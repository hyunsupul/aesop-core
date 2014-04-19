<?php

/**
 	* Creates a parallax component with background image, caption, lightbox, and optional "floater" item which can also be parallax, with multiple position and directions.
 	*
 	* @since    1.0.0
*/

if (!function_exists('aesop_parallax_shortcode')){

	function aesop_parallax_shortcode($atts, $content = null) {

		$defaults = array(
			'img' 				=> '',
			'height' 			=> 500,
			'parallaxbg' 		=> 'on',
			'floater' 			=> '',
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'floateroffset'		=> '',
			'caption'			=> '',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$placeholder = sprintf('%s', AI_CORE_URL.'/public/assets/img/grey.gif');
		$height = preg_replace('/[^0-9]/','',$atts['height']);

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (is_plugin_active('aesop-lazy-loader/aesop-lazy-loader.php')) {
       		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax aesop-lazy-img' : false;
			$style 		= sprintf('data-original="%s" style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$placeholder);
		} else {
			$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
			$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img']);
		}

		// custom classes
		$classes = function_exists('aesop_component_classes') ? aesop_component_classes( 'parallax', '' ) : null;

		ob_start();

		do_action('aesop_parallax_before'); //action

			?><div class="aesop-component aesop-parallax-component <?php echo $classes;?>"><?php

				do_action('aesop_parallax_inside_top'); // action

				// if parallax is on and we're not on mobile
				if ( 'on' == $atts['parallaxbg'] && !wp_is_mobile() ) { ?>
					<script>
						jQuery(document).ready(function(){
					   		jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-img').parallax({speed: 0.1});
					        var viewport = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?>').outerHeight();
		        			jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-img.is-parallax').css({'height': viewport * 1.65});

		        			<?php if ('on' == $atts['floater']) {?>
								var obj = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-floater');
						       	function scrollParallax(){
						       	    var floater = (jQuery(window).scrollTop() / jQuery(obj).data('speed')) - <?php echo absint(sanitize_text_field($atts['floateroffset']));?>;

						       	    <?php if ('left' == $atts['floaterdirection'] || 'right' == $atts['floaterdirection']){

										if ('left' == $atts['floaterdirection']){ ?>
						            		jQuery(obj).css({'transform':'translate3d(' + floater + 'px, 0px, 0px)'});
						            	<?php } else { ?>
											jQuery(obj).css({'transform':'translate3d(-' + floater + 'px, 0px, 0px)'});
						            	<?php }

						       	    } else {

						       	    	if ('up' == $atts['floaterdirection']){ ?>
						            		jQuery(obj).css({'transform':'translate3d(0px,' + floater + 'px, 0px)'});
										<?php } else { ?>
											jQuery(obj).css({'transform':'translate3d(0px,-' + floater + 'px, 0px)'});
										<?php }
						            } ?>
						       	}
						      	scrollParallax();
						        jQuery(window).scroll(function() {scrollParallax();});
						    <?php } ?>
						});
					</script>
				<?php } ?>
					<figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo $hash;?>" style="height:<?php echo $height;?>px;">

						<?php do_action('aesop_parallax_inner_inside_top'); //action ?>

						<?php if ('on' == $atts['floater']){?>
							<div class="aesop-parallax-sc-floater floater-<?php echo $atts['floaterposition'];?>" data-speed="10">
								<?php echo $atts['floatermedia'];?>
							</div>
						<?php } ?>

						<?php if ($atts['caption']){?>
							<figcaption class="aesop-parallax-sc-caption-wrap <?php echo $atts['captionposition'];?>">
								<?php echo $atts['caption'];?>
							</figcaption>
						<?php } ?>

						<?php if ( 'on' == $atts['lightbox']){?>
							<a class="aesop-lb-link aesop-lightbox" rel="lightbox" title="<?php echo $atts['caption'];?>" href="<?php echo $atts['img'];?>"><i class="aesopicon aesopicon-search-plus"></i></a>
						<?php } ?>

						<?php do_action('aesop_parallax_inner_inside_bottom'); //action ?>

						<div class="aesop-parallax-sc-img <?php echo $laxclass;?>" <?php echo $style;?>></div>
					</figure>

					<?php do_action('aesop_parallax_inside_bottom'); //action ?>

			</div>

		<?php do_action('aesop_parallax_after'); // action

		return ob_get_clean();
	}
}