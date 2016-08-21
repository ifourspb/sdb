<?php
/*
Plugin Name: Contact Form Bytehand Sms
Plugin URI: http://Bytehand.com/
Description: Bytehand
Author: Bytehand.com
Author URI: http://Bytehand.com/
Text Domain: contact-form-sms-bytehand-addon
Domain Path: /languages/
Version: 1.0
*/ 

// Version of the bytehand plugin in use
$GLOBALS['bytehand_plugins'][ basename( dirname( __FILE__ ) ) ] = '1.0';

if( !function_exists( 'bytehand_loader' ) ) {

  /**
   * Load bytehand plugins based on version numbering
   *
   * @return void
   */
  function bytehand_loader() {
    $versions = array_flip( $GLOBALS['bytehand_plugins'] );
    uksort( $versions, 'version_compare' );
    $versions = array_reverse( $versions );
    $first_plugin = reset( $versions );
    
    // Require bytehand plugin architecture
    if( !class_exists( 'bytehand_Plugin' ) ) {
      require_once( dirname( dirname( __FILE__ ) ) . '/' . $first_plugin . '/lib/class-bytehand-plugin.php' );
	  require_once( dirname( dirname( __FILE__ ) ) . '/' . $first_plugin . '/main.php' );
    }
    
  }
  
}

add_action( 'plugins_loaded', 'bytehand_loader' );
