<?php
use Mindverse\Inc\Utils\Helpers;

if( !is_single() ) {
    printf(
        '<div style="color:red; padding:10px; border:1px solid red;">Widget Only Available on Single Post Pages <code>%s</code></div>',
        esc_html( str_replace( get_template_directory(), '', $template ) )
    );
    return;
}

$post_id = get_the_ID();
$author_id = get_post_field( 'post_author', $post_id );
?>

<div class="post-meta">
    <div class="meta-item meta-author">
        <div class="author-avatar">
            <?php Helpers::the_avatar( $author_id, $settings['avatar_size'] ?: 96 ); ?>
        </div>
        <div class="author-name">
            <?php echo esc_html__('By ', 'mindverse'); ?>
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="author-link">
                <?php echo get_the_author_meta('display_name', $author_id); ?>
            </a>
        </div>
    </div>

    <div class="meta-item meta-date">
        <?php \Elementor\Icons_Manager::render_icon( $settings['date_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php echo get_the_date( '', $post_id ); ?>
    </div>

    <div class="meta-item meta-comment-count">
        <?php \Elementor\Icons_Manager::render_icon( $settings['comment_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php echo get_comments_number( $post_id ); ?>
    </div>

    <div class="meta-item meta-view-count">
        <?php \Elementor\Icons_Manager::render_icon( $settings['view_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php echo mindverse()->post->get_post_view( $post_id ); ?>
    </div>
</div>