<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Artists extends PHONG_WebController {
        
        function __construct() {
            parent::__construct();
        }
        
        function index() {
            $this->_render_page('artists_index');
        }
        
    }

/* End of file about.php */
/* Location: ./application/controllers/about.php */