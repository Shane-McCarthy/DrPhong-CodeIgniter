<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Blog extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		/**
		 *
		 */
		function show($blog_id, $blog_name) {
			
			$blog = new cBlog($blog_id);
			
			$this->data['blog'] = $blog;
			$this->_render_page('blogs_view');
			
		}
		
	}

/* End of file about.php */
/* Location: ./application/controllers/about.php */