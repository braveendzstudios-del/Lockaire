<?php

class lkar_autoloader{
    public function __construct() {
        spl_autoload_register( array( $this, 'autoload' ) );
    }

    public function autoload( $class_name ) {
         
        $base = plugin_dir_path(__DIR__); // go one level up (plugin root)

        $paths = [
            $base. $class_name . '.php',
            $base . 'Includes/' . $class_name . '.php',
            $base . 'Includes/Integration/' . $class_name . '.php',
            $base . 'Template/' . $class_name . '.php',  
            $base . 'Template/admin/' . $class_name . '.php',
            
        ];

        foreach ( $paths as $file ) {
            if ( file_exists( $file ) ) {
                require_once $file;
                return;
            }
           
        }



       
    }
}