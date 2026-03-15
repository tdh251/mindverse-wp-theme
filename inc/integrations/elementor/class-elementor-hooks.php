<?php

/**

 * Handles integration with the PXL plugin.

 *

 * @package    Mindverse

 * @subpackage Inc\Integrations

 */

namespace Mindverse\Inc\Integrations\Elementor;



use \Mindverse\Inc\Core\Hookable;

use \Mindverse\Inc\Utils\Helpers;



if ( !defined( 'ABSPATH' ) ) {

    exit;

}

class Elementor_Hooks extends Hookable {

    public function __construct() {

        $this->add_action( 'init', 'ensure_cpt_support');

        $this->add_action( 'elementor/preview/enqueue_styles', 'editor_preview_style' );

        $this->add_action( 'elementor/elements/categories_registered', 'register_elementor_widget_categories' );

        $this->add_filter( 'elementor/fonts/groups', 'update_elementor_font_groups_control' );
        $this->add_filter( 'elementor/fonts/additional_fonts', 'update_elementor_font_control' );
    }

    public function ensure_cpt_support() {
        if ( ! is_admin() ) {
            return;
        }
        $required_cpts = [ 'page', 'post', 'pxl-template', 'career', 'team' ];
        $current_cpts = get_option( 'elementor_cpt_support', [] );
        $has_changed = false;
        foreach ( $required_cpts as $cpt ) {
            if ( ! in_array( $cpt, $current_cpts ) ) {
                $current_cpts[] = $cpt;
                $has_changed = true;
            }
        }

        if ( $has_changed ) {
            update_option( 'elementor_cpt_support', $current_cpts );
        }
    }



    public function editor_preview_style(){
        wp_add_inline_style( 'editor-preview', $this->editor_preview_generate_global_inline_styles() );
    }



    protected function editor_preview_generate_global_inline_styles() {
        $theme_colors     = mindverse()->assets->get_style_config( 'theme_colors' );
        $link_colors      = mindverse()->assets->get_style_config( 'link' );
        $theme_typography = mindverse()->assets->get_style_config( 'theme_typography' );

        ob_start();
        echo '.elementor-edit-area-active {';
        foreach ( $theme_colors as $color => $value ) {
            printf( '--%1$s-color: %2$s;', esc_attr( $color ), esc_attr( $value['value'] ) );
        }
        foreach ( $link_colors as $color => $value ) {
            printf( '--link-%1$s: %2$s;', esc_attr( $color ), esc_attr( $value ) );
        }
        foreach ( $theme_typography as $font => $value ) {
            $font_family = is_array( $value['value'] ) ? $value['value']['font-family'] : $value['value'];
            printf( '--%1$s-font: %2$s;', esc_attr( $font ), esc_attr( $font_family ) );
        }
        echo '}';
        return ob_get_clean();
    }

    public function register_elementor_widget_categories( $elements_manager ) {
        $categories = [];
        $categories['mindverse-theme'] = [
            'title' => Helpers::get_theme_name(),
            'icon' => 'fa fa-plug'
        ];
        $existent_categories = $elements_manager->get_categories();
        $categories = array_merge($categories, $existent_categories);
        $set_categories = function ($categories) {
            $this->categories = $categories;
        };
        $set_categories->call($elements_manager, $categories);
    }

    function update_elementor_font_groups_control($font_groups){
        $pxlfonts_group = array( 'pxlfonts' => esc_html__( 'Theme Fonts', 'mindverse' ) );
        return array_merge( $pxlfonts_group, $font_groups );
    }
    
    function update_elementor_font_control($additional_fonts){
        $additional_fonts['Geist'] = 'pxlfonts';
        return $additional_fonts;
    }

}