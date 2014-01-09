<?php
/*
Plugin Name: WP Easy Tools Compression
Plugin http://codemywebapps.com/wp-easy-tools-compression
Description: The easiest to compress your image, html and css to speedup you websites.
Version: 1.0
Author: codemywebapps
Author URI: http://codemywebapps.com/
License: GPL2
*/
$wtc_upload_dir = wp_upload_dir();
define('WTC_PLUGIN_DIR', dirname(__FILE__));
define('WTC_PLUGIN_URL', plugin_dir_url(__FILE__));
//define('WTC_FILE_DIR',ABSPATH."/wp-content/uploads/wtc_images");
define('WTC_FILE_DIR',"$wtc_upload_dir[basedir]/wtc_images");
define('WTC_FILE_URL',get_option('siteurl')."/wp-content/uploads/wtc_images");

add_action('admin_menu','wtc_admin_menu');


function wtc_admin_menu()
{
	add_menu_page('Easy Tools','Easy Tools' ,'manage_options' ,__FILE__,"wtc_settings");    	
	add_submenu_page(__FILE__, 'Settings','', 'manage_options' , __FILE__,"wtc_settings");	 
		
	add_submenu_page(__FILE__, 'Settings','Settings','manage_options' , 
	'wtc_settings',"wtc_settings");
	
	add_submenu_page(__FILE__, 'Bulk Compression','Bulk Compression','manage_options' , 
	'wtc_image_settings',"wtc_image_settings");
}

require_once 'components/wtc_db.php';
require_once 'components/wtc_form.php';
require_once 'components/wtc_validator.php';
require_once 'components/tinyorg.php';
require_once 'components/Kraken.php';
require_once 'components/diet.php';

require_once 'models/wtc_settings.php';
require_once 'models/wtc_image_settings.php';
require_once 'models/wtc_media.php';

require_once 'ajax/wtc_ajax_admin.php';

$wtc_db=new wtc_db(array('username'=>DB_USER,'password'=>DB_PASSWORD,
'database'=>DB_NAME, 'host'=>DB_HOST
));

$wtc_validator=new wtc_validator;
$wtc_form=new wtc_form();

add_action( 'admin_enqueue_scripts', 'wtc_admin_assets' );

function wtc_admin_assets()
{	
	wp_enqueue_style('wtc-admin-css',WTC_PLUGIN_URL."/assets/css/wtc_admin.css");			
	wp_enqueue_style('jquery-ui-css',WTC_PLUGIN_URL."/vendor/jquery-ui-1.10.3.custom/smoothness/jquery-ui-1.10.3.custom.min.css");				
	wp_enqueue_script('jquery-ui-tabs');	 
	wp_enqueue_script('wtc-admin-js',WTC_PLUGIN_URL."/assets/js/wtc_admin.js",array('jquery'),'1.0',true);
}

add_action( 'wp_ajax_wtc_ajax_admin', 'wtc_ajax_admin' );
add_action( 'wp_ajax_nopriv_wtc_ajax_admin', 'wtc_ajax_admin');

//add_filter('the_content', 'test');

function test($content='')
{
	$dom = new DOMDocument;
    $dom->loadHTML($content);
    $dom->preserveWhiteSpace = false;
    $images = $dom->getElementsByTagName('img');
    foreach ($images as $image) {
      $image_url=$image->getAttribute('src');
      if (preg_match("/http:/i", $image_url)) {
      	 $t1=explode("/",$image_url);
      	 $t1_count=count($t1);      	
      	 $file_name=$t1[$t1_count-1];      	       	 
      	 if (file_exists(WTC_FILE_DIR."/$file_name")){      	 	
      	 	$content=str_replace($image_url,WTC_FILE_URL."/$file_name",$content);
      	 }
      }
    }
    return $content;
}

if (!function_exists('dump')){
	function dump($data='')
	{
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
}

/** COMPRESS HTML SETTINGS */
if (get_option('wtc_compress_html')==1){
    require_once WTC_PLUGIN_DIR."/vendor/WP_HTML_Compression.php";	
}

if (get_option('wtc_compress_main_css')==1){
    add_filter('stylesheet_uri','wtc_template_directory',10,2);	
    function wtc_template_directory($stylesheet_uri, $stylesheet_dir_uri){
      return WTC_PLUGIN_URL.'css/wtc_css.php?path='.$stylesheet_dir_uri;
    }
}

register_activation_hook(__FILE__,'wtc_install');

function wtc_install()
{	
	global $wpdb;	
	require_once 'sql/sql.php';
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	
	if (is_array($table) && count($table)>=1){
		foreach ($table as $val) {
	        dbDelta($val);	        
		}
	}
}