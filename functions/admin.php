<?php

/*  --------------------------------------------------------------------------------------------------
	 ADMINISTRATION AND PERMISSIONS
	-------------------------------------------------------------------------------------------------- */

	// Sort by PDF in Media Library
	function modify_post_mime_types($post_mime_types) {
	    $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
	    return $post_mime_types;
	}
	add_filter('post_mime_types', 'modify_post_mime_types');


	// Allow Editor access to Appearance menu
	$editor_role = get_role( 'editor' );
	$editor_role->add_cap( 'edit_theme_options' );


	// Redirect non-admins to home URL after login
	add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );
	function my_login_redirect( $redirect_to, $request, $user ) {
		if ( is_array( $user->roles ) ) {
			if ( in_array( 'administrator', $user->roles ) )
				return home_url( '/wp-admin/' );
			else
				return home_url();
		}
	}


	// Custom Login Logo, URL, and tooltip
	function custom_login_logo() {
		echo "<style>
		body.login #login h1 a {
			background: url('".get_bloginfo('template_url')."/images/custom-logo.png') no-repeat scroll center top transparent;
			width: 274px;
			height: 63px;
		}
		</style>";
	}
	add_filter('login_headerurl', create_function(false,"return '".home_url()."';"));
	add_filter('login_headertitle', create_function(false,"return 'Powered by WordPress';"));
	add_action("login_head", "custom_login_logo");


	// Remove admin menus from sidebar for non-admins
	//function remove_admin_menu_items() {
	//	$remove_menu_items = array(
	//		__('Appearance'),
	//		__('Comments'),
	//		__('Links'),
	//		__('Media'),
	//		__('Pages'),
	//		__('Plugins'),
	//		__('Posts'),
	//		__('Settings'),
	//		__('Tools'),
	//		__('Users')
	//	);
	//	global $menu;
	//	end ($menu);
	//	while (prev($menu)){
	//		$item = explode(' ',$menu[key($menu)][0]);
	//		if(in_array($item[0] != NULL?$item[0]:"" , $remove_menu_items)){
	//			unset($menu[key($menu)]);
	//		}
	//	}
	//}
	//if (!current_user_can('administrator')) {
	//	add_action('admin_menu', 'remove_admin_menu_items'); }


	// Add and remove admin bar items for non-admins
	//function custom_admin_bar_render() {
	//	global $wp_admin_bar;
	//	// Remove
	//	$wp_admin_bar->remove_menu('wp-logo');
	//	$wp_admin_bar->remove_menu('comments');
	//	$wp_admin_bar->remove_menu('new-link', 'new-content');
	//	$wp_admin_bar->remove_menu('new-post', 'new-content');
	//	$wp_admin_bar->remove_menu('my-account');
	//	// Add
	//	$wp_admin_bar->add_menu( array(
	//		'parent' => 'top-secondary',
	//		'id' => 'log_out',
	//		'title' => __('Log Out'),
	//		'href' => wp_logout_url()
	//	));
	//}
	//add_action( 'wp_before_admin_bar_render', 'custom_admin_bar_render' );


	// Remove meta boxes for non-admins
	//function remove_meta_boxes() {
	//	remove_meta_box('commentstatusdiv','page','normal'); // Comments status (discussion)
	//	remove_meta_box('commentsdiv','page','normal'); // Comments
	//	remove_meta_box('slugdiv','page','normal'); // Slug
	//	remove_meta_box('authordiv','page','normal'); // Author
	//	remove_meta_box('postcustom','page','normal'); // Custom fields
	//	remove_meta_box('postexcerpt','page','normal'); // Excerpt
	//	remove_meta_box('trackbacksdiv','page','normal'); // Trackbacks
	//	remove_meta_box('formatdiv','page','normal'); // Formats
	//	remove_meta_box('tagsdiv-post_tag','page','normal'); // Tags
	//	remove_meta_box('categorydiv','page','normal'); // Categories
	//	remove_meta_box('pageparentdiv','page','normal'); // Attributes
	//}
	//if(!current_user_can('administrator')) {
	//	add_action('admin_init','remove_meta_boxes'); }


	// Hide WP update messages for non-admins
	if ( !current_user_can('administrator') ) {
		add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) ); }


	// Hide admin bar search box
	function hide_admin_bar_search () { ?>
		<style type="text/css">
		#wpadminbar #adminbarsearch {
			display: none;
		}
		</style>
		<?php
	}
	add_action('admin_head', 'hide_admin_bar_search');
	add_action('wp_head', 'hide_admin_bar_search');


	// Custom Admin Footer
	function custom_admin_footer_text () {
		echo 'Copyright &copy; '. date("Y") .' '. get_bloginfo('name') .' | Site Design by <a href="http://vtldesign.com" target="_blank">Vital Design</a>';
	}
	add_filter('admin_footer_text', 'custom_admin_footer_text');


	// Replace "Howdy" text on admin-bar
	function replace_howdy( $wp_admin_bar ) {
		$my_account=$wp_admin_bar->get_node('my-account');
		$newtitle = str_replace( 'Howdy,', 'Logged in as', $my_account->title );
		$wp_admin_bar->add_node( array(
			'id' => 'my-account',
			'title' => $newtitle,
		) );
	}
	add_filter( 'admin_bar_menu', 'replace_howdy',25 );
?>