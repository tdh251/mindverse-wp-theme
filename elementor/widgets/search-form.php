<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Search_Form extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_search_form',
            'title'      => __( 'Search Form', 'mindverse' ),
            'icon'       => 'eicon-site-search',
            'keywords'   => [ 'mv', 'mindverse', 'search', 'form' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Layout
        $this->register_content_controls();
    }

    protected function register_content_controls() {
        $this->start_layout_section([ 
            'name' => 'seaction_content', 
            'label' => __('Content', 'mindverse') 
        ]);
        $this->select([
            'name' => 'template',
            'label' => __('Template', 'mindverse'),
            'default' => '',
            'options' => [
                '' => __('Default', 'mindverse'),
            ]
        ]);
        $this->end_controls_section();
    }
}