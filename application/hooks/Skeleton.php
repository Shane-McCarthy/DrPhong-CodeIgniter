<?php

    define('SKEL_DIR', APPPATH . 'skeleton');
    
    function as_setup_autoload() {
        
        // We need our interfaces whatever happens
        //
        require_once SKEL_DIR . '/cInterfaces.php';
        require_once SKEL_DIR . '/cExceptions.php';
        
    }
    
    function __autoload($class) {
        
        // We have Utility classes nested in the parent class file.
        //    e.g. cSkeletonUtility is in cSkeleton.php
        //
        if (strstr($class, 'Utility')) {
            $class = str_replace('Utility', '', $class);
        }
        
        // Load the class
        //
        if ((substr($class, 0, 7) != 'http://') && (substr($class, 0, 2) != 'CI') && (substr($class, 0, 2) != 'AS') && !stristr($class, 'PEAR')){
            if (file_exists(SKEL_DIR."/$class.php")) {
                require_once(SKEL_DIR."/$class.php");
            }
        }
        
    }