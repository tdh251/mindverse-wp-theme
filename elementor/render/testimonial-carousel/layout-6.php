<?php
use Mindverse\Inc\Integrations\Elementor\Elementor_Helpers;

Elementor_Helpers::is_items_empty($settings['contents']);

$swiper_settings = Elementor_Helpers::get_swiper_settings($settings, [
    'slides_per_view_xs' => $settings['slides_per_view_xs'] === '' ? 1 : $settings['slides_per_view_xs'],
    'slides_per_view_sm' => $settings['slides_per_view_sm'] === '' ? 2 : $settings['slides_per_view_sm'],
    'slides_per_view_md' => $settings['slides_per_view_md'] === '' ? 2 : $settings['slides_per_view_md'],
    'slides_per_view_lg' => $settings['slides_per_view_lg'] === '' ? 3 : $settings['slides_per_view_lg'],
    'slides_per_view_xl' => $settings['slides_per_view_xl'] === '' ? 3 : $settings['slides_per_view_xl'],
    'slides_per_view_xxl' => $settings['slides_per_view_xxl'] === '' ? 3 : $settings['slides_per_view_xxl']
]);
$swiper_settings = json_encode($swiper_settings);
$swiper_boxshadow = $settings['swiper_boxshadow'] === 'yes' ? ' swiper-boxshadow' : '';
$box_gradient_class = !empty( $settings['box_background_color_b'] ) || 
                    !empty( $settings['box_background_image'] ) ||  
                    !empty( $settings['box_hover_background_color_b'] ) || 
                    !empty( $settings['box_hover_background_image'] ) ? ' box-gradient' : '';

$contents = $settings['contents'] ?? [];
$users = $settings['users'] ?? [];
$icons = $settings['icons'] ?? [];
$imgs = $settings['images'] ?? [];
$video_links = $settings['video_links'];
$entrance_animation = ( empty( $settings['entrance_animation_lib'] ) && !empty( $settings['entrance_animation'] ) ) ? ' '.$settings['entrance_animation'] : ''; 
$img_w = $settings['img_size']['width'] ?? null;
$img_h = $settings['img_size']['height'] ?? null;
?>
<div class="carousel testimonial-carousel" data-layout="6">
    <div class="carousel-container swiper<?php echo esc_attr($swiper_boxshadow); ?>" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
        <div class="carousel-inner swiper-wrapper">
            <?php foreach($contents as $i => $item) : 

                $this->add_render_attribute('item_wrapper_'.$i, 'class', 'carousel-item swiper-slide elementor-repeater-item-'.$item['_id'] . $entrance_animation );
                $icon = isset( $icons[$i]['own_icon'] ) && !empty( $icons[$i]['own_icon']['value'] ) ? $icons[$i]['own_icon'] : $settings['icon'];
                $content = $contents[$i]['content'] ?? '';
                $user_name = $users[$i]['name'] ?? '';
                $user_img_id = $users[$i]['image']['id'] ?? [];
                $user_title = $users[$i]['title'] ?? '';
                $video_link = $video_links[$i]['link'] ?? '';
            ?>
                <div <?php pxl_print_html( $this->get_render_attribute_string('item_wrapper_'.$i) ); ?>>
                    <div class="testimonial<?php echo esc_attr($box_gradient_class); ?>">
                        <div class="testimonial-image">
                            <?php Elementor_Helpers::the_image_to_size($imgs[$i]['img']['id'] ?? '', $img_w, $img_h, []) ?>
                        </div>
                        <div class="testimonial-inner">
                            <div class="overlay"></div>
                            <div class="testimonial-header">
                                <a class="button button-play-video" data-type="play" href="<?php echo esc_url( $video_link['url'] ?? '#' ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="11" viewBox="0 0 10 11" fill="none">
                                        <path d="M5.34454 1.87926C3.27289 0.498001 2.23707 -0.192635 1.39028 0.0467288C1.12475 0.121783 0.878649 0.253489 0.668894 0.432778C-1.09278e-07 1.00454 0 2.2495 0 4.73944V6.25664C0 8.7463 -1.63917e-07 9.99121 0.668841 10.5629C0.878572 10.7422 1.12467 10.8739 1.39018 10.949C2.23689 11.1884 3.27266 10.4979 5.34431 9.11695L6.48223 8.35847C8.19277 7.21818 9.04813 6.64807 9.20285 5.87133C9.25189 5.62511 9.25189 5.37157 9.20285 5.12537C9.0482 4.34863 8.19293 3.7784 6.48246 2.63795L5.34454 1.87926Z" fill="white"/>
                                    </svg>
                                </a>
                                <div class="testimonial-icon icon">
                                    <?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
                                </div>
                            </div>
                            <div class="testimonial-footer">
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
                            </div>
                            <?php if( !empty( $link_attrs ) ) : ?>
                                <a <?php pxl_print_html( $link_attrs ); ?> class="box-link"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php echo Elementor_Helpers::get_swiper_controls( $settings ); ?>
    </div>
</div>