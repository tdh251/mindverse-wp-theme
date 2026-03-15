<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$link_attrs = Elementor_Helpers::get_link_attrs($settings['link']);
$subtitle_animation = !empty($settings['subtitle_animation']) ? ' '.$settings['subtitle_animation'] : '';
?>
<div class="heading">
    <!-- Subtitle Above -->
    <?php if( !empty($settings['subtitle']) && $settings['subtitle_position'] === 'above' ) : ?>
        <div class="heading-subtitle<?php echo esc_attr($subtitle_animation); ?>"
        <?php if ( !empty($settings['subtitle_style']) ) : ?> data-style="<?php echo esc_attr( $settings['subtitle_style'] ); ?>" <?php endif; ?>>
            <?php if( $settings['subtitle_style'] === 'style-5' ) : ?>
                <svg class="subtitle-box-border" width="194" height="33" viewBox="0 0 194 33" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <rect x="0.5" y="0.5" width="193" height="32" rx="16" stroke="url(#<?php echo esc_attr( $this->get_id() ); ?>)"/>
                    <defs>
                        <linearGradient id="<?php echo esc_attr( $this->get_id() ); ?>" x1="0" y1="16.5" x2="35" y2="16.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="white"/>
                            <stop offset="1" stop-color="#000212"/>
                        </linearGradient>
                    </defs>
                </svg>
            <?php endif; ?>
            <?php if( strpos($settings['subtitle_style'], 'secondary') !== false && !empty($settings['subtitle_highlight']) ) : ?>
                <span class="subtitle-highlight">
                    <?php echo esc_html($settings['subtitle_highlight']); ?>
                </span>
            <?php endif; ?>          
            <span class="subtitle-text">
                <?php pxl_print_html( $this->parse_text_editor( $settings['subtitle'] ?? '' ) ); ?>
            </span>
            <?php if( !empty( $settings['subtitle_icon']['value'] )) : ?>
                <span class="subtitle-icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['subtitle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Title -->
    <?php if(!empty($settings['title'])) : 
    
        $title = $settings['title'] ?? '';
        $title_style = !empty($settings['title_style']) ? ' title-'.$settings['title_style'] : '';

        $title_wrapper_attrs = [
            'class' => 'heading-title'. $title_style,
        ];

        if( empty( $settings['text_animation_lib'] ) && !empty( $settings['title_animation'] ) ) {
            $title_wrapper_attrs['class'] .= ' '.$settings['title_animation'];
        }

        if( $settings['text_animation_lib'] === 'gsap' && !empty( $settings['text_animation'] )  ) {
            $title_wrapper_attrs['data-text-animation'] = $this->get_text_animation_settings();
        }

        $title = Elementor_Helpers::render_highlight_html( $settings, $title );

        $this->add_render_attribute('title_wrapper', $title_wrapper_attrs);
    ?>
        <<?php echo esc_attr($settings['title_tag']); ?> <?php pxl_print_html( $this->get_render_attribute_string('title_wrapper') ); ?>>
            <?php if(!empty($link_attrs)) : ?>
                <a <?php pxl_print_html($link_attrs); ?>>
            <?php endif; ?>
                <?php pxl_print_html($title); ?>
            <?php if(!empty($link_attrs)) : ?>
                </a>
            <?php endif; ?>
        </<?php echo esc_attr($settings['title_tag']); ?>>
    <?php endif; ?>

    <!-- Subtitle Below -->
    <?php if( !empty($settings['subtitle']) && $settings['subtitle_position'] === 'below' ) : ?>
        <div class="heading-subtitle<?php echo esc_attr($subtitle_animation); ?>" 
        <?php if ( !empty($settings['subtitle_style']) ) : ?> data-style="<?php echo esc_attr( $settings['subtitle_style'] ); ?>" <?php endif; ?>>
            <?php if( $settings['subtitle_style']  === 'style-5' ) : ?>
                <svg class="subtitle-box-border" width="194" height="33" viewBox="0 0 194 33" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <rect x="0.5" y="0.5" width="193" height="32" rx="16" stroke="url(#<?php echo esc_attr( $this->get_id() ); ?>)"/>
                    <defs>
                        <linearGradient id="<?php echo esc_attr( $this->get_id() ); ?>" x1="0" y1="16.5" x2="35" y2="16.5" gradientUnits="userSpaceOnUse">
                            <stop stop-color="white"/>
                            <stop offset="1" stop-color="#000212"/>
                        </linearGradient>
                    </defs>
                </svg>
            <?php endif; ?>
            <?php if( strpos($settings['subtitle_style'], 'primary') ) : ?>
                <?php echo esc_html($settings['subtitle_highlight']); ?>
            <?php endif; ?>   
            <span class="span subtitle-text">
                <?php pxl_print_html( $this->parse_text_editor( $settings['subtitle'] ?? '' ) ); ?>
            </span>
            <?php if( !empty( $settings['subtitle_icon']['value'] )) : ?>
                <span class="subtitle-icon">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['subtitle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>