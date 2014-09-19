<?php 
	
	class Suggested extends PHONG_WebController {
		
		
		function __construct() {
	
		parent::__construct();
		}
		
		function show($offset = 0) {  
		
			$this->load->library('pagination');
			$config['base_url'] = '/#/suggested/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config); 
			
			$this->data['tracks'] = cTrack::findSuggested($this->logged_in_user->id,intval($offset));
			$this->_render_page('suggested_index');
			
		
		}
		
		
		
		
		
	}

/* End of file base.php */
/* Location: ./application/controllers/base.php */
?>