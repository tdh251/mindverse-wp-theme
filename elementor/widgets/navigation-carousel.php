<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Traits\Swiper_Trait;


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Navigation_Carousel extends Mindverse_Widget_Base {

    use Swiper_Trait;

    protected function widget_info() {
        return [
            'name'       => 'mindverse_navigation_carousel',
            'title'      => __( 'MV Navigation Carousel', 'mindverse' ),
            'icon'       => 'eicon-post-navigation',
            'keywords'   => [ 'mv', 'mindverse', 'nav', 'navigation', 'carousel' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->content_section();

        // Style
        $this->register_navigation_button_carousel_controls();
        // Setting
        $this->register_custom_options_settings_controls();
    }

    /** Content */
    protected function content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse'),
        ]);
        $this->hidden([
            'name' => 'swiper_nav',
            'default' => 'yes'
        ]);
        $this->hidden([
            'name' => 'nav_widget_id',
            'default' => ''
        ]);
        $this->text([
            'name'  => 'html_id',
            'label' => __('HTML ID', 'mindverse'),
            'placeholder' => __('eg: nav-carousel-demo', 'mindverse'),
        ]);
        $this->icons([
            'name' => 'nav_prev_icon',
            'label' => __('Previous Icon', 'mindverse'),
            'default' => [],
            'condition' => [
                'swiper_nav' => 'yes',
                'use_nav_widget' => ''
            ]
        ]);
        $this->icons([
            'name' => 'nav_next_icon',
            'label' => __('Next Icon', 'mindverse'),
            'default' => [],
            'condition' => [
                'swiper_nav' => 'yes',
                'use_nav_widget' => ''
            ]
        ]);
        $this->end_controls_section();
    }

    protected function register_layout_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->choose([
            'name' => 'swiper_nav_justify_content',
            'label' => __('Justify Content', 'mindverse'),
            'options' => [
                'start' => [ 'title' => __( 'Start', 'mindverse' ), 'icon' => 'eicon-justify-start-h', ],
                'center' => [ 'title' => __( 'Center', 'mindverse' ), 'icon' => 'eicon-justify-center-h', ],
                'end' => [ 'title' => __( 'End', 'mindverse' ), 'icon' => 'eicon-justify-end-h', ],
                'space-between' => [ 'title' => __( 'Space Between', 'mindverse' ), 'icon' => 'eicon-justify-space-between-h', ],
                'space-around' => [ 'title' => __( 'Space Around', 'mindverse' ), 'icon' => 'eicon-justify-space-around-h', ],
                'space-evenly' => [ 'title' => __( 'Space Evenly', 'mindverse' ), 'icon' => 'eicon-justify-space-evenly-h', ],
            ],
            'method' => 'add_responsive_control',
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation' => 'justify-content: {{VALUE}};'
            ]
        ]);
        $this->slider([
            'name' => 'swiper_nav_gap',
            'label' => __( 'Gap', 'mindverse' ),
            'size_units' => [ 'px', 'custom' ],
            'range' => [
                'px' => [ 'min' => 0, 'max' => 500, ],
            ],
            'default' => [
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Style */
    protected function style_navigation_button() {
        $this->start_style_section([ 
            'name' => 'style_swiper_nav_btn_section', 
            'label' => __('Navigation Button', 'mindverse'),
        ]);
        $this->start_controls_tabs( 'swiper_nav_btn_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'swiper_nav_btn_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'swiper_nav_btn_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'swiper_nav_btn_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button',
		]);
        $this->group_style([
            'name' => 'swiper_nav_btn_',
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'swiper_nav_btn_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'swiper_nav_btn_hover_color',
            'label' => __('Icon Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_background([
            'name' => 'swiper_nav_btn_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button:not(.box-gradient):hover, {{WRAPPER}} .carousel-navigation .carousel-button.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'swiper_nav_btn_hover_',
            'selector' => '{{WRAPPER}} .carousel-navigation .carousel-button:hover',
        ]);
        $this->duration([
            'name' => 'swiper_nav_btn_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .carousel-navigation .carousel-button, {{WRAPPER}} .carousel-navigation .carousel-button.box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}