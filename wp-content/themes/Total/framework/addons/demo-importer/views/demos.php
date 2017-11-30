<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap wpex-demo-import-wrap">

	<h1><?php esc_html_e( 'Demo Importer', 'total' ); ?></h1>
	
	<div class="wpex-demos-filter">
		<ul class="wpex-demos-categories">
			<?php
			// Loop through categories
			if ( ! empty( $this->categories ) && is_array( $this->categories ) ) {
				echo '<li value="all" class="wpex-all-cat wpex-selected-category">'. esc_html__( 'All', 'total' ) .'</li>';

				// Add the 'other' category at the end of the array
				if ( isset( $this->categories[ 'other' ] ) ) {
					$value = $this->categories[ 'other' ];
					unset( $this->categories[ 'other' ] );
					$this->categories[ 'other' ] = $value;
				}

				// Loop through categories and display them at the top
				foreach ( $this->categories as $category_key => $category_value ) {
					echo '<li value="'. esc_attr( $category_key ) . '">' . esc_html( $category_value ) . '</li>';
				}
			} ?>
		</ul>

		<input name="demo-search-box" class="wpex-demos-search-box" type="text" placeholder="<?php esc_attr_e( 'Search demos...', 'total' ); ?>"></input>
	</div>

	<div class="wpex-demos-select theme-browser wpex-clr">

		<?php
		if ( ! empty( $this->demos ) && is_array( $this->demos ) ) {

			// Loop through demos
			foreach ( $this->demos as $demo_key => $demo_data ) {
				$categories = '';

				// Store the demo's categories in a data attribute
				if ( isset( $demo_data['categories'] ) ) {
					foreach ( $demo_data['categories'] as $category_key => $category_value ) {
						$categories .= $categories === '' ? $category_value : ', ' . $category_value ;
					}
				}
			?>
				<div class="wpex-demo theme wpex-clr" data-demo="<?php echo esc_attr( $demo_data['demo_slug'] ); ?>" data-categories="<?php echo esc_attr( $categories ); ?>">
					
					<div class="theme-screenshot">
						<img class="wpex-lazyload" data-original="<?php echo esc_url( $demo_data['screenshot'] ); ?>" alt="<?php _e( 'Screenshot', 'total' ); ?>" />
						<span class="spinner wpex-demo-spinner"></span>
					</div>

					<h3 class="theme-name">
						<span class="wpex-demo-name"><?php echo esc_html( $demo_data['name'] ); ?></span>
						<div class="theme-actions">
							<a href="http://totaltheme.wpengine.com/<?php echo esc_attr( $demo_data['demo_slug'] ); ?>/" class="button button-primary" target="_blank"><?php _e( 'Live Preview', 'total' ); ?></a>
						</div>
					</h3>

				</div>
			
			<?php } ?>

		<?php } ?>

	</div>

	<div class="wpex-submit-popup-wrap">
		<div class="wpex-submit-popup wpex-clr">
			<div class="wpex-submit-popup-content wpex-clr"></div>
		</div>
	</div>

</div><!-- .wrap -->