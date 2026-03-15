<?php
/**
 * Handles integration with the PXL plugin.
 *
 * @package    Mindverse
 * @subpackage Inc\Integrations
 */

namespace Mindverse\Inc\Integrations\Pxlart;

use \Mindverse\Inc\Core\Hookable;
use \Mindverse\Inc\Core\Options;

class PXL_Hooks extends Hookable {
    private $options;
	public function __construct(Options $options_instance) {
        $this->options = $options_instance;
        $this->add_action('init', 'remove_plugin_actions', 11);
        $this->add_filter('pxl_support_e_control_icons', 'disable_hook');
        $this->add_filter('pxl_support_e_control_list', 'disable_hook');
        $this->add_filter('pxl_enable_pagepopup', 'disable_hook');
        $this->add_filter('pxl_enable_megamenu', 'enable_hook');
        $this->add_filter('pxl_enable_onepage', 'enable_hook');
        $this->add_filter('pxl_support_awesome_pro', 'disable_hook');
        $this->add_filter('pxl_scssc_on', 'disable_hook' );
        // Disable register widget 
        // $this->add_filter('pxl-register-widgets-folder', 'get_folder_widgets_path');
        /**
         * Disable Enquence Swiper to Core
         */
        $this->add_filter( 'pxl-swiper-version-active', 'disable_hook');
        // $this->add_filter( 'post_type_archive_link', 'set_post_types_archive_url', 10, 2 );
        
		
		$this->add_filter('pxl_server_info', 'server_info' );
		$this->add_filter('pxl_export_wp_settings', 'export_wp_settings' );
		// $this->add_filter('pxl_wg_get_source_id_builder', 'wg_get_source_builder' );
		$this->add_filter('pxl_template_type_support', 'template_type_support' );
        $this->add_filter('pxl_support_default_cpt', 'cpt_support_default' );
        $this->add_filter('pxl_extra_post_types', 'register_post_types');
        $this->add_filter('pxl_theme_builder_post_types', 'post_type_theme_supports_builder' );
    
        $this->add_filter('pxl_extra_taxonomies', 'register_taxonomies');

	}

    public function enable_hook() {
        return true;
    }

    public function disable_hook() {
        return false;
    }

    public function get_folder_widgets_path($folder) {
        $new_folder = get_stylesheet_directory() . '/elementor/widgets/';
        if ( is_dir( $new_folder ) ) {
            return $new_folder;
        }
        return '';
    }

    public function remove_plugin_actions() {
        if ( class_exists( 'Pxl_Elementor' ) ) {
            remove_action( 'elementor/widgets/register', [ \Pxl_Elementor::instance(), 'register_widgets' ] );
		}
    }

	public function server_info( $infos ) {
		return [
            'api_url' => 'https://api.casethemes.net/',
            'docs_url' => 'https://doc.casethemes.net/mindverse/',
            'plugin_url' => 'https://api.casethemes.net/plugins/',
            'demo_url' => 'https://mindverse.casethemes.net/',
            'support_url' => 'https://casethemes.ticksy.com/',
            'help_url' => 'https://doc.casethemes.net/mindverse',
            'email_support' => 'casethemesagency@gmail.com',
            'video_url' => '#'
		];
	}

	public function export_wp_settings( $wp_options ) {
		$wp_options[] = 'mc4wp_default_form_id';
		return $wp_options;
	}

	public function wg_get_source_builder( $wg_datas ) {
		$wg_datas['tabs']   = ['control_name' => 'tabs', 'source_name' => 'content_template'];
		$wg_datas['slides'] = ['control_name' => 'slides', 'source_name' => 'slide_template'];
		return $wg_datas;
	}
    
    public function template_type_support( $type ) {
		$extra_type = [
            'header'          => __('Header Desktop', 'mindverse'),
            'header-mobile'   => __('Header Mobile', 'mindverse'),
            'footer'          => __('Footer', 'mindverse'), 
            'mega-menu'       => __('Mega Menu', 'mindverse') ,
            'hero-section'    => __('Hero Section', 'mindverse'), 
            'panel'           => __('Panel', 'mindverse'),
            // 'archive'      => __('Archive', 'mindverse')
            'page'            => __('Page', 'mindverse'),
            'section'         => __('Section', 'mindverse')
		];
		return $extra_type;
	}

    function cpt_support_default($postypes){
        return $postypes; // pxl-template
    }

