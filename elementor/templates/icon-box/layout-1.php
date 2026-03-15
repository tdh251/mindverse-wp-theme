<div class="mindverse-icon-box" data-layout="1">
    <div class="mindverse-icon-box-icon copy">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </div>
    <div class="mindverse-icon-box-icon main">
        <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
    </div>
    <div class="mindverse-icon-box-content">
        <<?php echo esc_attr($title_tag); ?> class="mindverse-icon-box-title">
            <?php echo esc_html($title); ?>
        </<?php echo esc_attr($title_tag); ?>>
        <p class="mindverse-icon-box-desc">
            <?php echo esc_html($desc); ?>
        </p>
    </div>
</div>