<?php
    
    /**
     * Skeleton Class for Blogs
     */
    class cBlogPost extends cSkeleton implements iSaveable {
        
        
        protected static $TABLE_NAME = 'blog_posts';
        
        protected static $SERIALIZATION = array(
            'id' =>                     array('Id', 'string'),
            'name' =>                   array('Name', 'string'),
        );
        
        protected static $OBJECT_NAME = 'BlogPost';
        
        
        public $id = 0;
        
        public $track_id = 0;
        
        public $title = '';
        
        public $summary = '';
        
        public $url = '';
        
        public $media_url = '';
        
        public $posted = '';
        
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
            
            return cSkeleton::__applyNew('cBlogPost', $result->result());
            
        }
        
        /**
         *
         */
        function assignTag($tag_id) {
            $sql = "
                INSERT IGNORE INTO blog_post_tags (post_id, tag_id) VALUES (?, ?);
            ";
            $CI = get_instance();
            $result = $CI->db->query($sql, array($this->id, $tag_id));
            return true;
        }

		function getByUrl($url){
			
			$CI = get_instance();
			
			$sql = "SELECT * FROM blog_posts WHERE url LIKE '%" . $url . "%' LIMIT 0 , 30";

	        $CI->db->select('*');
	        $CI->db->from(self::$TABLE_NAME);
	        $CI->db->like('url', $url);
	        $result = $CI->db->get();

	        return cSkeleton::__applyNew('cBlogPost', $result->result());
			
		}
        
    }
