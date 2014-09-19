<?php

    abstract class cSkeleton implements iErrorReporter, iDeleteable, iSaveable {
        
        
        protected $queue;
        
        protected $error;
        
        
        /**
         *
         */
        function __construct($id = 0) {
            
            if ($id > 0) {
                $this->loadById($id);
            } else {
                $this->id = $id;
            }
            
        }
        
        /**
         * Copy variables from one object into this class
         */
        function __apply($data) {
            if (is_object($data)) {
                foreach($data as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
        
        /**
         * Apply Values of one class in to the target class
         */
        static function __applyNew($class_name, $data) {
            
            if (is_array($data)) {
                
                $items = new cCollection($class_name);
                foreach ($data as $key => $item) {
                    $items->add(self::__applyNew($class_name, $item));
                }
                return $items;
                
            } else {
                
                $target = new $class_name();
                foreach($data as $key => $value) {
                    $target->$key = $value;
                }
                return $target;
                
            }
            
        }
        
        /**
         *
         */
        static function __applyFactory($field, $base_type, $targets, $data) {
            
            if (is_array($data)) {
                
                $items = new cCollection($base_type);
                foreach($data as $key => $value) {
                    $items->add(self::__applyFactory($field, $base_type, $targets, $value));
                }
                return $items;
                
            } else {
                
                if (isset($data->{$field})) {
                    $factory_target = $targets[$data->{$field}];
                    return self::__applyNew($factory_target, $data);
                }
                
            }
            
        }
        
        /**
         *
         */
        static function __applyFromXml($class_name, $system_id, $xml) {
            
            // If we are passed a string parse it otherwise use the passed object
            //
            if (!is_object($xml)) {
                if (!$xmldoc = simplexml_load_string($xml)) {
                    return false;
                }
            } else {
                $xmldoc = $xml;
            }
            
            $reference_object = new $class_name();
            
            $items = array();
            foreach($xmldoc as $xmlitem) {
                $new_item = new $class_name();
                $new_item->system_id = $system_id;
                foreach ($xmlitem as $xmlkey => $xmlvalue) {
                    foreach ($reference_object->getSerializationAttributes() as $attrkey => $attrvalue) {
                        if (strtolower($xmlkey) == strtolower($attrvalue[0])) {
                            switch ($attrvalue[1]) {
                                case 'string':
                                    $new_item->{$attrkey} = (string) $xmlvalue;
                                    break;
                                case 'integer';
                                    $new_item->{$attrkey} = (integer) $xmlvalue;
                                    break;
                                default:
                                    $new_item->addQueue(self::__applyFromXml($attrvalue[1], $system_id, $xmlvalue));
                                    break;
                            }
                        }
                    }
                }
                $new_item->save();
                $items[] = $new_item;
            }
            
            foreach ($items as $item) {
                $item->save();
            }
            
            return $items;
            
        }
        
        /**
         *
         */
        static function __datetimeAsMysql($date = NULL) {
            if (empty($date)) $date = strtotime("now");
            return date("Y-m-d H:i:s", $date);
        }
        
        /**
         *
         */
        static function __emptyMySQLDateTime() {
            return '0000-00-00 00:00:00';
        }
        
        /**
         *
         */
        public function addQueue($object) {
            if (!$this->queue) {
                $this->queue = array();
            }
            if (is_array($object)) {
                foreach($object as $item) {
                    $this->addQueue($item);
                }
            } else {
                $this->queue[] = $object;
            }
        }
        
        
        /**
         *
         */
        function loadById($id) {
            
            $CI = get_instance();
            $result = null;
            
            // Fetch from Cache if implemented
            if ($this instanceof iCacheProvider) {
                $result = $this->getCache($id);
            }
            
            if (!$result) {
                
                // Fetch from database
                $dataResult = $CI->db->get_where($this->getTableName(), array('id' => $id));
                $result = $dataResult->row();
                
                // Save to Cache if implemented
                if ($this instanceof iCacheProvider) {
                    $this->setCache($id, $result);
                }
                
            }
            
            $this->__apply($result);
            
        }
        
        /**
         *
         */
        function toArray() {
            return cSkeletonUtility::getObjectAsArray($this);
        }
        
        /**
         *
         */
        function getKeysAsArray() {
            return cSkeletonUtility::getPublicVars($this);
        }
        
        /**
         * @return Boolean A Boolean value as to whether this item exists in the database
         */
        public function exists() {
            return !empty($this->id);
        }
        
        /**
         *
         */
        public function save() {
            
            try {
                
                $CI = get_instance();
                
                $this->modified = self::__datetimeAsMysql();
                if ($this->id == 0) {
                    $this->created = self::__datetimeAsMysql();
                }
                
                $data = $this->toArray();
                
                if ($this->id == 0) {
                    
                    $CI->db->insert($this->getTableName(), $data);
                    $this->id = $CI->db->insert_id();
                    
                } else {
                    
                    $CI->db->where('id', $this->id);
                    $CI->db->update($this->getTableName(), $data);
                    
                }
                
                //echo $CI->db->last_query() . "\n\n";
                
                return true;
                
            } catch (Exception $e) {
                
                $this->notifyException($e);
                return false;
                
            }
            
        }
        
        /**
         *
         */
        function delete() {
            
            try {
                
                $CI = get_instance();
                $CI->db->delete($this->getTableName(), array('id' => $this->id));
                
                return true;
                
            } catch (Exception $e) {
                
                $this->notifyException($e);
                return false;
                
            }
            
        }
        
        /**
         * @deprecated Use cSkeletonUtility::notifyException($e) instead
         */
        function notifyException($e) {
            cSkeletonUtility::notifyException($e);
        }
        
        /**
         * iErrorReporter
         */
        public function getError() {
            return $this->error;
        }
        
        /**
         * iErrorReporter
         */
        public function setError($message) {
            $this->error = $message;
        }
        
        
    }
    
    class cSkeletonUtility {
        
        /**
         *
         */
        public static function getObjectAsArray($obj) {
            
            $transform = array();
            if ($obj instanceof iApiSerializable) {
                $transform = $obj->getSerializationAttributes();
            }
            $transform['system_id'] = array('SystemId', 'integer');
            $transform['id'] = array('Id', 'integer');
            
            $return = array();
            foreach ($obj as $key => $value) {
                if (array_key_exists($key, $transform)) {
                    switch ($transform[$key][1]) {
                        case 'int':
                        case 'integer':
                            $return[$key] = (int) $value;
                            break;
                        case 'bool':
                        case 'boolean':
                            $return[$key] = (bool) $value;
                            break;
                        case 'string':
                        default:
                            $return[$key] = (string) $value;
                            break;
                    }
                } else {
                    $return[$key] = (string) $value;
                }
            }
            return $return;
        }
        
        /**
         *
         */
        public static function getPublicVars($obj) {
            $return = array();
            foreach ($obj as $key => $value) {
                $return[] = $key;
            }
            return $return;
        }
        
        /**
         *
         */
        public static function getRealType($val) {
            if (is_numeric($val)) {
                if (ctype_digit($val)) {
                    return intval($val);
                } else {
                    return floatval($val);
                }
            }
            return $val;
        }
        
        /**
         *
         */
        public static function getSkeletonVarType($attrs, $name, $val) {
            if (array_key_exists($name, $attrs)) {
                switch ($attrs[$name][1]) {
                    case 'str':
                    case 'string':
                        return (string) $val;
                        break;
                    case 'int':
                    case 'integer':
                        if (ctype_digit($val)) {
                            return intval($val);
                        } else {
                            return floatval($val);
                        }
                        break;
                    case 'bool':
                    case 'boolean':
                        return (bool) $val;
                        break;
                    
                }
            }
        }
        
        /**
         *
         */
        public static function toStdClass($array) {
            $n = new stdClass();
            foreach ($array as $key => $value) {
                $n->{$key} = $value;
            }
            return $n;
        }
        
        /**
         *
         */
        public static function serializeToArray($object) {
            
            if (is_array($object) || @get_class($object) == 'cCollection') {
                
                $return = array();
                foreach ($object as $o) {
                    $return[] = cSkeletonUtility::serializeToArray($o);
                }
                return $return;
                
            } else {
                
                $return = array();
                if (method_exists($object, 'getSerializationAttributes')) {
                    foreach ($object->getSerializationAttributes() as $key => $value) {
                        
                        // Node Names as Results of Functions
                        $node_name = $value[0];
                        if (substr($node_name,0, 1) == ':') {
                            $func = substr($node_name, 1);
                            $node_name = $object->{$func}();
                        }
                        
                        // Node Values as Results of Functions
                        if (substr($key,0, 1) == ':') {
                            $func = substr($key, 1);
                            $return[$node_name] = cSkeletonUtility::serializeToArray($object->{$func}());
                        } else {
                            $return[$node_name] = $object->{$key};
                        }
                        
                    }
                } else {
                    return $object;
                }
                return (!empty($return)) ? $return : null;
                
            }
            
        }
        
        /**
         *
         */
        function generateRandomString($length = 10, $chars = 'ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789') {
            
            try {
                
                $chars_length = (strlen($chars) - 1);
                $string = $chars{rand(0, $chars_length)};
                
                for ($i = 1; $i < $length; $i = strlen($string)) {
                    $r = $chars{rand(0, $chars_length)};
                    if ($r != $string{$i - 1}) $string .=  $r;
                }
                
                return $string;
                
            } catch (Exception $e) {
                
                cSkeletonUtility::notifyException($e);
                return false;
                
            }
            
        }
        
        /**
         *
         */
        public static function notifyException($e) {
            cAppLog::LogFromException($e);
        }
        
        /**
         *
         */
        public static function stringProxy($string, $check) {
            if ($check) {
                return $string;
            }
        }
        
        /**
         *
         */
        function startsWith($haystack,$needle,$case=true) {
            if($case){return (strcmp(substr($haystack, 0, strlen($needle)),$needle)===0);}
            return (strcasecmp(substr($haystack, 0, strlen($needle)),$needle)===0);
        }
        
        /**
         *
         */
        function endsWith($haystack,$needle,$case=true) {
            if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
            return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
        }
        
        /**
         * @return bool
         */
        static function isUrl($url){
            return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
        }
        
    }
