<?php
if ( ! function_exists( 'vito_enqueue_scripts' ) ){
	function vito_header_styles() {

		/*
			Print CSS colors
			==========================================================
		*/
		function vito_print_colors($color, $items_arr, $css_prop){
			$v_count = count($items_arr);
			$s_count = 1;
			foreach ($items_arr as $css_line) {
			    if ($v_count == $s_count) {
					echo wp_filter_nohtml_kses( $css_line ) . "\n";
				}else{
					echo wp_filter_nohtml_kses( $css_line ) . ",\n";	
				}
				$s_count++;
			}
			echo "{";
				echo wp_filter_nohtml_kses( $css_prop ) . ": " . esc_attr( $color ) . "!important;";
			echo "}";
		}//vito_print_colors()


	  ?>


		<!-- Custom Styles -->
	    <style type="text/css">

		/*
			Body
			---> Background Color
			=============================
		*/
		<?php
		$vito_body_background = "#" . get_background_color();
		$vito_body_background_html = array(
			"body"
		);
		vito_print_colors($vito_body_background, $vito_body_background_html, 'background-color');
		?>


		/*
			Header
			---> Text Color
			=============================
		*/
		<?php
		$vito_header_textcolor = "#" . get_header_textcolor();
		$vito_header_textcolor_html = array(
			"#header",
			"#jqueryslidemenu ul.nav > li > a"
		);
		vito_print_colors($vito_header_textcolor, $vito_header_textcolor_html, 'color');
		?>

		/*
			Content
			---> Text Color
			=============================
		*/
		<?php
		$vito_content_color = get_theme_mod( 'content_typography_color' );
		$vito_content_color_html = array(
			"body"
		);
		vito_print_colors($vito_content_color, $vito_content_color_html, 'color');
		?>

		/*
			Links
			---> Text Color
			=============================
		*/
		<?php
		$vito_links_color = get_theme_mod( 'links_typography_color' );
		$vito_links_color_html = array(
			".entry a, .widget a, #footer a, .metadata a"
		);
		vito_print_colors($vito_links_color, $vito_links_color_html, 'color');
		?>

		/*
			Headings
			---> Text Color
			=============================
		*/
		<?php
		$vito_headings_color = get_theme_mod( 'headings_color' );
		$vito_headings_color_html = array(
			"h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a"
		);
		vito_print_colors($vito_headings_color, $vito_headings_color_html, 'color');
		?>

	

	    </style>

	  <?php

	  
	}
}//end if function_exists

add_action( 'wp_head', 'vito_header_styles' );
?>