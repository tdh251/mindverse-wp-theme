<?php
if(is_single()) {
    $post_type = get_post_type();
    $breadcrumb_highight = mindverse()->get_theme_option('single_'.$post_type.'_breadcrumb_highight', get_the_title());
} elseif( is_home() ) {
    $breadcrumb_highight = mindverse()->get_theme_option('blog_breadcrumb_highight', get_the_title());
}elseif( is_archive() ) {
    if ( is_category() ) {
        $breadcrumb_highight = __( 'Category', 'mindverse' );
    } elseif ( is_tag() ) {
        $breadcrumb_highight = __( 'Tag', 'mindverse' );
    } elseif ( is_date() ) {
        $breadcrumb_highight = __( 'Date', 'mindverse' );
    }
} elseif( is_search() ) {
    $breadcrumb_highight = __('Search', 'mindverse');
}
else {
    $breadcrumb_highight = mindverse()->get_singular_option('breadcrumb_highight', get_the_title());
}
?>
<div class="breadcrumb">
    <?php if(  !empty( $breadcrumb_highight )) : ?>
        <div class="breadcrumb-highlight"><?php echo esc_html( $breadcrumb_highight ); ?></div>
    <?php endif; ?>
    <?php mindverse()->layout->get_breadcrumb(); ?>
    <?php if( !empty( $settings['icon'] ) ) : ?>
        <div class="breadcrumb-icon">
            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
        </div>
    <?php endif; ?>
</div>
