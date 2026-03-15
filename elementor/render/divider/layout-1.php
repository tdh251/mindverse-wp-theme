<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$classes = 'divider divider-'.$settings['divider_dir'];
?>
<?php if($settings['divider_style'] !== '') : ?>
    <div class="<?php echo esc_attr($classes); ?>"></div>
<?php else : ?>
    <?php if( $settings['divider_custom_type'] === 'img' ) : 
        Elementor_Helpers::the_image_to_size($settings['divider_img']['id'], null, null, ['class' => 'divider divider-image']);
    else : ?>
        <div class="divider divider-svg">
            <?php \Elementor\Icons_Manager::render_icon( $settings['divider_svg'], [ 'aria-hidden' => 'true' ] ); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php