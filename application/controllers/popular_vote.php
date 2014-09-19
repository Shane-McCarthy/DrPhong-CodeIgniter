<?php 
	
	class Popular_vote extends PHONG_WebController {
		
		
		function __construct() {
	
		parent::__construct();
		}
		
		function show($offset = 0) {
		
			$this->load->library('pagination');
			$config['base_url'] = '/#/popular_vote/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config); 
			
			$this->data['tracks'] = cTrack::findPopularVotes(intval($offset));
			$this->_render_page('popular_index');
			
		
		}
		
		
		
		
		
	}

/* End of file base.php */
/* Location: ./application/controllers/base.php */
?>