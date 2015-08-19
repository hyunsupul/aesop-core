<?php
/**
 * Creates a welcome screen when the plugin is activated
 *
 * @since 1.5
 */
class aesopCoreWelcome {

	public function __construct() {

		add_action( 'admin_init',   array( $this, 'redirect' ) );
		add_action( 'admin_menu',   array( $this, 'welcome' ) );
		add_action( 'admin_head',   array( $this, 'remove_menu' ) );

	}

	/**
	 * Redirect on plugin activation
	 *
	 * @since 1.5
	 */
	public function redirect() {

		// Bail if no activation redirect
		if ( ! get_transient( '_aesop_welcome_redirect' ) ) {
			return;
		}

		// Delete the redirect transient
		delete_transient( '_aesop_welcome_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
			return;
		}

		// Redirect to bbPress about page
		wp_safe_redirect( esc_url_raw( add_query_arg( array( 'page' => 'aesop-welcome-screen' ), admin_url( 'index.php' ) ) ) );

	}

	/**
	 * Draw the welcome page
	 *
	 * @since 1.5
	 */
	public function welcome() {
		add_dashboard_page( __( 'Welcome to Aesop Story Engine', 'aesop-core' ), __( 'Welcome to Aesop Story Engine', 'aesop-core' ), 'read', 'aesop-welcome-screen', array( $this, 'content' ) );
	}

	/**
	 * Welcome page callback
	 *
	 * @since 1.5
	 */
	public function content() {

?>
		  	<div class="wrap aesop--welcome">

		  		<div class="aesop--welcome__section aesop--welcome__section--top">
			  		<img src="<?php echo AI_CORE_URL.'/public/assets/img/aesop-logo.svg';?>">
			    	<h1><?php _e( 'Welcome to Aesop Story Engine', 'aesop-core' );?></h1>
			    	<h3><?php _e( 'Get started in a snap with our quick start guide', 'aesop-core' );?></h3>
			    	<ul class="aesop--welcome__social">
			    		<li><a href="http://twitter.com/aesopinteractiv" target="_blank"><i class="dashicons dashicons-twitter"></i> <?php _e( 'Twitter', 'aesop-core' );?></a></li>
			    		<li><a href="http://facebook.com/aesopinteractive" target="_blank"><i class="dashicons dashicons-facebook"></i> <?php _e( 'Facebook', 'aesop-core' );?></a></li>
			    	</ul>
			    </div>

			   	<div class="aesop--welcome__section aesop--welcome__section--quickstart">
			   		<h2><?php _e( 'Quick Start', 'aesop-core' );?></h2>
			   		<p class="aesop--welcome__lead"><?php _e( 'It\'s easy to get Aesop Story Engine implemented into your theme. Just follow these short steps below and you\'ll be on your way!', 'aesop-core' );?></p>
					<ul class="aesop--welcome__steps">
						<li>
							<strong><?php _e( 'Enable Theme Support', 'aesop-core' );?></strong>
							<p><?php _e( 'If your theme does not natively support Aesop Story Engine, add the code snippet below to your functions.php file, or add using', 'aesop-core' );?> <a href="<?php echo admin_url( 'plugin-install.php?tab=search&s=code+snippets' ) ?>"><?php _e( 'Code Snippets', 'aesop-core' );?></a> <?php _e( 'plugin to enable Extended Style Support. This will load one CSS file for any of the items that you include in the snippet below.', 'aesop-core' );?></p>
							<pre>add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );</pre>
						</li>
						<li>
							<strong><?php _e( 'Build your Story', 'aesop-core' );?></strong>
							<p><?php _e( 'Go to any post, and locate the "Add Component" button. It sits right above the post editor. Once you toggle this, you\'ll be able to select the component, adjust any options, and insert it anywhere within your story. Galleries are managed with the "Galleries" tab within WordPress.', 'aesop-core' );?></p>
						</li>
					</ul>
				</div>

			   	<div class="aesop--welcome__section aesop--welcome__section--addons">
			   		<h2><?php _e( 'Themes & Addons', 'aesop-core' );?></h2>
			   		<p><?php _e( 'Browse our growing library of', 'aesop-core' );?> <a href="http://aesopstoryengine.com/library/category/themes" target="_blank"><?php _e( 'themes', 'aesop-core' );?></a> and <a href="http://aesopstoryengine.com/library/category/add-ons"><?php _e( 'addons', 'aesop-core' );?></a> <?php _e( 'built specifically for Aesop Story Engine.', 'aesop-core' );?></p>
				</div>

			   	<div class="aesop--welcome__section aesop--welcome__section--addons">
			   		<h2><?php _e( 'Simpler, Faster, Easier Writing in WordPress', 'aesop-core' );?></h2>
			   		<p><?php _e( 'Stop wasting time constantly previewing your post, and edit and create from the front-end of your site with Editus, our front-end editor that goes perfectly with Aesop Story Engine. Visit the site and enter your email for a 25% discount!', 'aesop-core' );?> <a href="https://edituswp.com/?utm_source=aesop-plugin&utm_medium=banner&utm_campaign=aesop-plugin" target="_blank"><?php _e( 'Read More...', 'aesop-core' );?></a></p>
				</div>

		  	</div>
	 	<?php
	}

	/**
	 * Remove our welcome screen from the main menu dashboard
	 *
	 * @since 1.5
	 */
	public function remove_menu() {
		remove_submenu_page( 'index.php', 'aesop-welcome-screen' );
	}
}
new aesopCoreWelcome;
