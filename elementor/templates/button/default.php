<?php
/**
 * Template Button Default
 */
if(!empty($text)) : ?>
    <span class="button-text" <?php if($is_text_gradient) : ?> data-text="<?php echo esc_attr($text); ?>" <?php endif; ?>>
        <?php if( !$is_text_gradient ) { echo esc_html($text); } ?>
    </span>
<?php endif; 
if(!empty($icon['value'])) : ?>
    <span class="button-icon">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </span>
<?php endif; ?>