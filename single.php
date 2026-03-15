<?php 
/**
 * Page template file
 * 
 * @package Mindverse
 */
$post_type = get_post_type();

if( $post_type !== 'post' ) {
    get_template_part( 'template-parts/content/single/post_type', null, array( 'post_type' => $post_type ) );
    return;
}
    
get_template_part( 'template-parts/content/single/blog', null, array( 'post_type' => $post_type ) );
