<?php

/**
 	* Creates a dropdown document revealer
 	*
 	* @since    1.0.0
*/
if (!function_exists('aesop_document_shortcode')){

	function aesop_document_shortcode($atts, $content = null) {

		$defaults = array(
			'src'		=> '',
		);
		$atts = shortcode_atts($defaults, $atts);

		$hash = rand();

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

		$guts = sprintf('<div id="aesop-doc-collapse-%s" style="display:none;" class="aesop-content">%s</div>',$hash, $atts['src']);
		$link = sprintf('<a href="#" class="aesop-doc-reveal-%s"><span>document</span> %s</a>', $hash, do_shortcode($content));
		$out .= sprintf('<aside class="aesop-documument-component aesop-content">%s%s</aside>', $link, $guts);

		return apply_filters('aesop_document_output', $out);
	}
}
