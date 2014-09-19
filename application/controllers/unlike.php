<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Unlike extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function track($track_id) {
			
			cTrack::unlike($track_id, $this->logged_in_user->id);
			
			echo json_encode(array(
				'Status' => 'ok'
			));
			
		}
		
	}

/* End of file unlike.php */
/* Location: ./application/controllers/unlike.php */