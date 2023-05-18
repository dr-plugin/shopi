<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
?>
<div class="priceTemplate">
<?php
if($product->is_on_sale() && $product->is_in_stock()){
	if ($product->is_type( 'simple' )) {
	$regular_price = (float) $product->get_regular_price();
	$sale_price = (float) $product->get_price();
	}elseif ($product->is_type('variable')){
	$sale_price     =  $product->get_variation_sale_price( 'min', true );
	$regular_price  =  $product->get_variation_regular_price( 'max', true );
	}
	$sale_flash_msg =  round(($regular_price - $sale_price)/$regular_price*100);
	$sale_flash_msg.= '%';
	echo '<span class="sale_flash">' .$sale_flash_msg. '</span>';
}
?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
</div>