<?php

if( is_admin() ) {
	
	// Add 'mine' link always when on edit.php
	add_filter( 'views_edit-post', 'pilkku_plugin_edit_views_filterable' );
	
}

/* If members plugin is activated, add members capabilities in role management. */
if( function_exists( 'members_get_capabilities' ) )
		add_filter( 'members_get_capabilities', 'pilkku_plugin_members_get_capabilities' );


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
* Add tutorial capabilities to Members plugin.
*
* @since 0.1.0
*/
function pilkku_plugin_members_get_capabilities( $caps ) {

	return array_merge( $caps, array( 'edit_tutorials', 'edit_others_tutorials', 'publish_tutorials', 'delete_tutorials', 'read_private_tutorials', 'delete_others_tutorials' ) );

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