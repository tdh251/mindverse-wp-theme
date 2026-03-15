<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$post_id = $post->ID;

$thumbnail_id = get_post_thumbnail_id( $post_id );
$role = get_post_meta( $post_id, 'team_role', true );

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
$box_class = isset( $box_class ) ? ' '.$box_class : '';
?>

<div class="team<?php echo esc_attr($box_class); ?>">
    <div class="team-thumbnail image">
        <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
            <?php Elementor_Helpers::the_image_to_size($thumbnail_id, $img_width, $img_height, $img_attrs); ?>
        </a>
        <?php if( $show_socials == 'yes' ) : 
            $socials = get_post_meta($post_id, 'team_socials', true)['social_icon'] ?? [];
        ?>
            <?php if( !empty( $socials ) ) : ?>
                <div class="team-socials">
                    <?php foreach( $socials as $i => $social_icon ) : 
                        $social_link = $socials['social_link'][$i] ?? '#';    
                    ?>
                        <a href="<?php echo esc_url($social_link); ?>">
                            <?php Elementor_Helpers::the_svg_content( $social_icon['url'] ?? '' ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="team-content">
        <<?php echo esc_attr( $title_tag ); ?> class="team-title">
            <a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" 
            <?php if( isset( $title_hover_style ) ) : ?> data-hover="<?php echo esc_attr($title_hover_style); ?>" <?php endif; ?>
            <?php if( isset($title_hover_style) && $title_hover_style === 'text-flip-3d' ) : ?> data-text="<?php echo get_the_title( $post_id ); ?>" <?php endif; ?>>
                <span><?php echo get_the_title( $post_id ); ?></span>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
        <?php if( $show_role == 'yes' ) : ?>
            <div class="team-role">
                <?php echo esc_html( $role ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
