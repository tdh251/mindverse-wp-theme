<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$cart_headers = array(
	'thumb'    => '',
	'product'  => esc_html__( 'Product', 'mindverse' ),
	'price'    => esc_html__( 'Price', 'mindverse' ),
	'quantity' => esc_html__( 'Quantity', 'mindverse' ),
	'subtotal' => esc_html__( 'Subtotal', 'mindverse' ),
	'remove'   => '',
);
?>

<form class="woocommerce-cart-form cart-layout" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<div class="cart-table">

		<div class="cart-table__head">
			<div class="cart-table__col cart-table__col--thumb">
				<?php echo esc_html( $cart_headers['thumb'] ); ?>
			</div>
			<div class="cart-table__col cart-table__col--product">
				<?php echo esc_html( $cart_headers['product'] ); ?>
			</div>
			<div class="cart-table__col cart-table__col--price">
				<?php echo esc_html( $cart_headers['price'] ); ?>
			</div>
			<div class="cart-table__col cart-table__col--quantity">
				<?php echo esc_html( $cart_headers['quantity'] ); ?>
			</div>
			<div class="cart-table__col cart-table__col--subtotal">
				<?php echo esc_html( $cart_headers['subtotal'] ); ?>
			</div>
			<div class="cart-table__col cart-table__col--remove">
				<?php echo esc_html( $cart_headers['remove'] ); ?>
			</div>
		</div>

		<div class="cart-table__body">
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters(
						'woocommerce_cart_item_permalink',
						$_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
						$cart_item,
						$cart_item_key
					);

					$image_id = $_product->get_image_id();

					$thumbnail = apply_filters(
						'woocommerce_cart_item_thumbnail',
						wp_get_attachment_image(
							$image_id,
							'full',
							false,
							array(
								'alt'     => $_product->get_name(),
								'class'   => 'cart-product-image',
								'loading' => 'lazy',
							)
						),
						$cart_item,
						$cart_item_key
					);

					if ( $_product->is_sold_individually() ) {
						$min_quantity = 1;
						$max_quantity = 1;
					} else {
						$min_quantity = 0;
						$max_quantity = $_product->get_max_purchase_quantity();
					}

					$product_quantity = woocommerce_quantity_input(
						array(
							'input_name'   => "cart[{$cart_item_key}][qty]",
							'input_value'  => $cart_item['quantity'],
							'max_value'    => $max_quantity,
							'min_value'    => $min_quantity,
							'product_name' => $product_name,
						),
						$_product,
						false
					);
					?>

					<div class="cart-table__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<div
							class="cart-table__col cart-table__col--thumb product-thumbnail"
						>
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( $thumbnail );
							} else {
								printf(
									'<a href="%s">%s</a>',
									esc_url( $product_permalink ),
									$thumbnail // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								);
							}
							?>
						</div>

						<div
							class="cart-table__col cart-table__col--product product-name"
							data-title="<?php echo esc_attr( $cart_headers['product'] . ':' ); ?>"
						>
							<?php
							if ( ! $product_permalink ) {
								echo wp_kses_post( $product_name . '&nbsp;' );
							} else {
								echo wp_kses_post(
									apply_filters(
										'woocommerce_cart_item_name',
										sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ),
										$cart_item,
										$cart_item_key
									)
								);
							}

							do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

							echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo wp_kses_post(
									apply_filters(
										'woocommerce_cart_item_backorder_notification',
										'<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'mindverse' ) . '</p>',
										$product_id
									)
								);
							}
							?>
						</div>

						<div
							class="cart-table__col cart-table__col--price product-price"
							data-title="<?php echo esc_attr( $cart_headers['price']. ':' ); ?>"
						>
							<?php
							echo apply_filters(
								'woocommerce_cart_item_price',
								WC()->cart->get_product_price( $_product ),
								$cart_item,
								$cart_item_key
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<div
							class="cart-table__col cart-table__col--quantity product-quantity"
							data-title="<?php echo esc_attr( $cart_headers['quantity']. ':' ); ?>"
						>
							<?php
							echo apply_filters(
								'woocommerce_cart_item_quantity',
								$product_quantity,
								$cart_item_key,
								$cart_item
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<div
							class="cart-table__col cart-table__col--subtotal product-subtotal"
							data-title="<?php echo esc_attr( $cart_headers['subtotal']. ':' ); ?>"
						>
							<?php
							echo apply_filters(
								'woocommerce_cart_item_subtotal',
								WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ),
								$cart_item,
								$cart_item_key
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

						<div
							class="cart-table__col cart-table__col--remove product-remove"
						>
							<?php
							echo apply_filters(
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a role="button" href="%s" class="remove remove-cart-item" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr( sprintf( __( 'Remove %s from cart', 'mindverse' ), wp_strip_all_tags( $product_name ) ) ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								),
								$cart_item_key
							); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							?>
						</div>

					</div>

					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>
		</div>

		<div class="cart-table__actions">
			<?php if ( wc_coupons_enabled() ) : ?>
				<div class="coupon">
					<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'mindverse' ); ?></label>
					<input
						type="text"
						name="coupon_code"
						class="input-text"
						id="coupon_code"
						value=""
						placeholder="<?php esc_attr_e( 'Coupon code', 'mindverse' ); ?>"
					/>
					<button
						type="submit"
						class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
						name="apply_coupon"
						value="<?php esc_attr_e( 'Apply coupon', 'mindverse' ); ?>"
					>
						<?php esc_html_e( 'Apply coupon', 'mindverse' ); ?>
					</button>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php endif; ?>

			<button
				type="submit"
				class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>"
				name="update_cart"
				value="<?php esc_attr_e( 'Update cart', 'mindverse' ); ?>"
			>
				<?php esc_html_e( 'Update cart', 'mindverse' ); ?>
			</button>

			<?php do_action( 'woocommerce_cart_actions' ); ?>
			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php do_action( 'woocommerce_cart_collaterals' ); ?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>