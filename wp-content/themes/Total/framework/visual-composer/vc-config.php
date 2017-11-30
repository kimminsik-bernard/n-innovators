<?php
/**
 * Visual Composer configuration file
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start class
class WPEX_Visual_Composer_Config {

	/**
	 * Start things up
	 *
	 * @since 1.6.0
	 */
	public function __construct() {

		// Define useful Paths
		define( 'WPEX_VCEX_DIR', WPEX_FRAMEWORK_DIR .'visual-composer/' );
		define( 'WPEX_VCEX_DIR_URI', WPEX_FRAMEWORK_DIR_URI .'visual-composer/' );

		// Include helper functions and classes
		require_once( WPEX_VCEX_DIR .'vc-helpers.php' );

		// Disable updater
		if ( vcex_theme_mode_check() ) {
			require_once( WPEX_VCEX_DIR .'vc-disable-updater.php' );
		}

		// Disable welcome screen
		require_once( WPEX_VCEX_DIR .'vc-disable-welcome.php' );

		// Disable color options from VC admin
		require_once( WPEX_VCEX_DIR .'vc-disable-design-options.php' );

		// Register accent colors
		require_once( WPEX_VCEX_DIR .'vc-accent-color.php' );

		// Alter core vc modules
		require_once( WPEX_VCEX_DIR .'shortcode-mods/row.php' );
		require_once( WPEX_VCEX_DIR .'shortcode-mods/column.php' );
		require_once( WPEX_VCEX_DIR .'shortcode-mods/single-image.php' );
		require_once( WPEX_VCEX_DIR .'shortcode-mods/column-text.php' );

		// Parse attributes
		require_once( WPEX_VCEX_DIR .'parse-atts/row-atts.php' );

		// Custom Grid builder modules (must load early)
		require_once( WPEX_VCEX_DIR .'shortcodes/post_video.php' );
		require_once( WPEX_VCEX_DIR .'shortcodes/post_meta.php' );

		// Auto complete functions for editor
		require_once( WPEX_VCEX_DIR .'helpers/autocomplete.php' );

		// Add new parameter types
		if ( function_exists( 'vc_add_shortcode_param' ) ) {
			require_once( WPEX_VCEX_DIR .'shortcode-params/vcex-font-family-select.php' );
		}

		// Replace lightbox - need to fix ajax issues first
		//if ( wpex_get_mod( 'replace_vc_lightbox', true ) ) {
			//require_once( WPEX_VCEX_DIR .'vc-replace-prettyphoto.php' );
		//}

		// Remove default templates => Do not edit due to extension plugin and snippets
		add_filter( 'vc_load_default_templates', array( 'WPEX_Visual_Composer_Config', 'default_templates' ) );

		// Add custom templates
		require_once( WPEX_VCEX_DIR .'vc-templates.php' );

		// Run on init
		add_action( 'init', array( 'WPEX_Visual_Composer_Config', 'init' ), 20 );

		// Tweak scripts
		add_action( 'wp_enqueue_scripts', array( 'WPEX_Visual_Composer_Config', 'load_composer_front_css' ), 0 );
		add_action( 'wp_enqueue_scripts', array( 'WPEX_Visual_Composer_Config', 'load_remove_styles' ) );
		add_action( 'vc_frontend_editor_render',  array( 'WPEX_Visual_Composer_Config', 'remove_editor_font_awesome' ) );
		add_action( 'wp_footer', array( 'WPEX_Visual_Composer_Config', 'remove_footer_scripts' ) );
		add_action( 'admin_enqueue_scripts',  array( 'WPEX_Visual_Composer_Config', 'admin_scripts' ) );

		// Load Visual Composer meta CSS for footer builder, topbar, etc.
		add_action( 'wpex_head_css', array( 'WPEX_Visual_Composer_Config', 'vc_css_ids' ) );

		// Alter the allowed font tags and fonts
		add_filter( 'vc_font_container_get_allowed_tags', array( 'WPEX_Visual_Composer_Config', 'font_container_tags' ) );
		add_filter( 'vc_font_container_get_fonts_filter', array( 'WPEX_Visual_Composer_Config', 'font_container_fonts' ) );

	}

	/**
	 * Functions that run on init
	 *
	 * @since 2.0.0
	 */
	public static function init() {

		// Remove purchase notice
		wpex_remove_class_filter( 'admin_notices', 'Vc_License', 'adminNoticeLicenseActivation', 10 );

		// Override editor logo
		add_filter( 'vc_nav_front_logo', array( 'WPEX_Visual_Composer_Config', 'nav_logo' ) );

		// Remove templatera notice
		remove_action( 'admin_notices', 'templatera_notice' );

		// Set defaults for admin
		if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
			vc_set_default_editor_post_types( array( 'page', 'portfolio', 'staff' ) );
		}

		/* Set defaults for editor
		// @todo Check if causes issues with user-roles if not re-add.
		if ( function_exists( 'vc_editor_set_post_types ') ) {
			$types = vc_settings()->get( 'content_types' );
			if ( empty( $types ) ) {
				vc_editor_set_post_types( array( 'page', 'portfolio', 'staff' ) );
			}
		}*/

		// Array of elements to remove
		$elements = array(
			'vc_teaser_grid',
			'vc_posts_grid',
			'vc_posts_slider',
			'vc_carousel',
			'vc_gallery',
			'vc_wp_text',
			'vc_wp_pages',
			'vc_wp_links',
			'vc_wp_categories',
			'vc_wp_meta',
			'vc_images_carousel',
		);

		// Add filter for child theme tweaking
		$elements = apply_filters( 'wpex_vc_remove_elements', $elements );

		// Loop through elements to remove and remove them
		if ( is_array( $elements ) ) {
			foreach ( $elements as $element ) {
				vc_remove_element( $element );
			}
		}

		// Add custom params
		if ( function_exists( 'vc_add_param' ) ) {
			
			// Add param to tabs
			vc_add_param( 'vc_tabs', array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'total' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'total' ) => 'default',
					esc_html__( 'Alternative #1', 'total' ) => 'alternative-one',
					esc_html__( 'Alternative #2', 'total' ) => 'alternative-two',
				),  
			) );

			// Add param Tours
			vc_add_param( 'vc_tour', array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Style', 'total' ),
				'param_name' => 'style',
				'value' => array(
					esc_html__( 'Default', 'total' ) => 'default',
					esc_html__( 'Alternative #1', 'total' ) => 'alternative-one',
					esc_html__( 'Alternative #2', 'total' ) => 'alternative-two',
				),
				
			) );

		}

		// Include custom modules
		if ( function_exists( 'vc_lean_map' )
			&& class_exists( 'WPBakeryShortCode' )
			&& wpex_get_mod( 'extend_visual_composer', true )
		) {
			self::total_custom_vc_shortcodes();
		}

	}

	/**
	 * Override editor logo
	 *
	 * @since 3.0.0
	 */
	public static function nav_logo() {
		return '<div id="vc_logo" class="vc_navbar-brand">'. esc_html__( 'Visual Composer', 'total' ) .'</div>';
	}

	/**
	 * Load js_composer_front CSS eaerly on for easier modification
	 *
	 * @since  2.1.3
	 */
	public static function load_composer_front_css() {
		wp_enqueue_style( 'js_composer_front' );
	}

	/**
	 * Load and remove stylesheets
	 *
	 * @since 2.0.0
	 */
	public static function load_remove_styles() {

		// Add Scripts
		wp_enqueue_style(
			'wpex-visual-composer',
			wpex_asset_url( 'css/wpex-visual-composer.css' ),
			array( 'wpex-style', 'js_composer_front' ),
			WPEX_THEME_VERSION
		);

		wp_enqueue_style(
			'wpex-visual-composer-extend',
			wpex_asset_url( 'css/wpex-visual-composer-extend.css' ),
			array( 'wpex-style', 'js_composer_front' ),
			WPEX_THEME_VERSION
		);

		/* Remove Scripts to fix Customizer issue with jQuery UI
		 * Fixed in WP 4.4
		 * @deprecated 3.3.0
		if ( is_customize_preview() ) {
			wp_deregister_script( 'wpb_composer_front_js' );
			wp_dequeue_script( 'wpb_composer_front_js' );
		}*/

		// Remove unwanted scripts
		if ( apply_filters( 'wpex_remove_vc_design_options', true ) ) {
			wp_deregister_style( 'js_composer_custom_css' );
		}

	}

	/**
	 * Remove scripts from backend editor
	 *
	 * @since 3.6.0
	 */
	public static function remove_editor_font_awesome() {
		wp_deregister_style( 'font-awesome' );
		wp_dequeue_style( 'font-awesome' );
	}

	/**
	 * Remove scripts hooked in too late for me to remove on wp_enqueue_scripts
	 *
	 * @since 2.1.0
	 */
	public static function remove_footer_scripts() {

		// JS
		wp_dequeue_script( 'vc_pageable_owl-carousel' );
		wp_dequeue_script( 'vc_grid-js-imagesloaded' );

		// Styles conflict with Total owl carousel styles
		wp_deregister_style( 'vc_pageable_owl-carousel-css-theme' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css-theme' );
		wp_deregister_style( 'vc_pageable_owl-carousel-css' );
		wp_dequeue_style( 'vc_pageable_owl-carousel-css' );

	}

	/**
	 * Admin Scripts
	 *
	 * @since 1.6.0
	 */
	public static function admin_scripts( $hook ) {

		// Array of places to load the admin script
		$hooks = array(
			'edit.php',
			'post.php',
			'post-new.php',
			'widgets.php', // Support VC widget plugin
		);

		// Only needed on these admin screens
		if ( ! in_array( $hook, $hooks ) ) {
			return;
		}

		// Enque script
		wp_enqueue_style(
			'vcex-admin-css',
			wpex_asset_url( 'css/wpex-visual-composer-admin.css' ),
			array(),
			WPEX_THEME_VERSION
		);

	}

	/**
	 * Adds tags to the font_container param
	 *
	 * @since 2.1.0
	 */
	public static function font_container_tags( $tags ) {
		$tags['span'] = 'span';
		return $tags;
	}

	/**
	 * Adds fonts to the font_container param
	 *
	 * @since 2.1.0
	 */
	public static function font_container_fonts( $fonts ) {

		// Add blank option
		$new_fonts[''] = esc_html__( 'Default', 'total' );

		// Merge arrays
		$fonts = array_merge( $new_fonts, $fonts );

		// Get Google fonts
		$google_fonts = wpex_google_fonts_array();
		$google_fonts = array_combine( $google_fonts, $google_fonts );

		// Merge fonts
		$fonts = array_merge( $fonts, $google_fonts );

		// Return fonts
		return $fonts;

	}

	/**
	 * Maps custom shortcodes for the VC
	 *
	 * @since 2.1.0
	 */
	public static function total_custom_vc_shortcodes() {

		// Array of new modules to add to the VC
		$vcex_modules = apply_filters( 'vcex_builder_modules', array(
			'shortcode',
			'spacing',
			'divider',
			'divider_dots',
			'heading',
			'button',
			'leader',
			'animated_text',
			'icon_box',
			'teaser',
			'feature',
			'list_item',
			'bullets',
			'pricing',
			'skillbar',
			'icon',
			'milestone',
			'countdown',
			'social_links',
			'navbar',
			'searchbar',
			'login_form',
			'form_shortcode',
			'newsletter_form',
			'image_swap',
			'image_galleryslider',
			'image_flexslider',
			'image_carousel',
			'image_grid',
			'recent_news',
			'blog_grid',
			'blog_carousel',
			'post_type_grid',
			'post_type_archive',
			'post_type_slider',
			'post_type_carousel',
			'callout' => array(
				'file' =>  WPEX_VCEX_DIR .'shortcodes/callout/callout.php',
			),
			'post_terms',
			'terms_grid',
			'terms_carousel',
		) );

		// Load mapping files
		if ( ! empty( $vcex_modules ) ) {
			foreach ( $vcex_modules as $key => $val ) {
				if ( is_array( $val ) ) {
					$condition = isset( $val['condition'] ) ? $val['condition'] : true;
					$file      = isset( $val['file'] ) ? $val['file'] : WPEX_VCEX_DIR .'shortcodes/'. $key .'.php';
					if ( $condition ) {
						require_once( $file );
					}
				} else {
					$file = WPEX_VCEX_DIR .'shortcodes/'. $val .'.php';
					require_once( $file );
				}
			}
		}

	}

	/**
	 * Load VC CSS
	 *
	 * @since 2.0.0
	 */
	public static function vc_css_ids( $css ) {
		if ( $ids = wpex_global_obj( 'vc_css_ids' ) ) {
			foreach ( $ids as $id ) {
				if ( function_exists( 'is_shop' ) && is_shop() ) {
					$condition = true;
				} elseif ( is_404() && $id == wpex_global_obj( 'post_id' ) ) {
					$condition = true;
				} else {
					$condition = ( $id == wpex_global_obj( 'post_id' ) ) ? false : true;
				}
				if ( $condition && $vc_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true ) ) {
					$css .='/*VC META CSS*/'. $vc_css;
				}
			}
		}
		return $css;
	}

	/**
	 * Remove default templates
	 *
	 * @since 2.0.0
	 */
	public static function default_templates() {
		return array();
	}
	
}
new WPEX_Visual_Composer_Config();