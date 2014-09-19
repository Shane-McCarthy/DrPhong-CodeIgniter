<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Latest extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function show($offset = 0) {
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/latest/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config); 
			
			$this->data['tracks'] = cTrack::findLatest(intval($offset));
			$this->_render_page('latest_show');
			
		}
		
	}

/* End of file latest.php */
/* Location: ./application/controllers/latest.php */