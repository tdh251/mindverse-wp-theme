<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Feature_Card_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_feature_card_carousel',
            'title'      => __( 'MV Feature Card Carousel', 'mindverse' ),
            'script'     => ['mindverse-carousel'],
            'icon'       => 'eicon-slider-push',
            'keywords'   => [ 'mv', 'mindverse', 'img', 'image', 'featured', 'carousel', 'swiper', 'card', 'service' ],
        ];
    }

     protected function register_controls() {
        // Layout
        $this->register_layout_controls();
        // Content
        $this->register_main_content_controls();
        $this->register_image_content_controls();
        $this->register_icon_content_controls();
        $this->register_category_content_controls();
        $this->register_badge_content_controls();
        $this->register_link_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_image_style_controls();
        $this->register_icon_style_controls();
        $this->register_title_style_controls();
        $this->register_description_style_controls();
        $this->register_link_style_controls();
        $this->register_badge_style_controls();
        // Settings
        $this->register_carousel_settings_controls();
        $this->register_custom_options_settings_controls();
    }

    /** 
     * Register Layout Controls 
     */
    protected function register_layout_controls() {
        $this->start_layout_section([ 
            'name' => 'section_layout', 
            'label' => __('Layout', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'layout',
            'label' => __('Layout', 'mindverse'),
            'columns' => '1',
            'options' => [
                '1' => [
                    'title' => esc_attr__( 'Feature Card 1', 'mindverse' ),
                    'image' => content_url('default-assets/layout/feature-card-1.webp'),
                ],
                '2' => [
                    'title' => esc_attr__( 'Feature Card 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/feature-card-2.webp'),
                ],
                '3' => [
                    'title' => esc_attr__( 'Feature Card 3', 'mindverse' ),
                    'image' => content_url('default-assets/layout/feature-card-3.webp'),
                ],
                '4' => [
                    'title' => esc_attr__( 'Feature Card 4', 'mindverse' ),
                    'image' => content_url('default-assets/layout/feature-card-4.webp'),
                ],
            ],
            'default' => '1',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Main Content Controls 
     */
    protected function register_main_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_main_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->title_tag([
            'name' => 'title_tag',
            'default' => '',
        ]);
        $this->text([
            'name' => 'btn_text',
            'label' => __('Link Text', 'mindverse'),
            'default' => __('Click here', 'mindverse'),
            'condition' => [
                'layout' => ['2', '3', '4'],
            ],
        ]);
        $this->switcher([
            'name' => 'use_img_icon',
            'label' => __('Use Image Icon', 'mindverse'),
            'default' => '',
            'condition' => [
                'layout' => ['2'],
            ],
        ]);
        $this->repeater([
            'name' => 'contents',
            'label' => __( 'Contents', 'mindverse' ),
            'fields' => [
                [
                    'name' => 'title',
                    'label' => __( 'Title', 'mindverse' ),
                    'type' => 'textarea',
                    'rows' => 2,
                    'default' => __( 'Your Title', 'mindverse' ),
                ],
                [
                    'name' => 'desc',
                    'label' => __( 'Description', 'mindverse' ),
                    'type' =>'textarea',
                    'rows' => 10,
                    'default' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'name' => 'link',
                    'label' => __( 'Link', 'mindverse' ),
                    'type' => 'url',
                ]
            ],
            'default' => [
                [
                    'title' => __( 'Title #1', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #2', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
                [
                    'title' => __( 'Title #3', 'mindverse' ),
                    'desc' => __( 'Item description. Click the edit button to change this text.', 'mindverse' ),
                ],
            ]
        ]);

        $this->end_controls_section();
    }

    /** 
     * Register Image Content Controls 
     */
    protected function register_image_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_image_content', 
            'label' => __('Image', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => 'in',
                                'value' => ['1', '4'],
                            ],
                        ]
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => '===',
                                'value' => '2',
                            ],
                            [
                                'name' => 'use_img_icon',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                        ]
                    ]
                ],
            ],
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->repeater([
            'name' => 'imgs',
            'label' => __( 'Images', 'mindverse' ),
            'fields' => [
                [
                    'name'  => 'img',
                    'label' => __( 'Choose Image', 'mindverse' ),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                    ]
                ]
            ],
            'default' => [
                [
                    'img' => ['id' => 0]
                ],
                [
                    'img' => ['id' => 0]
                ],
                [
                    'img' => ['id' => 0]
                ],
            ]
        ]);

        $this->end_controls_section();
    }

    /** 
     * Register Icon Content Controls 
     */
    protected function register_icon_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_icon_content', 
            'label' => __('Icon', 'mindverse'),
            'condition' => [
                'layout' => '2',
                'use_img_icon!' => 'yes',
            ],
        ]);
        $this->repeater([
            'name' => 'icons',
            'label' => __( 'Icons', 'mindverse' ),
            'fields' => [
                [
                    'name'  => 'icon',
                    'label' => __( 'Choose Icon', 'mindverse' ),
                    'type' => 'icons',
                    'default' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                ]
            ],
            'default' => [
                [
                    'icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ]
                ],
                [
                    'icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ]
                ],
                [
                    'icon' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ]
                ],
            ]
        ]);

        $this->end_controls_section();
    }

    /** 
     * Register Category Content Controls 
     */
    protected function register_category_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_category_content', 
            'label' => __('Category', 'mindverse'),
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->repeater([
            'name' => 'categories',
            'label' => __( 'Categories', 'mindverse' ),
            'fields' => [
                [
                    'name' => 'name',
                    'label' => __( 'Name', 'mindverse' ),
                    'type' => 'text',
                    'label_block' => true,
                ],
                [
                    'name' => 'link',
                    'label' => __( 'Link', 'mindverse' ),
                    'type' => 'url',
                    'default' => ['url' => '#']
                ]
            ],
            'default' => [
                [
                    'name' => __( 'Category #1', 'mindverse' ),
                    'link' => ['url' => '#']
                ],
                [
                    'name' => __( 'Category #2', 'mindverse' ),
                    'link' => ['url' => '#']
                ],
                [
                    'name' => __( 'Category #3', 'mindverse' ),
                    'link' => ['url' => '#']
                ],
            ]
        ]);

        $this->end_controls_section();
    }

    /** 
     * Register Badge Content Controls 
     */
    protected function register_badge_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_badge_content', 
            'label' => __('Badges', 'mindverse'),
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->repeater([
            'name' => 'badges',
            'label' => __( 'Badges', 'mindverse' ),
            'fields' => [
                [
                    'name' => 'text',
                    'label' => __( 'Text', 'mindverse' ),
                    'type' => 'textarea',
                    'rows' => 10,
                    'description' => __('Separator with |', 'mindverse')
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Link Content Controls 
     */
    protected function register_link_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_link_content', 
            'label' => __('Link Secondary', 'mindverse'),
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->text([
            'name' => 'link2_text',
            'label' => __( 'Link Text', 'mindverse' ),
            'type' => 'text',
            'default' => __('Click here', 'mindverse'),
        ]);
        $this->repeater([
            'name' => 'links',
            'label' => __( 'Links', 'mindverse' ),
            'fields' => [
                [
                    'name' => 'link',
                    'label' => __( 'Link', 'mindverse' ),
                    'type' => 'url',
                    'default' => ['url' => '#']
                ]
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
            'selector' => '{{WRAPPER}} .feature-card',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .feature-card',
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
            'selector' => '{{WRAPPER}} .feature-card:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .feature-card:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => 'in',
                                'value' => ['1', '4'],
                            ],
                        ]
                    ],
                    [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'layout',
                                'operator' => '===',
                                'value' => '2',
                            ],
                            [
                                'name' => 'use_img_icon',
                                'operator' => '===',
                                'value' => 'yes',
                            ],
                        ]
                    ]
                ],
            ],
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image',
        ]);
        $this->group_size([
            'label' => __('Image Size', 'mindverse'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image img',
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
                    '{{WRAPPER}} .feature-card .feature-card-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image img'
        ]);
        $this->group_border([
            'name' => 'img_border',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image',
            'separator' => 'before',
        ]);
        $this->group_box_shadow([
            'name' => 'img_box_shadow',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image',
        ]);
        $this->dimensions([
            'name' => 'img_border_radius',
            'label' => __('Border Radius', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name' => 'img_padding',
            'label' => __('Padding', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
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
                    '{{WRAPPER}} .feature-card .feature-card-image:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image:hover img'
        ]);
        $this->group_border([
            'name' => 'img_hover_border',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image:hover',
            'separator' => 'before',
        ]);
        $this->group_box_shadow([
            'name' => 'img_hover_box_shadow',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-image:hover',
        ]);
        $this->dimensions([
            'name' => 'img_hover_border_radius',
            'label' => __('Border Radius', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-image:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name' => 'img_hover_padding',
            'label' => __('Padding', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-image:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->duration([
            'name' => 'img_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-image' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
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
     * Register Icon Style Controls 
    */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'mindverse'),
            'condition' => [
                'layout' => '2',
                'use_img_icon!' => 'yes',
            ],
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .feature-card .feature-card-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
            ]
        ]);
        $this->start_controls_tabs( 'icon_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'icon_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-icon' => 'color: {{VALUE}};',
            ]
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'icon_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'icon_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card:hover .feature-card-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            'selector' => '{{WRAPPER}} .feature-card .feature-card-title',
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
                '{{WRAPPER}} .feature-card .feature-card-title' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .feature-card:hover .feature-card-title' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'title_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-title' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Description Style Controls 
     */       
    protected function register_description_style_controls() {
        $this->start_style_section([
            'name' => 'section_description_style',
            'label' => __('Description', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-description',
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
                '{{WRAPPER}} .feature-card .feature-card-description' => 'color: {{VALUE}};',
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
                '{{WRAPPER}} .feature-card:hover .feature-card-description' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'description_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-description' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Link Style Controls 
     */       
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __('Link', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .feature-card .feature-card-link',
        ]);
        $this->start_controls_tabs( 'link_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'link_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'link_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-link' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'link_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'link_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .feature-card:hover .feature-card-link' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'link_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card .feature-card-link' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Badge Style Controls 
     */
    protected function register_badge_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_badge_style', 
            'label' => __('Badge', 'mindverse'),
            'condition' => [
                'layout' => ['3']
            ]
        ]);
        $this->group_typography([
            'name' => 'badge_typography',
            'selector' => '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge',
        ]);
        $this->color([
            'name' => 'badge_color',
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'badge_',
            'selector' => '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge'
        ]);
        $this->group_style([
            'name' => 'badge_',
            'selector' => '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge'
        ]);
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'badge_color',
            [
                'label' => __( 'Color', 'mindverse' ),
                'type' => 'color',
                'selectors' => [
                    '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge{{CURRENT_ITEM}}' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'badge_bg',
                'selector' => '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge{{CURRENT_ITEM}}',
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'badge_border',
                'selector' => '{{WRAPPER}} .feature-card-grid .feature-card-badges .badge{{CURRENT_ITEM}}',
            ]
        );
        $this->repeater([
            'name' => 'badges_style',
            'label' => __( 'Badges Own Style', 'mindverse' ),
            'separator' => 'before',
            'fields' => $repeater->get_controls(),
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