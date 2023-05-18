<?php
//tical template
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}
$average      = $product->get_average_rating();
$rating_count = $product->get_rating_count();

if ( $average > 0 ) : ?>
	<div class="acomment-div">
	<span>
	<?php echo $rating_count; ?> 
	دیدگاه
	</span>
	<?php if($average > 4 ):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/5.svg">
	<?php endif;?>
	<?php if($average > 3 && $average <= 4):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/4.svg">
	<?php endif;?>
	<?php if($average > 2 && $average <= 3):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/3.svg">
	<?php endif;?>
	<?php if($average > 1 && $average <= 2):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/2.svg">
	<?php endif;?>
	<?php if($average <= 1):?>
		<img src="https://tical.ir/files/themes/hello-elementor-child/woocommerce/single-product/1.svg">
	<?php endif;?>
	</div>
<?php endif;?>