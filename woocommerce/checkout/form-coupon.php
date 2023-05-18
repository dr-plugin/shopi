<?php
defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}
?>
کد تخفیف دارم
<label class="switch">
<input type="checkbox" id="checkoutckeckbox">
<span class="slider round"></span>
</label>
	<div id="div-form-continer" class="appear-from-below"><br>
	<form class="form-coupon" method="post" id="acopon_form">
		<input type="text" name="coupon_code" class="btn-cart" placeholder="اینجا وارد کنید." id="coupon_code" value="" />
		<button type="submit" class="btn-cart" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">اعمال کوپن</button>
	</form>
	</div>

<script >
jQuery("#checkoutckeckbox").click(function(){
	if (jQuery("#checkoutckeckbox").prop( 'checked' )){
		jQuery("#div-form-continer").slideDown();
	}else{
		jQuery("#div-form-continer").slideUp();
	}
});
</script>
<style>
div#div-form-continer {
   display:none;
}
button.btn-cart {
    position: absolute;
    top:3px;left:3px;
    width:30%;
    border-radius: 8px;
    border-color: #cdc5c5;
    padding:5px;
}
#coupon_code {
width:100%;
}

#acopon_form {
position: relative;
}

</style>
