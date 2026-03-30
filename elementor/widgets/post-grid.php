<?php
namespace Mindverse\Elementor\Widgets;

use Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Grid extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_grid',
            'title'      => __( 'Post Grid', 'mindverse' ),
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
        $this->register_post_grid_layout_controls();
        $this->register_post_grid_style_layout_controls();
        // Content
        $this->register_source_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_box_content_style_controls();
        $this->register_title_style_controls();
        $this->register_image_style_controls();
        $this->register_author_style_controls();
        $this->register_date_style_controls();
        $this->register_tag_style_controls();
        $this->register_button_style_controls();
        $this->register_saraly_style_controls();
        // // Settings
        $this->register_custom_options_settings_controls();
        $this->register_post_display_settings_controls();
        $this->register_grid_settings_controls();
    }

    /**
     * Register Grid Layout Controls
     */
    protected function register_post_grid_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_grid_layout', 
            'label' => __('Layout', 'mindverse') 
        ]);
        $this->text([
            'name' => 'html_id',
            'label' => __('HTML ID', 'mindverse'),
            'placeholder' => __('Ex: name-id', 'mindverse'),
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'toggle' => false,
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Post 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/post-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Career 1', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/career-1.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Grid Layout Controls
     */
    protected function register_post_grid_style_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_grid_style_layout', 
            'label' => __('Layout Style', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'layout1_style',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'toggle' => false,
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Layout Style Default', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/post-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Layout Style 2', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/post-1_2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Layout Style 3', 'mindverse' ),
                    'image' => content_url('/uploads/default-assets/layout/post-1_3.webp'),
                ],
            ],
            'default' => '1',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Grid Source Content Controls
     */
    protected function register_source_content_controls() {      
        $post_types = mindverse()->post->get_post_type_list();  
        $this->start_content_section([ 
            'name' => 'content_archive_source', 
            'label' => __('Source', 'mindverse') 
        ]);
        $this->select([
            'name' => 'post_type',
            'label' => __('Post Type', 'mindverse'),
            'options' => $post_types,
            'default' => 'post',
        ]);
        $this->select([
            'name' => 'source_type',
            'label' => __('Source Type', 'mindverse'),
            'default' => 'id' ,
            'options' => [
                'id' => __('ID', 'mindverse'),
                'category' => __('Category', 'mindverse'),
            ]
        ]);
        foreach( $post_types as $post_type => $label ) {
            $category_key = $post_type === 'post' ? 'category' : $post_type.'_category';
            $this->select2([
                'name' => $post_type.'_ids',
                'label_block' => true,
                'label' => __('Post List', 'mindverse'),
                'options' => mindverse()->post->get_cpt_post_list( $post_type ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'id',
                    'post_type' => $post_type
                ]
            ]);
            $this->select2([
                'name' => $post_type.'_categories',
                'label_block' => true,
                'label' => __('Post Categories', 'mindverse'),
                'options' => mindverse()->post->get_cpt_category_list( $category_key ),
                'multiple' => true,
                'condition' => [
                    'source_type' => 'category',
                    'post_type' => $post_type
                ]
            ]);
        }
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
     * Register Grid Layout Style Controls
     */
    protected function register_layout_style_controls() {        
        $this->start_style_section([ 
            'name' => 'settings_layout_style', 
            'label' => __('Layout', 'mindverse') 
        ]);
        $this->choose([
            'name' => 'box_flex_wrap',
            'label' => __('Flex Wrap', 'mindverse'),
            'options' => [
                'nowrap' => [
                    'title' => __('No Wrap', 'mindverse'),
                    'icon' => 'eicon-nowrap',
                ],
                'wrap' => [
                    'title' => __('Wrap', 'mindverse'),
                    'icon' => 'eicon-wrap',
                ],
            ],
            'method' => 'add_responsive_control',
            'selectors' => [
                '{{WRAPPER}} .post-grid .post' => 'flex-wrap: {{VALUE}};' 
            ]
        ]);
        $this->slider([
            'name' => 'featured_image_flex_basis',
            'label' => __('Featured Image Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-featured-image' => 'flex-basis: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1', '2']
            ]
        ]);
        $this->slider([
            'name' => 'content_flex_basis',
            'label' => __('Content Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-content' => 'flex-basis: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1', '2']
            ]
        ]);
        $this->slider([
            'name' => 'date_spacing',
            'label' => __('Date Spacing', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-date' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1'],
                'show_date' => 'yes'
            ]
        ]);
        $this->slider([
            'name' => 'title_spacing',
            'label' => __('Title Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-title' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->slider([
            'name' => 'excerpt_spacing',
            'label' => __('Excerpt Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1', '2'],
                'show_excerpt' => 'yes'
            ]
        ]);
         $this->slider([
            'name' => 'featured_image_spacing',
            'label' => __('Featured Image Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post-grid .post-featured-image' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'layout' => ['1'],
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
            'selector' => '{{WRAPPER}} .post',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .post',
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
            'selector' => '{{WRAPPER}} .post:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .post:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Box Content Style Controls 
     */
    protected function register_box_content_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_content_style', 
            'label' => __('Box Content', 'mindverse'),
        ]);
        $this->group_background([
            'name' => 'box_conent_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post .post-content',
		]);
        $this->group_style([
            'name' => 'box_content_',
            'selector' => '{{WRAPPER}} .post .post-content',
        ]);
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
            'selector' => '{{WRAPPER}} .post .post-featured-image img',
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .post .post-featured-image',
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
                    '{{WRAPPER}} .post .post-featured-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .post .post-featured-image img'
        ]);
        $this->group_style([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .post .post-featured-image',
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
                '{{WRAPPER}} .post:hover .post-featured-image img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .post:hover .post-thumbnail img'
        ]);
        $this->color([
            'name' => '_img_hover_border_color',
            'label' => __('Border Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post:hover .post-thumbnail' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_style([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .post:hover .post-thumbnail',
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
            'selector' => '{{WRAPPER}} .post .post-title',
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
                '{{WRAPPER}} .post .post-title' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .post .post-title:hover a:not([data-text]), 
                {{WRAPPER}} .post .post-title a:after' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .post .post-title' => '--mv-line-thickness: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .post .post-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Author Style Controls 
     */       
    protected function register_author_style_controls() {
        $this->start_style_section([
            'name' => 'section_author_style',
            'label' => __('Author', 'mindverse'),
            'condition' => [
                'show_author' => 'yes',
                'layout' => ['1']
            ]
        ]);
        $this->group_typography([
            'name' => 'author_typography',
            'selector' => '{{WRAPPER}} .post .post-author',
        ]);
        $this->start_controls_tabs( 'author_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'author_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'author_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post .post-author, 
                {{WRAPPER}} .post .post-author > a' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'author_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'author_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post .post-author > a:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'author_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post .post-author a' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Date Style Controls 
     */
    protected function register_date_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_date_style', 
            'label' => __('Date', 'mindverse'),
            'condition' => [
                'show_date' => 'yes',
                'layout' => ['1']
            ]
        ]);
        $this->group_typography([
            'name' => 'date_typography',
            'selector' => '{{WRAPPER}} .post .post-date',
        ]);
        $this->color([
            'name' => 'date_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post .post-date' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'date_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post',
		]);
        $this->group_style([
            'name' => 'date_',
            'selector' => '{{WRAPPER}} .post .post-date',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Tag Style Controls 
     */
    protected function register_tag_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_tag_style', 
            'label' => __('Tag', 'mindverse'),
            'condition' => [
                'show_tag' => 'yes',
                'layout' => ['2']
            ]
        ]);
        $this->group_typography([
            'name' => 'tag_typography',
            'selector' => '{{WRAPPER}} .post .post-tag a',
        ]);
        $this->start_controls_tabs( 'tag_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'tag_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'tag_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post .post-tag a',
		]);
        $this->group_style([
            'name' => 'tag_',
            'selector' => '{{WRAPPER}} .post .post-tag a',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'tag_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'tag_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post .post-tag a:hover',
		]);
        $this->group_style([
            'name' => 'tag_hover_',
            'selector' => '{{WRAPPER}} .post .post-tag a:hover',
        ]);
        $this->duration([
            'name' => 'tag_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post .post-tag a' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Button Style Controls 
     */
    protected function register_button_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_button_style', 
            'label' => __('Button', 'mindverse'),
            'condition' => [
                'show_button' => 'yes',
                'layout' => ['2']
            ]
        ]);
        $this->group_typography([
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .post .post-button',
        ]);
        $this->start_controls_tabs( 'button_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'button_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'button_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post .post-button',
		]);
        $this->group_style([
            'name' => 'button_',
            'selector' => '{{WRAPPER}} .post .post-button',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->_start_controls_tab([
            'name' => 'button_style_hover_tab', 
            'label' => __( 'Hover', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'button_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .post .post-button:before',
		]);
        $this->group_style([
            'name' => 'button_hover_',
            'selector' => '{{WRAPPER}} .post .post-button:before',
        ]);
        $this->duration([
            'name' => 'button_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post .post-button' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    /** 
     * Register Salary Style Controls 
     */       
    protected function register_saraly_style_controls() {
        $this->start_style_section([
            'name' => 'section_saraly_style',
            'label' => __('Salary', 'mindverse'),
            'condition' => [
                'show_saraly' => 'yes',
                'layout' => ['1']
            ]
        ]);
        $this->group_typography([
            'name' => 'saraly_typography',
            'selector' => '{{WRAPPER}} .post .post-saraly',
        ]);
        $this->start_controls_tabs( 'saraly_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'saraly_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'saraly_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post .post-saraly' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'saraly_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'saraly_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .post:hover .post-saraly' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'saraly_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .post .post-saraly' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Grid Source Content Controls
     */
    protected function register_post_display_settings_controls() {        
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
            'name' => 'show_date',
            'label' => __('Show Date', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1']
            ]
        ]);
        $this->text([
            'name' => 'date_format',
            'label' => __('Date Format', 'mindverse'),
            'description' => '<a href="https://www.php.net/manual/en/function.date.php" target="_blank">Learn More.<a/>',
            'placeholder' => __('F d, Y', 'mindverse'),
            'condition' => [
                'layout' => ['1'],
                'show_date' => 'yes'
            ]
        ]);
        $this->switcher([
            'name' => 'show_excerpt',
            'label' => __('Show Excerpt', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1', '2']
            ]
        ]);
        $this->number([
            'name' => 'num_of_words',
            'label' => __( 'Number of Words', 'mindverse' ),
            'min' => -1,
            'description' => __('Show Full Excerpt with value = -1', 'mindverse'),
            'condition' => [
                'layout' => ['1', '2'],
                'show_excerpt' => 'yes'
            ]
        ]);

        $this->switcher([
            'name' => 'show_author',
            'label' => __('Show Author', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['1']
            ]
        ]);

        $this->switcher([
            'name' => 'show_button',
            'label' => __('Show Button', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['2']
            ]
        ]);

        $this->text([
            'name' => 'button_text',
            'label' => __('Button Text', 'mindverse'),
            'condition' => [
                'layout' => ['2'],
                'show_button' => 'yes', 
            ]
        ]);

        $this->switcher([
            'name' => 'show_tag',
            'label' => __('Show Tag', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['2']
            ]
        ]);
        $this->switcher([
            'name' => 'show_salary',
            'label' => __('Show Salary', 'mindverse'),
            'default' => 'yes',
            'condition' => [
                'layout' => ['2']
            ]
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