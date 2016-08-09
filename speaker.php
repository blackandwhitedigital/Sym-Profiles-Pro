<?php
/**
* Plugin Name: Symposium Speaker Profiles Pro
* Plugin URI: http://www.blackandwhitedigital.eu/product-category/plugins/
* Description: Display your speaker profiles with ease.
* Author: Black and White Digital Ltd
* Version: 0.1
* Author URI: http://www.blackandwhitedigital.eu/product-category/plugins/
* Text Domain: Speaker
* License: GPL License
*/

define( 'SPEAKER_VERSION', '0.1' );
define( 'SPEAKER_TITLE', 'Symposium Speaker Profiles Pro');
define( 'SPEAKER_SLUG', 'speaker');
define( 'SPEAKER_PLUGIN_PATH', dirname( __FILE__ ));
define( 'SPEAKER_PLUGIN_ACTIVE_FILE_NAME', plugin_basename( __FILE__ ));
define( 'SPEAKER_PLUGIN_URL', plugins_url( '' , __FILE__ ));
define( 'SPEAKER_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages');

require('lib/init.php');

//require ('lib/Wp_License_Manager_Client.php');
wp_enqueue_style('thickbox'); // call to media files in wp
wp_enqueue_script('thickbox');
wp_enqueue_script( 'media-upload'); 
//$license_manager = new Wp_License_Manager_Client('speaker');



