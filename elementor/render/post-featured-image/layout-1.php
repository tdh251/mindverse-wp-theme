<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$post_id = get_the_ID();
$image_id = get_post_thumbnail_id($post_id);
$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode() 
|| \Elementor\Plugin::$instance->preview->is_preview_mode();
if( $image_id === 0 && !$is_editor ) {
    return;
}
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
?>
<div class="post-featured image">
    <?php Elementor_Helpers::the_image_to_size($image_id, $img_w, $img_h, []); ?>
</div>