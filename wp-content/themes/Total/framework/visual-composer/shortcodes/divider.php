<?php
/**
 * Visual Composer Divider
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Divider_Shortcode' ) ) {

	class VCEX_Divider_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.5.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'vcex_divider', array( 'VCEX_Divider_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_divider', array( 'VCEX_Divider_Shortcode', 'map' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.5.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_divider.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.5.0
		 */
		public static function map() {

			// Define re-usable strings
			$s_icon   = esc_html__( 'Icon', 'total' );
			$s_design = esc_html__( 'Design', 'total' );

			// Return settings array
			return array(
				'name' => esc_html__( 'Divider', 'total' ),
				'description' => esc_html__( 'Line Separator', 'total' ),
				'base' => 'vcex_divider',
				'icon' => 'vcex-divider vcex-icon fa fa-minus',
				'category' => wpex_get_theme_branding(),
				'params' => array(
					// General
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'total' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'total' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Appear Animation', 'total' ),
						'param_name' => 'css_animation',
						'value' => array(
							esc_html__( 'No', 'total' ) => '',
							esc_html__( 'Top to bottom', 'total' ) => 'top-to-bottom',
							esc_html__( 'Bottom to top', 'total' ) => 'bottom-to-top',
							esc_html__( 'Left to right', 'total' ) => 'left-to-right',
							esc_html__( 'Right to left', 'total' ) => 'right-to-left',
							esc_html__( 'Appear from center', 'total' ) => 'appear'
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Visibility', 'total' ),
						'param_name' => 'visibility',
						'value' => array_flip( wpex_visibility() ),
					),
					// Design
					array(
						'type' => 'dropdown',
						'admin_label' => true,
						'heading' => esc_html__( 'Style', 'total' ),
						'param_name' => 'style',
						'value' => array(
							esc_html__( 'Solid', 'total' ) => 'solid',
							esc_html__( 'Dashed', 'total' ) => 'dashed',
							esc_html__( 'Double', 'total' ) => 'double',
							esc_html__( 'Dotted Line', 'total' ) => 'dotted-line',
							esc_html__( 'Dotted', 'total' ) => 'dotted',
						),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Width', 'total' ),
						'param_name' => 'width',
						'description' => esc_html__( 'Enter a pixel or percentage value.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Align', 'total' ),
						'param_name' => 'align',
						'group' => $s_design,
						'value' => array(
							esc_html__( 'Default', 'total' ) => '',
							esc_html__( 'Center', 'total' ) => 'center',
							esc_html__( 'Right', 'total' ) => 'right',
							esc_html__( 'Left', 'total' ) => 'left',
						),
						'dependency' => array( 'element' => 'width', 'not_empty' => true ),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Height', 'total' ),
						'param_name' => 'height',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'solid', 'dashed', 'double', 'dotted-line' ),
						),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Height', 'total' ),
						'param_name' => 'dotted_height',
						'dependency' => array(
							'element' => 'style',
							'value' => 'dotted',
						),
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'color',
						'value' => '',
						'dependency' => array(
							'element' => 'style',
							'value' => array( 'solid', 'dashed', 'double', 'dotted-line' ),
						),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Margin Top', 'total' ),
						'param_name' => 'margin_top',
						'description' => esc_html__( 'Please enter a px value.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Margin Bottom', 'total' ),
						'description' => esc_html__( 'Please enter a px value.', 'total' ),
						'param_name' => 'margin_bottom',
						'group' => $s_design,
					),
					// Icon
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon library', 'total' ),
						'param_name' => 'icon_type',
						'description' => esc_html__( 'Select icon library.', 'total' ),
						'value' => array(
							esc_html__( 'Font Awesome', 'total' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'total' ) => 'openiconic',
							esc_html__( 'Typicons', 'total' ) => 'typicons',
							esc_html__( 'Entypo', 'total' ) => 'entypo',
							esc_html__( 'Linecons', 'total' ) => 'linecons',
							esc_html__( 'Pixel', 'total' ) => 'pixelicons',
						),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon',
						'std' => '',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'fontawesome',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_openiconic',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'openiconic',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_typicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'typicons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'typicons' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_entypo',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'entypo',
							'iconsPerPage' => 300,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'entypo' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_linecons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'linecons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'linecons' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'iconpicker',
						'heading' => $s_icon,
						'param_name' => 'icon_pixelicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'pixelicons',
							'source' => vcex_pixel_icons(),
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'pixelicons' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon Color', 'total' ),
						'param_name' => 'icon_color',
						'group' => $s_icon,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Icon Background', 'total' ),
						'param_name' => 'icon_bg',
						'group' => $s_icon,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Size', 'total' ),
						'param_name' => 'icon_size',
						'description' => esc_html__( 'You can use em or px values, but you must define them.', 'total' ),
						'group' => $s_icon,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Height', 'total' ),
						'param_name' => 'icon_height',
						'group' => $s_icon,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Width', 'total' ),
						'param_name' => 'icon_width',
						'group' => $s_icon,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Border Radius', 'total' ),
						'param_name' => 'icon_border_radius',
						'group' => $s_icon,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Icon Padding', 'total' ),
						'param_name' => 'icon_padding',
						'description' => esc_html__( 'Please use the following format: top right bottom left.', 'total' ),
						'group' => $s_icon,
					),
				)
			);
		}

	}
}
new VCEX_Divider_Shortcode;