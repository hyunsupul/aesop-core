<?php
/**
 	* Controls all contextual help for various pages in wordpress admin
 	*
 	* @since       1.0
 	* @return      void
*/
class AesopContextualHelp {

	public function __construct(){
		add_filter('contextual_help', array($this,'aesop_contextual_help'), 10, 3);

	}

	/**
	 	* Controls all contextual help for various pages in wordpress admin
	 	*
	 	* @since       1.0
	 	* @return      void
	 	* @param    $aesopstoryhook - global hook for the stories admin page
	*/
	function aesop_contextual_help($contextual_help, $screen_id, $screen) {

		// story page
		global $aesopstoryhook;

		switch($screen->id):
			case ($screen_id == $aesopstoryhook):
				$this->aesop_story_help($contextual_help,$aesopstoryhook);
			break;
			case ($screen->id == 'edit-post' || $screen->id == 'post'):
				$this->aesop_post_help($screen);
			break;

		endswitch;

	}

	/**
	 	* Adds a contextual help tab to teh stories page in worpderss admin
	 	*
	 	* @since       1.0
	 	* @return      void
	*/
	function aesop_story_help($contextual_help,$aesopstoryhook){

		$contextual_help = __('<p>Below are all of the stories that you have authored. To add a new story, click the Create a Story space below. Green dots indicate a published story. Red dots indicate stories that are in draft.</p>','aesop-core');
		return $contextual_help;
	}

	/**
	 	* Adds contextual help to post screen
	 	* Removes existing post help not relevant to story telling
	 	*
	 	* @since       1.0
	 	* @return      void
	*/
	function aesop_post_help( $screen){
		// remove the stock post help tabs
		$screen->remove_help_tab('customize-display');
		$screen->remove_help_tab('title-post-editor');
		$screen->remove_help_tab('inserting-media');
		$screen->remove_help_tab('publish-box');
		$screen->remove_help_tab('discussion-settings');

		// creating stories help
		$screen->add_help_tab( array(
      		'id'      => 'ai-story-help',
      		'title'   => __('Creating Stories', 'aesop-core'),
      		'content' => __('<p>Help Content here.</p>','aesop-core'),
      	));

      	// story cover help
      	$screen->add_help_tab( array(
      		'id'      => 'ai-cover-help',
      		'title'   => __('Story Cover', 'aesop-core'),
      		'content' => __('<p>Help Content here.</p>','aesop-core'),
      	));

      	// story components help
		$screen->add_help_tab( array(
      		'id'      => 'ai-component-help',
      		'title'   => __('Story Components', 'aesop-core'),
      		'content' => __('<p>Help Content here.</p>','aesop-core'),
      	));

		// set help sidebar
      	$screen->set_help_sidebar(__('Sidebar doc.','aesop-core'));
	}

}
new AesopContextualHelp;