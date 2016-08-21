<?php
if ( ! function_exists( 'vito_header_style' ) ) :
function vito_header_style() {
	$header_image = get_header_image();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && display_header_text() ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css" id="ql-header-css">
	<?php
		// Has a Custom Header been added?
		if ( ! empty( $header_image ) ) :
	?>
		#header {
			background: url(<?php header_image(); ?>) no-repeat 50% 50%;
			-webkit-background-size: cover;
			-moz-background-size:    cover;
			-o-background-size:      cover;
			background-size:         cover;
		}
	<?php
		endif;
		
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.ql_logo {
			display: none;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // vito_header_style
?>