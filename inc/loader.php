<?php
/**
 * Theme Loader
 *
 * @package Mindverse
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

require_once __DIR__ . '/core/class-autoloader.php';
new \Mindverse\Inc\Core\Autoloader();


function mindverse() {
	return \Mindverse\Inc\Core\Mindverse::instance();
}

mindverse();

if( ! function_exists( 'pxl_action' ) ) :
	function pxl_action() {

		$args   = func_get_args();

		if( !isset( $args[0] ) || empty( $args[0] ) ) {
			return;
		}

		$action = 'pxltheme_' . $args[0];
		unset( $args[0] );

		do_action_ref_array( $action, $args );
	}
    pxl_action( 'init' );
endif;