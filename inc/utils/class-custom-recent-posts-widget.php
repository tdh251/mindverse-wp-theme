<?php 
namespace Mindverse\Inc\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Recent Posts widgets
 * @package Case-Themes
 */

class Custom_Recent_Posts_Widget extends \WP_Widget {
    function __construct(){
        parent::__construct(
            'custom_recent_posts',
            esc_html__( 'Custom Recent Posts', 'mindverse' ),
            array(
                'description' => esc_html__( 'Your site’s most recent Posts.', 'mindverse' ),
                'customize_selective_refresh' => true,
            )
        );
    }

    function widget( $args, $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title'         => '',
            'number'        => 3,
        ) );

        $title = $instance['title'];
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo wp_kses_post($args['before_widget']);

        echo wp_kses_post($args['before_title']) . wp_kses_post($title) . wp_kses_post($args['after_title']);

        $number = absint( $instance['number'] ) ?: 3;
        
        $posts = mindverse()->post->get_posts([
            'posts_per_page' => $number,
            'post__not_in'  => [get_the_ID()]
        ])['posts'];       
        
        if( count($posts) !== 0 ) : ?>
            <div class="widget-content">
                <?php foreach( $posts as $i => $post ) : 
                    $featured_img_id = get_post_thumbnail_id( $post->ID );    
                ?>
                    <div class="post">
                        <div class="post-featured-image image">
                            <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                                <?php Helpers::the_image_to_size( $featured_img_id, 576, 384, ['data-hover' => 'zoomIn']); ?>
                            </a>
                        </div>
                        <div class="post-content">
                            <h6 class="post-title">
                                <a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
                                    <?php echo get_the_title( $post->ID ); ?>
                                </a>
                            </h6>
                            <div class="post-date">
                                <?php echo get_the_date( 'F d, Y' ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php
        else :
            echo '<p class="not-found">'.esc_html__('No Posts Found', 'mindverse').'</p>';
        endif;
        echo wp_kses_post($args['after_widget']);
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']         = sanitize_text_field( $new_instance['title'] );
        $instance['number']        = absint( $new_instance['number'] );
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title'         => esc_html__( 'Recent Posts', 'mindverse' ),
            'number'        => 4,
        ) );

        $title         = $instance['title'];
        $number        = absint( $instance['number'] );

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mindverse' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>


        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'mindverse' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" />
        </p>

        <?php
    }
}