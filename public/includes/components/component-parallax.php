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
			'floater' 			=> false,
			'floatermedia' 		=> '',
			'floaterposition' 	=> 'right',
			'floaterdirection'	=> 'up',
			'floateroffset'		=> 40,
			'caption'			=> '',
			'captionposition' 	=> 'bottom-left',
			'lightbox' 			=> false
		);

		$atts = apply_filters('aesop_parallax_defaults',shortcode_atts($defaults, $atts));

		$hash = rand();
		$laxclass 	= 'on' == $atts['parallaxbg'] ? 'is-parallax' : false;
		$style 		= sprintf('style="background-image:url(\'%s\');background-size:cover;"',$atts['img'],$atts['height']);

		ob_start();

		do_action('aesop_parallax_before');

			?><section class="aesop-component aesop-parallax-component" style="height:<?php echo $atts['height']?>px;"><?php

				do_action('aesop_parallax_inside_top'); // action

				// Call Parallax Method if Set
				if ('on' == $atts['parallaxbg']) { ?>
					<script>
						jQuery(document).ready(function(){
					   		jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-img').parallax({speed: 0.1});
					        var viewport = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?>').outerHeight();
		        			jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-img.is-parallax').css({'height': viewport * 1.65});

		        			<?php if ($atts['floatermedia']) {?>
								var obj = jQuery('.aesop-parallax-sc.aesop-parallax-sc-<?php echo $hash;?> .aesop-parallax-sc-floater');
						       	function scrollParallax(){
						       	    var floater = (jQuery(window).scrollTop() / jQuery(obj).data('speed')) - <?php echo $atts['floateroffset'];?>;

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
					<figure class="aesop-parallax-sc aesop-parallax-sc-<?php echo $hash;?>" style="height:<?php echo $atts['height'];?>px">

						<?php do_action('aesop_parallax_inner_inside_top'); //action ?>

						<?php if ($atts['floatermedia']){?>
							<div class="aesop-parallax-sc-floater floater-<?php echo $atts['floaterposition'];?>" data-speed="10">
								<?php echo $atts['floatermedia'];?>
							</div>
						<?php } ?>

						<?php if ($atts['caption']){?>
							<figcaption class="aesop-parallax-sc-caption-wrap <?php echo $atts['captionposition'];?>">
								<?php echo $atts['caption'];?>
							</figcaption>
						<?php } ?>

						<?php if ($atts['lightbox']){?>
							<a class="aesop-lb-link aesop-lightbox" rel="lightbox" title="<?php echo $atts['caption'];?>" href="<?php echo $atts['img'];?>"><i class="aesopicon aesopicon-search-plus"></i></a>
						<?php } ?>

						<?php do_action('aesop_parallax_inner_inside_bottom'); //action ?>

						<div class="aesop-parallax-sc-img <?php echo $laxclass;?>" <?php echo $style;?>></div>
					</figure>

					<?php do_action('aesop_parallax_inside_bottom'); //action ?>

			</section>

		<?php do_action('aesop_parallax_after'); // action

		return ob_get_clean();
	}
}