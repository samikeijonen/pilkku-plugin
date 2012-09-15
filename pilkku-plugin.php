<?php
/**
 * Plugin Name: Pilkku Plugin
 * Plugin URI: http://foxnet.fi/en
 * Description: Add stuff what we need in school magazine.
 * Version: 0.1
 * Author: Sami Keijonen
 * Author URI: http://foxnet.fi/en
 * Contributors: samikeijonen
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package PilkkuPlugin
 * @version 0.1
 * @author Sami Keijonen <sami.keijonen@foxnet.fi>
 * @copyright Copyright (c) 2012, Sami Keijonen
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/* Set up the plugin on the 'plugins_loaded' hook. */
add_action( 'plugins_loaded', 'pilkku_plugin_setup' );

/**
 * Plugin setup function.  Loads actions and filters to their appropriate hook.
 *
 * @since 0.1.0
 */
function pilkku_plugin_setup() {

	/* Load the translation of the plugin. */
	load_plugin_textdomain( 'pilkku-plugin', false, 'pilkku-plugin/languages' );

	if( is_admin() ) {
	
		// Add 'mine' link always when on edit.php
		add_filter( 'views_edit-post', 'pilkku_plugin_edit_views_filterable' );
	
	}
	
	/* Register custom post type 'tutorial'. */
	add_action( 'init', 'pilkku_plugin_register_cpt_tutorial' );
	
	/* If members plugin is activated, add members capabilities in role management. */
	if( function_exists( 'members_get_capabilities' ) )
		add_filter( 'members_get_capabilities', 'pilkku_plugin_members_get_capabilities' );
	
	/* Map meta capabilities. @link: http://justintadlock.com/archives/2010/07/10/meta-capabilities-for-custom-post-types */
	add_filter( 'map_meta_cap', 'pilkku_plugin_map_meta_cap', 10, 4 );
	
}

/*
 * Add 'Mine' link always in admin edit.php page. Hook is views_edit-post. By default this is seen if user can't edit_others_posts.
 *
 * @since 0.1.0
 */
function pilkku_plugin_edit_views_filterable( $views ) {

	/* Unset original 'Mine' link. */
	unset( $views['mine'] );
	
	if ( isset( $_GET['author'] ) && $_GET['author'] == get_current_user_id() || $_GET['author_name'] = get_the_author_meta( 'user_nicename' )  ) {
		
		/* Current class. */
		$pilkku_plugin_class = ' class="current"';
		
		/* Remove 'current' class from all-link. */
		add_action( 'admin_footer', 'pilkku_plugin_footer_scripts', 20 );
		
	}
	else {
		$pilkku_plugin_class = '';
	}
	
	/* Get user post count. */
	$pilkku_plugin_post_count = count_user_posts( get_current_user_id() );
	
	/* Add 'mine' link only if there are more than zero post by user. */
	//if ( $pilkku_plugin_post_total > 0 ) {
		
		$pilkku_plugin_views = array(
			'pilkku-plugin-mine' => sprintf( '<a %s href="%s">%s</a>', $pilkku_plugin_class, esc_url( add_query_arg( 'author', get_current_user_id(), 'edit.php' ) ), sprintf( _n( 'Mine <span class="count">(%s)</span>', 'Mine <span class="count">(%s)</span>', $pilkku_plugin_post_count, 'pilkku-plugin' ), number_format_i18n( $pilkku_plugin_post_count ) ) ) 
		);
	 
		/* Return $views so that 'Mine' attachments are first. */
		return array_merge( $pilkku_plugin_views, $views );
	
	//}
	//else {
		//return $views;
	//}
	
}

/*
 * Register custom post type tutorial.
 *
 * @since 0.1.0
 */
