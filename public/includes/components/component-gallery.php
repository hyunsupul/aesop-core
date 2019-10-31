<?php
/**
 * Creates a multipurpose gallery that can be shown as thumbnail, grid, gridset, and with lightbox and captions
 *
 * @since    1.0.0
 */

use Aesop\Plugin\BackgroundImageStyle\ClassBackgroundImageStyle as BIS;

class AesopCoreGallery {

	function __construct() {

		add_shortcode( 'aesop_gallery',  array( $this, 'aesop_post_gallery' ) );
		
        // if gutenberg is active 
		if (  function_exists( 'register_block_type' ) ) {
			register_block_type( 'ase/gallery', array(
                'render_callback' => array( $this, 'aesop_post_gallery' )
			) );
		} 
		

	}

	/**
	 * Main gallery component
	 *
	 * @since    1.0.0
	 */
	public function aesop_post_gallery( $atts ) {

		global $post;
		
		

		// attributes
		$defaults  = array( 'id' => '', 'revealfx' => 'off', 'no_gallery' => 'off' );
		$atts   = apply_filters( 'aesop_gallery_defaults', shortcode_atts( $defaults, $atts, 'aesop_gallery' ));

		// gallery ID
		$gallery_id = isset( $atts['id'] ) ? (int) $atts['id'] : false;

		// alias to new atts type
		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique  = sprintf( '%s-%s', $gallery_id, $instance );

		// get gallery images and custom attrs
		$image_ids  = get_post_meta( $gallery_id, '_ase_gallery_images', true );
		$image_ids = array_map( 'intval', explode( ',', $image_ids ) );

		$type   = get_post_meta( $gallery_id, 'aesop_gallery_type', true );
		$width   = get_post_meta( $gallery_id, 'aesop_gallery_width', true );

		// gallery caption
		$gallery_caption = get_post_meta( $gallery_id, 'aesop_gallery_caption', true );

		// custom classes
		$classes = aesop_component_classes( 'gallery', '' );

		ob_start();

		do_action( 'aesop_gallery_before', $type, $gallery_id, $atts, $unique ); // action
		
		$hidden ="";
		if (aesop_revealfx_set($atts) && $type != 'stacked') {
			$hidden ='style="visibility:hidden;"';
		}

		?><div id="aesop-gallery-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'gallery', $gallery_id, $atts );?> class="aesop-component aesop-gallery-component aesop-<?php echo esc_attr( $type );?>-gallery-wrap <?php echo sanitize_html_class( $classes );?> <?php if ( empty( $gallery_id ) ) { echo 'empty-gallery'; }?>  " <?php echo $hidden;?>><?php

		do_action( 'aesop_gallery_inside_top', $type, $gallery_id, $atts, $unique ); // action
		
		$image_ids = apply_filters( 'aesop_gallery_image_ids', $image_ids );

        // new
        $bool_custom = false;
        $arr_args = array(
            'atts'    => $atts,
            'type'    => $type,
            'gallery_id'   => $gallery_id,
            'image_ids'    => $image_ids,
            'instance' => $instance,
            'width' => $width,
            'unique'  => $unique
        );
        $bool_custom = apply_filters('aesop_gallery_custom_view', $bool_custom, $arr_args);
		

		if ( ! empty( $image_ids ) && $atts['no_gallery'] != 'on' && $bool_custom === false ) {

			switch ( $type ) {
				case 'thumbnail':
					$this->aesop_thumb_gallery( $gallery_id, $image_ids, $width );
					break;
				case 'grid':
					$this->aesop_grid_gallery( $gallery_id, $image_ids, $width,$unique );
					break;
				case 'stacked':
					$this->aesop_stacked_gallery( $gallery_id, $image_ids, $unique );
					break;
				case 'sequence':
					$this->aesop_sequence_gallery( $gallery_id, $image_ids, $unique);
					break;
				case 'photoset':
					$this->aesop_photoset_gallery( $gallery_id, $image_ids, $width, $unique);
					break;
				case 'hero':
					$this->aesop_hero_gallery( $gallery_id, $image_ids, $width );
					break;
				case 'horizontal':
					$this->aesop_horizontal_gallery( $gallery_id, $image_ids, $unique);
					break;
				default:
					$this->aesop_grid_gallery( $gallery_id, $image_ids, $width, $unique);
					break;
			}

			if ( $gallery_caption ) {
				printf( '<p class="aesop-component-caption">%s</p>', $gallery_caption );
			}

			// provide the edit link to the backend edit if Aesop Editor is not active

			if ( ! function_exists( 'lasso_editor_components' ) && is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) {

				$url = admin_url( 'post.php?post='.$gallery_id.'&action=edit' );
				$edit_gallery = __( 'edit gallery', 'aesop-core' );
				printf( '<a class="aesop-gallery-edit aesop-content" href="%s" target="_blank" title="%s">(%s)</a>', $url, $edit_gallery, $edit_gallery );
			}
		}//end if

		if ( empty( $gallery_id ) && is_user_logged_in() && current_user_can( 'edit_post', get_the_ID() ) ) {

			if ( function_exists( 'lasso_editor_components' ) ) {

				?><div contenteditable="false" class="lasso--empty-component"><?php
				_e( 'Setup a gallery by clicking the <span class="lasso-icon-gear"></span> icon above.', 'aesop-core' );
				?></div><?php

			} else {

				?><div class="aesop-error aesop-content"><?php
				_e( 'This gallery is empty! It\'s also possible that you simply have the wrong gallery ID.', 'aesop-core' );
				?></div><?php

			}
		}

		do_action( 'aesop_gallery_inside_bottom', $type, $gallery_id, $atts, $unique ); // action

		?></div><?php

		do_action( 'aesop_gallery_after', $type, $gallery_id, $atts, $unique ); // action

		return ob_get_clean();

	}

