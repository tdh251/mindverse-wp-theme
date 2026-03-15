<?php

$post_id = get_the_ID();
$post_type = get_post_type();
?>

<div class="post-tag">
    <?php the_terms( $post_id, $post_type.'_tag', '', '', '' ); ?>
    <?php if( $post_type === 'pxl-template' ) : ?>
        <a href="#"><?php echo esc_html__( 'Demo', 'mindverse' ); ?></a>
        <a href="#"><?php echo esc_html__( 'Preview', 'mindverse' ); ?></a>
        <a href="#"><?php echo esc_html__( 'Template', 'mindverse' ); ?></a>
    <?php endif; ?>
</div>