<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Base extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			
			if (!$this->_requireAdminUser()) return;
			
			$this->_render_page('admin_index');
			
		}
		
	}

/* End of file base.php */
/* Location: ./application/controllers/base.php */