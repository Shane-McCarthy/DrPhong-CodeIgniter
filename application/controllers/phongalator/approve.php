<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Approve extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			
			if (!$this->_requireAdminUser()) return;
			
            $this->data['feeds'] = cBlog::getAllUnapproved();
			$this->_render_page('admin_approve_index');
			
		}
        
		function add() {
			$this->edit(0);
		}
		
        function edit($id) {
			
			if (!$this->_requireAdminUser()) return;
			
            $feed = new cBlog($id);
            
            if ($this->_is_postback()) {
                
                $feed->name = $this->input->post('name');
                $feed->description = $this->input->post('description');
                $feed->url = $this->input->post('url');
                $feed->feed_url = $this->input->post('feed_url');
                
                $feed->save();
                
                redirect('/phongalator/feeds/');
                return;
                
            }
            
            $this->data['feed'] = $feed;
			$this->_render_page('admin_feeds_edit');
            
        }
		
		function delete($id) {
			
			if (!$this->_requireAdminUser()) return;
			
            $feed = new cBlog($id);
			$feed->delete();
			
			redirect('/phongalator/feeds/');
			
		}
		
	}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */