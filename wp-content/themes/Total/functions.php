<?php
/**
 * Functions.php => This is where the magic happens.
 *
 * IMPORTANT: DO NOT USE AN ILLEGAL COPY OF THIS THEME !!!
 * IMPORTANT: DO NOT EVER EDIT THIS FILE !!!!
 * IMPORTANT: DO NOT EVER COPY AND PASTE ANYTHING FROM THIS FILE TO YOUR CHILD THEME !!!
 * IMPORTANT: DO NOT COPY AND PASTE THIS FILE INTO YOUR CHILD THEME !!!
 * IMPORTANT: DO USE HOOKS, FILTERS & TEMPLATE PARTS TO ALTER THIS THEME
 *
 * Total is a very powerful theme and virtually anything can be customized
 * via a child theme. If you need any help altering a function, just let us know!
 * Customizations aren't included with your purchase but if it's a simple task we can assist :)
 *
 * Theme Docs        : http://wpexplorer-themes.com/total/docs/
 * Using Hooks       : http://wpexplorer-themes.com/total/docs/action-hooks/
 * Filters Reference : http://www.wpexplorer.com/docs/total-wordpress-theme-filters/
 * Theme Support     : http://wpexplorer-themes.com/support/ (valid purchase required)
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core Constants
define( 'TOTAL_THEME_ACTIVE', true );
define( 'WPEX_THEME_VERSION', '3.6.0' );
define( 'WPEX_VC_SUPPORTED_VERSION', '4.12.1' );

define( 'WPEX_THEME_DIR', get_template_directory() );
define( 'WPEX_THEME_URI', get_template_directory_uri() );

// Start up class
class WPEX_Theme_Setup {

	/**
	 * Main Theme Class Constructor
	 *
	 * Loads all necessary classes, functions, hooks, configuration files and actions for the theme.
	 * Everything starts here.
	 *
	 * @since 1.6.0
	 *
	 */
	public function __construct() {

		// Perform actions after updating => Run before anything else
		require_once( WPEX_THEME_DIR .'/framework/updates/after-update.php' );

		// Define globals
		global $wpex_theme, $wpex_theme_mods;

		// Gets all theme mods and stores them in an easily accessable global var to limit DB requests
		$wpex_theme_mods = get_theme_mods();

		// Functions used to retrieve theme mods.
		// Loaded early so it can be used on all hooks.
		// Requires $wpex_theme_mods global var to be defined first => look up!
		require_once( WPEX_THEME_DIR .'/framework/get_mods.php' );

		// Include conditional functions early so we can use them anywhere
		require_once( WPEX_THEME_DIR .'/framework/conditionals.php' );

		// Include global object class early so it can be used anywhere needed.
		// This is important because when inserting VC modules we must re-run the class object at times
		require_once( WPEX_THEME_DIR .'/framework/classes/global-object.php' );

		// Define constants
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'constants' ), 0 );

		// Load all core theme function files
		// Load Before classes and addons so we can make use of them
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'include_functions' ), 1 );

		// Load all the theme addons - must run on this hook!!!
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'addons' ), 2 );

		// Load configuration classes (post types & 3rd party plugins)
		// Must load first so it can use hooks defined in the classes
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'configs' ), 3 );

		// Load framework classes
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		// Must run on 10 priority or else child theme locale will be overritten
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'theme_setup' ), 10 );

		// Defines hooks and adds theme actions
		// Moved to after_setup_theme hook in v3.6.0 so it can be accessed earlier if needed
		// to remove actions
		add_action( 'after_setup_theme', array( 'WPEX_Theme_Setup', 'hooks_actions' ), 10 );

		// Populate the global object
		// Must be done early on to prevent issues with plugins altering templates
		// But must run after WP has loaded so conditionals work
		add_action( 'template_redirect', array( 'WPEX_Theme_Setup', 'global_object' ), 0 );

		// Run after switch theme
		add_action( 'after_switch_theme', array( 'WPEX_Theme_Setup', 'after_switch_theme' ) );

		// Load custom widgets
		add_action( 'widgets_init', array( 'WPEX_Theme_Setup', 'custom_widgets' ), 10 );

		// Register sidebar widget areas
		add_action( 'widgets_init', array( 'WPEX_Theme_Setup', 'register_sidebars' ) );

		// Register footer widgets
		add_action( 'widgets_init', array( 'WPEX_Theme_Setup', 'footer_widgets' ), 40 );

		/** Admin only actions **/
		if ( is_admin() ) {

			// Load scripts in the WP admin
			add_action( 'admin_enqueue_scripts', array( 'WPEX_Theme_Setup', 'admin_font_awesome' ) );

			// Outputs custom CSS for the admin
			add_action( 'admin_head', array( 'WPEX_Theme_Setup', 'admin_inline_css' ) );

			// Add new social profile fields to the user dashboard
			add_filter( 'user_contactmethods', array( 'WPEX_Theme_Setup', 'add_user_social_fields' ) );

			// Remove wpex_term_data when a term is removed
			add_action( 'delete_term', array( 'WPEX_Theme_Setup', 'delete_term' ), 5 );

		/** Non Admin actions **/
		} else {

			// Load theme CSS
			add_action( 'wp_enqueue_scripts', array( 'WPEX_Theme_Setup', 'theme_css' ) );

			// Browser dependent CSS
			add_action( 'wp_enqueue_scripts', array( 'WPEX_Theme_Setup', 'browser_dependent_css' ), 40 );

			// Load RTL CSS right before responsive
			add_action( 'wp_enqueue_scripts', array( 'WPEX_Theme_Setup', 'rtl_css' ), 98 );

			// Load responsive CSS - must be added last
			add_action( 'wp_enqueue_scripts', array( 'WPEX_Theme_Setup', 'responsive_css' ), 99 );

			// Load theme js => High priority so after js_composer
			add_action( 'wp_enqueue_scripts', array( 'WPEX_Theme_Setup', 'theme_js' ) );

			// Exclude categories from the blog page
			add_action( 'pre_get_posts', array( 'WPEX_Theme_Setup', 'pre_get_posts' ) );

			// Redirect posts with custom links
			add_filter( 'template_redirect', array( 'WPEX_Theme_Setup', 'redirect_custom_links' ) );

			// Add meta viewport tag to header
			add_action( 'wp_head', array( 'WPEX_Theme_Setup', 'meta_viewport' ), 1 );

			// Add theme meta generator
			add_action( 'wp_head', array( 'WPEX_Theme_Setup', 'theme_meta_generator' ), 1 );

			// Add an X-UA-Compatible header
			add_filter( 'wp_headers', array( 'WPEX_Theme_Setup', 'x_ua_compatible_headers' ) );

			// Outputs custom CSS to the head
			add_action( 'wp_head', array( 'WPEX_Theme_Setup', 'custom_css' ), 9999 );

			// Alter tagcloud widget to display all tags with 1em font size
			add_filter( 'widget_tag_cloud_args', array( 'WPEX_Theme_Setup', 'widget_tag_cloud_args' ) );

			// Alter WP categories widget to display count inside a span
			add_filter( 'wp_list_categories', array( 'WPEX_Theme_Setup', 'wp_list_categories_args' ) );

			// Add a responsive wrapper to the WordPress oembed output
			add_filter( 'embed_oembed_html', array( 'WPEX_Theme_Setup', 'oembed_html' ), 99, 4 );

			// Allow for the use of shortcodes in the WordPress excerpt
			add_filter( 'the_excerpt', 'shortcode_unautop' );
			add_filter( 'the_excerpt', 'do_shortcode' );

			// Make sure the wp_get_attachment_url() function returns correct page request (HTTP or HTTPS)
			add_filter( 'wp_get_attachment_url', array( 'WPEX_Theme_Setup', 'honor_ssl_for_attachments' ) );

			// Tweak the default password protection output form
			add_filter( 'the_password_form', array( 'WPEX_Theme_Setup', 'custom_password_protected_form' ) );

			// Exclude posts with custom links from the next and previous post links
			add_filter( 'get_previous_post_join', array( 'WPEX_Theme_Setup', 'prev_next_join' ) );
			add_filter( 'get_next_post_join', array( 'WPEX_Theme_Setup', 'prev_next_join' ) );
			add_filter( 'get_previous_post_where', array( 'WPEX_Theme_Setup', 'prev_next_where' ) );
			add_filter( 'get_next_post_where', array( 'WPEX_Theme_Setup', 'prev_next_where' ) );

			// Remove emoji scripts
			if ( wpex_get_mod( 'remove_emoji_scripts_enable', true ) ) {
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
			}

			// Adds classes the post class
			add_filter( 'post_class', array( 'WPEX_Theme_Setup', 'post_class' ) );

			// Add schema markup to the authors post link
			add_filter( 'the_author_posts_link', array( 'WPEX_Theme_Setup', 'the_author_posts_link' ) );

			// Move Comment textarea form field back to bottom
			add_filter( 'comment_form_fields', array( 'WPEX_Theme_Setup', 'move_comment_form_fields' ) );

			// Disable WP responsive images if retina is enabled
			if ( wpex_is_retina_enabled() ) {
				add_filter( 'wp_calculate_image_srcset', '__return_false' );
			}

			// Disable canonical redirect on the homepage when using pagination via VC modules
			add_filter( 'redirect_canonical', array( 'WPEX_Theme_Setup', 'home_pagination_fix' ) );

			// Filter kses protocols
			add_filter( 'kses_allowed_protocols' , array( 'WPEX_Theme_Setup', 'kses_allowed_protocols' ) );

			// Filter comment link for smooth scrolling
			add_filter( 'get_comments_link', array( 'WPEX_Theme_Setup', 'get_comments_link' ), 10, 2 );
			add_filter( 'respond_link', array( 'WPEX_Theme_Setup', 'get_comments_link' ), 10, 2 );
			
			// Allow shortcodes in menus
			add_filter( 'wp_nav_menu_items', 'do_shortcode' );

		} // Non admin functions

	} // End constructor

	/**
	 * Defines the constants for use within the theme.
	 *
	 * @since 2.0.0
	 */
	public static function constants() {

		// Theme branding
		define( 'WPEX_THEME_BRANDING', wpex_get_mod( 'theme_branding', 'Total' ) );

		// Theme Panel slug
		define( 'WPEX_THEME_PANEL_SLUG', 'wpex-panel' );
		define( 'WPEX_ADMIN_PANEL_HOOK_PREFIX', 'theme-panel_page_'. WPEX_THEME_PANEL_SLUG );

		// Framework Paths
		define( 'WPEX_FRAMEWORK_DIR', WPEX_THEME_DIR .'/framework/' );
		define( 'WPEX_FRAMEWORK_DIR_URI', WPEX_THEME_URI .'/framework/' );

		// Classes directory
		define( 'WPEX_ClASSES_DIR', WPEX_FRAMEWORK_DIR .'classes/' );

		// Check if plugins are active
		define( 'WPEX_VC_ACTIVE', class_exists( 'Vc_Manager' ) );
		define( 'WPEX_BBPRESS_ACTIVE', class_exists( 'bbPress' ) );
		define( 'WPEX_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		define( 'WPEX_WPML_ACTIVE', class_exists( 'SitePress' ) );

		// Active post types
		define( 'WPEX_PORTFOLIO_IS_ACTIVE', wpex_get_mod( 'portfolio_enable', true ) );
		define( 'WPEX_STAFF_IS_ACTIVE', wpex_get_mod( 'staff_enable', true ) );
		define( 'WPEX_TESTIMONIALS_IS_ACTIVE', wpex_get_mod( 'testimonials_enable', true ) );

	}

	/**
	 * Defines all theme hooks and runs all needed actions for theme hooks.
	 *
	 * @since 2.0.0
	 */
	public static function hooks_actions() {

		// Register hooks (needed in admin for Custom Actions panel)
		require_once( WPEX_FRAMEWORK_DIR .'hooks/hooks.php' );

		// Front-end stuff
		if ( ! is_admin() ) {
			require_once( WPEX_FRAMEWORK_DIR .'hooks/actions.php' );
			require_once( WPEX_FRAMEWORK_DIR .'hooks/partials.php' );
		}

	}

	/**
	 * Framework functions
	 * Load before Classes & Addons so we can use them
	 *
	 * @since 2.0.0
	 */
	public static function include_functions() {

		// Needed in front-end and back-end
		require_once( WPEX_FRAMEWORK_DIR .'deprecated.php' );
		require_once( WPEX_FRAMEWORK_DIR .'core-functions.php' );
		require_once( WPEX_FRAMEWORK_DIR .'arrays.php' );
		require_once( WPEX_FRAMEWORK_DIR .'shortcodes/shortcodes.php' );
		require_once( WPEX_FRAMEWORK_DIR .'helper-functions/fonts.php' );
		require_once( WPEX_FRAMEWORK_DIR .'helper-functions/overlays.php' );

		// Admin only functions
		if ( is_admin() ) {
			require_once( WPEX_FRAMEWORK_DIR .'disable-wp-update-check.php' );
		}

		// Front-end functions only
		else {
			require_once( WPEX_FRAMEWORK_DIR .'body-classes.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/header.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/menu.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/title.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/page-header.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/excerpts.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/pagination.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/blog.php' );
			require_once( WPEX_FRAMEWORK_DIR .'helper-functions/instagram-feed.php' );
		}
		
	}

	/**
	 * Include Theme Panel class which loads various add-on functions
	 *
	 * @since 2.0.0
	 */
	public static function addons() {
		require_once( WPEX_FRAMEWORK_DIR .'addons/theme-panel.php' );
	}

	/**
	 * Configs for post types and 3rd party plugins.
	 *
	 * @since 2.0.0
	 */
	public static function configs() {

		// Portfolio
		if ( WPEX_PORTFOLIO_IS_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'portfolio/portfolio-config.php' );
		}

		// Staff
		if ( WPEX_STAFF_IS_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'staff/staff-config.php' );
		}

		// Testimonias
		if ( WPEX_TESTIMONIALS_IS_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'testimonials/testimonials-config.php' );
		}

		// WooCommerce
		if ( WPEX_WOOCOMMERCE_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'woocommerce/woocommerce-config.php' );
		}

		// Visual Composer
		if ( WPEX_VC_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'visual-composer/vc-config.php' );
		}

		// The Events Calendar
		if ( class_exists( 'Tribe__Events__Main' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'tribe-events/tribe-events-config.php' );
		}

		// WPML
		if ( WPEX_WPML_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/wpml.php' );
		}

		// Polylang
		if ( class_exists( 'Polylang' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/polylang.php' );
		}

		// bbPress
		if ( WPEX_BBPRESS_ACTIVE ) {
			require_once( WPEX_FRAMEWORK_DIR .'bbpress/bbpress-config.php' );
		}

		// Sensei
		if ( function_exists( 'Sensei' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/sensei.php' );
		}

		// Yoast SEO
		if ( defined( 'WPSEO_VERSION' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/yoast.php' );
		}

		// Contact From 7
		if ( defined( 'WPCF7_VERSION' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/contact-form-7.php' );
		}

		// Revolution
		if ( class_exists( 'RevSlider' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/revslider.php' );
		}

		// LayerSlider
		if ( class_exists( 'LS_Sliders' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/layerslider.php' );
		}

		// JetPack
		if ( class_exists( 'Jetpack' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/jetpack.php' );
		}

		// Gravity Forms
		if ( class_exists( 'RGForms' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'3rd-party/gravity-forms.php' );
		}

		// Post types UI
		if ( function_exists( 'cptui_init' ) ) {
			require_once( WPEX_FRAMEWORK_DIR .'cpt-ui/types.php' );
		}

	}

	/**
	 * Framework Classes
	 *
	 * @since 2.0.0
	 */
	public static function classes() {

		// Sanitize input
		require_once( WPEX_ClASSES_DIR .'sanitize-data.php' );

		// iLightbox
		require_once( WPEX_ClASSES_DIR .'ilightbox.php' );

		// Image Resize
		require_once( WPEX_ClASSES_DIR .'image-resize.php' );

		// Gallery metabox
		require_once( WPEX_ClASSES_DIR .'gallery-metabox.php' );

		// Term colors - @todo
		//require_once( WPEX_ClASSES_DIR .'term-colors.php' );

		// Post Series
		if ( wpex_get_mod( 'post_series_enable', true ) ) {
			require_once( WPEX_ClASSES_DIR .'post-series.php' );
		}

		// Custom WP header
		if ( wpex_get_mod( 'header_image_enable' ) ) {
			require_once( WPEX_ClASSES_DIR .'custom-header.php' );
		}

		// Term meta
		require_once( WPEX_ClASSES_DIR .'term-meta.php' );

		// Term thumbnails
		if ( wpex_get_mod( 'term_thumbnails_enable', true ) ) {
			require_once( WPEX_ClASSES_DIR .'term-thumbnails.php' );
		}

		// Remove post type slugs
		if ( wpex_get_mod( 'remove_posttype_slugs' ) ) {
			require_once( WPEX_ClASSES_DIR .'remove-post-type-slugs.php' );
		}
		
		// Image sizes panel
		if ( wpex_get_mod( 'image_sizes_enable', true ) ) {
			require_once( WPEX_ClASSES_DIR .'image-sizes.php' );
		}

		// Admin only classes
		if ( is_admin() ) {

			// Recommend plugins
			if ( wpex_recommended_plugins() && wpex_get_mod( 'recommend_plugins_enable', true ) ) {
				require_once( WPEX_ClASSES_DIR .'class-tgm-plugin-activation.php' );
				require_once( WPEX_FRAMEWORK_DIR .'3rd-party/tgm-plugin-activation.php' );
			}

			// Plugins updater
			// Won't work with multisite because of how themes work.
			require_once( WPEX_ClASSES_DIR .'plugins-updater.php' );

			// Category meta
			require_once( WPEX_ClASSES_DIR .'category-meta.php' );

			// Metabox => Page Settings
			require_once( WPEX_ClASSES_DIR .'post-metabox.php' );

			// Custom attachment fields
			require_once( WPEX_ClASSES_DIR .'attachment-fields.php' );

		}

		// Front-end classes
		else {

			// Accent color
			require_once( WPEX_ClASSES_DIR .'accent-color.php' );

			// Border color
			require_once( WPEX_ClASSES_DIR .'border-colors.php' );

			// Site backgrounds
			require_once( WPEX_ClASSES_DIR .'site-backgrounds.php' );

			// Advanced styling
			require_once( WPEX_ClASSES_DIR .'advanced-styling.php' );

			// Breadcrumbs class
			require_once( WPEX_ClASSES_DIR .'breadcrumbs.php' );

		}

		// Disable Google Services
		if ( wpex_disable_google_services() ) {
			require_once( WPEX_ClASSES_DIR .'disable-google-services.php' );
		}

		// Customizer must load last to take advantage of all functions before it
		require_once( WPEX_FRAMEWORK_DIR .'customizer/customizer.php' );

	}

	/**
	 * Include all custom widget classes
	 *
	 * @since 2.0.0
	 */
	public static function custom_widgets() {

		// Get array of custom widgets
		$widgets = wpex_custom_widgets_list();

		// Loop through array and register the custom widgets
		if ( $widgets && is_array( $widgets ) ) {
			foreach ( $widgets as $widget ) {
				$file = WPEX_ClASSES_DIR .'widgets/' . $widget .'.php';
				if ( file_exists ( $file ) ) {
					require_once( $file );
				}
			}
		}

	}

	/**
	 * Populate the $wpex_theme global object.
	 *
	 * This helps speed things up by calling core functions only once and saving them in memory.
	 *
	 * @since 2.0.0
	 */
	public static function global_object() {
		global $wpex_theme;
		$wpex_theme = new WPEX_Global_Theme_Object();
		$wpex_theme = $wpex_theme->generate_obj();
	}

	/**
	 * Adds basic theme support functions and registers the nav menus
	 *
	 * @since 1.6.0
	 */
	public static function theme_setup() {

		// Load text domain
		load_theme_textdomain( 'total', WPEX_THEME_DIR .'/languages' );

		// Get globals
		global $content_width;

		// Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 980;
		}

		// Register theme navigation menus
		register_nav_menus( array(
			'topbar_menu'     => esc_html__( 'Top Bar', 'total' ),
			'main_menu'       => esc_html__( 'Main', 'total' ),
			'mobile_menu_alt' => esc_html__( 'Mobile Menu Alternative', 'total' ),
			'mobile_menu'     => esc_html__( 'Mobile Icons', 'total' ),
			'footer_menu'     => esc_html__( 'Footer', 'total' ),
		) );

		// Declare theme support
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Enable excerpts for pages.
		add_post_type_support( 'page', 'excerpt' );

		// Add styles to the WP editor
		add_editor_style( 'assets/css/editor-style.css' );

	}

	/**
	 * Functions called after theme switch
	 *
	 * @since 1.6.0
	 */
	public static function after_switch_theme() {
		flush_rewrite_rules();
		delete_metadata( 'user', null, 'tgmpa_dismissed_notice_wpex_theme', null, true );
	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.6.0
	 */
	public static function meta_viewport() {

		// Responsive viewport viewport
		if ( wpex_global_obj( 'responsive' ) ) {
			$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';
		}

		// Non responsive meta viewport
		else {
			$width    = intval( wpex_get_mod( 'main_container_width', '980' ) );
			$width    = $width ? $width: '980';
			$viewport = '<meta name="viewport" content="width='. $width .'" />';
		}
		
		// Apply filters to the meta viewport for child theme tweaking
		echo apply_filters( 'wpex_meta_viewport', $viewport );

	}

	/**
	 * Adds meta generator for 
	 *
	 * @since 3.1.0
	 */
	public static function theme_meta_generator() {
		echo "\r\n";
		echo '<meta name="generator" content="Total WordPress Theme '. WPEX_THEME_VERSION .'" />';
		echo "\r\n";
	}

	/**
	 * Load font awesome in backend
	 *
	 * @since 3.6.0
	 */
	public static function admin_font_awesome( $hook ) {

		// Array of places to load font awesome
		$hooks = array(
			'edit.php',
			'post.php',
			'post-new.php',
			'widgets.php',
		);

		// Only needed on these admin screens
		if ( ! in_array( $hook, $hooks ) ) {
			return;
		}

		// Load font awesome script for VC icons and other
		wp_enqueue_style( 'font-awesome', wpex_asset_url( 'lib/font-awesome/css/font-awesome.min.css' ), array(), '4.6.3' );

	}

	/**
	 * Returns all CSS needed for the front-end
	 *
	 * @since 1.6.0
	 */
	public static function theme_css() {

		// Remove other font awesome scripts
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );

		// Register hover-css
		wp_register_style( 'wpex-hover-animations', wpex_asset_url( 'lib/hover-css/hover-css.min.css' ), array(), '2.0.1' );

		// Main Style.css File
		wp_enqueue_style(
			'wpex-style', // !! IMPORTANT ** Do NOT edit 'wpex-style' *** !!!
			get_stylesheet_uri(),
			array(),
			WPEX_THEME_VERSION
		);

	}

	/**
	 * Loads RTL stylesheet
	 *
	 * @since 1.6.0
	 */
	public static function rtl_css() {
		if ( is_RTL() ) {
			wp_enqueue_style( 'wpex-rtl', wpex_asset_url( 'css/wpex-rtl.css' ), array(), WPEX_THEME_VERSION );
		}
	}

	/**
	 * Loads responsive css very last after all styles.
	 *
	 * @since 1.6.0
	 */
	public static function responsive_css() {
		if ( wpex_global_obj( 'responsive' ) ) {
			wp_enqueue_style( 'wpex-responsive', wpex_asset_url( 'css/wpex-responsive.css' ), array(), WPEX_THEME_VERSION );
		}
	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.6.0
	 */
	public static function theme_js() {

		// First lets make sure html5 shiv is on the site
		wp_enqueue_script( 'wpex-html5shiv', wpex_asset_url( 'js/dynamic/html5.js' ), array(), WPEX_THEME_VERSION, false );
		wp_script_add_data( 'wpex-html5shiv', 'conditional', 'lt IE 9' );

		// Get localized array
		$localize_array = WPEX_Theme_Setup::localize_array();

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Load minified js
		if ( wpex_get_mod( 'minify_js_enable', true ) ) {
			wp_enqueue_script( 'wpex-core', wpex_asset_url( 'js/total-min.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );
		}
		
		// Load all non-minified js
		else {

			// Touch events
			wp_enqueue_script( 'tocca', wpex_asset_url( 'js/core/Tocca.min.js' ), array( 'jquery' ), '1.0.0', true );

			// Easing
			wp_enqueue_script( 'easing', wpex_asset_url( 'js/core/jquery.easing.js' ), array( 'jquery' ), '1.3.2', true );

			// Superfish used for menu dropdowns
			wp_enqueue_script( 'wpex-superfish', wpex_asset_url( 'js/core/superfish.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );
			wp_enqueue_script( 'wpex-supersubs', wpex_asset_url( 'js/core/supersubs.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );
			wp_enqueue_script( 'wpex-hoverintent', wpex_asset_url( 'js/core/hoverintent.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Tooltips
			wp_enqueue_script( 'wpex-tipsy', wpex_asset_url( 'js/core/tipsy.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Typed
			wp_enqueue_script( 'wpex-typed', wpex_asset_url( 'js/core/typed.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Checks if images are loaded within an element
			wp_enqueue_script( 'wpex-images-loaded', wpex_asset_url( 'js/core/images-loaded.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Main masonry script
			wp_enqueue_script( 'wpex-isotope', wpex_asset_url( 'js/core/isotope.js' ), array( 'jquery' ), '2.2.2', true );

			// Leaner modal used for search/woo modals: @todo: Replace with CSS+light js
			wp_enqueue_script( 'wpex-leanner-modal', wpex_asset_url( 'js/core/leanner-modal.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Slider Pro
			wp_enqueue_script( 'wpex-sliderpro', wpex_asset_url( 'js/core/jquery.sliderPro.js' ), array( 'jquery' ), '1.3', true );
			wp_enqueue_script( 'wpex-sliderpro-customthumbnails', wpex_asset_url( 'js/core/jquery.sliderProCustomThumbnails.js' ), array( 'jquery', 'wpex-sliderpro' ), false, true );

			// Touch Swipe - do we need it?
			wp_enqueue_script( 'wpex-touch-swipe', wpex_asset_url( 'js/core/touch-swipe.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Carousels
			wp_enqueue_script( 'wpex-owl-carousel', wpex_asset_url( 'js/core/owl.carousel.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Used for milestones
			wp_enqueue_script( 'wpex-countUp', wpex_asset_url( 'js/core/countUp-jquery.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );
			wp_enqueue_script( 'wpex-appear', wpex_asset_url( 'js/core/appear.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Mobile menu
			wp_enqueue_script( 'wpex-sidr', wpex_asset_url( 'js/core/sidr.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Custom Selects
			wp_enqueue_script( 'wpex-custom-select', wpex_asset_url( 'js/core/jquery.customSelect.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Equal Heights
			wp_enqueue_script( 'wpex-equal-heights', wpex_asset_url( 'js/core/jquery.wpexEqualHeights.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Mousewheel
			wp_enqueue_script( 'wpex-mousewheel', wpex_asset_url( 'js/core/jquery.mousewheel.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Parallax bgs
			wp_enqueue_script( 'wpex-scrolly', wpex_asset_url( 'js/core/scrolly.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// iLightbox
			wp_enqueue_script( 'wpex-ilightbox', wpex_asset_url( 'js/core/ilightbox.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

			// Core global functions
			wp_enqueue_script( 'wpex-core', wpex_asset_url( 'js/functions.js' ), array( 'jquery' ), WPEX_THEME_VERSION, true );

		}

		// Localize core js
		wp_localize_script( 'wpex-core', 'wpexLocalize', $localize_array );

		// Retina.js
		if ( wpex_is_retina_enabled() ) {
			wp_enqueue_script( 'wpex-retina', wpex_asset_url( 'js/dynamic/retina.js' ), array( 'jquery' ), '0.0.2', true );
			wp_localize_script( 'wpex-retina', 'wpexRetina', array(
				'mode' => wpex_get_mod( 'retina_mode', 1 )
			) );
		}

	}

	/**
	 * Functions.js localize array
	 * IMPORTANT: Must be ** static function ** so we can get array in VC inline_js class
	 *
	 * @since 3.0.0
	 */
	public static function localize_array() {

		// Get Header Style and Mobile meny style
		$header_style    = wpex_global_obj( 'header_style' );
		$mm_style        = wpex_global_obj( 'mobile_menu_style' );
		$mm_toggle_style = wpex_global_obj( 'mobile_menu_toggle_style' );
		$mm_breakpoint   = intval( wpex_get_mod( 'mobile_menu_breakpoint' ) );

		// Create array
		$array = array(
			'isRTL'                 => is_rtl(),
			'mainLayout'            => wpex_global_obj( 'main_layout' ),
			'menuSearchStyle'       => wpex_global_obj( 'menu_search_style' ),
			'siteHeaderStyle'       => $header_style,
			'megaMenuJS'            => true,
			'superfishDelay'        => 600,
			'superfishSpeed'        => 'fast',
			'superfishSpeedOut'     => 'fast',
			'hasMobileMenu'         => wpex_global_obj( 'has_mobile_menu' ),
			'mobileMenuBreakpoint'  => $mm_breakpoint ? $mm_breakpoint : '960',
			'mobileMenuStyle'       => $mm_style,
			'mobileMenuToggleStyle' => $mm_toggle_style,
			'localScrollUpdateHash' => false,
			'localScrollSpeed'      => 1000,
			'localScrollEasing'     => 'easeInOutExpo',
			'scrollTopSpeed'        => 1000,
			'scrollTopOffset'       => 100,
			'carouselSpeed'		    => 150,
			'customSelects'         => '.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, #bbp_stick_topic_select, #bbp_topic_status_select, #bbp_destination_topic, .single-product .variations_form .variations select',
			'overlaysMobileSupport' => true,
		);

		/**** Header params ****/
		if ( 'disabled' != $header_style ) {

			// Sticky Header
			if ( wpex_global_obj( 'has_fixed_header' ) ) {
				$array['hasStickyHeader'] = true;
				if ( $logo = wpex_global_obj( 'fixed_header_logo' ) ) {
					$array['stickyheaderCustomLogo'] = esc_url( $logo );
					if ( $logo = wpex_global_obj( 'fixed_header_logo_retina' ) ) {
						$array['stickyheaderCustomLogoRetina'] = esc_url( $logo );
					}
				}
				$array['stickyHeaderStyle']      = wpex_global_obj( 'fixed_header_style' );
				$array['hasStickyMobileHeader']  = wpex_get_mod( 'fixed_header_mobile' );
				$array['overlayHeaderStickyTop'] = 0;
				$array['stickyHeaderBreakPoint'] = 960;

				// Shrink sticky header > used for local-scroll offset
				if ( wpex_global_obj( 'shrink_fixed_header' ) ) {
					$height = intval( wpex_get_mod( 'fixed_header_shrink_end_height' ) );
					$height = $height ? $height + 20 : 70;
					$array['shrinkHeaderHeight'] = $height;
				}
				
			}

			// Sticky Navbar
			if ( 'two' == $header_style || 'three' == $header_style || 'four' == $header_style ) {
				$enabled = wpex_get_mod( 'fixed_header_menu', true );
				$array['hasStickyNavbar'] = $enabled;
				if ( $enabled ) {
					$array['hasStickyNavbarMobile']  = wpex_get_mod( 'fixed_header_menu_mobile' );
					$array['stickyNavbarBreakPoint'] = 960;
				}
			}

			// Header five
			if ( 'five' == $header_style ) {
				$array['headerFiveSplitOffset'] = 1;
			}

			// WooCart
			if ( WPEX_WOOCOMMERCE_ACTIVE ) {
				$array['wooCartStyle'] = wpex_global_obj( 'menu_cart_style' );
			}

		} // End header params

		// Toggle mobile menu position
		if ( 'toggle' == $mm_style ) {
			$array['animateMobileToggle'] = true;
			if ( wpex_get_mod( 'fixed_header_mobile' ) ) {
				$mobileToggleMenuPosition = 'absolute'; // Must be absolute for sticky header
			} elseif ( 'fixedTopNav' != $mm_toggle_style && ( wpex_global_obj( 'has_overlay_header' ) ) ) {
				if ( 'navbar' == $mm_toggle_style ) {
					$mobileToggleMenuPosition = 'afterself';
				} else {
					$mobileToggleMenuPosition = 'absolute';
				}
			} elseif ( 'outer_wrap_before' == wpex_get_mod( 'mobile_menu_navbar_position' ) && 'navbar' == $mm_toggle_style ) {
				$mobileToggleMenuPosition = 'afterself';
			} else {
				$mobileToggleMenuPosition = 'afterheader';
			}
			$array['mobileToggleMenuPosition'] = $mobileToggleMenuPosition;
		}

		// Sidr settings
		if ( 'sidr' == $mm_style ) {
			$sidr_side = wpex_get_mod( 'mobile_menu_sidr_direction' );
			$sidr_side = $sidr_side ? $sidr_side : 'left'; // Fallback is crucial
			$array['sidrSource']         = wpex_global_obj( 'sidr_menu_source' );
			$array['sidrDisplace']       = wpex_get_mod( 'mobile_menu_sidr_displace', true ) ?  true : false;
			$array['sidrSide']           = $sidr_side;
			$array['sidrBodyNoScroll']   = false;
			$array['sidrSpeed']          = 300;
			$array['sidrDropdownTarget'] = 'arrow';
		}

		// Sticky topBar
		if ( apply_filters( 'wpex_has_sticky_topbar', wpex_get_mod( 'top_bar_sticky' ) ) ) {
			$array['stickyTopBarBreakPoint'] = 960;
			$array['hasStickyTopBarMobile']  = true;
		}

		// Full screen mobile menu style
		if ( 'full_screen' == $mm_style ) {
			$array['fullScreenMobileMenuStyle'] = wpex_get_mod( 'full_screen_mobile_menu_style', 'white' );
		}

		// Contact form 7 preloader
		if ( defined( 'WPCF7_VERSION' ) ) {
			$array['altercf7Prealoader'] = true;
		}

		// Apply filters and return array - sanitization done by wp_localize_script
		return apply_filters( 'wpex_localize_array', $array );
	}

	/**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @since 2.1.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Load browser dependent stylesheets
	 *
	 * @since 1.6.0
	 */
	public static function browser_dependent_css() {

		// IE8 Stylesheet
		wp_enqueue_style( 'wpex-ie8',
			apply_filters( 'wpex_ie8_stylesheet', wpex_asset_url( 'css/wpex-ie8.css' ) ),
			false,
			WPEX_THEME_VERSION
		);
		wp_style_add_data( 'wpex-ie8', 'conditional', 'IE 8' );

		// IE9 Stylesheet
		wp_enqueue_style( 'wpex-ie9',
			apply_filters( 'wpex_ie9_stylesheet', wpex_asset_url( 'css/wpex-ie9.css' ) ),
			false,
			WPEX_THEME_VERSION
		);
		wp_style_add_data( 'wpex-ie9', 'conditional', 'IE 9' );

	}

	/**
	 * Registers the theme sidebars (widget areas)
	 *
	 * @since 1.6.0
	 */
	public static function register_sidebars() {

		// Define sidebars array
		$sidebars = array(
			'sidebar' => esc_html__( 'Main Sidebar', 'total' ),
		);

		// Pages Sidebar
		if ( wpex_get_mod( 'pages_custom_sidebar', true ) ) {
			$sidebars['pages_sidebar'] = esc_html__( 'Pages Sidebar', 'total' );
		}

		// Search Results Sidebar
		if ( wpex_get_mod( 'search_custom_sidebar', true ) ) {
			$sidebars['search_sidebar'] = esc_html__( 'Search Results Sidebar', 'total' );
		}

		// Apply filters - makes it easier to register new sidebars
		$sidebars = apply_filters( 'wpex_register_sidebars_array', $sidebars );

		// Register sidebars
		if ( $sidebars ) {

			// Sidebar tags
			$tag = wpex_get_mod( 'sidebar_headings', 'div' );
			$tag = $tag ? $tag : 'div';

			// Loop through sidebars and register them
			foreach ( $sidebars as $id => $name ) {
				register_sidebar( array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<div id="%1$s" class="sidebar-box widget %2$s clr">',
					'after_widget'  => '</div>',
					'before_title'  => '<'. $tag .' class="widget-title">',
					'after_title'   => '</'. $tag .'>',
				) );
			}

		}

	}

	/**
	 * Registers footer widgets
	 *
	 * @since 3.6.0
	 */
	public static function footer_widgets() {

		// Check if footer widgets are enabled
		$footer_widgets = apply_filters( 'wpex_register_footer_sidebars', wpex_get_mod( 'footer_widgets', true ) );

		// return if no widgets
		if ( ! $footer_widgets ) {
			return;
		}

		// Footer tag
		$tag = wpex_get_mod( 'footer_headings', 'div' );
		$tag = $tag ? $tag : 'div';

		// Footer widget columns
		$footer_columns = wpex_get_mod( 'footer_widgets_columns', '4' );
		
		// Footer 1
		register_sidebar( array(
			'name'          => esc_html__( 'Footer Column 1', 'total' ),
			'id'            => 'footer_one',
			'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s clr">',
			'after_widget'  => '</div>',
			'before_title'  => '<'. $tag .' class="widget-title">',
			'after_title'   => '</'. $tag .'>',
		) );
		
		// Footer 2
		if ( $footer_columns > '1' ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer Column 2', 'total' ),
				'id'            => 'footer_two',
				'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $tag .' class="widget-title">',
				'after_title'   => '</'. $tag .'>'
			) );
		}
		
		// Footer 3
		if ( $footer_columns > '2' ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer Column 3', 'total' ),
				'id'            => 'footer_three',
				'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $tag .' class="widget-title">',
				'after_title'   => '</'. $tag .'>',
			) );
		}
		
		// Footer 4
		if ( $footer_columns > '3' ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer Column 4', 'total' ),
				'id'            => 'footer_four',
				'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $tag .' class="widget-title">',
				'after_title'   => '</'. $tag .'>',
			) );
		}

		// Footer 5
		if ( $footer_columns > '4' ) {
			register_sidebar( array(
				'name'          => esc_html__( 'Footer Column 5', 'total' ),
				'id'            => 'footer_five',
				'before_widget' => '<div id="%1$s" class="footer-widget widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<'. $tag .' class="widget-title">',
				'after_title'   => '</'. $tag .'>',
			) );
		}

	}

	/**
	 * All theme functions hook into the wpex_head_css filter for this function.
	 * This way all dynamic CSS is minified and outputted in one location in the site header.
	 *
	 * @since 1.6.0
	 */
	public static function custom_css( $output = NULL ) {

		// Add filter for adding custom css via other functions
		$output = apply_filters( 'wpex_head_css', $output );

		// Minify and output CSS in the wp_head
		if ( ! empty( $output ) ) {
			echo '<style type="text/css" data-type="wpex-css">'. wp_strip_all_tags( wpex_minify_css( $output ) ) .'</style>';
		}

	}

	/**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.6.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}

	/**
	 * Alters the default WordPress tag cloud widget arguments.
	 * Makes sure all font sizes for the cloud widget are set to 1em.
	 *
	 * @since 1.6.0 
	 */
	public static function widget_tag_cloud_args( $args ) {
		$args['largest']  = '0.923';
		$args['smallest'] = '0.923';
		$args['unit']     = 'em';
		return $args;
	}

	/**
	 * Alter wp list categories arguments.
	 * Adds a span around the counter for easier styling.
	 *
	 * @since 1.6.0
	 */
	public static function wp_list_categories_args( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="cat-count-span">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}

	/**
	 * This function runs before the main query.
	 *
	 * @since 1.6.0
	 */
	public static function pre_get_posts( $query ) {

		// Only alter main query
		if ( ! $query->is_main_query() ) {
			return;
		}

		// Search pagination
		if ( is_search() ) {
			$query->set( 'posts_per_page', wpex_get_mod( 'search_posts_per_page', '10' ) );
			return;
		}

		// Exclude categories from the main blog
		if ( ( is_home() || is_page_template( 'templates/blog.php' ) ) && $cats = wpex_blog_exclude_categories() ) {
			$query->set( 'category__not_in', $cats );
			return;
		}

		// Category pagination
		if ( $query->is_category() ) {
			$terms = get_terms( 'category' );
			if ( ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( is_category( $term->slug ) ) {
						$term_id    = $term->term_id;
						$term_data  = get_option( "category_$term_id" );
						if ( $term_data ) {
							if ( ! empty( $term_data['wpex_term_posts_per_page'] ) ) {
								$query->set( 'posts_per_page', $term_data['wpex_term_posts_per_page'] );
								return;
							}
						}
					}
				}
			}
		}

	}

	/**
	 * Add new user fields / user meta
	 *
	 * @since 1.6.0
	 */
	public static function add_user_social_fields( $contactmethods ) {

		$branding = wpex_get_theme_branding();
		$branding = $branding ? $branding .' - ' : '';

		if ( ! isset( $contactmethods['wpex_twitter'] ) ) {
			$contactmethods['wpex_twitter'] = $branding .'Twitter';
		}

		if ( ! isset( $contactmethods['wpex_facebook'] ) ) {
			$contactmethods['wpex_facebook'] = $branding .'Facebook';
		}

		if ( ! isset( $contactmethods['wpex_googleplus'] ) ) {
			$contactmethods['wpex_googleplus'] = $branding .'Google+';
		}

		if ( ! isset( $contactmethods['wpex_linkedin'] ) ) {
			$contactmethods['wpex_linkedin'] = $branding .'LinkedIn';
		}

		if ( ! isset( $contactmethods['wpex_pinterest'] ) ) {
			$contactmethods['wpex_pinterest'] = $branding .'Pinterest';
		}
		
		if ( ! isset( $contactmethods['wpex_instagram'] ) ) {
			$contactmethods['wpex_instagram'] = $branding .'Instagram';
		}

		return $contactmethods;

	}

	/**
	 * Alters the default oembed output.
	 * Adds special classes for responsive oembeds via CSS.
	 *
	 * @since 1.6.0
	 */
	public static function oembed_html( $cache, $url, $attr, $post_ID ) {

		// Remove frameborder
		$cache = str_replace( 'frameborder="0"', '', $cache );

		// Supported video embeds
		$hosts = apply_filters( 'wpex_oembed_responsive_hosts', array(
			'vimeo.com',
			'youtube.com',
			'blip.tv',
			'money.cnn.com',
			'dailymotion.com',
			'flickr.com',
			'hulu.com',
			'kickstarter.com',
			'vine.co',
			'soundcloud.com',
		) );

		// Supports responsive
		$supports_responsive = false;

		// Check if responsive wrap should be added
		foreach( $hosts as $host ) {
			if ( strpos( $url, $host ) !== false ) {
				$supports_responsive = true;
				break; // no need to loop further
			}
		}

		// Output code
		if ( $supports_responsive ) {
			return '<p class="responsive-video-wrap wpex-clr">' . $cache . '</p>';
		} else {
			return '<div class="wpex-oembed-wrap wpex-clr">' . $cache . '</div>';
		}

	}

	/**
	 * The wp_get_attachment_url() function doesn't distinguish whether a page request arrives via HTTP or HTTPS.
	 * Using wp_get_attachment_url filter, we can fix this to avoid the dreaded mixed content browser warning
	 *
	 * @since 1.6.0
	 */
	public static function honor_ssl_for_attachments( $url ) {
		$http     = site_url( FALSE, 'http' );
		$https    = site_url( FALSE, 'https' );
		$isSecure = false;
		if ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) {
			$isSecure = true;
		}
		if ( $isSecure ) {
			return str_replace( $http, $https, $url );
		} else {
			return $url;
		}
	}

	/**
	 * Alters the default WordPress password protected form so it's easier to style
	 *
	 * @since 2.0.0
	 */
	public static function custom_password_protected_form() {
		ob_start();
		include( locate_template( 'partials/password-protection-form.php' ) );
		return ob_get_clean();
	}


	/**
	 * Modify JOIN in the next/prev function
	 *
	 * @since 2.0.0
	 */
	public static function prev_next_join( $join ) {
		global $wpdb;
		$join .= " LEFT JOIN $wpdb->postmeta AS m ON ( p.ID = m.post_id AND m.meta_key = 'wpex_post_link' )";
		return $join;
	}

	/**
	 * Modify WHERE in the next/prev function
	 *
	 * @since 2.0.0
	 */
	public static function prev_next_where( $where ) {
		$where .= " AND ( (m.meta_key = 'wpex_post_link' AND CAST(m.meta_value AS CHAR) = '' ) OR m.meta_id IS NULL ) ";
		return $where;
	}

	/**
	 * Redirect posts using custom links
	 *
	 * @since 2.0.0
	 */
	public static function redirect_custom_links() {
		if ( ! wpex_vc_is_inline()
			&& is_singular()
			&& $custom_link = wpex_get_custom_permalink()
		) {
			wp_redirect( $custom_link, 301 );
		}
	}

	/**
	 * When a term is deleted, delete its data.
	 *
	 * @since 2.1.0
	 */
	public static function delete_term( $term_id ) {

		// If term id is defined
		if ( $term_id = absint( $term_id ) ) {
			
			// Get terms data
			$term_data = get_option( 'wpex_term_data' );

			// Remove key with term data
			if ( $term_data && isset( $term_data[$term_id] ) ) {
				unset( $term_data[$term_id] );
				update_option( 'wpex_term_data', $term_data );
			}

		}

	}

	/**
	 * Adds extra classes to the post_class() output
	 *
	 * @since 3.0.0
	 */
	public static function post_class( $classes ) {

		// Get post type
		$type = get_post_type();

		// Not needed here
		if ( 'forum' == $type || 'topic' == $type ) {
			return $classes;
		}

		// Add entry class
		$classes[] = 'entry';

		// Add has media class (requires wpex media metabox)
		$check_gallery = ( 'post' == $type && wpex_get_mod( 'blog_entry_gallery_output', true ) ) ? true : false;
		if ( wpex_post_has_media( get_the_ID(), $check_gallery ) ) {
			$classes[] = 'has-media';
		} else {
			$classes[] = 'no-media';
		}

		// Return classes
		return $classes;

	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 3.0.0
	 */
	public static function the_author_posts_link( $link ) {

		// Add schema markup
		$schema = wpex_get_schema_markup( 'author_link' );
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author"'. $schema, $link );
		}

		// Return link
		return $link;

	}

	/**
	 * Move Comment form field back to bottom which was altered in WP 4.4
	 *
	 * @since 3.3.0
	 */
	public static function move_comment_form_fields( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}

	/**
	 * Disable canonical redirect on the homepage when using pagination via VC modules
	 * or when using the blog template on the homepage
	 *
	 * @since 3.3.3
	 */
	public static function home_pagination_fix( $redirect_url ) {
		if ( is_paged() && is_singular() ) {
			$redirect_url = false;
		}
		return $redirect_url;
	}

	/**
	 * Filters the kses_allowed_protocols for sanitization like esc_url to allow
	 * specific protocols such as skype calls
	 *
	 * @since 3.5.0
	 */
	public static function kses_allowed_protocols( $protocols ) {
		$protocols[] = 'skype';
		return $protocols;
	}

	/**
	 * Filters the comments_link for smoother local scrolling and to
	 * fix issues with fixed/sticky elements
	 *
	 * @since 3.5.0
	 */
	public static function get_comments_link( $comments_link, $post_id ) {
		$hash = get_comments_number( $post_id ) ? '#view_comments' : '#comments_reply';
		$comments_link = get_permalink( $post_id ) . $hash;
		return $comments_link;
	}

}
new WPEX_Theme_Setup;