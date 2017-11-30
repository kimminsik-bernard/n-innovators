<?php
/**
 * Main Theme Panel
 *
 * @package Total WordPress theme
 * @subpackage Framework
 * @version 3.6.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Theme_Panel' ) ) {
	class WPEX_Theme_Panel {

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {

			// Add panel menu
			add_action( 'admin_menu', array( 'WPEX_Theme_Panel', 'add_menu_page' ), 0 );

			// Add panel submenu
			add_action( 'admin_menu', array( 'WPEX_Theme_Panel', 'add_menu_subpage' ) );

			// Add custom CSS for the theme panel
			add_action( 'admin_enqueue_scripts', array( 'WPEX_Theme_Panel', 'scripts' ) );

			// Register panel settings
			add_action( 'admin_init', array( 'WPEX_Theme_Panel', 'register_settings' ) );

			// Load addon files
			self::load_addons();

		}

		/**
		 * Return theme addons
		 * Can't be added in construct because translations won't work
		 *
		 * @since 3.3.3
		 */
		private static function get_addons() {
			$addons = array(
				'demo_importer' => array(
					'label'    => esc_html__( 'Demo Importer', 'total' ),
					'icon'     => 'dashicons dashicons-download',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'under_construction' => array(
					'label'    => esc_html__( 'Under Construction', 'total' ),
					'icon'     => 'dashicons dashicons-hammer',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'recommend_plugins' => array(
					'label'    => esc_html__( 'Recommend Plugins', 'total' ),
					'icon'     => 'dashicons dashicons-admin-plugins',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'schema_markup' => array(
					'label'     => esc_html__( 'Schema Markup', 'total' ),
					'icon'      => 'dashicons dashicons-feedback',
					'category'  => esc_html__( 'SEO', 'total' ),
				),
				'minify_js' => array(
					'label'    => esc_html__( 'Minify Javascript', 'total' ),
					'icon'     => 'dashicons dashicons-performance',
					'category' => esc_html__( 'Optimizations', 'total' ),
				),
				'custom_css' => array(
					'label'    => esc_html__( 'Custom CSS', 'total' ),
					'icon'     => 'dashicons dashicons-admin-appearance',
					'category' => esc_html__( 'Developers', 'total' ),
				),
				'custom_actions' => array(
					'label'    => esc_html__( 'Custom Actions', 'total' ),
					'icon'     => 'dashicons dashicons-editor-code',
					'category' => esc_html__( 'Developers', 'total' ),
				),
				'favicons' => array(
					'label'    => esc_html__( 'Favicons', 'total' ),
					'icon'     => 'dashicons dashicons-nametag',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'portfolio' => array(
					'label'    => wpex_get_portfolio_name(),
					'icon'     => 'dashicons dashicons-'. wpex_get_portfolio_menu_icon(),
					'category' => esc_html__( 'Post Types', 'total' ),
				),
				'staff' => array(
					'label'    => wpex_get_staff_name(),
					'icon'     => 'dashicons dashicons-'. wpex_get_staff_menu_icon(),
					'category' => esc_html__( 'Post Types', 'total' ),
				),
				'testimonials' => array(
					'label'    => wpex_get_testimonials_name(),
					'icon'     => 'dashicons dashicons-'. wpex_get_testimonials_menu_icon(),
					'category' => esc_html__( 'Post Types', 'total' ),
				),
				'post_series' => array(
					'label'    => esc_html__( 'Post Series', 'total' ),
					'icon'     => 'dashicons dashicons-edit',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'header_builder' => array(
					'label'    => esc_html__( 'Header Builder', 'total' ),
					'icon'     => 'dashicons dashicons-editor-insertmore',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'footer_builder' => array(
					'label'    => esc_html__( 'Footer Builder', 'total' ),
					'icon'     => 'dashicons dashicons-editor-insertmore',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'custom_admin_login'  => array(
					'label'    => esc_html__( 'Custom Login Page', 'total' ),
					'icon'     => 'dashicons dashicons-lock',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'custom_404' => array(
					'label'    => esc_html__( 'Custom 404 Page', 'total' ),
					'icon'     => 'dashicons dashicons-dismiss',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'customizer_panel' => array(
					'label'    => esc_html__( 'Customizer Manager', 'total' ),
					'icon'     => 'dashicons dashicons-admin-settings',
					'category' => esc_html__( 'Optimizations', 'total' ),
				),
				'custom_wp_gallery' => array(
					'label'    => esc_html__( 'Custom WordPress Gallery', 'total' ),
					'icon'     => 'dashicons dashicons-images-alt2',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'widget_areas' => array(
					'label'    => esc_html__( 'Widget Areas', 'total' ),
					'icon'     => 'dashicons dashicons-welcome-widgets-menus',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'custom_widgets' => array(
					'label'    => esc_html__( 'Custom Widgets', 'total' ),
					'icon'     => 'dashicons dashicons-list-view',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'term_thumbnails' => array(
					'label'    => esc_html__( 'Category Thumbnails', 'total' ),
					'icon'     => 'dashicons dashicons-format-image',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'editor_formats' => array(
					'label'    => esc_html__( 'Editor Formats', 'total' ),
					'icon'     => 'dashicons dashicons-editor-paste-word',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'editor_shortcodes' => array(
					'label'    => esc_html__( 'Editor Shortcodes', 'total' ),
					'icon'     => 'dashicons dashicons-editor-paste-word',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'remove_emoji_scripts' => array(
					'label'    => esc_html__( 'Remove Emoji Scripts', 'total' ),
					'icon'     => 'dashicons dashicons-smiley',
					'category' => esc_html__( 'Optimizations', 'total' ),
				),
				'image_sizes' => array(
					'label'    => esc_html__( 'Image Sizes', 'total' ),
					'icon'     => 'dashicons dashicons-image-crop',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'page_animations' => array(
					'label'    => esc_html__( 'Page Animations', 'total' ),
					'icon'     => 'dashicons dashicons-welcome-view-site',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'typography' => array(
					'label'    => esc_html__( 'Typography Options', 'total' ),
					'icon'     => 'dashicons dashicons-editor-bold',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'edit_post_link' => array(
					'label'    => esc_html__( 'Post Edit Links', 'total' ),
					'icon'     => 'dashicons dashicons-admin-tools',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'header_image' => array(
					'label'    => esc_html__( 'Header Image', 'total' ),
					'disabled' => true,
					'icon'     => 'dashicons dashicons-format-image',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'import_export' => array(
					'label'    => esc_html__( 'Import/Export Panel', 'total' ),
					'icon'     => 'dashicons dashicons-admin-settings',
					'category' => esc_html__( 'Core', 'total' ),
				),
				'visual_composer_theme_mode' => array(
					'label'     =>  esc_html__( 'Visual Composer Theme Mode', 'total' ),
					'icon'      => 'dashicons dashicons-admin-customizer',
					'custom_id' => true,
					'condition' => WPEX_VC_ACTIVE,
					'category'  => esc_html__( 'Visual Composer', 'total' ),
				),
				'extend_visual_composer' => array(
					'label'     => WPEX_THEME_BRANDING .' '. esc_html__( 'Visual Composer Modules', 'total' ),
					'icon'      => 'dashicons dashicons-admin-customizer',
					'custom_id' => true,
					'condition' => WPEX_VC_ACTIVE,
					'category'  => esc_html__( 'Visual Composer', 'total' ),
				),
				'disable_gs' => array(
					'disabled'  => true,
					'label'     => esc_html__( 'Remove Google Fonts', 'total' ),
					'custom_id' => true,
					'icon'      => 'dashicons dashicons-thumbs-down',
					'category'  => esc_html__( 'Optimizations', 'total' ),
				),
				'remove_posttype_slugs' => array(
					'disabled'  => true,
					'label'     => esc_html__( 'Remove Post Type Slugs', 'total' ),
					'desc'      => esc_html__( 'Removes the slug from built-in custom post types. Slugs are important to prevent conflicts so use with caution (not recommented in most cases).', 'total' ),
					'custom_id' => true,
					'icon'      => 'dashicons dashicons-art',
					'category'  => esc_html__( 'Post Types', 'total' ),
				),
			);

			// Add custom js only if setting not empty
			if ( wpex_get_mod ( 'custom_js', null ) ) {
				$addons['custom_js'] = array(
					'label'    => esc_html__( 'Custom JS', 'total' ),
					'icon'     => 'dashicons dashicons-media-code',
					'category' => esc_html__( 'Developers', 'total' ),
					'disabled' => true,
				);
			}

			// Apply filters and return
			return apply_filters( 'wpex_theme_addons', $addons );

		}

		/**
		 * Registers a new menu page
		 *
		 * @since 1.6.0
		 */
		public static function add_menu_page() {
		  add_menu_page(
				esc_html__( 'Theme Panel', 'total' ),
				'Theme Panel', // menu title - can't be translated because it' used for the $hook prefix
				'manage_options',
				WPEX_THEME_PANEL_SLUG,
				'',
				'dashicons-admin-generic',
				null
			);
		}

		/**
		 * Registers a new submenu page
		 *
		 * @since 1.6.0
		 */
		public static function add_menu_subpage(){
			add_submenu_page(
				'wpex-general',
				esc_html__( 'General', 'total' ),
				esc_html__( 'General', 'total' ),
				'manage_options',
				WPEX_THEME_PANEL_SLUG,
				array( 'WPEX_Theme_Panel', 'create_admin_page' )
			);
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.6.0
		 */
		public static function register_settings() {
			register_setting( 'wpex_tweaks', 'wpex_tweaks', array( 'WPEX_Theme_Panel', 'admin_sanitize' ) ); 
		}

		/**
		 * Main Sanitization callback
		 *
		 * @since 1.6.0
		 */
		public static function admin_sanitize( $options ) {

			// Check options first
			if ( ! is_array( $options ) || empty( $options ) || ( false === $options ) ) {
				return array();
			}

			// Get addons array
			$theme_addons = self::get_addons();

			// Save checkboxes
			$checkboxes = array();

			// Add theme parts to checkboxes
			foreach ( $theme_addons as $key => $val ) {

				// Get correct ID
				$id = isset( $val['custom_id'] ) ? $key : $key .'_enable';

				// No need to save items that are enabled by default unless they have been disabled
				$default = isset ( $val['disabled'] ) ? false : true;

				// If default is true
				if ( $default ) {
					if ( ! isset( $options[$id] ) ) {
						set_theme_mod( $id, 0 ); // Disable option that is enabled by default
					} else {
						remove_theme_mod( $id ); // Make sure its not in the theme_mods since it's already enabled
					}
				}

				// If default is false
				elseif ( ! $default ) {
					if ( isset( $options[$id] ) ) {
						set_theme_mod( $id, 1 ); // Enable option that is disabled by default
					} else {
						remove_theme_mod( $id ); // Remove theme mod because it's disabled by default
					}
				}


			}

			// Remove thememods for checkboxes not in array
			foreach ( $checkboxes as $checkbox ) {
				if ( isset( $options[$checkbox] ) ) {
					set_theme_mod( $checkbox, 1 );
				} else {
					set_theme_mod( $checkbox, 0 );
				}
			}

			// Save Branding
			$value = $options['theme_branding'];
			if ( empty( $value ) ) {
				set_theme_mod( 'theme_branding', 'disabled' );
			} else {
				set_theme_mod( 'theme_branding', strip_tags( $value ) );
			}

			// No need to save in options table
			$options = '';
			return $options;

		}

		/**
		 * Settings page output
		 *
		 * @since 1.6.0
		 */
		public static function create_admin_page() {

			// Delete option that isn't needed
			delete_option( 'wpex_tweaks' );

			// Get theme addons array
			$theme_addons = self::get_addons(); ?>

			<div class="wrap wpex-theme-panel wpex-clr">

				<h1><?php esc_attr_e( 'Theme Panel', 'total' ); ?></h1>

				<h2 class="nav-tab-wrapper">
					<a href="#" class="nav-tab nav-tab-active"><span class="fa fa-cogs"></span><?php esc_attr_e( 'Features', 'total' ); ?></a>
					<?php if ( wpex_get_mod( 'demo_importer_enable', true ) ) { ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=wpex-panel-demo-importer' ) ); ?>" class="nav-tab"><span class="fa fa-download"></span><?php esc_attr_e( 'Demo Import', 'total' ); ?></a>
					<?php } ?>
					<?php
					// Customizer url
					$customize_url = add_query_arg(
						array(
							'return' => urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ),
						),
						'customize.php'
					); ?>
					<a href="<?php echo esc_url( $customize_url ); ?>" class="nav-tab"><span class="fa fa-paint-brush"></span><?php esc_attr_e( 'Customize', 'total' ); ?></a>
				</h2>

				<div id="wpex-theme-panel-content" class="wpex-clr">

					<div class="wpex-theme-panel-updated updated" style="border-color: #f0821e;display:none;">
						<p>
							<?php echo wpex_sanitize_data( __( 'Don\'t forget to <a href="#">save your changes</a>', 'total' ), 'html' ); ?>
						</p>
					</div>

					<form id="wpex-theme-panel-form" method="post" action="options.php">

						<?php settings_fields( 'wpex_tweaks' ); ?>

						<div class="manage-right">

							<!-- Branding -->
							<h4><?php esc_attr_e( 'Theme Branding', 'total' ); ?></h4>
							<?php
							// Get theme branding value
							$value = wpex_get_mod( 'theme_branding', 'Total' );
							$value = ( 'disabled' == $value || ! $value ) ? '' : $value; ?>
							<input type="text" name="wpex_tweaks[theme_branding]" value="<?php echo esc_attr( $value ); ?>" placeholder="<?php esc_attr_e( 'Used in widgets and builder blocks...', 'total' ); ?>">

							<!-- View -->
							<h4><?php esc_attr_e( 'View', 'total' ); ?></h4>
							<div class="button-group wpex-filter-active">
								<button type="button" class="button active"><?php esc_attr_e( 'All', 'total' ); ?></button>
								<button type="button" class="button" data-filter-by="active"><?php esc_attr_e( 'Active', 'total' ); ?></button>
								<button type="button" class="button" data-filter-by="inactive"><?php esc_attr_e( 'Inactive', 'total' ); ?></button>
							</div>

							<!-- Sort -->
							<h4><?php esc_attr_e( 'Sort', 'total' ); ?></h4>
							<?php
							// Categories
							$categories = wp_list_pluck( $theme_addons, 'category' );
							$categories = array_unique( $categories );
							asort( $categories ); ?>
							<ul class="wpex-theme-panel-sort">
								<li><a href="#" data-category="all" class="wpex-active-category"><?php esc_attr_e( 'All', 'total' ); ?></a></li>
								<?php
								// Loop through cats
								foreach ( $categories as $key => $category ) :

									// Check condition
									$display = true;
									if ( isset( $theme_addons[$key]['condition'] ) ) {
										$display = $theme_addons[$key]['condition'];
									}

									// Show cat
									if ( $display ) {
										$sanitize_category = strtolower( str_replace( ' ', '_', $category ) ); ?>
										<li><a href="#" data-category="<?php echo esc_attr( $sanitize_category ); ?>" title="<?php echo esc_attr( $category ); ?>"><?php echo strip_tags( $category ); ?></a></li>
									<?php } ?>

								<?php endforeach; ?>
							</ul>

						</div><!-- manage-right -->

						<div class="manage-left">

							<table class="table table-bordered wp-list-table widefat fixed wpex-modules">

								<tbody id="the-list">

									<?php
									$count = 0;
									// Loop through theme addons and add checkboxes
									foreach ( $theme_addons as $key => $val ) :
										$count++;

										// Display setting?
										$display = true;
										if ( isset( $val['condition'] ) ) {
											$display = $val['condition'];
										}

										// Sanitize vars
										$default = isset ( $val['disabled'] ) ? false : true;
										$label   = isset ( $val['label'] ) ? $val['label'] : '';
										$icon    = isset ( $val['icon'] ) ? $val['icon'] : '';

										// Label
										if ( $icon ) {
											$label = '<i class="'. $icon .'"></i>'. $label;
										}

										// Set id
										if ( isset( $val['custom_id'] ) ) {
											$key = $key;
										} else {
											$key = $key .'_enable';
										}

										// Get theme option
										$theme_mod = wpex_get_mod( $key, $default );

										// Get category and sanitize
										$category = isset( $val['category'] ) ? $val['category'] : ' other';
										$category = strtolower( str_replace( ' ', '_', $category ) );

										// Sanitize category
										$category = strtolower( str_replace( ' ', '_', $category ) );

										// Classes
										$classes = 'wpex-module';
										$classes .= $theme_mod ? ' wpex-active' : ' wpex-disabled';
										$classes .= ! $display ? ' wpex-hidden' : '';
										$classes .= ' wpex-category-'. $category;
										if ( $count = 2 ) {
											$classes .= ' alternative';
											$count = 0;
										} ?>

										<tr id="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $classes ); ?>">

											<th scope="row" class="check-column">
												<input type="checkbox" name="wpex_tweaks[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( $theme_mod ); ?>" <?php checked( $theme_mod, true ); ?> class="wpex-checkbox">
											</th>

											<td class="name column-name">
												<span class="info"><a href="#<?php echo esc_attr( $key ); ?>" class="wpex-theme-panel-module-link"><?php echo wpex_sanitize_data( $label, 'html' ); ?></a></span>
												<?php if ( isset( $val['desc'] ) ) { ?>
													<div class="wpex-module-description">
														<small><?php echo wpex_sanitize_data( $val['desc'], 'html' ); ?></small>
													</div>
												<?php } ?>
											</td>

										</tr>

									<?php endforeach; ?>

								</tbody>

							</table>

							<?php submit_button(); ?>

						</div><!-- .manage-left -->

					</form>

					</div><!-- #wpex-theme-panel-content -->

			</div>

		<?php
		}

		/**
		 * Load Theme Panel Scripts
		 *
		 * @since 3.6.0
		 */
		public static function scripts( $hook ) {
			if ( $hook != 'toplevel_page_wpex-panel' ) {
				return;
			}
			wp_enqueue_style( 'font-awesome', wpex_asset_url( 'lib/font-awesome/css/font-awesome.min.css' ), array(), '4.6.3' );
			wp_enqueue_style( 'wpex-theme-panel', WPEX_FRAMEWORK_DIR_URI .'addons/assets/theme-panel.css' );
			wp_enqueue_script( 'wpex-theme-panel', WPEX_FRAMEWORK_DIR_URI .'addons/assets/theme-panel.js', array( 'jquery' ), WPEX_THEME_VERSION, true );
		}

		/**
		 * Include addons
		 *
		 * @since 1.6.0
		 */
		private static function load_addons() {

			// Addons directory location
			$dir = WPEX_FRAMEWORK_DIR .'addons/';

			// Demo importer
			if ( wpex_get_mod( 'demo_importer_enable', true ) ) {
				require_once( $dir .'/demo-importer/demo-importer.php' );
			}

			// Typography
			if ( wpex_get_mod( 'typography_enable', true ) ) {
				require_once( $dir .'typography.php' );
			}

			// Under Construction
			if ( wpex_get_mod( 'under_construction_enable', true ) ) {
				require_once( $dir .'under-construction.php' );
			}

			// Custom Favicons
			if ( wpex_get_mod( 'favicons_enable', true ) ) {
				require_once( $dir .'favicons.php' );
			}

			// Custom 404
			if ( wpex_get_mod( 'custom_404_enable', true ) ) {
				require_once( $dir .'custom-404.php' );
			}

			// Custom widget areas
			if ( wpex_get_mod( 'widget_areas_enable', true ) ) {
				require_once( $dir .'widget-areas.php' );
			}

			// Custom Login
			if ( wpex_get_mod( 'custom_admin_login_enable', true ) ) {
				require_once( $dir .'custom-login.php' );
			}

			// Header builder
			if ( wpex_get_mod( 'header_builder_enable', true ) ) {
				require_once( $dir .'header-builder.php' );
			}

			// Footer builder
			if ( wpex_get_mod( 'footer_builder_enable', true ) ) {
				require_once( $dir .'footer-builder.php' );
			}

			// Custom WordPress gallery output
			if ( apply_filters( 'wpex_custom_wp_gallery', wpex_get_mod( 'custom_wp_gallery_enable', true ) ) ) {
				require_once( $dir .'wp-gallery.php' );
			}

			// Custom CSS
			if ( wpex_get_mod( 'custom_css_enable', true ) ) {
				require_once( $dir .'custom-css.php' );
			}

			// Custom JS / Only if not empty this - this is deprecated
				//Removed completely in Total 3.6.0
				//require_once( $dir .'custom-js.php' );
			//

			// User Actions
			if ( wpex_get_mod( 'custom_actions_enable', true ) ) {
				require_once( $dir .'custom-actions.php' );
			}

			// Page animations
			if ( wpex_get_mod( 'page_animations_enable', true ) ) {
				require_once( $dir .'page-animations.php' );
			}

			// Skins (deprecated since 3.0.0)
			require_once( WPEX_THEME_DIR .'/skins/skins.php' );

			/*** ADMIN ONLY ADDONS ***/
			if ( is_admin() ) {

				// Import Export Functions
				if ( wpex_get_mod( 'import_export_enable', true ) ) {
					require_once( $dir .'import-export.php' );
				}

				// Editor formats
				if ( wpex_get_mod( 'editor_formats_enable', true ) ) {
					require_once( $dir .'editor-formats.php' );
				}

			} // End is_admin()

		}

	}
}
new WPEX_Theme_Panel();