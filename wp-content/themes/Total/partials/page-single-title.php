<?php
/**
 * Page Content
 *
 * @package Total WordPress theme
 * @subpackage Partials
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<header class="single-page-header<?php if ( 'full-screen' == wpex_global_obj( 'post_layout' ) ) echo ' container'; ?>"><h1 class="single-page-title entry-title"<?php wpex_schema_markup( 'heading' ); ?>><?php the_title(); ?></h1></header>