    /**
     * 
     */
    function post_type_theme_supports_builder($postypes){
        //default are header, footer, mega-menu
        return $postypes;
    }

    /**
     * Register post types
     */
    function register_post_types( $postypes ) {
        $post_types = $this->options->get_theme_option('pxl_post_type', []);
        $post_type_labels = $this->options->get_theme_option('pxl_post_type_label', []);
        $post_type_slugs = $this->options->get_theme_option('pxl_post_type_slug', []);
        $post_type_status = $this->options->get_theme_option('pxl_post_type_status', []);

        $team_label = $this->options->get_theme_option('team_label', 'Team');;
        $team_status = $this->options->get_theme_option('team_status', true);

        array_unshift($post_types, 'team');
        array_unshift($post_type_labels, $team_label);
        array_unshift($post_type_slugs, 'team');
        array_unshift($post_type_status, $team_status);

        $career_label = $this->options->get_theme_option('career_label', 'Career');
        $career_status = $this->options->get_theme_option('career_status', true);

        array_unshift($post_types, 'career');
        array_unshift($post_type_labels, $career_label);
        array_unshift($post_type_slugs, 'career');
        array_unshift($post_type_status, $career_status);

        $post_type_status = array_map('boolval', $post_type_status);

        if( !is_array( $post_types ) || empty( $post_types ) ) {
            return [];
        }

        foreach( $post_types as $i => $post_type ) {
            $sanitize_text = sanitize_title( $post_type );
            if( empty( $post_type ) ) {
                continue;
            }
            $postypes[$sanitize_text] = array(
                'status'     => (bool)$post_type_status,
                'item_name'  => $post_type_labels[$i],
                'items_name' => $post_type_labels[$i],
                'args'       => array(
                    'has_archive' => false,
                    'rewrite'             => array(
                        'slug'       => sanitize_title( $post_type_slugs[$i] ),
                    ),
                ),
                'labels'     => array(
                    'add_new_item' => __('Add ', 'mindverse').ucwords($post_type),
                ),
            );
        }
    
        return $postypes;
    }

    /**
     * Resgister taxonomies
     */
    function register_taxonomies( $taxonomies ) {
        $on_category = $this->options->get_theme_option('pxl_on_category', []); 
        $category_labels = $this->options->get_theme_option('pxl_category_label', []);
        $post_types = $this->options->get_theme_option('pxl_post_type', []);
        $career_status = $this->options->get_theme_option('career_status', true);

        // Xử lý career đồng bộ
        if( $career_status ) {
            array_unshift($post_types, 'career');
            array_unshift($category_labels, 'Categories');
            array_unshift($on_category, true); 
        }

        if( !is_array( $post_types ) || empty( $post_types ) ) {
            return $taxonomies;
        }

        foreach( $post_types as $i => $post_type ) {
            if( isset($on_category[$i]) && $on_category[$i] ) {
                $sanitize_text = sanitize_title( $post_type.'_category' );
                $taxonomies[$sanitize_text] = array(
                    'status'     => true,
                    'post_type'  => [ sanitize_title( $post_type ) ],
                    'taxonomy'   => !empty($category_labels[$i]) ? $category_labels[$i] : ucwords($post_type).' Category',
                    'taxonomies' => !empty($category_labels[$i]) ? $category_labels[$i] : ucwords($post_type).' Categories',
                    'args'       => array(
                        'hierarchical' => true, 
                        'show_in_rest' => true,
                        'rewrite'      => array(
                            'slug' => sanitize_title( $post_type.'-category' )
                        ),
                    ),
                    'labels'     => array(
                        'add_new_item' => __('Add ', 'mindverse').ucwords($post_type). __(' Category', 'mindverse'),
                    ),
                );
            }
        }

        if( $career_status ) {
            $taxonomies['career_tag'] = array(
                'status'     => true,
                'post_type'  => array('career'), 
                'taxonomy'   => esc_html__('Career Tag', 'mindverse'), 
                'taxonomies' => esc_html__('Tags', 'mindverse'), 
                'args'       => array(
                    'hierarchical'      => true,
                    'show_admin_column' => true,  
                    'show_in_rest'      => true, 
                    'rewrite'           => array(
                        'slug' => 'career-tag'
                    ),
                ),
                'labels'     => array(
                    'menu_name' => esc_html__('Career Tags', 'mindverse'),
                ),
            );
        }

        return $taxonomies;
    }

}