<?php
$starting_number = $settings['starting_number'] ?: 1;
$ending_number   = $settings['ending_number'] ?: 1;
$title_tag = !empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
$wrapper_attrs = [
    'class' => 'counter-box',
    'data-layout' => 3
];
$this->add_render_attribute('custom_wrapper', $wrapper_attrs);
?>
<div <?php pxl_print_html($this->get_render_attribute_string('custom_wrapper')); ?>>
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
    <div class="counter-box-content">
        <?php if(!empty($settings['title'])) : ?>
            <<?php echo esc_attr($title_tag); ?> class="counter-box-title">
                <?php echo esc_html($settings['title']); ?>
            </<?php echo esc_attr($title_tag); ?>>
        <?php endif; ?>
        <?php if(!empty($settings['desc'])) : ?>
            <p class="counter-box-desc">
                <?php pxl_print_html($settings['desc']); ?>
            </p>
        <?php endif; ?>
    </div>
</div>