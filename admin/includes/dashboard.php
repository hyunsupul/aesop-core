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

		wp_add_dashboard_widget('custom_help_widget', 'Custom Dash Widget', array($this,'custom_dashboard_help'));
	}

	/**
	 	* Return an instance of this class.
	 	*
	 	* @since     1.0.0
	 	*
	 	* @return    object    HTML for dashboard ewidget
	*/
	function custom_dashboard_help() {
		echo '<p>Custom Dashboard WIdget.</p>';
	}
}
new aiCoreDash;