	/**
	 * Draws a thumbnail gallery using fotorama
	 *
	 * @since    1.0.0
	 */
	public function aesop_thumb_gallery( $gallery_id, $image_ids, $width ) {
	    global $is_edge;

		$thumbs  = get_post_meta( $gallery_id, 'aesop_thumb_gallery_hide_thumbs', true ) ? sprintf( 'data-nav=false' ) : sprintf( 'data-nav=thumbs' );
		$trans_speed = intval(get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true ));
		$autoplay  = $trans_speed ? sprintf( 'data-autoplay=%s', $trans_speed ) : null;
		$lazy_load  = get_post_meta( $gallery_id, 'aesop_gallery_lazy_load', true );
		
		$transition = get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true ) ? get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true ) : 'crossfade';

		// image size
		$size    = apply_filters( 'aesop_thumb_gallery_size', 'full' );
		$fullscreen = $is_edge ? "true" : "native";

		?><div id="aesop-thumb-gallery-<?php echo esc_attr( $gallery_id );?>" class="fotorama" 	data-transition="<?php echo esc_attr( $transition );?>"
																			data-width="<?php echo esc_attr( $width );?>"
																			<?php echo esc_attr( $autoplay );?>
																			data-keyboard="true"
																			<?php echo esc_attr( $thumbs );?>
																			data-allow-full-screen="<?php echo $fullscreen; ?>"
																			data-click="true"><?php

		foreach ( $image_ids as $image_id ):

			$full    = wp_get_attachment_image_src( $image_id, $size, false );
		$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		$caption  = get_post( $image_id )->post_excerpt;

		    if ( $lazy_load ) {
				?><a href="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>"></a><?php
            } else {
			    ?><img src="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>"><?php
            }

		endforeach;

		?></div><?php
	}

	/**
	 * Draws a grid style gallery using wookmark
	 *
	 * @since    1.0.0
	 */
	public function aesop_grid_gallery( $gallery_id, $image_ids, $width, $unique) {

		$gridwidth  = get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) ? get_post_meta( $gallery_id, 'aesop_grid_gallery_width', true ) : 400;
		$aesop_lightbox_text = get_post_meta( $gallery_id, 'aesop_lightbox_text', true ) ? get_post_meta( $gallery_id, 'aesop_lightbox_text', true ) : 'title';
		

		// allow theme developers to determine the spacing between grid items
		$space = apply_filters( 'aesop_grid_gallery_spacing', 5 );

