<?php
/**
 * Checkout form — Bomflor theme override
 *
 * Simplified structure: no col2-set wrapper.
 * Billing renders directly inside #customer_details.
 * Delivery fields injected via woocommerce_checkout_after_customer_details hook.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @version 3.5.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<div class="woocommerce-NoticeGroup woocommerce-NoticeGroup-checkout"></div>

	<div class="bf-checkout-left">
		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div id="customer_details">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>
	</div>

	<div class="bf-checkout-right">
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<h3 id="order_review_heading"><?php esc_html_e( 'Tu Pedido', 'bomflor' ); ?></h3>

		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
