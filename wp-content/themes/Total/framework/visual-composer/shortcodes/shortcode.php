<?php
/**
 * Visual Composer Shortcode for Shortcodes
 *
 * Provides a better way for adding shortcodes in the VC
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Shortcode' ) ) {

	class VCEX_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.6.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'vcex_shortcode', array( 'VCEX_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_shortcode', array( 'VCEX_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.6.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_shortcode.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.6.0
		 */
		public static function map() {
			return array(
				'name' => esc_html__( 'Shortcode', 'total' ),
				'description' => esc_html__( 'Insert custom shortcodes', 'total' ),
				'base' => 'vcex_shortcode',
				'icon' => 'vcex-shortcode vcex-icon fa fa-cog',
				'category' => wpex_get_theme_branding(),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Shortcode', 'total' ),
						'param_name' => 'content',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Visibility', 'total' ),
						'param_name' => 'visibility',
						'value' => array_flip( wpex_visibility() ),
					),
				),
			);
		}

	}
}
new VCEX_Shortcode;