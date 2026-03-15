<?php
namespace Mindverse\Elementor\Widgets;

use \Mindverse\Elementor\Mindverse_Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}; 

class Post_Social_Share extends Mindverse_Widget_Base {

    protected function widget_info() {
        return [
            'name'       => 'mindverse_post_social_share',
            'title'      => __( 'MV Post Social Share', 'mindverse' ),
            'icon'       => 'eicon-featured-image',
            'keywords'   => [ 'mv', 'mindverse', 'social share', 'post' ],
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
            'label' => __('Post Social Share', 'mindverse')
        ]);
        $this->text([
            'name' => 'share_text',
            'label' => __('Share Text', 'mindverse'),
            'default' => __('Share:', 'mindverse'),
        ]);
        $this->select2([
            'name' => 'social_networks',
            'label' => __('Social Networks', 'mindverse'),
            'separator' => 'before',
            'options' => [
                'facebook'   => __('Facebook', 'mindverse'),
                'X'           => __('X', 'mindverse'),
                'linkedin'   => __('LinkedIn', 'mindverse'),
                'pinterest'  => __('Pinterest', 'mindverse'),
                'reddit'     => __('Reddit', 'mindverse'),
                'tumblr'     => __('Tumblr', 'mindverse'),
                'whatsapp'   => __('WhatsApp', 'mindverse'),
                'telegram'   => __('Telegram', 'mindverse'),
                'email'      => __('Email', 'mindverse'),
                'instagram'  => __('Instagram', 'mindverse'),
                'youtube'    => __('YouTube', 'mindverse'),
            ],
            'multiple' => true,
            'label_block' => true,
            'default' => [ 'facebook', 'instagram', 'linkedin', 'pinterest', 'youtube' ],
        ]);
        $this->url([
            'name' => 'instagram_url',
            'label' => __('Instagram Profile URL', 'mindverse'),
            'placeholder' => __('https://www.instagram.com/yourprofile', 'mindverse'),
            'default' => [
                'url' => 'https://www.instagram.com/',
            ],
            'condition' => [
                'social_networks' => 'instagram',
            ],
        ]);
        $this->url([
            'name' => 'youtube_url',
            'label' => __('YouTube Channel URL', 'mindverse'),
            'placeholder' => __('https://www.youtube.com/yourchannel', 'mindverse'),
            'default' => [
                'url' => 'https://www.youtube.com/',
            ],
            'condition' => [
                'social_networks' => 'youtube',
            ],
        ]);
        $this->end_controls_section();
    }

}