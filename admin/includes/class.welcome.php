<?php
/**
*
*	Creates a welcome screen when the plugin is activated
*	@since 1.5
*/
class aesopCoreWelcome {

	function __construct(){

		add_action( 'admin_init', 		array($this,'redirect' ));
		add_action( 'admin_menu', 		array($this,'welcome'));
		//add_action( 'admin_head', 		array($this,'remove_menu' ));

	}

	/**
	*
	*	Redirect on plugin activation
	*	@since 1.5
	*/
	function redirect() {

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
	  	wp_safe_redirect( add_query_arg( array( 'page' => 'aesop-welcome-screen' ), admin_url( 'index.php' ) ) );

	}

	/**
	*
	*	Draw the welcome page
	*	@since 1.5
	*/
	function welcome() {
	  	add_dashboard_page( __('Welcome to Aesop Story Engine','aesop-core'),__('Welcome to Aesop Story Engine','aesop-core'),'read','aesop-welcome-screen',array($this,'content'));
	}

	/**
	*
	*	Welcome page callback
	*	@since 1.5
	*/
	function content() {

	  	?>
		  	<div class="wrap">
		    	<h2>Welcome to Aesop Story Engine</h2>
		    	<p>Coming soon!</p>
		  	</div>
	 	<?php
	}

	/**
	*
	*	Remove our welcome screen from the main menu dashboard
	*	@since 1.5
	*/
	function remove_menu() {
    	remove_submenu_page( 'index.php', 'aesop-welcome-screen' );
	}
}
new aesopCoreWelcome;