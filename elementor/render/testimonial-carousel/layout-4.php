<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 1 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 1 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 1 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 1 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 1 : $settings['slides_per_view_xxl']
]);
$swiper_settings = json_encode($swiper_settings);
$swiper_boxshadow = $settings['swiper_boxshadow'] !== 'no' ? ' swiper-boxshadow' : '';
$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image'] ) ? ' box-gradient' : '';

$contents = $settings['contents'] ?? [];
$users = $settings['users'] ?? [];
$icons = $settings['icons'] ?? [];
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
?>
<div class="carousel testimonial-carousel" data-layout="4">
    <div class="carousel-container swiper<?php echo esc_attr($swiper_boxshadow); ?>" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($contents as $i => $item) : 

                $this->add_render_attribute('item_wrapper_'.$i, 'class', 'carousel-item swiper-slide elementor-repeater-item-'.$item['_id'] . $entrance_animation );

                $icon = isset( $icons[$i]['own_icon'] ) && !empty( $icons[$i]['own_icon']['value'] ) ? $icons[$i]['own_icon'] : $settings['icon'];
                $content = $contents[$i]['content'] ?? '';
                $user_name = $users[$i]['name'] ?? '';
                $user_img_id = $users[$i]['image']['id'] ?? [];
                $user_title = $users[$i]['title'] ?? '';
            ?>
                <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
                    <div class="testimonial<?php echo esc_attr($box_gradient_class); ?>">
                        <div class="overlay"></div>
                        <?php if( !empty($icon['value']) ) : ?>
                            <div class="testimonial-icon">
                                <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                            </div>
                        <?php endif; ?>
                        <p class="testimonial-content">
                            <?php echo esc_html( $content ); ?>
                        </p>
                        <?php if( $settings['show_user'] === 'yes' ) : ?>
                            <div class="testimonial-user user">
                                <?php Elementor_Helpers::the_image_to_size($user_img_id, null, null, ['class' => 'user-image']) ?>
                                <div class="user-content">
                                    <div class="user-name">
                                        <?php echo esc_html( $user_name ); ?>
                                    </div>
                                    <span class="user-title">
                                        <?php echo esc_html( $user_title ); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $link_attrs ) ) : ?>
                            <a <?php pxl_print_html( $link_attrs ); ?> class="box-link"></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>