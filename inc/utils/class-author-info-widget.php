<?php 
namespace Mindverse\Inc\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Recent Posts widgets
 * @package Case-Themes
 */

class Author_Info_Widget extends \WP_Widget {
    function __construct(){
        parent::__construct(
            'author_info',
            esc_html__( 'Author Info', 'mindverse' ),
            array(
                'description' => esc_html__( 'Author Info of post.', 'mindverse' ),
                'customize_selective_refresh' => true,
            )
        );
    }

    function widget( $args, $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title'         => '',
        ) );

        $title = $instance['title'];
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo wp_kses_post($args['before_widget']);

        echo wp_kses_post($args['before_title']) . wp_kses_post($title) . wp_kses_post($args['after_title']);

        $post_id = get_the_ID();

        $author_id = get_post_field( 'post_author', $post_id );
        $biography = get_the_author_meta( 'description', $author_id );

        $social_list = mindverse()->get_theme_option('user_social_name', []);
        ?>
        <div class="widget-content">
            <div class="author-avatar">
                <?php Helpers::the_avatar( $author_id, 'full' ); ?>
            </div>
            <?php if ( ! empty( $biography ) ) : ?>
                <div class="author-bio">
                    <?php echo wp_kses_post( $biography ); ?>
                </div>
            <?php endif; ?>
            <?php if( !empty( $social_list ) ) : 
                $social_icons = mindverse()->get_theme_option('user_social_icon', []);    
            ?>
                <div class="author-social-list">
                    <?php foreach ( $social_list as $i => $social ) : 
                        $id = sanitize_title($social); 
                        $meta_key = 'user_social_' . $id;
                        $social_url = get_the_author_meta( $meta_key, $author_id );
    
                        if ( ! empty( $social_url ) ) : ?>
                            <a href="<?php echo esc_url( $social_url ); ?>" class="author-social-link" target="_blank" rel="noopener noreferrer">
                                <?php Helpers::the_svg_content( $social_icons[$i]['url'] ?? '' ); ?>
                            </a>
                    <?php   
                        endif;
                    endforeach; 
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        echo wp_kses_post($args['after_widget']);
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']         = sanitize_text_field( $new_instance['title'] );
        return $instance;
    }

    function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array(
            'title'         => esc_html__( 'About Author', 'mindverse' ),
        ) );

        $title         = $instance['title'];

        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'mindverse' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <?php
    }
}