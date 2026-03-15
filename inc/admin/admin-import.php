<?php
/**
* The Mindverse_Admin_Import class
*/
use \Mindverse\Inc\Utils\Helpers;

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Mindverse_Admin_Import extends Mindverse_Admin_Page {
	protected $id = null;
	protected $page_title = null;
	protected $menu_title = null;
	public $parent = null;
	public function __construct() {

		$this->id = 'pxlart-import-demos';
		$this->page_title = esc_html__( 'Import Demos', 'mindverse' );
		$this->menu_title = esc_html__( 'Import Demos', 'mindverse' );
		$this->parent = 'pxlart';
		//$this->position = '10';

		parent::__construct();
	}

	public function display() {
		Helpers::get_template( 'inc/admin/views/admin-demos' );
	}


	public function save() {

	}
}
new Mindverse_Admin_Import;