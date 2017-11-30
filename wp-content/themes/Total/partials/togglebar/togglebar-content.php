<?php
/**
 * Togglebar content output
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Display content if defined
if ( $content = get_post_field( 'post_content', wpex_global_obj( 'toggle_bar_content_id' ) ) ) : ?>

	<div class="entry wpex-clr">
		<?php echo do_shortcode( wp_kses_post( $content ) ); ?>		
	</div><!-- .entry -->

<?php endif; ?>