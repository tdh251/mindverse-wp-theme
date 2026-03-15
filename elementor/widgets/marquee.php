<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Marquee extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_marquee',
            'title'      => __( 'MV Marquee', 'mindverse' ),
            'icon'       => 'eicon-carousel',
            'script'     => ['marquee'],
            'keywords'   => [ 'mv', 'mindverse', 'img', 'image', 'marquee','slider', 'ma', 'quee' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_content_controls();
        $this->register_interactions_controls();
        // Style
        $this->register_box_style_controls();
        $this->register_image_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __( 'Content', 'mindverse' )
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Items', 'mindverse'),
            'fields' => [
                [
                    'name'  => 'type',
                    'label' => __('Type', 'mindverse'),
                    'type'  => 'select',
                    'default' => 'image',
                    'options' => [
                        'image' => __('Image', 'mindverse'),
                        'icon'  => __('Icon', 'mindverse'),
                        'text'  => __('Text', 'mindverse'),
                    ],
                ],
                [
                    'name' => 'img',
                    'label' => __('Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    'condition' => [
                        'type' => 'image',
                    ],
                ],
                [
                    'name'  => 'img_size',
                    'label' => esc_html__( 'Image Size', 'mindverse' ),
                    'type' => 'image_dimensions',
                    'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio. (Only apply this item)', 'mindverse' ),
                    'condition' => [
                        'type' => 'img',
                    ],
                ],
                [
                    'name' => 'icon',
                    'type' => 'icons',
                    'condition' => [
                        'type' => 'icon',
                    ],
                ],
                [
                    'name' => 'text',
                    'type' => 'wysiwyg',
                    'condition' => [
                        'type' => 'text',
                    ],
                ],
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                    'separator' => 'before',
                    'condition' => [
                        'type!' => 'text',
                    ],
                ],
            ],
        ]);
        $this->end_controls_section();
    }

    /** Interactions */
    protected function register_interactions_controls() {
        $this->start_content_section([ 
            'name' => 'section_interactions', 
            'label' => __('Interactions', 'mindverse'), 
        ]);
        $this->select([
            'name' => 'direction',
            'label' => __('Direction', 'mindverse'),
            'separator' => 'before',
            'default' => 'rtl',
            'options' => [
                'rtl' => __('Right to Left', 'mindverse'),
                'ltr' => __('Left to Right', 'mindverse'),
            ]
        ]);
        $this->switcher([
            'name' => 'pause_on_hover',
            'label' => __('Pause On Hover', 'mindverse'),
            'default' => '',
        ]);
        $this->number([
            'name' => 'marquee_anim_duration',
            'label' => __('Animation Duration(s)', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-inner' => '--mv-animation-duration: {{VALUE}}s;',
            ]
        ]);
        $this->slider([
            'name' => 'spacing',
            'label' => __('Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-inner' => '--mv-spacing-inline: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** Style Box */
    protected function register_box_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_box_style', 
            'label' => __('Box', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs( 'box_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'box_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .marquee-item',
		]);
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item',
        ]);
        // End Normal Tab
        $this->end_controls_tab();
        // Hover Tab
        $this->start_controls_tab( 'box_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );
        $this->group_background([
            'name' => 'box_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .marquee-item:not(.box-gradient):hover, {{WRAPPER}} .box-gradient:before',
		]);
        $this->group_style([
            'name' => 'box_hover_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item:hover',
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item, {{WRAPPER}} .box-gradient:before' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Style Image Section */
    protected function register_image_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_image_style', 
            'label' => __('Image', 'mindverse'),
        ]);
        $this->group_size([
            'label' => __('Image Size', 'mindverse'),
            'name' => 'img',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image img',
        ]);
        $this->group_size([
            'label' => __('Box Size', 'mindverse'),
            'name' => 'box_img',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image',
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
                    '{{WRAPPER}} .marquee .marquee-item-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_css_filter',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image img'
        ]);
        $this->group_style([
            'name' => 'img_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image'
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
                    '{{WRAPPER}} .marquee .marquee-item-image:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'img_hover_css_filter',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image:hover img'
        ]);
        $this->group_style([
            'name' => 'img_hover_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-image:hover'
        ]);
        $this->duration([
            'name' => 'img_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item-image' => 'transition-duration: {{SIZE}}{{UNIT}};'
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
            ]
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Style Icon Section */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item-icon' => 'font-size: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'svg_size',
            'label' => __('SVG Size', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->select([
            'name' => 'svg_fit',
            'label' => __('SVG Fit To', 'mindverse'),
            'default' => 'height',
            'options' => [
                ''       => __('Auto', 'mindverse'),
                'width'  => __('Width', 'mindverse'),
                'height' => __('Height', 'mindverse'),
            ],
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item-icon svg' => '{{VALUE}}: auto;'
            ],
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
                '{{WRAPPER}} .marquee .marquee-item-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .marquee-item-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-icon',
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
                '{{WRAPPER}} .marquee .marquee-item-icon:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .marquee .marquee-item-icon:hover',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .marquee .marquee-item-icon:hover',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /** Style Text Section */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __('Text', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .marquee .marquee-item',
        ]);
        $this->group_text_shadow([
            'name' => 'text_text_shadow',
            'selector' => '{{WRAPPER}} .marquee .marquee-item',
        ]);
        $this->start_controls_tabs(
            'text_style_tabs'
        );
        // Tab Normal
        $this->start_tab([
            'name' => 'text_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .marquee .marquee-item'
        ]);
        $this->end_controls_tab();
        // Tab Hover
        $this->start_tab([
            'name' => 'text_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->color([
            'name' => 'text_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .marquee .marquee-item:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_hover_stroke',
            'selector' => '{{WRAPPER}} .marquee .marquee-item:hover'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}
