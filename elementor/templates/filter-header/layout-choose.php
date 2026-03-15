<?php 
$box_gradient_class = !empty( $settings['filter_btn_background_color_b'] ) || 
                       !empty( $settings['filter_btn_background_image'] ) ||  
                        !empty( $settings['filter_btn_hover_background_color_b'] ) || 
                        !empty( $settings['filter_btn_hover_background_image'] ) ? ' box-gradient' : '';
?>
<div class="filter-header" data-layout="choose">
    <?php foreach( $settings['btns'] as $btn ) : 
        $is_active_class = $settings['filter_active'] === $btn['data_filter'] ? ' is-active' : '';    
    ?>
        <button class="button filter-button<?php echo esc_attr($is_active_class . $box_gradient_class); ?>" data-filter="<?php echo esc_attr( trim( $btn['data_filter'] ) ); ?>">
            <span class="button-text">
                <?php pxl_print_html( $btn['parsed_btn_text'] ); ?>
            </span>
            <?php if( !empty( $btn['btn_note'] ) ) : ?>
                <span class="button-note"><?php echo esc_html($btn['btn_note']); ?></span>
            <?php endif; ?>
        </button>
    <?php endforeach; ?>
</div>