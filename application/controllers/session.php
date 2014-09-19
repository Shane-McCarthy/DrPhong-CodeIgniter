<?php

/**
 * @author		Paul Trippett (paul@pyhub.com)
 * @copyright	Copyright (c) 2010 pyHub Limited.
 */

	class Session extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
        
        /**
         *
         */
		function index() {
			$this->login();
		}
        
        /**
         *
         */
        function login() {
            
            // Load required Helpers/Libraries/Plugins
            $this->load->library('form_validation');
            
            if ($this->_is_postback()) {
                
				$this->form_validation->set_rules('username', 'Username', 'required|min_length[2]|max_length[45]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[45]');
				
                // Run Validator and Setup View
                if ($this->form_validation->run() == FALSE) {
                    
                    $errors = array();
					$this->form_validation->set_error_delimiters('', '');
                    if ($this->form_validation->error('username')) $this->data['errors'][] = $this->form_validation->error('username');
                    if ($this->form_validation->error('password')) $this->data['errors'][] = $this->form_validation->error('password');
                    
					echo json_encode(array('Action' => 'error', 'Errors' => $this->data['errors']));
					return;
					
                } else {
                    
                    $user = cUser::getByUsernamePassword($this->input->post('username'), md5($this->input->post('password')));
                    if ( $user && !empty($user->id) ) {
                        
						$user->last_seen = cSkeleton::__datetimeAsMysql();
						$user->last_login = cSkeleton::__datetimeAsMysql();
						$user->save();
						
                        // Create a fresh session
                        $this->session->set_userdata($user);
                        $this->session->set_userdata(array('logged_in' => true));
                        
						echo json_encode(array('Action' => 'login', 'Location' => '/', 'Username' => $this->input->post('username'), 'Admin' => $user->admin));
						return;
                        
                    } else {
                        
						echo json_encode(array('Action' => 'error', 'Errors' => array('Either your Username or Password was incorrect.')));
						return;
                        
                    }
                    
                }
                
            }
            
            $this->_render_page('session_login');
            
        }
        
        /**
         *
         */
        function logout() {
            
            $this->session->sess_destroy();
            
            delete_cookie('phongu');
            delete_cookie('phongp');
            
            redirect('/');
            
        }
        
		/**
		 *
		 */
		function signup() {
			
            // Load required Helpers/Libraries/Plugins
            $this->load->library('form_validation');
            
            if ($this->_is_postback()) {
                
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('username', 'Username', 'required|min_length[2]|max_length[45]');
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[45]');
				
                // Run Validator and Setup View
                if ($this->form_validation->run() == FALSE) {
                    
                    $errors = array();
					$this->form_validation->set_error_delimiters('', '');
                    if ($this->form_validation->error('email')) $this->data['errors'][] = $this->form_validation->error('email');
                    if ($this->form_validation->error('username')) $this->data['errors'][] = $this->form_validation->error('username');
                    if ($this->form_validation->error('password')) $this->data['errors'][] = $this->form_validation->error('password');
                    
					echo json_encode(array('Action' => 'error', 'Errors' => $this->data['errors']));
					return;
					
                } else {
                    
                    $user = new cUser();
					$user->email = $this->input->post('email');
					$user->username = $this->input->post('username');
					$user->password = md5($this->input->post('password'));
					$user->last_seen = cSkeleton::__datetimeAsMysql();
					$user->last_login = cSkeleton::__datetimeAsMysql();
					$user->save();
					
					// Create a fresh session
					$this->session->set_userdata($user);
					$this->session->set_userdata(array('logged_in' => true));
					
					// Redirect to main site
					//
					if (!empty($_GET['return_to'])) {
						echo json_encode(array('Action' => 'login', 'Location' => $_GET['return_to'], 'Username' => $this->input->post('username'), 'Admin' => false));
						return;	
					} else {
						echo json_encode(array('Action' => 'login', 'Location' => '/', 'Username' => $this->input->post('username'), 'Admin' => false));
						return;
					}
                        
                }
                
            }
            
            $this->_render_page('session_signup');
            
		}
		
	}

