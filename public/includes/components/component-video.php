<?php
/**
 * Responsive video component with full width settings
 *
 * @since    1.0.0
 */
if ( ! function_exists( 'aesop_video_shortcode' ) ) {
	function aesop_video_shortcode( $atts ) {

		// let this be used multiple times
		static $instance = 0;
		$instance++;
		$unique = sprintf( '%s-%s', get_the_ID(), $instance );
		$defaults = array(
			'width'  	=> '100%',
			'align'  	=> 'center',
			'src'   	=> 'youtube',
			'hosted'  	=> '',
			'id'  		=> '',
			'disable_for_mobile'  => 'on',
			'loop'  	=> 'on',
			'autoplay' 	=> 'on',
			'controls' 	=> 'off',
			'viewstart' => 'off',
			'viewend'   => 'off',
			'caption'  	=> '',
			'overlay_content'   => '',
			'vidwidth'  => '',
			'vidheight' => '',
			'poster_frame' =>'',
			'mute' =>'off',
			'inside_chapter' => '',    // this is meant to be only turned on when the Chapter Component uses it for video background.
			'force_fullwidth'=>'off',
			'revealfx'  => '',
			'overlay_revealfx'          => ''
		);
		$atts = apply_filters( 'aesop_video_defaults', shortcode_atts( $defaults, $atts, 'aesop_video' ) );

		$contentwidth = 'content' == $atts['width'] ? 'aesop-content' : false;

		$widthstyle = $atts['width'] && 'center' !== $atts['align'] ? sprintf( 'style=width:%s;', $atts['width'] ) : sprintf( 'style=max-width:%s;', $atts['width'] );

		// width constraint class if
		$caption = !empty( $atts['caption'] ) ? sprintf( '<div class="aesop-video-component-caption aesop-component-align-%s" %s>%s</div>', $atts['align'], $widthstyle, $atts['caption'] ) : false;

		if ( 'vine' == $atts['src'] || 'instagram' == $atts['src'] ) {
			$vineStagramClass = 'aesop-vine-stagram-container';
			$vineStagramAlign = $atts['align'] ? sprintf( 'aesop-vine-stagram-container-%s', $atts['align'] ) : false;
		} else {
			$vineStagramAlign = null;
			$vineStagramClass = null;
		}

		$loopstatus  = 'on' == $atts['loop'] ? true : false;
		$inside_chapter = 'on' == $atts['inside_chapter'] ? true : false;
		$mute  = 'on' == $atts['mute'] || ($inside_chapter && $atts['src'] != 'self') ? true : false;
		$autoplaystatus = 'on' == $atts['autoplay'] ? true : false;
		$disable_for_mobile = 'on' == $atts['disable_for_mobile'] ? true : false;
		$controlstatus = 'on' == $atts['controls'] ? 'controls-visible' : 'controls-hidden';
		$iframe_height = $atts['vidheight'] ? sprintf( 'height="%s"', preg_replace( '/[^0-9]/', '', $atts['vidheight'] ) ) : sprintf( 'height=""' );
		$iframe_width = $atts['vidwidth'] ? sprintf( 'width="%s"', preg_replace( '/[^0-9]/', '', $atts['vidwidth'] ) ) : sprintf( 'width=""' );
		$iframe_size = sprintf( '%s %s' , $iframe_height, $iframe_width );

		// custom classes
		$classes = function_exists( 'aesop_component_classes' ) ? aesop_component_classes( 'video', '' ) : null;

		// waypoint filter
		$point   = 'bottom-in-view';
		$waypoint  = apply_filters( 'aesop_video_component_waypoint', $point, $unique );
		if ( 'on' == $atts['viewstart'] || wp_is_mobile()) { 
			$autoplaystatus = false;
		}

		ob_start();


		do_action( 'aesop_video_before', $atts, $unique ); // action
?>
	    <div id="aesop-video-<?php echo esc_attr( $unique );?>" <?php echo aesop_component_data_atts( 'video', $unique, $atts );?> class="aesop-component aesop-video-component aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> <?php echo sanitize_html_class( $classes );?> <?php echo sanitize_html_class( $controlstatus );?> <?php echo sanitize_html_class( $contentwidth );?> <?php echo sanitize_html_class( $vineStagramClass );?> <?php echo sanitize_html_class( $vineStagramAlign );?>"
		    <?php echo aesop_revealfx_set($atts) ? 'style="visibility:hidden;"': null ?>
		>

	    	<?php do_action( 'aesop_video_inside_top', $atts, $unique ); // action
        // new
        $bool_custom = false;
        $arr_args    = [
            'atts'    => $atts,
            'autoplaystatus' => $autoplaystatus,
            'classes' => $classes,
            'controlstatus' => $controlstatus,
            'disable_for_mobile' => $disable_for_mobile,
            'iframe_height' => $iframe_height,
            'iframe_size' => $iframe_size,
            'iframe_width' => $iframe_width,
            'inside_chapter' => $inside_chapter,
            'instance' => $instance,
            'loopstatus' => $loopstatus,
            'mute' => $mute,
            'point' => $point,
            'unique'  => $unique,
            'waypoint' => $waypoint
        ];
        $bool_custom = apply_filters( 'aesop_video_custom_view', $bool_custom, $arr_args );

        if ( $bool_custom === false ) {

        ?>

	    	<div class="aesop-video-container aesop-video-container-<?php echo esc_attr( $unique );?> aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> <?php echo sanitize_html_class( $atts['src'] );?>" <?php echo $widthstyle;?> >

			<?php
			if ($disable_for_mobile && wp_is_mobile() && $atts['poster_frame']!=='' ) {
				// disable video for mobile
					$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-lazy-img"', $lazy_holder, esc_url( $atts['poster_frame'] ) ) : sprintf( 'src="%s"',  $atts['poster_frame']  );
					//
					?>
					 <div class="aesop-image-component-image aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> " <?php echo $widthstyle;?>>
					 <img <?php echo $lazy;?> >
					 </div>
					 
					<?php
			} else {
					if ( 'self' == $atts['src'] && ($autoplaystatus || 'on' == $atts['viewstart'] || 'on' == $atts['viewend'] || 'pip' == $atts['viewend']  )) { 
							?>
							<script>
								jQuery(document).ready(function($){
									var playing = false;
									$('#aesop-video-<?php echo esc_attr( $unique );?>').arrive('.mejs-video', function(){
										<?php if ( 'on' == $atts['viewstart'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '30%',
											handler: function(direction){
												if (!playing) {
												     $('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button, #aesop-video-<?php echo esc_attr( $unique );?> mejs-overlay-button').trigger('click');
													 playing = true;
												}
											}
										});
										<?php } ?>
										<?php if ( 'on' == $atts['viewend'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '100%',
											handler: function(direction){
												if (direction == 'up' && playing) {
													$('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button, #aesop-video-<?php echo esc_attr( $unique );?> mejs-overlay-button').trigger('click');
													playing = false;
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-70%',
											handler: function(direction){
												if (playing) {
												    $('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button, #aesop-video-<?php echo esc_attr( $unique );?> mejs-overlay-button').trigger('click');
													playing = false;
												}
											}
										});
										<?php } else if ( 'pip' == $atts['viewend'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '0%',
											handler: function(direction){
												if (direction == 'up') {
													$('#aesop-video-<?php echo esc_attr( $unique );?>').removeClass('aesop-video-pip');
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-50%',
											handler: function(direction){
												if ($('#aesop-video-<?php echo esc_attr( $unique );?> video').length > 0 && !$('#aesop-video-<?php echo esc_attr( $unique );?> video').get(0).paused) {
													$('#aesop-video-<?php echo esc_attr( $unique );?>').addClass('aesop-video-pip');
												}
											}
										});
										<?php } ?>
									});
									$('#aesop-video-<?php echo esc_attr( $unique );?>').click( function(){
										$('#aesop-video-<?php echo esc_attr( $unique );?> mejs-poster' ).hide();
									});
								});
							</script>
					<?php 
					}//end if
					switch ( $atts['src'] ) {
					case 'vimeo':
						$vmparams = $loopstatus ? sprintf ("&loop=1") : "";
						$vmparams = $vmparams.($autoplaystatus ? "&autoplay=1" : "");
						if ($controlstatus !=='controls-visible') { ?>
							<style> #aesop-vm-<?php echo esc_attr( $unique );?> .controls-wrapper { display:none !important;} </style>
							
						<?php	
						}
						printf( '<iframe id="aesop-vm-%s" src="//player.vimeo.com/video/%s?api=1&&player_id=aesop-vm-%s&controls=0%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>', esc_attr( $unique ), esc_attr( $atts['id'] ), esc_attr( $unique ),$vmparams, esc_attr( $iframe_size ) );
						
						if (('on' == $atts['viewstart'] || 'on' == $atts['viewend'] || 'pip' == $atts['viewend'])&& !wp_is_mobile()) {
						?>
						   <script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>

							<script>
							jQuery(document).ready(function($){
								// If multiple elements are selected, it will use the first element.
								 var vimeo_iframe = $('#aesop-vm-<?php echo esc_attr( $unique );?>')[0];
								 var player = $f(vimeo_iframe);								
								 player.addEvent('ready', function() {
									 <?php if ( $mute ) { ?>
									 player.api('setVolume', 0);
									 <?php } ?>
								
								
									<?php if ( 'on' == $atts['viewstart'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '25%',
											handler: function(direction){
												player.api('play');
											}
										});
										<?php } ?>
										<?php if ( 'on' == $atts['viewend'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '100%',
											handler: function(direction){
												if (direction == 'up') {
													player.api('pause');
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-70%',
											handler: function(direction){
												player.api('pause');
											}
										});
										<?php } else if ('pip' == $atts['viewend']) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '0%',
											handler: function(direction){
												if (direction == 'up') {
													$('#aesop-video-<?php echo esc_attr( $unique );?>').removeClass('aesop-video-pip');
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-50%',
											handler: function(direction){
												player.getPaused().then(function(paused) {
													if (!paused) {
														$('#aesop-video-<?php echo esc_attr( $unique );?>').addClass('aesop-video-pip');
													}
												});
											}
										});
									<?php } ?>
									
								});

							});
							</script>
						<?php
						}
						break;
					case 'dailymotion':
						printf( '<iframe src="//www.dailymotion.com/embed/video/%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0"></iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
						break;
					case 'youtube':
						$ytparams = $loopstatus ? sprintf ("&loop=1&playlist=%s" ,esc_attr( $atts['id'])) : "";
						$ytparams = $ytparams.($autoplaystatus ? "&autoplay=1" : "");
						$ytparams = $ytparams.($mute ? "&mute=1" : "");
						$ytparams = $ytparams.($controlstatus=='controls-visible' ? "" : "&controls=0&showinfo=0");
						
						printf( '<iframe id ="aesop-ytb-%s"  src="//www.youtube.com/embed/%s?rel=0&enablejsapi=1&wmode=transparent%s" %s  webkitAllowFullScreen mozallowfullscreen allowFullScreen wmode="transparent" frameborder="0" width="100%%"></iframe>', esc_attr( $unique ), esc_attr( $atts['id'] ), $ytparams, esc_attr( $iframe_size ) );

						if (('on' == $atts['viewstart'] || 'on' == $atts['viewend'] || 'pip' == $atts['viewend'])&& !wp_is_mobile()) {
						?>
							<script type="text/javascript">
							  var tag = document.createElement('script');
							  tag.id = 'iframe-demo';
							  tag.src = 'https://www.youtube.com/iframe_api';
							  var firstScriptTag = document.getElementsByTagName('script')[0];
							  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

							  var aseYTBplayer<?php echo esc_attr( $instance );?>;
							  function onYouTubeIframeAPIReady<?php echo esc_attr( $instance );?>() {
									aseYTBplayer<?php echo esc_attr( $instance );?> = new YT.Player('aesop-ytb-<?php echo esc_attr( $unique );?>', {
										events: {
										  'onReady': onAesopYTPlayerReady<?php echo esc_attr( $instance );?>,
										}
									});
							  }
							  if (typeof document.AesopYTReadyFuncs == 'undefined') {
								  document.AesopYTReadyFuncs =[];
							  }
							  document.AesopYTReadyFuncs.push(onYouTubeIframeAPIReady<?php echo esc_attr( $instance );?>);
							  

							  function onYouTubeIframeAPIReady() {
									if (typeof document.AesopYTReadyFuncs != 'undefined') {
										  for (var i = 0; i < document.AesopYTReadyFuncs.length; i++) {
												document.AesopYTReadyFuncs[i]();
										  }
									  }
							  }
							  
							  function onAesopYTPlayerReady<?php echo esc_attr( $instance );?>(event) {
								  jQuery(document).ready(function($){
										<?php if ( 'on' == $atts['viewstart'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '30%',
											handler: function(direction){
												aseYTBplayer<?php echo esc_attr( $instance );?>.playVideo();
											}
										});
										
										<?php } ?>
										<?php if ( 'on' == $atts['viewend'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '100%',
											handler: function(direction){
												if (direction == 'up') {
													aseYTBplayer<?php echo esc_attr( $instance );?>.pauseVideo();
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-70%',
											handler: function(direction){
												if (direction == 'down') {
													aseYTBplayer<?php echo esc_attr($instance );?>.pauseVideo();
												}
											}
										});
										<?php } else if ( 'pip' == $atts['viewend'] ) { ?>
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '0%',
											handler: function(direction){
												if (direction == 'up') {
													$('#aesop-video-<?php echo esc_attr( $unique );?>').removeClass('aesop-video-pip');
												}
											}
										});
										$('#aesop-video-<?php echo esc_attr( $unique );?>').waypoint({
											offset: '-50%',
											handler: function(direction){
												if (aseYTBplayer<?php echo esc_attr($instance );?>.getPlayerState() == 1) {
													$('#aesop-video-<?php echo esc_attr( $unique );?>').addClass('aesop-video-pip');
												}
											}
										});
										<?php } ?>
								  });
							  }
							</script>
						<?php
						}
						break;
					case 'kickstarter':
						printf( '<iframe src="%s" %s scrolling="no" wmode="transparent" frameborder="0"> </iframe>', esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
						break;
					case 'viddler':
						printf( '<iframe id="viddler-%s" src="//www.viddler.com/embed/%s/" %s mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>', esc_attr( $atts['id'] ), esc_attr( $atts['id'] ), esc_attr( $iframe_size ) );
						break;
					case 'vine':
						printf( '<iframe class="vine-embed" src="//vine.co/v/%s/embed/simple" width="480" height="480" frameborder="0"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>', esc_attr( $atts['id'] ) );
						break;
					case 'wistia':
						printf( '
												<div id="wistia_%s" class="wistia_embed" style="width:640px;height:360px;">&nbsp;</div>
												<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js"></script>
												<script> wistiaEmbed = Wistia.embed("%s",{videoFoam: true }); </script>
												', esc_attr( $atts['id'] ), esc_attr( $atts['id'] ) );
						break;
					case 'instagram':
						printf( '<iframe class="instagram-embed" src="//instagram.com/p/%s/embed" width="612" height="710" frameborder="0"></iframe>', esc_attr( $atts['id'] ) );
						break;
					case 'self':
						if (!$disable_for_mobile || !wp_is_mobile() ) {
							$video_code ="";
							if ($atts['poster_frame']!=='') {
								
								?>
								<script>
									jQuery(document).ready(function($){
										$('#aesop-video-<?php echo esc_attr( $unique );?>').click( function(){
											$('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-poster' ).remove();
											$('#aesop-video-<?php echo esc_attr( $unique );?> .mejs-playpause-button button, #aesop-video-<?php echo esc_attr( $unique );?> mejs-overlay-button').trigger('click');
											$('#aesop-video-<?php echo esc_attr( $unique );?>').off('click');
										});
									});
								</script>
								<?php
								$video_code = do_shortcode( '[video src="'.$atts['hosted'].'" loop="'.esc_attr( $loopstatus ).'" autoplay="'.esc_attr( $autoplaystatus ).'" poster="'.$atts['poster_frame'].'"]' );
							} else {
								$video_code = do_shortcode( '[video src="'.$atts['hosted'].'" loop="'.esc_attr( $loopstatus ).'" autoplay="'.esc_attr( $autoplaystatus ).'"]' );
							}
							if ($mute) {
								$video_code = str_replace( '<video', '<video muted', $video_code );
							}
							echo $video_code;
						} else {
							// disable video for mobile
							if ($atts['poster_frame']!=='') {
								$lazy   = class_exists( 'AesopLazyLoader' ) && ! is_user_logged_in() ? sprintf( 'src="%s" data-src="%s" class="aesop-lazy-img"', $lazy_holder, esc_url( $atts['poster_frame'] ) ) : sprintf( 'src="%s"',  $atts['poster_frame']  );
								//
								?>
								 <div class="aesop-image-component-image aesop-component-align-<?php echo sanitize_html_class( $atts['align'] );?> ">
								 <img <?php echo $lazy;?> >
								 </div>
								 
								<?php
								
							} else {
								
							}
						}
					}
			}
?>
		    </div>
			<div class="aesop-video-overlay-content">
				<?php echo $atts['overlay_content']; ?>
			</div>

	   	 	<?php echo $caption;

		do_action( 'aesop_video_inside_bottom', $atts, $unique ); // action ?>
		</div>

		<?php }
		do_action( 'aesop_video_after', $atts, $unique ); // action
		return ob_get_clean();
	}
}//end if
