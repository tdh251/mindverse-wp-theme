<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$btn_gradient = ( isset($settings['title_background_background']) && ( $settings['title_background_background']  === 'gradient' || $settings['title_background_background']  === 'image' ) ||
                isset($settings['title_hover_background_background']) && ( $settings['title_hover_background_background']  === 'gradient' || $settings['title_hover_background_background']  === 'image' ) ) ? 
                ' box-gradient' : '';
$is_text_gradient = ( isset($settings['title_fill_background']) && $settings['title_fill_background']  === 'gradient' ) || 
                ( isset($settings['title_hover_fill_background']) && $settings['title_hover_fill_background']  === 'gradient' );
                

?>

<<?php echo esc_attr($settings['title_tag']); ?> class="post-title">
    <?php echo esc_html(get_the_title()); ?>
</<?php echo esc_attr($settings['title_tag']); ?>>