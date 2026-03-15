<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Image extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_image',
            'title'      => __( 'MV Image', 'mindverse' ),
            'icon'       => 'eicon-image',
            'script'     => ['ogl' ,'mindverse-interactions', 'mindverse-effects', 'mindverse-scrolling'],
            'keywords'   => [ 'mv', 'mindverse', 'img', 'image' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_image_content_controls();
        $this->register_loop_animation_content_controls();
        // Style
        $this->register_image_style_controls();
        $this->register_overlay_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Image Content Controls
     */
    protected function register_image_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_image_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        // $this->switcher([
        //     'name' => 'enable_move_on',
        //     'label' => __('Enable Move On', 'mindverse'),
        //     'default' => '',
        // ]);
        // $this->text([
        //     'name' => 'target',
        //     'label' => __('Target', 'mindverse'),
        //     'type' => 'text',
        //     'condition' => [
        //         'enable_move_on' => 'yes'
        //     ]
        // ]);
        // $this->text([
        //     'name' => 'html_id',
        //     'label' => __('HTML ID', 'mindverse'),
        //     'label_block' => false,
        //     'placeholder' => __('eg: name-id', 'mindverse')
        // ]);
        // $this->repeater([
        //     'name' => 'move_on_settings',
        //     'label' => __('Move On Settings', 'mindverse'),
        //     'fields' => [
        //         [
        //             'name' => 'target',
        //             'label' => __('Target', 'mindverse'),
        //             'type' => 'text'
        //         ],
        //         [
        //             'name' => 'scale',
        //             'label' => __('Scale', 'mindverse'),
        //             'type' => 'number',
        //             'min' => 0,
        //             'step' => 0.05,
        //         ],
        //         [
        //             'name' => 'flipX',
        //             'label' => __('FlipX', 'mindverse'),
        //             'type' => 'switcher',
        //             'default' => ''
        //         ]
        //     ]
        // ]);
        $this->media([
            'name' => 'img',
            'label' => __('Choose Image', 'mindverse'),
            'default' => [
                'id' => 0,
            ]
        ]);
        $this->image_size([
            'name'      => 'img_size',
            'separator' => 'before',
            'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before',
        ]);
        $this->text_alignment([
            'separator' => 'before',
            'label' => __('Image Alignment', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}}',
            ],
        ]);
        $this->switcher([
            'name' => 'show_overlay',
            'label' => __('Show Overlay', 'mindverse'),
            'default' => '',
        ]);
        $this->select([
            'name' => 'img_effects',
            'label' => __('Effects', 'mindverse'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                '' => __('None', 'mindverse'),
                'random-transition' => __('Random Transition', 'mindverse'),
            ]
        ]);
        $this->repeater([
            'name' => 'imgs',
            'label' => __('Images', 'mindverse'),
            'condition' => [
                'img_effects' => 'random-transition',
            ],
            'fields' => [
                [
                    'name' => 'item_img',
                    'label' => __('Choose Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                    ],
                ],
                [
                    'name' => 'item_link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                    'separator' => 'before',
                ],
            ],
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
                'flowmapDeformation' => __('Flowmap Deformation', 'mindverse'),
                'flowmapDeformation2' => __('Flowmap Deformation 2', 'mindverse'),
            ]
        ]);
        $this->text([
            'name' => 'hover_trigger',
            'label' => __('Trigger', 'mindverse'),
            'placeholder' => __('eg: #trigger-id', 'mindverse'),
            'label_block' => false,
            'condition' => [
                'img_hover_style' => ['flowmapDeformation', 'flowmapDeformation2'],
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

    /**
     * Register Image Overlay Style Controls
     */
    protected function register_overlay_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_overlay_style', 
            'label' => __('Overlay', 'mindverse'),
            'condition' => [
                'show_overlay' => 'yes'
            ]
        ]);
        $this->group_size([
            'label' => __('Overlay', 'mindverse'),
            'name' => 'overlay',
            'selector' => '{{WRAPPER}} .image .overlay',
        ]);
        $this->slider([
            'name' => 'overlay_offset_top',
            'label' => __('Top', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .image .overlay' => 'top: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'overlay_offset_right',
            'label' => __('Right', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image .overlay' => 'right: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'overlay_offset_bottom',
            'label' => __('Bottom', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image .overlay' => 'bottom: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'overlay_offset_left',
            'label' => __('Left', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .image .overlay' => 'left: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->start_controls_tabs('overlay_styles');
        // Normal
        $this->_start_controls_tab([
            'name' => 'overlay_tab_normal',
            'label' => __('Normal', 'mindverse'),
        ]);
        $this->slider([
                'name' => 'overlay_opacity',
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
                    '{{WRAPPER}} .image .overlay' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->group_css_filter([
            'name' => 'overlay_css_filter',
            'selector' => '{{WRAPPER}} .image .overlay'
        ]);
        $this->group_background([
            'name' => 'overlay_background',
            'selector' => '{{WRAPPER}} .image .overlay'
        ]);
        $this->end_controls_tab();

        // Hover
        $this->_start_controls_tab([
            'name' => 'overlay_tab_hover',
            'label' => __('Hover', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'overlay_hover_opacity',
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
                '{{WRAPPER}} .image:hover .overlay' => 'opacity: {{SIZE}};',
            ],
        ]);
        $this->group_css_filter([
            'name' => 'overlay_hover_css_filter',
            'selector' => '{{WRAPPER}} .image:hover .overlay'
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
}