<?php

/*
Plugin Name: Mobile Featured Image
Plugin URI: https://github.com/drunken-coding/mobile-featured-image
Description: Display a different featured image on small screens
Version: 0.1
Author: ryanshoover
Author URI: http://ryan.hoover.ws
Text Domain: mobileimg
*/

namespace MobileImg;

define( 'MOBILE_IMG_PATH', plugin_dir_path(__FILE__) );
define( 'MOBILE_IMG_URL', plugin_dir_url(__FILE__) );

require_once( MOBILE_IMG_PATH . 'inc/core.php' );

if ( is_admin() )
	require_once( MOBILE_IMG_PATH . 'inc/admin.php' );
