<?php
if($layout <= 0) {
    return;
}
?>
<section id="hero-section" class="hero-section" data-layout="builder">
    <?php echo \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $layout ); ?>
</section>

