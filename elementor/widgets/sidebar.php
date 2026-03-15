<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Utils\Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Sidebar extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_sidebar',
            'title'      => __( 'MV Sidebar', 'mindverse' ),
            'icon'       => 'eicon-sidebar',
            'keywords'   => [ 'mv', 'mindverse', 'sidebar' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_sidebar_content_controls();
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Sidebar Content Controls
     */
    protected function register_sidebar_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_sidebar_content', 
            'label' => __('Sidebar', 'mindverse') 
        ]);
        $this->select([
            'name' => 'sidebar',
            'label' => __('Choose Sidebar', 'mindverse'),
            'default' => '',
            'options' => Helpers::get_sidebar_option(),
        ]);
        $this->end_controls_section();
    }
}