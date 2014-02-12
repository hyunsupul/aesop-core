<?php

/**
 	* Creates a help tab within the posts screen
 	*
 	* @since    0.9.94
*/

class AesopPostHelp {

	function __construct() {

		add_filter('contextual_help', array($this,'aesop_contextual_help'), 10, 3);

	}

	function aesop_contextual_help($contextual_help, $screen_id, $screen) {

		if ($screen->id == 'edit-post' || $screen->id == 'post'):

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

		endif;

	}

}
new AesopPostHelp;