<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Divider extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_divider',
            'title'      => __( 'MV Divider', 'mindverse' ),
            'icon'       => 'eicon-divider',
            'keywords'   => [ 'mv', 'mindverse', 'divider' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_divider_content_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Divider Content Controls
     */
    protected function register_divider_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_divider_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->select([
            'name' => 'divider_dir',
            'label' => __('Direction', 'mindverse'),
            'default' => 'horizontal',
            'options' => [
                'horizontal' => __( 'Horizontal', 'mindverse' ),
                'vertical'   => __( 'Vertical', 'mindverse' ),
            ],
        ]);
        $this->select([
            'name' => 'divider_style',
            'label' => __('Style', 'mindverse'),
            'default' => 'solid',
            'options' => [
                'solid'  => __( 'Solid', 'mindverse' ),
                'dashed' => __( 'Dashed', 'mindverse' ),
                'dotted' => __( 'Dotted', 'mindverse' ),
                'double' => __( 'Double', 'mindverse' ),
                ''       => __( 'Custom', 'mindverse' ),
            ],
            'selectors' => [
                '{{WRAPPER}} .divider' => '--mv-border-style: {{VALUE}};'
            ]
        ]);
        $this->select([
            'name' => 'divider_custom_type',
            'label' => __('Custom Type', 'mindverse'),
            'default' => 'img',
            'options' => [
                'img'  => __( 'Image', 'mindverse' ),
                'svg' => __( 'SVG', 'mindverse' ),
            ],
            'condition' => [
                'divider_style' => ''
            ]
        ]);
        $this->media([
            'name' => 'divider_img',
            'label' => __('Choose Image', 'mindverse'),
            'condition' => [
                'divider_style' => '',
                'divider_custom_type' => 'img'
            ]
        ]);
        $this->icons([
            'name' => 'divider_svg',
            'label' => __('Choose SVG', 'mindverse'),
            'condition' => [
                'divider_custom_type' => 'svg'
            ]
        ]);
        $this->color([
            'name' => 'divider_color',
            'label' => __('Divider Color', 'mindverse'),
            'conditions' => [
                'relation' => 'or',
                'terms' => [
                    [
                        'name' => 'divider_style',
                        'operator' => '!==',
                        'value' => '',
                    ],
                    [
                        'name' => 'divider_custom_type',
                        'operator' => '===',
                        'value' => 'svg',
                    ],
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .divider' => '--mv-border-color: {{VALUE}};'
            ]
        ]);
        $this->slider([
            'name' => 'divider_weight',
            'label' => __('Divider Weight', 'mindverse'),
            'condition' => [
                'divider_style!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .divider.divider-horizontal' => '--mv-height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .divider.divider-vertical'   => '--mv-width: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }
}