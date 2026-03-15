<?php
/**
 * Handles integration with the PXL plugin.
 *
 * @package    Mindverse
 * @subpackage Inc\Integrations
 */

namespace Mindverse\Inc\Integrations\Redux;

use \Mindverse\Inc\Core\Options;
use \Mindverse\Inc\Core\Hookable;

class Redux_Hooks extends Hookable {
    private $options;
	public function __construct(Options $options_instance) {
        $this->options = $options_instance;
        $this->add_filter( 'redux_pxl_iconpicker_field/get_icons', 'set_icons_to_pxl_iconpicker_field' );
        $this->add_filter( 'redux/'.$this->options->get_option_name().'/field/typography/custom_fonts', 'set_custom_font_to_redux_typography_option', 10, 1 ); 
	}

    public function enable_hook() {
        return false;
    }

    public function disable_hook() {
        return false;
    }

    function set_icons_to_pxl_iconpicker_field($icons){
        $custom_icons = []; //'Flaticon' => array(array('flaticon-marker' => 'flaticon-marker')),
        // $icons = array_merge($custom_icons, $icons);
        return $icons;
    }

    function set_custom_font_to_redux_typography_option($fonts){
        $fonts = [
            'Theme Custom Fonts' => [
                'Glittery-Snowfall' => 'Glittery Snowfall',
            ]
        ];
        return $fonts;
    }
}