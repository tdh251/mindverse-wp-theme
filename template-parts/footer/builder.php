<?php 
if($layout <= 0) {
    return;
}
?>
<footer id="footer" class="footer" data-layout="<?php echo esc_attr($type); ?>">
    <div class="footer-inner">
        <?php echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $layout ); ?>
    </div>
</footer>