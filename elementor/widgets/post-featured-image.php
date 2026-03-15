<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Featured_Image extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_featured_image',
            'title'      => __( 'MV Post Featured Image', 'mindverse' ),
            'icon'       => 'eicon-featured-image',
            'keywords'   => [ 'mv', 'mindverse', 'image', 'img', 'featured image', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        $this->register_image_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Featured Image' , 'mindverse')
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
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
            'selector' => '{{WRAPPER}} .image img',
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .image',
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
                    '{{WRAPPER}} .image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .image img'
        ]);
        $this->group_style([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .image',
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
                '{{WRAPPER}} .image:hover img' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .image:hover img'
        ]);
        $this->color([
            'name' => '_img_border_color',
            'label' => __('Border Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image' => 'border-color:{{VALUE}};'
            ]
        ]);
        $this->group_style([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .image:hover',
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}