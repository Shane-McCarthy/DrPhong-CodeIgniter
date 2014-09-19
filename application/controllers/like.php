<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Like extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function track($track_id) {
			
			cTrack::like($track_id, $this->logged_in_user->id);
			
			echo json_encode(array(
				'Status' => 'ok'
			));
		}
		
	}

/* End of file like.php */
/* Location: ./application/controllers/like.php */