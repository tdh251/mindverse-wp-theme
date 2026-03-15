<?php
namespace Mindverse\Elementor\Widgets;

use Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Contact_Form extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_contact_form',
            'title'      => __( 'MV Contact Form', 'mindverse' ),
            'icon'       => 'eicon-ehp-forms',
            'keywords'   => [ 'mv', 'mindverse', 'form', 'contact', 'contact-form-7', '7'],
        ];
    }

    protected function register_controls() {
        // Content
        $this->register_content_section();
        // Style
        $this->resgister_label_style_controls();
        $this->register_input_style_controls();
        $this->register_textarea_style_controls();
        $this->register_select_style_controls();
        $this->register_error_message_style_controls();
        $this->register_error_note_style_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_grid_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_section() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->select([
            'name'  => 'cf_id',
            'label' => __('Contact Form', 'mindverse'),
            'default' => '0',
            'options' => Elementor_Helpers::get_contact_form_options(),
        ]);
        // $this->text([
        //     'name'  => 'cf_html_id',
        //     'label' => __('HTML ID', 'mindverse'),
        //     'placeholder' => __('Ex: contact-form-123', 'mindverse'),
        // ]);
        $this->select([
            'name'  => 'cf_filed_style',
            'label' => __('Field Style', 'mindverse'),
            'separator' => 'before',
            'default' => '',
            'options' => [
                '' => __('Custom', 'mindverse'),
                '1' => __('Style 1', 'mindverse'),
                '2' => __('Style 2', 'mindverse'),
                '3' => __('Style 3', 'mindverse'),
                '4' => __('Style 4', 'mindverse'),
                '5' => __('Style 5', 'mindverse'),
                '6' => __('Style 6', 'mindverse'),
            ],
        ]);
        $this->end_controls_section();
    }

    /** Style label Section */
    protected function resgister_label_style_controls() {
        $this->start_style_section([
            'name' => 'section_label_style',
            'label' => __('Label', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'label_spacing',
            'label' => __('Label Spacing', 'mindverse'),
            'size_units' => [ 'px', 'custom' ],
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form label:not(:has(input)):not(.button-upload)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]);
        $this->group_typography([
            'name' => 'label_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form label:not(.button-upload), {{WRAPPER}} .wpcf7 form.wpcf7-form .label',
        ]);
        $this->color([
            'name' => 'label_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form label:not(.button-upload), {{WRAPPER}} .wpcf7 form.wpcf7-form .label' => 'color: {{VALUE}};',
            ]
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Input Style Controls
     */
    protected function register_input_style_controls() {
        $this->start_style_section([
            'name' => 'section_input_style', 
            'label' => __('Input', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'input_height',
            'label' => __('Field Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'input_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])',
        ]);
        $this->start_controls_tabs( 'input_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'input_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->color([
            'name' => 'input_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'input_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])',
        ]);
        // Group Style
        $this->group_style([
            'name' => 'input_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'input_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        $this->color([
            'name' => 'input_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):hover, {{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):focus' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'input_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):hover, {{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):focus',
		]);
        // Border Color 
        $this->color([
			'name' => 'input_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):hover, {{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):focus' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'input_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):hover, {{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"]):focus'
        ]);
        $this->duration([
            'name' => 'input_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form input:not([type="file"])' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Textarea Style Controls
     */
    protected function register_textarea_style_controls() {
        $this->start_style_section([
            'name' => 'section_textarea_style', 
            'label' => __('Texarea', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'textarea_height',
            'label' => __('Field Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'textarea_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea',
        ]);
        $this->start_controls_tabs( 'textarea_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'textarea_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->color([
            'name' => 'textarea_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'textarea_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea',
        ]);
        // Group Style
        $this->group_style([
            'name' => 'textarea_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'textarea_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        $this->color([
            'name' => 'textarea_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'textarea_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus',
		]);
        // Border Color 
        $this->color([
			'name' => 'textarea_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'textarea_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form textarea:focus'
        ]);
        $this->duration([
            'name' => 'textarea_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form textarea' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /** 
     * Register Select Style Controls
     */
    protected function register_select_style_controls() {
        $this->start_style_section([
            'name' => 'section_select_style', 
            'label' => __('Select', 'mindverse'),
        ]);
        $this->slider([
            'name' => 'select_height',
            'label' => __('Field Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->group_typography([
            'name' => 'select_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select',
        ]);
        $this->start_controls_tabs( 'select_tabs' );
        /** Normal Tab Style */
        $this->_start_controls_tab([
			'name' => 'select_normal_tab',
			'label' => __( 'Normal', 'mindverse' ),
		]);
        $this->color([
            'name' => 'select_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
            'name' => 'select_background',
            'types' => [ 'classic', 'gradient' ],
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select',
        ]);
        // Group Style
        $this->group_style([
            'name' => 'select_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select'
        ]);
        $this->end_controls_tab();


        /** Hover Tab Style */
        $this->_start_controls_tab([
			'name' => 'select_hover_tab',
			'label' => __( 'Hover', 'mindverse' ),
		]);
        $this->color([
            'name' => 'select_hover_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
                {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open' => 'color: {{VALUE}};',
            ]
        ]);
        // Background 
        $this->group_background([
			'name' => 'select_hover_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
            {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open',
		]);
        // Border Color 
        $this->color([
			'name' => 'select_hover_border_color',
			'label' => __( 'Border Color', 'mindverse' ),
			'selectors' => [
				'{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
                {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open' => 'border-color: {{VALUE}}',
			],
		]);
        $this->group_style([
            'name' => 'select_hover',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form select:focus,
            {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select:hover, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select.open'
        ]);
        $this->duration([
            'name' => 'select_transition_duration',
            'label' => __('Transition Duration', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form select, {{WRAPPER}} .wpcf7 form.wpcf7-form nice-select' => 'transition-duration: {{SIZE}}{{UNIT}};'
            ],
        ]);
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    /**
     * Register Error Mesagge Text Style
     */
    protected function register_error_message_style_controls() {
        $this->start_style_section([
            'name' => 'section_error_message_style',
            'label' => __('Error Message', 'mindverse'),
        ]);
        $this->color([
            'name' => 'error_message_color',
            'label' => __('Text Color', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_typography([
            'name' => 'error_message_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-not-valid-tip',
        ]);
        $this->end_controls_section();
    }


    /**
     * Register Error Mesagge Text Style
     */
    protected function register_error_note_style_controls() {
        $this->start_style_section([
            'name' => 'section_error_note_style',
            'label' => __('Error Note', 'mindverse'),
        ]);
        $this->group_typography([
            'name' => 'error_note_typography',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
        ]);
        $this->color([
            'name' => 'error_note_color',
            'label' => __('Text Color', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output' => 'color: {{VALUE}};',
            ]
        ]);
        $this->group_background([
			'name' => 'error_note_background',
			'types' => [ 'classic', 'gradient' ],
			'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
		]);
        $this->group_style([
            'name' => 'error_note_',
            'selector' => '{{WRAPPER}} .wpcf7 form.wpcf7-form .wpcf7-response-output',
        ]);
        $this->end_controls_section();
    }

    /** 
     * Register Grid Settings 
     */
    protected function register_grid_settings_controls() {
        $this->start_settings_section([ 
            'name' => 'section_grid_settings', 
            'label' => __('Grid', 'mindverse'),
        ]);
        $this->grid_controls_section();
        $this->end_controls_section();
    }
}