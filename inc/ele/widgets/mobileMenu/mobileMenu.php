<?php
if (function_exists('sh_mobileMenuRender')) {
	return;
}


function sh_mobileMenuRender($settings)
{
	$menuId = $settings['menu-select'];
	$openingFrom = $settings['opening'];


	
	$menu = wp_nav_menu(array(
		'menu'           => $menuId ,
		'echo' 			 => false ,
		'container'      => 'div',
		'container_class'=> 'position-fixed mobileMenu',
		'container_id'	 => 'mobileMenu',
		'items_wrap'     => '<ul id="frist-ul" data-open="'.$openingFrom.'" > <li><a href="#" class="back" >بستن<i aria-hidden="true" class="fas fa-arrow-right"></i></a></li>%3$s</ul>',
		'walker' 		 => new mobile_menu_Walker_Nav_Menu()
	));

	echo $menu;
}

class mobile_menu_Walker_Nav_Menu extends Walker_Nav_Menu 
{

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// Depth-dependent classes.
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
			

		// Build HTML for output.
		$output .= '<div class="mobileMenu position-fixed"><ul>';
		$output .= '<li><a href="#" class="back">بازگشت<i aria-hidden="true" class="fas fa-arrow-right"></i></a></li>' . "\n";
	}


	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) 
	{
		//global $wp_query;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// Depth-dependent classes.
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// Build HTML.
		$output .='<li>';

		// Link attributes.
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
	//	$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$icon = '<i aria-hidden="true" class="fas fa-arrow-left"></i>' ;


		// Build HTML output and pass through the proper filter.
		$item_output = sprintf( '<a%3$s>%5$s %1$s</a>',
			$icon ,
			$args->before,
			//محتویات درون تگ لینک
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		$output .= $item_output;
	}
}