<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;


// if ($product->is_type( 'simple' )) {
// 	$regular_price = (float) $product->get_regular_price();
// 	$sale_price = (float) $product->get_price();
// }elseif ($product->is_type('variable')){
// 	$sale_price     =  $product->get_variation_sale_price( 'min', true );
//     $regular_price  =  $product->get_variation_regular_price( 'max', true );
// }
// if(! $regular_price)
// 	return;

// $sale_flash_msg =  round(($regular_price - $sale_price)/$regular_price*100);