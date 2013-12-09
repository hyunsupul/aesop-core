<?php

class aiCoreMenuCleanup {

	public function __construct(){
		add_action('admin_init', array($this,'remove_theme_edit'));
		add_action( 'admin_menu', array($this,'remove_menus'));
	}

	/*
	*	Remove Page Menu
	*	Remove Plugins Menu
	*	Remove Users Menu
	*
	*/
	function remove_menus(){

	  	remove_menu_page( 'edit.php?post_type=page' );    //Pages
	  	remove_menu_page( 'plugins.php' );                //Plugins
	  	remove_menu_page( 'users.php' );                  //Users
	  	remove_menu_page( 'edit.php' );                  //Users

	  	//remove_menu_page( 'tools.php' );                  //Tools
	  	//remove_menu_page( 'options-general.php' );        //Settings
	  	//remove_menu_page( 'edit-comments.php' );          //Comments
	  	//remove_menu_page( 'themes.php' );                 //Appearance

	}

	/*
	* 	Removes Editor from Theme Menu
	*	Removed edit tags from post menu
	*/
	function remove_theme_edit(){
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag'  );
	}

}

new aiCoreMenuCleanup;