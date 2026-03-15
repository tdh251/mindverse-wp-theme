<?php
$post_type = $settings['post_type'] ?? 'post';
$cat_ids = $settings[$post_type.'_categories'] ?? [];

$taxonomy = ($post_type === 'post') ? 'category' : $post_type . '_category';

if ( empty($cat_ids) || !is_array($cat_ids) ) {
    $terms = get_terms( array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => true, 
    ) );
} else {
    $terms = [];
    foreach ( $cat_ids as $cat_id ) {
        $term = get_term( $cat_id, $taxonomy );
        if ( $term && !is_wp_error($term) ) {
            $terms[] = $term;
        }
    }
}
?>

<div class="post-filter-button filter-buttons" data-trigger="<?php echo esc_attr( $settings['trigger_id'] ); ?>">
    <button class="filter-button is-active box-gradient" data-filter="*">
        <span class="button-text">
            <?php echo esc_html__('View All', 'mindverse'); ?>
        </span>
    </button>
    <?php 
    if ( !empty($terms) ) :
        foreach ( $terms as $term ) : ?>
            <button class="filter-button box-gradient" data-filter=".<?php echo esc_attr( $term->slug ); ?>">
                <span class="button-text">
                    <?php echo esc_html( $term->name ); ?>
                </span>
            </button>
        <?php 
        endforeach;
    endif; 
    ?>
</div>