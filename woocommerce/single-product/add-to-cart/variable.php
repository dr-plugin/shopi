<?php
   defined( 'ABSPATH' ) || exit;
   global $product;
   $attribute_keys  = array_keys( $attributes );
   $variations_json = wp_json_encode( $available_variations );
   $variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
   do_action( 'woocommerce_before_add_to_cart_form' ); ?>
<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
   <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
   <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
   <?php else : ?>
   <table class="variations" cellspacing="0">
      <tbody>
         <?php $variations_arr = array();
            foreach ( $attributes as $attribute_name => $options ) : ob_start(); ?>
         <tr>
            <td class="label"><label for="<?php echo sanitize_title( $attribute_name ); ?>">
               <?php echo wc_attribute_label( $attribute_name ); ?></label>
            </td>
            <td class="value">
               <div style="opacity:0;visibility:hidden;height:2px;">
                  <?php 
                     $selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
                     wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name, 'product' => $product, 'selected' => $selected ) ); 
                     ?>
               </div>
               <?php
                  $values = wc_get_product_terms( $product->id, $attribute_name, array( 'fields' =>  'all' ) );
                  if( $values ){
                  	foreach ( $values as $term ){
                  		$termdescrip = term_description( $term->term_id );
                  		$termdescrip = trim($termdescrip, '<p>');
                  		$termdescrip = substr($termdescrip, 0, -5);
                   		echo '<input style="background:'.$termdescrip.'"type="button" class="vbutton" value="'.$term->name.'">';
                  		echo '<input type="hidden" class="vvalue" value="'.$term->slug.'">';		
                  		}
                  	
                  }
                  echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations" href="#"> پاک کردن </a>' : ''; 
                  ?>
            </td>
         </tr>
         <?php $variations_ob = ob_get_clean(); $variations_arr[wc_attribute_label($attribute_name)] = $variations_ob; endforeach;
            foreach ($variations_arr as $name => $ob) 
            { 
            	echo str_ireplace('choose an option', 'Choose '.$name, $ob );
            } 
            ?>
      </tbody>
   </table>
   <div class="single_variation_wrap">
      <?php do_action( 'woocommerce_single_variation' ); ?>
   </div>
   <?php 
      endif; 
      $sss = $product->get_max_purchase_quantity();
      if ($sss == 1){
      	echo '<style>.quantity.buttons_added {display: none;}</style>';
      } 
      ?>
</form>
<script>
   jQuery(document).ready(function ($) {
   	$(".vbutton").on('click', function() {
   	var vvalue = $('.vvalue').val();
   	$("form.cart select").val(vvalue).change();
   	});
   });
</script>
<style>
   input.vbutton {
   margin-left:10px;
   border: 1px solid;
   border-radius: 8px;
   }
   a.reset_variations {
   font-size: 15px !important;
   color:red;
   font-family: 'dashicons';
   font-family: 'yekan';
   }
</style>