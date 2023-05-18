<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$delimiter = '&nbsp';
if ( ! empty( $breadcrumb ) ) {
	//echo wp_kses_post( $wrap_before );
	$count = count($breadcrumb);
	$home = 'خانه ';
	?><div class="abreadcrumb-class"><?php
	//echo '<button onclick="history.go(-1);" style="padding: 0 0 0 10px; font-size: 17px;"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>';
	if(!is_shop()){echo '<a href="https://tical.ir/cosmetic/">فروشگاه </a>';}
	if(is_shop()){echo '<a href="https://tical.ir">'.$home.'</a>';}
	if(is_checkout()){echo '<a href="https://tical.ir/cart">سبد خرید</a>';}
	//echo $delimiter;
	foreach ( $breadcrumb as $key => $crumb ) {
				
			if ($crumb[0] != 'خانه'){
				echo $delimiter;
				if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
					
echo '<a href="' . esc_url( $crumb[1] ) . '" class="">' . esc_html( $crumb[0] ) . '</a>';
					
				}else {
						echo '<span>' . esc_html( $crumb[0] ) . '</span>';
					}
		 	 }
	}
	?></div><?php
	//echo wp_kses_post( $wrap_after );
}