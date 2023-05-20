<?php
defined( 'ABSPATH' ) || exit;

if( ! class_exists( 'Simple_Update_Check' ) ) {

	class Simple_Update_Check{

		public $plugin_slug;
		public $api_url;
		public function __construct($plugin_slug) {
			$this->plugin_slug = $plugin_slug;
			$this->api_url = 'http://dev.local/info.json'; //You can add your plugin slug here as a parameter
			add_filter('update_plugins_'.$this->plugin_slug, array($this, 'update'), 10, 4);
			add_filter('plugins_api', array( $this, 'info' ), 20, 3 );
		}

        //Checks for a new update. You should probably add some basic error handling
		public function update($update, $plugin_data, $plugin_file, $locales) {
			$remote = wp_remote_get($this->api_url);
            if(!is_wp_error( $remote ) {
		    	$remote = json_decode( wp_remote_retrieve_body( $remote ) );
            }
			return $remote;
		}

        //Show modal window with update and plugins details. You should probably add some basic error handling
		public function info($res, $action, $args){
			if('plugin_information' === $action && $args->slug == $this->plugin_slug) {
				$remote = wp_remote_get($this->api_url);
                if(!is_wp_error( $remote ) {
                    $res = json_decode( wp_remote_retrieve_body( $remote ) );
                    //Fix, because $res requires sections and banners to be an array, not an object
				    $res->sections = json_decode(json_encode($res->sections), true);
				    $res->banners = json_decode(json_encode($res->banners), true);		
                }	
			}
			return $res;
		}

	}

}