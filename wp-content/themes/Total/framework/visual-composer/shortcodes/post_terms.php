<?php
/**
 * Visual Composer Post Terms
 *
 * @package Total WordPress Theme
 * @subpackage VC Functions
 * @version 3.6.0
 */

if ( ! class_exists( 'VCEX_Post_Terms_Shortcode' ) ) {

	class VCEX_Post_Terms_Shortcode {

		/**
		 * Main constructor
		 *
		 * @since 3.6.0
		 */
		public function __construct() {
			
			// Add main shortcode
			add_shortcode( 'vcex_post_terms', array( 'VCEX_Post_Terms_Shortcode', 'output' ) );

			// Add grid item shortcode @todo
			//add_shortcode( 'vcex_gitem_post_terms', array( 'VCEX_Post_Terms_Shortcode', 'gitem_output' ) );

			// Map to VC
			if ( function_exists( 'vc_lean_map' ) ) {
				vc_lean_map( 'vcex_post_terms', array( 'VCEX_Post_Terms_Shortcode', 'map' ) );
			}

			// Admin filters
			if ( is_admin() ) {

				// Suggest tax
				add_filter( 'vc_autocomplete_vcex_post_terms_taxonomy_callback', 'vcex_suggest_taxonomies', 10, 1 );
				add_filter( 'vc_autocomplete_vcex_post_terms_taxonomy_render', 'vcex_render_taxonomies', 10, 1 );

				// Suggest terms
				add_filter( 'vc_autocomplete_vcex_post_terms_exclude_terms_callback', 'vcex_suggest_terms', 10, 1 );
				add_filter( 'vc_autocomplete_vcex_post_terms_exclude_terms_render', 'vcex_render_terms', 10, 1 );

			}

		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.6.0
		 */
		public static function output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_post_terms.php' ) );
			return ob_get_clean();
		}

		/**
		 * Shortcode output => Get template file and display shortcode
		 *
		 * @since 3.6.0
		 */
		public static function gitem_output( $atts, $content = null ) {
			ob_start();
			include( locate_template( 'vcex_templates/vcex_post_terms.php' ) );
			return ob_get_clean();
		}

		/**
		 * Map shortcode to VC
		 *
		 * @since 3.6.0
		 */
		public static function map() {
			
			// Strings
			$s_enable = esc_html__( 'Enable', 'total' );
			$s_yes    = esc_html__( 'Yes', 'total' );
			$s_no     = esc_html__( 'No', 'total' );
			$s_link   = esc_html__( 'Link', 'total' );
			$s_design = esc_html__( 'Design', 'total' );

			// Return array
			return array(
				'name' => esc_html__( 'Post Terms', 'total' ),
				'description' => esc_html__( 'Display your post terms.', 'total' ),
				'base' => 'vcex_post_terms',
				'category' => wpex_get_theme_branding(),
				'icon' => 'vcex-post-terms vcex-icon fa fa-folder',
				'params' => array(
					// General
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Unique Id', 'total' ),
						'param_name' => 'unique_id',
						'admin_label' => true,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Custom Classes', 'total' ),
						'param_name' => 'classes',
						'admin_label' => true,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'CSS Animation', 'total' ),
						'param_name' => 'css_animation',
						'value' => array_flip( wpex_css_animations() ),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Visibility', 'total' ),
						'param_name' => 'visibility',
						'value' => array_flip( wpex_visibility() ),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Taxonomy', 'total' ),
						'param_name' => 'taxonomy',
						'admin_label' => true,
						'std' => '',
						'settings' => array(
							'multiple' => false,
							'min_length' => 1,
							'groups' => false,
							'unique_values' => true,
							'display_inline' => true,
							'delay' => 0,
							'auto_focus' => true,
						),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Exclude terms', 'total' ),
						'param_name' => 'exclude_terms',
						'settings' => array(
							'multiple' => true,
							'min_length' => 1,
							'groups' => true,
							'display_inline' => true,
							'delay' => 0,
							'auto_focus' => true,
						),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order', 'total' ),
						'param_name' => 'order',
						'value' => array(
							esc_html__( 'ASC', 'total' ) => 'ASC',
							esc_html__( 'DESC', 'total' ) => 'DESC',					),
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Order By', 'total' ),
						'param_name' => 'orderby',
						'value' => array(
							esc_html__( 'Name', 'total' ) => 'name',
							esc_html__( 'Slug', 'total' ) => 'slug',
							esc_html__( 'Term Group', 'total' ) => 'term_group',
							esc_html__( 'Term ID', 'total' ) => 'term_id',
							'ID' => 'id',
							esc_html__( 'Description', 'total' ) => 'description',
						),
					),
					// Link
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Link to Archive?', 'total' ),
						'param_name' => 'archive_link',
						'value' => array( $s_yes => 'true', $s_no => 'false', ),
						'group' => $s_link,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Link Target', 'total' ),
						'param_name' => 'target',
						'value' => array(
							esc_html__( 'Self', 'total' ) => '',
							esc_html__( 'Blank', 'total' ) => 'blank',
						),
						'group' => $s_link,
					),
					// Design
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Style', 'total' ),
						'param_name' => 'button_style',
						'std' => '',
						'value' => array_flip( wpex_button_styles() ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'button_color_style',
						'std' => '',
						'value' => array_flip( wpex_button_colors() ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Align', 'total' ),
						'param_name' => 'button_align',
						'value' => array_flip( wpex_alignments() ),
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Size', 'total' ),
						'param_name' => 'button_size',
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
						'param_name' => 'button_font_family',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Background', 'total' ),
						'param_name' => 'button_background',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Background: Hover', 'total' ),
						'param_name' => 'button_hover_background',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color', 'total' ),
						'param_name' => 'button_color',
						'group' => $s_design,
					),
					array(
						'type' => 'colorpicker',
						'heading' => esc_html__( 'Color: Hover', 'total' ),
						'param_name' => 'button_hover_color',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Font Size', 'total' ),
						'param_name' => 'button_font_size',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Letter Spacing', 'total' ),
						'param_name' => 'button_letter_spacing',
						'group' => $s_design,
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Text Transform', 'total' ),
						'param_name' => 'button_text_transform',
						'group' => $s_design,
						'value' => array_flip( wpex_text_transforms() ),
						'std' => '',
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__( 'Font Weight', 'total' ),
						'param_name' => 'button_font_weight',
						'value' => array_flip( wpex_font_weights() ),
						'std' => '',
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Border Radius', 'total' ),
						'param_name' => 'button_border_radius',
						'description' => esc_html__( 'Please enter a px value.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Padding', 'total' ),
						'param_name' => 'button_padding',
						'description' => esc_html__( 'Please use the following format: top right bottom left.', 'total' ),
						'group' => $s_design,
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Margin', 'total' ),
						'param_name' => 'button_margin',
						'description' => esc_html__( 'Please use the following format: top right bottom left.', 'total' ),
						'group' => $s_design,
					),
				)
			);
		}

	}
}
new VCEX_Post_Terms_Shortcode;