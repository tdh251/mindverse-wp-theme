<?php
use Mindverse\Inc\Utils\Helpers;

$post_id = get_the_ID();

$author_id = get_post_field( 'post_author', $post_id );
$biography = get_the_author_meta( 'description', $author_id );
$title_tag = $settings['author_name_tag'] ?: 'h3';

$social_list = mindverse()->get_theme_option('user_social_name', []);
?>

<div class="post-author">
    <div class="author-avatar">
        <?php Helpers::the_avatar( $author_id, $settings['avatar_size'] ?: 96 ); ?>
    </div>
    <div class="author-info">
        <<?php echo esc_attr( $title_tag ); ?> class="author-name">
            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" class="author-link">
                <?php echo get_the_author_meta('display_name', $author_id); ?>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
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
</div>