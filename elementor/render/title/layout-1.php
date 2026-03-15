<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);

$btn_gradient = ( isset($settings['title_background_background']) && ( $settings['title_background_background']  === 'gradient' || $settings['title_background_background']  === 'image' ) ||
                isset($settings['title_hover_background_background']) && ( $settings['title_hover_background_background']  === 'gradient' || $settings['title_hover_background_background']  === 'image' ) ) ? 
                ' box-gradient' : '';
$is_text_gradient = ( isset($settings['title_fill_background']) && $settings['title_fill_background']  === 'gradient' ) || 
                ( isset($settings['title_hover_fill_background']) && $settings['title_hover_fill_background']  === 'gradient' );

switch ( $settings['get_page_title'] ) {
    case 'custom' :
        $title = mindverse()->layout->get_title();
        break;
    case 'default' :
        $title = get_the_title();
        break;
    default : 
        $title = $settings['title'];
        break;
}
?>

<<?php echo esc_attr($settings['title_tag']); ?> class="title" 
<?php if($is_text_gradient) : ?> data-text="<?php echo esc_attr($title); ?>" <?php endif; ?>
<?php if( !empty( $settings['title_hover_style'] ) ) : ?> data-hover="<?php echo esc_attr( $settings['title_hover_style'] ); ?>" <?php endif; ?>
<?php if( $settings['title_hover_style'] === 'text-flip-3d' ) : ?> data-text="<?php echo esc_attr( $title ); ?>" <?php endif; ?>>
    <?php if(!empty($link_attrs)) : ?>
        <a <?php pxl_print_html($link_attrs); ?>>
    <?php endif; ?>
        <?php if( !$is_text_gradient ) { pxl_print_html($title); } ?>
    <?php if(!empty($link_attrs)) : ?>
        </a>
    <?php endif; ?>
</<?php echo esc_attr($settings['title_tag']); ?>>