<?php
/**
 * Single Custom Post Type Media
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check for video
if ( $video = wpex_get_post_video() ) : ?>

	<div id="post-media" class="wpex-clr"><?php wpex_post_video_html( $video ); ?></div>

<?php
// Audio
elseif ( $audio = wpex_get_post_audio() ) : ?>

	<div id="post-media" class="wpex-clr"><?php wpex_post_audio_html( $audio ); ?></div>

<?php
// Gallery images
elseif ( wpex_post_has_gallery() ) :

	get_template_part( 'partials/cpt/cpt-single-gallery' );

// Thumbnail
else :

	// Get post type
	$type = get_post_type();

	// Thumbnail args
	$args = apply_filters( 'wpex_'. $type .'_single_thumbnail_args', array(
		'size'          => $type .'_single',
		'alt'           => wpex_get_esc_title(),
		'schema_markup' => true
	), $type );

	// Get thumbnail
	$thumbnail = wpex_get_post_thumbnail( $args );

	// Display featured image
	if ( $thumbnail ) : ?>

		<div id="post-media" class="wpex-clr"><?php echo $thumbnail; // Already sanitized ?></div>

	<?php endif; ?>

<?php endif; ?>