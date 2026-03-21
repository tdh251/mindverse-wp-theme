<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use \Elementor\Controls_Manager;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Heading extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_heading',
            'title'      => __( 'MV Heading', 'mindverse' ),
            'icon'       => 'eicon-heading',
            'script'     => ['SplitText', 'mindverse-animation', 'mindverse-effects'],
            'keywords'   => [ 'mv', 'mindverse', 'heading', 'title' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_subtitle_content_controls();
        $this->register_title_content_controls();
        $this->register_title_highlight_content_controls();
        $this->register_text_animation_content_controls();

        // Style
        $this->register_layout_style_controls();
        $this->register_title_style_controls();
        $this->register_title_underline_style_controls();
        $this->register_typing_style_controls();
        $this->resgister_subtitle_style_controls();
        $this->register_subtitle_highlight_style_controls();
        $this->register_subtitle_icon_style_controls();

        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /** Content Subtitle Section */
    protected function register_subtitle_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_subtitle_content', 
            'label' => __('Subtitle', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'subtitle_style',
            'label' => __('Subtitle Style', 'mindverse'),
            'options' => [
                'primary' => [
                    'title' => esc_attr__( 'Primary', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-primary.webp'),
                ],
                'secondary' => [
                    'title' => esc_attr__( 'Secondary', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-secondary.webp'),
                ],
                'style-1' => [
                    'title' => esc_attr__( 'Style 1', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-style-1.webp'),
                ],
                'style-2' => [
                    'title' => esc_attr__( 'Style 2', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-style-2.webp'),
                ],
                'style-3' => [
                    'title' => esc_attr__( 'Style 3', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-style-3.webp'),
                ],
                'style-4' => [
                    'title' => esc_attr__( 'Style 4', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-style-4.webp'),
                ],
                'style-5' => [
                    'title' => esc_attr__( 'Style 5', 'mindverse' ),
                    'image' => content_url('default-assets/layout/subtitle-style-5.webp'),
                ],
                '' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                ],
            ],
            'default' => 'primary',
        ]);
        $this->textarea([
            'name'  => 'subtitle',
            'label' => __('Subtitle', 'mindverse'),
            'separator' => 'before',
            'default' =>'Heading Subtitle',
            'rows' => 3,
        ]);
        $this->text([
            'name' => 'subtitle_highlight',
            'label' => __('Subtitle Highlight', 'mindverse'),
            'default' => __('Highlight', 'mindverse'),
            'condition' => [
                'subtitle_style' => ['secondary']
            ]
        ]);
        $this->icons([
            'name' => 'subtitle_icon',
            'label' => __('Subtitle Icon', 'mindverse'),
            'default' => []
        ]);      
        $this->end_controls_section();
    }

    /** Content Title Section */
    protected function register_title_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_title_content', 
            'label' => __('Title', 'mindverse') 
        ]);
        $this->visual_choice([
            'name' => 'title_style',
            'label' => __('Title Style', 'mindverse'),
            'options' => [
                'primary' => [
                    'title' => esc_attr__( 'Primary', 'mindverse' ),
                ],
                'secondary' => [
                    'title' => esc_attr__( 'Secondary', 'mindverse' ),
                ],
                'underline-highlight' => [
                    'title' => esc_attr__( 'Underline Highlight', 'mindverse' ),
                ],
                'gradient' => [
                    'title' => esc_attr__( 'Gradient Three Color', 'mindverse' ),
                ],
                'gradient four-colors' => [
                    'title' => esc_attr__( 'Gradient Four Colors', 'mindverse' ),
                ],
                '' => [
                    'title' => esc_attr__( 'Custom', 'mindverse' ),
                ],
            ],
            'default' => 'primary',
            'condition' => [
                'title!' => '',
            ]
        ]);
        $this->textarea([
            'name'  => 'title',
            'label' => __('Title', 'mindverse'),
            'default' =>'Enter Your Heading Title',
            'separator' => 'before',
            'description' => __('Create a highlight using the syntax [highlight]. Group them together using the structure [start] ... [end]', 'mindverse')
        ]);
        $this->title_tag([
            'name' => 'title_tag',
        ]);
        $this->url([
            'name' => 'link',
            'label' => __('Link URL', 'mindverse'),
            'separator' => 'before',
        ]);
        $this->select([
            'name' => 'title_effect',
            'label' => __('Title Effect', 'mindverse'),
            'default' => '',
            'options' => [
                ''       => __('None', 'mindverse'),
                'typing' => __('Typing', 'mindverse'),
                'typing-2' => __('Typing 2', 'mindverse'),
            ]
        ]);
        $this->repeater([
            'name' => 'texts',
            'label' => __('Texts', 'mindverse'),
            'condition' => [
                'title_effect' => ['typing', 'typing-2'],
            ],
            'fields' => [
                [
                    'name' => 'text',
                    'label' => __('Text', 'mindverse'),
                    'type' => 'text',
                    'label_block' => true,
                ]
            ],
            'default' => [
                ['text' => __('Text #1', 'mindverse')],
                ['text' => __('Text #2', 'mindverse')],
                ['text' => __('Text #3', 'mindverse')],
            ]
        ]);
        $this->end_controls_section();
    }

    /** Title Highlight Section */
    protected function register_title_highlight_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_title_highlight_content', 
            'label' => __('Title Highlight', 'mindverse') 
        ]);
        // Highlight Content
        $this->highlight_content();
        // Group Highlight Style
        $this->group_highlight();
        $this->end_controls_section();
    }

    /** Text Animation */
    protected function register_text_animation_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_animation_section', 
            'label' => __('Text Animation', 'mindverse')
        ]);
        $this->heading([
            'name' => 'title_animation_heading',
            'label' => __('Title Animation', 'mindverse'),
            'condition' => [
                'title!' => '',
            ]
        ]);
        $this->select([
            'name' => 'text_animation_lib',
            'label' => __('Animation Library', 'mindverse'),
            'default' => '',
            'options' => [
                '' => __('Default', 'mindverse'),
                'gsap' => __('Gsap', 'mindverse'),
            ]
        ]);
        // Title Animation
        $this->select([
            'name' => 'title_animation',
            'label' => __( 'Entrance Animation', 'mindverse' ),
            'groups' => Elementor_Helpers::entrance_animation_options(), 
            'default' => '', 
            'condition' => [
                'title!' => '',
                'text_animation_lib' => '',
            ]
        ]);
        $this->select([
            'name' => 'text_animation',
            'label' => __( 'Text Animation', 'mindverse' ),
            'options' => [
                ''             => __('None', 'mindverse'),
                'fadeIn'       => __('Fade In', 'mindverse'),
                'fadeInUp'     => __('Fade In Up', 'mindverse'),
                'fadeInRight'  => __('Fade In Right', 'mindverse'),
                'fadeInLeft'   => __('Fade In Left', 'mindverse'),
                'fadeInDown'   => __('Fade In Down', 'mindverse'),
                'fadeRotateInRight'  => __('Fade Rotate In Right', 'mindverse'),
                'slideUp'      => __('Slide Up', 'mindverse'),
                'slideDown'    => __('Slide Down', 'mindverse'),
                'flyFlipX'     => __('Fly Flip X', 'mindverse'),
                'flipX'        => __('Flip X', 'mindverse'),
                'flipY'        => __('Flip Y', 'mindverse'),
                'zigzagZoom'  => __('Zigzag Zoom', 'mindverse'),
            ],
            'default' => '', 
            'condition' => [
                'title!' => '',
                'text_animation_lib' => 'gsap',
            ]
        ]);
        $this->select([
            'name' => 'split_type',
            'label' => __( 'Split Type', 'mindverse' ),
            'options' => [
                'lines' => __('Lines', 'mindverse'),
                'words' => __('Words', 'mindverse'),
                'chars' => __('Characters', 'mindverse'),
            ],
            'default' => 'chars',
            'condition' => [
                'title!' => '',
                'text_animation!' => ['', 'flyFlipX'],
                'text_animation_lib' => 'gsap'
            ]
        ]);
        $this->select([
            'name' => 'animation_from',
            'label' => __( 'Animation From', 'mindverse' ),
            'default' => 'start',
            'options' => [
                'start' => __('Start', 'mindverse'),
                'center' => __('Center', 'mindverse'),
                'end' => __('End', 'mindverse'),
                'edges' => __('Edges', 'mindverse'),
                'random' => __('Random', 'mindverse'),
            ],
            'condition' => [
                'title!' => '',
                'text_animation!' => ['', 'flyFlipX'],
                'text_animation_lib' => 'gsap'
            ]
        ]);
        $this->number([
            'name' => 'stagger_each',
            'label' => __('Stagger Delay', 'mindverse'),
            'default' => 0.015,
            'min' => 0,
            'max' => 5,
            'step' => 0.01,
            'method' => 'add_control',
            'condition' => [
                'title!' => '',
                'text_animation!' => ['', 'flyFlipX'],
                'text_animation_lib' => 'gsap'
            ]
        ]);
        $this->select([
            'name' => 'sync_scroll',
            'label' => __('Sync Scroll', 'mindverse'),
            'default' => '0',
            'options' => [
                '1' => __('On', 'mindverse'),
                '0' => __('Off', 'mindverse'),
            ],
            'condition' => [
                'title!' => '',
                'text_animation!' => '',
                'text_animation_lib' => 'gsap'
            ]
        ]);
        $this->select([
            'name' => 'toggle_actions',
            'label' => __('Toggle Actions', 'mindverse'),
            'default' => 'none',
            'options' => [
                'none'    => __('None', 'mindverse'),
                'reverse' => __('Reverse', 'mindverse'),
            ],
            'condition' => [
                'title!' => '',
                'text_animation!' => '',
                'text_animation_lib' => 'gsap',
                'sync_scroll' => '0'
            ]
        ]);
        $this->duration([
            'name' => 'title_animation_duration',
            'label' => __('Animation Duration', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading-title.wow' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'title_animation!' => '',
                'title!' => '',
                'text_animation_lib' => '',
            ]
        ]);
        $this->duration([
            'name' => 'title_animation_delay',
            'label' => __('Animation Delay', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading-title.wow' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'title_animation!' => '',
                'title!' => '',
                'text_animation_lib' => '',
            ]
        ]);
        // Subtitle Animation
        $this->heading([
            'name' => 'subtitle_animation_heading',
            'label' => __('Subtitle Animation', 'mindverse'),
            'condition' => [
                'subtitle!' => '',
            ]
        ]);
        $this->select([
            'name' => 'subtitle_animation',
            'label' => __( 'Entrance Animtion', 'mindverse' ),
            'groups' => Elementor_Helpers::entrance_animation_options(),  
            'default' => '', 
            'condition' => [
                'subtitle!' => '',
            ]
        ]);
        $this->duration([
            'name' => 'subtitle_animation_duration',
            'label' => __('Animation Duration', 'mindverse'),
            'default' => [
                'size' => 1000,
                'unit' => 'ms',
            ],
            'selectors' => [
                '{{WRAPPER}} .heading-subtitle' => 'animation-duration: {{SIZE}}{{UNIT}}; -webkit-animation-duration: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'subtitle_animation!' => '',
                'subtitle!' => '',
            ]
        ]);
        $this->duration([
            'name' => 'subtitle_animation_delay',
            'label' => __('Animation Delay', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading-subtitle' => 'animation-delay: {{SIZE}}{{UNIT}}; -webkit-animation-delay: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'subtitle_animation!' => '',
                'subtitle!' => '',
            ]
        ]);
        $this->end_controls_section();
    }

    /** Style Layout Section */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'style_layout_section',
            'label' => __('Layout', 'mindverse'),
        ]); 
        $this->text_alignment([
            'selectors' => [
                '{{WRAPPER}} .heading' => 'text-align: {{VALUE}}',
            ],
        ]);
        $this->text_alignment([
            'name' => 'subtitle_',
            'label' => __('Subtitle Align', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'text-align: {{VALUE}}',
            ],
            'condition' => [
                'subtitle!' => ''
            ]
        ]);
        $this->choose([
            'name' => 'subtitle_position',
            'label' => __('Subtitle Position', 'mindverse'),
            'separator' => 'before',
            'options' => [
                'above' => [
                    'title' => __('Above', 'mindverse'),
                    'icon' => 'eicon-v-align-top',
                ],
                'below' => [
                    'title' => __('Below', 'mindverse'),
                    'icon' => 'eicon-v-align-bottom',
                ],
            ],
            'condition' => [
                'subtitle!' => '',
            ],
            'default' => 'above',
            'toggle' => false,
        ]);
        $this->choose([
            'name' => 'subtitle_icon_position',
            'label' => __( 'Subtitle Icon Position', 'mindverse' ),
            'options' => [
                'row-reverse' => [ 
                    'title' => __( 'Left', 'mindverse' ), 
                    'icon' => 'eicon-arrow-left'
                ],
                'row' => [ 
                    'title' => __( 'Right', 'mindverse' ), 
                    'icon' => 'eicon-arrow-right', 
                ],
            ],
            'condition' => [
                'subtitle_icon[value]!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'flex-direction: {{VALUE}};'
            ]
        ]);
        $this->slider([
            'name' => 'subtitle_title_gap',
            'label' => __('Subtitle Gap', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'gap: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->slider([
            'name' => 'subtitle_spacing_bottom',
            'label' => __('Subtitle Spacing', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};'
            ],
            'condition' => [
                'subtitle_position' => 'above',
                'subtitle!' => '',
            ],
        ]);
        $this->slider([
            'name' => 'subtitle_spacing_top',
            'label' => __('Subtitle Spacing', 'mindverse'),
            'default' => [
                'size' => 20,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: 0;'
            ],
            'condition' => [
                'subtitle_position' => 'below',
                'subtitle!' => '',
            ],
        ]);
        $this->dimensions([
            'name' => 'subtitle_icon_spacing',
            'label' => __('Subtitle Icon Margin', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);
        $this->dimensions([
            'name' => 'subtitle_hl_spacing',
            'label' => __('Subtitle Highlight Margin', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-highlight' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Style Title Section */
    protected function register_title_style_controls() {
        $this->start_style_section([
            'name' => 'style_title_section',
            'label' => __('Title', 'mindverse'),
            'condition' => [
                'title!' => '',
            ],
        ]);
        $this->number([
            'name' => 'title_gradient_angle',
            'label' => __('Gradient Angle', 'mindverse'),
            'min' => -360,
            'max' => 360,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title' => '--mv-angle: {{VALUE}}deg;'
            ],
            'condition' => [
                'title_style' => 'gradient',
            ]
        ]);
        $this->color([
            'name' => 'title_color_gradient',
            'label' => __('Color 1', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title' => '--gradient-color: {{VALUE}};'
            ],
            'condition' => [
                'title_style' => 'gradient',
            ]
        ]);
        $this->color([
            'name' => 'title_color2_gradient',
            'label' => __('Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title' => '--gradient-color-2: {{VALUE}};'
            ],
            'condition' => [
                'title_style' => 'gradient',
            ]
        ]);
        $this->color([
            'name' => 'title_color3_gradient',
            'label' => __('Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title' => '--gradient-color-3: {{VALUE}};'
            ],
            'condition' => [
                'title_style' => 'gradient',
            ]
        ]);
        $this->color([
            'name' => 'title__color',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'title_style!' => 'gradient',
            ]
        ]);
        $this->group_typography([
            'name' => 'title__typography',
            'selector' => '{{WRAPPER}} .heading .heading-title',
        ]);
        $this->group_text_shadow([
            'name' => 'title__text_shadow',
            'selector' => '{{WRAPPER}} .heading .heading-title',
        ]);
        $this->group_text_stroke([
            'name' => 'title__text_stroke',
            'selector' => '{{WRAPPER}} .heading .heading-title',
        ]);
        $this->end_controls_section();
    }

    /** Style Typing Section */
    protected function register_typing_style_controls() {
        $this->start_style_section([
            'name' => 'style_typing_section',
            'label' => __('Typing', 'mindverse'),
            'condition' => [
                'title_effect' => ['typing', 'typing-2'],
            ],
        ]);
        $this->group_typography([
            'name' => 'typing_typography',
            'selector' => '{{WRAPPER}} .heading .heading-title .highlight-typing',
        ]);
        $this->color([
            'name' => 'typing_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-title .highlight-typing' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'title_typing_fill',
			'selector' => '{{WRAPPER}} .heading .heading-title .highlight-typing',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .heading .heading-title .highlight-typing' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading-title .highlight-typing' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .heading .heading-title .highlight-typing' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->end_controls_section();
    }

    /** Style SubTitle Section */
    protected function resgister_subtitle_style_controls() {
        $this->start_style_section([
            'name' => 'section_subtitle_style',
            'label' => __('Subtitle', 'mindverse'),
            'condition' => [
                'subtitle!' => '',
            ],
        ]);
        $this->group_typography([
            'name' => 'subtitle_typography',
            'selector' => '{{WRAPPER}} .heading .heading-subtitle',
        ]);
        $this->color([
            'name' => 'subtitle_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'subtitle_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .heading .heading-subtitle',
		]);

        $this->group_style([
            'name' => 'subtitle_',
            'selector' => '{{WRAPPER}} .heading .heading-subtitle',
        ]);
        $this->end_controls_section();
    }

    /** Style SubTitle Highlight Section */
    protected function register_subtitle_highlight_style_controls() {
        $this->start_style_section([
            'name' => 'section_subtitle_highlight_style',
            'label' => __('Subtitle Highlight', 'mindverse'),
            'condition' => [
                'subtitle_highlight!' => '',
                'subtitle_style' => ['secondary']
            ],
        ]);
        $this->group_typography([
            'name' => 'subtitle_hl_typography',
            'selector' => '{{WRAPPER}} .heading .heading-subtitle',
        ]);
        $this->color([
            'name' => 'subtitle_hl_text_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-highlight' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'subtitle_hl_text_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .heading .heading-subtitle .subtitle-highlight',
		]);
        $this->group_style([
            'name' => 'subtitle_hl_text_',
            'selector' => '{{WRAPPER}} .heading .heading-subtitle .subtitle-highlight',
        ]);
        $this->end_controls_section();
    }

    /** Style Icon */
    protected function register_subtitle_icon_style_controls() {
        $this->start_style_section([
            'name' => 'section_subtitle_icon_style',
            'label' => __('Subtitle Icon', 'mindverse'),
            'condition' => [
                'subtitle_icon[value]!' => ''
            ]
        ]);
        $this->slider([
            'name' => 'subtitle_icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ],
        ]);
        $this->slider([
            'name' => 'subtitle_icon_box_width',
            'label' => __('Box Width', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'subtitle_icon_box_height',
            'label' => __('Box Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->color([
            'name' => 'subtitle_icon_color',
            'label' => __('Icon Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'subtitle_icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon',
		]);
        $this->group_style([
            'name' => 'subtitle_icon_',
            'selector' => '{{WRAPPER}} .heading .heading-subtitle .subtitle-icon',
        ]);

        $this->end_controls_section();
    }

        /** 
     * Register Box Style Controls 
    */
    protected function register_title_underline_style_controls() {
        $this->start_style_section([ 
            'name' => 'section_title_underline_style', 
            'label' => __('Title Underline', 'mindverse'),
            'condition' => [
                'title_style' => 'underline-highlight'
            ]
        ]);

        $this->start_controls_tabs( 'title_underline_style_tabs' );
        // Normal Tab
        $this->_start_controls_tab([ 
            'name' => 'title_underline_style_normal_tab',
            'label' => __( 'Normal', 'mindverse' ) 
        ]);
        $this->group_background([
            'name' => 'title_underline_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .heading-title.title-underline-highlight::after',
		]);
        $this->group_style([
            'name' => 'title_underline_',
            'selector' => '{{WRAPPER}} .heading-title.title-underline-highlight::after',
        ]);
        $this->end_controls_section();
    }
}