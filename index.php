<?php
/*
Plugin Name: Sample Plugin Name
Plugin URI: http://visztpeter.me
Description: Your Plugin Description
Author: Your Name
Version: 1.0
Update URI: simple-wp-plugin-update
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Run your plugin as usual
if( ! class_exists( 'SampleExtension' ) ) {
    class SampleExtension {

        public function __construct() {
            self::$version = '1.0';
        
                //Check for updates
                require_once( plugin_dir_path( __FILE__ ) . 'class-update.php' );
                $update = new Simple_Update_Check('simple-wp-plugin-update'); //Add your plugin slug here(same as the folder name and same as the Update URI in the plugin header)
        
                //Uncomment this for testing, so it will check for plugin updates on every page load
                /*
                add_action( 'init', function(){
                    delete_transient( 'update_plugins' );
                    delete_site_transient( 'update_plugins' );
                });
                */
                
        }

    }

    new SampleExtension();
}