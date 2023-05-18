<?php
defined( 'ABSPATH' ) || exit;
//do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
سبد خرید خالیه به
		<a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			فروشگاه
		</a>
		برگرد یا از محصولات نشان شده انتخاب کن
	</p>
<?php endif; ?>
<div class="atable-product-sum">
	<?php echo do_shortcode('[wishlist]');?>
</div>