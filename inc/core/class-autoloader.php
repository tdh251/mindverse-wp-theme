<?php
namespace Mindverse\Inc\Core;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Autoloader {

    public function __construct() {
        spl_autoload_register( array( $this, 'load_class' ) );
    }

    public function load_class( $class_name ) {
        if ( strpos( $class_name, 'Mindverse\\Inc\\' ) !== 0 ) {
            return;
        }

        $relative_class = substr( $class_name, strlen( 'Mindverse\\Inc\\' ) );
        
        $parts = explode( '\\', $relative_class );

        $file_class_name = array_pop( $parts );

        $file_name = 'class-' . str_replace( '_', '-', strtolower( $file_class_name ) ) . '.php';
        
        $path_parts = array_map( 'strtolower', $parts );
        
        $path = get_template_directory() . '/inc/' . implode( '/', $path_parts ) . '/' . $file_name;
        
        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }
    
}