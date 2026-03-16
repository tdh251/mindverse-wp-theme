<?php
/**
 * Sidebar template file
 * 
 * @package Mindverse
 */

if ( class_exists( 'WooCommerce' ) && ( is_product_category() || is_shop() || is_product() ) ) {
    $sidebar = ' sidebar-shop';
}  else {
    $sidebar = ' sidebar-blog';
} 
?>
<aside id="sidebar" class="sidebar is-sticky<?php echo esc_attr($sidebar); ?>" data-sticky-settings="<?php echo esc_attr(json_encode(['position' => 'top', 'offset'=> 30, 'spacing'=> false, 'breakOn'=> 'tablet'])); ?>">
    <?php dynamic_sidebar($sidebar); ?>
</aside>
