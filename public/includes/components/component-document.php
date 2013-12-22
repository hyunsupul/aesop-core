<?php

/**
 	* Creates a dropdown document revealer
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_document_shortcode')){

	function aesop_document_shortcode($atts, $content = null) {

		$defaults = array(
			'type'		=> 'pdf',
			'src'		=> '',
			'caption'		=> ''
		);
		$atts = shortcode_atts($defaults, $atts);

		$hash = rand();

		
		switch($atts['src']) {
			case 'pdf':
				$source = sprintf('<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', $atts['src']);
			break;
			case 'image':
				$source = sprintf('<img src="%s"', $atts['src']);
			break;
			default:
				$source = sprintf('<object class="aesop-pdf" data="%s" type="application/pdf" ></object>', $atts['src']);
			break;
		}

		$out = sprintf('
			<script>
			jQuery(document).ready(function(){
				jQuery(\'.aesop-doc-reveal-%s\').click(function(e){
					e.preventDefault;
					jQuery( "#aesop-doc-collapse-%s" ).slideToggle();
					return false;
				});
			});
		</script>
		',$hash, $hash);

		$slide = $atts['caption'] ? $atts['caption'] : false;
		$link = sprintf('<a href="#" class="aesop-doc-reveal-%s"><span>document</span><br /> %s</a>', $hash,$slide);
		$guts = sprintf('<div id="aesop-doc-collapse-%s" style="display:none;" class="aesop-content">%s</div>',$hash, $source);
		
		$out .= sprintf('<aside class="aesop-documument-component aesop-content">%s%s</aside>', $link, $guts);

		return apply_filters('aesop_document_output', $out);
	}
}
