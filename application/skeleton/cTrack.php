<?php

/**
 * Skeleton Class for Blogs
 */
class cTrack extends cSkeleton implements iSaveable {

    protected static $TABLE_NAME = 'tracks';
    protected static $SERIALIZATION = array(
        'id' => array('Id', 'string'),
        'name' => array('Name', 'string'),
    );
    protected static $OBJECT_NAME = 'Track';
    public $id = 0;
    public $artist = '';
    public $track = '';
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
    static function getByIdMulti($user_ids, $sort = 'name', $sort_direction = 'ASC') {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::getTableName());
        $CI->db->where_in('id', $user_ids);
        $CI->db->order_by($sort, $sort_direction);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cTrack', $result->result());
    }

    /**
     * 
     */
    static function getAll() {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::$TABLE_NAME);
        $result = $CI->db->get();

        return cSkeleton::__applyNew('cTrack', $result->result());
    }

    /**
     *
     */
    static function getByArtistTrack($artist, $track) {

        $CI = get_instance();

        $CI->db->select('*');
        $CI->db->from(self::getTableName());
        $CI->db->where('artist', $artist);
        $CI->db->where('track', $track);
        $result = $CI->db->get();

        if ($result->result()) {
            return cSkeleton::__applyNew('cTrack', $result->row());
        }

        return null;
    }

    /**
     *
     */
    static function findByArtistFuzzy($artist, $offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                WHERE `tracks`.`artist` LIKE '%$artist%'
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array(intval($offset), intval($limit)));
        return $query->result();
    }

    /**
     *
     */
    static function findByTrackId($track_id) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                WHERE `tracks`.`id` = ?
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($track_id));
        return $query->row();
    }

    /**
     *
     */
    static function findByTrackFuzzy($track, $offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                WHERE `tracks`.`track` LIKE '%$track%'
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array(intval($offset), intval($limit)));
        return $query->result();
    }

    /**
     *
     */
    static function findLatest($offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($offset, $limit));
        return $query->result();
    }

    /**
     *
     */
    static function findPromoted($blogId = 394, $offset = 0, $limit = 30) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                WHERE `blog_posts`.`blog_id` = ".$blogId."
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT 0, 10
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($offset, $limit));
        
        $results = $query->result();
        
        shuffle($results);
        
        $result = array_slice($results, 0, 3);
        
        return $result;
    }

    /**
     *
     */
    static function findPopular($offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                WHERE
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) > 0 AND
                    DATEDIFF(NOW(), `tracks`.`created`) > ?
                GROUP BY `blog_posts`.`track_id`
            ORDER BY RAND()
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array(30, $offset, $limit));
        return $query->result();
    }

    static function findPopularDate($offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                WHERE
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) > 0 AND
                    DATEDIFF(NOW(), `tracks`.`created`) > ?
                GROUP BY `blog_posts`.`track_id`
            ORDER BY `blog_posts`.`date_voted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array(30, $offset, $limit));
        return $query->result();
    }

    static function findPopularVotes($offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                WHERE
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) > 0 AND
                    DATEDIFF(NOW(), `tracks`.`created`) > ?
                GROUP BY `blog_posts`.`track_id`
            
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array(30, $offset, $limit));
        return $query->result();
    }

    /**
     *
     */
    static function findByTag($tag_id, $offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                WHERE
                    `track_tags`.`tag_id` = ?
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($tag_id, $offset, $limit));
        return $query->result();
    }

    /**
     *
     */
    static function findByBlog($blog_id, $offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                WHERE
                    `blog_posts`.`blog_id` = ?
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($blog_id, $offset, $limit));
        return $query->result();
    }

    /**
     *
     */
    static function findMyMusic($user_id, $offset = 0, $limit = 20) {

        $sql = "
                SELECT 
                    `blog_posts`.`id`,
                    `tracks`.`id` as `track_id`,
                    `tracks`.`artist`,
                    `tracks`.`track`,
                    (select COUNT(*) FROM `track_likes` WHERE `track_id` = `tracks`.`id`) as `likes`,
                    (select COUNT(*) FROM `track_dislikes` WHERE `track_id` = `tracks`.`id`) as `dislikes`,
                    COUNT(*) as `times_posted`,
                    `blogs`.`id` as `blog_id`,
                    `blogs`.`name` as `blog_name`,
                    `blog_posts`.`title`,
                    `blog_posts`.`summary`,
                    `blog_posts`.`url`,
                    `blog_posts`.`media_url`,
                    `blog_posts`.`posted`,
                    `blog_posts`.`created`,
                    `blog_posts`.`modified`
                FROM `blog_posts`
                LEFT JOIN `tracks` ON `blog_posts`.`track_id` = `tracks`.`id`
                LEFT JOIN `blogs` ON `blog_posts`.`blog_id` = `blogs`.`id`
                LEFT JOIN `track_tags` ON `tracks`.`id` = `track_tags`.`track_id`
                LEFT JOIN `track_likes` ON `tracks`.`id` = `track_likes`.`track_id`
                WHERE
                    `track_likes`.`user_id` = ?
                GROUP BY `blog_posts`.`track_id`
                ORDER BY `blog_posts`.`posted` DESC
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($user_id, $offset, $limit));
        return $query->result();
    }

    static function findSuggested($user_id, $offset = 0, $limit = 20) {

        $sql = "
                SELECT
					track_likes.track_id,
					track_likes.user_id,
                   users.username,
				   users.id,
				   tracks.track
					FROM track_likes
					LEFT JOIN users ON track_likes.user_id = users.id
					LEFT JOIN tracks ON track_likes.track_id = tracks.id
					WHERE track_likes.user_id = ?
            
           
                LIMIT ?, ?;
            ";

        $CI = get_instance();

        $query = $CI->db->query($sql, array($user_id, $offset, $limit));
        return $query->result();
    }

    /**
     *
     */
    static function findMyMusicCount($user_id) {

        $CI = get_instance();

        $CI->db->where('user_id', $user_id);
        $CI->db->from('track_likes');

        return $CI->db->count_all_results();
    }

    /**
     *
     */
    function assignTag($tag_id) {
        $sql = "
                INSERT IGNORE INTO track_tags (track_id, tag_id) VALUES (?, ?);
            ";
        $CI = get_instance();
        $result = $CI->db->query($sql, array($this->id, $tag_id));
        return true;
    }

    /**
     *
     */
    static function like($track_id, $user_id) {
        $time = time();
        $sql = "
                INSERT IGNORE INTO track_likes (track_id, user_id) VALUES (?, ?);
            ";

        $CI = get_instance();
        $result = $CI->db->query($sql, array($track_id, $user_id));

        $sql2 = "
			 UPDATE blog_posts SET date_voted=$time WHERE track_id=$track_id;
			";


        $CI2 = get_instance();
        $result2 = $CI2->db->query($sql2, array($track_id, $user_id));
        return true;
    }

    /**
     *
     */
    static function unlike($track_id, $user_id) {
        $time = time();
        $sql = "
                INSERT IGNORE INTO track_dislikes (track_id, user_id) VALUES (?, ?);
            ";
        $CI = get_instance();
        $result = $CI->db->query($sql, array($track_id, $user_id));

        $sql2 = "
			 UPDATE tracks SET date_voted=$time WHERE id=$track_id;
			";
        $CI2 = get_instance();
        $result2 = $CI2->db->query($sql2, array($track_id, $user_id));

        return true;
    }

}
