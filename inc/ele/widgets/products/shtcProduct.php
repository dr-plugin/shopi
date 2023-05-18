<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if (!defined('ABSPATH')) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class shtcProduct extends Widget_Base
{

	public function get_name()
	{
		return 'show_products';
	}

	public function get_title()
	{
		return esc_html__('Products', 'sh_textdomain');
	}

	public function get_icon()
	{
		return 'eicon-post-slider';
	}

	public function get_categories()
	{
		return ['sh_category'];
	}

	public function get_product_attributes_array()
	{
		$attributes = [];

		if (sh_woocommerce_installed()) {
			foreach (wc_get_attribute_taxonomies() as $attribute) {
				$attributes[] = 'pa_' . $attribute->attribute_name;
			}
		}

		return $attributes;
	}

	protected function _register_controls()
	{
		// Content tab.
		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__('General', 'sh_textdomain'),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'       => esc_html__('Data source', 'sh_textdomain'),
				'description' => esc_html__('Select content type for your grid.', 'sh_textdomain'),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'product',
				'options'     => array(
					'product'            => esc_html__('All Products', 'sh_textdomain'),
					'featured'           => esc_html__('Featured Products', 'sh_textdomain'),
					'sale'               => esc_html__('Sale Products', 'sh_textdomain'),
					'new'                => esc_html__('Products with NEW label', 'sh_textdomain'),
					'bestselling'        => esc_html__('Bestsellers', 'sh_textdomain'),
					'ids'                => esc_html__('List of IDs', 'sh_textdomain'),
					'top_rated_products' => esc_html__('Top Rated Products', 'sh_textdomain'),
				),
			]
		);

		$this->add_control(
			'include',
			[
				'label'       => esc_html__('Include only', 'sh_textdomain'),
				'description' => esc_html__('Add products by title.', 'sh_textdomain'),
				'type'        => 'sh_autocomplete',
				'search'      => 'woodmart_get_posts_by_query',
				'render'      => 'woodmart_get_posts_title_by_id',
				'post_type'   => 'product',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type' => 'ids',
				],
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label'       => esc_html__('Categories or tags', 'sh_textdomain'),
				'description' => esc_html__('List of product categories.', 'sh_textdomain'),
				'type'        => 'sh_autocomplete',
				'search'      => 'sh_get_taxonomies_by_query',
				'render'      => 'sh_get_taxonomies_title_by_id',
				'taxonomy'    => array_merge(['product_cat', 'product_tag'], $this->get_product_attributes_array()),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__('Order by', 'sh_textdomain'),
				'description' => esc_html__('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'sh_textdomain'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''               => '',
					'date'           => esc_html__('Date', 'sh_textdomain'),
					'id'             => esc_html__('ID', 'sh_textdomain'),
					'author'         => esc_html__('Author', 'sh_textdomain'),
					'title'          => esc_html__('Title', 'sh_textdomain'),
					'modified'       => esc_html__('Last modified date', 'sh_textdomain'),
					'comment_count'  => esc_html__('Number of comments', 'sh_textdomain'),
					'menu_order'     => esc_html__('Menu order', 'sh_textdomain'),
					'meta_value'     => esc_html__('Meta value', 'sh_textdomain'),
					'meta_value_num' => esc_html__('Meta value number', 'sh_textdomain'),
					'rand'           => esc_html__('Random order', 'sh_textdomain'),
					'price'          => esc_html__('Price', 'sh_textdomain'),
				),
			]
		);

		$this->add_control(
			'offset',
			[
				'label'       => esc_html__('Offset', 'sh_textdomain'),
				'description' => esc_html__('Number of grid elements to displace or pass over.', 'sh_textdomain'),
				'type'        => Controls_Manager::TEXT,
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->add_control(
			'query_type',
			[
				'label'   => esc_html__('Query type', 'sh_textdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'OR',
				'options' => array(
					'OR'  => esc_html__('OR', 'sh_textdomain'),
					'AND' => esc_html__('AND', 'sh_textdomain'),
				),
			]
		);

		$this->add_control(
			'order',
			[
				'label'       => esc_html__('Sort order', 'sh_textdomain'),
				'description' => 'Designates the ascending or descending order',
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''     => esc_html__('Inherit', 'sh_textdomain'),
					'DESC' => esc_html__('Descending', 'sh_textdomain'),
					'ASC'  => esc_html__('Ascending', 'sh_textdomain'),
				),
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'       => esc_html__('Meta key', 'sh_textdomain'),
				'description' => esc_html__('Input meta key for grid ordering.', 'sh_textdomain'),
				'type'        => Controls_Manager::TEXTAREA,
				'condition'   => [
					'orderby' => ['meta_value', 'meta_value_num'],
				],
			]
		);

		$this->add_control(
			'exclude',
			[
				'label'       => esc_html__('Exclude', 'sh_textdomain'),
				'description' => esc_html__('Exclude posts, pages, etc. by title.', 'sh_textdomain'),
				'type'        => 'sh_autocomplete',
				'search'      => 'sh_get_posts_by_query',
				'render'      => 'sh_get_posts_title_by_id',
				'post_type'   => 'product',
				'multiple'    => true,
				'label_block' => true,
				'condition'   => [
					'post_type!' => 'ids',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_style_section',
			[
				'label' => esc_html__('Layout', 'sh_textdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => esc_html__('Products hover', 'sh_textdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => array(
					'grid'     => esc_html__('Grid', 'sh_textdomain'),
					'list'     => esc_html__('List', 'sh_textdomain'),
					'carousel' => esc_html__('Carousel', 'sh_textdomain'),
				),
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => esc_html__('Columns', 'sh_textdomain'),
				'description' => esc_html__('Number of columns in the grid.', 'sh_textdomain'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 4,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 6,
						'step' => 1,
					],
				],
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'products_masonry',
			[
				'label'       => esc_html__('Masonry grid', 'sh_textdomain'),
				'description' => esc_html__('Products may have different sizes.', 'sh_textdomain'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__('Inherit', 'sh_textdomain'),
					'enable'  => esc_html__('Enable', 'sh_textdomain'),
					'disable' => esc_html__('Disable', 'sh_textdomain'),
				),
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'products_different_sizes',
			[
				'label'       => esc_html__('Products grid with different sizes', 'sh_textdomain'),
				'description' => esc_html__('In this situation, some of the products will be twice bigger in width than others. Recommended to use with 6 columns grid only.', 'sh_textdomain'),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'options'     => array(
					''        => esc_html__('Inherit', 'sh_textdomain'),
					'enable'  => esc_html__('Enable', 'sh_textdomain'),
					'disable' => esc_html__('Disable', 'sh_textdomain'),
				),
				'condition'   => [
					'layout' => 'grid',
				],
			]
		);

		$this->add_control(
			'spacing',
			[
				'label'     => esc_html__('Space between', 'sh_textdomain'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'' => esc_html__('Inherit', 'sh_textdomain'),
					0  => esc_html__('0 px', 'sh_textdomain'),
					2  => esc_html__('2 px', 'sh_textdomain'),
					6  => esc_html__('6 px', 'sh_textdomain'),
					10 => esc_html__('10 px', 'sh_textdomain'),
					20 => esc_html__('20 px', 'sh_textdomain'),
					30 => esc_html__('30 px', 'sh_textdomain'),
				],
				'default'   => '',
				'condition' => [
					'layout'                => ['grid', 'carousel'],
					'highlighted_products!' => ['1'],
				],
			]
		);

		$this->add_control(
			'items_per_page',
			[
				'label'       => esc_html__('Items per page', 'sh_textdomain'),
				'description' => esc_html__('Number of items to show per page.', 'sh_textdomain'),
				'default'     => 12,
				'type'        => Controls_Manager::NUMBER,
			]
		);

		$this->add_control(
			'pagination',
			[
				'label'     => esc_html__('Pagination', 'sh_textdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''         => esc_html__('Inherit', 'sh_textdomain'),
					'more-btn' => esc_html__('Load more button', 'sh_textdomain'),
					'infinit'  => esc_html__('Infinit scrolling', 'sh_textdomain'),
					'arrows'   => esc_html__('Arrows', 'sh_textdomain'),
					'links'    => esc_html__('Links', 'sh_textdomain'),
				),
				'condition' => [
					'layout!' => 'carousel',
				],
			]
		);

		$this->add_control(
			'shop_tools',
			[
				'label'        => esc_html__('Shop tools', 'sh_textdomain'),
				'description'  => esc_html__('Per page, Sorting, Columns', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => '1',
				'condition'    => [
					'pagination' => 'links',
				],
			]
		);

		$this->end_controls_section();

		// Carousel settings.

		$this->start_controls_section(
			'carousel_style_section',
			[
				'label'     => esc_html__('Carousel', 'sh_textdomain'),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'carousel',
				],
			]
		);

		$this->add_control(
			'slides_per_view',
			[
				'label'       => esc_html__('Slides per view', 'sh_textdomain'),
				'description' => esc_html__('Set numbers of slides you want to display at the same time on slider\'s container for carousel mode.', 'sh_textdomain'),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 3,
				],
				'size_units'  => '',
				'range'       => [
					'px' => [
						'min'  => 1,
						'max'  => 8,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'scroll_per_page',
			[
				'label'        => esc_html__('Scroll per page', 'sh_textdomain'),
				'description'  => esc_html__('Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_pagination_control',
			[
				'label'        => esc_html__('Hide pagination control', 'sh_textdomain'),
				'description'  => esc_html__('If "YES" pagination control will be removed.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'hide_prev_next_buttons',
			[
				'label'        => esc_html__('Hide prev/next buttons', 'sh_textdomain'),
				'description'  => esc_html__('If "YES" prev/next control will be removed', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'center_mode',
			[
				'label'        => esc_html__('Center mode', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'wrap',
			[
				'label'        => esc_html__('Slider loop', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__('Slider autoplay', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'       => esc_html__('Slider speed', 'sh_textdomain'),
				'description' => esc_html__('Duration of animation between slides (in ms)', 'sh_textdomain'),
				'default'     => '5000',
				'type'        => Controls_Manager::NUMBER,
				'condition'   => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'scroll_carousel_init',
			[
				'label'        => esc_html__('Init carousel on scroll', 'sh_textdomain'),
				'description'  => esc_html__('This option allows you to init carousel script only when visitor scroll the page to the slider. Useful for performance optimization.\'', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();

		//design
		$this->start_controls_section(
			'products_design_style_section',
			[
				'label' => esc_html__('Products design', 'sh_textdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'element_title',
			[
				'label'     => esc_html__('Element title', 'sh_textdomain'),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'highlighted_products' => '1',
				],
			]
		);

		$this->add_control(
			'product_hover',
			[
				'label'     => esc_html__('Products hover', 'sh_textdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inherit',
				'options'   => array(
					'inherit'  => esc_html__('Inherit from Theme Settings', 'sh_textdomain'),
					'info-alt' => esc_html__('Full info on hover', 'sh_textdomain'),
					'info'     => esc_html__('Full info on image', 'sh_textdomain'),
					'alt'      => esc_html__('Icons and "add to cart" on hover', 'sh_textdomain'),
					'icons'    => esc_html__('Icons on hover', 'sh_textdomain'),
					'quick'    => esc_html__('Quick', 'sh_textdomain'),
					'button'   => esc_html__('Show button on hover on image', 'sh_textdomain'),
					'base'     => esc_html__('Show summary on hover', 'sh_textdomain'),
					'standard' => esc_html__('Standard button', 'sh_textdomain'),
					'tiled'    => esc_html__('Tiled', 'sh_textdomain'),
				),
				'condition' => [
					'layout!' => 'list',
				],
			]
		);

		$this->add_control(
			'img_size',
			[
				'label'   => esc_html__('Image size', 'sh_textdomain'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				//'options' => woodmart_get_all_image_sizes_names('elementor'),
			]
		);

		$this->add_control(
			'img_size_custom',
			[
				'label'       => esc_html__('Image dimension', 'sh_textdomain'),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'sh_textdomain'),
				'condition'   => [
					'img_size' => 'custom',
				],
			]
		);

		$this->add_control(
			'sale_countdown',
			[
				'label'        => esc_html__('Sale countdown', 'sh_textdomain'),
				'description'  => esc_html__('Countdown to the end sale date will be shown. Be sure you have set final date of the product sale price.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'stock_progress_bar',
			[
				'label'        => esc_html__('Stock progress bar', 'sh_textdomain'),
				'description'  => esc_html__('Display a number of sold and in stock products as a progress bar.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'highlighted_products',
			[
				'label'        => esc_html__('Highlighted products', 'sh_textdomain'),
				'description'  => esc_html__('Create an eye-catching section of special products to promote them on your store.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => '1',
			]
		);

		$this->add_control(
			'products_bordered_grid',
			[
				'label'        => esc_html__('Bordered grid', 'sh_textdomain'),
				'description'  => esc_html__('Add borders between the products in your grid.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => '1',
				'condition'    => [
					'highlighted_products!' => ['1'],
				],
			]
		);

		$this->add_control(
			'product_quantity',
			[
				'label'     => esc_html__('Quantity input on product', 'sh_textdomain'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__('Inherit', 'sh_textdomain'),
					'enable'  => esc_html__('Enable', 'sh_textdomain'),
					'disable' => esc_html__('Disable', 'sh_textdomain'),
				),
				'condition' => [
					'product_hover' => ['standard', 'quick'],
				],
			]
		);

		$this->end_controls_section();

		//extra settings
		$this->start_controls_section(
			'extra_style_section',
			[
				'label' => esc_html__('Extra', 'sh_textdomain'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'lazy_loading',
			[
				'label'        => esc_html__('Lazy loading for images', 'sh_textdomain'),
				'description'  => esc_html__('Enable lazy loading for images for this element.', 'sh_textdomain'),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__('Yes', 'sh_textdomain'),
				'label_off'    => esc_html__('No', 'sh_textdomain'),
				'return_value' => 'yes',
			]
		);

		$this->end_controls_section();
	}


	protected function render()
	{
		//woodmart_elementor_products_template($this->get_settings_for_display());
	}
}

//require_once SH_THEME_INC . 'ele/widgets/products/products.php';