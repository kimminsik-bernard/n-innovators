<?php
/**
 * Visual Composer Bullets
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Bullets_Shortcode' ) ) {

	class VCEX_Bullets_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.5.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'vcex_bullets', array( 'VCEX_Bullets_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_bullets', array( 'VCEX_Bullets_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.5.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_bullets.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.5.0
		 */
		public static function map() {
			// Reusable strings
			$s_icon       = esc_html__( 'Icon', 'total' );
			$s_typography = esc_html__( 'Typography', 'total' );
			// Return array
			return array(
				'name' => esc_html__( 'Bullets', 'total' ),
				'description' => esc_html__( 'Styled bulleted lists', 'total' ),
				'base' => 'vcex_bullets',
				'category' => wpex_get_theme_branding(),
				'icon' => 'vcex-bullets vcex-icon fa fa-dot-circle-o',
				'params' => array(
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'total' ),
						'param_name' => 'style',
						'admin_label' => true,
						'value' => array(
							esc_html__( 'Check', 'total') => 'check',
							esc_html__( 'Blue', 'total' ) => 'blue',
							esc_html__( 'Gray', 'total' ) => 'gray',
							esc_html__( 'Purple', 'total' ) => 'purple',
							esc_html__( 'Red', 'total' ) => 'red',
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Custom Icon', 'total' ),
						'param_name' => 'icon_type',
						'description' => esc_html__( 'Select icon library.', 'total' ),
						'value' => array(
							esc_html__( 'None', 'total' ) => '',
							esc_html__( 'Font Awesome', 'total' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'total' ) => 'openiconic',
							esc_html__( 'Typicons', 'total' ) => 'typicons',
							esc_html__( 'Entypo', 'total' ) => 'entypo',
							esc_html__( 'Linecons', 'total' ) => 'linecons',
						),
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon',
						'admin_label' => true,
						'value' => 'fa fa-info-circle',
						'settings' => array(
							'emptyIcon' => true,
							'iconsPerPage' => 4000,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_openiconic',
						'std' => '',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'openiconic',
							'iconsPerPage' => 4000,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_typicons',
						'std' => '',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'typicons',
							'iconsPerPage' => 4000,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'typicons' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_entypo',
						'std' => '',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'entypo',
							'iconsPerPage' => 4000,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'entypo' ),
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_linecons',
						'std' => '',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'linecons',
							'iconsPerPage' => 4000,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'linecons' ),
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon Color', 'total' ),
						'param_name' => 'icon_color',
						'dependency' => array( 'element' => 'icon_type', 'not_empty' => true ),
					),
					array(
						'type' => 'textarea_html',
						'heading' => esc_html__( 'Insert Unordered List', 'total' ),
						'param_name' => 'content',
						'value' => '<ul><li>List 1</li><li>List 2</li><li>List 3</li><li>List 4</li></ul>',
					),
					// Typography
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'color',
						'group' => $s_typography,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Font Size', 'total' ),
						'param_name' => 'font_size',
						'group' => $s_typography,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Line Height', 'total' ),
						'param_name' => 'line_height',
						'group' => $s_typography,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Letter Spacing', 'total' ),
						'param_name' => 'letter_spacing',
						'group' => $s_typography,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Font Weight', 'total' ),
						'param_name' => 'font_weight',
						'value' => array_flip( wpex_font_weights() ),
						'std' => '',
						'group' => $s_typography,
					),
					array(
						'type' => 'vcex_font_family_select',
						'heading' => esc_html__( 'Font Family', 'total' ),
						'param_name' => 'font_family',
						'group' => $s_typography,
					),
				)
			);
		}

	}
}
new VCEX_Bullets_Shortcode;