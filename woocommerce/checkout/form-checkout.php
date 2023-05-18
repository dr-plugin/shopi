<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! is_user_logged_in() ) {
	include  HELLOO_CHILDE_DIR . "template/login-form.php";
	wp_footer();
	exit();
}
?>
<div class="ashowbag">
	<div class="bbbb main-coupon-continer">
	<?php //این تابع در افزونه کیف پول ایجاد شده است. 
	 kff_get_bag_value(); 
	?>
	</div>
	<div class="bbbb main-coupon-continer"><?php do_action( 'woocommerce_before_checkout_form', $checkout ); ?></div>
</div>	
<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" data-formrun-alert-dialog>
	<div class="col2-set" id="customer_details">
			<div class="col-2">
					<?php if ( $checkout->get_checkout_fields() ) : ?>
					<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
					<?php endif; ?>
					
			</div>
			
			<div class="col-1 checkout-order-review">	
				<h3>سفارش شما</h3>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
				</div>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
	</div>
</form>
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<style>
.button#place_order {
    background-color: #6A1B9A;
    color: white;
    pointer-events: visiblestroke;
    cursor: pointer;
    width: 100%;
	border-radius: 10px;
}
.shop_table tr {
    background-color: white;
    padding: 10px;
}
table.shop_table {
    border-radius: 10px;
    padding: 4px;
    background-color: #f5cbcb;
}
ul#shipping_method {
    list-style: none;
    /* padding: 0; */
}
ul.wc_payment_methods.payment_methods.methods li {
    background-color: #f5cbcb;
    margin-top: 10px;
    border-radius: 10px;
	padding: 10px;
}
ul.wc_payment_methods.payment_methods.methods {
    list-style: none;
	padding: 0;
}
.woocommerce-billing-fields__field-wrapper input {
    width: 100%;
}
input:focus{box-shadow:0 0 5px 1px #e6daf6}
input{border: 1px solid #c1c1c1;border-radius: 8px;}
@media (max-width:961px) {
.col-1.checkout-order-review {margin-top: 10px;}
 }
@media (min-width:961px) {
.bbbb{width:50%;}
.ashowbag{display:flex;column-gap: 10px;align-items:stretch;}
 div#customer_details {display:flex;column-gap:10px; flex-direction:row;column-count:2;}
 }
.col-1.checkout-order-review , .col-2{
    background-color: white;
    border: 1px solid #7a7a7a5e;
    padding:10px;
    border-radius: 8px;
}
.main-coupon-continer {
    background-color: white;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 9px;
    border: 1px solid #e7e7e7;
}
p#billing_country_field{display: none;}
</style>