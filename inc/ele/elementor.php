<?php
//all elementor fucntion


use Elementor\Core\Files\CSS\Post_Preview;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Plugin;
use Elementor\Utils;
use XTS\Elementor\Controls\Autocomplete;
use XTS\Elementor\Controls\Google_Json;
use XTS\Elementor\Controls\Buttons;

if ( ! defined( 'SH_THEME_DIR' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'sh_elementor_is_edit_mode' ) ) {
	/**
	 * Whether the edit mode is active.
	 */
	function sh_elementor_is_edit_mode() {
		if ( ! sh_is_elementor_installed() ) {
			return false;
		}

		return \Elementor\Plugin::$instance->editor->is_edit_mode();
	}
}


// if ( ! function_exists( 'sh_elementor_maybe_init_cart' ) ) {
// 	/**
// 	 * Ini woo cart in elementor.
// 	 */
// 	function sh_elementor_maybe_init_cart() {
// 		if ( ! sh_elementor_maybe_init_cart() ) {
// 			return;
// 		}

// 		WC()->initialize_session();
// 	}

// 	add_action( 'elementor/editor/before_enqueue_scripts', 'sh_elementor_maybe_init_cart' );
// }

if ( ! function_exists( 'sh_elementor_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function sh_elementor_register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_location(
			'header',
			[
				'is_core'         => false,
				'public'          => false,
				'label'           => esc_html__( 'Header', 'sh_textdomain' ),
				'edit_in_content' => false,
			]
		);

		$elementor_theme_manager->register_location(
			'footer',
			[
				'is_core'         => false,
				'public'          => false,
				'label'           => esc_html__( 'Footer', 'sh_textdomain' ),
				'edit_in_content' => false,
			]
		);
	}

	add_action( 'elementor/theme/register_locations', 'sh_elementor_register_elementor_locations' );
}



