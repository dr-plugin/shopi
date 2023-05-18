<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" id="special-btn" style="width:96%;display:inline-block;text-align:center;">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
	<span>&#x21D0;</span>
</a>