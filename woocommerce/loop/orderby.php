<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
	//ferfri.ir
}
?>
<div class="ashow-mobile-only" >
<form class="woocommerce-ordering" method="get" id="aioConceptName" action="javascript:void(0);">
	<select name="orderby" class="orderby" >
	<option value="1" >مرتب سازی بر اساس نام </option>
	<option value="2" >مرتب سازی از ارزان ترین</option>
	<option value="3" >مرتب سازی از گرانترین</option>
	<option value="4" >مرتب سازی از جدیدترین</option>
	<option value="5" >مرتب سازی از محبوت ترین</option>
	<option value="6" >مرتب سازی براساس موجود بودن</option>
	</select>
	<input type="hidden" name="paged" value="1" />
	<?php wp_nonce_field( 'select_name_of_my_action', 'select_name_of_nonce_field' ); ?>
</form>
</div>
<div class="ashow-desktop-only">
مرتب سازی بر اساس:
<button type="button" value="1">الفبا</button>
<button type="button" value="2">ارزان ترین</button>
<button type="button" value="3">گران ترین</button>
<button type="button" value="4">جدیدترین</button>
<button type="button" value="5">محبوت ترین</button>
<button type="button" value="6">موجود بودن</button>
</div>
<style>
.ashow-desktop-only button{border:none;}
.ashow-desktop-only {background-color: white;margin-bottom: 14px;padding: 3px;border-radius:5px;}
a#filter-btn {margin-bottom: 10px}</style>