<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Artistsect extends PHONG_WebController {
        
        function __construct() {
            parent::__construct();
        }
          function index() {
              $this-> load-> model ("model_get"); 
              $data["results"]= $this -> model_get-> getData ("truly"); 
              
            $this->load-> view('artist_section', $data);
        }
        
    }