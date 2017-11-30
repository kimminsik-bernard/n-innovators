<?php
/**
 * Visual Composer disable updater
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Admin only functions
if ( ! is_admin() ) {
	return;
}

// Remove design options
if ( apply_filters( 'wpex_remove_vc_design_options', true ) ) {

	// Delete design options
	delete_option( 'wpb_js_use_custom' );

	// Set correct filter for VC
	add_filter( 'vc_settings_page_show_design_tabs', '__return_false' );

}