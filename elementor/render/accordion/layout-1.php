<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['items']);

$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image'] ) ? ' box-gradient' : '';

$icon_box_gradient = ( isset($settings['icon_background_background']) && ( $settings['icon_background_background']  === 'gradient' || $settings['icon_background_background']  === 'image' ) ||
    isset($settings['icon_hover_background_background']) && ( $settings['icon_hover_background_background']  === 'gradient' || $settings['icon_hover_background_background']  === 'image' ) ) ? 
    ' box-gradient' : '';
$icon_html = '<div class="accordion-icon icon'.$icon_box_gradient.'"><span class="icon-plus"></span></div>';
$title_tag = ( $settings['title_tag'] ?: 'h4' ) ?? 'div';
$title_text_gradient = ( isset($settings['title_fill_background']) && ( $settings['title_fill_background']  === 'gradient' || $settings['title_fill_background']  === 'image' ) ) || 
                        ( isset($settings['title_hover_fill_background']) && ( $settings['title_hover_fill_background']  === 'gradient' || $settings['title_hover_fill_background']  === 'image' ) );
$index_text_gradient = ( isset($settings['index_fill_background']) && ( $settings['index_fill_background']  === 'gradient' || $settings['index_fill_background']  === 'image' ) ) || 
                        ( isset($settings['index_hover_fill_background']) && ( $settings['index_hover_fill_background']  === 'gradient' || $settings['index_hover_fill_background']  === 'image' ) );
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
?>
<div class="accordion" data-mode="<?php echo esc_attr($settings['mode']); ?>"
    <?php if( $settings['layout_style'] !== '0' ) : ?> data-layout_style="<?php echo esc_attr($settings['layout_style']); ?>" <?php endif; ?>>
    <?php foreach($settings['items'] as $i => $item) : 
        $default_active = $settings['default_active'] === ( $i + 1 ) ? ' is-active' : '';

        $this->add_render_attribute('item_wrapper_'.$i, 'class', 'accordion-item' . $default_active . $box_gradient_class . $entrance_animation );

        $index_content = $settings['show_index'] === 'yes' ? $settings['index_prefix'] . ( $i + 1 ) . $settings['index_suffix'] : '';
    ?>
        <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
            <?php if( $settings['layout_style'] === '1' ) : ?>
                <svg class="border-gradient-svg" width="100%" height="100%" viewBox="0 0 1301 161" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M1296 0C1298.76 0 1301 2.23858 1301 5V156C1301 158.761 1298.76 161 1296 161H2.27441C1.01829 161 7.27762e-05 160.026 0 158.824V6.92188C0 6.3414 0.239755 5.78423 0.666992 5.37402L5.59863 0.639648C5.77661 0.468766 5.9453 0.329316 6.125 0.224609C6.37593 0.0784333 6.64877 0 7 0V1.00977C6.6969 1.00977 6.58522 1.11768 6.38477 1.31152C6.37066 1.32517 6.35591 1.33903 6.34082 1.35352L1.40918 6.08887C1.17925 6.30973 1.0498 6.6094 1.0498 6.92188V9H1V141H1.0498V158.824C1.04988 159.471 1.59816 159.996 2.27441 159.996H7V160H1296C1298.21 160 1300 158.209 1300 156V5C1300 2.79086 1298.21 1 1296 1H7.00391V0H1296Z" fill="url(#paint_linear_<?php echo esc_attr( $this->get_id() ); ?>)"/>
                </svg>
            <?php elseif( $settings['layout_style'] === '2' ) : ?>
                <div class="box-border-gradient six-colors"></div>
            <?php endif; ?>
            <div class="accordion-header">
                <<?php echo esc_attr($title_tag); ?> class="accordion-title">
                    <?php if( $settings['show_index'] === 'yes' ) : ?>
                        <span class="accordion-index" <?php if($index_text_gradient) : ?> data-text="<?php echo esc_attr($index_content); ?>" <?php endif; ?>>
                            <?php if( !$index_text_gradient ) { echo esc_html( $index_content ); } ?>
                        </span>
                    <?php endif; ?>
                    <span class="title-text" <?php if($title_text_gradient) : ?> data-text="<?php echo esc_attr($item['title']); ?>" <?php endif; ?>>
                        <?php if( !$title_text_gradient ) { echo esc_html( $item['title'] ); } ?>
                    </span>
                </<?php echo esc_attr($title_tag); ?>>
                <?php pxl_print_html($icon_html); ?>
            </div>
            <div class="accordion-content">
                <?php pxl_print_html($item['content']); ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if( $settings['layout_style'] === '1' ) : ?>
        <svg class="svg-render">
            <defs>
                <linearGradient id="paint_linear_<?php echo esc_attr( $this->get_id() ); ?>" x1="1301.99" y1="-1.67709" x2="2.77201" y2="-1.67704" gradientUnits="userSpaceOnUse">
                <stop stop-color="#39EDAC"/>
                <stop offset="0.216346" stop-color="#47B2FF"/>
                <stop offset="0.492311" stop-color="#434AFF"/>
                <stop offset="0.774038" stop-color="#47B2FF"/>
                <stop offset="0.988561" stop-color="#39EDAC"/>
                </linearGradient>
            </defs>
        </svg>
    <?php endif; ?>
</div>