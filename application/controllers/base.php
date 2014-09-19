<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Base extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/latest/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$this->pagination->initialize($config); 
			
			$this->data['tracks'] = cTrack::findLatest(0);
			
			$this->data['title'] = '| Dr Phong | New Music, Popular Songs and Remixes | Listen, Save to a Playlist and Vote |';
			$this->data['keywords'] = 'top latest songs, latest music releases, songs new, new songs, latest songs, latest song, music blog aggregator, music blog aggregator, music blog';
			$this->data['description'] = 'People blog the latest music, artists and DJÕs. Listeners discover new music and vote to make it popular. Listen to music for free, save playlists and share them with your friends.';
			
			$this->_render_page('latest_show');
			
		}
		
	}

/* End of file latest.php */
/* Location: ./application/controllers/latest.php */