<?php

class aiCoreDash {

	function __construct(){

		add_action('wp_dashboard_setup', array($this,'remove_widgets' ));
		add_action('wp_dashboard_setup', array($this,'custom_widgets'));
	}

	/**
	 	* Remove wordpress dashboard widgets
	 	*
	 	* @since     1.0.0
	 	*
	 	* @return    null
	*/
	function remove_widgets() {

		global $wp_meta_boxes;

		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
	    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal');
	    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal');
	  	remove_meta_box( 'dashboard_quick_press',   'dashboard', 'side' );      //Quick Press widget
	    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      //Recent Drafts
	    remove_meta_box( 'dashboard_primary',       'dashboard', 'side' );      //WordPress.com Blog
	    remove_meta_box( 'dashboard_secondary',     'dashboard', 'side' );      //Other WordPress News
	    remove_meta_box( 'dashboard_incoming_links','dashboard', 'normal' );    //Incoming Links
	    remove_meta_box( 'dashboard_plugins',       'dashboard', 'normal' );    //Plugins

	}

	/**
		* Creates a custom help widget on WP dashboard
	 	*
	 	* @since     1.0.0
	 	*
	 	* @return    call    returns a callback for custom_dashboard_help
	*/
	function custom_widgets() {
		global $wp_meta_boxes;

		wp_add_dashboard_widget('get_storiews', 'Your Stories', array($this,'get_stories'));
		wp_add_dashboard_widget('collaborators', 'Collaborators', array($this,'collaborators_view'));
		wp_add_dashboard_widget('collab_posts', 'Collaborated Stories', array($this,'collaborated_stories'));
	}

	/**
	 	* Return the stories that the currnent user is co-authored
	 	*
	 	* @since     1.0.0
	 	*
	*/
	function get_stories() {

		global $current_user;
	  	
	  	$args = array(
	  		'author'	=> $current_user->ID,
	    	'post_type' => 'post',
	    	'post_status' => 'publish, private, draft',
	    	'posts_per_page' => -1,
	  	);

	  	$q = new WP_Query($args);

	  	?><ul class="aesop-admin-post-list">

	  	<?php

		  	if( $q->have_posts() ): 

		  		while ($q->have_posts()) : $q->the_post();

		  	 	?>
			      	<li>
			      		<span class="aesop-admin-story-title"><?php the_title(); ?></span>
			      		<div class="aesop-admin-edit-meta">
			      			<a class="aesop-admin-edit-story-link button button-small " href="<?php echo admin_url();?>post.php?post=<?php echo the_ID();?>&action=edit"><i class="aesop-admin-button-icon dashicons dashicons-welcome-write-blog"></i> Edit</a>
			      			<a class="aesop-admin-view-story-link button button-small button-primary" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" target="_new"><i class="aesop-admin-button-icon dashicons dashicons-share-alt2"></i> View</a>
			      		</div>
			      		</p>
			      	</li>
		    	<?php

		    	endwhile;

		   else:
		   		_e('You havent created any stories yet. <a href="/wp-admin/post-new.php">Create one</a> now.', 'aesop-core');
		   	endif;

		  	wp_reset_query();

	  	?></ul><?php
	}

	/**
	 	* Return the stories that the current user has co-authored
	 	*
	 	* @since     1.0.0
	 	*
	*/
	function collaborated_stories() {

		global $current_user;
	  	
	  	$args = array(
	    	'post_type' => 'post',
	    	'post_status' => 'publish, private, draft',
	    	'posts_per_page' => -1,
		    'tax_query' => array(
		        array(
		            'taxonomy' => 'author',
		            'field' => 'id',
		            'terms' => $current_user->ID,
		        ),
		    ),
	  	);

	  	$q = new WP_Query($args);

	  	?><ul class="aesop-admin-post-list">

	  	<?php

		  	if( $q->have_posts() ): 

		  		while ($q->have_posts()) : $q->the_post();

		  	 	?>
			      	<li>
			      		<span class="aesop-admin-story-title"><?php the_title(); ?></span>
			      		<div class="aesop-admin-edit-meta">
			      			<a class="aesop-admin-edit-story-link button button-small " href="<?php echo admin_url();?>post.php?post=<?php echo the_ID();?>&action=edit"><i class="aesop-admin-button-icon dashicons dashicons-welcome-write-blog"></i> Edit</a>
			      			<a class="aesop-admin-view-story-link button button-small button-primary" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" target="_new"><i class="aesop-admin-button-icon dashicons dashicons-share-alt2"></i> View</a>
			      		</div>
			      		</p>
			      	</li>
		    	<?php

		    	endwhile;

		   else:
		   		_e('You havent been invited to collaborate on any stories yet.', 'aesop-core');
		   	endif;

		  	wp_reset_query();

	  	?></ul><?php
	}
	/**
	 	* Return the users for the site
	 	*
	 	* @since     1.0.0
	 	*
	*/
	function collaborators_view() {

		?><ul><?php

			$args = array(
				'blog_id'      => $GLOBALS['blog_id'],
				'orderby'		=> 'nicename',
				'role'			=> 'editor'
			);

		    $authors = get_users($args);

		    if($authors){
			    foreach ($authors as $author) {
			        echo '<li>' . $author->display_name . '</li>';
			    }
			} else {

				_e('<a href="/wp-admin/user-new.php">Invite</a> someone to help you with your story.', 'aesop-core');
			}

		?></ul><?php
	}


}
new aiCoreDash;















