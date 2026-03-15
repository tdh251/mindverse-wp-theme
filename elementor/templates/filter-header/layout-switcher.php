<?php 
$random_key = mt_rand(1, 1000); 
$box_gradient_class = !empty( $settings['filter_btn_background_color_b'] ) || 
                       !empty( $settings['filter_btn_background_image'] ) ||  
                        !empty( $settings['filter_btn_hover_background_color_b'] ) || 
                        !empty( $settings['filter_btn_hover_background_image'] ) ? ' box-gradient' : '';
?>  
<div class="filter-header" data-layout="switcher">
    <?php foreach( $settings['btns'] as $i => $btn ) : 
        $is_active_class = $settings['filter_active'] === $btn['data_filter'] ? ' is-active' : '';
        $isChecked = $settings['filter_active'] === $btn['data_filter'];
    ?>
        <?php if( $i < 2 ) : ?>
            <button class="filter-button switch-value<?php echo esc_attr($is_active_class . $box_gradient_class); ?>" data-filter="<?php echo esc_attr( trim( $btn['data_filter'] ) ); ?>">
                <span class="button-text">
                    <?php pxl_print_html( $btn['parsed_btn_text'] ); ?>
                </span>
                <?php if( !empty( $btn['btn_note'] ) ) : ?>
                    <span class="button-note"><?php echo esc_html($btn['btn_note']); ?></span>
                <?php endif; ?>
            </button>
        <?php endif; ?>
        <?php if( $i === 0 ) : 
            $isChecked = $settings['filter_active'] !== $btn['data_filter'];
        ?>
            <input type="checkbox" class="check-switch" id="switch-<?php echo esc_attr($random_key); ?>" <?php if( $isChecked ) : ?> checked <?php endif; ?>>
            <label class="toggle-switch" for="switch-<?php echo esc_attr($random_key); ?>">
                <span class="slider">
                    <?php if( !empty( $settings['slider_icon'] ) ) : ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings['slider_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php endif; ?>
                </span>
            </label>
        <?php endif; ?>
    <?php endforeach; ?>
</div>