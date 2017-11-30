<?php
/**
 * Registers the button shortcode and adds it to the Visual Composer
 *
 * @package Total WordPress Theme
 * @subpackage VC Templates
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Button_Shortcode' ) ) {

	class VCEX_Button_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.5.0
		 */
		public function __construct() {
			
			// Add shortcode
			add_shortcode( 'vcex_button', array( 'VCEX_Button_Shortcode', 'output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_button', array( 'VCEX_Button_Shortcode', 'map' ) );
			}

			// Parse attributes
			if ( is_admin() ) {
				add_filter( 'vc_edit_form_fields_attributes_vcex_button', array( 'VCEX_Button_Shortcode', 'edit_form_fields' ) );
			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.5.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_button.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.5.0
		 */
		public static function map() {

			// Same re-usable strings
			$s_design = esc_html__( 'Design', 'total' );
			$s_icons  = esc_html__( 'Icons', 'total' );

			// Return array of settings
			return array(
				'name' => esc_html__( 'Total Button', 'total' ),
				'description' => esc_html__( 'Eye catching button', 'total' ),
				'base' => 'vcex_button',
				'category' => wpex_get_theme_branding(),
				'icon' => 'vcex-total-button vcex-icon fa fa-external-link-square',
				'params' => array(

					// General
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => esc_html__( 'Unique Id', 'total' ),
						'param_name' => 'unique_id',
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => esc_html__( 'Extra class name', 'total' ),
						'param_name' => 'classes',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'total' ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Visibility', 'total' ),
						'param_name' => 'visibility',
						'value' => array_flip( wpex_visibility() ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Appear Animation', 'total'),
						'param_name' => 'css_animation',
						'value' => array_flip( wpex_css_animations() ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Hover Animation', 'total'),
						'param_name' => 'hover_animation',
						'value' => array_flip( wpex_hover_css_animations() ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'On click action', 'total' ),
						'param_name' => 'onclick',
						'value' => array(
							esc_html__( 'Open custom link', 'total' ) => 'custom_link',
							esc_html__( 'Open image', 'total' ) => 'image',
							esc_html__( 'Open lightbox', 'total' ) => 'lightbox',
						),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'URL', 'total' ),
						'param_name' => 'url',
						'value' => 'https://www.google.com/',
						'dependency' => array( 'element' => 'onclick', 'value' => array( 'custom_link', 'lightbox' ) ),
					),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Image', 'total' ),
						'param_name' => 'image_attachment',
						'dependency' => array( 'element' => 'onclick', 'value' => array( 'image', 'lightbox' ) ),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Text', 'total' ),
						'param_name' => 'content',
						'admin_label' => true,
						'std' => 'Button Text',
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Link Title', 'total' ),
						'param_name' => 'title',
						'value' => 'Visit Site',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Link Target', 'total' ),
						'param_name' => 'target',
						'value' => array(
							esc_html__( 'Self', 'total' ) => '',
							esc_html__( 'Blank', 'total' ) => 'blank',
							esc_html__( 'Local', 'total' ) => 'local',
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Link Rel', 'total' ),
						'param_name' => 'rel',
						'value' => array(
							esc_html__( 'None', 'total' ) => '',
							esc_html__( 'Nofollow', 'total' ) => 'nofollow',
						),
					),
					// Design
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'total' ),
						'param_name' => 'style',
						'std' => '',
						'value' => array_flip( wpex_button_styles() ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Layout', 'total' ),
						'param_name' => 'layout',
						'value' => array(
							esc_html__( 'Inline', 'total' ) => '',
							esc_html__( 'Block', 'total' ) => 'block',
							esc_html__( 'Expanded (fit container)', 'total' ) => 'expanded',
						),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Align', 'total' ),
						'param_name' => 'align',
						'value' => array_flip( wpex_alignments() ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Size', 'total' ),
						'param_name' => 'size',
						'std' => '',
						'value' => array(
							esc_html__( 'Default', 'total' ) => '',
							esc_html__( 'Small', 'total' ) => 'small',
							esc_html__( 'Medium', 'total' ) => 'medium',
							esc_html__( 'Large', 'total' ) => 'large',
						),
						'group' => $s_design,
					),
					array(
						'type' => 'vcex_font_family_select',
						'heading' => esc_html__( 'Font Family', 'total' ),
						'param_name' => 'font_family',
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'color',
						'std' => '',
						'value' => array_flip( wpex_button_colors() ),
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Background', 'total' ),
						'param_name' => 'custom_background',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Background: Hover', 'total' ),
						'param_name' => 'custom_hover_background',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'custom_color',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color: Hover', 'total' ),
						'param_name' => 'custom_hover_color',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Font Size', 'total' ),
						'param_name' => 'font_size',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Letter Spacing', 'total' ),
						'param_name' => 'letter_spacing',
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Text Transform', 'total' ),
						'param_name' => 'text_transform',
						'group' => $s_design,
						'value' => array_flip( wpex_text_transforms() ),
						'std' => '',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Font Weight', 'total' ),
						'param_name' => 'font_weight',
						'value' => array_flip( wpex_font_weights() ),
						'std' => '',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Custom Width', 'total' ),
						'param_name' => 'width',
						'description' => esc_html__( 'Please use a pixel or percentage value.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Border Radius', 'total' ),
						'param_name' => 'border_radius',
						'description' => esc_html__( 'Please enter a px value.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Padding', 'total' ),
						'param_name' => 'font_padding',
						'description' => esc_html__( 'Please use the following format: top right bottom left.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Margin', 'total' ),
						'param_name' => 'margin',
						'description' => esc_html__( 'Please use the following format: top right bottom left.', 'total' ),
						'group' => $s_design,
					),
					// Lightbox
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Type', 'total' ),
						'param_name' => 'lightbox_type',
						'value' => array(
							esc_html__( 'Auto Detect - slow', 'total' ) => '',
							esc_html__( 'iFrame', 'total' ) => 'iframe',
							esc_html__( 'Image', 'total' ) => 'image',
							esc_html__( 'Video', 'total' ) => 'video_embed',
							esc_html__( 'HTML5', 'total' ) => 'html5',
							esc_html__( 'Quicktime', 'total' ) => 'quicktime',
						),
						'description' => esc_html__( 'Auto detect depends on the iLightbox API, so by choosing your type it speeds things up and you also allows for HTTPS support.', 'total' ),
						'group' => esc_html__( 'Lightbox', 'total' ),
						'dependency' => array( 'element' => 'onclick', 'value' => 'lightbox' ),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'HTML5 Webm URL', 'total' ),
						'param_name' => 'lightbox_video_html5_webm',
						'description' => esc_html__( 'Enter the URL to a video, SWF file, flash file or a website URL to open in lightbox.', 'total' ),
						'group' => esc_html__( 'Lightbox', 'total' ),
						'dependency' => array( 'element' => 'lightbox_type', 'value' => 'html5' ),
					),
					array(
						'type' => 'attach_image',
						'heading' => esc_html__( 'Lightbox HTML5 Poster Image', 'total' ),
						'param_name' => 'lightbox_poster_image',
						'dependency' => array( 'element' => 'lightbox_type', 'value' => 'html5' ),
						'group' => esc_html__( 'Lightbox', 'total' ),
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Lightbox Dimensions', 'total' ),
						'param_name' => 'lightbox_dimensions',
						'description' => esc_html__( 'Enter a custom width and height for your lightbox pop-up window. Use format widthxheight. Example: 900x600.', 'total' ),
						'group' => esc_html__( 'Lightbox', 'total' ),
						'dependency' => array( 'element' => 'onclick', 'value' => 'lightbox' ),
					),
					//Icons
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Icon library', 'total' ),
						'param_name' => 'icon_type',
						'description' => esc_html__( 'Select icon library.', 'total' ),
						'std' => 'fontawesome',
						'value' => array(
							esc_html__( 'Font Awesome', 'total' ) => 'fontawesome',
							esc_html__( 'Open Iconic', 'total' ) => 'openiconic',
							esc_html__( 'Typicons', 'total' ) => 'typicons',
							esc_html__( 'Entypo', 'total' ) => 'entypo',
							esc_html__( 'Linecons', 'total' ) => 'linecons',
							esc_html__( 'Pixel', 'total' ) => 'pixelicons',
						),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left',
						'settings' => array(
							'emptyIcon' => true,
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left_openiconic',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'openiconic',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left_typicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'typicons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'typicons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left_entypo',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'entypo',
							'iconsPerPage' => 300,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'entypo' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left_linecons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'linecons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'linecons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Left', 'total' ),
						'param_name' => 'icon_left_pixelicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'pixelicons',
							'source' => vcex_pixel_icons(),
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'pixelicons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right',
						'settings' => array(
							'emptyIcon' => true,
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'fontawesome' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right_openiconic',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'openiconic',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'openiconic' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right_typicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'typicons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'typicons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right_entypo',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'entypo',
							'iconsPerPage' => 300,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'entypo' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right_linecons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'linecons',
							'iconsPerPage' => 200,
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'linecons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'iconpicker',
						'heading' => esc_html__( 'Icon Right', 'total' ),
						'param_name' => 'icon_right_pixelicons',
						'settings' => array(
							'emptyIcon' => true,
							'type' => 'pixelicons',
							'source' => vcex_pixel_icons(),
						),
						'dependency' => array( 'element' => 'icon_type', 'value' => 'pixelicons' ),
						'group' => $s_icons,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Left Icon: Right Padding', 'total' ),
						'param_name' => 'icon_left_padding',
						'group' => $s_icons,
					),

					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Right Icon: Left Padding', 'total' ),
						'param_name' => 'icon_right_padding',
						'group' => $s_icons,
					),
					// Design options
					array(
						'type' => 'css_editor',
						'heading' => esc_html__( 'CSS', 'total' ),
						'param_name' => 'css_wrap',
						'group' => esc_html__( 'CSS', 'total' ),
					),
					// Deprecated
					array( 'type' => 'hidden', 'param_name' => 'lightbox' ),
					array( 'type' => 'hidden', 'param_name' => 'lightbox_image' ),
				)
			);
		}

		/**
		 * Update fields on edit
		 *
		 * @since 3.5.0
		 */
		public function edit_form_fields( $atts ) {
			if ( ! empty( $atts['lightbox_image'] ) ) {
				$atts['image_attachment'] = $atts['lightbox_image'];
				unset( $atts['lightbox_image'] );
			}
			if ( isset( $atts['lightbox'] ) && 'true' == $atts['lightbox'] ) {
				$atts['onclick'] = 'lightbox';
			}
			return $atts;
		}


	}

}
new VCEX_Button_Shortcode;