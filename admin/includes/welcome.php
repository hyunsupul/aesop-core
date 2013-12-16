<?php

/**
 * Hide default welcome dashboard message and and create a custom one
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function aesop_welcome_panel() {

	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('div.welcome-panel-content').hide();
	});
	</script>

	<div class="custom-welcome-panel-content">
	<h3><?php _e( 'Welcome to Aesop!','aesop-core' ); ?></h3>
	<p class="about-description"><?php _e( 'Here you can place your custom text, give your customers instructions, place an ad or your contact information.','aesop-core' ); ?></p>
	<div class="welcome-panel-column-container">
	<div class="welcome-panel-column">
		<h4><?php _e( "Let's Get Started",'aesop-core' ); ?></h4>
		<a class="button button-primary button-hero load-customize hide-if-no-customize" href="http://your-website.com"><?php _e( 'Create a Story','aesop-core' ); ?></a>
			<p class="hide-if-no-customize"><?php printf( __( 'or, <a href="%s">edit your site settings</a>','aesop-core' ), admin_url( 'options-general.php' ) ); ?></p>
	</div>
	<div class="welcome-panel-column">
		<h4><?php _e( 'Next Steps','aesop-core' ); ?></h4>
		<ul>
		<?php if ( 'page' == get_option( 'show_on_front' ) && ! get_option( 'page_for_posts' ) ) : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page','aesop-core' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages','aesop-core' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
		<?php elseif ( 'page' == get_option( 'show_on_front' ) ) : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-edit-page">' . __( 'Edit your front page','aesop-core' ) . '</a>', get_edit_post_link( get_option( 'page_on_front' ) ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages','aesop-core' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Add a blog post','aesop-core' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
		<?php else : ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Write your first story','aesop-core' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
		<?php endif; ?>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site','aesop-core' ) . '</a>', home_url( '/' ) ); ?></li>
		</ul>
	</div>
	<div class="welcome-panel-column welcome-panel-last">
		<h4><?php _e( 'More Actions','aesop-core' ); ?></h4>
		<ul>
			<li><?php printf( '<div class="welcome-icon welcome-widgets-menus">' . __( 'Manage <a href="%1$s">widgets</a> or <a href="%2$s">menus</a>','aesop-core' ) . '</div>', admin_url( 'widgets.php' ), admin_url( 'nav-menus.php' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-comments">' . __( 'Turn comments on or off','aesop-core' ) . '</a>', admin_url( 'options-discussion.php','aesop-core' ) ); ?></li>
			<li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more">' . __( 'Learn more about getting started','aesop-core' ) . '</a>', __( 'http://codex.wordpress.org/First_Steps_With_WordPress','aesop-core' ) ); ?></li>
		</ul>
	</div>
	</div>
	</div>

<?php
}

add_action( 'welcome_panel', 'aesop_welcome_panel' );