?>
		<!-- Aesop Grid Gallery -->
		<script>
		
		
			jQuery(document).ready(function($){
			    $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>').imagesLoaded(function() {
			        var options = {
			          	autoResize: true,
			          	container: $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>'),
			          	offset: <?php echo (int) $space;?>,
			          	flexibleWidth: <?php echo (int) $gridwidth;?>
			        };
			        var handler = $('#aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?> li');
			        handler.wookmark(options);
					$('aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>').attr('id','the_new_id');
					$(window).trigger("lookup2");
					<?php 
					global $revealcode;
					if ($revealcode[$unique]) { echo $revealcode[$unique];}
					?>
					
			    });
			});
		</script>
		<?php
		
		if (class_exists( 'AesopLazyLoader' )) {
			?>
		<script>
		    ;(function($) {

			  $.fn.unveil2 = function(threshold) {

				var $w = $(window),
					th = threshold || 0,
					images = this,
					loaded;

				this.one("unveil2", function() {
					this.setAttribute("style", "opacity:1");

				});

				function unveil2() {
				  var inview = images.filter(function() {
					var $e = $(this);
					if ($e.is(":hidden")) return;

					var wt = $w.scrollTop(),
						wb = wt + $w.height(),
						et = $e.offset().top,
						eb = et + $e.height();

					return eb >= wt - th && et <= wb + th;
				  });

				  loaded = inview.trigger("unveil2");
				  images = images.not(loaded);
				}

				$w.on("scroll.unveil2 resize.unveil2 lookup2.unveil2", unveil2);

				unveil2();

				return this;

			  };

			})(window.jQuery || window.Zepto);
			
			jQuery(document).ready(function($){
				$('.aesop-lazy-img2').unveil2(0,function() {
				  	$(this).on('load',function() {
				    	this.style.opacity = 1;
				  	});
				});
			});
			
		</script>
		<?php
		
		}
		?>
		
		<div id="aesop-grid-gallery-<?php echo esc_attr( $gallery_id );?>" class="aesop-grid-gallery aesop-grid-gallery" style="width:100%;max-width:<?php echo esc_attr( $width );?>;margin:0 auto;"><ul><?php

		foreach ( $image_ids as $image_id ):

			$getimage   = wp_get_attachment_image( $image_id, 'aesop-grid-image', false, array( 'class' => 'aesop-grid-image' ) );
			$img = get_post( $image_id );
			$caption   = $img->post_excerpt;
			$img_title     = $img->post_title;
			$lightbox_text = "";
			switch ($aesop_lightbox_text) {
				case 'title': $lightbox_text = $img_title;break;	
				case 'caption': $lightbox_text = $caption;break;
				case 'title_caption': $lightbox_text = $img_title."<br>".$caption;break;
				case 'description': $lightbox_text = $img->post_content;break;
			}
			$getimagesrc    = wp_get_attachment_image_src( $image_id, 'full' );	
			if (class_exists( 'AesopLazyLoader' )) {
			    $getimagesrc2    = wp_get_attachment_image_src( $image_id, 'aesop-grid-image' );
				$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';
				$getimage = sprintf( '<img src="%s" data-src="%s" class="aesop-grid-image aesop-lazy-img2" width="%s" height="%s" style="opacity:0;" >', 
				                        esc_url( $getimagesrc2[0] ), esc_url( $getimagesrc2[0] ),
									  $getimagesrc2[1],$getimagesrc2[2] );
			}
