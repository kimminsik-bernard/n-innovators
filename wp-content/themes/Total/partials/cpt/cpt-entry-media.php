<?php
/**
 * Custom Post Type Entry Media
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 *
 * @todo Add support for post featured video ? No one has requested it yet.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get post type
$type = get_post_type();

// Check for a video
$video = wpex_get_post_video();

// Thumbnail args
$thumb_args = apply_filters( 'wpex_'. $type .'_entry_thumbnail_args', array(
	'size'          => $type .'_archive',
	'alt'           => wpex_get_esc_title(),
	'schema_markup' => true
), $type );

// Get thumbnail
$thumbnail = wpex_get_post_thumbnail( $thumb_args );

// Display featured image
if ( $thumbnail || $video ) :

	// Get overlay style
	if ( ! $video ) {
		$overlay = apply_filters( 'wpex_'. $type .'_entry_overlay_style', null );
		$overlay = $overlay ? $overlay : 'none';
	} ?>

	<div class="cpt-entry-media entry-media clr <?php echo wpex_overlay_classes( $overlay ); ?>">

		<?php
		// Display video
		if ( $video ) : ?>

			<?php wpex_post_video_html( $video ); ?>

		<?php
		// Display thumbnail
		else : ?>

		<a href="<?php wpex_permalink(); ?>" title="<?php wpex_esc_title(); ?>" rel="bookmark" class="cpt-entry-media-link <?php wpex_entry_image_animation_classes(); ?>">
			<?php echo $thumbnail; ?>
			<?php wpex_overlay( 'inside_link', $overlay ); ?>
		</a>

		<?php wpex_overlay( 'outside_link', $overlay ); ?>

		<?php endif; ?>

	</div>

<?php endif; ?>