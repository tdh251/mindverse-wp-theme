<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Image_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_image_carousel',
            'title'      => __( 'MV Image Carousel', 'mindverse' ),
            'icon'       => 'eicon-slider-push',
            'script'     => ['mindverse-carousel', 'mindverse-interactions', 'mindverse-animation'],
            'keywords'   => [ 'mv', 'mindverse', 'img', 'image', 'carousel', 'swiper', 'slider' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_image_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_image_style_controls();
        // Settings
        $this->register_carousel_settings_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Image Content Controls
     */
    protected function register_image_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_image_content', 
            'label' => __('Content', 'mindverse'),
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Apply all items)', 'mindverse' ),
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Images', 'mindverse'),
            'fields' => [
                [
                    'name' => 'img',
                    'label' => __('Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ]
                ],
                [
                    'name'  => 'item_img_size',
                    'label' => esc_html__( 'Image Size', 'mindverse' ),
                    'type' => 'image_dimensions',
                    'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Only apply this item)', 'mindverse' ),
                ],
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                    'separator' => 'before',
                ],
            ],
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
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box',
            'selector' => '{{WRAPPER}} .image-carousel .image-item',
        ]);
        $this->group_size([
            'label' => __('Image Size', 'mindverse'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .image-carousel .image-item img',
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
                    '{{WRAPPER}} .image-carousel .image-item img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .image-carousel .image-item img'
        ]);
        $this->group_border([
            'name' => 'img_border',
            'selector' => '{{WRAPPER}} .image-carousel .image-item',
            'separator' => 'before',
        ]);
        $this->group_box_shadow([
            'name' => 'img_box_shadow',
            'selector' => '{{WRAPPER}} .image-carousel .image-item',
        ]);
        $this->dimensions([
            'name' => 'img_border_radius',
            'label' => __('Border Radius', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image-carousel .image-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name' => 'img_padding',
            'label' => __('Padding', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .image-carousel .image-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .image-carousel .image-item:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .image-carousel .image-item:hover img'
        ]);
        $this->group_border([
            'name' => 'img_hover_border',
            'selector' => '{{WRAPPER}} .image-carousel .image-item:hover',
            'separator' => 'before',
        ]);
        $this->group_box_shadow([
            'name' => 'img_hover_box_shadow',
            'selector' => '{{WRAPPER}} .image-carousel .image-item:hover',
        ]);
        $this->dimensions([
            'name' => 'img_hover_border_radius',
            'label' => __('Border Radius', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image-carousel .image-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->dimensions([
            'name' => 'img_hover_padding',
            'label' => __('Padding', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .image-carousel .image-item:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .testimonial, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
}