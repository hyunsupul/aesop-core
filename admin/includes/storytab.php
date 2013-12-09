<?php

class aiCoreStoryView {

 	function __construct(){
 		add_action( 'admin_menu', array($this,'register_my_custom_menu_page' ));
 		 add_action( 'admin_init', array($this,'plugin_admin_init' ));
 	}

	function register_my_custom_menu_page(){
	    $menu = add_menu_page( 'Stories', 'Stories', 'manage_options', 'stories', array($this,'my_custom_menu_page'), 'dashicons-edit', 6 );
	    add_action( 'admin_print_styles-' . $menu, array($this,'admin_custom_css' ));
	}

	function my_custom_menu_page(){

	  	echo $this->stories();
	}

	function stories(){

		global $current_user;

	  	$args = array(
	    	'author' => $current_user->ID,
	    	'post_type' => 'post',
	    	'post_status' => 'publish, private',
	    	'posts_per_page' => -1,
	  	);

	  	$q = new WP_Query($args);

	  	?><ul class="aesop-admin-story-grid">

	  		<li class="aesop-admin-grid-create">

	  			<a href="/wp-admin/post-new.php" class="aesop-clear">
	  				<div class="aesop-admin-grid-create-inner">
	      				<i class="dashicons dashicons-plus"></i>
	      				<h3>Create a Story</h3>
	      			</div>
	      		 </a>

	      	</li>

	  	<?php

		  	if( $q->have_posts() ): while ($q->have_posts()) : $q->the_post();

		  	 	?>
			      	<li>
			      		<div class="aesop-admin-story-grid-story" style="background:url('http://placekitten.com/300/300') no-repeat; background-size:cover;">
				      		<div class="aesop-admin-story-edit-meta">
				      			<span class="aesop-admin-story-grid-title"><?php the_title(); ?></span>
				      			<a class="aesop-admin-edit-story-link button button-small" href="<?php echo admin_url();?>post.php?post=<?php echo the_ID();?>&action=edit"><i class="aesop-admin-button-icon dashicons dashicons-welcome-write-blog"></i> Edit</a>
				      			<a class="aesop-admin-view-story-link button button-small button-primary" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" target="_new"><i class="aesop-admin-button-icon dashicons dashicons-share-alt2"></i> View</a>
				      		</div>
				      	</div>
			      	</li>

		    	<?php

		    endwhile;endif;

		  	wp_reset_query();

	  	?></ul><?php
	}

    function plugin_admin_init() {
        wp_register_style( 'edd-catalog-style', AI_CORE_URL.'/admin/assets/css/story-tab-style.css', AI_CORE_VERSION, true );
    }

	function admin_custom_css() {
      wp_enqueue_style( 'edd-catalog-style' );
  	}

}
new aiCoreStoryView;