<?php
$title  = $settings['title'] ?: '';
$percent = $settings['percent'] ?: 0;
?>
<div class="progress-bar">
    <div class="progress-bar-header">
        <?php if( !empty( $title ) ) : ?>
            <div class="progress-bar-title">
                <?php echo esc_html( $title ); ?>
            </div>
        <?php endif; ?>
        <div class="progress-bar-value">
            <span class="value-number" data-effect="counter" data-ending_number="<?php echo esc_attr($percent); ?>"><?php echo esc_html( $percent ); ?></span>
            <span class="value-suffix"><?php echo esc_html('%'); ?></span>
        </div>
    </div>
    <div class="progress-bar-track">
        <span class="progress-bar-fill wow fillProgress" style="max-width: <?php echo esc_attr($percent).'%'; ?>"></span>
    </div>
</div>