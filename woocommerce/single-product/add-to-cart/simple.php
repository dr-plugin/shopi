<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $product;
$sss = $product->get_max_purchase_quantity();
$add_to_cart_text = 'خرید محصول';
$quanfiled = '';
if($sss == -1 && $product->is_in_stock()) {
$quanfiled = woocommerce_quantity_input( array(), $product, false ) ;
}
if ($product->is_in_stock()){
$html = sprintf( '<div style="display:flex;align-content:center;justify-content:center;" class="asingleproductaddtocart"> %s<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" id="special-btn" class="button add_to_cart_button ajax_add_to_cart">%s</a></div>',
			$quanfiled,
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $quantity ) ? $quantity : 1 ),
            esc_attr( $product->get_id() ),
            esc_attr( $product->get_sku() ),
          //  esc_attr( isset( $class ) ? $class : 'button' ),
            esc_html($add_to_cart_text)
        );
echo $html;
}else{
	echo '<button continerId="c__newsLetter" class="popupOpen outofstock-btn"><i aria-hidden="true" class="far fa-bell"></i>
	وقتی موجود شد خبرم بده
	(موجود نیست)</button>';
}
?>
<script type='text/javascript'>
        jQuery(function($){
            // Update data-quantity quantity-table
            $(document.body).on('change input', 'input.qty', function() {
                $(this).parent().parent().find('a.ajax_add_to_cart').attr('data-quantity', $(this).val());
               // $(".added_to_cart").remove(); // Optional: Removing other previous "view cart" buttons
            }).on('click', '.add_to_cart_button', function(){
				$("#quantity-table").slideDown();
                var button = $(this);
                setTimeout(function(){
                    button.parent().find('.quantity > input.qty').val(1); // reset quantity to 1
                }, 1000); // After 1 second

            });
        });
    </script>
<?php