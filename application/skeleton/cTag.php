<?php
    
    /**
     * Skeleton Class for Blogs
     */
    class cTag extends cSkeleton implements iSaveable {
        
        
        protected static $TABLE_NAME = 'tags';
        
        protected static $SERIALIZATION = array(
            'id' =>                     array('Id', 'string'),
            'name' =>                   array('Name', 'string'),
        );
        
        protected static $OBJECT_NAME = 'Tag';
        
        
        public $id = 0;
        
        public $tag_name = '';
        
        public $soundex = '';
        
        public $created = '';
        
        public $modified = '';
        
        
        protected static function getTableName() {
            return self::$TABLE_NAME;
        }
        
        public static function getSerializationAttributes() {
            return self::$SERIALIZATION;
        }
        
        public static function getObjectName() {
            return self::$OBJECT_NAME;
        }
        
        
        /**
         * 
         */
        static function getAll() {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::$TABLE_NAME);
            $result = $CI->db->get();
            
            return cSkeleton::__applyNew('cTag', $result->result());
            
        }
        
        /**
         *
         */
        static function getBySoundex($soundex) {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::$TABLE_NAME);
            $CI->db->where('soundex', $soundex);
            $result = $CI->db->get();
            
            if (sizeof($result->result())) {
                return cSkeleton::__applyNew('cTag', $result->row());
            }
            
            return null;
            
        }
        
        /**
         *
         */
        static function getByTag($tag_name) {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::$TABLE_NAME);
            $CI->db->where('tag_name', $tag_name);
            $result = $CI->db->get();
            
            if (sizeof($result->result())) {
                return cSkeleton::__applyNew('cTag', $result->row());
            }
            
            return null;
            
        }
        
        /**
         *
         */
        static function getByPost($post_id) {
            
            $CI = get_instance();
            
            $CI->db->select('tags.*');
            $CI->db->from(self::$TABLE_NAME);
            $CI->db->join('blog_post_tags', 'tags.id = blog_post_tags.tag_id');
            $CI->db->where('blog_post_tags.post_id', $post_id);
            $result = $CI->db->get();
            
            return cSkeleton::__applyNew('cTag', $result->result());
        
        }
        
        /**
         *
         */
        static function getByTrack($track_id) {
            
            $CI = get_instance();
            
            $CI->db->select('tags.*');
            $CI->db->from(self::$TABLE_NAME);
            $CI->db->join('track_tags', 'tags.id = track_tags.tag_id');
            $CI->db->where('track_tags.track_id', $track_id);
            $result = $CI->db->get();
            
            return cSkeleton::__applyNew('cTag', $result->result());
        
        }
        
        /**
         *
         */
        static function getByName($tag_name) {
            
            $CI = get_instance();
            
            $CI->db->select('tags.*');
            $CI->db->from(self::$TABLE_NAME);
            $CI->db->join('track_tags', 'tags.id = track_tags.tag_id');
            $CI->db->where('tags.tag_name', $tag_name);
            $result = $CI->db->get();
            
            if ($result->row()) {
                return cSkeleton::__applyNew('cTag', $result->row());
            }
            
            return null;
        
        }
        
    }
