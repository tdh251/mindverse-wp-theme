<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$post_id = $post->ID;
$thumbnail_id = get_post_thumbnail_id( $post_id );

$img_attrs = [];
if( isset( $img_hover_style ) ) {
    $img_attrs['data-hover'] = $img_hover_style;
    if( $img_hover_style === 'parallax' ) {
        $img_attrs['data-parallax_settings'] = json_encode([
            'intensity' => 125,
            'scale'  => 1.15,
        ]);
    }
    if( isset( $displacement_img_url ) ) {
        $img_attrs['data-displacement'] = $displacement_img_url;
    }
}
$box_class = isset( $box_class ) ? $box_class : '';
?>

<div class="post<?php echo esc_attr($box_class); ?>">
    <div class="post-featured-image image">
        <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
            <?php Elementor_Helpers::the_image_to_size($thumbnail_id, $img_width, $img_height, $img_attrs); ?>
        </a>
    </div>
    <div class="post-content">
        <?php if( $show_date === 'yes' ) : ?>
            <div class="post-date"><?php echo get_the_date( $date_format, $post_id ); ?></div>
        <?php endif; ?>
        <<?php echo esc_attr( $title_tag ); ?> class="post-title">
            <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" 
            <?php if( isset( $title_hover_style ) ) : ?> data-hover="<?php echo esc_attr($title_hover_style); ?>" <?php endif; ?>
            <?php if( isset($title_hover_style) && $title_hover_style === 'text-flip-3d' ) : ?> data-text="<?php echo get_the_title( $post_id ); ?>" <?php endif; ?>>
                <span><?php echo get_the_title( $post_id ); ?></span>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
        <?php if( $show_excerpt === 'yes' ) : ?>
            <p class="post-excerpt">
                <?php echo wp_trim_words( $post->post_excerpt, $num_of_words, $more = null); ?>
            </p>
        <?php endif; ?>
        <?php if( $show_author === 'yes' ) : 
            $author_id = get_post_field( 'post_author', $post_id );
            $author_name = get_the_author_meta( 'display_name', $author_id );
            $author_url = get_author_posts_url( $author_id );    
        ?>
            <div class="post-author">
                <?php echo esc_html__( 'By', 'mindverse' ); ?>
                <a href="<?php echo esc_url( $author_url ); ?>">
                    <?php echo esc_html( $author_name ); ?>
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>