if ( ! function_exists( 'sh_get_posts_by_query' ) ) {
	/**
	 * Get post by search
	 *
	 * @since 1.0.0
	 */
	function sh_get_posts_by_query() {
		$search_string = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : ''; // phpcs:ignore
		$post_type     = isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'post'; // phpcs:ignore
		$results       = array();

		$query = new WP_Query(
			array(
				's'              => $search_string,
				'post_type'      => $post_type,
				'posts_per_page' => - 1,
			)
		);

		if ( ! isset( $query->posts ) ) {
			return;
		}

		foreach ( $query->posts as $post ) {
			$results[] = array(
				'id'   => $post->ID,
				'text' => $post->post_title,
			);
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_sh_get_posts_by_query', 'sh_get_posts_by_query' );
	add_action( 'wp_ajax_nopriv_sh_get_posts_by_query', 'sh_get_posts_by_query' );
}

if ( ! function_exists( 'sh_get_posts_title_by_id' ) ) {
	/**
	 * Get post title by ID
	 *
	 * @since 1.0.0
	 */
	function sh_get_posts_title_by_id() {
		$ids       = isset( $_POST['id'] ) ? $_POST['id'] : array(); // phpcs:ignore
		$post_type = isset( $_POST['post_type'] ) ? $_POST['post_type'] : 'post'; // phpcs:ignore
		$results   = array();

		$query = new WP_Query(
			array(
				'post_type'      => $post_type,
				'post__in'       => $ids,
				'posts_per_page' => - 1,
				'orderby'        => 'post__in',
			)
		);

		if ( ! isset( $query->posts ) ) {
			return;
		}

		foreach ( $query->posts as $post ) {
			$results[ $post->ID ] = $post->post_title;
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_sh_get_posts_title_by_id', 'sh_get_posts_title_by_id' );
	add_action( 'wp_ajax_nopriv_sh_get_posts_title_by_id', 'sh_get_posts_title_by_id' );
}

if ( ! function_exists( 'sh_get_taxonomies_title_by_id' ) ) {
	/**
	 * Get taxonomies title by id
	 *
	 * @since 1.0.0
	 */
	function sh_get_taxonomies_title_by_id() {
		$ids     = isset( $_POST['id'] ) ? $_POST['id'] : array(); // phpcs:ignore
		$results = array();

		$args = array(
			'include' => $ids,
		);

		$terms = get_terms( $args );

		if ( is_array( $terms ) && $terms ) {
			foreach ( $terms as $term ) {
				if ( is_object( $term ) ) {
					$results[ $term->term_id ] = $term->name . ' (' . $term->taxonomy . ')';
				}
			}
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_sh_get_taxonomies_title_by_id', 'sh_get_taxonomies_title_by_id' );
	add_action( 'wp_ajax_nopriv_sh_get_taxonomies_title_by_id', 'sh_get_taxonomies_title_by_id' );
}

if ( ! function_exists( 'sh_get_taxonomies_by_query' ) ) {
	/**
	 * Get taxonomies by search
	 *
	 * @since 1.0.0
	 */
	function sh_get_taxonomies_by_query() {
		$search_string = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : ''; // phpcs:ignore
		$taxonomy      = isset( $_POST['taxonomy'] ) ? $_POST['taxonomy'] : ''; // phpcs:ignore
		$results       = array();

		$args = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
			'search'     => $search_string,
		);

		$terms = get_terms( $args );

		if ( is_array( $terms ) && $terms ) {
			foreach ( $terms as $term ) {
				if ( is_object( $term ) ) {
					$results[] = array(
						'id'   => $term->term_id,
						'text' => $term->name . ' (' . $term->taxonomy . ')',
					);
				}
			}
		}

		wp_send_json( $results );
	}

	add_action( 'wp_ajax_sh_get_taxonomies_by_query', 'sh_get_taxonomies_by_query' );
	add_action( 'wp_ajax_nopriv_sh_get_taxonomies_by_query', 'sh_get_taxonomies_by_query' );
}

if ( ! function_exists( 'sh_get_image_html' ) ) {
	/**
	 * Get image url
	 *
	 * @since 1.0.0
	 *
	 * @param array  $settings       Control settings.
	 * @param string $image_size_key Settings key for image size.
	 *
	 * @return string
	 */
	function sh_get_image_html( $settings, $image_size_key = '' ) {
		if ( ! sh_is_elementor_installed() ) {
			return wp_get_attachment_image( $settings[ $image_size_key ]['id'], $settings[ $image_size_key . '_size' ] );
		}

		return Group_Control_Image_Size::get_attachment_image_html( $settings, $image_size_key );
	}
}



if ( ! function_exists( 'sh_elementor_is_preview_mode' ) ) {
	/**
	 * Whether the preview mode is active.
	 *
	 * @since 1.0.0
	 */
	function sh_elementor_is_preview_mode() {
		return Plugin::$instance->preview->is_preview_mode();
	}
}

if ( ! function_exists( 'sh_elementor_is_preview_page' ) ) {
	/**
	 * Whether the preview page.
	 *
	 * @since 1.0.0
	 */
	function sh_elementor_is_preview_page() {
		return isset( $_GET['preview_id'] );
	}
}

if ( ! function_exists( 'sh_get_image_url' ) ) {
	/**
	 * Get image url
	 *
	 * @since 1.0.0
	 *
	 * @param integer $id             Image id.
	 * @param string  $image_size_key Settings key for image size.
	 * @param array   $settings       Control settings.
	 *
	 * @return string
	 */
	function sh_get_image_url( $id, $image_size_key, $settings ) {
		if ( ! sh_is_elementor_installed() ) {
			return wp_get_attachment_image_src( $id, $settings[ $image_size_key . '_size' ] )[0];
		}

		return Group_Control_Image_Size::get_attachment_image_src( $id, $image_size_key, $settings );
	}
}

if ( ! function_exists( 'sh_get_all_image_sizes' ) ) {
	/**
	 * Retrieve available image sizes
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	function sh_get_all_image_sizes() {
		global $_wp_additional_image_sizes;

		$default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );
		$image_sizes         = array();

		foreach ( $default_image_sizes as $size ) {
			$image_sizes[ $size ] = array(
				'width'  => (int) get_option( $size . '_size_w' ),
				'height' => (int) get_option( $size . '_size_h' ),
				'crop'   => (bool) get_option( $size . '_crop' ),
			);
		}

		if ( $_wp_additional_image_sizes ) {
			$image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
		}

		$image_sizes['full'] = array();

		return $image_sizes;
	}
}

if ( ! function_exists( 'sh_get_all_image_sizes_names' ) ) {
	/**
	 * Retrieve available image sizes names
	 *
	 * @since 1.0.0
	 *
	 * @param string $style Array output style.
	 *
	 * @return array
	 */
	function sh_get_all_image_sizes_names( $style = 'default' ) {
		$available_sizes = sh_get_all_image_sizes();
		$image_sizes     = array();

		foreach ( $available_sizes as $size => $size_attributes ) {
			$name = ucwords( str_replace( '_', ' ', $size ) );
			if ( is_array( $size_attributes ) && ( isset( $size_attributes['width'] ) || isset( $size_attributes['height'] ) ) ) {
				$name .= ' - ' . $size_attributes['width'] . ' x ' . $size_attributes['height'];
			}

			if ( 'elementor' === $style ) {
				$image_sizes[ $size ] = $name;
			} elseif ( 'header_builder' === $style ) {
				$image_sizes[ $size ] = array(
					'label' => $name,
					'value' => $size,
				);
			} elseif ( 'default' === $style ) {
				$image_sizes[ $size ] = array(
					'name'  => $name,
					'value' => $size,
				);
			} elseif ( 'widget' === $style ) {
				$image_sizes[ $name ] = $size;
			}
		}

		if ( 'elementor' === $style ) {
			$image_sizes['custom'] = esc_html__( 'Custom', 'sh' );
		} elseif ( 'header_builder' === $style ) {
			$image_sizes['custom'] = array(
				'label' => esc_html__( 'Custom', 'sh' ),
				'value' => 'custom',
			);
		} elseif ( 'default' === $style ) {
			$image_sizes['custom'] = array(
				'name'  => esc_html__( 'Custom', 'sh' ),
				'value' => 'custom',
			);
		} elseif ( 'widget' === $style ) {
			$image_sizes[ esc_html__( 'Custom', 'sh' ) ] = 'custom';
		}

		return $image_sizes;
	}
}