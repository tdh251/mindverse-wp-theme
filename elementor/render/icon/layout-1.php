<?php



// if( !empty( $settings['loop_animation'] ) ) {
//     $wrapper_attrs['data-loop-animation'] = $settings['loop_animation'];
// }

// $this->add_render_attribute('custom_wrapper', $wrapper_attrs);

?>

<div class="icon">
    <span <?php if( !empty( $settings['loop_animation'] ) ) : ?> data-loop-animation="<?php echo esc_attr($settings['loop_animation']); ?>" <?php endif; ?>>
        <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
    </span>
</div>