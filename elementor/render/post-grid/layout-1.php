<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$layout = $settings['layout'] ?? 1;
$layout_style = $settings['layout1_style'] ?? '';
$post_type = $settings['post_type'] ?? 'post';
$post_ids = $settings[$post_type.'_ids'] ?? [];
$cat_ids = $settings[$post_type.'_categories'] ?? [];

$query_args = [
    'post_type'      => $post_type,
    'posts_per_page' => $settings['posts_per_page'] ?: 6, 
    'orderby'        => $settings['orderby'],   
    'order'          => $settings['order'], 
];   

if( !empty( $post_ids ) ) {
    $query_args['post__in'] = $post_ids;
}

if( !empty( $cat_ids ) ) {
    // $query_args['category__in'] = $cat_ids;
    $query_args['tax_query'] = [
        [
            'taxonomy' => ( $post_type === 'post' ) ?  'category' :  $post_type . '_category',
            'field'    => 'id',
            'terms'    => $cat_ids,
            'operator' => 'IN',
        ]
    ];
}

extract( mindverse()->post->get_posts( $query_args ) );  // Return $posts and $query

if( count( $posts ) === 0 ) {
    echo '<div class="message">'.esc_html__('No Posts Found.', 'mindverse').'</div>';
    return;
}

$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image']['url'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image']['url'] ) ? ' box-gradient' : '';

$display_args = [
    'post_type' => $post_type,
    'img_width'  => $settings['img_size']['width'] ?: null,
    'img_height' => $settings['img_size']['height'] ?: null,
    'title_tag'  => $settings['title_tag'] ?: 'h3',
    'show_date'  => $settings['show_date'],
    'date_format' => $settings['date_format'] ?: 'd M, Y',
    'show_excerpt' => $settings['show_excerpt'],
    'num_of_words' => $settings['num_of_words'] ?: 10,
    'show_author' => $settings['show_author'],
];

if( !empty( $settings['title_hover_style'] ) ) {
    $display_args['title_hover_style'] = $settings['title_hover_style'];
}

if( !empty( $settings['img_hover_style'] ) ) {
    $display_args['img_hover_style'] = $settings['img_hover_style'];
    if( $settings['img_hover_style'] === 'distortionTransition' ) {
        wp_enqueue_script('hoverjs');
        $display_args['displacement_img_url'] = content_url(
            '/uploads/default-assets/displacement/' . $settings['img_displacement'] . '.webp'
        );
    }
}

if( !empty( $box_gradient_class ) ) {
    $display_args['box_class'] = $box_gradient_class;
}

$custom_settings = json_encode([ $query_args, $display_args ]);

$wrapper_attrs = [
    'id'    => $settings['html_id'],
    'class' => 'grid post-grid is-post-type-'.$post_type,
    'data-settings' => $custom_settings,
    'data-layout'   => $layout,
    'data-layout_style' => $layout_style
];

$this->add_render_attribute('grid_wrapper', $wrapper_attrs);

?>

<div <?php pxl_print_html( $this->get_render_attribute_string('grid_wrapper') ); ?>>
    <div class="grid-inner">
        <?php foreach( $posts as $post ) : 
            $display_args['post'] = $post;    
        ?>
            <div class="grid-item">
                <?php Elementor_Helpers::get_template('/elementor/templates/content/post/layout-'.$layout, $display_args ); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if( $settings['grid_load_type'] === 'pagination' && !is_home() && !is_archive() && !is_search()  ) : ?>
        <?php mindverse()->layout->the_pagination( $query, true ); ?>
    <?php endif; ?>
    <?php if( $settings['grid_load_type'] === 'load_more' && !is_home() && !is_archive() && !is_search() ) : ?>
        <div class="grid-load-more ajax">
            <button class="button button-primary button-load-more" data-current-page="1">
                <span class="button-text"><?php echo esc_html__('Load More', 'mindverse'); ?></span>
            </button>
        </div>
    <?php endif; ?>
</div>