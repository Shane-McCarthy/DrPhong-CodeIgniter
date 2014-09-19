<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Tags extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function view($tag, $offset = 0) {
            
            $dbtag = cTag::getByName(urldecode($tag));
			if (!$dbtag) {
				$dbtag = new cTag();
				$dbtag->tag_name = urldecode($tag);
			}
			
			$this->data['tag'] = $dbtag;
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/tags/'.$tag.'/';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config);
			
			$this->data['tracks'] = cTrack::findByTag($dbtag->id, intval($offset));
            $this->_render_page('tags_view');
            
		}
		
	}

/* End of file base.php */
/* Location: ./application/controllers/base.php */