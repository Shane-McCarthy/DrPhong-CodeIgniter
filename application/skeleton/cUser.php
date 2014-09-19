<?php
    
    /**
     * Skeleton Class for Accounts
     */
    class cUser extends cSkeleton implements iSaveable, iDeleteable {
        
        
        protected static $TABLE_NAME = 'users';
        
        
        public $id = 0;
        
        public $admin = false;
        
        public $username = '';
        
        public $password = '';
        
        public $email = '';
        
        public $last_seen = '';
        
        public $last_login = '';
        
        public $created = '';
        
        public $modified = '';
        
        
        /**
         * iDbConnected
         */
        public static function getTableName() {
            return self::$TABLE_NAME;
        }
        
        /**
         *
         */
        static function getByIdMulti($user_ids, $sort = 'last_name', $sort_direction = 'ASC') {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::getTableName());
            $CI->db->where_in('id', $user_ids);
            $CI->db->order_by($sort, $sort_direction);
            $result = $CI->db->get();
            
            return cSkeleton::__applyNew('cUser', $result->result());
            
        }
        
        /**
         * 
         */
        static function getByUsernamePassword($username, $password) {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::getTableName());
            $CI->db->where('username', $username);
            $CI->db->where('password', $password);
            $result = $CI->db->get();
            
            return cUser::__applyNew('cUser', $result->row());
            
        }
        
        /**
         * 
         */
        static function getAll() {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from(self::$TABLE_NAME);
            $result = $CI->db->get();
            
            return cUser::__applyNew('cUser', $result->result());
            
        }
        
        
        /**
         *
         */
        function likesTrack($track_id) {
            
            $CI = get_instance();
            
            $CI->db->select('*');
            $CI->db->from('track_likes');
            $CI->db->where('track_id', $track_id);
            $CI->db->where('user_id', $this->id);
            $result = $CI->db->get();
            
            if (sizeof($result->result()) > 0) {
                return true;
            }
            
            return false;
            
        }
        
    }
