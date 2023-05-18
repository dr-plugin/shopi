<?php
//tical template

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<?php 
		if ( $average ) {
			if($average > 4 ):?>
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
			<?php endif; 
		} ?>


		<?php if ( comments_open() ) : ?>
			
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				(<?php echo $review_count; ?>دیدگاه)
			</a>

		<?php endif ?>
	</div>

<?php endif; ?>
