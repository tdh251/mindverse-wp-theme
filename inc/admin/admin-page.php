<?php
/**
* The Mindverse_Admin_Page base class
*/

use Mindverse\Inc\Core\Hookable;

if( !defined( 'ABSPATH' ) )
	exit; 


class Mindverse_Admin_Page extends Hookable {

    public $parent = null;

    public $capability = 'manage_options';

	public $icon = 'dashicons-art';
	
    public $position;
  
	public function __construct() {
 
		$priority = -1;
		if ( isset( $this->parent ) && $this->parent ) {
			$priority = intval( $this->position );
		}
		$this->position = 2;
  
		$this->add_action( 'admin_menu', 'register_page', $priority );
		 
		if( !isset( $_GET['page'] ) || empty( $_GET['page'] ) || ! $this->id === sanitize_text_field($_GET['page']) ) {
			return;
		}
 
	}

	public function register_page() {
 
		if( ! $this->parent ) {
			add_menu_page(
				$this->page_title,
				$this->menu_title,
				$this->capability,
				$this->id,
				array( $this, 'display' ),
				get_template_directory_uri() . '/assets/img/dashboard-icon.png',
				$this->position
			);
		}
		else {
			add_submenu_page(
				$this->parent,
				$this->page_title,
				$this->menu_title,
				$this->capability,
				$this->id,
				array( $this, 'display' )
			);
		}
 
	}
 	public function save() {

	} 
	public function display() {
		echo '';
	}
}
