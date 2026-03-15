<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Progress_Bar extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_progress_bar',
            'title'      => __( 'MV Progress Bar', 'mindverse' ),
            'icon'       => 'widget-icon',
            'script'     => ['mindverse-counter'],
            'keywords'   => [ 'mv', 'mindverse', 'progress', 'bar', 'progress bar' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        $this->register_content_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->number([
            'name' => 'percent',
            'label' => __('Percent', 'mindverse'),
            'min' => 0,
            'max' => 100,
            'default' => 50,
        ]);
        $this->text([
            'name' => 'title',
            'label' => __('Title', 'mindverse'),
        ]);
        $this->end_controls_section();
    }
}