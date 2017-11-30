<?php
/**
 * Returns the correct title to display for any post/page/archive
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 * @version 3.6.0
 */

function wpex_title( $post_id = '' ) {

	// Default title is null
	$title = null;

	// Return singular title if post id is defined and don't apply filters
	// This is used for VC heading module
	if ( $post_id ) {
		return single_post_title( '', false );
	}
	
	// Get post ID from global object
	$post_id = wpex_global_obj( 'post_id' );
	
	// Homepage - display blog description if not a static page
	if ( is_front_page() && ! is_singular( 'page' ) ) {
		
		if ( get_bloginfo( 'description' ) ) {
			$title = get_bloginfo( 'description' );
		} else {
			return esc_html__( 'Recent Posts', 'total' );
		}

	// Homepage posts page
	} elseif ( is_home() && ! is_singular( 'page' ) ) {

		$title = get_the_title( get_option( 'page_for_posts', true ) );
		$title = $title ? $title : esc_html__( 'Home', 'total' );

	}

	// Search => NEEDS to go before archives
	elseif ( is_search() ) {
		$title = esc_html__( 'Search results for:', 'total' ) .' &quot;'. esc_html( get_search_query( false ) ) .'&quot;';
	}
		
	// Archives
	elseif ( is_archive() ) {

		// Author
		if ( is_author() ) {
			if ( $author = get_queried_object() ) {
				$title = $author->display_name; // Fix for authors with 0 posts
			} else {
				$title = get_the_archive_title();
			}
		}

		// Post Type archive title
		elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}

		// Daily archive title
		elseif ( is_day() ) {
			$title = sprintf( esc_html__( 'Daily Archives: %s', 'total' ), get_the_date() );
		}

		// Monthly archive title
		elseif ( is_month() ) {
			$title = sprintf( esc_html__( 'Monthly Archives: %s', 'total' ), get_the_date( 'F Y' ) );
		}

		// Yearly archive title
		elseif ( is_year() ) {
			$title = sprintf( esc_html__( 'Yearly Archives: %s', 'total' ), get_the_date( 'Y' ) );
		}

		// Categories/Tags/Other
		else {

			// Get term title
			$title = single_term_title( '', false );

			// Fix for bbPress and other plugins that are archives but use pages
			if ( ! $title ) {
				global $post;
				$title = get_the_title( $post_id );
			}

		}

	} // End is archive check

	// 404 Page
	elseif ( is_404() ) {

		// Custom 404 page
		if ( $page_id = wpex_parse_obj_id( wpex_get_mod( 'error_page_content_id' ), 'page' ) ) {
			$title = get_the_title( $page_id );
		}

		// Default 404 page
		else {
			$title = wpex_get_translated_theme_mod( 'error_page_title' );
			$title = $title ? $title : esc_html__( '404: Page Not Found', 'total' );
		}

	}
	
	// Anything else with a post_id defined
	elseif ( $post_id ) {

		// Single Pages
		if ( is_singular( 'page' ) || is_singular( 'attachment' ) || is_singular( 'wp_router_page' ) ) {
			$title = single_post_title( '', false );
		}

		// Single blog posts
		elseif ( is_singular( 'post' ) ) {
			$display = wpex_get_mod( 'blog_single_header' );
			$display = $display ? $display : 'custom_text';
			if ( 'custom_text' == $display ) {
				$title = wpex_get_mod( 'blog_single_header_custom_text' );
				$title = $title ? $title : esc_html__( 'Blog', 'total' );
			} elseif ( 'first_category' == $display ) {
				$title = wpex_get_first_term_name();
			} else {
				$title = single_post_title( '', false );
			}
		}

		// Other posts (custom types)
		else {
			$obj = get_post_type_object( get_post_type() );
			if ( is_object( $obj ) ) {
				$title = $obj->labels->name;
			}
		}

		// Custom meta title
		if ( $meta = get_post_meta( $post_id, 'wpex_post_title', true ) ) {
			$title = $meta;
		}

	}

	// Last check if title is empty
	$title = $title ? $title : get_the_title();

	// Apply filters and return title
	return apply_filters( 'wpex_title', $title );
	
}