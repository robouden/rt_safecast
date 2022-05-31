<?php
/**
* Plugin Name: LH Multisite CORS
* Plugin URI: https://lhero.org/portfolio/lh-multisite-cors/
* Version: 1.02
* Author: Peter Shaw
* Author URI: https://shawfactor.com
* Description: Sets the CORS allow headers for requests between sites within your multisite network
* License: GPL2
*/

  // If this file is called directly, abandon ship.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* LH Multisite CORS Class
*/

if (!class_exists('LH_multisite_cors_plugin')) {

class LH_multisite_cors_plugin {
    
    private static $instance;

static function check_blog($blog){

global $wpdb;

$domain = $wpdb->get_results( "SELECT domain FROM ".$wpdb->blogs." where domain ='".$blog."' and spam = '0' LIMIT 1");

if (isset($domain[0]->domain)){

return true;

} else {

return false;


}

}

static function check_mapped_domain($mapped){

global $wpdb;

// Define the custom table
$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';

// Check if the custom table exists
if ( $wpdb->dmtable != $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->dmtable}'" ) ){
    return false;
    
}

$domain = $wpdb->get_results( "SELECT a.domain FROM ".$wpdb->dmtable." a, ".$wpdb->blogs." b where a.blog_id = b.blog_id and a.domain = '".$mapped."'");

if (isset($domain[0]->domain)){

return true;

} else {

return false;


}

}

public function add_header() {

  if (isset($_SERVER['HTTP_REFERER'])){

	$referrer = $_SERVER['HTTP_REFERER'];
	

$bits = parse_url($referrer);

	if (isset($bits['host'])){ $referrer_domain = $bits['host']; }
	if (isset($bits['scheme'])){ $referrer_scheme = $bits['scheme']; }
 
  }


  if (isset($referrer_domain) and isset($referrer_scheme)){

if (isset($_SERVER['HTTP_ORIGIN'])){
  
$origin = $_SERVER['HTTP_ORIGIN'];

}

$pieces = parse_url(site_url());

if (isset($pieces['host'])){ $site_domain = $pieces['host']; } 
if (isset($pieces['scheme'])){ $site_scheme = $pieces['scheme']; }

if (empty($referrer_scheme) or empty($site_scheme) or ($referrer_scheme != $site_scheme)){

//The protocols don't match
return;

} elseif (empty($site_domain) or empty($referrer_domain) or ($site_domain == $referrer_domain)){

//the referrer is part of the same domain
return;


} elseif (self::check_blog($referrer_domain)){

//It is is part of the multisite
header("Access-Control-Allow-Origin:".$referrer_scheme."://".$referrer_domain); 
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS,PUT,DELETE');


} elseif (self::check_mapped_domain($referrer_domain)){

//It is a mapped domain
header("Access-Control-Allow-Origin:".$referrer_scheme."://".$referrer_domain); 
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST,GET,OPTIONS,PUT,DELETE');

} else {

//No match
return;


}
  }

}

public function plugin_init(){
    
add_action( 'wp_loaded', array($this,'add_header'));
    
    
}


   /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }


public function __construct() {

        //run our hooks on plugins loaded to as we may need checks       
    add_action( 'plugins_loaded', array($this,'plugin_init'));

}

}

$lh_multisite_cors_instance = LH_multisite_cors_plugin::get_instance();

}


?>