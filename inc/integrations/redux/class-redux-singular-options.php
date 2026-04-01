<?php
/**
 * The core Hookable class.
 *
 * This file defines the base class for all other classes in the theme that need to
 * interact with the WordPress hook system (actions and filters).
 *
 * @package    Mindverse
 * @subpackage Inc\Core
 * @author     Case Theme
 */
namespace Mindverse\Inc\Integrations\Redux;

use \Mindverse\Inc\Core\Hookable;
use \Mindverse\Inc\Utils\Helpers;
use \Mindverse\Inc\Core\Options;

// Prevents direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Redux_Singular_Options extends Hookable {

    private $options;

    public function __construct( Options $options_instance ) {
        $this->options = $options_instance;
        $this->add_action( 'pxl_post_metabox_register', 'singular_options_register' );
    }

    function singular_options_register( $metabox ) {
        $panels = [
            /** Singular Page */
            'page' => [
                'opt_name'            => 'pxl_page_options',
                'display_name'        => __( 'Page Settings', 'mindverse' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => $this->singular_general_options(),
            ],
            /** Template Page */
            'pxl-template' => [
                'opt_name'            => 'pxl_hidden_template_options',
                'display_name'        => __( 'Template Options', 'mindverse' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => [
                    'header' => [
                        'title'  => __( 'General', 'mindverse' ),
                        'icon'   => 'el-icon-website',
                        'fields' => array(
                            array(
                                'id'    => 'template_type',
                                'type'  => 'select',
                                'title' => __('Template Type', 'mindverse'),
                                'options' => [
                                    'df'       	   => __('Select Type', 'mindverse'), 
                                    'header'       => __('Header Desktop', 'mindverse'),
                                    'header-mobile'=> __('Header Mobile', 'mindverse'),
                                    'footer'       => __('Footer', 'mindverse'), 
                                    'mega-menu'    => __('Mega Menu', 'mindverse'), 
                                    'hero-section' => __('Hero Section', 'mindverse'), 
                                    'panel'        => __('Panel', 'mindverse'),
                                    'page'         => __('Page', 'mindverse'),
                                    'section'      => __('Section', 'mindverse')
                                ],
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'default' => 'df',
                            ),
                            
                            array(
                                'id'    => 'header_type',
                                'type'  => 'select',
                                'title' => __('Header Type', 'mindverse'),
                                'options' => [
                                    'default'       => __('Default', 'mindverse'), 
                                    'transparent'   => __('Transparent', 'mindverse'),
                                ],
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'default' => 'default',
                                'required' => ['template_type', '=', 'header'],
                            ),
                            array(
                                'id'    => 'hero_section_display_on',
                                'type'  => 'select',
                                'title' => __('Display On', 'mindverse'),
                                'multi' => true,
                                'select2'  => array(
                                    'allowClear' => false,
                                ),
                                'options' => [
                                    'page'         => __('Page', 'mindverse'), 
                                    'single'       => __('Single Post', 'mindverse'),
                                    'archive'      => __('Archive', 'mindverse'),
                                ],
                                'default' => 'page',
                                'required' => ['template_type', '=', 'hero-section'],
                            ),
                        ), 
                    ],
                ]
            ],
            // Team
            'team' => [
                'opt_name'            => 'pxl_team_options',
                'display_name'        => __('Team Settings', 'mindverse' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => $this->single_team_options(),
            ],
            'career' => [
                'opt_name'            => 'pxl_career_options',
                'display_name'        => __('Career Settings', 'mindverse' ),
                'show_options_object' => false,
                'context'  => 'advanced',
                'priority' => 'default',
                'sections'  => $this->single_career_options(),
            ]
        ];

        $post_types = $this->options->get_theme_option('pxl_post_type', []);
        if( is_array($post_types) ) {
            foreach( $post_types as $post_type ) {
                $post_type_slug = sanitize_title($post_type);
                $panels[$post_type_slug] = [
                    'opt_name'            => 'pxl_'.$post_type.'_options',
                    'display_name'        => $post_type.__( ' Settings', 'mindverse' ),
                    'show_options_object' => false,
                    'context'  => 'advanced',
                    'priority' => 'default',
                    'sections'  => [],
                ];
            }
        }
        $metabox->add_meta_data( $panels );
    }

    function singular_general_options() {
        return [
            // Header
            'header' => [
                'title'  => __( 'Header', 'mindverse' ),
                'icon'   => 'eicon-header',
                'fields' => array_merge(
                    array(
                        array(
                            'id' => 'header_desktop_heading',
                            'title' => __('Header Desktop', 'mindverse'),
                            'type'  => 'section',
                            'indent' => true,
                        ),
                    ),
                    Helpers::get_header_options('private'),
                    array(
                        array(
                            'id'       => 'header_nav_menu',
                            'type'     => 'select',
                            'title'    => esc_html__( 'Header Menu', 'mindverse' ),
                            'options'  => Helpers::get_nav_menu_options(),
                            'default' => '',
                            'description' => 'When you select Custom Menu. The custom menu will apply to the entire layout when you use Case Nav Menu widget in Elementor and Menu on header layout in Mobile.'
                        ),
                        array(
                            'id'       => 'header_logo',
                            'type'     => 'media',
                            'title'    => __('Header Logo', 'mindverse'),
                            'default' => array(
                                'url' => get_template_directory_uri() . '/assets/img/site-logo.webp'
                            ),
                            'url'      => false,
                            'required' => ['header_mode', '=', 'default'],
                        ),
                        array(
                            'id' => 'header_mobile_heading',
                            'title' => __('Header Mobile', 'mindverse'),
                            'type'  => 'section',
                            'indent' => true,
                        ),
                    ),
                    array(
                        array(
                            'id'       => 'header_mobile_logo',
                            'type'     => 'media',
                            'title'    => __('Mobile Logo', 'mindverse'),
                            'default' => array(
                                'url'=> get_template_directory_uri() . '/assets/img/site-logo.webp'
                            ),
                            'url'      => false,
                        ),
                        array(
                            'id'             => 'header_mobile_logo_height',
                            'type'           => 'dimensions',
                            'units'          => array('px'), 
                            'units_extended' => 'false',
                            'title'          => __('Mobile Logo Height', 'mindverse'),
                            'height'         => true,
                            'width'          => false, 
                        ),
                    )
                ),
            ],
            // Hero Section
            'hero-section' => [
                'title'  => __( 'Hero Section', 'mindverse' ),
                'icon'   => 'eicon-archive-title',
                'fields' => array_merge(
                    array(
                        // array(
                        //     'id' => 'hero_section_heading',
                        //     'title' => __('Hero Section', 'mindverse'),
                        //     'type'  => 'section',
                        //     'indent' => true,
                        // ),
                    ),
                    Helpers::get_page_hero_options('page', 'private'),
                ),
            ],
            // Footer
            'footer' => [
                'title'  => __( 'Footer', 'mindverse' ),
                'icon'   => 'eicon-footer',
                'fields' => array_merge(
                    array(
                        array(
                            'id' => 'footer_heading',
                            'title' => __('Footer', 'mindverse'),
                            'type'  => 'section',
                            'indent' => true,
                        ),
                    ),
                    Helpers::get_footer_options('private'),
                )
            ],
            'breadcrumb' => [
                'title'  => __('Breadcrumb', 'mindverse'),
                'icon'   => 'eicon-animated-headline',
                'fields' => array(
                    array(
                        'id' => 'breadcrumb_heading',
                        'title' => __('Breadcrumb', 'mindverse'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id'      => 'breadcrumb_mode',
                        'type'    => 'button_set',
                        'title'   => __( 'Breadcrumb Mode', 'mindverse' ),
                        'options' => [
                            'default'   => __( 'Default', 'mindverse' ),
                            'custom'    => __( 'Custom', 'mindverse' ),
                        ], 
                        'default' => 'default',
                    ),
                    array(
                        'id'    => 'breadcrumb_label',
                        'type'  => 'text',
                        'title' => __( 'Breadcrumb Label', 'mindverse' ),
                        'placeholder' => __('Ex: ABC', 'mindverse'),
                        'required' => [ 'breadcrumb_mode', '=', 'custom' ]
                    ),
                    array(
                        'id'    => 'breadcrumb_highight',
                        'type'  => 'text',
                        'title' => __( 'Breadcrumb Highight', 'mindverse' ),
                        'placeholder' => __('Ex: ABC', 'mindverse'),
                    ),
                ) 
            ],
            'appearance' => [
                'title'  => __( 'Appearance', 'mindverse' ),
                'icon'   => 'eicon-custom',
                'fields' => array(
                    array(
                        'id' => 'general_heading',
                        'title' => __('General', 'mindverse'),
                        'type'  => 'section',
                        'indent' => true,
                    ),
                    array(
                        'id' => 'body_custom_class',
                        'type' => 'text',
                        'title' => __('Body Custom Class', 'mindverse'),
                    ), 
                    array(
                        'id' => 'color_heading',
                        'title' => __('Colors', 'mindverse'),
                        'type'  => 'section',
                    ),
                    array(
                        'id'        => 'body_bg_color',
                        'type'      => 'color',
                        'title'     => __('Body Background Color', 'mindverse'),
                        'transparent' => false,
                    ),
                    array(
                        'id'          => 'primary_color',
                        'type'        => 'color',
                        'title'       => __('Primary Color', 'mindverse'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id'          => 'secondary_color',
                        'type'        => 'color',
                        'title'       => __('Secondary Color', 'mindverse'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id'          => 'heading_color',
                        'type'        => 'color',
                        'title'       => __('Heading Color', 'mindverse'),
                        'transparent' => false,
                        'default'     => ''
                    ),
                    array(
                        'id' => 'font_heading',
                        'title' => __('Font Family', 'mindverse'),
                        'type'  => 'section',
                    ),
                    array(
                        'id'          => 'primary_font',
                        'type'        => 'typography',
                        'title'       => __('Primary Font', 'mindverse'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'secondary_font',
                        'type'        => 'typography',
                        'title'       => __('Secondary Font', 'mindverse'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'third_font',
                        'type'        => 'typography',
                        'title'       => __('Third Font', 'mindverse'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'color'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                    ),
                    array(
                        'id'          => 'heading_font',
                        'type'        => 'typography',
                        'title'       => __('Heading Font', 'mindverse'),
                        'google'      => true,
                        'font-backup' => false,
                        'all_styles'  => false,
                        'line-height'  => false,
                        'font-size'  => false,
                        'font-style'  => false,
                        'font-weight'  => false,
                        'text-align'  => false,
                        'color'       => false,
                    ),
                )
            ],
        ];
    }

    function single_team_options() {
        return [
            'info' => [
                'title'  => __( 'Info', 'mindverse' ),
                'icon'   => 'eicon-text-field',
                'fields' => [
                    array(
                        'id'    => 'team_role',
                        'type'  => 'text',
                        'title' => __('Role', 'mindverse'),
                        'placeholder' => __('CEO', 'mindverse')
                    ),
                    array(
                        'id'    => 'team_email',
                        'type'  => 'text',
                        'title' => __('Email', 'mindverse'),
                        'placeholder' => __('info@gmail.com', 'mindverse')
                    ),
                    array(
                        'id'    => 'team_phone_number',
                        'type'  => 'text',
                        'title' => __('Phone Number', 'mindverse'),
                        'placeholder' => __('+84260325111', 'mindverse')
                    ),
                    array(
                        'id'    => 'team_address',
                        'type'  => 'text',
                        'title' => __('Address', 'mindverse'),
                        'placeholder' => __('25/26 Hai Ba Trung street, Ha Noi, Viet Nam', 'mindverse')
                    ),
                ],
            ],
            'socials' => [
                'title'  => __( 'Socials', 'mindverse' ),
                'icon'   => 'eicon-text-field',
                'fields' => [
                    array(
                        'id'       => 'team_socials',
                        'type'     => 'repeater',
                        'title'    => __('Socials', 'mindverse'),
                        'full_width' => true, 
                        'sortable' => true,
                        'group_values' => true,
                        'bind_title' => 'social_label',
                        'fields'   => array(
                            array(
                                'id'       => 'social_icon',
                                'type'     => 'media', 
                                'url'      => true,
                                'title'    => esc_html__('Social Icon', 'mindverse'),
                            ),
                            array(
                                'id'    => 'social_link',
                                'type'  => 'text',
                                'title' => __('Social Link', 'mindverse'),
                                'default' => '#'
                            ),
                        ),
                    )
                ]
            ]
        ];
    }

    function single_career_options() {
        return [
            'info' => [
                'title'  => __( 'Info', 'mindverse' ),
                'icon'   => 'eicon-text-field',
                'fields' => [
                    array(
                        'id'    => 'career_salary',
                        'type'  => 'text',
                        'title' => __('Salary', 'mindverse'),
                        'placeholder' => __('Ex: $99k/year', 'mindverse')
                    ),
                ],
            ],
        ];
    }

}