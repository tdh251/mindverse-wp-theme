<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Author extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_author',
            'title'      => __( 'MV Post Author', 'mindverse' ),
            'icon'       => 'eicon-user-circle-o',
            'keywords'   => [ 'mv', 'mindverse', 'author', 'post' ],
        ];
    }

    /**
     * Register All Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Style
        // Settings
        $this->register_custom_options_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'section_content', 
            'label' => __('Post Author', 'mindverse')
        ]);
        $this->title_tag([
            'name' => 'author_name_tag',
            'label' => __( 'Author Name HTML Tag', 'mindverse' ),
            'default' => 'h3',
        ]);
        $this->number([
            'name' => 'avatar_size',
            'label' => __( 'Avatar Size', 'mindverse' ),
            'default' => 133,
            'min' => 16,
            'max' => 512,
            'step' => 1,
            'description' => __( 'Set the size of the author avatar in pixels.', 'mindverse' ),
        ]);
        $this->end_controls_section();
    }
}