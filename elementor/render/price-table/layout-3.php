<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

$this->add_render_attribute('wrapper', [
    'class' => 'price-table'.($settings['on_filter']  === 'yes' ? ' filter' : ''),
    'data-layout' => 3
]);
$this->add_render_attribute('inner', [
    'class' => 'price-inner grid'.($settings['on_filter']  === 'yes' ? ' filter-content' : ''),
]);

$title_tag = $settings['title_tag'] ?: 'div';
$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                        !empty( $settings['box_background_image'] ) ||  
                        !empty( $settings['box_hover_background_color_b'] ) || 
                        !empty( $settings['box_hover_background_image'] ) ? ' box-gradient' : '';
$feature_title_tag = $settings['feature_title_tag'] ?: 'h5';
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
$activated_filters = [];
?>
<?php if( $settings['on_filter']  === 'yes' && $settings['input_mode'] === 'btns' ) : ?>
    <div class="price-table filter">
        <?php
            if ( ! empty( $settings['btns'] ) ) {
                foreach ( $settings['btns'] as &$btn ) {
                    $btn['parsed_btn_text'] = $this->parse_text_editor( $btn['btn_text'] ?? '' );
                }
            }
            Elementor_Helpers::get_template('/elementor/templates/filter-header/layout-'.( $settings['filter_header_layout'] ?? 'choose' ), [
                'widget' => $widget,
                'settings' => $settings,
            ]);
        ?>
    </div>
<?php else : ?>
    <div <?php pxl_print_html( $this->get_render_attribute_string( 'wrapper' ) ); ?>>
        <div <?php pxl_print_html( $this->get_render_attribute_string( 'inner' ) ); ?>>
            <div class="grid-inner">
                <?php foreach( $settings['contents'] as $i => $item ) : 
                    $item_class = 'grid-item';
                    $filter_value = $item['filter_by'] ?? '';

                    if($settings['on_filter'] === 'yes') {
                        $item_class .= ' filter-item '.$filter_value;
                    }
                    $this->add_render_attribute('item_wrapper_'.$i, 'class', $item_class . $entrance_animation);
                    $link_attrs = Elementor_Helpers::get_link_attrs($item['link']);
                    $active_class = '';
                    if ( !in_array($filter_value, $activated_filters) ) {
                        $active_class = ' is-active';
                        $activated_filters[] = $filter_value; 
                    }
                    $btn_text = !empty( $item['btn_text'] ) ? $item['btn_text'] : $settings['btn_text'];
                ?>
                    <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
                        <div class="price<?php echo esc_attr($active_class . $box_gradient_class); ?>">
                            <div class="price-overview">
                                <?php if( !empty( $item['badge_img']['url'] ) || !empty( $item['badge_text'] ) ) : ?>
                                    <div class="price-badge">
                                        <?php if( !empty( $item['badge_img']['url'] ) ) : ?>
                                            <?php echo Elementor_Helpers::the_image_to_size($item['badge_img']['id'], null, null, ['class' => 'badge-image']) ?>
                                        <?php endif; ?>
                                        <?php if( !empty( $item['badge_text'] ) ) : ?>
                                            <span class="badge-text"><?php echo esc_html($item['badge_text']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <<?php echo esc_attr($title_tag); ?> class="price-title">
                                    <?php echo esc_html($item['title']); ?>
                                </<?php echo esc_attr($title_tag); ?>>
                                <p class="price-description">
                                    <?php echo esc_html($item['description']); ?>
                                </p>
                                <hr class="price-divider">
                                <div class="price-amount">
                                    <span class="amount-text"><?php echo esc_html($item['price']); ?></span>
                                    <span class="amount-suffix"><?php echo esc_html($item['price_suffix']); ?></span>
                                </div>
                                <hr class="price-divider">
                                <ul class="price-feature">
                                    <?php foreach(explode('|', $item['features']) as $feature): ?>
                                        <li class="feature-item">
                                            <?php if( !empty($settings['feature_icon']['value']) ) : ?>
                                                <span class="feature-icon icon">
                                                    <?php \Elementor\Icons_Manager::render_icon( $settings['feature_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php echo esc_html($feature); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <a <?php pxl_print_html($link_attrs); ?> class="button price-button">
                                <?php echo esc_html( $btn_text ); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach;  ?>
            </div>
        </div>
    </div>
<?php endif; ?>