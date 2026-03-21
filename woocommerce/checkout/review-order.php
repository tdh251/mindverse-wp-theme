<div class="shop_table woocommerce-checkout-review-order-table review-order-table">

	<div class="review-order-table__head">
		<div class="review-order-table__col review-order-table__col--name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></div>
		<div class="review-order-table__col review-order-table__col--total"><?php esc_html_e( 'Price', 'woocommerce' ); ?></div>
	</div>

	<div class="review-order-table__body">
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<div class="review-order-table__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<div class="review-order-table__col review-order-table__col--name product-name">
						<a href="<?php echo esc_url( $_product->get_permalink() ); ?>">
							<?php
							echo wp_kses_post(
								apply_filters(
									'woocommerce_cart_item_name',
									$_product->get_name(),
									$cart_item,
									$cart_item_key
								)
							);
							?>
						</a>

						<?php
						echo apply_filters(
							'woocommerce_checkout_cart_item_quantity',
							' <span class="product-quantity">x' . $cart_item['quantity'] . '</span>',
							$cart_item,
							$cart_item_key
						);
						?>

						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
					</div>

					<div class="review-order-table__col review-order-table__col--total product-total">
						<?php
						echo apply_filters(
							'woocommerce_cart_item_subtotal',
							WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ),
							$cart_item,
							$cart_item_key
						);
						?>
					</div>

				</div>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</div>

	<div class="review-order-table__foot">

		<div class="review-order-table__item cart-subtotal">
			<div class="review-order-table__col review-order-table__col--label label">
				<?php esc_html_e( 'Subtotal', 'woocommerce' ); ?>
			</div>
			<div class="review-order-table__col review-order-table__col--value value">
				<?php wc_cart_totals_subtotal_html(); ?>
			</div>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="review-order-table__item cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<div class="review-order-table__col review-order-table__col--label label">
					<?php wc_cart_totals_coupon_label( $coupon ); ?>
				</div>
				<div class="review-order-table__col review-order-table__col--value value">
					<?php wc_cart_totals_coupon_html( $coupon ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<div class="review-order-table__item shipping">
				<div class="review-order-table__col review-order-table__col--full">
					<?php wc_cart_totals_shipping_html(); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="review-order-table__item fee">
				<div class="review-order-table__col review-order-table__col--label label">
					<?php echo esc_html( $fee->name ); ?>
				</div>
				<div class="review-order-table__col review-order-table__col--value value">
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>

			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="review-order-table__item tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<div class="review-order-table__col review-order-table__col--label label">
							<?php echo esc_html( $tax->label ); ?>
						</div>
						<div class="review-order-table__col review-order-table__col--value value">
							<?php echo wp_kses_post( $tax->formatted_amount ); ?>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="review-order-table__item tax-total">
					<div class="review-order-table__col review-order-table__col--label label">
						<?php echo esc_html( WC()->countries->tax_or_vat() ); ?>
					</div>
					<div class="review-order-table__col review-order-table__col--value value">
						<?php wc_cart_totals_taxes_total_html(); ?>
					</div>
				</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="review-order-table__item order-total">
			<div class="review-order-table__col review-order-table__col--label label">
				<?php esc_html_e( 'Total', 'woocommerce' ); ?>
			</div>
			<div class="review-order-table__col review-order-table__col--value value">
				<?php wc_cart_totals_order_total_html(); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>

</div>