function pilkku_plugin_register_cpt_tutorial() {

	$labels = array( 
		'name'					=> __( 'Tutorials', 'pilkku-plugin' ),
		'singular_name'			=> __( 'Tutorial', 'pilkku-plugin' ),
		'add_new'				=> __( 'Add New', 'pilkku-plugin' ),
		'add_new_item'			=> __( 'Add New Tutorial', 'pilkku-plugin' ),
		'edit_item'				=> __( 'Edit Tutorial', 'pilkku-plugin' ),
		'new_item'				=> __( 'New Tutorial', 'pilkku-plugin' ),
		'view_item'				=> __( 'View Tutorial', 'pilkku-plugin' ),
		'search_items'			=> __( 'Search Tutorials', 'pilkku-plugin' ),
		'not_found'				=> __( 'No tutorials found', 'pilkku-plugin' ),
		'not_found_in_trash'	=> __( 'No tutorials found in Trash', 'pilkku-plugin' ),
		'parent_item_colon'		=> __( 'Parent Tutorial:', 'pilkku-plugin' ),
		'menu_name'				=> __( 'Tutorials', 'pilkku-plugin' ),
    );

    $args = array( 
		'labels'		=> $labels,
		'hierarchical'	=> false,
        
		'supports'		=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
		//'taxonomies'	=> array( 'category', 'post_tag' ),
		'public'		=> true,
		'show_ui'		=> true,
		'show_in_menu'	=> true,
		'menu_position'	=> 5,
        
		'show_in_nav_menus'		=> true,
		'publicly_queryable'	=> true,
		'exclude_from_search'	=> false,
		'has_archive'			=> true,
		'query_var'				=> true,
		'can_export'			=> true,
		'rewrite'				=> true,
		'rewrite'				=> array('slug' => 'ohjeet'),
		'capability_type'		=> 'tutorial',
		'capabilities'			=> array(
			'edit_posts' 			=> 'edit_tutorials',
			'edit_others_posts'		=> 'edit_others_tutorials',
			'publish_posts' 		=> 'publish_tutorials',
			'delete_posts' 			=> 'delete_tutorials',
			'read_private_posts' 	=> 'read_private_tutorials', 
			'delete_others_posts' 	=> 'delete_others_tutorials',
			'edit_post' 			=> 'edit_tutorial',
			'read_post' 			=> 'read_tutorial',
			'delete_post' 			=> 'delete_tutorial',
        )
    );

    register_post_type( 'tutorial', $args );
}

/*
* Add tutorial capabilities to Members plugin.
*
* @since 0.1.0
*/
function pilkku_plugin_members_get_capabilities( $caps ) {

return array_merge( $caps, array( 'edit_tutorials', 'edit_others_tutorials', 'publish_tutorials', 'delete_tutorials', 'read_private_tutorials', 'delete_others_tutorials' ) );

}

/**
* Map meta capabilities.
* @link: http://justintadlock.com/archives/2010/07/10/meta-capabilities-for-custom-post-types
* @since 0.1.0
*/
function pilkku_plugin_map_meta_cap( $caps, $cap, $user_id, $args ) {

	/* If editing, deleting, or reading a tutorial, get the post and post type object. */
	if ( 'edit_tutorial' == $cap || 'delete_tutorial' == $cap || 'read_tutorial' == $cap ) {
		
		$post = get_post( $args[0] );
		$post_type = get_post_type_object( $post->post_type );

		/* Set an empty array for the caps. */
		$caps = array();
		
	}

	/* If editing a tutorial, assign the required capability. */
	if ( 'edit_tutorial' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->edit_posts;
		else
			$caps[] = $post_type->cap->edit_others_posts;
	}

	/* If deleting a tutorial, assign the required capability. */
	elseif ( 'delete_tutorial' == $cap ) {
		if ( $user_id == $post->post_author )
			$caps[] = $post_type->cap->delete_posts;
		else
			$caps[] = $post_type->cap->delete_others_posts;
	}

	/* If reading a private tutorial, assign the required capability. */
	elseif ( 'read_tutorial' == $cap ) {

		if ( 'private' != $post->post_status )
			$caps[] = 'read';
		elseif ( $user_id == $post->post_author )
			$caps[] = 'read';
		else
			$caps[] = $post_type->cap->read_private_posts;
	}

	/* Return the capabilities required by the user. */
	return $caps;

}

/*
 * Remove 'current' class from all-link.
 *
 * @since 0.1.0
 */
function pilkku_plugin_footer_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(
	function() {
		jQuery( '.all a' ).removeClass('current');
	}
);
</script>

<?php }

?>