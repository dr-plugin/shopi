<?php
defined( 'ABSPATH' ) || exit;
global $product;
$product_images_attr = $product_image_summary_class = '';

$product_images_class  	= shopi_product_images_class();
$product_summary_class 	= shopi_product_summary_class();
$single_product_class  	= shopi_single_product_class();
$content_class 			= shopi_get_content_class();
$product_design 		= shopi_product_design();
$breadcrumbs_position 	= shopi_get_opt( 'single_breadcrumbs_position' );
$image_width 			= shopi_get_opt( 'single_product_style' );
$full_height_sidebar    = shopi_get_opt( 'full_height_sidebar' );
$page_layout            = shopi_get_opt( 'single_product_layout' );
$tabs_location 			= shopi_get_opt( 'product_tabs_location' );
$reviews_location 		= shopi_get_opt( 'reviews_location' );

//Full width image layout
if ( $image_width == 5 ) {
	if ( 'wpb' === shopi_get_current_page_builder() ) {
		$product_images_class .= ' vc_row vc_row-fluid vc_row-no-padding';
		$product_images_attr = 'data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true"';
	} else {
		$product_images_class .= ' wd-section-stretch-content';
	}
}

$container_summary = $container_class = $full_height_sidebar_container = 'container';

if ( $full_height_sidebar && $page_layout != 'full-width' ) {
	$single_product_class[] = $content_class;
	$product_image_summary_class = 'col-lg-12 col-md-12 col-12';
} else {
	$product_image_summary_class = $content_class;
}

if ( shopi_get_opt( 'single_full_width' ) ) {
	$container_summary = 'container-fluid';
	$full_height_sidebar_container = 'container-fluid';
}

if ( $full_height_sidebar && $page_layout != 'full-width' ) {
	$container_summary = 'container-none';
	$container_class = 'container-none';
}

?>

<?php if ( ( ( $product_design == 'alt' && ( $breadcrumbs_position == 'default' || empty( $breadcrumbs_position ) ) ) || $breadcrumbs_position == 'below_header' ) && ( shopi_get_opt( 'product_page_breadcrumbs', '1' ) || shopi_get_opt( 'products_nav' ) ) ): ?>
	<div class="single-breadcrumbs-wrapper">
		<div class="container">
			<?php if ( shopi_get_opt( 'product_page_breadcrumbs', '1' ) ) : ?>
				<?php shopi_current_breadcrumbs( 'shop' ); ?>
			<?php endif; ?>

			<?php if ( shopi_get_opt( 'products_nav' ) ) : ?>
				<?php shopi_products_nav(); ?>
			<?php endif ?>
		</div>
	</div>
<?php endif ?>

<div class="container">
	<?php
		/**
		 * Hook: woocommerce_before_single_product.
		 */
		 do_action( 'woocommerce_before_single_product' );
		 if ( post_password_required() ) {
		 	echo get_the_password_form();
		 	return;
		 }
	?>
</div>

