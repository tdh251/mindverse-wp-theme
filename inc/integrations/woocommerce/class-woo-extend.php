<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( class_exists( 'WPCleverWoosc' ) ) {
    return;
}

class Woo_Extend {

    public function __construct() {

    }

    /**
     * Normalize product id
     */
    public function normalize_product_id( $product_id ) {
        $product_id = absint( $product_id );

        if ( ! $product_id ) {
            return 0;
        }

        $product = wc_get_product( $product_id );

        if ( ! $product ) {
            return 0;
        }

        return $product_id;
    }

}