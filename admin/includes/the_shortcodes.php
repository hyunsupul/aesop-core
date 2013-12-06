<?php

	// Gist Shortcode
	function aesop_gist_shortcode ($atts,$content = null) {

		$defaults = array(
			'id' => '1268328',
			'file' => ''
		);
		$atts = shortcode_atts($defaults,$atts);

		$src = 'https://gist.github.com/'.trim($atts['id']).'.js';
		if($atts['file'] != '') {
			$src = $src.'?file='.trim($atts['file']);
		}
		$out =  "<script src=\"$src\"></script>";

		if($content != null){
			$out = $out."<noscript><code class=\"gist\"><pre>".$content."</pre></code></noscript>";
		}

		return $out;
	}
