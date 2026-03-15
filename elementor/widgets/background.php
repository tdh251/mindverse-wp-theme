<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use \Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Background extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_background',
            'title'      => __( 'MV Background', 'mindverse' ),
            'icon'       => 'eicon-background',
            'keywords'   => [ 'mv', 'mindverse', 'background', 'bg' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls 
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => 'Content' 
        ]);
        $this->group_background([
            'name' => 'background',
            'selector' => '{{WRAPPER}} .background',
        ]);
        $this->slider([
            'name' => 'background_width',
            'label' => __('Width', 'mindverse'),
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}} .background' => 'width: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->slider([
            'name' => 'background_height',
            'label' => __('Height', 'mindverse'),
            'selectors' => [
                '{{WRAPPER}} .background' => 'height: {{SIZE}}{{UNIT}};'
            ]
        ]);
        $this->end_controls_section();
    }

    /** Render */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="background">
            <div class="background-overlay"></div>
        </div>
        <?php
    }

    /** Content Template */
    protected function content_template() {
        ?>
        <div class="background"></div>
        <?php
    }
}