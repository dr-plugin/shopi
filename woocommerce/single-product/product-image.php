<?php
defined( 'ABSPATH' ) || exit;//tical.ir
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}
global $product;
$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);
?>
<?php //if( $product->is_on_sale() && $product->is_in_stock()) {
		//	$regular_price 	= get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
		//	$regular_price = (int) $regular_price;
		//	$saleDate = date('Y-m-d',$regular_price);
		//	$date_now =  date("Y-m-d");
?>
<?php //if($saleDate > $date_now ): ?>

<?php //endif; <div class="sale-single-product sale-date" date="<?php echo $saleDate"><span class="sale-timer"></span></div> ?> 
<?php //} ?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">

	<?php //اضافه کردن برچسب های فروشگاه به صفحه محصول تکی
		add_out_stock_text_function();
	?>

	<figure class="woocommerce-product-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) {
			$html = wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
		do_action( 'woocommerce_product_thumbnails' );
		?>
<?php //این کد تگ فیگور به عکسهای وکامرس اضاف میکنه/
//<figcaption><?php echo wp_get_attachment_caption($post_thumbnail_id) ; <///////figcaption> 
?>
	</figure>
</div>
