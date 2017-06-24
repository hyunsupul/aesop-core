<?php



/**
 * Output codes for scroll reveal animation, pluggable
 * @since 1.9.4
 */
if ( ! function_exists( 'aesop_scroll_reveal_animation' ) ) {
	function aesop_scroll_reveal_animation($component, $atts, $unique) 
	{  
	    $overlay_id = "";
		$delay ="";
		switch ($component) {
			case 'image':
				$id = '#aesop-image-component-'.esc_html( $unique );
				$overlay_id = ".aesop-image-overlay-content";				
				break;
			case 'quote':
				$id = '#aesop-quote-component-'.esc_html( $unique );		     
				break;
			case 'chapter':
				$id = '#chapter-unique-'.esc_html( $unique );		     
				$overlay_id = ".aesop-chapter-overlay-content";
				break;
			case 'video':
				$id = '#aesop-video-'.esc_html( $unique );	
				$overlay_id = ".aesop-video-overlay-content";
				break;
			case 'gallery':
				$id = '#aesop-gallery-'.esc_html( $unique );
				$overlay_id = ".aesop-hero-gallery-content";
				break;
			case 'content':
				$id = '#aesop-content-component-'.esc_html( $unique );
				$overlay_id = ".aesop-component-content-data";
				break;
			case 'character':
				$id = '#aesop-character-component-'.esc_html( $unique );				
				break;
			case 'parallax':
				$id = '#aesop-parallax-component-'.esc_html( $unique );
				$overlay_id = ".aesop-parallax-sc-floater";
				break;
			case 'collection':  
				$id = '#aesop-collection-'.esc_html( $unique )." .aesop-collection-item"; 
				$delay = ',200'; 
				break;
			default:
				return;
		}
		?>
		<script>
		jQuery(document).ready(function(){
				if (!window.sr) {
				   window.sr = ScrollReveal();
				}
		<?php
		$overlay_delay = 500;
		switch ($atts['revealfx']) {
			case 'inplace':
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '0px', duration: 1000}<?php echo $delay ;?>);<?php
				break;
			case 'inplaceslow':
				$overlay_delay = 2500;
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '0px', delay:500, duration: 2000}<?php echo $delay ;?>);<?php
				break;
			case 'frombelow':
				$overlay_delay = 1500;
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'bottom', distance: '200px', duration: 1000}<?php echo $delay ;?>);<?php
				break;
			case 'fromleft':
				$overlay_delay = 1500;
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'left', distance: '400px', duration: 1000}<?php echo $delay ;?>);<?php
				break;
			case 'fromright':
				$overlay_delay = 1500;
				?>sr.reveal('<?php echo esc_html( $id );?>', {origin:'right', distance: '400px', duration: 1000}<?php echo $delay ;?>);<?php
				break;
			default:
			    ?>jQuery('<?php echo esc_html( $id );?>').css("visibility","visible"); <?php
			    break;
		}
		switch ($atts['overlay_revealfx']) {
			case 'inplace':
				?>sr.reveal('<?php echo esc_html( $id )." ".$overlay_id;?>', {origin:'bottom', delay:<?php echo $overlay_delay;?>, distance: '0px', duration: 1000});<?php
				break;
			case 'inplaceslow':
				?>sr.reveal('<?php echo esc_html( $id )." ".$overlay_id;?>', {origin:'bottom', delay:<?php echo $overlay_delay;?>, distance: '0px', duration: 2000});<?php
				break;
			case 'frombelow':
				?>sr.reveal('<?php echo esc_html( $id )." ".$overlay_id;?>', {origin:'bottom', delay:<?php echo $overlay_delay;?>, distance: '200px', duration: 1000});<?php
				break;
			case 'fromleft':
				?>sr.reveal('<?php echo esc_html( $id )." ".$overlay_id;?>', {origin:'left', delay:<?php echo $overlay_delay;?>, distance: '400px', duration: 1000});<?php
				break;
			case 'fromright':
				?>sr.reveal('<?php echo esc_html( $id )." ".$overlay_id;?>', {origin:'right', delay:<?php echo $overlay_delay;?>, distance: '400px', duration: 1000});<?php
				break;
			default:
			    ?>jQuery('<?php echo esc_html( $id )." ".$overlay_id;?>').css("visibility","visible"); <?php
			    break;
		}
		?>
		});
		</script>
	    <?php
	}
}

