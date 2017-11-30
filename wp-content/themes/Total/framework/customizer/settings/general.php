<?php
/**
 * Customizer => General Panel
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Accent Colors
$this->sections['wpex_accent_colors'] = array(
	'title' => esc_html__( 'Accent Colors', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'accent_color',
			'default' => '#3b86b0',
			'transport' => 'refresh',
			'control' => array(
				'label' => esc_html__( 'Accent Color', 'total' ),
				'type' => 'color',
			),
		),
		array(
			'id' => 'main_border_color',
			'default' => '#eee',
			'control' => array(
				'label' => esc_html__( 'Border Accent Color', 'total' ),
				'type' => 'color',
			),
		),
	)
);

// Background
$patterns_url = WPEX_THEME_URI .'/images/patterns/';
$this->sections['wpex_background'] = array(
	'title'  => esc_html__( 'Site Background', 'total' ),
	'panel'  => 'wpex_general',
	'desc' => esc_html__( 'Here you can alter the global site background. It is highly recommended that you first set the site layout to "Boxed" under the Layout options.', 'total' ),
	'settings' => array(
		array(
			'id' => 'background_color',
			'control' => array(
				'label' => esc_html__( 'Background Color', 'total' ),
				'type' => 'color',
			),
		),
		array(
			'id' => 'background_image',
			'control' => array(
				'label' => esc_html__( 'Custom Background Image', 'total' ),
				'type' => 'image',
				'active_callback' => 'wpex_cac_hasnt_background_pattern',
			),
		),
		array(
			'id' => 'background_style',
			'default' => 'stretched',
			'control' => array(
				'label' => esc_html__( 'Background Image Style', 'total' ),
				'type'  => 'image',
				'type'  => 'select',
				'active_callback' => 'wpex_cac_has_background_image',
				'choices' => $bg_styles,
			),
		),
		array(
			'id' => 'background_pattern',
			'control' => array(
				'label' => esc_html__( 'Background Pattern', 'total' ),
				'type'  => 'image',
				'type'  => 'select',
				'active_callback' => 'wpex_cac_hasnt_background_image',
				'choices' => array(
					'' => esc_html__( 'None', 'total' ),
					$patterns_url .'dark_wood.png'  => esc_html__( 'Dark Wood', 'total' ),
					$patterns_url .'diagmonds.png'  => esc_html__( 'Diamonds', 'total' ),
					$patterns_url .'grilled.png' => esc_html__( 'Grilled', 'total' ),
					$patterns_url .'lined_paper.png' => esc_html__( 'Lined Paper', 'total' ),
					$patterns_url .'old_wall.png' => esc_html__( 'Old Wall', 'total' ),
					$patterns_url .'ricepaper2.png' => esc_html__( 'Rice Paper', 'total' ),
					$patterns_url .'tree_bark.png'  => esc_html__( 'Tree Bark', 'total' ),
					$patterns_url .'triangular.png' => esc_html__( 'Triangular', 'total' ),
					$patterns_url .'white_plaster.png' => esc_html__( 'White Plaster', 'total' ),
					$patterns_url .'wild_flowers.png' => esc_html__( 'Wild Flowers', 'total' ),
					$patterns_url .'wood_pattern.png' => esc_html__( 'Wood Pattern', 'total' ),
				),
			),
		),
	),
);

// Social Sharing Section
$this->sections['wpex_social_sharing'] = array(
	'title'  => esc_html__( 'Social Sharing', 'total' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id'  => 'social_share_sites',
			'transport' => 'partialRefresh',
			'default' => array( 'twitter', 'facebook', 'google_plus', 'pinterest' ),
			'control' => array(
				'label'  => esc_html__( 'Sites', 'total' ),
				'desc' => esc_html__( 'Click and drag and drop elements to re-order them.', 'total' ),
				'type' => 'wpex-sortable',
				'object' => 'WPEX_Customize_Control_Sorter',
				'choices' => array(
					'twitter'  => 'Twitter',
					'facebook' => 'Facebook',
					'google_plus' => 'Google Plus',
					'pinterest' => 'Pinterest',
					'linkedin' => 'LinkedIn',
				),
				'active_callback' => 'wpex_cac_hasnt_custom_social_share',
			),
		),
		array(
			'id' => 'social_share_position',
			'transport' => 'partialRefresh',
			'control' => array(
				'label' => esc_html__( 'Position', 'total' ),
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'horizontal' => esc_html__( 'Horizontal', 'total' ),
					'vertical' => esc_html__( 'Vertical', 'total' ),
				),
				'active_callback' => 'wpex_cac_has_theme_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_style',
			'transport' => 'partialRefresh',
			'default' => 'flat',
			'control' => array(
				'label' => esc_html__( 'Style', 'total' ),
				'type'  => 'select',
				'choices' => array(
					'flat' => esc_html__( 'Flat', 'total' ),
					'minimal' => esc_html__( 'Minimal', 'total' ),
					'three-d' => esc_html__( '3D', 'total' ),
					'rounded' => esc_html__( 'Rounded', 'total' ),
				),
				'active_callback' => 'wpex_cac_has_theme_social_share_sites',
			),
		),
		array(
			'transport' => 'partialRefresh',
			'id' => 'social_share_heading_enable',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Horizontal Style Heading?', 'total' ),
				'type'  => 'checkbox',
				'active_callback' => 'wpex_cac_has_theme_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_heading',
			'transport' => 'partialRefresh',
			'default' => esc_html__( 'Please Share This', 'total' ),
			'control' => array(
				'label' => esc_html__( 'Heading on Posts', 'total' ),
				'type'  => 'text',
				'active_callback' => 'wpex_cac_has_theme_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_twitter_handle',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Twitter Handle', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_theme_social_share_sites',
			),
		),
		array(
			'id' => 'social_share_shortcode',
			'transport' => 'partialRefresh',
			'control' => array(
				'label' => esc_html__( 'Alternative Shortcode', 'total' ),
				'type' => 'text',
				'description' => esc_html__( 'Override the theme default social share with your custom social sharing shortcode.', 'total' ),
			),
		),
	)
);

// Breadcrumbs
$this->sections['wpex_breadcrumbs'] = array(
	'title' => esc_html__( 'Breadcrumbs', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'breadcrumbs',
			'transport' => 'partialRefresh',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Enable', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'breadcrumbs_position',
			'transport' => 'partialRefresh',
			'default' => 'absolute',
			'control' => array(
				'label' => esc_html__( 'Position', 'total' ),
				'type'  => 'select',
				'choices' => array(
					'absolute'  => esc_html__( 'Absolute Right', 'total' ),
					'under-title' => esc_html__( 'Under Title', 'total' ),
					'custom' => esc_html__( 'Custom', 'total' ),
				),
				'active_callback' => 'wpex_cac_has_breadcrumbs',
			),
		),
		array(
			'id' => 'breadcrumbs_home_title',
			'transport' => 'partialRefresh',
			'control' => array(
				'label' => esc_html__( 'Custom Home Title', 'total' ),
				'type'  => 'text',
			),
		),
		array(
			'id' => 'breadcrumbs_first_cat_only',
			'transport' => 'partialRefresh',
			'default' => false,
			'control' => array(
				'label' => esc_html__( 'First Category Only', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'breadcrumbs_title_trim',
			'transport' => 'partialRefresh',
			'control' => array(
				'label' => esc_html__( 'Title Trim Length', 'total' ),
				'type'  => 'text',
				'desc'  => esc_html__( 'Enter the max number of words to display for your breadcrumbs post title', 'total' ),
			),
		),
		array(
			'id' => 'breadcrumbs_text_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'total' ),
				'active_callback' => 'wpex_cac_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_seperator_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Separator Color', 'total' ),
				'active_callback' => 'wpex_cac_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs .sep',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color', 'total' ),
				'active_callback' => 'wpex_cac_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs a',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'breadcrumbs_link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Link Color: Hover', 'total' ),
				'active_callback' => 'wpex_cac_has_breadcrumbs',
			),
			'inline_css' => array(
				'target' => '.site-breadcrumbs a:hover',
				'alter' => 'color',
			),
		),
	),
);

// Page Title
$this->sections['wpex_page_header'] = array(
	'title' => esc_html__( 'Page Header Title', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'page_header_style',
			'transport' => 'refresh',
			'default' => '',
			'control' => array(
				'label'  => esc_html__( 'Style', 'total' ),
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default','total' ),
					'centered' => esc_html__( 'Centered', 'total' ),
					'centered-minimal' => esc_html__( 'Centered Minimal', 'total' ),
					'hidden' => esc_html__( 'Hidden', 'total' ),
				),
			),
		),
		array(
			'id' => 'page_header_top_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Top Padding', 'total' ),
				'description' => $pixel_desc,
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'padding-top',
			),
		),
		array(
			'id' => 'page_header_bottom_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Bottom Padding', 'total' ),
				'description' => $pixel_desc,
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'padding-bottom',
			),
		),
		array(
			'id' => 'page_header_bottom_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Bottom Margin', 'total' ),
				'description' => $pixel_desc,
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header',
				'alter' => 'margin-bottom',
			),
		),
		array(
			'id' => 'page_header_background',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'total' ),
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'page_header_title_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Text Color', 'total' ),
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods .page-header-title',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'page_header_top_border',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Top Border Color', 'total' ),
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'border-top-color',
			),
		),
		array(
			'id' => 'page_header_bottom_border',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Bottom Border Color', 'total' ),
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => 'border-bottom-color',
			),
		),
		array(
			'id' => 'page_header_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'total' ),
				'description' => $pixel_desc,
				'active_callback' => 'wpex_cac_has_page_header',
			),
			'inline_css' => array(
				'target' => '.page-header.wpex-supports-mods',
				'alter' => array( 'border-width' ),
			),
		),
		array(
			'id' => 'page_header_background_img',
			'transport' => 'refresh',
			'control' => array(
				'type' => 'image',
				'label' => esc_html__( 'Background Image', 'total' ),
				'active_callback' => 'wpex_cac_has_page_header',
			),
		),
		array(
			'id' => 'page_header_background_img_style',
			'default' => 'fixed',
			'control' => array(
				'label' => esc_html__( 'Background Image Style', 'total' ),
				'type'  => 'image',
				'type'  => 'select',
				'active_callback' => 'wpex_cac_supports_page_header_background_img_style',
				'choices' => $bg_styles,
			),
		),
		array(
			'id' => 'page_header_hidden_main_top_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Hidden Page Header Title Spacing', 'total' ),
				'active_callback' => 'wpex_cac_hasnt_page_header',
				'desc' => esc_html__( 'When the page header title is set to hidden there will not be any space between the header and the main content. If you want to add a default space between the header and your main content you can enter the px value here.', 'total' ) .'<br /><br />'. $pixel_desc,
			),
			'inline_css' => array(
				'target' => 'body.page-header-disabled #content-wrap',
				'alter' => 'padding-top',
				'sanitize' => 'px',
			),
		),
	),
);

// Pages
$blocks = apply_filters( 'wpex_page_single_blocks', array(
	'title'    => esc_html__( 'Title', 'total' ),
	'media'    => esc_html__( 'Media', 'total' ),
	'content'  => esc_html__( 'Content', 'total' ),
	'share'    => esc_html__( 'Social Share', 'total' ),
	'comments' => esc_html__( 'Comments', 'total' ),
) );
$this->sections['wpex_pages'] = array(
	'title'  => esc_html__( 'Pages', 'total' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'page_single_layout',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Layout', 'total' ),
				'type' => 'select',
				'choices' => $post_layouts,
			),
		),
		array(
			'id' => 'pages_custom_sidebar',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Custom Sidebar', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'page_composer',
			'default' => 'content',
			'control' => array(
				'label' => esc_html__( 'Post Layout Elements', 'total' ),
				'type' => 'wpex-sortable',
				'choices' => $blocks,
				'desc' => esc_html__( 'Click and drag and drop elements to re-order them.', 'total' ),
			),
		),
	),
);

// Search
$this->sections['wpex_search'] = array(
	'title'  => esc_html__( 'Search', 'total' ),
	'panel'  => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'search_style',
			'default' => 'default',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Style', 'total' ),
				'type' => 'select',
				'choices' => array(
					'default' => esc_html__( 'Left Thumbnail', 'total' ),
					'blog' => esc_html__( 'Inherit From Blog','total' ),
				),
			),
		),
		array(
			'id' => 'search_layout',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Layout', 'total' ),
				'type' => 'select',
				'choices' => $post_layouts,
			),
		),
		array(
			'id' => 'search_posts_per_page',
			'default' => '10',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Posts Per Page', 'total' ),
				'type' => 'text',
			),
		),
		array(
			'id' => 'search_custom_sidebar',
			'default' => true,
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Custom Sidebar', 'total' ),
				'type' => 'checkbox',
			),
		),
	),
);

// Scroll to top
$this->sections['wpex_scroll_top'] = array(
	'title' => esc_html__( 'Scroll To Top', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'scroll_top',
			'default' => true,
			'transport' => 'refresh',
			'control' => array(
				'label' => esc_html__( 'Scroll Up Button', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'scroll_top_arrow',
			'default' => 'chevron-up',
			'transport' => 'postMessage',
			'active_callback' => 'wpex_cac_has_scrolltop',
			'control' => array(
				'label' => esc_html__( 'Arrow', 'total' ),
				'type' => 'select',
				'choices' => wpex_get_awesome_icons( 'up_arrows' ),
			),
		),
		array(
			'id' => 'scroll_top_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'total' ),
				'description' => $pixel_desc,
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'sanitize' => 'px',
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'scroll_top_size',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Button Size', 'total' ),
				'description' => $pixel_desc,
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'sanitize' => 'px',
				'alter' => array(
					'width',
					'height',
					'line-height',
				),
			),
		),
		array(
			'id' => 'scroll_top_icon_size',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Icon Size', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'font-size',
			),
		),
		array(
			'id' => 'scroll_top_border_radius',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Radius', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'scroll_top_right_position',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Right Position', 'total' ),
				'description' => esc_html__( 'Default:', 'total' ) .' 40px',
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'right',
			),
		),
		array(
			'id' => 'scroll_top_bottom_position',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Bottom Position', 'total' ),
				'description' => esc_html__( 'Default:', 'total' ) .' 40px',
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'bottom',
			),
		),
		array(
			'id' => 'scroll_top_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'scroll_top_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'scroll_top_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'scroll_top_bg_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'scroll_top_border',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'scroll_top_border_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '#site-scroll-top:hover',
				'alter' => 'border-color',
			),
		),
	),
);

// Pagination
$this->sections['wpex_pagination'] = array(
	'title' => esc_html__( 'Pagination', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'pagination_align',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'select',
				'default' => 'left',
				'label' => esc_html__( 'Align', 'total' ),
				'choices' => array(
					'left' => esc_html__( 'Left', 'total' ),
					'center' => esc_html__( 'Center', 'total' ),
					'right' => esc_html__( 'Right', 'total' ),
				),
			),
		),
		array(
			'id' => 'pagination_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'total' ),
				'description' => $padding_desc,
			),
			'inline_css' => array(
				'target' => 'ul .page-numbers a, a.page-numbers, span.page-numbers, .page-links span, .page-links a > span',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'pagination_font_size',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Font Size', 'total' ),
			),
			'inline_css' => array(
				'target' => 'ul.page-numbers, .page-links',
				'alter' => 'font-size',
			),
		),
		array(
			'id' => 'pagination_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'total' ),
			),
			'inline_css' => array(
				'target' => 'ul .page-numbers a, a.page-numbers, span.page-numbers, .page-links span, .page-links a > span',
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'pagination_border_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'total' ),
			),
			'inline_css' => array(
				'target' => 'ul .page-numbers a, a.page-numbers, span.page-numbers, .page-links span, .page-links a > span',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'pagination_border_hover_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border Color: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers a:hover, .page-numbers.current, .page-numbers.current:hover, .page-links span, .page-links a > span:hover',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'pagination_border_active_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border Color: Active', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers.current, .page-numbers.current:hover',
				'alter' => 'border-color',
				'important' => true,
			),
		),
		array(
			'id' => 'pagination_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'total' ),
			),
			'inline_css' => array(
				'target' => 'ul .page-numbers a, a.page-numbers, span.page-numbers, .page-links span, .page-links a > span',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'pagination_hover_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers a:hover, .page-numbers.current, .page-numbers.current:hover, .page-links span, .page-links a > span:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'pagination_hover_active',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color: Active', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers.current, .page-numbers.current:hover',
				'alter' => 'color',
				'important' => true,
			),
		),
		array(
			'id' => 'pagination_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'total' ),
			),
			'inline_css' => array(
				'target' => 'ul .page-numbers a, a.page-numbers, span.page-numbers, .page-links span, .page-links a > span',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'pagination_hover_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers a:hover, .page-numbers.current, .page-numbers.current:hover, .page-links span, .page-links a > span:hover',
				'alter' => 'background',
			),
		),
		array(
			'id' => 'pagination_active_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background: Active', 'total' ),
			),
			'inline_css' => array(
				'target' => '.page-numbers.current, .page-numbers.current:hover',
				'alter' => 'background',
				'important' => true,
			),
		),
	),
);

// Theme Heading
$this->sections['wpex_theme_heading'] = array(
	'title' => esc_html__( 'Theme Heading', 'total' ),
	'panel' => 'wpex_general',
	'desc' => esc_html__( 'Heading used in various places such as the related and comments heading.', 'total' ),
	'settings' => array(
		array(
			'id' => 'theme_heading_style',
			'control' => array(
				'type' => 'select',
				'default' => '',
				'label' => esc_html__( 'Style', 'total' ),
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'plain' => esc_html__( 'Plain', 'total' ),
					'border-w-color' => esc_html__( 'Bottom Border With Color', 'total' ),
				),
			),
		),
		array(
			'id' => 'theme_heading_tag',
			'default' => 'div',
			'control' => array(
				'label' => esc_html__( 'Tag', 'total' ),
				'type' => 'select',
				'choices' => array(
					'div' => 'div',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
				),
			),
		),
	),
);

// Forms
$this->sections['wpex_general_forms'] = array(
	'title' => esc_html__( 'Forms', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'label_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Labels', 'total' ),
			),
			'inline_css' => array(
				'target' => 'label',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'input_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Padding', 'total' ),
				'description' => $padding_desc,
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'input_border_radius',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Radius', 'total' ),
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => array( 'border-radius', '-webkit-border-radius' ),
			),
		),
		array(
			'id' => 'input_font_size',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Font-Size', 'total' ),
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'font-size',
			),
		),
		array(
			'id' => 'input_background',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'total' ),
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'input_border',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border', 'total' ),
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'input_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'total' ),
				'description' => $pixel_desc,
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'input_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Color', 'total' ),
			),
			'inline_css' => array(
				'target' => array('.site-content input[type="date"],.site-content input[type="time"],.site-content input[type="datetime-local"],.site-content input[type="week"],.site-content input[type="month"],.site-content input[type="text"],.site-content input[type="email"],.site-content input[type="url"],.site-content input[type="password"],.site-content input[type="search"],.site-content input[type="tel"],.site-content input[type="number"],.site-content textarea' ),
				'alter' => 'color',
			),
		),
	),
);


// Links & Buttons
$this->sections['wpex_general_links_buttons'] = array(
	'title' => esc_html__( 'Links & Buttons', 'total' ),
	'panel' => 'wpex_general',
	'settings' => array(
		array(
			'id' => 'link_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Links Color', 'total' ),
			),
			'inline_css' => array(
				'target' => 'a, h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, .entry-title a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'link_color_hover',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Links Color: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => 'a:hover',
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_padding',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Theme Button Padding', 'total' ),
				'description' => $padding_desc,
			),
			'inline_css' => array(
				'target' => '.theme-button,input[type="submit"],button',
				'alter' => 'padding',
			),
		),
		array(
			'id' => 'theme_button_border_radius',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Theme Button Border Radius', 'total' ),
			),
			'inline_css' => array(
				'target' => '.theme-button,input[type="submit"],button',
				'alter' => 'border-radius',
			),
		),
		array(
			'id' => 'theme_button_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Theme Button Color', 'total' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button,input[type="submit"],button',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_hover_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Theme Button Color: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button:hover,input[type="submit"]:hover,button:hover',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'color',
			),
		),
		array(
			'id' => 'theme_button_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Theme Button Background', 'total' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button,input[type="submit"],button',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'background',
			),
		),
		array(
			'id' => 'theme_button_hover_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Theme Button Background: Hover', 'total' ),
			),
			'inline_css' => array(
				'target' => array(
					'.theme-button:hover,input[type="submit"]:hover,button:hover',
					'.navbar-style-one .menu-button > a > span.link-inner:hover',
				),
				'alter' => 'background',
			),
		),
	),
);