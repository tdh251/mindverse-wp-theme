<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Text_Editor extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_text_editor',
            'title'      => __( 'MV Text Editor', 'mindverse' ),
            'icon'       => 'eicon-library-edit',
            'script'     => ['mindverse-animation'],
            'keywords'   => [ 'mv', 'mindverse', 'text', 'editor' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_main_content_controls();
        $this->register_highlight_content_controls();
        $this->register_group_highlight_style_controls();
        $this->register_text_style_controls();
        $this->register_link_style_controls();
        $this->register_motion_effects_settings_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_text_animation_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_main_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_main_content', 
            'label' => __('Text Editor', 'mindverse') 
        ]);
        $this->select([
            'name' => 'text_style',
            'label' => __('Text Style', 'mindverse'),
            'options' => [
                '' => __('Custom', 'mindverse'),
                'text-p1' => __('Text P1', 'mindverse'),
                'text-b2' => __('Text B2', 'mindverse'),
                'text-p2' => __('Text P2', 'mindverse'),
                'text-p4' => __('Text P4', 'mindverse'),
                'text-fin-p1' => __('Fin P1', 'mindverse'),
                'text-fin-p2' => __('Fin P2', 'mindverse'),
                'text-fin-p3' => __('Fin P3', 'mindverse'),
                'text-gradient' => __('Text Gradient', 'mindverse'),
                'text-gradient three-colors' => __('Text Gradient - 3 Colors', 'mindverse'),
                'box-bubble' => __('Box Bubble', 'mindverse'),
            ],
            'default' => '',
        ]);
        $this->switcher([
            'name' => 'auto_get_note_page',
            'label' => __('Get Note Page', 'mindverse'),
            'default' => ''
        ]);
        $this->text_editor([
            'name' => 'text',
            'condition' => [
                'auto_get_note_page!' => 'yes',
            ]
        ]);
        $this->text_alignment([
            'selectors' => [
                '{{WRAPPER}} .text-editor' => 'text-align: {{VALUE}}',
            ],
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Highlight Content Controls 
     */
    protected function register_highlight_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_highlight_content', 
            'label' => __('Highlight', 'mindverse') 
        ]);
        $this->highlight_content();
        $this->end_controls_section();
    }

    /**
     * Register Group Highlight Style Controls 
     */
    protected function register_group_highlight_style_controls() {
        $this->start_content_section([ 
            'name' => 'section_group_highlight_style', 
            'label' => __('Wrapper Highlight', 'mindverse') 
        ]);
        $this->group_highlight();
        $this->end_controls_section();
    }

    
    /**
     * Register Text Style Controls 
     */
    protected function register_text_style_controls() {
        $this->start_style_section([
            'name' => 'section_text_style',
            'label' => __('Text', 'mindverse'),
        ]);
        $this->group_background([
			'name' => 'title_fill',
			'selector' => '{{WRAPPER}} .text-editor > p',
			'fields_options' => [
				'background' => [
					'label' => __( 'Text Fill', 'mindverse' ),
				],				
				'color' => [
					'label' => __( 'Text Color', 'mindverse' ),
					'selectors' => [
						'{{WRAPPER}} .text-editor > p' => 'color: {{VALUE}};',
					],
				],
				'image' => [
					'selectors' => [
						'{{WRAPPER}} .text-editor > p' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
				'color_b' => [
					'selectors' => [
						'{{WRAPPER}} .text-editor > p' => '-webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
            'condition' => [
                'text_style' => 'text-gradient',
            ]
		]);
        $this->number([
            'name' => 'text_color_gradient_angle',
            'label' => __('Gradient Angle', 'mindverse'),
            'min' => -360,
            'max' => 360,
            'step' => 1,
            'selectors' => [
                '{{WRAPPER}} .text-editor' => '--mv-angle: {{VALUE}}deg;'
            ],
            'condition' => [
                'text_style' => ['text-gradient three-colors'],
            ]
        ]);
        $this->color([
            'name' => 'text_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .text-editor' => 'color: {{VALUE}}; --gradient-color: {{VALUE}};',
            ],
        ]);
        $this->color([
            'name' => 'text_color2_gradient',
            'label' => __('Text Color 2', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .text-editor' => '--gradient-color-2: {{VALUE}};'
            ],
            'condition' => [
                'text_style' => ['text-gradient three-colors'],
            ]
        ]);
        $this->color([
            'name' => 'text_color3_gradient',
            'label' => __('Text Color 3', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .text-editor' => '--gradient-color-3: {{VALUE}};'
            ],
            'condition' => [
                'text_style' => ['text-gradient three-colors'],
            ]
        ]);
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .text-editor',
        ]);
        $this->group_text_shadow([
            'name' => 'text_text_shadow',
            'selector' => '{{WRAPPER}} .text-editor',
        ]);
        $this->group_text_stroke([
            'name' => 'text_text_stroke',
            'selector' => '{{WRAPPER}} .text-editor',
        ]);
        $this->group_background([
			'name' => 'text_image',
			'selector' => '{{WRAPPER}} .text-editor > p',
            'types' => ['classic'],
            'exclude' => ['color'],
            'separator' => 'before',
			'fields_options' => [
                'background' => [
					'label' => __( 'Text Mask', 'mindverse' ),
				],
                'image' => [
					'selectors' => [
						'{{WRAPPER}} .text-editor > p' => 'background-image: url("{{URL}}"); -webkit-background-clip: text; background-clip: text; color: transparent;',
					],
				],
			],
		]);
        $this->group_background([
            'name' => 'text_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .text-editor',
		]);
        $this->group_style([
            'name' => 'text_',
            'selector' => '{{WRAPPER}} .text-editor',
        ]);
        $this->end_controls_section();
    }

    /**
     * Register Link Style Controls 
     */
    protected function register_link_style_controls() {
        $this->start_style_section([
            'name' => 'section_link_style',
            'label' => __('Link', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'link_typography',
            'selector' => '{{WRAPPER}} .text-editor a',
        ]);
        $this->start_controls_tabs( 'link_style_tabs' );
        // Normal Tab
        $this->start_controls_tab( 'link_style_normal_tab', 
            [ 
                'label' => __( 'Normal', 'mindverse' ) 
            ] 
        );
        $this->color([
            'name' => 'link_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .text-editor a' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab( 'link_style_hover_tab', 
            [ 
                'label' => __( 'Hover', 'mindverse' ) 
            ] 
        );  
        $this->color([
            'name' => 'link_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .text-editor a:hover' => 'color: {{VALUE}};',
            ]
        ]);
        $this->duration([
            'name' => 'link_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .text-editor a' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Animation Settings Controls 
     */
    protected function register_text_animation_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_text_animation_settings', 
            'label' => __('Text Animation', 'mindverse'), 
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
                'text_animation!' => ['', 'flyFlipX'],
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
                'text_animation!' => ['', 'flyFlipX'],
            ]
        ]);
        $this->number([
            'name' => 'stagger_each',
            'label' => __('Stagger Delay', 'mindverse'),
            'default' => 0.015,
            'min' => 0,
            'max' => 5,
            'step' => 0.0015,
            'condition' => [
                'text_animation!' => ['', 'flyFlipX'],
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
                'text_animation!' => '',
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
                'text_animation!' => '',
                'sync_scroll' => '0'
            ]
        ]);
        $this->end_controls_section();
    }
}