<?php

/**
 	* Creates a help tab within the posts screen
 	*
 	* @since    0.9.94
*/

class AesopContextualHelp {

	function __construct() {

		add_filter('contextual_help', array($this,'aesop_help'), 10, 3);

	}

	function aesop_help($contextual_help, $screen_id, $screen) {

		if ( 'edit-post' == $screen->id || 'post' == $screen->id ) {

			$screen->add_help_tab( array(
	      		'id'      => 'ai-story-help',
	      		'title'   => __('Aesop Core', 'aesop-core'),
	      		'content' => __('
	      		<h3>Welcome to Aesop</h3>
				<p>Add story components by clicking the "Add Component" button below. This opens the Story Engine and allows you to select the component that you\'d like to insert, after setting up a few options.</p>

				<h4>Theme Compatibility</h4>
				<p>While most of the components will work with any theme, the <em>Timeline</em> and <em>Chapter</em> components will not function as designed without a theme that implements the necessary action hooks. Refer to the documentation link below.</p>

				<h4>Documentation</h4>
				<p>All components, options, and hooks are full documented at <a href="http://developers.aesopstories.com">http://developers.aesopstories.com</a></p>
	      		','aesop-core')
	      	));

		}

		if ( 'ai_galleries' == $screen->id ){

			$screen->add_help_tab( array(
	      		'id'      => 'ai-gallery-help',
	      		'title'   => __('Aesop Galleries', 'aesop-core'),
	      		'content' => __('
	      		<h3>Aesop Gallery Component</h3>
				<p>Gallery components for Aesop are created and managed here with the Galleries post type. Each post is a different gallery, and each gallery has it\'s own shortcode that you\'ll use to display the gallery with.</p>

				<h4>Directions</h4>
				<ol>
					<li>Click the Add Media button</li>
					<li>Click Create Gallery to create a gallery</li>
					<li>Create a gallery, then choose a gallery type while creating the gallery within the gallery modal. </li>
					<li>Insert the gallery into the post, and publish the page.</li>
					<li>Take note of the code produced that you\'ll copy and paste into the post where you want the gallery to show up.</li>
					</ol>


				<h4>Documentation</h4>
				<p>All components, options, and hooks are full documented at <a href="http://developers.aesopstories.com">http://developers.aesopstories.com</a></p>
	      		','aesop-core')
	      	));
		}
	}

}
new AesopContextualHelp;