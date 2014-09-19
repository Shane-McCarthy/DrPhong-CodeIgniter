<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Legal extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function privacy() {
			$this->_render_page('legal_privacy');
		}
		
		function terms() {
			$this->_render_page('legal_terms');
		}
		
	}

/* End of file about.php */
/* Location: ./application/controllers/about.php */