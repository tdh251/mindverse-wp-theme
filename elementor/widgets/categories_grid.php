<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Categories_Grid extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_categories_grid',
            'title'      => __( 'MV Categories Grid', 'mindverse' ),
            'icon'       => 'eicon-grid',
            'script'     => ['mindverse-interactions'],
            'keywords'   => [ 'mv', 'mindverse', 'category' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_category_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_title_style_controls();
        $this->register_description_style_controls();
        $this->register_thumbnail_style_controls();
        $this->register_meta_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_grid_settings_controls();
    }

    /**
     * Register Category Content Controls
     */
    protected function register_category_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_category_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Apply all items)', 'mindverse' ),
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'thumbnail',
            [
                'label' => __('Thumbnail', 'mindverse'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'id' => 0,
                ],
            ]
        );
        $repeater->add_control(
            'title',
            [
                'label' => __('Title', 'mindverse'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block' => true,
                'default' => __('Your Title', 'mindverse'),
            ]
        );
        $repeater->add_control(
            'desc',
            [
                'label' => __('Description', 'mindverse'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
            ]
        );
        $repeater->add_control(
            'meta',
            [
                'label' => __('Meta', 'mindverse'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $repeater->add_control(
            'link',
            [
                'label' => __('Link', 'mindverse'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '#'
                ]
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'item_overlay_background',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .overlay',
                'fields_options' => [
                    'background' => [
                        'label' => __('Overlay Color', 'mindverse'),
                    ]
                ]
            ]
            // .category-item-{{_index}}
        );
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'mindverse'),
            'title_field' => '{{{ title }}}',
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'title' => __( 'Title #1', 'mindverse' ),
                    'desc'  => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                    'meta'  => __('20 item', 'mindverse'),
                ],
                [
                    'title' => __( 'Title #2', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                    'meta'  => __('20 item', 'mindverse')
                ],
                [
                    'title' => __( 'Title #3', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                    'meta'  => __('20 item', 'mindverse')
                ],
            ],
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
            'selector' => '{{WRAPPER}} .category',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .category',
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
            'selector' => '{{WRAPPER}} .category:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .category:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .category, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
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
            'selector' => '{{WRAPPER}} .category .category-title',
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
                '{{WRAPPER}} .category .category-title' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .category:hover .category-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .category .category-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Content Style Controls 
    */
    protected function register_description_style_controls() {
        $this->start_style_section([
            'name' => 'section_description_style',
            'label' => __('Description', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .category .category-description',
        ]);
        $this->start_controls_tabs( 'description_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'description_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'description_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .category .category-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'description_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'description_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .category:hover .category-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'description_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .category .category-description' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

        /**
     * Register Image Style Controls
     */
    protected function register_thumbnail_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_thumbnail_style', 
            'label' => __('Thumbnail', 'mindverse'),
        ]);
        $this->group_size([
            'label' => __('Image Size', 'mindverse'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .category .category-thumbnail img',
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .category .category-thumbnail',
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
                    '{{WRAPPER}} .category .category-thumbnail img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .category .category-thumbnail img'
        ]);
        $this->group_style([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .category .category-thumbnail',
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
                '{{WRAPPER}} .category .category-thumbnail:hover img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .category .category-thumbnail:hover img'
        ]);
        $this->color([
            'name' => '_img_border_color',
            'label' => __('Border Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .category .category-thumbnail' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_style([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .category .category-thumbnail:hover',
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
                'tilt'     => __('Tilt', 'mindverse'),
                'distortionTransition' => __('Distortion Transition', 'mindverse'),
                'overlayShine' => __('Overlay Shine', 'mindverse'),
                'flowmapDeformation' => __('Flowmap Deformation', 'mindverse'),
                'flowmapDeformation2' => __('Flowmap Deformation 2', 'mindverse'),
            ]
        ]);
        $this->text([
            'name' => 'hover_trigger',
            'label' => __('Trigger', 'mindverse'),
            'placeholder' => __('eg: #trigger-id', 'mindverse'),
            'label_block' => false,
            'condition' => [
                'img_hover_style' => ['flowmapDeformation', 'flowmapDeformation2'],
            ]
        ]);
        $this->text([
            'name' => 'parallax_trigger',
            'label' => __('Trigger', 'mindverse'),
            'placeholder' => __('eg: #trigger-id', 'mindverse'),
            'label_block' => false,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->number([
            'name' => 'parallax_intensity',
            'label' => __('Intensity', 'mindverse'),
            'min' => 50,
            'max' => 500,
            'default' => 125,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->number([
            'name' => 'parallax_scale',
            'label' => __('Scale', 'mindverse'),
            'min' => 0,
            'max' => 5,
            'default' => 1,
            'condition' => [
                'img_hover_style' => 'parallax',
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
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

    /** 
     * Register Meta Style Controls 
    */       
    protected function register_meta_style_controls() {
        $this->start_style_section([
            'name' => 'section_meta_style',
            'label' => __('Meta', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'meta_typography',
            'selector' => '{{WRAPPER}} .category .category-meta',
        ]);
        $this->start_controls_tabs( 'meta_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'meta_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'meta_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .category .category-meta' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'meta_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'meta_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .category:hover .category-meta' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'meta_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .category .category-meta' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

}