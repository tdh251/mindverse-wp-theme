<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2><?php esc_html_e( 'Cart total', 'mindverse' ); ?></h2>

	<div class="shop_table shop_table_responsive cart-totals-table">

		<div class="cart-subtotal cart-totals-table__item">
			<div class="label"><?php esc_html_e( 'Subtotal', 'mindverse' ); ?></div>
			<div class="value" data-title="<?php esc_attr_e( 'Subtotal', 'mindverse' ); ?>">
				<?php wc_cart_totals_subtotal_html(); ?>
			</div>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount cart-totals-table__item coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<div class="label"><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
				<div class="value price" data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>">
					<?php wc_cart_totals_coupon_html( $coupon ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<div class="cart-totals-table__item">
				<?php wc_cart_totals_shipping_html(); ?>
			</div>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<div class="shipping cart-totals-table__item">
				<div class="label"><?php esc_html_e( 'Shipping', 'mindverse' ); ?></div>
				<div class="value" data-title="<?php esc_attr_e( 'Shipping', 'mindverse' ); ?>">
					<?php woocommerce_shipping_calculator(); ?>
				</div>
			</div>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee cart-totals-table__item">
				<div class="label"><?php echo esc_html( $fee->name ); ?></div>
				<div class="value" data-title="<?php echo esc_attr( $fee->name ); ?>">
					<?php wc_cart_totals_fee_html( $fee ); ?>
				</div>
			</div>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				$estimated_text = sprintf(
					' <small>' . esc_html__( '(estimated for %s)', 'mindverse' ) . '</small>',
					WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ]
				);
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
					?>
					<div class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?> cart-totals-table__item">
						<div class="label">
							<?php echo esc_html( $tax->label ) . $estimated_text; ?>
						</div>
						<div class="value" data-title="<?php echo esc_attr( $tax->label ); ?>">
							<?php echo wp_kses_post( $tax->formatted_amount ); ?>
						</div>
					</div>
					<?php
				}
			} else {
				?>
				<div class="tax-total cart-totals-table__item">
					<div class="label">
						<?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?>
					</div>
					<div class="value" data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>">
						<?php wc_cart_totals_taxes_total_html(); ?>
					</div>
				</div>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="order-total cart-totals-table__item">
			<div class="label"><?php esc_html_e( 'Total', 'mindverse' ); ?></div>
			<div class="value" data-title="<?php esc_attr_e( 'Total', 'mindverse' ); ?>">
				<?php wc_cart_totals_order_total_html(); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</div>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>