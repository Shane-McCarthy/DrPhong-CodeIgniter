<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Users extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		function index() {
			
			if (!$this->_requireAdminUser()) return;
			
            $this->data['users'] = cUser::getAll();
			$this->_render_page('admin_users_index');
			
		}
        
        function edit($id) {
			
			if (!$this->_requireAdminUser()) return;
			
            $user = new cUser($id);
            
            if ($this->_is_postback()) {
                
                $user->email = $this->input->post('email');
                $user->username = $this->input->post('username');
                if ($this->input->post('password')) $user->password = md5($this->input->post('password'));
                
                $user->save();
                
                echo json_encode(array('Action' => 'save', 'Location' => '/admin/users'));
                return;
                
            }
            
            $this->data['user'] = $user;
			$this->_render_page('admin_users_edit');
            
        }
		
		function delete($id) {
			
			if (!$this->_requireAdminUser()) return;
			
            $user = new cUser($id);
            $user->delete();
			
			redirect('/phongalator/users');
			
		}
		
	}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */