<?php
/**
* The Mindverse_Admin_Dashboard base class
*/
use \Mindverse\Inc\Utils\Helpers;

if( !defined( 'ABSPATH' ) )
	exit; 

class Mindverse_Admin_Dashboard extends Mindverse_Admin_Page {
	protected $id = null;
	protected $page_title = null;
	protected $menu_title = null;
	public $position = null;
	public function __construct() {
		$this->id = 'pxlart';
		$this->page_title = Helpers::get_theme_name();
		$this->menu_title = Helpers::get_theme_name();
		$this->position = '50';

		parent::__construct();
	}

	public function display() {
		Helpers::get_template( 'inc/admin/views/admin-dashboard' );
	}
 
	public function save() {

	}
}
new Mindverse_Admin_Dashboard;
