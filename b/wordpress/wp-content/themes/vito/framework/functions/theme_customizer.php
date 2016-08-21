<?php
/**
 * Front End Customizer
 *
 * WordPress 3.4 Required
 */
 
add_action( 'customize_register', 'vito_quemalabs_options_register' );

function vito_quemalabs_options_register($wp_customize) {


	$wp_customize->get_setting('blogname')->transport='postMessage';
	$wp_customize->remove_control('blogdescription');
	$wp_customize->get_setting('header_textcolor')->transport='postMessage';	

	/*
	Site Title
	=====================================================
	*/
	$wp_customize->add_section( 'title_tagline', array(
	     'title'    => esc_attr__( 'Site Title', 'vito' ),
	     'priority' => 20,
	) );


	/*
	Color Section (Default)
	=====================================================
	*/
	$wp_customize->add_setting( 'headings_color', array(
		'default' => '#333333',
		'transport'  => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'theme_mod'
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'vito_headings_color', array(
		'label'      => esc_attr__( 'Headings Color', 'vito' ),
		'section'    => 'colors',
		'settings'   => 'headings_color'
	) ) );

	$wp_customize->add_setting( 'content_typography_color', array(
		'default' => '#777777',
		'transport'  => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'theme_mod'
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'vito_content_typography_color', array(
		'label'      => esc_attr__( 'Content Color', 'vito' ),
		'section'    => 'colors',
		'settings'   => 'content_typography_color'
	) ) );

	$wp_customize->add_setting( 'links_typography_color', array(
		'default' => '#68B1D5',
		'transport'  => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'type' => 'theme_mod'
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control( $wp_customize, 'vito_links_typography_color', array(
		'label'      => esc_attr__( 'Links Color', 'vito' ),
		'section'    => 'colors',
		'settings'   => 'links_typography_color'
	) ) );


	/*
	Social Icons
	=====================================================
	*/
	$wp_customize->add_section( 'vito_social_icons', array(
	     'title'    => esc_attr__( 'Social Icons', 'vito' ),
	     'priority' => 50,
	) );

	$wp_customize->add_setting('social_facebook', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_facebook', array(
        'label'      => esc_attr__('Facebook', 'vito'),
        'description' => esc_attr__('Add your social URL:', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_facebook',
    ));

    $wp_customize->add_setting('social_twitter', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_twitter', array(
        'label'      => esc_attr__('Twitter', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_twitter',
    ));

    $wp_customize->add_setting('social_instagram', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_instagram', array(
        'label'      => esc_attr__('Instagram', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_instagram',
    ));

    $wp_customize->add_setting('social_flickr', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_flickr', array(
        'label'      => esc_attr__('Flickr', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_flickr',
    ));

    $wp_customize->add_setting('social_youtube', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_youtube', array(
        'label'      => esc_attr__('Youtube', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_youtube',
    ));

    $wp_customize->add_setting('social_vimeo-square', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_vimeo-square', array(
        'label'      => esc_attr__('Vimeo', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_vimeo-square',
    ));

    $wp_customize->add_setting('social_linkedin', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_linkedin', array(
        'label'      => esc_attr__('LinkedIn', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_linkedin',
    ));

    $wp_customize->add_setting('social_skype', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_skype', array(
        'label'      => esc_attr__('Skype', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_skype',
    ));

    $wp_customize->add_setting('social_google-plus', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_google-plus', array(
        'label'      => esc_attr__('Google Plus', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_google-plus',
    ));

    $wp_customize->add_setting('social_tumblr', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_tumblr', array(
        'label'      => esc_attr__('Tumblr', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_tumblr',
    ));

    $wp_customize->add_setting('social_dribbble', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_dribbble', array(
        'label'      => esc_attr__('Dribbble', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_dribbble',
    ));

    $wp_customize->add_setting('social_foursquare', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_foursquare', array(
        'label'      => esc_attr__('Foursquare', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_foursquare',
    ));

    $wp_customize->add_setting('social_pinterest', array(
        'default'        => '',
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_pinterest', array(
        'label'      => esc_attr__('Pinterest', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_pinterest',
    ));

    $wp_customize->add_setting('social_rss', array(
        'default'        => get_bloginfo('rss2_url'),
        'transport'  => 'postMessage',
        'capability'     => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
        'type'     => 'theme_mod',
    ));
    $wp_customize->add_control('vito_social_rss', array(
        'label'      => esc_attr__('RSS', 'vito'),
        'section'    => 'vito_social_icons',
        'settings'   => 'social_rss',
    ));

}


/*
Enqueue Script for Live previw in the Theme Customizer
*/
if ( ! function_exists( 'vito_customizer_live_preview' ) ){
	function vito_customizer_live_preview()
	{
		wp_enqueue_script( 'ql-themecustomizer',			//Give the script an ID
			  VITO_THEME_JS.'/theme-customizer.js',//Point to file
			  array( 'jquery','customize-preview' ),	//Define dependencies
			  '',						//Define a version (optional) 
			  true						//Put script in footer?
		);
	}
}//end if function_exists
add_action( 'customize_preview_init', 'vito_customizer_live_preview' );
?>