<?php if ( $full_height_sidebar && $page_layout != 'full-width' ) echo '<div class="' . $full_height_sidebar_container . '"><div class="row full-height-sidebar-wrap">'; ?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( $single_product_class, $product ); ?>>

	<div class="<?php echo esc_attr( $container_summary ); ?>">
		<?php
			/**
			 * Hook: shopi_before_single_product_summary_wrap.
			 *
			 * @hooked woocommerce_output_all_notices - 10
			 */
			do_action( 'shopi_before_single_product_summary_wrap' );
		?>

		<div class="row product-image-summary-wrap">
			<div class="product-image-summary <?php echo esc_attr( $product_image_summary_class ); ?>">
				<div class="row product-image-summary-inner">
					<div class="<?php echo esc_attr( $product_images_class ); ?> product-images" <?php echo !empty( $product_images_attr ) ? $product_images_attr: ''; ?>>
						<div class="product-images-inner">
							<?php
								/**
								 * woocommerce_before_single_product_summary hook
								 *
								 * @hooked woocommerce_show_product_sale_flash - 10
								 * @hooked woocommerce_show_product_images - 20
								 */
								do_action( 'woocommerce_before_single_product_summary' );
							?>
						</div>
					</div>
					<?php if ( $image_width == 5 && 'wpb' === shopi_get_current_page_builder() ): ?>
						<div class="vc_row-full-width"></div>
					<?php endif ?>
					<div class="<?php echo esc_attr( $product_summary_class ); ?> summary entry-summary">
						<div class="asummary-inner">
							<?php if ( ( ( $product_design == 'default' && ( $breadcrumbs_position == 'default' || empty( $breadcrumbs_position ) ) ) || $breadcrumbs_position == 'summary' ) && ( shopi_get_opt( 'product_page_breadcrumbs', '1' ) || shopi_get_opt( 'products_nav' ) ) ): ?>
								<div class="single-breadcrumbs-wrapper">
									<div class="single-breadcrumbs">
										<?php if ( shopi_get_opt( 'product_page_breadcrumbs', '1' ) ) : ?>
											<?php shopi_current_breadcrumbs( 'shop' ); ?>
										<?php endif; ?>

										<?php if ( shopi_get_opt( 'products_nav' ) ): ?>
											<?php shopi_products_nav(); ?>
										<?php endif ?>
									</div>
								</div>
							<?php endif ?>

							<?php
								/**
								 * woocommerce_single_product_summary hook
								 *
								 * @hooked woocommerce_template_single_title - 5
								 * @hooked woocommerce_template_single_rating - 10
								 * @hooked woocommerce_template_single_price - 10
								 * @hooked woocommerce_template_single_excerpt - 20
								 * @hooked woocommerce_template_single_add_to_cart - 30
								 * @hooked woocommerce_template_single_meta - 40
								 * @hooked woocommerce_template_single_sharing - 50
								 */
								do_action( 'woocommerce_single_product_summary' );
							?>
						</div>
					</div>
				</div><!-- .summary -->
			</div>
			<?php echo do_shortcode("[html_block id='3841']"); ?>
			<?php 
				if ( ! $full_height_sidebar ) {
					/**
					 * woocommerce_sidebar hook
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );
				}
			?>

		</div>
		
		<?php
			/**
			 * shopi_after_product_content hook
			 *
			 * @hooked shopi_product_extra_content - 20
			 */
			do_action( 'shopi_after_product_content' );
		?>

	</div>

	<?php if ( $tabs_location != 'summary' || $reviews_location == 'separate' ) : ?>
		<div class="product-tabs-wrapper">
			<div class="<?php echo esc_attr( $container_class ); ?>">
				<div class="row">
					<div class="col-12 poduct-tabs-inner">
						<?php
							/**
							 * woocommerce_after_single_product_summary hook
							 *
							 * @hooked woocommerce_output_product_data_tabs - 10
							 * @hooked woocommerce_upsell_display - 15
							 * @hooked woocommerce_output_related_products - 20
							 */
							do_action( 'woocommerce_after_single_product_summary' );
						?>
					</div>
				</div>	
			</div>
		</div>
	<?php endif; ?>

	<?php do_action( 'shopi_after_product_tabs' ); ?>

	<div class="<?php echo esc_attr( $container_class ); ?> related-and-upsells"><?php 
		/**
		 * shopi_woocommerce_after_sidebar hook
		 *
		 * @hooked woocommerce_upsell_display - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'shopi_woocommerce_after_sidebar' );
	?></div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php 
	if ( $full_height_sidebar && $page_layout != 'full-width' ) {
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	}
?>

<?php if ( $full_height_sidebar && $page_layout != 'full-width' ) echo '</div></div>'; ?>
<style>.summary.entry-summary , .product-images{background-color:white;box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;padding-top: 8px;padding-bottom:8px;}.product-tabs-wrapper{box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;}
.wd-btn-arrow::after {background-color:#686363;color: white;border-radius:50%;padding:3px;}.wd-btn-arrow.disabled{display:none;}
tr.woocommerce-product-attributes-item{border-bottom:1px solid #e8e8e8;}.price .amount{font-size: 19px;}
.wd-compare-btn.product-compare-button.wd-action-btn.wd-style-text.wd-compare-icon , .wd-wishlist-btn.wd-action-btn.wd-style-text.wd-wishlist-icon{justify-content:center;width:100%;}
.wd-compare-btn.product-compare-button.wd-action-btn.wd-style-text.wd-compare-icon{border-top:1px solid #e8e8e8;padding-top:5px;}
p.price {border-bottom:2px solid #e8e8e8;}
@media only screen and (max-width: 600px) {
 .elementor.elementor-3841 { margin:-5px 0 -10px 0;}
}
@media (min-width:700px) {
.elementor.elementor-3841{ margin: 15px 0 -29px 0;}.col-lg-5.col-12.col-md-6.product-images {margin-left: 20px;}
}
</style>