?>

				<li class="aesop-grid-gallery-item">
					<a class="aesop-lightbox" href="<?php echo esc_url( $getimagesrc[0] );?>" title="<?php echo $lightbox_text;?>">
						<?php if ( $caption ) { ?>
							<span class="aesop-grid-gallery-caption"><?php echo aesop_component_media_filter( $caption );?></span>
						<?php } ?>
						<span class="clearfix"><?php echo $getimage;?></span>
						
					</a>
				</li>

				<?php

		endforeach;
		//exit(0);

		?></ul></div><?php
	}

	/**
	 * Draws a stacked parallax style gallery
	 *
	 * @since    1.0.0
	 * @param string $unique
	 */
	public function aesop_stacked_gallery( $gallery_id, $image_ids, $unique ) {

		/**
		 * AMP Plugin compatability. Checks to see if we're at an AMP
		 * endpoint and, if so, output <img> instead of <div> with
		 * `background-image`.
		 * Note that the AMP spec calls for <amp-img> instead of <img>,
		 * but output <img> here and rely on the AMP plugin to replace
		 * the tags properly.
		 * @link https://wordpress.org/plugins/amp/
		 * @link https://www.ampproject.org/docs/reference/spec.html
		 */
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {

			$size    = apply_filters( 'aesop_stacked_gallery_size', 'full' );

			foreach ( $image_ids as $image_id ):
				$full     = wp_get_attachment_image_src( $image_id, $size, false );
				$caption	= get_post( $image_id )->post_excerpt;
				$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
				?>

				<div class="aesop-stacked-img">
					<img src="<?php echo esc_url( $full[0] );?>" alt="<?php echo esc_attr( $alt );?>">
					<?php if ( $caption ) { ?>
						<div class="aesop-stacked-caption"><?php echo aesop_component_media_filter( $caption );?></div>
					<?php } ?>
				</div>

				<?php
			endforeach;

		} else {
			if (!wp_is_mobile()) {
				
				// image size
				$size    = apply_filters( 'aesop_stacked_gallery_size', 'full' );
				
				?>
				<!-- Aesop Stacked Gallery Desktop -->
				<script>

						jQuery(document).ready(function($){

							var stackedResizer = function(){
								$('.aesop-stacked-img').css({'height':($(window).height())+'px'});
							}
							stackedResizer();

							$(window).resize(function(){
								stackedResizer();
							});
						});

				</script>
				<?php
				$stacked_styles = 'background-size:100%;background-position:center center';
				$styles = apply_filters( 'aesop_stacked_gallery_styles_'.$unique, $stacked_styles );

                $new_bis = new BIS(); //ClassBackgroundImageStyle


                foreach ( $image_ids as $image_id ):

					$full      = wp_get_attachment_image_src( $image_id, $size, false );
					$caption   = get_post( $image_id )->post_excerpt;

                    $new_bis->setAttachmentID($image_id);
                    $new_bis->setSelector( 'aesop-stacked-img-' . $image_id );
                    $arr_push_size = array(
                            'pushXS' => 'medium_large',
                            'pushMD' => 'aesop-cover-img',
                            'pushXL' => 'full'
                    );
                    // TODO - put a filter right here.
                    foreach ( $arr_push_size as $str_method => $str_size){
                        if ( method_exists($new_bis, $str_method)){
                            $new_bis->$str_method( $str_size );
                        }
                    }
                    // note the added id= in the div below. and the background image (in style="background-image ...") has been removed

					?>
								<div id="aesop-stacked-img-<?php echo esc_attr($image_id) ?>" class="aesop-stacked-img" style="Xbackground-image:url('<?php echo esc_url( $full[0] );?>');<?php echo $styles;?>">
									<?php if ( $caption ) { ?>
										<div class="aesop-stacked-caption"><?php echo aesop_component_media_filter( $caption );?></div>
									<?php } ?>
								</div>
								<?php

                    $new_bis->setReset();

				endforeach;

                $new_bis->getStyle( true );

			} else {
				$size    = apply_filters( 'aesop_sequence_gallery_size', 'large' );
				$mobile_panorama = get_post_meta( $gallery_id, 'aesop_parallax_gallery_mobile_panorama', true );
				if (!$mobile_panorama) {
					foreach ( $image_ids as $image_id ):

						$img     = wp_get_attachment_image_src( $image_id, $size, false, '' );
						$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
						$caption = get_post( $image_id )->post_excerpt;

						// lazy loading disabled for now
						//$lazy   = class_exists( 'AesopLazyLoader' ) ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"', $lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );
						$lazy = sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

						?>
						<figure class="aesop-sequence-img-wrap">

							<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">

							<?php if ( $caption ) { ?>
								<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
							<?php } ?>

						</figure>
						<?php

					endforeach;
				} else {
					wp_enqueue_script( 'aesop-paver', AI_CORE_URL.'/public/assets/js/jquery.paver.min.js', array( 'ai-core' ) );
					add_action( 'wp_footer', aesop_panorama, 20 );?>
					
					<?php
					foreach ( $image_ids as $image_id ):

						$full      = wp_get_attachment_image_src( $image_id, 'full', false );
						$caption   = get_post( $image_id )->post_excerpt;

					?>
						<div class="aesop-panorama" >
						      <img src="<?php echo $full[0];?>" alt="<?php echo esc_attr( $alt );?>">
							  <?php if ( $caption ) { ?>
								 <div class="aesop-stacked-caption"><?php echo aesop_component_media_filter( $caption );?></div>
							  <?php } ?>
								
						</div>
						<?php

					endforeach;
				}
			}

			
		}
	}

	/**
	 * Draws a gallery with images in sequential order
	 *
	 * @since    1.0.0
	 */
	public function aesop_sequence_gallery($gallery_id, $image_ids, $unique) {

		// image size
		$size    = apply_filters( 'aesop_sequence_gallery_size', 'large' );

		// lazy loader class
		$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';
		
		$sequence_panorama = get_post_meta( $gallery_id, 'aesop_sequence_gallery_panorama', true );;
		if ($sequence_panorama) {
			$size    = apply_filters( 'aesop_sequence_gallery_size', 'full' );
			$sequence_panorama_height = 500;
			$sequence_panorama_height = get_post_meta( $gallery_id, 'aesop_sequence_gallery_panorama_height', true );;
			wp_enqueue_script( 'aesop-paver', AI_CORE_URL.'/public/assets/js/jquery.paver.min.js', array( 'ai-core' ) );
			add_action( 'wp_footer', aesop_panorama, 20 );
		}

		foreach ( $image_ids as $image_id ):

			$img     = wp_get_attachment_image_src( $image_id, $size, false, '' );
			$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$caption = get_post( $image_id )->post_excerpt;

			// lazy loading disabled for now
			//$lazy   = class_exists( 'AesopLazyLoader' ) ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"', $lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );
			$lazy = sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

			if (!$sequence_panorama) {
?>
           	<figure class="aesop-sequence-img-wrap">

           		<img <?php echo $lazy;?> alt="<?php echo esc_attr( $alt );?>">

           		<?php if ( $caption ) { ?>
           			<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
           		<?php } ?>

           	</figure>
           	<?php
			} else { ?>
				<div class="aesop-panorama" style="height:<?php echo $sequence_panorama_height;?>px;">
					<img src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $alt );?>">
					<?php if ( $caption ) { ?>
						<figcaption class="aesop-content aesop-component-caption aesop-sequence-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
					<?php } ?>
								
				</div>
			<?php
			}

		endforeach;

	}
	
	/**
	 * Gallery that scrolls horizontally as you scroll down
	 *
	 * @since    
	 */
	public function aesop_horizontal_gallery($gallery_id, $image_ids, $unique) {

		$direction= get_post_meta( $gallery_id, 'aesop_horizontal_gallery_direction', true ) ? get_post_meta( $gallery_id, 'aesop_horizontal_gallery_direction', true) : false;
		$behavior= get_post_meta( $gallery_id, 'aesop_horizontal_gallery_behavior', true ) ? get_post_meta( $gallery_id, 'aesop_horizontal_gallery_behavior', true) : false;
		// image size
		$size    = apply_filters( 'aesop_sequence_gallery_size', 'large' );
		
		$float = "left";
		if ($direction=='lefttoright') {
			$float = 'right';
		}

		// lazy loader class
		$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';
		
		$c = count($image_ids);
		
		?>
		
		<figure class="aesop-horizontal-gallery" id="aesop-horizontal-gallery-<?php echo esc_attr( $unique );?>" style="height:300vh;">
		    <div id="aesop-horizontal-gallery-row-wrapper-<?php echo esc_attr( $unique );?>" class="aesop-horizontal-gallery-row-wrapper" style="width:100%;height:100vh;position:sticky;position:-webkit-sticky;top:0;">

			  <div id="aesop-horizontal-gallery-row-<?php echo esc_attr( $unique );?>" class="aesop-horizontal-gallery-row" style="position:absolute;width:<?php echo $c;?>00vw;height:100vh;<?php if ($direction=='lefttoright') {echo 'right:0px;';}?>">
			  <script>
			jQuery(document).ready(function($){

				const obj = document.querySelector('#aesop-horizontal-gallery-<?php echo esc_attr( $unique );?>');
				const obj2 = document.querySelector('#aesop-horizontal-gallery-row-<?php echo esc_attr( $unique );?>');
				const imgWidth = obj2.getBoundingClientRect().width/<?php echo $c;?>;
				const objTop = obj.style.top;		
				const maxScrollX = obj2.getBoundingClientRect().width- obj.getBoundingClientRect().width + (imgWidth/2);
				
				obj.style.height = (obj2.getBoundingClientRect().width+ (imgWidth)) +"px";
				

				document.addEventListener('scroll', () => {
					var rect = obj.getBoundingClientRect();
					var scrollY = 0;
					var scrollX = 0;
					 
					if (rect.top<0) {
						if (-rect.top>=maxScrollX) {
							scrollX = -maxScrollX+(imgWidth/2);;
						} else if (-rect.top<=(imgWidth/2)) {
							scrollX = 0;
						} else {
							scrollX =rect.top+(imgWidth/2);
						}
						scrollY = rect.top;
						<?php
						if ($direction=='lefttoright') {
						?>
							obj2.style.right = scrollX+"px";
						<?php 
						} else {?>
							obj2.style.left = scrollX+"px";
						<?php 
						}?>
						//obj2.style.top = objTop-scrollY+"px";
					}			
				});
			}); // end jquery doc ready
				
			</script>
		<?php
		foreach ( $image_ids as $image_id ):

			$img     = wp_get_attachment_image_src( $image_id, $size, false, '' );
			$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$caption = get_post( $image_id )->post_excerpt;

			// lazy loading disabled for now
			//$lazy   = class_exists( 'AesopLazyLoader' ) ? sprintf( 'src="%s" data-src="%s" class="aesop-sequence-img aesop-lazy-img"', $lazy_holder, esc_url( $img[0] ) ) : sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );
			$lazy = sprintf( 'src="%s" class="aesop-sequence-img" ', esc_url( $img[0] ) );

			?>
			     <div class = "aesop-horizontal-gallery-image" style="background-image:url('<?php echo esc_url( $img[0] );?>');<?php if ($behavior=='parallax') {echo 'background-attachment:fixed;';}?>;background-size:cover;height:100vh;width:100vw;display: inline-block;float: <?php echo $float;?>;">
				 <?php if ( $caption ) { ?>
						<figcaption class="aesop-content aesop-component-caption"><?php echo aesop_component_media_filter( $caption );?></figcaption>
				 <?php } ?>
				 </div>
				 
			<?php

		endforeach;
		?>
			</div>
		  </div>
		  <div style="height:100vh;">
		  </div>
		</figure>
		
		<?php

	}

	/**
	 * Draws a photoset style gallery
	 *
	 * @since    1.0.9
	 */
	public function aesop_photoset_gallery( $gallery_id, $image_ids, $width, $unique) {

		// allow theme developers to determine the spacing between grid items
		$space  = apply_filters( 'aesop_grid_gallery_spacing', 5 );

		// layout
		$layout = get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) ? get_post_meta( $gallery_id, 'aesop_photoset_gallery_layout', true ) : '';

		$style  = $width ? sprintf( 'style="max-width:%s;margin-left:auto;margin-right:auto;"', esc_attr( $width ) ) : null;

		// lightbox
		$lightbox = get_post_meta( $gallery_id, 'aesop_photoset_gallery_lightbox', true );
		$aesop_lightbox_text = get_post_meta( $gallery_id, 'aesop_lightbox_text', true ) ? get_post_meta( $gallery_id, 'aesop_lightbox_text', true ) : 'title';

		// image size
		$size    = apply_filters( 'aesop_photoset_gallery_size', 'large' );

