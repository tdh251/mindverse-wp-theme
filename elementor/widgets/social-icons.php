<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Social_Icons extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_social_icons',
            'title'      => __( 'MV Social Icons', 'mindverse' ),
            'icon'       => 'eicon-social-icons',
            'keywords'   => [ 'mv', 'mindverse', 'social', 'icon' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_content_controls();
        $this->register_items_animation_controls();
        // Style
        $this->register_icon_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Socials', 'mindverse'),
            'fields' => [
                [
                    'name' => 'icon',
                    'label' => __('Icon', 'mindverse'),
                    'type' => 'icons',
                ],
                [
                    'name' => 'link',
                    'label' => __('Link', 'mindverse'),
                    'type' => 'url',
                    'default' => [
                        'url' => '#',
                    ]
                ],
                [
                    'name' => 'item_icon_size',
                    'label' => __('Icon Size', 'mindverse'),
                    'type' => 'slider',
                    'size_units' => [ 'px', 'custom' ],
                    'separator' => 'before',
                    'default' => [
                        'unit' => 'px'
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .social-item{{CURRENT_ITEM}}' => 'font-size: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .social-item{{CURRENT_ITEM}} svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                    ],
                ]
            ],
            'default' => [
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url('/uploads/2025/10/facebook.svg'),
                            'id'  => 1223,
                        ],
                        'library' => 'svg'
                    ],
                    'link' => [
                        'url' => '#',
                    ]
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url('/uploads/2025/10/youtube.svg'),
                            'id'  => 1226,
                        ],
                        'library' => 'svg'
                    ],
                    'link' => [
                        'url' => '#',
                    ]
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url('/uploads/2025/10/x.svg'),
                            'id'  => 1227,
                        ],
                        'library' => 'svg'
                    ],
                    'link' => [
                        'url' => '#',
                    ]
                ],
                [
                    'icon' => [
                        'value' => [
                            'url' => content_url('/uploads/2025/10/linkedin.svg'),
                            'id'  => 1224,
                        ],
                        'library' => 'svg'
                    ],
                    'link' => [
                        'url' => '#',
                    ]
                ],
            ]
        ]);
        $this->slider([
            'name' => 'item_spacing',
            'label' => __('Item Spacing', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .social-icons' => 'gap: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Icon Style Controls 
     */
    protected function register_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_icon_style',
            'label' => __('Icon', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'icon_font_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .social-item' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .social-item svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size_width',
            'separator' => 'before',
            'label' => __('Box Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .social-item' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'icon_box_size_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .social-item' => 'height: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .social-item' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .social-item',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .social-item',
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
                '{{WRAPPER}} .social-item:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .social-item:not(.box-gradient):hover,
                            {{WRAPPER}} .social-item.box-gradient:before',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .social-item:hover',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .social-item' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }
}