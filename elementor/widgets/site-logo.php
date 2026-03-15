<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Site_Logo extends Mindverse_Widget_Base {
    protected function widget_info() {
        return [
            'name'       => 'mindverse_site_logo',
            'title'      => __( 'Site Logo', 'mindverse' ),
            'icon'       => 'eicon-site-logo',
            'keywords'   => [ 'site', 'logo', 'header', 'mindverse' ],
        ];
    }

    /**
     * Register Controls
     */
    protected function register_controls() {
        // Content
        $this->register_content_controls();
        // Settings
        $this->register_custom_options_settings_controls();
        $this->register_motion_effects_settings_controls();
    }

    /**
     * Register Content Controls
     */
    protected function register_content_controls() {
        $this->start_content_section([ 
            'name' => 'content_section', 
            'label' => __('Site Logo', 'mindverse')
        ]);
        $this->media([
            'name'  => 'img',
            'label' => __('Choose Logo', 'mindverse'),
            'default' => [
                'id' => 0,
            ],
        ]);
        $this->group_size([
            'name'  => 'logo',
            'label' => 'Image Size',
            'selector' => '{{WRAPPER}} .site-logo img'
        ]);
        $this->url([
            'name' => 'link',
            'separator' => 'before',
            'default' => [
                'url' => home_url(),
            ]
        ]);
        $this->end_controls_section();
    }

    /** Render */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);
        ?>
        <a class="site-logo" <?php pxl_print_html($link_attrs); ?>>
            <?php Elementor_Helpers::the_image_to_size($settings['img']['id']); ?>
        </a>
        <?php 
    }
}