?>
		<!-- Aesop Photoset Gallery -->
		<script>
			jQuery(window).on('load',function(){
				jQuery('.aesop-gallery-photoset').photosetGrid({
				  	gutter: "<?php echo absint( $space ).'px';?>",
				  	<?php if ( $lightbox ) { ?>
				  	highresLinks:true,
				  	<?php } ?>
				  	onComplete: function(){

				  		<?php if ( $lightbox ) { ?>
							jQuery('.aesop-gallery-photoset a').addClass('aesop-lightbox').prepend('<i class="dashicons dashicons-search"></i>');

				  		<?php } ?>

					   	 	jQuery('.aesop-gallery-photoset').attr('style', '');
					    	jQuery(".photoset-cell img").each(function(){

							caption = jQuery(this).attr('data-caption');

							if ( caption) {
								
								title = jQuery(this).attr('data-title');
								lbtitle = jQuery(this).attr('title');
								jQuery(this).after('<span class="aesop-photoset-caption"><span class="aesop-photoset-caption-title">' + title + '</span><span class="aesop-photoset-caption-caption">' + caption +'</span></span>');
								jQuery('.aesop-photoset-caption').hide().fadeIn();

								jQuery(this).closest('a').attr('title',lbtitle);
							}
							<?php 
							global $revealcode;
							if ($revealcode[$unique]) { echo $revealcode[$unique];}
							 ?>
						});
					}
				});
			});
		</script>

		<?php if ( $style !== null ) { echo '<div class="aesop-gallery-photoset-width" '.$style.' >'; }

		?><div class="aesop-gallery-photoset" data-layout="<?php echo absint( $layout );?>" ><?php

		foreach ( $image_ids as $image_id ) {

			$full     = wp_get_attachment_image_src( $image_id, $size, false );
			$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$img = get_post( $image_id );
			$caption    = $img->post_excerpt;
			$title     = $img->post_title;
			$lightbox_text = "";
			switch ($aesop_lightbox_text) {
				case 'title': $lightbox_text = $title;break;	
				case 'caption': $lightbox_text = $caption;break;
				case 'title_caption': $lightbox_text = $title."<br>".$caption;break;
				case 'description': $lightbox_text = $img->post_content;break;
			}

			$lb_link = $lightbox ? sprintf('href="%s" title="%s"', esc_url( $full[0] ), esc_attr($lightbox_text)) : null;

			if (class_exists( 'AesopLazyLoader' )) {
				$lazy_holder = AI_CORE_URL.'/public/assets/img/aesop-lazy-holder.png';
				$lazy = sprintf( 'src="%s" data-src="%s" class="aesop-lazy-img"', $lazy_holder, esc_url( $full[0] ) );
				?><img <?php echo $lazy;?> <?php echo $lb_link;?>  data-caption="<?php echo esc_attr( $caption );?>" data-title="<?php echo esc_attr( $title );?>" alt="<?php echo esc_attr( $alt );?>"><?php
			} else {
				?><img src="<?php echo esc_url( $full[0] );?>" <?php echo $lb_link;?> data-caption="<?php echo esc_attr( $caption );?>" data-title="<?php echo esc_attr( $title );?>" alt="<?php echo esc_attr( $alt );?>"><?php
			}

		}

		?></div><?php

		if ( $style !== null ) { echo '</div>'; }

	}

	/**
	 * Draws a hero gallery using fotorama
	 *
	 * @since    1.0.0
	 */
	public function aesop_hero_gallery( $gallery_id, $image_ids, $width ) {

	    $trans = get_post_meta( $gallery_id, 'aesop_hero_gallery_transition', true );
	    $trans_speed = get_post_meta( $gallery_id, 'aesop_hero_gallery_transition_speed', true );
		$trans_anim_speed = get_post_meta( $gallery_id, 'aesop_hero_gallery_transition_anim_speed', true );
		// if hero option is not set use the thumb gallery option
		$trans = $trans ? $trans : get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition', true );
		$trans_speed = $trans_speed ? $trans_speed : get_post_meta( $gallery_id, 'aesop_thumb_gallery_transition_speed', true );
		$trans_speed = $trans_speed ? $trans_speed : 3000;
		$trans_anim_speed = $trans_anim_speed ? $trans_anim_speed : 1200;
		$autoplay  = sprintf( 'data-autoplay=%s', $trans_speed, true );
		$transition = $trans ? $trans : 'crossfade';
		$content = get_post_meta( $gallery_id, 'aesop_hero_gallery_content', true ) ? get_post_meta( $gallery_id, 'aesop_hero_gallery_content', true) : '';
		$height = get_post_meta( $gallery_id, 'aesop_hero_gallery_height', true ) ? get_post_meta( $gallery_id, 'aesop_hero_gallery_height', true) : '';
		$enable_nav = get_post_meta( $gallery_id, 'aesop_hero_gallery_enable_nav', true ) ? get_post_meta( $gallery_id, 'aesop_hero_gallery_enable_nav', true) : false;
		$enable_full = get_post_meta( $gallery_id, 'aesop_hero_gallery_enable_full', true ) ? get_post_meta( $gallery_id, 'aesop_hero_gallery_enable_full', true) : false;
		$image_text_op = get_post_meta( $gallery_id, 'aesop_hero_image_text', true ) ? get_post_meta( $gallery_id, 'aesop_hero_image_text', true) : false;

		// image size
		$size    = apply_filters( 'aesop_thumb_gallery_size', 'full' );

		if (empty($width)) {
			$width = "100%";
		}
		if (empty($height)) {
			$height = "100%";
		} else {
			if (strpos($height, '/') !== FALSE)
			{
			   $ratio = 'data-ratio="'.$height.'"';
			   $height ="";
			}
		}
		?>
		<div class="aesop-hero-gallery-wrapper">
		<div id="aesop-hero-gallery-<?php echo esc_attr( $gallery_id );?>" class="fotorama" 	data-transition="<?php echo esc_attr( $transition );?>"
																			data-width="<?php echo esc_attr( $width );?>"
																			data-height="<?php echo esc_attr( $height );?>"
																			<?php
                                                                            if ( isset($ratio)) {
                                                                                echo  $ratio ;
                                                                            }?>
																			<?php echo esc_attr( $autoplay );?>
																			data-keyboard="false"
																			data-click="false"
																			data-fit="cover"
																			data-captions="true"
																			data-stopautoplayontouch="false"
																			<?php if ($enable_nav) {?>
																			data-nav="dots"
																			data-arrows="true"
																			data-swipe="true"
																			<?php }else {?>
																			data-nav=false
																			data-arrows="false"
																			data-swipe="false"
																			<?php }?>
																			
																			<?php if ($enable_full) {?>
																			data-allow-full-screen="true"
																			<?php }?>
																			
																			data-transitionduration="<?php echo esc_attr( $trans_anim_speed );?>"
																			><?php

		foreach ( $image_ids as $image_id ):

			$full    = wp_get_attachment_image_src( $image_id, $size, false );
			$alt     = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
			$img = get_post( $image_id );
			$caption  = $img->post_excerpt;
			$image_text = "";
			 
			if ($image_text_op && $image_text_op != 'none') {
			 
				switch ($image_text_op) {
					case 'title': $image_text = $img->post_title;break;	
					case 'caption': $image_text = $caption;break;
					case 'title_caption': $image_text = $img->post_title."<br>".$caption;break;
					case 'description': $image_text = $img->post_content;break;
				}
				?>
				<div data-img="<?php echo esc_url( $full[0] );?>" data-caption="<?php echo esc_attr( $caption );?>" style="display:block;">
				  <div class="aesop-hero-gallery-content"><?php echo $image_text;?></div>
				</div>
			 <?php
			} else {
			    ?>
			    <img src="<?php echo esc_url( $full[0] );?>"  srcset="<?php echo wp_get_attachment_image_srcset( $image_id );?>" data-caption="<?php echo esc_attr( $caption );?>" alt="<?php echo esc_attr( $alt );?>">
			   <?php
			}
		endforeach;

		?>
		</div>

		<div class="aesop-hero-gallery-content">
			<?php echo $content; ?>
		</div>

		</div><?php
	}


}

new AesopCoreGallery;
