<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Icon_Text extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_icon_text',
            'title'      => __( 'MV Icon Text', 'mindverse' ),
            'icon'       => 'eicon-tel-field',
            'keywords'   => [ 'icon', 'i', 'text', 'icon text', 'mindverse', 'mindverse' ],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_icon_text_content_controls();
        // Style
        $this->register_layout_style_controls();
        $this->register_box_style_controls();
        $this->register_icon_style_controls();
        $this->register_text_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }
    /**  
     * Register Icon Text Content Controlss
    */
    protected function register_icon_text_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_icon_text_content', 
            'label' => __('Icon Text', 'mindverse'), 
        ]);
        $this->text([
            'name' => 'text',
            'default' => __('Lorem ipsum dolor', 'mindverse')
        ]);
        $this->icons([
            'name'      => 'icon',
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before'
        ]);
        $this->end_controls_section();
    }

    /**  
     * Register Layout Style Controls 
     */
    protected function register_layout_style_controls() {
        $this->start_style_section([
            'name' => 'section_layout_style', 
            'label' => __('Layout', 'mindverse'),
        ]);
        $this->flex_direction([
            'name' => 'icon_text',
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'flex-direction: {{VALUE}};',
            ]
        ]);
        $this->justify_content_horizontal([
            'name' => 'icon_text',
            'condition' => [
                'icon_text_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'justify-content: {{VALUE}};',
            ],
        ]);
        $this->justify_content_vertical([
            'name' => 'icon_text',
            'condition' => [
                'icon_text_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'justify-content: {{VALUE}};',
            ],
        ]);

        $this->align_items_horizontal([
            'name' => 'icon_text',
            'condition' => [
                'icon_text_flex_direction!' => ['column', 'column-reverse'],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->align_items_vertical([
            'name' => 'icon_text',
            'condition' => [
                'icon_text_flex_direction!' => ['row', 'row-reverse', ''],
            ],
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'align-items: {{VALUE}};',
            ],
        ]);
        $this->gap([
            'name' => 'icon_text',
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'gap: {{SIZE}}{{UNIT}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Box Style Controls 
     */
    protected function register_box_style_controls() {
        $this->start_style_section([
            'name' => 'section_box_style', 
            'label' => __('Box', 'mindverse'),
        ]);

        $this->start_controls_tabs( 'box_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'box_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        // Background 
        $this->group_background([
            'name' => 'box_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-text',
            'exclude' => ['image']
        ]);
        // Group Style
        $this->group_style([
            'name' => 'box_',
            'selector' => '{{WRAPPER}} .icon-text'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'box_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        // Background 
        $this->group_background([
			'name' => 'box_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .icon-text:hover',
		]);
        // Border Color 
        $this->color([
			'name' => 'box_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .icon-text:hover' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'box_hover',
            'selector' => '{{WRAPPER}} .icon-text:hover'
        ]);
        $this->duration([
            'name' => 'box_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-text' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();

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
        $this->slider([
            'name' => 'icon_size',
            'label' => __('Icon Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .icon-text .icon-text-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;'
            ],
        ]);
        $this->slider([
            'name' => 'icon_box_size',
            'label' => __('Box Size', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
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
                '{{WRAPPER}} .icon-text .icon-text-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-text .icon-text-icon',
		]);
        $this->group_style([
            'name' => 'icon_',
            'selector' => '{{WRAPPER}} .icon-text .icon-text-icon',
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
                '{{WRAPPER}} .icon-text:hover .icon-text-icon' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
            'name' => 'icon_hover_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .icon-text:hover .icon-text-icon',
		]);
        $this->group_style([
            'name' => 'icon_hover_',
            'selector' => '{{WRAPPER}} .icon-text:hover .icon-text-icon',
        ]);
        $this->duration([
            'name' => 'icon_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .icon-text .icon-text-icon' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        // End Hover Tab
        $this->end_controls_tab();
        $this->end_controls_tabs();
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
        $this->group_typography([
            'name' => 'text_typography',
            'selector' => '{{WRAPPER}} .icon-text .icon-text-text',
        ]);
        $this->group_text_shadow([
            'name' => 'text_shadow',
            'selector' => '{{WRAPPER}} .icon-text .icon-text-text',
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
                '{{WRAPPER}} .icon-text .icon-text-text' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_stroke',
            'selector' => '{{WRAPPER}} .icon-text .icon-text-text'
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
                '{{WRAPPER}} .icon-text .icon-text-text:hover' => 'color: {{VALUE}};'
            ]
        ]);
        $this->group_text_stroke([
            'name' => 'text_hover_stroke',
            'selector' => '{{WRAPPER}} .icon-text .icon-text-text:hover'
        ]);
        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** Editor Preview Content */
    protected function content_template() {
        ?>
        <#
            const iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
        #>
        <div class="icon-text">
            <span class="icon-text-icon">
                {{{ iconHTML.value }}}
            </span>
            <a href="{{ settings.link.url }}" class="icon-text-text">
                {{ settings.text }}
            </a>
        </div>
        <?php
    }
}