<?php
/**
 * Plugin Name: Wpdevart Facebook comments
 * Plugin URI: http://wpdevart.com/wordpress-facebook-comments-plugin/
 * Description: Our WordPress Facebook comments plugin will help you to display Facebook Comments box on your website. You can use Facebook Comments box on your pages/posts.
 * Version: 1.2.5
 * Author: wpdevart
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 

class wpdevart_comment_main{
	// required variables 
	
	private $wpdevart_comment_plugin_url;
	
	private $wpdevart_comment_plugin_path;
	
	private $wpdevart_comment_version;
	
	public $wpdevart_comment_options;
	
	
	function __construct(){
		
		$this->wpdevart_comment_plugin_url  = trailingslashit( plugins_url('', __FILE__ ) );
		$this->wpdevart_comment_plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		if(!class_exists('wpdevart_comment_setting'))
			require_once($this->wpdevart_comment_plugin_path.'includes/library.php');
		$this->wpdevart_comment_version     = 10.0;
		$this->call_base_filters();
		$this->install_databese();
		$this->create_admin_menu();	
		$this->wpdevart_comment_front_end();
		
	}
	
	public function create_admin_menu(){
		
		require_once($this->wpdevart_comment_plugin_path.'includes/admin_menu.php');
		
		$wpdevart_comment_admin_menu = new wpdevart_comment_admin_menu(array('menu_name' => 'FB comments','databese_parametrs'=>$this->wpdevart_comment_options));
		
		add_action('admin_menu', array($wpdevart_comment_admin_menu,'create_menu'));
		
	}
	
	public function install_databese(){
		
		require_once($this->wpdevart_comment_plugin_path.'includes/install_database.php');
		
		$wpdevart_comment_install_database = new wpdevart_comment_install_database();
		
		$this->wpdevart_comment_options = $wpdevart_comment_install_database->installed_options;
		
	}
	
	public function wpdevart_comment_front_end(){
		
		require_once($this->wpdevart_comment_plugin_path.'includes/front_end.php');
		$wpdevart_comment_front_end = new wpdevart_comment_front_end(array('menu_name' => 'Wpdevart Comment','databese_parametrs'=>$this->wpdevart_comment_options));
		
	}
	
	public function registr_requeried_scripts(){
		wp_register_script('comment-box-admin-script',$this->wpdevart_comment_plugin_url.'includes/javascript/admin-wpdevart-comment.js');
		wp_register_style('comment-box-admin-style',$this->wpdevart_comment_plugin_url.'includes/style/admin-style.css');
		
	}
	
	public function call_base_filters(){
		add_action( 'init',  array($this,'registr_requeried_scripts') );
		add_action( 'admin_head',  array($this,'include_requeried_scripts') );
	}
  	public function include_requeried_scripts(){
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style( 'wp-color-picker' );
	}

}
$wpdevart_comment_main = new wpdevart_comment_main();

?>