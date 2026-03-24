<?php
/**
 * Override WooCommerce single product image to custom carousel with thumbnails
 *
 * @package YourTheme
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
	return;
}

$post_thumbnail_id = $product->get_image_id();
$gallery_ids       = $product->get_gallery_image_ids();
$image_ids         = array();

if ( $post_thumbnail_id ) {
	$image_ids[] = $post_thumbnail_id;
}

if ( ! empty( $gallery_ids ) ) {
	foreach ( $gallery_ids as $gallery_id ) {
		if ( $gallery_id !== $post_thumbnail_id ) {
			$image_ids[] = $gallery_id;
		}
	}
}

$wrapper_classes = array(
	'product-images',
	! empty( $image_ids ) ? 'custom-product-gallery--with-images' : 'custom-product-gallery--without-images',
);
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
	<?php if ( ! empty( $image_ids ) ) :
		wp_enqueue_style('swiper');
		wp_enqueue_script('mindverse-carousel');
		wp_enqueue_script('wc-carousel-js');
		wp_enqueue_style('wc-carousel-style');
		
		$swiper_settings = [
			'allowTouchMove'      => false,
			'centeredSlides'      => false,
			'direction'           => 'horizontal',
			'rows'                => '1',
			'autoplay'            => false,
			'freeMode'            => false,
			'initialSlide'        => 0,
			'loop'                => false,
			'mousewheel'          => false,
			'navigation'          => false,
			'pagination'          => '',
			'scrollbar'           => false,
			'speed'               => 500,
			'touchRatio'          => 1,
			'slides_per_view_xs'  => 1,
			'slides_per_view_sm'  => 1,
			'slides_per_view_md'  => 1,
			'slides_per_view_lg'  => 1,
			'slides_per_view_xl'  => 1,
			'slides_per_view_xxl' => 1,
		];
		$swiper_settings = json_encode($swiper_settings);
	?>
		<div class="vertical-carousel custom-product-gallery__thumbs wow fadeIn" id="verticalCarousel">
			<div class="vc-viewport">
				<div class="vc-track">
					<?php foreach ( $image_ids as $image_id ) : ?>
						<div class="vc-item">
							<?php
							echo wp_get_attachment_image(
								$image_id,
								'woocommerce_single',
								false,
								array(
									'class' => 'custom-product-gallery__thumb-image',
								)
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="carousel custom-product-gallery">
			<div class="carousel-container swiper" data-swiper = "<?php echo esc_attr($swiper_settings); ?>">
				<div class="carousel-inner swiper-wrapper">
					<?php foreach ( $image_ids as $image_id ) : 
						$full_src   = wp_get_attachment_image_url( $image_id, 'full' );
						$image_html = wp_get_attachment_image(
							$image_id,
							'woocommerce_single',
							false,
							array(
								'class' => 'custom-product-gallery__main-image',
							)
						);
					?>
						<div class="carousel-item swiper-slide">
							<div class="image product-image">
								<?php pxl_print_html( $image_html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<?php
		$thumb_swiper_settings = [
			'touchRatio'        => 1,
			'allowTouchMove'    => true,
			'centeredSlides'    => false,
			'direction'         => 'horizontal',
			'autoplay'          => false,
			'freeMode'          => false,
			'initialSlide'      => 0,
			'loop'              => false,
			'mousewheel'        => false,
			'rows'              => 1,
			'pagination'        => false,
			'scrollbar'         => false,
			'speed'             => 300,
			'slides_per_view_xs'  => 3,
			'slides_per_view_sm'  => 4,
			'slides_per_view_md'  => 2,
			'slides_per_view_lg'  => 2,
			'slides_per_view_xl'  => 3,
			'slides_per_view_xxl' => 3,
			'spaceBetween'       => 15 
		];
			$thumb_swiper_settings = json_encode($thumb_swiper_settings);
		?>
		<div class="carousel wow fadeIn" id="horizontalCarousel">
			<div class="carousel-container swiper" data-swiper = "<?php echo esc_attr($thumb_swiper_settings); ?>">
				<div class="carousel-inner swiper-wrapper">
					<?php foreach ( $image_ids as $image_id ) : 
						$full_src   = wp_get_attachment_image_url( $image_id, 'full' );
						$image_html = wp_get_attachment_image(
							$image_id,
							'woocommerce_single',
							false,
							array(
								'class' => 'custom-product-gallery__main-image',
							)
						);
					?>
						<div class="carousel-item swiper-slide">
							<div class="image product-image">
								<?php pxl_print_html( $image_html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

	<?php else : ?>

		<div class="custom-product-gallery__placeholder">
			<img
				src="<?php echo esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ); ?>"
				alt="<?php echo esc_attr__( 'Awaiting product image', 'mindverse' ); ?>"
				class="wp-post-image"
			/>
		</div>

	<?php endif; ?>
</div>