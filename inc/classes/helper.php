<?php
if (!defined('SH_THEME_DIR')) {
	exit('No direct script access allowed');
}

if(! function_exists('sh_get_opt')){
	function sh_get_opt($option){

		return $option;
	}
}

if (!function_exists('sh_is_elementor_installed')) {
	/**
	 * Check if Elementor is activate
	 */
	function sh_is_elementor_installed()
	{
		return did_action('elementor/loaded');
	}
}

if (!function_exists('sh_is_new_label_needed')) {
	function sh_is_new_label_needed($product_id)
	{
		$date         = get_post_meta($product_id, '_sh_new_label_date', true);
		$new          = get_post_meta($product_id, '_sh_new_label', true);
		$newness_days = sh_get_opt('new_label_days_after_create');
		$product      = wc_get_product($product_id);
		$created      = strtotime($product->get_date_created());

		if ($new) {
			return true;
		}

		if ($date && time() <= strtotime($date)) {
			return true;
		}

		if ($newness_days && (time() - (60 * 60 * 24 * $newness_days)) < $created) {
			return true;
		}

		return false;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Add theme support for WooCommerce
 * ------------------------------------------------------------------------------------------------
 */

add_theme_support('woocommerce');
add_theme_support('wc-product-gallery-zoom');
/**
 * ------------------------------------------------------------------------------------------------
 * Check if WooCommerce is active
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('sh_woocommerce_installed')) {
	function sh_woocommerce_installed()
	{
		return class_exists('WooCommerce');
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * is ajax request
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('sh_is_woo_ajax')) {
	function sh_is_woo_ajax()
	{
		$request_headers = function_exists('getallheaders') ? getallheaders() : array();

		if (sh_is_elementor_installed() && sh_elementor_is_edit_mode()) {
			return apply_filters('xts_is_ajax', false);
		}

		if (defined('DOING_AJAX') && DOING_AJAX) {
			return 'wp-ajax';
		}

		if (isset($request_headers['x-pjax']) || isset($request_headers['X-PJAX']) || isset($request_headers['X-Pjax'])) {
			return 'full-page';
		}

		if (isset($_REQUEST['woo_ajax'])) {
			return 'fragments';
		}

		if (sh_is_pjax()) {
			return true;
		}

		return false;
	}
}

if (!function_exists('sh_is_pjax')) {
	function sh_is_pjax()
	{
		$request_headers = function_exists('getallheaders') ? getallheaders() : array();

		return isset($_REQUEST['_pjax']) && ((isset($request_headers['X-Requested-With']) && 'xmlhttprequest' === strtolower($request_headers['X-Requested-With'])) || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])));
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * Force Swatche layered nav and price widget to work
 * ------------------------------------------------------------------------------------------------
 */


add_filter('woocommerce_is_layered_nav_active', 'sh_is_layered_nav_active');
if (!function_exists('sh_is_layered_nav_active')) {
	function sh_is_layered_nav_active()
	{
		return is_active_widget(false, false, 'sh-woocommerce-layered-nav', true);
	}
}

add_filter('woocommerce_is_price_filter_active', 'sh_is_layered_price_active');

if (!function_exists('sh_is_layered_price_active')) {
	function sh_is_layered_price_active()
	{
		$result = is_active_widget(false, false, 'sh-price-filter', true);
		if (!$result) {
			$result = apply_filters('sh_use_custom_price_widget', true);
		}
		return $result;
	}
}

if (!function_exists('sh_get_current_term_id')) {
	/**
	 * FIX CMB2 bug
	 */
	function sh_get_current_term_id()
	{
		return isset($_REQUEST['tag_ID']) ? $_REQUEST['tag_ID'] : 0;
	}
}

/**
 * ------------------------------------------------------------------------------------------------
 * is product thumb enabled
 * ------------------------------------------------------------------------------------------------
 */
if (!function_exists('sh_is_product_thumb_enabled')) {
	function sh_is_product_thumb_enabled()
	{
		$thums_position = sh_get_opt('thums_position');
		$product_design = sh_get_opt('product_design');
		return ($product_design != 'sticky' && ($thums_position == 'bottom' || $thums_position == 'left'));
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Determine is it product attribute archive page
 * ------------------------------------------------------------------------------------------------
 */

if (!function_exists('sh_is_product_attribute_archive')) {
	function sh_is_product_attribute_archive()
	{
		$queried_object = get_queried_object();
		if ($queried_object && property_exists($queried_object, 'taxonomy')) {
			$taxonomy = $queried_object->taxonomy;
			return substr($taxonomy, 0, 3) == 'pa_';
		}
		return false;
	}
}

if (!function_exists('sh_get_name_by_path')) {
	function sh_get_name_by_path($path)
	{
		$name = basename($path);
		$name = explode('.' , $name);
		return $name[0];
	}
}