<?php

/* Register custom post type 'tutorial'. */
add_action( 'init', 'pilkku_plugin_register_cpt_tutorial' );

/*
 * Register custom post type tutorial.
 *
 * @since 0.1.0
 */
function pilkku_plugin_register_cpt_tutorial() {

	$labels = array( 
		'name' 					=> __( 'Tutorials', 'pilkku-plugin' ),
		'singular_name' 		=> __( 'Tutorial', 'pilkku-plugin' ),
		'add_new' 				=> __( 'Add New', 'pilkku-plugin' ),
		'add_new_item' 			=> __( 'Add New Tutorial', 'pilkku-plugin' ),
		'edit_item' 			=> __( 'Edit Tutorial', 'pilkku-plugin' ),
		'new_item' 				=> __( 'New Tutorial', 'pilkku-plugin' ),
		'view_item' 			=> __( 'View Tutorial', 'pilkku-plugin' ),
		'search_items' 			=> __( 'Search Tutorials', 'pilkku-plugin' ),
		'not_found' 			=> __( 'No tutorials found', 'pilkku-plugin' ),
		'not_found_in_trash' 	=> __( 'No tutorials found in Trash', 'pilkku-plugin' ),
		'parent_item_colon' 	=> __( 'Parent Tutorial:', 'pilkku-plugin' ),
		'menu_name' 			=> __( 'Tutorials', 'pilkku-plugin' ),
    );

    $args = array( 
		'labels' 				=> $labels,
		'hierarchical' 			=> false,
        
		'supports' 				=> array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
		//'taxonomies' 			=> array( 'category', 'post_tag' ),
		'public' 				=> true,
		'show_ui' 				=> true,
		'show_in_menu' 			=> true,
		'menu_position' 		=> 5,
        
		'show_in_nav_menus' 	=> true,
		'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> false,
		'has_archive' 			=> true,
		'query_var' 			=> true,
		'can_export' 			=> true,
		'rewrite' 				=> true,
		'rewrite' 				=> array('slug' => 'ohjeet'),
		'capability_type' 		=> 'tutorial',
		'map_meta_cap' 			=> true,
		'capabilities' 			=> array(
		
			// meta caps (don't assign these to roles)
			'edit_post' 				=> 'edit_tutorial',
			'read_post' 				=> 'read_tutorial',
			'delete_post' 				=> 'delete_tutorial',
			
			// primitive caps used outside of map_meta_cap()
			'edit_posts' 				=> 'edit_tutorials',
			'edit_others_posts' 		=> 'edit_others_tutorials',
			'publish_posts' 			=> 'publish_tutorials',
			'read_private_posts' 		=> 'read_private_tutorials', 
			
			// primitive caps used inside of map_meta_cap()
			'read' 						=> 'read',
			'delete_posts' 				=> 'delete_tutorials',
			'delete_private_posts' 		=> 'delete_others_tutorials',
			'delete_published_posts' 	=> 'delete_others_tutorials',
			'delete_others_posts' 		=> 'delete_others_tutorials',
			'edit_private_posts' 		=> 'edit_tutorials',
			'edit_published_posts' 		=> 'edit_tutorials'
        )
    );

    register_post_type( 'tutorial', $args );
}

?>