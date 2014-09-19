<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class View extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function artist($artist) {
			$this->data['artist'] = urldecode($artist);
			$this->_render_page('view_artist');
		}
		
		function track($artist, $track_id, $track) {
			$this->data['track'] = cTrack::findByTrackId($track_id);
			$this->_render_page('view_track');
		}
		
	}

/* End of file view.php */
/* Location: ./application/controllers/view.php */