<?php
ob_start();
/*
Plugin Name: WP Active Support 
Plugin URI: http://www.marketing-optimiser.co.uk/
Description:WP Active Support provides a simple way to keep an eye on the core and plugins of your WordPress website. A simple dashboard and email notification facility to let you know when things need updating. Get premium support at <a href="http://www.marketing-optimiser.co.uk/products/active-support/">Marketing Optimiser</a>.
Author: David Kitchenham
Author URI: http://www.marketing-optimiser.co.uk/active-support-plugin-for-wordpress/ 
Version: 1
Copyright 2015 David Kitchenham (email: david.kitchenham at gmail.com)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or    (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
define( 'ROOT_PATH', dirname(__FILE__) );
require ABSPATH . WPINC . '/pluggable.php';	
class WP_Active_Support{
	public $mainpluginuser;
	public $version;
    function __construct() {		
		add_action( 'admin_menu', array( $this, 'wp_acive_supported_menu' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'wp_active_style') );
		register_activation_hook( __FILE__, array( $this, 'wp_active_install' ) ); 
        register_deactivation_hook( __FILE__, array( $this, 'wp_active_unistall' ) );
		$this->version = "1.0";
		$this->mainpluginuser = "http://www.marketing-optimiser.co.uk/curl-page/";
		$this->imagesurl = plugins_url('images/', __FILE__);
	}
	function wp_acive_supported_menu() {
		
        add_menu_page( 'Active Support', 'Active Support', 'manage_options', 'main-dashboard', array(
                          __CLASS__,
                         'wp_active_file_path'
                        ), plugins_url('images/icon.png', __FILE__),'2.2.9');						
        add_submenu_page( 'main-dashboard', 'Marketing Optimiser WP Active Support' . ' Dashboard', ' Dashboard', 'manage_options', 'main-dashboard', array(
                              __CLASS__,
                             'wp_active_file_path'
                            ));
							
    }
	
    static function wp_active_file_path() {
    
        $screen = get_current_screen();
        if ( strpos( $screen->base, 'main-settings' ) !== false ) {
            include( dirname(__FILE__) . '/includes/main-settings.php' );
        } 
        else {
            include( dirname(__FILE__) . '/includes/main-dashboard.php' );
        }
    }	
    public function wp_active_dashboard_tab( $current = 'preferences' ) { 
         $tabs = array( 					'preferences' =>  'Preferences',				'userlist'  =>  'User List',				'initiate' =>  'Active'				);
            echo '<div class="left-area">';
            echo '<div id="icon-themes" class="icon32"><br></div>';
            echo '<h2 class="nav-tab-wrapper">';
            foreach( $tabs as $tab => $name ) {
                $class = ( $tab == $current ) ? ' nav-tab-active' : '';
                echo "<a class='nav-tab$class $name' href='?page=main-dashboard&tab=$tab'>$name</a>";
            }
            echo '</h2>';
    }
	public function wp_active_style( $page ) {
        wp_enqueue_style( 'wp_supported_css', plugins_url('css/wp_supported_css.css', __FILE__));
    }

	
    function wp_active_install() {
		
		$paths = $this->mainpluginuser; 
		$wp_siteurl=site_url(); 
		$wp_email = get_option('admin_email');
			function curlRequest2($url) {
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			return($response);
			}
			$querstring = "$paths?action=activeplugin&wp_siteurl=$wp_siteurl&wp_email=$wp_email";
			$deactiveresponce = curlRequest2($querstring);
			$keyvalue = "0"; 
			$valueinsertpostmeta = serialize($keyvalue); 
			update_post_meta('1', 'information_key',$valueinsertpostmeta);
			update_post_meta('1', 'wp_notification',$valueinsertpostmeta);
			
	}

    function wp_active_unistall() { 
		
		$paths = $this->mainpluginuser; 	
		
		$wp_siteurl=site_url(); 
		$wp_email = get_option('admin_email');
		function curlRequestseconds($url) {
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($ch);
			return($response);
			}
		$querstring = "$paths?action=deactive&wp_siteurl=$wp_siteurl&wp_email=$wp_email";	
		$deactiveresponce = curlRequestseconds($querstring);
	}
	function currentuserinformation(){
		global $current_user;
		get_currentuserinfo();
		$current_user->ID; 
		$lasttime =  date('d-m-Y H:i:s'); 
		update_user_meta($current_user->ID, 'last_login',$lasttime);
	}
	
}
$wp_callplugin = new WP_Active_Support();
$wp_callplugin = $wp_callplugin->currentuserinformation();			

?>
