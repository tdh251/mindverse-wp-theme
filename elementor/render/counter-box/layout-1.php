<?php
$starting_number = $settings['starting_number'] ?: 1;
$ending_number   = $settings['ending_number'] ?: 1;

?>
<div class="counter-box" data-layout="1">
    <?php if(!empty($settings['icon']['value'])) : ?>
        <div class="counter-box-icon">
            <?php \Elementor\Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
        </div>
    <?php endif; ?>
    <div class="counter-box-content">
        <div class="counter-box-number">
            <?php if(!empty($settings['number_prefix'])) : ?>
                <span class="number-prefix">
                    <?php pxl_print_html($settings['number_prefix']); ?>
                </span>
            <?php endif;?>
            <span class="counter-number" data-effect="counter" data-delimiter="<?php echo esc_attr($settings['number_delimiter']); ?>" data-starting_number="<?php echo esc_attr($starting_number) ?>" data-ending_number="<?php echo esc_attr($ending_number); ?>">
                <?php echo esc_html($ending_number); ?>
            </span>
                <?php if(!empty($settings['number_suffix'])) : ?>
                <span class="number-suffix">
                    <?php pxl_print_html($settings['number_suffix']); ?>
                </span>
            <?php endif; ?> 
        </div>
        <?php if(!empty($settings['desc'])) : ?>
            <p class="counter-box-desc">
                <?php pxl_print_html($settings['desc']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>