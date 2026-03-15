<?php 
    $box_gradient_class = !empty( $settings['swiper_nav_btn_background_color_b'] ) || 
            !empty( $settings['swiper_nav_btn_background_image'] ) ||  
            !empty( $settings['swiper_nav_btn_hover_background_color_b'] ) || 
            !empty( $settings['swiper_nav_btn_hover_background_image'] ) ? ' box-gradient' : '';
?>
<div id="<?php echo esc_attr($settings['html_id']); ?>" class="carousel-navigation">    
    <div class="button carousel-button carousel-button-prev<?php echo esc_attr($box_gradient_class); ?>">
        <?php if(!empty( $settings['nav_prev_icon']['value'] )) : ?>
            <?php \Elementor\Icons_Manager::render_icon( $settings['nav_prev_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                <path d="M1.03125 7.21875L0 8.25L8.25 16.5L9.28125 15.4687L2.0625 8.25L9.28125 1.03125L8.25 -1.90735e-06L4.125 4.125L1.03125 7.21875Z" fill="#2B2B2B"/>
            </svg>
        <?php endif; ?>
    </div>
    <div class="button carousel-button carousel-button-next<?php echo esc_attr($box_gradient_class); ?>">
        <?php if(!empty( $settings['nav_next_icon']['value'] )) : ?>
            <?php \Elementor\Icons_Manager::render_icon( $settings['nav_next_icon'], [ 'aria-hidden' => 'true' ] ); ?>
        <?php else: ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="17" viewBox="0 0 10 17" fill="none">
                <path d="M8.33594 9.28125L9.36719 8.25L1.03125 -1.90735e-06L0 1.03125L7.21875 8.25L0 15.4687L1.03125 16.5L5.24219 12.375L8.33594 9.28125Z" fill="#2B2B2B"/>
            </svg>
        <?php endif; ?>
    </div>
</div>