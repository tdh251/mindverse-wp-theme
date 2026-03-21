<?php
namespace Mindverse\Inc\Core;
// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use Mindverse\Inc\Setup\Setup;
use Mindverse\Inc\Frontend\Layout;
use Mindverse\Inc\Frontend\Assets;
use Mindverse\Inc\Frontend\Customize;
use Mindverse\Inc\Integrations\Pxlart\PXL_Hooks;
use Mindverse\Inc\Integrations\Redux\Redux_Hooks;
use Mindverse\Inc\Integrations\Redux\Redux_Theme_Options;
use Mindverse\Inc\Integrations\Redux\Redux_Singular_Options;
use \Mindverse\Inc\Integrations\Elementor\Elementor_Init;
use \Mindverse\Inc\Integrations\Woocommerce\Woo_Init;

// use Mindverse\Inc\Core\Options;

if(!class_exists('Mindverse')) {
    final class Mindverse {
        private static $instance = null;
        public $layout;
        public $options;
        public $assets;
        public $post;
        public $customize;
    
        private function __construct() {
            $this->init_components();
            add_action( 'widgets_init', [ $this, 'register_widgets' ] );

        }
        
        public static function instance() {
            if (null === self::$instance) {
                self::$instance = new Mindverse();
            }
            return self::$instance;
        }

        private function init_components() {
            new Setup();
            $this->options = new Options();
            $this->customize = new Customize( $this->options );
            $this->assets = new Assets( $this->options );
            if ( class_exists( 'Pxl_Elementor' ) ) { 
                new PXL_Hooks( $this->options );
            }
            if( class_exists( 'Woocommerce' ) ) {
                new Woo_Init( $this->options );
            }
            if ( class_exists( 'Redux' ) && is_admin()) {
                new Redux_Hooks( $this->options );
                new Redux_Theme_Options( $this->options ); 
                new Redux_Singular_Options( $this->options );
            }
            $this->layout = new Layout( $this->options );
            $this->post = new Post_Manager( $this->options, $this->layout );
            if ( did_action( 'elementor/loaded' )) {
                new Elementor_Init( $this->assets );
            }
        }

        public function get_option($option = null, $default = false, $subset = false) {
            return $this->options->get_option($option, $default, $subset);
        }

        public function get_theme_option($option = null, $default = false, $subset = false) {
            return $this->options->get_theme_option($option, $default, $subset);
        }

        public function get_singular_option($option = null, $default = false, $subset = false) {
            return $this->options->get_singular_option($option, $default, $subset);
        }

        public function register_widgets(){
            if( function_exists('pxl_register_wp_widget') ){
                pxl_register_wp_widget( 'Mindverse\Inc\Utils\Custom_Recent_Posts_Widget' );
                pxl_register_wp_widget( 'Mindverse\Inc\Utils\Author_Info_Widget' );
            }
        }

        
    }


}