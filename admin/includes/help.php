<?php

/**
 * Creates a help tab within the posts screen
 *
 * @since    0.9.94
 */

class AesopContextualHelp {

	public function __construct() {

		add_filter( 'contextual_help', array( $this, 'aesop_help' ), 10, 3 );

	}

	public function aesop_help( $contextual_help, $screen_id, $screen ) {

		if ( 'edit-post' == $screen->id || 'post' == $screen->id ) {

			$screen->add_help_tab( array(
					'id'      => 'ai-story-help',
					'title'   => __( 'Aesop Story Engine', 'aesop-core' ),
					'content' =>
					'<h3>' .__( 'Welcome to Aesop Story Engine', 'aesop-core' ). '</h3>'.
					'<p>'.__( 'Add story components by clicking the "Add Component" button below. This opens the Story Engine and allows you to select the component that you\'d like to insert, after setting up a few options.', 'aesop-core' ). '</p>'.
					'<h4 style="margin-bottom:0;">'. __( 'How to Edit Components', 'aesop-core' ).'</h4>'.
					'<p>'. __( 'While in the <em>Visual</em> tab below, and after adding inserting a story component, each component will turn into a sort of placeholder. You can either edit the components options by clicking on the pencil icon, or delete the component with the trash can icon.', 'aesop-core' ).'</p>'.
					'<h4 style="margin-bottom:0;">'.__( 'Working with Components', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'After adding a component to the editor, simply press "enter" and that will get you to the next line in the editor. Nesting components inside each other isn\'t allowed within the visual editor at this time.', 'aesop-core' ).'</p>'.
					'<h4 style="margin-bottom:0;">'.__( 'Using Maps', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'At this time one map is allowed per post. Click into the map meta box to add a marker. Click the marker to add optional title and or content. Clicking update will update the marker text. You can drag around the markers. You can also drag around the map, and set the zoom. These will be saved and the map displayed on your post will reflect this. Map markers are shown in the order that they are added.', 'aesop-core' ).'</p>'.
					'<p>'.__( 'Map tiles are provided by our free account through Mapbox. If the map is grayed out, and the map tiles are 404, then the free Aesop account has reached its monthly quota. For this reason it\'s highly recommended to sign up for your own free <a href="http://mapbox.com">Mapbox</a> account. Further documentation on this can be found <a href="http://aesopstoryengine.com/help/maps-component/">here</a>.', 'aesop-core' ).'</p>'.
					'<h4 style="margin-bottom:0;">'.__( 'Theme Compatibility', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'Aesop will work with most WordPress themes by adding a code snippet to enable Extended CSS Support. The following code snippet can be entered with a plugin such as Code Snippets. If you\'re a developer you can selectively load additional styles based on the component that you define in the array.', 'aesop-core' ).'</p>'.
					'<code>add_theme_support("aesop-component-styles", array("parallax", "image", "quote", "gallery", "content", "video", "audio", "collection", "chapter", "document", "character", "map", "timeline" ) );</code>'.
					'<h4 style="margin-bottom:0;">'.__( 'Documentation', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'Documentation for the options are listed at <a href="http://aesopstoryengine.com/help">http://aesopstoryengine.com/help</a>, while developers may be more intereseted in <a href="http://aesopstoryengine.com/developers">http://aesopstoryengine.com/developers</a>.', 'aesop-core' ).'</p>'.
					'<h4>'.__( 'Donations', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'Aesop Story Engine is 100% free and open-sourced, but we do rely on donations and purchases of our <a href="http://aesopstoryengine.com/library/category/themes/">premium WordPress themes</a> and add-ons to facilitate further development of the free plugin. If Aesop Story Engine has worked out for you well, please consider making a donation at <a href="http://aesopstoryengine.com/donate">http://aesopstoryengine.com/donate</a>.', 'aesop-core' ).'</p>'

				) );

		}//end if

		if ( 'ai_galleries' == $screen->id ) {

			$screen->add_help_tab( array(
					'id'      => 'ai-gallery-help',
					'title'   => __( 'Aesop Galleries', 'aesop-core' ),
					'content' =>
					'<h3>'. __( 'Aesop Gallery Component', 'aesop-core' ). '</h3>'.
					'<p>'.__( 'Gallery components for Aesop are created and managed here with the Galleries post type. Each post is a different gallery, and each gallery has it\'s own shortcode that you\'ll use to display the gallery with.', 'aesop-core' ).'</p>'.
					'<h4>'.__( 'Directions', 'aesop-core' ).'</h4>'.
					'<ol>'.
					'<li>'.__( 'Add images by clicking the Add Images button. Select multiple by holding down CNTRL or COMMAND, then click "Use Selected Images."', 'aesop-core' ).'</li>'.
					'<li>'.__( 'Choose a layout by clicking a layout option.', 'aesop-core' ).'</li>'.
					'<li>'.__( 'Adjust any available options for your specified gallery type.', 'aesop-core' ).'</li>'.
					'<li>'.__( 'Publish the gallery.', 'aesop-core' ).'</li>'.
					'<li>'.__( 'Go to any post, open the Component generator, select the Gallery component, and choose the gallery that you just created from the list.', 'aesop-core' ).'</li>'.
					'</ol>'.
					'<p>'.__( 'Tips: Clicking the "x" icon over the image will delete the image from this gallery (but not from your site). Clicking the "pencil" icon will let you edit any information for the image such as a caption or title used by some galleries.', 'aesop-core' ).'</p>'.
					'<h4>'.__( 'Documentation', 'aesop-core' ).'</h4>'.
					'<p>'.__( 'All components, options, and hooks are fully documented at <a href="http://developers.aesopstories.com">http://developers.aesopstories.com</a>', 'aesop-core' ).'</p>'
				) );
		}//end if
	}

}
new AesopContextualHelp;
