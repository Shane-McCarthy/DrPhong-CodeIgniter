<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Artists_signup extends PHONG_WebController {
        
        function __construct() {
            parent::__construct();
        }
        
        function index() {
            $this->_render_page('artists_landing_page');
        }
        
    }

/* End of file about.php */
/* Location: ./application/controllers/about.php */