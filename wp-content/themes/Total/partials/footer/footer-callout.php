<?php
/**
 * Footer bottom content
 *
 * @package Total WordPress Theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Return if disabled
if ( ! wpex_global_obj( 'has_footer_callout' ) ) {
	return;
}

// Get post ID
$post_id = wpex_global_obj( 'post_id' );

// Get post content
$content = wpex_global_obj( 'footer_callout_content' );

// Get link
if ( $post_id && $meta = get_post_meta( $post_id, 'wpex_callout_link', true ) ) {
	$link = $meta;
} else {
	$link = wpex_get_mod( 'callout_link', 'http://www.wpexplorer.com' );
}

// Get link text
if ( $post_id && $meta = get_post_meta( $post_id, 'wpex_callout_link_txt', true ) ) {
	$link_text = $meta;
} else {
	$link_text = wpex_get_mod( 'callout_link_txt', 'Get In Touch' );
}

// If link is defined set target and rel
if ( $link ) {

	// Link target
	$target	= wpex_get_mod( 'callout_button_target', 'blank' );
	$target	= ( 'blank' == $target ) ? ' target="_blank"' : '';

	// Link rel
	$rel = wpex_get_mod( 'callout_button_rel', false );
	$rel = ( 'nofollow' == $rel ) ? ' rel="nofollow"' : '';

}

// Button Icon
if ( $icon = wpex_get_mod( 'callout_button_icon' ) ) {
	$icon = '<span class="theme-button-icon-right fa fa-'. esc_html( $icon ) .'"></span>';
} else {
	$icon = '';
}

// Translate Theme mods
$content   = wpex_translate_theme_mod( 'callout_text', $content );
$link      = wpex_translate_theme_mod( 'callout_link', $link );
$link_text = wpex_translate_theme_mod( 'callout_link_txt', $link_text );

// Bail if conditions are not met
if ( ! $content && ( ! $link || ! $link_text ) ) {
	return;
}

// Callout classes
$classes = 'clr';
if ( ! $content ) {
	$classes .= ' btn-only';
}
if ( 'always-visible' != wpex_get_mod( 'callout_visibility', 'always-visible' ) ) {
	$classes .= ' '. wpex_get_mod( 'callout_visibility' );
} ?>
	
<div id="footer-callout-wrap" class="<?php echo esc_attr( $classes ); ?>">

	<div id="footer-callout" class="clr<?php if ( $content ) echo ' container'; ?>">

		<?php
		// Display content
		if ( $content ) : ?>

			<div id="footer-callout-left" class="footer-callout-content clr<?php if ( ! $link ) echo ' full-width'; ?>"><?php

				// Output content
				echo do_shortcode( wp_kses_post( $content ) );

			?></div>

		<?php endif; ?>

		<?php
		// Display footer callout button if callout link & text options are not blank in the admin
		if ( $link ) : ?>

			<div id="footer-callout-right" class="footer-callout-button wpex-clr">
				<a href="<?php echo esc_url( $link ); ?>" class="theme-button" title="<?php echo esc_attr( $link_text ); ?>"<?php echo $target; ?><?php echo $rel; ?>><?php echo esc_html( $link_text ); ?><?php echo $icon; ?></a>
			</div>

		<?php endif; ?>

	</div>

</div>