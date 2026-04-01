<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;
$img_w = $settings['img_size']['width'] ?: null;
$img_h = $settings['img_size']['height'] ?: null;
$title_tag = $settings['title_tag'] ?: 'h4';
$link_attrs = Elementor_Helpers::get_link_attrs( $settings['link'] );
$coming_soon_class = ( $settings['is_coming_soon'] === 'yes' ) ? ' coming-soon' : '';
?>
<div class="show-case<?php echo esc_attr( $coming_soon_class ); ?>" data-layout="1">
    <div class="show-case-box" data-hover="tilt">
        <div class="show-case-box-inner">
            <div class="show-case-header">
                <div class="show-case-status">
                    <span class="dot dot-1"></span>
                    <span class="dot dot-2"></span>
                    <span class="dot dot-3"></span>
                </div>
                <?php if( !empty( $settings['badge'] ) && $settings['is_coming_soon'] !== 'yes' ) : ?>
                    <div class="show-case-badge">
                        <?php echo esc_html( $settings['badge'] ); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="show-case-image image">
                <?php if( $settings['is_coming_soon'] === 'yes' ) : ?>
                    <div class="show-case-coming-soon">
                        <?php echo esc_html__('Coming Soon', 'mindverse'); ?>
                    </div>
                <?php endif; ?>
                <?php if( empty( $settings['btns'] ) ) : ?>
                    <a <?php pxl_print_html( $link_attrs ); ?>>
                <?php endif; ?>
                <?php Elementor_Helpers::the_image_to_size( $settings['img']['id'], $img_w, $img_h, []); ?>
                <?php if( empty( $settings['btns'] ) ) : ?>
                    </a>
                <?php endif; ?>
                <?php if( !empty( $settings['btns'] ) ) : ?>
                    <div class="show-case-button-group">
                        <?php foreach( $settings['btns'] as $i => $btn ) : 
                            $link_attrs = Elementor_Helpers::get_link_attrs( $btn['link'] );    
                        ?>
                            <a class="button show-case-button box-gradient elementor-repeater-item-<?php  echo esc_attr( $btn['_id'] ); ?>" <?php pxl_print_html(  $link_attrs ); ?> style="--button-index: <?php echo esc_attr( $i ); ?>">
                                <span class="button-text"><?php echo esc_html( $btn['text'] ); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if( $settings['is_coming_soon'] !== 'yes' ) : ?>
        <<?php echo esc_attr( $title_tag ); ?> class="show-case-title">
            <a <?php pxl_print_html( $link_attrs ); ?>>
                <?php echo esc_html( $settings['title'] ); ?>
            </a>
        </<?php echo esc_attr( $title_tag ); ?>>
    <?php endif; ?>
</div>