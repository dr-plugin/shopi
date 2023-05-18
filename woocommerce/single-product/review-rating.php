<?php
//tical template
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

if ( $rating ) {

	if($rating > 4 ):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/5.svg">
	<?php endif;?>
	<?php if($rating > 3 && $rating <= 4):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/4.svg">
	<?php endif;?>
	<?php if($rating > 2 && $rating <= 3):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/3.svg">
	<?php endif;?>
	<?php if($rating > 1 && $rating <= 2):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/2.svg">
	<?php endif;?>
	<?php if($rating <= 1):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/1.svg">
	<?php endif;
}
