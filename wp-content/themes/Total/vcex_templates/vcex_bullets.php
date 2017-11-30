<?php
/**
 * Visual Composer Bullets
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Not needed in admin ever
if ( is_admin() ) {
    return;
}

// Required VC functions
if ( ! function_exists( 'vc_map_get_attributes' ) ) {
	vcex_function_needed_notice();
	return;
}

// Return if no content
if ( empty( $content ) ) {
	return;
}

// Define output
$output = '';

// Get shortcode attributes
$atts = vc_map_get_attributes( 'vcex_bullets', $atts );

// Wrap classes
$classes = 'vcex-module vcex-bullets';
if ( $atts['style'] && ! $atts['icon_type'] ) {
	$classes .= ' vcex-bullets-'. $atts['style'];
} else {
	$icon       = vcex_get_icon_class( $atts, 'icon' );
	$icon_style = vcex_inline_style( array(
		'color' => $atts['icon_color']
	) );
	$content = str_replace( '<li>', '<li><span class="vcex-icon '. $icon .'" '. $icon_style .'></span>', $content );
	$classes .= ' custom-icon';
}

// Wrap Style
$wrap_style = vcex_inline_style( array(
	'color'          => $atts['color'],
	'font_family'    => $atts['font_family'],
	'font_size'      => $atts['font_size'],
	'letter_spacing' => $atts['letter_spacing'],
	'font_weight'    => $atts['font_weight'],
	'line_height'    => $atts['line_height'],
) );

// Load custom font
if ( $atts['font_family'] ) {
	wpex_enqueue_google_font( $atts['font_family'] );
}

// Enqueue needed icon font
if ( $atts['icon'] && 'fontawesome' != $atts['icon_type'] ) {
	vcex_enqueue_icon_font( $atts['icon_type'] );
}

// Output
$output .= '<div class="'. esc_attr( $classes ) .'"'. $wrap_style .'>';

	$output .= do_shortcode( wp_kses_post( $content ) );

$output .= '</div>';

// Echo output
echo $output;