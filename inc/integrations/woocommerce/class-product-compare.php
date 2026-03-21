<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'WPCleverWoosc' ) ) {
    return;
}

class Product_Compare extends Woo_Extend {

    public function __construct() {
        add_filter('woosc_button_position_archive', '__return_false');
        add_filter('woosc_button_position_single', '__return_false');
    }
}