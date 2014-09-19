<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends PHONG_WebController {

    function __construct() {
        parent::__construct();
    }

    /**
     *
     */
    function parseAllFeeds() {
        set_time_limit(0);
        foreach (cBlog::getAllApproved() as $blog) {
            $blog->parseFeed();
            //break;
        }
    }

}

/* End of file cron.php */
/* Location: ./application/controllers/cron.php */