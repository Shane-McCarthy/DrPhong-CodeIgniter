<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Contact extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			$this->_render_page('contact_index');
		}
		
	}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */