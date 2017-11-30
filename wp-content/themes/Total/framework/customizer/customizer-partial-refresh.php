<?php
/**
 * Customizer Partial Refresh Support
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Abort if selective refresh is not available.
if ( ! isset( $wp_customize->selective_refresh ) ) {
	return;
}

// Social Sharing
$wp_customize->selective_refresh->add_partial( 'social_share', array(
	'selector'            => '.wpex-social-share-wrap',
	'settings'            => array(
		'social_share_sites',
		'social_share_heading_enable',
		'social_share_position',
		'social_share_style',
		'social_share_shortcode',
		'social_share_heading'
	),
	'primarySetting'      => 'social_share_sites',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'social_share' );
	},
) );

// Breadcrumbs
$wp_customize->selective_refresh->add_partial( 'breadcrumbs', array(
	'selector'            => '.site-breadcrumbs',
	'settings'            => array(
		'breadcrumbs',
		'breadcrumbs_position',
		'breadcrumbs_home_title',
		'breadcrumbs_title_trim',
		'blog_page',
		'breadcrumbs_first_cat_only',
	),
	'primarySetting'      => 'breadcrumbs',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_display_breadcrumbs(); // must use this function because of custom position.
	},
) );

// Topbar Style
$wp_customize->selective_refresh->add_partial( 'top_bar_style', array(
	'selector'            => '#top-bar-wrap',
	'settings'            => array( 'top_bar_style' ),
	'primarySetting'      => false,
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'topbar' );
	},
) );

// Topbar Content
$wp_customize->selective_refresh->add_partial( 'top_bar_content', array(
	'id'                  => 'top_bar_content',
	'selector'            => '#top-bar-content',
	'settings'            => array( 'top_bar_content' ),
	'primarySetting'      => 'top_bar_content',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'topbar_content' );
	},
) );

// Topbar Social
$social_settings = array(
	'top_bar_social_style',
	'top_bar_social_alt',
);
$social_options = wpex_topbar_social_options();
foreach ( $social_options as $key => $val ) {
	$social_settings[] = 'top_bar_social_profiles[' . $key .']';
}
$wp_customize->selective_refresh->add_partial( 'top_bar_social', array(
	'selector'             => '#top-bar-social',
	'settings'             => $social_settings,
	'primarySetting'       => 'top_bar_social',
	'container_inclusive'  => true,
	'render_callback'      => function() {
		wpex_get_template_part( 'topbar_social' );
	},
) );

// Post Series
$wp_customize->selective_refresh->add_partial( 'post_series', array(
	'id'                  => 'post_series_heading',
	'selector'            => '#post-series',
	'settings'            => array( 'post_series_heading' ),
	'primarySetting'      => 'post_series_heading',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'post_series' );
	},
) );

// Header Aside Content
$wp_customize->selective_refresh->add_partial( 'header_aside', array(
	'id'                  => 'header_aside',
	'selector'            => '#header-aside',
	'settings'            => array( 'header_aside', 'header_aside_search' ),
	'primarySetting'      => 'header_aside',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'header_aside' );
	},
) );

// Callout
$wp_customize->selective_refresh->add_partial( 'callout', array(
	'selector'            => '#footer-callout-wrap',
	'settings'            => array(
		'callout',
		'callout_text',
		'callout_link',
		'callout_button_icon',
		'callout_link_txt',
		'callout_visibility'
	),
	'primarySetting'      => 'callout_text',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'footer_callout' );
	},
) );

// Footer Bottom
$wp_customize->selective_refresh->add_partial( 'footer_bottom', array(
	'selector'            => '#footer-bottom',
	'settings'            => array( 'footer_bottom', 'bottom_footer_text_align', 'footer_copyright_text' ),
	'primarySetting'      => 'footer_bottom',
	'container_inclusive' => true,
	'render_callback'     => function() {
		wpex_get_template_part( 'footer_bottom' );
	},
) );