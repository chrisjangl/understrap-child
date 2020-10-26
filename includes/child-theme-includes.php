<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Includes
 *
 * turn on/off different includes files, depending on needs and parent theme
 *
 * @version  1.0
 * @package  Child theme
 * @subpackage  Includes
 * @author   Digitally Cultured
 * 
 */

    // analytics
    // include( "./functions-analytics.php" );

	// holds function definitions for common developer needs
	// include("functions-developer.php"); 
    
    // adding NAP etc to theme options (Responsive parent theme)
	// include("functions-theme-options.php");
	
	// templating functions
	include("functions-theme-functions.php"); 

	// register navigation
	// include("functions-navigation.php");
	
	// blog functionality
	include("functions-blog.php");

	// metaboxes for pages, posts & custom post types
	// include("functions-metaboxes.php");
    
    // edits to WP Admin Customizer
	// include("./functions-customizer.php"); 

	// custom functionality to allow for category images
	// include("functions-category-images.php");
    
	// WooCommerce
	// if ( is_woocomerce_active() )
	// include("functions-woocommerce.php"); 

	// extra meta fields for product category
	// include("functions-woocommerce-category-extras.php");
    
    // custom widgets
	// include("functions-widgets.php"); 
    
    // widget areas & sidebars
	// include("functions-widget-areas.php"); 

	// editor shortcodes
	// include( "functions-shortcodes.php" );
	
	add_action('wp_update_nav_menu_item', 'custom_nav_update',10, 3);
	function custom_nav_update($menu_id, $menu_item_db_id, $args ) {
		if ( is_array($_REQUEST['menu-item-custom']) ) {
			$custom_value = $_REQUEST['menu-item-custom'][$menu_item_db_id];
			update_post_meta( $menu_item_db_id, '_menu_item_custom', $custom_value );
		}
	}

	/*
	* Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
	*/
	add_filter( 'wp_setup_nav_menu_item','custom_nav_item' );
	function custom_nav_item($menu_item) {
		$menu_item->custom = get_post_meta( $menu_item->ID, '_menu_item_custom', true );
		return $menu_item;
	}

	add_filter( 'wp_edit_nav_menu_walker', 'custom_nav_edit_walker',10,2 );
	function custom_nav_edit_walker($walker,$menu_id) {
		return 'Walker_Nav_Menu_Edit_Custom';
	}

	/**
	 * Copied from Walker_Nav_Menu_Edit class in core
	 * 
	 * Create HTML list of nav menu input items.
	 *
	 * @package WordPress
	 * @since 3.0.0
	 * @uses Walker_Nav_Menu
	 */
	class Walker_Nav_Menu_Edit_Custom extends Walker_Nav_Menu  {
		/**
		 * @see Walker_Nav_Menu::start_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function start_lvl(&$output,$depth = 0, $args = []) {}

		/**
		 * @see Walker_Nav_Menu::end_lvl()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 */
		function end_lvl(&$output, $depth = 0, $args = []) {
		}

		/**
		 * @see Walker::start_el()
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param object $args
		 */
		function start_el(&$output, $item, $depth = 0, $args = array(), $id=0) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			ob_start();
			$item_id      = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = false;
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) ) {
					$original_title = false;
				}
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
					$original_title  = get_the_title( $original_object->ID );
				} elseif ( 'post_type_archive' == $item->type ) {
					$original_object = get_post_type_object( $item->object );
					if ( $original_object ) {
						$original_title = $original_object->labels->archives;
					}
				}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __( '%s (Pending)' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
				if ( 0 == $depth ) {
					$submenu_text = 'style="display: none;"';
				}
				
			?>
			<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode( ' ', $classes ); ?>">
				<div class="menu-item-bar">
					<div class="menu-item-handle">
						<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' ); ?></span></span>
						<span class="item-controls">
							<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
							<span class="item-order hide-if-js">
								<a href="
								<?php
									echo wp_nonce_url(
										add_query_arg(
											array(
												'action'    => 'move-up-menu-item',
												'menu-item' => $item_id,
											),
											remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
										),
										'move-menu_item'
									);
								?>
								" class="item-move-up" aria-label="<?php esc_attr_e( 'Move up' ); ?>">&#8593;</a>
								|
								<a href="
									<?php
										echo wp_nonce_url(
											add_query_arg(
												array(
													'action'    => 'move-down-menu-item',
													'menu-item' => $item_id,
												),
												remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) )
											),
											'move-menu_item'
										);
									?>
									" class="item-move-down" aria-label="<?php esc_attr_e( 'Move down' ); ?>">&#8595;</a>
							</span>
							<a class="item-edit" id="edit-<?php echo $item_id; ?>" href="
								<?php
								echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
								?>
								" aria-label="<?php esc_attr_e( 'Edit menu item' ); ?>"><span class="screen-reader-text"><?php _e( 'Edit' ); ?></span></a>
						</span>
					</div>
				</div>

				<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo $item_id; ?>">
					<?php if ( 'custom' == $item->type ) : ?>
						<p class="field-url description description-wide">
							<label for="edit-menu-item-url-<?php echo $item_id; ?>">
								<?php _e( 'URL' ); ?><br />
								<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
							</label>
						</p>
					<?php endif; ?>
					<p class="description description-wide">
						<label for="edit-menu-item-title-<?php echo $item_id; ?>">
							<?php _e( 'Navigation Label' ); ?><br />
							<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
						</label>
					</p>
					<p class="field-title-attribute field-attr-title description description-wide">
						<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
							<?php _e( 'Title Attribute' ); ?><br />
							<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
						</label>
					</p>
					<p class="field-link-target description">
						<label for="edit-menu-item-target-<?php echo $item_id; ?>">
							<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
							<?php _e( 'Open link in a new tab' ); ?>
						</label>
					</p>
					<p class="field-css-classes description description-thin">
						<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
							<?php _e( 'CSS Classes (optional)' ); ?><br />
							<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>" />
						</label>
					</p>
					<p class="field-xfn description description-thin">
						<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
							<?php _e( 'Link Relationship (XFN)' ); ?><br />
							<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
						</label>
					</p>
					<p class="field-description description description-wide">
						<label for="edit-menu-item-description-<?php echo $item_id; ?>">
							<?php _e( 'Description' ); ?><br />
							<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
							<span class="description"><?php _e( 'The description will be displayed in the menu if the current theme supports it.' ); ?></span>
						</label>
					</p>        
					<?php
					/*
					* This is the added field
					*/
					?>      
					<p class="field-custom description description-wide hidden-field">
						<label for="edit-menu-item-custom-<?php echo $item_id; ?>">
							<?php _e( 'Custom' ); ?><br />
							<input type="text" id="edit-menu-item-custom-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-custom[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->custom ); ?>" />
						</label>
					</p>
					<p class="field-css-classes description description-wide">
						Looking to add an icon to the menu item? Make sure <b>CSS Classes</b> is enabled in Screen Options  (top right corner of the page). <a href="https://fontawesome.com/icons?d=gallery/" target="_blank">Find the icon you'd like to use</a>, and enter just the class name.
					</p>
					<?php
					/*
					* end added field
					*/
					?>

					<fieldset class="field-move hide-if-no-js description description-wide">
						<span class="field-move-visual-label" aria-hidden="true"><?php _e( 'Move' ); ?></span>
						<button type="button" class="button-link menus-move menus-move-up" data-dir="up"><?php _e( 'Up one' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-down" data-dir="down"><?php _e( 'Down one' ); ?></button>
						<button type="button" class="button-link menus-move menus-move-left" data-dir="left"></button>
						<button type="button" class="button-link menus-move menus-move-right" data-dir="right"></button>
						<button type="button" class="button-link menus-move menus-move-top" data-dir="top"><?php _e( 'To the top' ); ?></button>
					</fieldset>
						
					<div class="menu-item-actions description-wide submitbox">
						<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
							<p class="link-to-original">
								<?php
								/* translators: %s: original title */
								printf( __( 'Original: %s' ), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' );
								?>
							</p>
						<?php endif; ?>
						<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="
							<?php
							echo wp_nonce_url(
								add_query_arg(
									array(
										'action'    => 'delete-menu-item',
										'menu-item' => $item_id,
									),
									admin_url( 'nav-menus.php' )
								),
								'delete-menu_item_' . $item_id
							);
							?>
							"><?php _e( 'Remove' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="
							<?php
							echo esc_url(
							add_query_arg(
							array(
							'edit-menu-item' => $item_id,
							'cancel'         => time(),
							),
							admin_url( 'nav-menus.php' )
							)
							);
							?>
							#menu-item-settings-<?php echo $item_id; ?>"><?php _e( 'Cancel' ); ?></a>
					</div>

					<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
					<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
					<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
					<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
					<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
					<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
				</div><!-- .menu-item-settings-->
				<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}
	}