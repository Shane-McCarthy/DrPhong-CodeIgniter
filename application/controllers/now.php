<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Now extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$this->_render_page('now_index');
		}
		
	}

/* End of file now.php */
/* Location: ./application/controllers/now.php */