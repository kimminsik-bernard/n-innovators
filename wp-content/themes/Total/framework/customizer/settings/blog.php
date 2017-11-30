<?php
/**
 * Blog Customizer Options
 *
 * @package Total WordPress Theme
 * @subpackage Customizer
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Entry meta
$entry_meta_defaults = array( 'date', 'author', 'categories', 'comments' );
$entry_meta_choices = array(
	'date'           => esc_html__( 'Date', 'total' ),
	'author'         => esc_html__( 'Author', 'total' ),
	'categories'     => esc_html__( 'Categories', 'total' ),
	'first_category' => esc_html__( 'First Category', 'total' ),
	'comments'       => esc_html__( 'Comments', 'total' ),
);

// Entry Blocks
$entry_blocks = apply_filters( 'wpex_blog_entry_blocks', array(
	'featured_media'  => esc_html__( 'Media', 'total' ),
	'title'           => esc_html__( 'Title', 'total' ),
	'meta'            => esc_html__( 'Meta', 'total' ),
	'excerpt_content' => esc_html__( 'Excerpt', 'total' ),
	'readmore'        => esc_html__( 'Read More', 'total' ),
	'social_share'    => esc_html__( 'Social Share', 'total' ),
) );

// Single Blocks
$single_blocks = apply_filters( 'wpex_blog_single_blocks', array(
	'featured_media' => esc_html__( 'Featured Media','total' ),
	'title'          => esc_html__( 'Title', 'total' ),
	'meta'           => esc_html__( 'Meta', 'total' ),
	'post_series'    => esc_html__( 'Post Series','total' ),
	'the_content'    => esc_html__( 'Content','total' ),
	'post_tags'      => esc_html__( 'Post Tags','total' ),
	'social_share'   => esc_html__( 'Social Share','total' ),
	'author_bio'     => esc_html__( 'Author Box','total' ),
	'related_posts'  => esc_html__( 'Related Posts','total' ),
	'comments'       => esc_html__( 'Comments','total' ),
) );

// General
$this->sections['wpex_blog_general'] = array(
	'title' => esc_html__( 'General', 'total' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'blog_page',
			'transport' => 'partialRefresh',
			'control' => array(
				'label' => esc_html__( 'Main Page', 'total' ),
				'type' => 'wpex-dropdown-pages',
				'desc' => esc_html__( 'This setting is used for breadcrumbs when your main blog page is not the homepage.', 'total' ),
			),
		),
		array(
			'id' => 'blog_cats_exclude',
			'control' => array(
				'label' => esc_html__( 'Exclude Categories From Blog', 'total' ),
				'type' => 'text',
				'desc' => esc_html__( 'Enter the ID\'s of categories to exclude from the blog template or homepage blog seperated by a comma (no spaces).', 'total' ),
			),
		),
	),
);

// Archives
$this->sections['wpex_blog_archives'] = array(
	'title' => esc_html__( 'Archives & Entries', 'total' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'category_description_position',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Category Description Position', 'total' ),
				'type' => 'select',
				'choices' => array(
					''			 => esc_html__( 'Default', 'total' ),
					'under_title' => esc_html__( 'Under Title', 'total' ),
					'above_loop' => esc_html__( 'Above Loop', 'total' ),
					'hidden' => esc_html__( 'Hidden', 'total' ),
				),
			),
		),
		array(
			'id' => 'blog_archives_layout',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Layout', 'total' ),
				'type' => 'select',
				'choices' => $post_layouts,
			),
		),
		array(
			'id' => 'blog_style',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Style', 'total' ),
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'large-image-entry-style' => esc_html__( 'Large Image','total' ),
					'thumbnail-entry-style' => esc_html__( 'Left Thumbnail','total' ),
					'grid-entry-style' => esc_html__( 'Grid','total' ),
				),
			),
		),
		array(
			'id' => 'blog_left_thumbnail_width',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Left Thumbnail Width', 'total' ),
				'type' => 'text',
				'desc' => esc_html__( 'Default', 'total' ) .': 46%',
				'active_callback' => 'wpex_cac_blog_style_left_thumb',
			),
			'inline_css' => array(
				'target' => '.entries.left-thumbs .blog-entry .entry-media',
				'alter' => 'width',
			),
		),
		array(
			'id' => 'blog_right_content_width',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Right Content Width', 'total' ),
				'type' => 'text',
				'desc' => esc_html__( 'Default', 'total' ) .': 50%',
				'active_callback' => 'wpex_cac_blog_style_left_thumb',
			),
			'inline_css' => array(
				'target' => '.entries.left-thumbs .blog-entry .entry-details',
				'alter' => 'width',
			),
		),
		array(
			'id' => 'blog_grid_style',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Grid Style', 'total' ),
				'type' => 'select',
				'active_callback' => 'wpex_cac_grid_blog_style',
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'fit-rows' => esc_html__( 'Fit Rows', 'total' ),
					'masonry' => esc_html__( 'Masonry', 'total' ),
				),
			),
		),
		array(
			'id' => 'blog_grid_columns',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Grid Columns', 'total' ),
				'type' => 'select',
				'active_callback' => 'wpex_cac_grid_blog_style',
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			),
		),
		array(
			'id' => 'blog_grid_gap',
			'control' => array(
				'label' => esc_html__( 'Gap', 'total' ),
				'type' => 'select',
				'choices' => wpex_column_gaps(),
				'active_callback' => 'wpex_cac_grid_blog_style',
			),
		),
		array(
			'id' => 'blog_archive_grid_equal_heights',
			'control' => array(
				'label' => esc_html__( 'Equal Heights', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_blog_supports_equal_heights',
			),
		),
		array(
			'id' => 'blog_pagination_style',
			'default' => '',
			'control' => array(
				'label' => esc_html__( 'Pagination Style', 'total' ),
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'total' ),
					'standard' => esc_html__( 'Standard', 'total' ),
					'infinite_scroll' => esc_html__( 'Infinite Scroll', 'total' ),
					'next_prev' => esc_html__( 'Next/Prev', 'total' )
				),
			),
		),
		array(
			'id' => 'blog_entry_overlay',
			'control' => array(
				'label' => esc_html__( 'Image Overlay', 'total' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array(),
				'active_callback' => 'wpex_cac_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_entry_image_hover_animation',
			'control' => array(
				'label' => esc_html__( 'Image Hover Animation', 'total' ),
				'type' => 'select',
				'choices' => wpex_image_hovers(),
				'active_callback' => 'wpex_cac_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_exceprt',
			'default' => 'on',
			'control' => array(
				'label' => esc_html__( 'Auto Excerpts', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_has_blog_entry_excerpt',
			),
		),
		array(
			'id' => 'blog_excerpt_length',
			'default' => '40',
			'control' => array(
				'label' => esc_html__( 'Excerpt length', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_blog_entry_excerpt',
			),
		),
		array(
			'id' => 'blog_entry_readmore_text',
			'default' => esc_html__( 'Read More', 'total' ),
			'control' => array(
				'label' => esc_html__( 'Read More Button Text', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_blog_entry_readmore',
			),
		),
		array(
			'id' => 'blog_entry_image_lightbox',
			'control' => array(
				'label' => esc_html__( 'Image Lightbox', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_has_blog_entry_media',
			),
		),
		array(
			'id' => 'blog_entry_author_avatar',
			'control' => array(
				'label' => esc_html__( 'Author Avatar', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_entry_video_output',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Display Featured Videos?', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_entry_gallery_output',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Display Gallery Slider?', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_entry_meta_sections',
			'default' => $entry_meta_defaults,
			'control' => array(
				'label' => esc_html__( 'Meta', 'total' ),
				'type' => 'multiple-select',
				'object' => 'WPEX_Customize_Multicheck_Control',
				'choices' => $entry_meta_choices,
				'active_callback' => 'wpex_cac_has_blog_entry_meta',
			),
		),
		array(
			'id' => 'blog_entry_composer',
			'default' => 'featured_media,title,meta,excerpt_content,readmore',
			'control' => array(
				'label' => esc_html__( 'Entry Layout Elements', 'total' ),
				'type' => 'wpex-sortable',
				'object' => 'WPEX_Customize_Control_Sorter',
				'choices' => $entry_blocks,
				'desc' => esc_html__( 'Click and drag and drop elements to re-order them.', 'total' ),
			),
		),
	),
);

// Single
$this->sections['wpex_blog_single'] = array(
	'title' => esc_html__( 'Single', 'total' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'blog_single_layout',
			'default' => 'right-sidebar',
			'control' => array(
				'label' => esc_html__( 'Layout', 'total' ),
				'type' => 'select',
				'choices' => $post_layouts,
			),
		),
		array(
			'id' => 'blog_single_header',
			'default' => 'custom_text',
			'control' => array(
				'label' => esc_html__( 'Header Displays', 'total' ),
				'type' => 'select',
				'choices' => array(
					'custom_text' => esc_html__( 'Custom Text','total' ),
					'post_title' => esc_html__( 'Post Title','total' ),
					'first_category' => esc_html__( 'First Category','total' ),
				),
			),
		),
		array(
			'id' => 'blog_single_header_custom_text',
			'transport' => 'postMessage',
			'default' => esc_html__( 'Blog', 'total' ),
			'control' => array(
				'label' => esc_html__( 'Header Custom Text', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_blog_page_header_custom_text',
			),
		),
		array(
			'id' => 'blog_post_image_lightbox',
			'control' => array(
				'label' => esc_html__( 'Featured Image Lightbox', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_has_blog_single_media',
			),
		),
		array(
			'id' => 'blog_thumbnail_caption',
			'control' => array(
				'label' => esc_html__( 'Featured Image Caption', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_has_blog_single_media',
			),
		),
		array(
			'id' => 'blog_next_prev',
			'default' => true,
			'control' => array(
				'label' => esc_html__( 'Next & Previous Links', 'total' ),
				'type' => 'checkbox',
			),
		),
		array(
			'id' => 'blog_post_meta_sections',
			'default' => $entry_meta_defaults,
			'control' => array(
				'label' => esc_html__( 'Meta', 'total' ),
				'type' => 'multiple-select',
				'object' => 'WPEX_Customize_Multicheck_Control',
				'choices' => $entry_meta_choices,
				'active_callback' => 'wpex_cac_has_blog_meta',
			),
		),
		array(
			'id' => 'blog_related_title',
			'transport' => 'postMessage',
			'control' => array(
				'label' => esc_html__( 'Related Posts Title', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_count',
			'default' => '3',
			'control' => array(
				'label' => esc_html__( 'Related Posts Count', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_columns',
			'default' => '3',
			'control' => array(
				'label' => esc_html__( 'Related Posts Columns', 'total' ),
				'type' => 'select',
				'active_callback' => 'wpex_cac_has_blog_related',
				'choices' => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
			),
		),
		array(
			'id' => 'blog_related_overlay',
			'control' => array(
				'label' => esc_html__( 'Related Posts Image Overlay', 'total' ),
				'type' => 'select',
				'choices' => wpex_overlay_styles_array(),
				'active_callback' => 'wpex_cac_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_excerpt',
			'default' => 'on',
			'control' => array(
				'label' => esc_html__( 'Related Posts Excerpt', 'total' ),
				'type' => 'checkbox',
				'active_callback' => 'wpex_cac_has_blog_related',
			),
		),
		array(
			'id' => 'blog_related_excerpt_length',
			'default' => '15',
			'control' => array(
				'label' => esc_html__( 'Related Posts Excerpt Length', 'total' ),
				'type' => 'text',
				'active_callback' => 'wpex_cac_has_blog_related',
			),
		),
		array(
			'id' => 'blog_single_composer',
			'default' => 'featured_media,title,meta,post_series,the_content,post_tags,social_share,author_bio,related_posts,comments',
			'control' => array(
				'label' => esc_html__( 'Single Layout Elements', 'total' ),
				'type' => 'wpex-sortable',
				'object' => 'WPEX_Customize_Control_Sorter',
				'choices' => $single_blocks,
				'desc' => esc_html__( 'Click and drag and drop elements to re-order them.', 'total' ),
			),
		),
	),
);

// Author Box
$this->sections['wpex_author_box'] = array(
	'title' => esc_html__( 'Author Box', 'total' ),
	'panel' => 'wpex_blog',
	'settings' => array(
		array(
			'id' => 'author_box_bg',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Background', 'total' ),
			),
			'inline_css' => array(
				'target' => '.author-bio',
				'alter' => 'background-color',
			),
		),
		array(
			'id' => 'author_box_margin',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Margin', 'total' ),
				'desc' => $margin_desc,
			),
			'inline_css' => array(
				'target' => '.author-bio',
				'alter' => 'margin',
			),
		),
		array(
			'id' => 'author_box_border_color',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'color',
				'label' => esc_html__( 'Border Color', 'total' ),
			),
			'inline_css' => array(
				'target' => '.author-bio',
				'alter' => 'border-color',
			),
		),
		array(
			'id' => 'author_box_border_width',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Border Width', 'total' ),
			),
			'inline_css' => array(
				'target' => '.author-bio',
				'alter' => 'border-width',
			),
		),
		array(
			'id' => 'author_box_social_style',
			//'transport' => 'partialRefresh',
			'default' => 'flat-color-round',
			'control' => array(
				'label' => esc_html__( 'Social Style', 'total' ),
				'type' => 'select',
				'choices' => $social_styles,
			),
		),
		array(
			'id' => 'author_box_social_font_size',
			'transport' => 'postMessage',
			'control' => array(
				'type' => 'text',
				'label' => esc_html__( 'Social Font Size', 'total' ),
				'desc' => $pixel_desc,
			),
			'inline_css' => array(
				'target' => '.author-bio-social .wpex-social-btn',
				'alter' => 'font-size',
			),
		),
	)
);