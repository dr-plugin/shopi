<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$svg = 'افزودن';
global $product;
if (!$product->is_in_stock()){
	$add_to_cart_text = '<span>ناموجود</span>';
}else if($product->is_type('variable')){
	$add_to_cart_text = $svg;
} else{
$add_to_cart_text = $svg;
}

echo apply_filters( 'woocommerce_loop_add_to_cart_link', 
	sprintf( '<a href="%s" data-quantity="%s" class="%s add-to-cart-loop" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		$add_to_cart_text
	),
$product, $args );