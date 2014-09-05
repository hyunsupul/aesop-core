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
	      		'title'   => __('Aesop Story Engine', 'aesop-core'),
	      		'content' => __('
	      		<h3>Welcome to Aesop Story Engine</h3>
				<p>Add story components by clicking the "Add Component" button below. This opens the Story Engine and allows you to select the component that you\'d like to insert, after setting up a few options.</p>

				<h4 style="margin-bottom:0;">How to Edit Components</h4>
				<p>While in the <em>Visual</em> tab below, and after adding inserting a story component, each component will turn into a sort of placeholder. You can either edit the components options by clicking on the pencil icon, or delete the component with the trash can icon.</p>

				<h4 style="margin-bottom:0;">Working with Components</h4>
				<p>After adding a component to the editor, simply press "enter" and that will get you to the next line in the editor. Nesting components inside each other isn\'t allowed within the visual editor at this time.</p>

				<h4 style="margin-bottom:0;">Theme Compatibility</h4>
				<p>Aesop will work with most WordPress themes by adding a code snippet to enable Extended CSS Support. The following code snippet can be entered with a plugin such as Code Snippets. If you\'re a developer you can selectively load additional styles based on the component that you define in the array.</p>
				<code>add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );</code>

				<h4 style="margin-bottom:0;">Documentation</h4>
				<p>Documentation for the options are listed at <a href="http://aesopstoryengine.com/help">http://aesopstoryengine.com/help</a>, while developers may be more intereseted in <a href="http://aesopstoryengine.com/developers">http://aesopstoryengine.com/developers</a>.</p>
	      		
	      		<h4>Donations</h4>
	      		<p>Aesop Story Engine is 100% free and open-sourced, but we do rely on donations and purchases of our <a href="http://aesopstoryengine.com/library/category/themes/">premium WordPress themes</a> and add-ons to facilitate further development of the free plugin. If Aesop Story Engine has worked out for you well, please consider making a donation at <a href="http://aesopstoryengine.com/donate">http://aesopstoryengine.com/donate</a>.</p>

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
					<li>Click the Add Gallery button</li>
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