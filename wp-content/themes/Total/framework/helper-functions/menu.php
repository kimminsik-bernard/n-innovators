<?php
/**
 * Header Menu Functions
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 * @version 3.6.0
 */

/**
 * Returns correct menu classes
 *
 * @since 2.0.0
 */
function wpex_header_menu_classes( $return ) {

	// Define classes array
	$classes = array();

	// Get data
	$header_style = wpex_global_obj( 'header_style' );
	$has_overlay  = wpex_global_obj( 'has_overlay_header' );

	// Return wrapper classes
	if ( 'wrapper' == $return ) {

		// Add Header Style to wrapper
		$classes[] = 'navbar-style-'. $header_style;

		// Add the fixed-nav class if the fixed header option is enabled
		if ( wpex_get_mod( 'fixed_header', true )
			&& ( 'two' == $header_style || 'three' == $header_style || 'four' == $header_style )
		) {
			$classes[] = 'fixed-nav';
		}

		// Dropdown dropshadow
		if ( 'one' == $header_style || 'five' == $header_style || $has_overlay ) {
			$classes[] = 'wpex-dropdowns-caret';
		}

		// Flush Dropdowns
		if ( wpex_get_mod( 'menu_flush_dropdowns' )
			&& 'one' == $header_style
			&& ! $has_overlay
		) {
			$classes[] = 'wpex-flush-dropdowns';
		}

		// Dropdown dropshadow
		if ( $shadow = wpex_get_mod( 'menu_dropdown_dropshadow' ) ) {
			$classes[] = 'wpex-dropdowns-shadow-'. $shadow;
		}

		// Add special class if the dropdown top border option in the admin is enabled
		if ( wpex_get_mod( 'menu_dropdown_top_border' ) ) {
			$classes[] = 'wpex-dropdown-top-border';
		}

		// Disable header two borders
		if ( 'two' == $header_style && wpex_get_mod( 'header_menu_disable_borders', false ) ) {
			$classes[] = 'no-borders';
		}

		// Center items
		if ( 'two' == $header_style && wpex_get_mod( 'header_menu_center', false ) ) {
			$classes[] = 'center-items';
		}

		// Add clearfix
		$classes[] = 'clr';

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpex_header_menu_wrap_classes', $classes );

	}

	// Inner Classes
	elseif ( 'inner' == $return ) {

		// Core
		$classes[] = 'navigation';
		$classes[] = 'main-navigation';
		$classes[] = 'clr';

		// Add the container div for specific header styles
		if ( in_array( $header_style, array( 'two', 'three', 'four' ) ) ) {
			$classes[] = 'container';
		}

		// Set keys equal to vals
		$classes = array_combine( $classes, $classes );

		// Apply filters
		$classes = apply_filters( 'wpex_header_menu_classes', $classes );

	}

	// Return
	if ( is_array( $classes ) ) {
		return implode( ' ', $classes );
	} else {
		return $return;
	}

}

/**
 * Custom menu walker
 *
 * @since 1.3.0
 */
if ( ! class_exists( 'WPEX_Dropdown_Walker_Nav_Menu' ) ) {
	class WPEX_Dropdown_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

			// Define vars
			$id_field     = $this->db_fields['id'];
			$header_style = wpex_global_obj( 'header_style' );

			// Down Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth == 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpex_get_mod( 'menu_arrow_down' ) ) {
					$arrow_class = 'six' == $header_style ? 'fa-chevron-right' : 'fa-angle-down';
					$element->title .= ' <span class="nav-arrow top-level fa '. $arrow_class .'"></span>';
				}
			}

			// Right/Left Arrows
			if ( ! empty( $children_elements[$element->$id_field] ) && ( $depth > 0 ) ) {
				$element->classes[] = 'dropdown';
				if ( wpex_get_mod( 'menu_arrow_side', true ) ) {
					if ( is_rtl() ) {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-left"></span>';
					} else {
						$element->title .= '<span class="nav-arrow second-level fa fa-angle-right"></span>';
					}
				}
			}

			// Remove current menu item when using local-scroll class
			if ( in_array( 'local-scroll', $element->classes ) && in_array( 'current-menu-item', $element->classes ) ) {
				$key = array_search( 'current-menu-item', $element->classes );
				unset( $element->classes[$key] );
			}

			// Define walker
			Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		}
	}
}

/**
 * Checks for custom menus.
 *
 * @since 1.3.0
 */
function wpex_custom_menu() {
	$menu = get_post_meta( wpex_global_obj( 'post_id' ), 'wpex_custom_menu', true );
	$menu = 'default' != $menu ? $menu : '';
	return apply_filters( 'wpex_custom_menu', $menu );
}

/**
 * Adds the search icon to the menu items
 *
 * @since 1.0.0
 */
function wpex_add_search_to_menu ( $items, $args ) {

	// Only used on main menu
	if ( 'main_menu' != $args->theme_location ) {
		return $items;
	}

	// Get search style
	$search_style = wpex_global_obj( 'menu_search_style' );

	// Return if disabled
	if ( ! $search_style || 'disabled' == $search_style ) {
		return $items;
	}

	// Define classes
	$li_classes = 'search-toggle-li wpex-menu-extra';
	$a_classes  = 'site-search-toggle';

	// Get header style
	$header_style = wpex_global_obj( 'header_style' );
	
	// Get correct search icon class
	if ( 'overlay' == $search_style) {
		$a_classes .= ' search-overlay-toggle';
	} elseif ( 'drop_down' == $search_style ) {
		$a_classes .= ' search-dropdown-toggle';
	} elseif ( 'header_replace' == $search_style ) {
		$a_classes .= ' search-header-replace-toggle';
	}

	// Add search item to menu
	if ( class_exists( 'UberMenu' ) && apply_filters( 'wpex_add_search_toggle_ubermenu_classes', true ) ) {
		$li_classes .= ' ubermenu-item-level-0 ubermenu-item';
		$a_classes  .= ' ubermenu-target ubermenu-item-layout-default ubermenu-item-layout-text_only';
	}
	$items .= '<li class="'. $li_classes .'">';
		$items .= '<a href="#" class="'. $a_classes .'">';
			$items .= '<span class="link-inner">';
				$text = esc_html__( 'Search', 'total' );
				$text = apply_filters( 'wpex_header_search_text', $text );
				if ( 'six' == $header_style ) {
					$items .= '<span class="fa fa-search"></span>';
					$items .= '<span class="wpex-menu-search-text">'. $text .'</span>';
				} else {
					$items .= '<span class="wpex-menu-search-text">'. $text .'</span>';
					$items .= '<span class="fa fa-search" aria-hidden="true"></span>';
				}
			$items .= '</span>';
		$items .= '</a>';
	$items .= '</li>';
	
	// Return nav $items
	return $items;

}
add_filter( 'wp_nav_menu_items', 'wpex_add_search_to_menu', 11, 2 );