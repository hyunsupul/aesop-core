<?php

class aiCoreStoryView {

 	function __construct(){
 		add_action( 'admin_menu', array($this,'register_my_custom_menu_page' ));
 	}

	function register_my_custom_menu_page(){
	    $menu = add_menu_page( 'Stories', 'Stories', 'edit_posts', 'stories', array($this,'my_custom_menu_page'), AI_CORE_URL.'/admin/assets/img/icon.png', 6 );
	}

	function my_custom_menu_page(){

	  	echo $this->stories();
	}

	function stories(){

		global $current_user;

	  	$args = array(
	    	'author' => $current_user->ID,
	    	'post_type' => 'post',
	    	'post_status' => 'publish, private, draft',
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

				$coverimg = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );

		  	 	?>
			      	<li <?php post_class();?>>
			      		<div class="aesop-admin-story-grid-story" style="background:url('<?php echo $coverimg;?>') no-repeat; background-size:cover;">
				      		<div class="aesop-admin-story-edit-meta">
				      			<span class="aesop-admin-story-grid-title"><?php the_title(); ?></span>
				      			<div class="aesop-admin-story-grid-actions">
				      				<a class="aesop-admin-edit-story-link button button-small" href="<?php echo admin_url();?>post.php?post=<?php echo the_ID();?>&action=edit"><i class="aesop-admin-button-icon dashicons dashicons-welcome-write-blog"></i> Edit</a>
				      				<a class="aesop-admin-view-story-link button button-small button-primary" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" target="_new"><i class="aesop-admin-button-icon dashicons dashicons-share-alt2"></i> View</a>
				      			</div>
				      		</div>
				      	</div>
			      	</li>

		    	<?php

		    endwhile;endif;

		  	wp_reset_query();

	  	?></ul><?php
	}

}
new aiCoreStoryView;