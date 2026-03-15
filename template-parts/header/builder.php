<?php
/**
 * Template part for displaying header builder by Elementor.
 *
 * @package Mindverse
 */
// HTML
if($layout <= 0) {
    return;
}
$style = get_post_meta($layout, 'header_type', true);
$style_class = ( $style === 'transparent' ) ? ' header-transparent' : '';
?>
<header id="header-desktop" class="header header-desktop<?php echo esc_attr($style_class); ?>" data-layout="<?php echo esc_attr($type); ?>">
    <div class="header-inner">
            <?php echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $layout ); ?>
    </div>
</header>