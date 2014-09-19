<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Artistsect extends PHONG_WebController {
        
        function __construct() {
            parent::__construct();
        }
          function index() {
            $this->_render_page('artist_section');
        }
        
    }