if ( ! function_exists( 'aesop_scroll_reveal_animation_gallery' ) ) {
	function aesop_scroll_reveal_animation_gallery($type, $atts, $unique) 
	{  
	    global $revealcode;
	    // handle sequence, grid and photoset galleries. Let the default function handle hero and thumbnail
	    switch ($type) {
			case 'sequence':  $id = '#aesop-gallery-'.esc_html( $unique )." .aesop-sequence-img-wrap"; break;
			case 'grid': $id = '#aesop-gallery-'.esc_html( $unique )." .aesop-grid-gallery-item"; break;
			case 'photoset': $id = '#aesop-gallery-'.esc_html( $unique )." .photoset-cell"; break;
			default: 
			    aesop_scroll_reveal_animation('gallery', $atts, $unique) ; return;
		}
	    
		switch ($atts['revealfx']) {
			case 'inplace':
				$revealcode[$unique] = "sr.reveal('".esc_html( $id )."', {origin:'bottom', distance: '0px', duration: 1000},200);";
				break;
			case 'inplaceslow':
				$revealcode[$unique] = "sr.reveal('".esc_html( $id )."', {origin:'bottom', distance: '0px', delay:500, duration: 1000},200);";
				break;
			case 'frombelow':
				$revealcode[$unique] = "sr.reveal('".esc_html( $id )."', {origin:'bottom', distance: '200px', duration: 1000},200);";
				break;
			case 'fromright':
				$revealcode[$unique] = "sr.reveal('".esc_html( $id )."', {origin:'right', distance: '400px', duration: 800},200);";
				break;
			case 'fromleft':
				$revealcode[$unique] = "sr.reveal('".esc_html( $id )."', {origin:'left', distance: '400px', duration: 800},200);";
				break;
		}
		?>
		
		<script>
		jQuery(document).ready(function(){
			if (!window.sr) {
			   window.sr = ScrollReveal();
			}
			<?php if ($type == 'sequence') { echo $revealcode[$unique]; }?>
		});
		</script>
		<?php
	}
}

/*
   Aesop reveal animation module
*/

class AesopRevealAnim {

	public function __construct(){
		
		define( 'PLUGIN_URL', plugins_url( '', __FILE__ ) );
		add_action('aesop_image_inside_top',array($this,'revealfx_image'),10,2);
		add_action('aesop_chapter_inside_top',array($this,'revealfx_chapter'),10,2);
		$theme = wp_get_theme();
		if (  $theme->get('Name')!='Longform' ) {
			// do not add quote filter for Longform theme
		   add_action('aesop_quote_inside_top',array($this,'revealfx_quote'),10,2);
	    } 
		
		add_action('aesop_video_inside_top',array($this,'revealfx_video'),10,2);
		add_action('aesop_cbox_inside_top',array($this,'revealfx_content'),10,2);
		add_action('aesop_character_inside_top',array($this,'revealfx_character'),10,2);
		add_action('aesop_gallery_inside_top',array($this,'revealfx_gallery'),10,4);
		add_action('aesop_parallax_inside_top',array($this,'revealfx_parallax'),10,2);
		add_action('aesop_collection_inside_top',array($this,'revealfx_collection'),10,2);
		
		
		add_filter( 'aesop_avail_components',   array( $this, 'options' ) );
		
	}



