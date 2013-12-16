<?php

class aiCoreStoryView {

 	function __construct(){
 		add_action( 'admin_menu', array($this,'register_my_custom_menu_page' ));
 	}

	function register_my_custom_menu_page(){
		global $aesopstoryhook;
	    $aesopstoryhook = add_menu_page( __('Stories','aesop-core'), __('Stories','aesop-core'), 'edit_posts', 'stories', array($this,'my_custom_menu_page'), AI_CORE_URL.'/admin/assets/img/icon.png', 6 );
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


	  	?>
	  	<div class="aesop-admin-story-grid-wrap">
	  		<h2>Stories	<span class="story-count"><?php echo $q->found_posts;?></span></h2>

		  	<ul class="aesop-admin-story-grid">

		  		<li class="aesop-admin-grid-create">

		  			<a href="/wp-admin/post-new.php" class="aesop-clear">
		  				<div class="aesop-admin-grid-create-inner">
		      				<i class="dashicons dashicons-plus"></i>
		      				<h3><?php _e('Create a Story','aesop-core');?></h3>
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
					      				<a class="aesop-admin-edit-story-link button button-small" href="<?php echo admin_url();?>post.php?post=<?php echo the_ID();?>&action=edit"><i class="aesop-admin-button-icon dashicons dashicons-welcome-write-blog"></i> <?php _e('Edit','aesop-core');?></a>
					      				<a class="aesop-admin-view-story-link button button-small button-primary" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" target="_new"><i class="aesop-admin-button-icon dashicons dashicons-share-alt2"></i> <?php _e('View','aesop-core');?></a>
					      			</div>
					      		</div>
					      	</div>
				      	</li>

			    	<?php

			    endwhile;endif;

			  	wp_reset_query();

		  	?></ul>
		 </div><?php
	}

}
new aiCoreStoryView;