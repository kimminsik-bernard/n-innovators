<?php
/**
 * Registers the form shortcode and adds it to the Visual Composer
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Form_Shortcode' ) ) {
	class VCEX_Form_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.6.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'vcex_form_shortcode', array( 'VCEX_Form_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_form_shortcode', array( 'VCEX_Form_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.6.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_form_shortcode.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.6.0
		 */
		public static function map() {
			return array(
				'name' => esc_html__( 'Form Shortcode', 'total' ),
				'description' => esc_html__( 'Form shortcode with style', 'total' ),
				'base' => 'vcex_form_shortcode',
				'category' => wpex_get_theme_branding(),
				'icon' => 'vcex-form-shortcode vcex-icon fa fa-wpforms',
				'params' => array(
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => esc_html__( 'Form Shortcode', 'total' ),
						'param_name' => 'content',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'total' ),
						'param_name' => 'style',
						'std' => '',
						'value' => array_flip( wpex_get_form_styles() ),
						'description' => esc_html__( 'The theme will try and apply the necessary styles to your form (works best with Contact Form 7) but remember every contact form plugin has their own styles so additional tweaks may be required.', 'total' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Full-Width Inputs', 'total' ),
						'param_name' => 'full_width',
						'value' => array(
							esc_html__( 'No', 'total' )  => 'false',
							esc_html__( 'Yes', 'total' ) => 'true',
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Width', 'total' ),
						'param_name' => 'width',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Font Size', 'total' ),
						'param_name' => 'font_size',
					),
					// Design
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'Design', 'total' ),
						'param_name' => 'css',
						'group' => esc_html__( 'Design options', 'total' ),
					),
				),
			);
		}

	}
}
new VCEX_Form_Shortcode;