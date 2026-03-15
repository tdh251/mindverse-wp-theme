<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Partners extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_icons_grid',
            'title'      => __( 'Icons Grid', 'mindverse' ),
            'icon'       => 'eicon-carousel',
            'keywords'   => [ 'mv', 'mindverse', 'grid', 'icons', 'icon' ],
        ];
    }

    protected function register_controls() {
        $this->content_section();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    protected function content_section() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => 'Content' 
        ]);
        $this->repeater([
            'name' => 'items',
            'label' => __('Icons', 'mindverse'),
            'fields' => [
                [
                    'name'  => 'icon_type',
                    'label' => __('Icon Type', 'mindverse'),
                    'type'  => 'select',
                    'default' => 'icon',
                    'options' => [
                        'icon' => __('Icon', 'mindverse'),
                        'img'  => __('Image', 'mindverse'),
                    ] 
                ],
                [
                    'name' => 'icon',
                    'label' => __('Choose Icon', 'mindverse'),
                    'type' => 'icons',
                    'default' => [
                        'value' => 'fas fa-circle',
                        'library' => 'fa-solid',
                    ],
                    'condition' => [
                        'icon_type' => 'icon',
                    ]
                ],
                [
                    'name' => 'img',
                    'label' => __('Choose Image', 'mindverse'),
                    'type' => 'media',
                    'default' => [
                        'id' => 0,
                    ],
                    'condition' => [
                        'icon_type' => 'img',
                    ]
                ],
                [
                    'name' => 'link',
                    'label' => __("Link", 'mindverse'),
                    'type' => 'url',
                    'separator' => 'before',
                ],
            ],
        ]);
        $this->end_controls_section();
    }
}