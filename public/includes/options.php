<?php
/**
 * Creates a section of options in theme customizer
 *
 * @since    1.0.3
 */


// add new options to new section
function AesopStoryEngineOptions_register( $wp_customize ) {
		class ChapterUI_Select_Control extends WP_Customize_Control {
			public $type = 'select';
			
			public function render_content() { 
				$val = $this->value();
			    $def_selected ="";
				$left_dots ="";
				$right_dots ="";
				if(empty($val)) $def_selected =  'selected="selected"';
				if($this->value() == 'left_dots') $left_dots =  'selected="selected"';
				if($this->value() == 'right_dots') $right_dots =  'selected="selected"';
				$content = '
				<label>
				<span class="customize-control-title">'.esc_html( $this->label ).'</span>
				<select '.$this->get_link().'>
					<option value="" '.$def_selected.'>'.__( 'Default', 'aesop-core' ).'</option>
					<option value="left_dots" '.$left_dots.'>'.__( 'Left Dots', 'aesop-core' ).'</option>
					<option value="right_dots" '.$right_dots.'>'.__( 'Right Dots', 'aesop-core' ).'</option>
				</select>
				<script>
					jQuery(document).ready(function($){			
						function optSetting(val){
							if (val == "") {
								jQuery("#customize-control-ase_chapter_dot_color,#customize-control-ase_chapter_hide_active_chapter_name,#customize-control-ase_chapter_active_dot_color,#customize-control-ase_chapter_active_hover_color,#customize-control-ase_chapter_enable_dots_mobile").slideUp();
							} else {
								jQuery("#customize-control-ase_chapter_dot_color,#customize-control-ase_chapter_hide_active_chapter_name,#customize-control-ase_chapter_active_dot_color,#customize-control-ase_chapter_active_hover_color,#customize-control-ase_chapter_enable_dots_mobile").slideDown();
							}
						}
						setTimeout( function() { 
							    optSetting(jQuery( "#customize-control-ase_chapter_ui_style select" ).val()); }, 500);
						jQuery( "#customize-control-ase_chapter_ui_style select" ).change(function() {
							optSetting(this.value);
						})
					});
				</script>
				</label>';
				$content = apply_filters( 'aesop_chapter_ui_select_content', $content );
				echo $content;
			} //render_content()
		} //Select_Control()

		$wp_customize->add_section( 'aesop_story_engine', array(
				'title'   => __( 'Aesop Story Engine', 'aesop-core' ),
							) );



		$wp_customize->add_setting( 'ase_mapbox_id', array(
				'default'   => '',
				'type'    => 'option',
				'sanitize_callback' => AesopStoryEngineOptions_sanitize_text_field()
			) );
		$wp_customize->add_control( 'ase_mapbox_id', array(
				'label'   => __( 'Mapbox Map ID', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_mapbox_id',
				'description' => __( 'Refer to the documentation located <a href="http://aesopstoryengine.com/help/map-component" target="_blank">here</a> for option descriptions.', 'aesop-core' ),
				'type'    => 'text'
			) );
		
		$wp_customize->add_setting( 'ase_mapbox_apikey', array(
				'default'   => 'AIzaSyDguxUeZr9LUPe9ImgYwXPTqPwQbsUFAJo',
				'type'    => 'option',
				'sanitize_callback' => AesopStoryEngineOptions_sanitize_text_field()
			) );
		$wp_customize->add_control( 'ase_mapbox_apikey', array(
				'label'   => __( 'Google Map API Key.', 'aesop-core'),
                'description' => __('Recommended: Visit <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a> to get your own API key.', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_mapbox_apikey',
				'type'    => 'text'
			) );
			
		$wp_customize->add_setting('ase_chapter_ui_style', array('default'=>'','type'    => 'option'));
		
		$wp_customize->add_control( new ChapterUI_Select_Control($wp_customize, 'ase_chapter_ui_style', array(
			'label' => __( 'Chapter Component UI', 'aesop-core'),
			'section' => 'aesop_story_engine',
			'settings' => 'ase_chapter_ui_style',
			'transport' => 'refresh'
		) ) );
		
		$wp_customize->add_setting( 'ase_chapter_content_class', array(
				'default'   => '.entry-content',
				'type'    => 'option',
				'sanitize_callback' => AesopStoryEngineOptions_sanitize_text_field()
			) );
		$wp_customize->add_control( 'ase_chapter_content_class', array(
				'label'   => __( 'Selector for the Post Content.', 'aesop-core'),
                'description' => __('ASE Chapter Component uses this information to search the chapters. The default should work for most themes.', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_chapter_content_class',
				'type'    => 'text'
			) );
		

			
		$wp_customize->add_setting( 'ase_chapter_no_animate_scroll', array(
				'default'   => '',
				'type'    => 'option',
				'label'		=> __('Disable Chapter Scroll Animation.', 'aesop-core')
			) );
		
		$wp_customize->add_control( 'ase_chapter_no_animate_scroll', array(
				'label'   => __( 'Disable Chapter Scroll Animation', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_chapter_no_animate_scroll',
				'type'    =>  'checkbox',
			) );

		$wp_customize->add_setting( 'ase_chapter_hide_active_chapter_name', array(
				'default'   => '',
				'type'    => 'option',
				'label'		=> __('Hide The Active Chapter Name on Dots.', 'aesop-core')
			) );
		
		$wp_customize->add_control( 'ase_chapter_hide_active_chapter_name', array(
				'label'   => __( 'Hide The Active Chapter Name on Dots.', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_chapter_hide_active_chapter_name',
				'type'    =>  'checkbox',
			) );
			
		$wp_customize->add_setting( 'ase_chapter_enable_dots_mobile', array(
				'default'   => '',
				'type'    => 'option',
				'label'		=> __('Enable Dots Navigation on Mobile.', 'aesop-core')
			) );
		
		$wp_customize->add_control( 'ase_chapter_enable_dots_mobile', array(
				'label'   => __( 'Enable Chapter Dots on Mobile. By default dots navigation is disabled on mobile.', 'aesop-core' ),
				'section'   => 'aesop_story_engine',
				'settings'   => 'ase_chapter_enable_dots_mobile',
				'type'    =>  'checkbox',
			) );
			
		// Chapter Dot Color
		$wp_customize->add_setting( 'ase_chapter_dot_color', array(
			'type' 		=> 'option',
			'default'	=> '#7f7f7f'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ase_chapter_dot_color', array(
			'label' 	=> __('Chapter Dot Color', 'aesop-core'),
			'section' 	=> 'aesop_story_engine',
			'settings' 	=> 'ase_chapter_dot_color',
			'transport' => 'postMessage'
		) ) );
			
		// Chapter Active Color
		$wp_customize->add_setting( 'ase_chapter_active_dot_color', array(
			'type' 		=> 'option',
			'default'	=> '#1e73be'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ase_chapter_active_dot_color', array(
			'label' 	=> __('Active Chapter Dot Color', 'aesop-core'),
			'section' 	=> 'aesop_story_engine',
			'settings' 	=> 'ase_chapter_active_dot_color',
			'transport' => 'postMessage'
		) ) );
		// Chapter Hover Color
		$wp_customize->add_setting( 'ase_chapter_active_hover_color', array(
			'type' 		=> 'option',
			'default'	=> '#dd9933'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ase_chapter_active_hover_color', array(
			'label' 	=> __('Active Chapter Hover Dot Color', 'aesop-core'),
			'section' 	=> 'aesop_story_engine',
			'settings' 	=> 'ase_chapter_active_hover_color',
			'transport' => 'postMessage'
		) ) );
}

function AesopStoryEngineOptions_sanitize_text_field( $input = ''  ) {
	return sanitize_text_field( $input );
}


// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , 'AesopStoryEngineOptions_register' );
