<?php
namespace Mindverse\Inc\Integrations\Woocommerce;

use Mindverse\Inc\Core\Hookable;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use \Mindverse\Inc\Core\Options;

class Woo_Init extends Hookable {

    public function __construct( Options $options_instance ) {
        new Shop( $options_instance );
    }

}