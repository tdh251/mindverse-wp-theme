<?php
       
if( class_exists('WPCF7') && $settings['cf_id'] !== '0' ) :
    add_filter('wpcf7_autop_or_not', '__return_false'); 
    $field_style_class = !empty( $settings['cf_filed_style'] ) ? ' field-style-'.$settings['cf_filed_style'] : '';
    // html_id="'.esc_attr(trim($settings['cf_html_id'])).'"
?>
<?php pxl_print_shortcode('[contact-form-7 id="'.esc_attr($settings['cf_id']).'" html_class="'.esc_attr('grid wpcf7-form wpcf7-form-'.$settings['cf_id'].' '.$field_style_class).'"]'); ?>
<?php else : ?>
    <p class="no-found"><?php echo esc_html__('No Form Found.', 'mindverse'); ?></p>
<?php endif;
