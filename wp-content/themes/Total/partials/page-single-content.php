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

<div class="entry clr"><?php

	// Page content
	the_content();
	
	// Page links (for the <!-nextpage-> tag)
	get_template_part( 'partials/link-pages' );

?></div>