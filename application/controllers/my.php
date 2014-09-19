<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class My extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function show($offset = 0) {
			
			if (!$this->_requireLoggedInUser()) return;
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/my/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
			
		
			
			$this->data['tracks'] = cTrack::findMyMusic($this->logged_in_user->id, intval($offset));
			
	
			
			$this->_render_page('my_index');
			
		}
		
	}

/* End of file about.php */
/* Location: ./application/controllers/about.php */