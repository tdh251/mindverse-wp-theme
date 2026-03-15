<?php 
/**
 * The template for displaying 404 pages (Not Found)
 * 
 * @package Mindverse
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
$template_id = (int) mindverse()->get_theme_option('404_page_template_id', 0);
?>

<?php get_header(); ?>

<?php if( $template_id === 0 ) : ?>
    <main id="main">
        <div class="main-inner">
            <div class="page-heading">
                <h1 class="page-title"><?php echo esc_html__('404', 'mindverse'); ?></h1>
                <div class="page-subtitle">
                    <?php echo esc_html__('Page Not Found', 'mindverse'); ?>
                </div>
            </div>
            <a href="<?php echo esc_attr( home_url('/') ); ?>" class="button button-back" data-hover="fillCircle">
                <div class="button-text">
                    <?php echo esc_html__('Go Back Home', 'mindverse'); ?>
                </div>
            </a>
        </div>
    </main>
<?php else : ?>
    <?php echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id ); ?>
<?php endif; ?>
<?php get_footer(); ?>
