<?php
/**
 * Visual Composer Text Block Configuration
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'VCEX_VC_Column_Text_Config' ) ) {
	
	class VCEX_VC_Column_Text_Config {

		/**
		 * Main constructor
		 *
		 * @since 3.6.0
		 */
		public function __construct() {
			add_action( 'init', array( 'VCEX_VC_Column_Text_Config', 'add_params' ) );
		}

		/**
		 * Adds new params for the VC Rows
		 *
		 * @since 3.6.0
		 */
		public static function add_params() {

			// Re-usable strings
			$s_yes = esc_html__( 'Yes', 'total' );
			$s_no = esc_html__( 'No', 'total' );

			// Width
			vc_add_param( 'vc_column_text', array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Width', 'total' ),
				'param_name' => 'width',
				'description' => esc_html__( 'Enter a custom width instead of using breaks to slim down your content width.', 'total' ),
			) );

			// Typography
			$typo_params = array(
				array(
					'type' => 'colorpicker',
					'heading' => esc_html__( 'Color', 'total' ),
					'param_name' => 'color',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Font Size', 'total' ),
					'param_name' => 'font_size',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Responsive Font Size', 'total' ),
					'param_name' => 'responsive_text',
					'value' => array(
						$s_no => 'false',
						$s_yes => 'true',
					),
					'dependency' => array( 'element' => 'font_size', 'not_empty' => true ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Minimum Font Size', 'total' ),
					'param_name' => 'min_font_size',
					'dependency' => array( 'element' => 'responsive_text', 'value' => 'true' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Line Height', 'total' ),
					'param_name' => 'line_height',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Letter Spacing', 'total' ),
					'param_name' => 'letter_spacing',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Italic', 'total' ),
					'param_name' => 'italic',
					'value' => array(
						$s_no => 'false',
						$s_yes => 'true',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Font Weight', 'total' ),
					'param_name' => 'font_weight',
					'value' => array_flip( wpex_font_weights() ),
					'std' => '',
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Text Align', 'total' ),
					'param_name' => 'text_align',
					'value' => array_flip( wpex_alignments() ),
					'std' => '',
				),
				array(
					'type' => 'vcex_font_family_select',
					'heading' => esc_html__( 'Font Family', 'total' ),
					'param_name' => 'font_family',
				),
			);

			foreach ( $typo_params as $param ) {
				$param['group'] = esc_html__( 'Typography', 'total' );
				vc_add_param( 'vc_column_text', $param );
			}

		}

	}

	new VCEX_VC_Column_Text_Config();

}