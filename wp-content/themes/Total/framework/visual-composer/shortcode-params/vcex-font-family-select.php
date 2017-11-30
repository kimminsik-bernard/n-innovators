<?php
/**
 * Adds a new custom font family select parameter to the VC
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'vcex_font_family_select_shortcode_param' ) ) {

	function vcex_font_family_select_shortcode_param( $settings, $value ) {

		// Begin output
		$output = '<select name="'
				. $settings['param_name']
				. '" class="wpb_vc_param_value wpb-input wpb-select '
				. $settings['param_name']
				. ' ' . $settings['type'] .'">'
				. '<option value="" '. selected( $value, '', false ) .'>'. esc_html__( 'Default', 'total' ) .'</option>';
		
		// Add Custom fonts
		if ( function_exists( 'wpex_add_custom_fonts' ) ) {
			$fonts = wpex_add_custom_fonts();
			if ( $fonts && is_array( $fonts ) ) {
				$output .= '<optgroup label="'. esc_html__( 'Custom Fonts', 'total' ) .'">';
				foreach ( $fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $value, $font, false ) .'>'. esc_html( $font ) .'</option>';
				}
				$output .= '</optgroup>';
			}
		}
		
		// Get Standard font options
		if ( $std_fonts = wpex_standard_fonts() ) {
			$output .= '<optgroup label="'. esc_html__( 'Standard Fonts', 'total' ) .'">';
				foreach ( $std_fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $font, $value, false ) .'>'. esc_html( $font ) .'</option>';
				}
			$output .= '</optgroup>';
		}
		
		// Google font options
		if ( $google_fonts = wpex_google_fonts_array() ) {
			$output .= '<optgroup label="'. esc_html__( 'Google Fonts', 'total' ) .'">';
				foreach ( $google_fonts as $font ) {
					$output .= '<option value="'. esc_html( $font ) .'" '. selected( $font, $value ) .'>'. esc_html( $font ) .'</option>';
				}
			$output .= '</optgroup>';
		}
		$output .= '</select>';

		// Return output
		return $output;

	}
	
}
vc_add_shortcode_param( 'vcex_font_family_select', 'vcex_font_family_select_shortcode_param' );