<?php
namespace Mindverse\Elementor\Widgets;

use Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Team_Grid extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_team_grid',
            'title'      => __( 'MV Team Grid', 'mindverse' ),
            'icon'       => 'eicon-archive',
            'script'     => ['mindverse-post', 'mindverse-interactions'],
            'keywords'   => [ 'mv', 'mindverse', 'archive', 'grid', 'post', 'post type' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout
        $this->register_team_layout_controls();
        // Content
        $this->register_source_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_title_style_controls();
        $this->register_image_style_controls();
        $this->register_role_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_archive_display_settings_controls();
        $this->register_grid_settings_controls();

    }

    /**
     * Register Archive Layout Controls
     */
    protected function register_team_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_archive_layout', 
            'label' => __('Archive Layout', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'toggle' => false,
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Team 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/team-1.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Archive Source Content Controls
     */
    protected function register_source_content_controls() {        
        $this->start_content_section([ 
            'name' => 'section_source_content', 
            'label' => __('Source', 'mindverse') 
        ]);
        $this->hidden([
            'name' => 'post_type',
            'label' => __('Post Type', 'mindverse'),
            'default' => 'team',
        ]);
        $this->select2([
            'name' => 'post_ids',
            'label_block' => true,
            'label' => __('Team List', 'mindverse'),
            'options' => mindverse()->post->get_cpt_post_list( 'team' ),
            'multiple' => true,
        ]);
        $this->select([
            'name' => 'orderby',
            'label' => __('Order By', 'mindverse'),
            'separator' => 'before',
            'options' => [
                'date'  => __('Date', 'mindverse'),
                'title' => __('Title', 'mindverse'),
                'author'=> __('Author', 'mindverse'),
                'id'    => __('ID', 'mindverse'),
                'rand'  => __('Random', 'mindverse'),
            ],
            'default' => 'date'
        ]);
        $this->select([
            'name' => 'order',
            'label' => __('Order', 'mindverse'),
            'options' => [
                'ASC'  => __('Ascending', 'mindverse'),
                'DESC' => __('Descending', 'mindverse'),
            ],
            'default' => 'DESC'
        ]);
        $this->number([
            'name' => 'posts_per_page',
            'label' => __('Posts Per Page', 'mindverse'),
            'min'   => -1,
            'default' => 6,
            'method' => 'add_control',
            'description' => __('To get all posts leave the value as -1', 'mindverse')
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Archive Layout Style Controls
     */
    protected function register_layout_style_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_layout_style', 
            'label' => __('Layout', 'mindverse') 
        ]);
        $this->slider([
            'name' => 'thumbnail_spacing',
            'label' => __('Thumbnail Spacing', 'mindverse'),
            'default' => [
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .team .team-thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'title_spacing',
            'label' => __('Title Spacing', 'mindverse'),
            'default' => [
                'unit' => 'px'
            ],
            'selectors' => [
                '{{WRAPPER}} .team .team-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->text_alignment([
            'name' => 'content_text_align',
            'label' => __('Content Text Align', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team .team-content' => 'text-align: {{VALUE}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Box Style Controls 
     */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_style', 
            'label' => __('Box', 'mindverse'),
        ]);

        $this->start_controls_tabs( 'box_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'box_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .team',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .team',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'box_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .team:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .team:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .team, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Image Style Controls
     */
    protected function register_image_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_image_style', 
            'label' => __('Image', 'mindverse'),
        ]);
        $this->group_size([
            'label' => __('Image Size', 'mindverse'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .team .team-thumbnail img',
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .team .team-thumbnail',
        ]);
        $this->start_controls_tabs('img_styles');

        // Normal
        $this->_start_controls_tab([
            'name' => 'img_tab_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->slider([
                'name' => 'img_opacity',
                'label' => __( 'Opacity', 'mindverse' ),
                'size_units' => [ '' ],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .team .team-thumbnail img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .team .team-thumbnail img'
        ]);
        $this->group_style([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .team .team-thumbnail',
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'img_tab_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'img_hover_opacity',
            'label' => __( 'Opacity', 'mindverse' ),
            'size_units' => [ '' ],
            'range' => [
                '' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.01,
                ],
            ],
            'default' => [
                'unit' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .team:hover .team-thumbnail img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .team:hover .team-thumbnail img'
        ]);
        $this->color([
            'name' => '_img_hover_border_color',
            'label' => __('Border Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team:hover .team-thumbnail' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_style([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .team:hover .team-thumbnail',
        ]);
        $this->select([
            'name' => 'img_hover_style',
            'label' => __('Hover Style', 'mindverse'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                ''         => __('None', 'mindverse'),
                'zoomIn'  => __('Zoom In', 'mindverse'),
                'parallax' => __('Parallax', 'mindverse'),
                'distortionTransition' => __('Distortion Transition', 'mindverse'),
                'overlayShine' => __('Overlay Shine', 'mindverse'),
            ]
        ]);
        $this->choose_displacement([
            'condition' => [
                'img_hover_style' => 'distortionTransition'
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Title Style Controls 
     */       
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'section_title_style',
            'label' => __('Title', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .team .team-title',
        ]);
        $this->start_controls_tabs( 'title_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'title_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'title_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team .team-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'title_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'title_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team .team-title:hover a:not([data-text]), 
                {{WRAPPER}} .team .team-title a:after' => 'color: {{VALUE}};',
            ]
        ]);
        $this->select([
            'name' => 'title_hover_style',
            'label' => __('Hover Style', 'mindverse'),
            'separator' => 'before',
            'type' => 'select',
            'default' => '',
            'options' => [
                '' => __('None', 'mindverse'),
                'text-underline' => __('Underline', 'mindverse'),
                'text-underline-slide' => __('Underline Slide', 'mindverse'),
                'text-flip-3d' => __('Flip 3D', 'mindverse'),
            ],
        ]);
        $this->slider([
            'name' => 'underline_thickness',
            'label' => __('Underline Thickness', 'mindverse'),
            'size_units' => ['px', 'custom'],
            'default' => ['unit' => 'px'],
            'selectors' => [
                '{{WRAPPER}} .team .team-title' => '--mv-line-thickness: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'title_hover_style' => ['text-underline', 'text-underline-slide'],
            ],
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .team .team-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Role Style Controls 
     */       
    protected function register_role_style_controls() {
        $this->start_style_section([
            'name' => 'section_role_style',
            'label' => __('Role', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'role_typography',
            'selector' => '{{WRAPPER}} .team .team-role',
        ]);
        $this->start_controls_tabs( 'role_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'role_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'role_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team .team-role' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'role_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'role_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .team:hover .team-role' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'role_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .team .team-role' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Archive Display Settings Controls
     */
    protected function register_archive_display_settings_controls() {        
        $this->start_settings_section([ 
            'name' => 'settings_archive_display', 
            'label' => __('Display', 'mindverse') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'separator' => 'before',
            'default' => ''
        ]);
        $this->switcher([
            'name' => 'show_role',
            'label' => __('Show Role', 'mindverse'),
            'default' => 'yes',
        ]);
        $this->switcher([
            'name' => 'show_socials',
            'label' => __('Show Socials', 'mindverse'),
            'default' => 'yes',
        ]);
        $this->end_controls_section();
    }
    
    /** 
     * Register Grid Settings Controls 
     */
    protected function register_grid_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_grid_settings', 
            'label' => __('Grid', 'mindverse'),
        ]);
        $this->grid_controls_section();
        $this->end_controls_section();
    }
}
