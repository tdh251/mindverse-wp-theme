<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;


class Icon extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_icon',
            'title'      => __( 'MV Icon', 'mindverse' ),
            'icon'       => 'eicon-favorite',
            'keywords'   => [ 'mv', 'mindverse', 'icon', 'svg' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_icon_content_controls();
        $this->register_loop_animation_content_controls();
        // Style
        $this->register_icon_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Icon Content Controls
     */
    protected function register_icon_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse'), 
        ]);
        $this->icons([
            'name' => 'icon',
            'label' => __('Choose Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ]
        ]);
        $this->slider([
            'name' => 'box_icon_width',
            'label' => __('Box Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'box_icon_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Loop Aimation Content Controls
     */
    protected function register_loop_animation_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_loop_animation_content',
            'label' => __('Loop Animation', 'mindverse'), 
        ]);
        $this->add_control(
            'loop_animation', 
            [
                'label' => __( 'Loop Animation', 'mindverse' ),
                'type' => 'select',
                'groups' => Elementor_Helpers::loop_animation_options(),  
                'default' => '',
            ]
        );
        $this->add_responsive_control(
            'loop_animation_duration', 
            [
                'label' => __('Animation Duration(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} [data-loop-animation]' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'loop_animation!' => '',
                ]
            ]
        );
        $this->add_responsive_control(
            'loop_animation_delay', 
            [
                'label' => __('Animation Delay(ms)', 'mindverse'),
                'type' => 'slider',
                'size_units' => ['ms'],
                'default' => [
                    'unit' => 'ms'
                ],
                'selectors' => [
                    '{{WRAPPER}} [data-loop-animation]' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'loop_animation!' => '',
                ]
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Register Icon Style Controls
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'style_icon_section',
            'label' => __('Icon', 'mindverse'),
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
                '{{WRAPPER}} .icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .icon',
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
                '{{WRAPPER}} .icon:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon:hover',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .icon:hover',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}