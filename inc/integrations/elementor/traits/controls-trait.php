<?php
/**
 * Trait contains helper functions to create Elementor controls faster.
 */
namespace Mindverse\Inc\Integrations\Elementor\Traits;

use \Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

trait Controls_Trait {
    /**
     * Register helpers function 
     * Use with control group name = name + group_control_name
     */
    protected function _register_control_helper( $elementor_method, $args, $defaults, $caller_function_name, $name_suffix = '' ) {
    
        if ( ! Elementor_Helpers::validate_control_name($args, $caller_function_name) ) {
            return;
        }

        $prefix_name = $args['name']; 
        $elementor_method = isset($args['method']) && !empty($args['method']) ? $args['method'] : $elementor_method;

        if($elementor_method !== 'add_group_control') {
            unset($args['name']); 

            $final_control_name = $prefix_name . $name_suffix;
            
            $this->{$elementor_method}(
                $final_control_name, 
                array_merge($defaults, $args) 
            );
            return;
        }
        
        if ( empty($args['type']) ) {
            trigger_error('Args for _register_control_helper (group control) must include a "type" key.', E_USER_WARNING);
            return;
        }

        $control_type = $args['type']; 
        unset($args['type']);         
        
        $args['name'] = $prefix_name . $name_suffix;

        
        $this->{$elementor_method}(
            $control_type, 
            array_merge($defaults, $args)
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_CONTENT section
     */
    protected function start_content_section($args = []) {
        $defaults = [
            'tab' => Controls_Manager::TAB_CONTENT,
        ];
        
        $this->_register_control_helper(
            'start_controls_section', // Elementor function name
            $args,                    // The arguments
            $defaults,                // Default
            __FUNCTION__              // This function (start_content_section)
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_STYLE section
     */
    protected function start_style_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_STYLE,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_SETTINGS section
     */
    protected function start_settings_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_SETTINGS,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_LAYOUT section
     */
    protected function start_layout_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_LAYOUT,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start \Controls_Manager::TAB_ADVANCED section
     */
    protected function start_advanced_section( $args = [] ) {
        $defaults = [
            'tab' => Controls_Manager::TAB_ADVANCED,
        ];

        $this->_register_control_helper(
            'start_controls_section', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start control tab
     */
    public function start_tab( $args = [] ) {
        $defaults = [];

        $this->_register_control_helper(
            'start_controls_tab', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick start controls tab normal
     */
    public function _start_controls_tab( $args = [] ) {
        $defaults = [
            'label' => __('Tab', 'mindverse')
        ];

        $this->_register_control_helper(
            'start_controls_tab', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick heading control 
     */
    protected function heading( $args = [] ) {
        $defaults = [
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,                    
            $defaults,                
            __FUNCTION__    
        );
    }

    /**
     * Quick icon control
     */
    protected function icons($args = []) { 
        $defaults = [
            'label' => __( 'Icon', 'mindverse' ), 
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-circle',
                'library' => 'fa-solid',
            ],
        ];

        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Quick slider control
     */
    protected function slider( $args = [] ) {
        $defaults = [
            'label' => __( 'Slider', 'mindverse' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'custom' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1000,
                ],
            ],
            'default' => [
                'unit' => 'px',
            ],
        ];

        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Quick divider
     */
    protected function divider( $args = [] ) {
        $defaults = [
            'type' => Controls_Manager::DIVIDER,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick color style
     */
    protected function color( $args = [] ) {
        $defaults = [
            'label' => __( 'Color', 'mindverse' ),
            'type' => Controls_Manager::COLOR,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick dimension control
     */
    protected function dimensions( $args = [] ) {
        $defaults = [
            'label' => __( 'Dimension', 'mindverse' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'custom' ],
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick media control
     */
    protected function media( $args = [] ) {
        $defaults = [
            'label' => __( 'Media', 'mindverse' ),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick link url
     */
    protected function url($args = []) {
        $defaults = [
            'label' => __( 'Link', 'mindverse' ),
            'type' => Controls_Manager::URL,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick text control
     */
    protected function text( $args = [] ) {
        $defaults = [
            'label' => __( 'Text', 'mindverse' ),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick Select Controls
     */
    protected function select( $args = [] ) {
        $defaults = [
            'label' => __( 'Select', 'mindverse' ),
            'type' => Controls_Manager::SELECT,
            'render_type' => 'template',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick Select2 Controls
     */
    protected function select2( $args = [] ) {
        $defaults = [
            'label' => __( 'Select 2', 'mindverse' ),
            'type' => Controls_Manager::SELECT2,
            'render_type' => 'template',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick textare control 
     */
    protected function textarea($args = []) {
        $defaults = [
            'label' => __( 'Textarea', 'mindverse' ),
            'type' => Controls_Manager::TEXTAREA,
            'placeholder' => __( 'Type your here', 'mindverse' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick choose control
     */
    protected function choose($args = []) {
        $defaults = [
            'label' => __( 'Choose', 'mindverse' ),
            'type' => Controls_Manager::CHOOSE,
            'toggle' => true,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick popover_
     */
    protected function popover_toggle( $args = [] ) {
        $defaults = [
            'label' => __( 'Popover Toggle', 'mindverse' ),
            'type' => 'popover_toggle',
            'return_value' => 'yes',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick text editor
     */
    protected function text_editor( $args = [] ) {
        $defaults = [
            'label' => __( 'Text Editor', 'mindverse' ),
            'type' => 'wysiwyg',
            'placeholder' => esc_html__( 'Type your description here!', 'mindverse' ),
            'default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc sit amet risus fermentum pharetra non in elit.', 'mindverse'),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Repeater
     */
    protected function repeater( $args = [] ) {
        $defaults = [
            'label' => __( 'Repeater', 'mindverse' ),
            'type' => 'repeater',
            'prevent_empty' => false,
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * 
     */
    protected function image_size( $args = [] ) {
        $defaults = [
            'type' => 'image_dimensions',
            'label' => __( 'Image Size', 'mindverse' ),
            'label_block' => true,
            // 'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'mindverse' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    protected function switcher( $args = [] ) {
        $defaults = [
            'type' => 'switcher',
            'label' => __( 'Switcher', 'mindverse' ),
            'default' => '',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    } 

    protected function number( $args = [] ) {
        $defaults = [
            'type' => 'number',
            'label' => __( 'Number', 'mindverse' ),
        ];
        $this->_register_control_helper(
            'add_responsive_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    } 

    /**
     * Visual Choice
     */
    protected function visual_choice( $args = [] ) {
        $defaults = [
            'type' => 'visual_choice',
            'label' => __( 'Visual Choice', 'mindverse' ),
            'label_block' => true,
            'columns' => 2,
            'toggle' => false
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__
        );
    }

    /**
     * Visual Choice
     */
    protected function hidden( $args = [] ) {
        $defaults = [
            'type' => 'hidden',
            'label' => __( 'Hiddden', 'mindverse' ),
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Back drop filter
     */
    protected function backdrop_filter( $args = [] ) {
        $defaults = [
            'label' => __( 'Backdrop Filter(px)', 'mindverse' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => 'px',
            ],
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Quick Title Tag Option
     */
    protected function title_tag( $args = [] ) {
        $defaults = [
            'label' => __( 'Title HTML Tag', 'mindverse' ),
            'type' => Controls_Manager::SELECT,
            'render_type' => 'template',
            'options' => [
                ''    => __( 'Default', 'mindverse' ),
                'h1'  => __( 'H1', 'mindverse' ),
                'h2'  => __( 'H2', 'mindverse' ),
                'h3'  => __( 'H3', 'mindverse' ),
                'h4'  => __( 'H4', 'mindverse' ),
                'h5'  => __( 'H5', 'mindverse' ),
                'h6'  => __( 'H6', 'mindverse' ),
                'p'   => __( 'Paragraph (p)', 'mindverse' ),
                'div' => __( 'Div', 'mindverse' ),
                'span'=> __( 'Span', 'mindverse' ),
            ],
            'default' => 'h2',
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * Opacity
     */
    protected function opacity( $args = [] ) {
        $defaults = [
            'label' => __( 'Opacity', 'mindverse' ),
            'type' => Controls_Manager::SLIDER,
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
        ];
        $this->_register_control_helper(
            'add_control', 
            $args,
            $defaults,
            __FUNCTION__,
        );
    }

    /**
     * 
     */
    protected function choose_displacement( $args = [] ) {
        $this->visual_choice(
            array_merge(
                [
                    'name' => 'img_displacement',
                    'label' => __('Displacement', 'mindverse'),
                    'columns' => 3,
                    'toggle' => false,
                    'options' => [
                        '1' => [
                            'title' => esc_attr__( '1', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/1.webp'),
                        ],
                        '2' => [
                            'title' => esc_attr__( '2', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/2.webp'),
                        ],
                        '3' => [
                            'title' => esc_attr__( '3', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/3.webp'),
                        ],
                        '4' => [
                            'title' => esc_attr__( '4', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/4.webp'),
                        ],
                        '5' => [
                            'title' => esc_attr__( '5', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/5.webp'),
                        ],
                        '6' => [
                            'title' => esc_attr__( '6', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/6.webp'),
                        ],
                        '7' => [
                            'title' => esc_attr__( '7', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/7.webp'),
                        ],
                        '8' => [
                            'title' => esc_attr__( '8', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/8.webp'),
                        ],
                        '9' => [
                            'title' => esc_attr__( '9', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/9.webp'),
                        ],
                        '10' => [
                            'title' => esc_attr__( '10', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/10.webp'),
                        ],
                        '11' => [
                            'title' => esc_attr__( '11', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/11.webp'),
                        ],
                        '12' => [
                            'title' => esc_attr__( '12', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/12.webp'),
                        ],
                        '13' => [
                            'title' => esc_attr__( '13', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/13.webp'),
                        ],
                        '14' => [
                            'title' => esc_attr__( '14', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/14.webp'),
                        ],
                        '15' => [
                            'title' => esc_attr__( '14', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/15.webp'),
                        ],
                        '15' => [
                            'title' => esc_attr__( '14', 'mindverse' ),
                            'image' => content_url('/uploads/default-assets/displacement/16.webp'),
                        ],
                    ],
                    'default' => '13',
                ],
                $args
            )
        );
    }
}