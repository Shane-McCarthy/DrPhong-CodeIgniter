<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Blogs extends PHONG_WebController {
		
		function __construct() {
			parent::__construct();
		}
		
		/**
		 *
		 */
		function show($offset = 0) {
			
			$this->load->library('pagination');
			$config['base_url'] = '/#/blogs';
			$config['total_rows'] = '1000';
			$config['per_page'] = '20';
			$config['uri_segment'] = 2;
			$this->pagination->initialize($config); 
			
			$this->data['blogs'] = cBlog::findAll(intval($offset), 20);
			$this->_render_page('blogs_index');
		}
		
		function add() {
			
            // Load required Helpers/Libraries/Plugins
            $this->load->library('form_validation');
            
            if ($this->_is_postback()) {
                
				$this->form_validation->set_rules('name', 'Name', 'required|min_length[2]|max_length[45]');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
				$this->form_validation->set_rules('url', 'URL', 'required|min_length[2]|max_length[45]');
				$this->form_validation->set_rules('feed_url', 'Feed URL', 'required|min_length[2]|max_length[45]');
				
                // Run Validator and Setup View
                if ($this->form_validation->run() == FALSE) {
                    
                    $errors = array();
					$this->form_validation->set_error_delimiters('', '');
                    if ($this->form_validation->error('name')) $this->data['errors'][] = $this->form_validation->error('name');
                    if ($this->form_validation->error('email')) $this->data['errors'][] = $this->form_validation->error('email');
                    if ($this->form_validation->error('url')) $this->data['errors'][] = $this->form_validation->error('url');
                    if ($this->form_validation->error('feed_url')) $this->data['errors'][] = $this->form_validation->error('feed_url');
                    
					if (strtolower($this->input->post('captcha')) !== strtolower($this->session->userdata('lastword'))) {
						$this->data['errors'][] = 'The captcha is incorrect: '.$this->session->userdata('lastword');
					}
					
					echo json_encode(array('Action' => 'error', 'Errors' => $this->data['errors']));
					return;
					
                } else {
                    
					if (strtolower($this->input->post('captcha')) !== strtolower($this->session->userdata('lastword'))) {
						echo json_encode(array('Action' => 'error', 'Errors' => array('The captcha is incorrect')));
						return;
					}
					
                    $blog = new cBlog();
					$blog->approved = false;
					$blog->name = $this->input->post('name');
					$blog->url = $this->input->post('url');
					$blog->feed_url = $this->input->post('feed_url');
					$blog->owner = $this->input->post('email');
					$blog->save();
					
					echo json_encode(array('Action' => 'success', 'Message' => 'Your URL has been submitted for review. You will receive a notification by email upon approval. Thanks!'));
					return;	
                        
                }
                
            }
            
		}
		
	}

/* End of file about.php */
/* Location: ./application/controllers/about.php */