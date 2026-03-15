<?php

use Mindverse\Inc\Core\Hookable;

if( !defined( 'ABSPATH' ) )
	exit; 

class Mindverse_Admin_Templates extends Hookable{

	public function __construct() {
		$this->add_action( 'admin_menu', 'register_page', 20 );
	}
 
	public function register_page() {
		add_submenu_page(
			'pxlart',
		    esc_html__( 'Templates', 'mindverse' ),
		    esc_html__( 'Templates', 'mindverse' ),
		    'manage_options',
		    'edit.php?post_type=pxl-template',
		    false
		);
	}
}
new Mindverse_Admin_Templates;
