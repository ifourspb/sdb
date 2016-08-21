<?php
if(!class_exists('vito_Theme')){
/**
 * Theme Class
 */
class vito_Theme {

	/**
	 * Here are loaded all the initial files, constant, etc.
	 */
	function __construct($theme_info){
	

		/* Define theme's constants. */
		$this->constants($theme_info);

		/* Add Theme support */
		$this->theme_support();
		
		/* Add Stylesheets for the Theme (CSS) */
		$this->stylesheets();

		/* Add JS Scripts for the Theme (JS) */
		$this->scripts();
		
		/* Add Theme Functions */
		$this->theme_functions();
		
		/* Create all the widget areas */
		$this->widget_areas();

		/* Customizer */
		$this->customizer();
				
		
		/* Set the Full Width Image value */
		if ( ! isset( $content_width ) ) $content_width = 649;
		
	}
	
	
	
	
	/**
	 * Defines the constant paths for use within the theme.
	 */
	private function constants($theme_info) {
		define('VITO_THEME_NAME', $theme_info['theme_name']);
		define('VITO_THEME_SLUG', $theme_info['theme_slug']);
		define('VITO_THEME_VERSION', $theme_info['theme_version']);
		define('VITO_THEME_AUTHOR', $theme_info['theme_author']);
		define('VITO_THEME_AUTHOR_URI', $theme_info['theme_author_uri']);

		define('VITO_THEME_DIR', get_template_directory());
		define('VITO_THEME_URI', get_template_directory_uri());

		
		define('VITO_THEME_CSS', VITO_THEME_URI . '/css');
		define('VITO_THEME_JS', VITO_THEME_URI . '/js');
		define('VITO_THEME_IMAGES', VITO_THEME_URI . '/images');


		define('VITO_THEME_FRAMEWORK', VITO_THEME_DIR . '/framework');
		define('VITO_THEME_FRAMEWORK_URI', VITO_THEME_URI . '/framework');

		define('VITO_THEME_ADMIN', VITO_THEME_FRAMEWORK_URI . '/admin');
		define('VITO_THEME_FUNCTIONS', VITO_THEME_FRAMEWORK . '/functions');
		define('VITO_THEME_SCRIPTS', VITO_THEME_FRAMEWORK . '/theme_scripts');
		define('VITO_THEME_POST_TYPES', VITO_THEME_FRAMEWORK . '/post_types');
		define('VITO_THEME_META_BOXES', VITO_THEME_FRAMEWORK . '/meta_boxes');
		define('VITO_THEME_META_BOXES_URI', VITO_THEME_FRAMEWORK_URI . '/meta_boxes');
		define('VITO_THEME_WIDGET_AREAS', VITO_THEME_FRAMEWORK . '/widget_areas');
		define('VITO_THEME_WIDGETS', VITO_THEME_FRAMEWORK . '/widgets');
		define('VITO_THEME_SHORTCODES', VITO_THEME_FRAMEWORK . '/shortcodes');
		define('VITO_THEME_FULLSCREEN', VITO_THEME_FRAMEWORK . '/fullscreen');
		define('VITO_THEME_PLUGINS', VITO_THEME_FRAMEWORK . '/plugins');
		define('VITO_THEME_PLUGINS_URI', VITO_THEME_FRAMEWORK_URI . '/plugins');

		
		define('VITO_THEME_LENGUAGES', VITO_THEME_DIR . '/languages');



		//Constant for Child Themes
		define('VITO_CHILD_THEME_DIR', get_stylesheet_directory());
		define('VITO_CHILD_THEME_URI', get_stylesheet_directory_uri());
		
		define('VITO_CHILD_THEME_CSS', VITO_CHILD_THEME_URI . '/css');
		define('VITO_CHILD_THEME_JS', VITO_CHILD_THEME_URI . '/js');
		define('VITO_CHILD_THEME_IMAGES', VITO_CHILD_THEME_URI . '/images');

		define('VITO_CHILD_THEME_FRAMEWORK', VITO_CHILD_THEME_DIR . '/framework');
		define('VITO_CHILD_THEME_FRAMEWORK_URI', VITO_CHILD_THEME_URI . '/framework');

		define('VITO_CHILD_THEME_ADMIN', VITO_CHILD_THEME_FRAMEWORK_URI . '/admin');
		define('VITO_CHILD_THEME_FUNCTIONS', VITO_CHILD_THEME_FRAMEWORK . '/functions');
		define('VITO_CHILD_THEME_SCRIPTS', VITO_CHILD_THEME_FRAMEWORK . '/theme_scripts');
		define('VITO_CHILD_THEME_POST_TYPES', VITO_CHILD_THEME_FRAMEWORK . '/post_types');
		define('VITO_CHILD_THEME_META_BOXES', VITO_CHILD_THEME_FRAMEWORK . '/meta_boxes');
		define('VITO_CHILD_THEME_META_BOXES_URI', VITO_CHILD_THEME_FRAMEWORK_URI . '/meta_boxes');
		define('VITO_CHILD_THEME_WIDGET_AREAS', VITO_CHILD_THEME_FRAMEWORK . '/widget_areas');
		define('VITO_CHILD_THEME_WIDGETS', VITO_CHILD_THEME_FRAMEWORK . '/widgets');
		define('VITO_CHILD_THEME_SHORTCODES', VITO_CHILD_THEME_FRAMEWORK . '/shortcodes');
		define('VITO_CHILD_THEME_FULLSCREEN', VITO_CHILD_THEME_FRAMEWORK . '/fullscreen');
		define('VITO_CHILD_THEME_PLUGINS', VITO_CHILD_THEME_FRAMEWORK . '/plugins');
		define('VITO_CHILD_THEME_PLUGINS_URI', VITO_CHILD_THEME_FRAMEWORK_URI . '/plugins');

		
		define('VITO_CHILD_THEME_LENGUAGES', VITO_CHILD_THEME_DIR . '/languages');
	}
	
	
	
	
	

	
	/**
	 * Add Stylesheets for the Theme (CSS)
	 */
	public function stylesheets(){

		//Stylesheets
		vito_require_file("/stylesheets.php", VITO_THEME_SCRIPTS, VITO_CHILD_THEME_SCRIPTS);


		//Custom Styles from Admin Panel
		vito_require_file("/styles.php", VITO_THEME_SCRIPTS, VITO_CHILD_THEME_SCRIPTS);
		
	}



	/**
	 * Add JS Scripts for the Theme (JS)
	 */
	public function scripts(){

		//Stylesheets
		vito_require_file("/scripts.php", VITO_THEME_SCRIPTS, VITO_CHILD_THEME_SCRIPTS);
		
	}

	
	
	
	
	/**
	 * Add Theme Support
	 */
	public function theme_support(){		
		function vito_setup() {

			load_theme_textdomain( 'vito', get_template_directory() . '/languages' );

			add_theme_support( 'post-thumbnails' );

			if ( function_exists( 'add_image_size' ) ) {
				//Blog Thumbnails
				add_image_size( 'post', 953, 536, true );
			}
		
			// Add RSS links to <head> section
			add_theme_support('automatic-feed-links');
			
			//Add Menu Manager---------------------------
			add_theme_support( 'nav-menus' );

			register_nav_menus( array('menu-1' => esc_attr__( 'Navigation Menu' , 'quemalabs_admin')));

			//Title support---------------------------
			add_theme_support( 'title-tag' );

			// Setup the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'vito_custom_background_args', array(
				'default-color'      => "#F1F1F1",
				'default-attachment' => 'fixed',
			) ) );

			//HTML5 support
			add_theme_support( 'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
			) );

			// Styles for TinyMCE
		    add_editor_style( VITO_THEME_CSS . '/custom-editor-style.css' );
		    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Lato:300,400,700' );
    		add_editor_style( $font_url );


			add_theme_support( 'custom-header', apply_filters( 'vito_custom_header_args', array(
				'default-text-color'     => "#777777",
				'width'                  => 953,
				'height'                 => 110,
				'wp-head-callback'       => 'vito_header_style',
			) ) );
		}
		add_action( 'after_setup_theme', 'vito_setup' );
	}
	
	
	
	/**
	 * Add Theme Functions
	 */
	public function theme_functions(){

		//Custom Comments		
		vito_require_file("/custom_comments.php", VITO_THEME_FUNCTIONS, VITO_CHILD_THEME_FUNCTIONS);
		
		//Single Functions		
		vito_require_file( "/custom-functions.php", VITO_THEME_FUNCTIONS, VITO_CHILD_THEME_FUNCTIONS);

		//Custom Header
		vito_require_file("/custom-header.php", VITO_THEME_FUNCTIONS, VITO_CHILD_THEME_FUNCTIONS);	

	}
	
	
		

	
	/**
	 * Create all the widget areas
	 */
	public function widget_areas(){
		vito_require_file("/widget_areas.php", VITO_THEME_WIDGET_AREAS, VITO_CHILD_THEME_WIDGET_AREAS);
	}
	
	/**
	 * Create all the widget areas
	 */
	public function customizer(){
		/**
		 * Front End Customizer
		 *
		 * WordPress 3.4 Required
		 */

		vito_require_file('/theme_customizer.php', VITO_THEME_FUNCTIONS, VITO_CHILD_THEME_FUNCTIONS);
	}


	
	

}//class Theme

}//if !class_exists
?>