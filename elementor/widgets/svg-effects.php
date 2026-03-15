<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class SVG_Effects extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_svg_effects',
            'title'      => __( 'MV SVG Effects', 'mindverse' ),
            'icon'       => 'eicon-svg',
            'script'      => ['mindverse-effects'],
            'keywords'   => [ 'mv', 'mindverse', 'svg', 'image', 'img', 'effect', 'animation', 'icon'],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_svg_content_controls();
        $this->register_svg_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register SVG Content Controls
     */
    protected function register_svg_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->select([
            'name' => 'layout',
            'label' => __('Choose SVG', 'mindverse'),
            'options' => [
                '1' => __( 'SVG 1', 'mindverse' ),
                '2' => __( 'SVG 2', 'mindverse' ),
                '3' => __( 'SVG 3', 'mindverse' ),
                '4' => __( 'SVG 4', 'mindverse' ),
                '5' => __( 'SVG 5', 'mindverse' ),
                '6' => __( 'SVG 6', 'mindverse' ),
            ],
            'default' => '1',
        ]);
        $this->number([
            'name' => 'anim_duration',
            'label' => __('Animation Duration', 'mindverse'),
            'separator' => 'before',
            'default' => 5,
            'condition' => [
                'layout!' => ['6']
            ]
        ]);
        $this->media([
            'name' => 'img1',
            'label' => __('Choose Image 1', 'mindverse'),
            'default' => [
                'id' => 0,
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'layout' => ['4', '6', '3']
            ]
        ]);
        $this->media([
            'name' => 'img2',
            'label' => __('Choose Image 2', 'mindverse'),
            'default' => [
                'id' => 0,
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'layout' => ['4', '6']
            ]
        ]);
        $this->media([
            'name' => 'img3',
            'label' => __('Choose Image 3', 'mindverse'),
            'default' => [
                'id' => 0,
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'layout' => ['4', '6']
            ]
        ]);
        $this->media([
            'name' => 'img4',
            'label' => __('Choose Image 4', 'mindverse'),
            'default' => [
                'id' => 0,
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'condition' => [
                'layout' => ['4', '6']
            ]
        ]);
        $this->end_controls_section();
    }
    
    /**
     * Register SVG Style Controls
     */
    protected function register_svg_style_controls() {
        $this->start_style_section([ 
            'name' => 'style_section', 
            'label' => 'Style' 
        ]);
        $this->slider([
            'name' => 'svg_size',
            'label' => __('SVG Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);

        $this->slider([
            'name' => 'svg_size_w',
            'label' => __('SVG Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);

            $this->slider([
            'name' => 'svg_size_h',
            'label' => __('SVG Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);

        $this->color([
            'name' => 'line_color',
            'label' => __('Line Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => '--mv-line-color: {{VALUE}}',
            ]
        ]);
        $this->color([
            'name' => 'highlight_color',
            'label' => __('Highlight Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => '--mv-highlight-color: {{VALUE}}',
            ]
        ]);

        $this->color([
            'name' => 'svg_color',
            'label' => __('SVG Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => '--mv-primary-color: {{VALUE}}',
            ]
        ]);

        $this->color([
            'name' => 'color',
            'label' => __('Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => '--gradient-color: {{VALUE}}',
            ]
        ]);

        $this->color([
            'name' => 'color_2',
            'label' => __('Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} svg' => '--gradient-color-2: {{VALUE}}',
            ]
        ]);
        $this->end_controls_section();
    }
}