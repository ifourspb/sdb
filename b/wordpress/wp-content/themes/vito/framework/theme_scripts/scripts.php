<?php
	//=============================================================
	//Theme Scripts
	//=============================================================
	
	//Register JS Scripts for later use
if ( ! function_exists( 'vito_enqueue_scripts' ) ){
	function vito_enqueue_scripts() {
				
		//hoverIntent Plugin ==============================================
		wp_register_script('hoverIntent', VITO_THEME_JS . '/jquery.hoverIntent.minified.js', array('jquery'), '6.0', true );
		wp_enqueue_script('hoverIntent');
		//=================================================================

		//Modernizr Plugin ==============================================
		wp_register_script('modernizr', VITO_THEME_JS . '/modernizr.min.js', '2.8.3', true );
		wp_enqueue_script('modernizr');
		//=================================================================

		//Pace  =============================================
		wp_register_script('pace', VITO_THEME_JS . '/pace.min.js', array(), '0.2.0', true);
		wp_enqueue_script('pace');
		//=================================================================
		
		//Bootstrap JS ========================================
		wp_register_script('bootstrap', VITO_THEME_JS . '/bootstrap.min.js', array(), '2.1.0', true);
		wp_enqueue_script('bootstrap');
		//=================================================================
		
		//Comment Reply ===================================================
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		//=================================================================


		//Customs Scripts =================================================
		wp_register_script('theme-custom', VITO_THEME_JS . '/script.js', array('jquery', 'bootstrap'), '1.0', true );
		wp_enqueue_script('theme-custom');
		//=================================================================
	}
}//end if function_exists
	add_action('wp_enqueue_scripts', 'vito_enqueue_scripts');

?>