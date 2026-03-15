<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$layout = $settings['layout'] ?? 1;

$query_args = [
    'post_type'      => $settings['post_type'],
    'posts_per_page' => $settings['posts_per_page'] ?: 6, 
    'orderby'        => $settings['orderby'],   
    'order'          => $settings['order'], 
];   

if( !empty( $settings['post_ids'] ) ) {
    $query_args['post__in'] = $settings['post_ids'];
}

extract( mindverse()->post->get_posts($query_args) );

if( count( $posts ) === 0 ) {
    echo '<div class="message">'.esc_html__('No Posts Found.', 'mindverse').'</div>';
    return;
}

$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image']['url'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image']['url'] ) ? ' box-gradient' : '';

$display_args = [
    'img_width'  => $settings['img_size']['width'] ?: null,
    'img_height' => $settings['img_size']['height'] ?: null,
    'title_tag'  => $settings['title_tag'] ?: 'h3',
    'show_role'  => $settings['show_role'],
    'show_socials' => $settings['show_socials'],
];

if( !empty( $settings['title_hover_style'] ) ) {
    $display_args['title_hover_style'] = $settings['title_hover_style'];
}

if( !empty( $settings['img_hover_style'] ) ) {
    $display_args['img_hover_style'] = $settings['img_hover_style'];
    if( $settings['img_hover_style'] === 'distortionTransition' ) {
        wp_enqueue_script('hoverjs');
        $display_args['displacement_img_url'] = content_url(
            'default-assets/displacement/' . $settings['img_displacement'] . '.webp'
        );
    }
}

if( !empty( $box_gradient_class ) ) {
    $display_args['box_class'] = $box_gradient_class;
}


$custom_settings = json_encode([ $query_args, $display_args ]);
?>

<div class="grid team-grid" data-settings="<?php echo esc_attr($custom_settings); ?>" data-layout="<?php echo esc_attr( $layout ); ?>">
    <div class="grid-inner">
        <?php foreach( $posts as $post ) : 
            $display_args['post'] = $post;    
        ?>
            <div class="grid-item">
                <?php Elementor_Helpers::get_template('/elementor/templates/content/team/layout-'.$layout, $display_args ); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if( $settings['grid_load_type'] === 'pagination' ) : ?>
        <?php mindverse()->layout->the_pagination( $query, true ); ?>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'load_more' ) : ?>
        <div class="grid-load-more ajax">
            <button class="button button-primary button-load-more" data-current-page="1">
                <span class="button-text"><?php echo esc_html__('Load More', 'mindverse'); ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>