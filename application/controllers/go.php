<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Go extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
        /**
         *
         */
		function itunes($track_id) {
            
            $track = new cTrack($track_id);
            $term = urlencode($track->artist);
            
            $result = json_decode(file_get_contents("http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?term=$term&entity=musicArtist"));
			
			if (sizeof($result->results) > 0) {
	            $url = $result->results[0]->artistLinkUrl;
	            redirect("http://click.linksynergy.com/fs-bin/stat?id=o4ngYLh7WbA&offerid=146261&type=3&subid=0&tmpid=1826&RD_PARM1=$url%2526partnerId%253D30");
			} else {
				redirect("http://www.doctorphong.com/#/");
			}
            
		}
		
	}

/* End of file go.php */
/* Location: ./application/controllers/go.php */