	public function revealfx_image($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			
			aesop_scroll_reveal_animation('image', $atts, $unique);
		}	
	}
	
	public function revealfx_video($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			
			aesop_scroll_reveal_animation('video', $atts, $unique);
		}	
	}
	
	public function revealfx_quote($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('quote', $atts, $unique);
		}	
	}
	
	public function revealfx_content($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('content', $atts, $unique);
		}	
	}
	
	public function revealfx_character($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('character', $atts, $unique);
		}	
	}

	public function revealfx_parallax($atts, $unique)
	{	
	    if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('parallax', $atts, $unique);
		}	
	}
	
	
	public function revealfx_chapter($atts, $unique)
	{	
		if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('chapter', $atts, $unique);
		}	
	}
	
	public function revealfx_gallery($type, $gallery_id, $atts, $unique)
	{	
		if (aesop_revealfx_set($atts) && $type != "stacked") {
			aesop_scroll_reveal_animation_gallery($type, $atts, $unique);
		}	
	}
	
	public function revealfx_collection($atts, $unique)
	{	
		if (aesop_revealfx_set($atts)) {
			aesop_scroll_reveal_animation('collection', $atts, $unique);
		}	
	}
	
	public function options( $shortcodes ) {
		$custom =  array(
						'type'  => 'select',
						'values'  => array(
						    array(
								'value' => 'off',
								'name' => __( 'Off', 'aesop-core' )
							),
							array(
								'value' => 'inplace',
								'name' => __( 'In Place', 'aesop-core' )
							),
							array(
								'value' => 'inplaceslow',
								'name' => __( 'In Place Slow', 'aesop-core' )
							),
							array(
								'value' => 'frombelow',
								'name' => __( 'From Below', 'aesop-core' )
							),
							array(
								'value' => 'fromleft',
								'name' => __( 'From Left', 'aesop-core' )
							),
							array(
								'value' => 'fromright',
								'name' => __( 'From Right', 'aesop-core' )
							)
							
						),
						'default'  => 'off',
						'desc'   => __( 'Reveal Effect', 'aesop-core' ),
						'tip'  => __( 'Animation effect when the component is revealed.', 'aesop-core' )
					
		);
	    $shortcodes['image']['atts']['revealfx'] = $custom ;
		$shortcodes['chapter']['atts']['revealfx'] = $custom ;
		$shortcodes['quote']['atts']['revealfx'] = $custom ;
		$shortcodes['video']['atts']['revealfx'] = $custom ;
		$shortcodes['content']['atts']['revealfx'] = $custom ;
		$shortcodes['character']['atts']['revealfx'] = $custom ;
		$shortcodes['collection']['atts']['revealfx'] = $custom ;
		$custom['tip'] = __( 'Animation effect when the component is revealed. Not applied to Parallax Gallery', 'aesop-core' );
		$shortcodes['gallery']['atts']['revealfx'] = $custom ;
		
		$custom['desc']=__( 'Overlay Reveal Effect', 'aesop-core' );
		$custom['tip']=__( 'Reveal animation effect for the overlay content.', 'aesop-core' );
		
		$shortcodes['image']['atts']['overlay_revealfx'] = $custom ;
		$shortcodes['chapter']['atts']['overlay_revealfx'] = $custom ;
		$shortcodes['video']['atts']['overlay_revealfx'] = $custom ;
		$custom['desc']=__( 'Floater Reveal Effect', 'aesop-core' );
		$custom['tip']=__( 'Reveal animation effect for the floater.', 'aesop-core' );
		$shortcodes['parallax']['atts']['overlay_revealfx'] = $custom ;
		$custom['tip']=__( 'Reveal animation effect for the content.', 'aesop-core' );
		$shortcodes['content']['atts']['overlay_revealfx'] = $custom ;
		$custom['tip']=__( 'Reveal animation effect for the overlay content. Only applied to Hero Gallery', 'aesop-core' );
		$shortcodes['gallery']['atts']['overlay_revealfx'] = $custom ;

		return $shortcodes;

	}

}



new AesopRevealAnim;

