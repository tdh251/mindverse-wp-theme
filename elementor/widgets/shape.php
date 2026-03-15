<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Shape extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_shape',
            'title'      => __( 'MV Shape', 'mindverse' ),
            'icon'       => 'eicon-shape',
            'script'     => ['mindverse-scrolling'],
            'keywords'   => [ 'mv', 'mindverse', 'shape' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_shape_content_controls();
        // Style
        $this->register_shape_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Shape Content Controls
     */
    protected function register_shape_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => 'Content' 
        ]);
        $this->select([
            'name' => 'shape_style',
            'label' => __('Style', 'mindverse'),
            'default' => '',
            'options' => [
                '' => __('Default', 'mindverse'),
                'gradient-3-color' => __('Gradient 3 Color', 'mindverse'),
                'gradient-6-color' => __('Gradient 6 Color', 'mindverse'),
            ]
        ]);
        $this->slider([
            'name' => 'shape_width',
            'label' => __('Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .shape' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'shape_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .shape' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Shape Style Controls
     */
    protected function register_shape_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_shape_style', 
            'label' => __('Shape', 'mindverse'),
        ]);
        // Background
        $this->group_background([
            'name' => 'shape_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .shape',
            'condition' => [
                'shape_style!' => 'gradient-3-color'
            ]
		]);
        $this->number([
            'name' => 'shape_angle_gradient',
            'label' => __('Angle', 'mindverse'),
            'min' => -360,
            'max' => 360,
            'selectors' => [
                '{{WRAPPER}} .shape' => '--mv-angle: {{VALUE}}deg;'
            ]
        ]);
        $this->color([
            'name' => 'shape_color_gradient',
            'label' => __('Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .shape' => '--gradient-color: {{VALUE}};'
            ],
            'condition' => [
                'shape_style' => 'gradient-3-color'
            ]
        ]);
        $this->color([
            'name' => 'shape_color2_gradient',
            'label' => __('Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .shape' => '--gradient-color-2: {{VALUE}};'
            ],
            'condition' => [
                'shape_style' => 'gradient-3-color'
            ]
        ]);
        $this->color([
            'name' => 'shape_color3_gradient',
            'label' => __('Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .shape' => '--gradient-color-3: {{VALUE}};'
            ],
            'condition' => [
                'shape_style' => 'gradient-3-color'
            ]
        ]);
        // Border
        $this->group_border([
            'name' => 'shape_border',
            'selector' => '{{WRAPPER}} .shape',
            'separator' => 'before',
        ]);
        // Box Shadow
        $this->group_box_shadow([
            'name' => 'shape_box_shadow',
            'selector' => '{{WRAPPER}} .shape',
	    ]);
        // Border Radius
        $this->dimensions([
            'name' => 'shape_border_radius',
            'label' => __( 'Border Radius', 'mindverse' ),
            'selectors' => [
                '{{WRAPPER}} .shape' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Padding 
        $this->dimensions([
            'name' => 'shape_padding',
            'label' => __( 'Padding', 'mindverse' ),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .shape' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]);
        // Opacity
        $this->opacity([
            'name' => 'shape_opacity',
            'selectors' => [
                '{{WRAPPER}} .shape' => 'opacity: {{SIZE}}',
            ],
        ]);
        // Css filter
        $this->group_css_filter([
            'name' => 'shape_css_filter',
            'selector' => '{{WRAPPER}} .shape'
        ]);
        $this->end_controls_section();
    }
}