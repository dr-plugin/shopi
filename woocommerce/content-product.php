<?php
defined( 'ABSPATH' ) || exit;
global $product;
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li	<?php wc_product_class( '', $product ); ?>>
	<?php
	do_action( 'woocommerce_before_shop_loop_item' );
	do_action( 'woocommerce_before_shop_loop_item_title' );
	?>
	<div id="ttt">
	<?php do_action( 'woocommerce_shop_loop_item_title' );?>
	<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
	
	</div>
	
	<br>
	<div class="addtocartdiv" >
	<?php do_action( 'woocommerce_after_shop_loop_item' );?>
	</div>
</li>
