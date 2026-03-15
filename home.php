<?php 
/**
 * Front page template file
 * 
 * @package Mindverse
 */
$archive_template_id = (int) mindverse()->get_theme_option('archive_standard_template_id', 0);
$before_page_template_id = (int) mindverse()->get_theme_option('archive_standard_before_template_id', 0);
$after_page_template_id = (int) mindverse()->get_theme_option('archive_standard_after_template_id', 0);

$sidebar_mode = mindverse()->get_theme_option('blog_sidebar_mode', 'right');
if( isset( $_GET['sidebar'] ) ) {
    $sidebar_mode = $_GET['sidebar'];
}
?>

<?php get_header(); ?>
<main id="main">
    <?php
        if( $before_page_template_id !== 0 ) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $before_page_template_id );
        }
    ?>
    <div class="inner">
        <div class="content-area">
            <?php
                if( $archive_template_id !== 0 ) {
                    echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $archive_template_id );
                }else {
                    if ( have_posts() ) {
                        ?>
                        <div class="grid post-grid is-post-type-post" data-layout="1" data-layout_style="2">
                            <div class="grid-inner">
                                <?php
                                    while ( have_posts() ) {
                                        the_post(); 
                                        get_template_part('template-parts/content/archive');
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                        // if ( get_next_posts_link() ) {
                        //     next_posts_link();
                        // }
                        // if ( get_previous_posts_link() ) {
                        //     previous_posts_link();
                        // }
                    } else {
                        get_template_part('template-parts/content/none');
                    }
                }
                mindverse()->layout->the_pagination();
            ?>
        </div>
        <?php if( $sidebar_mode !== 'none' ) : ?>
            <div class="sidebar-area">
                <?php get_sidebar(); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
        if( $after_page_template_id !== 0 ) {
            echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $after_page_template_id );
        }
    ?>
</main>

<?php get_footer(); ?>
