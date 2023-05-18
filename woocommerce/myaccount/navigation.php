<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<nav id="col-filter-id" class="woocommerce-MyAccount-navigation">
	<a id="btn-close-id" class="ashow-mobile-only menu-toggle" >✘ بستن</a>
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?>
				<i class="fas fa-angle-double-left"></i>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<style>
.namecontiner a:not(#filter-btn){float:left;font-size: 22px;}
.namecontiner {
    border-bottom: 1px solid #e7dfdf;
    padding: 8px;
}
.namecontiner span {
    background-color: #e6daf6;
    padding: 8px;
    border-top-left-radius: 50%;
    border-bottom-right-radius: 50%;
    border-top-right-radius: 50%;
}
nav#col-filter-id li:hover i {
    transform: translateX(-10px);
}
nav#col-filter-id i {
    float: left;
    margin-left: 10px;
	margin-top: 4px;
}
.woocommerce-MyAccount-content input:not(#link-input , #tiBtnCopy){width: 100%;}
li.woocommerce-MyAccount-navigation-link a:hover{background-color:#e6daf6;}
@media (min-width: 900px){
.woocommerce-MyAccount-content {
    width: 79%;
    float: left;
    padding-right:8px;
}
nav#col-filter-id {
float: right;
width: 20%;
border-left: 1px solid #e7dfdf;
}
li.woocommerce-MyAccount-navigation-link a {
display: block;
border-bottom: 1px solid #e3dada;
padding: 5px;
}
}
@media (max-width: 900px){
	.namecontiner span{margin-right:30%;}
	.woocommerce-MyAccount-content {
		margin-top:10px;
	}
	nav#col-filter-id li > a {
		display: block;
		border-bottom: 1px solid #cdcdcd;
		padding: 10px;
	}
	nav#col-filter-id {
		background-color: white;
		border-left: 3px solid #cdcdcd;
	}
}
</style>