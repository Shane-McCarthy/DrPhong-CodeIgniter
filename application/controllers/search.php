<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Search extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function artist($keyword = '', $offset = 0) {
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/search/artist/'.$keyword.'/';
			$config['total_rows'] = 100; //cTrack::findMyMusicCount($this->logged_in_user->id);
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config); 
			
            $this->data['tracks'] = cTrack::findByArtistFuzzy(urldecode($keyword), $offset);
			
			$this->_render_page('search_index');
			
		}
		
		function track($keyword = '', $offset = 0) {
            
            $this->load->library('pagination');
            $config['base_url'] = '/#/search/track/'.$keyword.'/';
            $config['total_rows'] = 100; //cTrack::findMyMusicCount($this->logged_in_user->id);
            $config['per_page'] = '20';
            $config['uri_segment'] = 3;
            $this->pagination->initialize($config); 
            
            $this->data['tracks'] = cTrack::findByTrackFuzzy(urldecode($keyword), $offset);
            
            $this->_render_page('search_index');
            
        }
        function blog($keyword = '', $offset = 0) {
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/search/blog/'.$keyword.'/';
			$config['total_rows'] = 100; //cTrack::findMyMusicCount($this->logged_in_user->id);
			$config['per_page'] = '20';
			$config['uri_segment'] = 3;
			$this->pagination->initialize($config); 
			
            $this->data['tracks'] = cTrack::findByBlog(urldecode($keyword), $offset);
			
			$this->_render_page('search_index');
			
		}
		
	}

/* End of file about.php */
/* Location: ./application/controllers/about.php */