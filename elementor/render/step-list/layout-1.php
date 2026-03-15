<?php
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
?>
<div class="step-list">
    <svg class="step-line" width="1" height="307" viewBox="0 0 1 307" fill="none" xmlns="http://www.w3.org/2000/svg">
        <line x1="0.5" y1="2.18557e-08" x2="0.499987" y2="307" stroke="currentcolor" stroke-dasharray="4 4"/>
    </svg>
    <?php foreach($settings['items'] as $i => $item) : ?>
        <div class="step-item<?php echo esc_attr( $entrance_animation ); ?>">
            <div class="step-inner">
                <div class="step-index">
                    <?php echo esc_html( $i + 1 ); ?>
                </div>
                <div class="step-content">
                    <h5 class="step-title">
                        <?php pxl_print_html($item['title']); ?>
                    </h5>
                    <p class="step-description">
                        <?php pxl_print_html($item['desc']); ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>