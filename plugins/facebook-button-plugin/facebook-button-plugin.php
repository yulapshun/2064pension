<?php
/*##
Plugin Name: Facebook Button by BestWebSoft
Plugin URI: http://bestwebsoft.com/products/
Description: Put Facebook Button in to your post.
Author: BestWebSoft
Text Domain: facebook-button-plugin
Domain Path: /languages
Version: 2.48
Author URI: http://bestwebsoft.com/
License: GPLv2 or later
*/

/*  Copyright 2016  BestWebSoft  ( http://support.bestwebsoft.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Add BWS menu */
if ( ! function_exists( 'fcbkbttn_add_pages' ) ) {
	function fcbkbttn_add_pages() {
		bws_general_menu();
		$settings = add_submenu_page( 'bws_plugins', __( 'Facebook Button Settings', 'facebook-button-plugin' ), 'Facebook Button', 'manage_options', 'facebook-button-plugin.php', 'fcbkbttn_settings_page' );
		add_action( 'load-' . $settings, 'fcbkbttn_add_tabs' );
	}
}
/* end fcbkbttn_add_pages ##*/

if ( ! function_exists( 'fcbkbttn_plugins_loaded' ) ) {
	function fcbkbttn_plugins_loaded() {
		/* Internationalization, first(!) */
		load_plugin_textdomain( 'facebook-button-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

/* Initialization */
if ( ! function_exists( 'fcbkbttn_init' ) ) {
	function fcbkbttn_init() {
		global $fcbkbttn_plugin_info, $fcbkbttn_lang_codes, $fcbkbttn_options;

		if ( empty( $fcbkbttn_plugin_info ) ) {
			if ( ! function_exists( 'get_plugin_data' ) )
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$fcbkbttn_plugin_info = get_plugin_data( __FILE__ );
		}

		/*## add general functions */
		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		
		bws_wp_min_version_check( plugin_basename( __FILE__ ), $fcbkbttn_plugin_info, '3.8' );/* check compatible with current WP version ##*/

		/* Get options from the database */
		if ( ! is_admin() || ( isset( $_GET['page'] ) && ( "facebook-button-plugin.php" == $_GET['page'] || "social-buttons.php" == $_GET['page'] ) ) ) {
			/* Get/Register and check settings for plugin */
			fcbkbttn_settings();
			
			$fcbkbttn_lang_codes = array(
				"af_ZA" => 'Afrikaans', "ar_AR" => 'العربية', "az_AZ" => 'Azərbaycan dili', "be_BY" => 'Беларуская', "bg_BG" => 'Български', "bn_IN" => 'বাংলা', "bs_BA" => 'Bosanski', "ca_ES" => 'Català', "cs_CZ" => 'Čeština', "cy_GB" => 'Cymraeg', "da_DK" => 'Dansk', "de_DE" => 'Deutsch', "el_GR" => 'Ελληνικά', "en_US" => 'English', "en_PI" => 'English (Pirate)', "eo_EO" => 'Esperanto', "es_CO" => 'Español (Colombia)', "es_ES" => 'Español (España)', "es_LA" => 'Español', "et_EE" => 'Eesti', "eu_ES" => 'Euskara', "fa_IR" => 'فارسی', "fb_LT" => 'Leet Speak', "fi_FI" => 'Suomi', "fo_FO" => 'Føroyskt', "fr_CA" => 'Français (Canada)', "fr_FR" => 'Français (France)', "fy_NL" => 'Frysk', "ga_IE" => 'Gaeilge', "gl_ES" => 'Galego', "gn_PY" => "Avañe'ẽ", "gu_IN" => 'ગુજરાતી', "he_IL" => 'עברית', "hi_IN" => 'हिन्दी', "hr_HR" => 'Hrvatski', "hu_HU" => 'Magyar', "hy_AM" => 'Հայերեն', "id_ID" => 'Bahasa Indonesia', "is_IS" => 'Íslenska', "it_IT" => 'Italiano', "ja_JP" => '日本語', "jv_ID" => 'Basa Jawa', "ka_GE" => 'ქართული', "kk_KZ" => 'Қазақша', "km_KH" => 'ភាសាខ្មែរ', "kn_IN" => 'ಕನ್ನಡ', "ko_KR" => '한국어', "ku_TR" => 'Kurdî', "la_VA" => 'lingua latina', "lt_LT" => 'Lietuvių', "lv_LV" => 'Latviešu', "mk_MK" => 'Македонски', "ml_IN" => 'മലയാളം', "mn_MN" => 'Монгол', "mr_IN" => 'मराठी', "ms_MY" => 'Bahasa Melayu', "nb_NO" => 'Norsk (bokmål)', "ne_NP" => 'नेपाली', "nl_BE" => 'Nederlands (België)', "nl_NL" => 'Nederlands', "nn_NO" => 'Norsk (nynorsk)', "pa_IN" => 'ਪੰਜਾਬੀ', "pl_PL" => 'Polski', "ps_AF" => 'پښتو', "pt_BR" => 'Português (Brasil)', "pt_PT" => 'Português (Portugal)', "ro_RO" => 'Română', "ru_RU" => 'Русский', "sk_SK" => 'Slovenčina', "sl_SI" => 'Slovenščina', "sq_AL" => 'Shqip', "sr_RS" => 'Српски', "sv_SE" => 'Svenska', "sw_KE" => 'Kiswahili', "ta_IN" => 'தமிழ்', "te_IN" => 'తెలుగు', "tg_TJ" => 'тоҷикӣ', "th_TH" => 'ภาษาไทย', "tl_PH" => 'Filipino', "tr_TR" => 'Türkçe', "uk_UA" => 'Українська', "ur_PK" => 'اردو', "uz_UZ" => "O'zbek", "vi_VN" => 'Tiếng Việt', "zh_CN" => '中文(简体)', "zh_HK" => '中文(香港)', "zh_TW" => '中文(台灣)' 											
			);
			
			if ( ! is_admin() && isset( $fcbkbttn_options['display_for_excerpt'] ) && 1 == $fcbkbttn_options['display_for_excerpt'] )
				add_filter( 'the_excerpt', 'fcbkbttn_display_button' );
		}
	}
}
/* End function init */

/* Function for admin_init */
if ( ! function_exists( 'fcbkbttn_admin_init' ) ) {
	function fcbkbttn_admin_init() {
		/* Add variable for bws_menu */
		global $bws_plugin_info, $fcbkbttn_plugin_info, $bws_shortcode_list;
		
		/*## Function for bws menu */
		if ( ! isset( $bws_plugin_info ) || empty( $bws_plugin_info ) )	{
			$bws_plugin_info = array( 'id' => '78', 'version' => $fcbkbttn_plugin_info["Version"] );
		}

		/* add Facebook to global $bws_shortcode_list ##*/
		$bws_shortcode_list['fcbkbttn'] = array( 'name' => 'Facebook Button' );
	}
}
/* end fcbkbttn_admin_init */

if ( ! function_exists( 'fcbkbttn_settings' ) ) {
	function fcbkbttn_settings() {
		global $fcbkbttn_options, $fcbkbttn_plugin_info, $fcbkbttn_options_default;

		$fcbkbttn_options_default = array(
			'plugin_option_version'		=> $fcbkbttn_plugin_info["Version"],
			'link'						=>	'',
			'my_page'					=>	1,
			'like'						=>	1,
			'layout_option'             =>  'button_count',
			'like_action'               =>  'like',
			'color_scheme'              =>  'light',
			'share'						=>	0,
			'faces'						=>	0,
			'width'						=>	450,
			'where'						=>	'before',
			'display_option'			=>	'standard',
			'count_icon'				=>	1,
			'extention'					=>	'png',
			'fb_img_link'				=>	plugins_url( "images/standard-facebook-ico.png", __FILE__ ),
			'locale' 					=>	'en_US',
			'html5'						=>	0,
			'use_multilanguage_locale'	=>  0,
			'display_for_excerpt'		=>  0,
			'display_settings_notice'	=>	1,
			'first_install'				=>	strtotime( "now" ),
			'suggest_feature_banner'	=> 1
		);
		/* Install the option defaults */
		if ( ! get_option( 'fcbk_bttn_plgn_options' ) ) {
			if ( false !== get_option( 'fcbk_bttn_plgn_options_array' ) ) {
				$old_options = get_option( 'fcbk_bttn_plgn_options_array' );
				foreach ( $fcbkbttn_options_default as $key => $value ) {
					if ( isset( $old_options['fcbk_bttn_plgn_' . $key ] ) )
					$fcbkbttn_options_default[ $key ] = $old_options['fcbk_bttn_plgn_' . $key ];
				}
				update_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options_default );
				delete_option( 'fcbk_bttn_plgn_options_array' );
			}
			add_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options_default );
		}
		/* Get options from the database */
		$fcbkbttn_options = get_option( 'fcbk_bttn_plgn_options' );

		if ( ! isset( $fcbkbttn_options['plugin_option_version'] ) || $fcbkbttn_options['plugin_option_version'] != $fcbkbttn_plugin_info["Version"] ) {
			if ( stristr( $fcbkbttn_options['fb_img_link'], 'standart-facebook-ico.jpg' ) || stristr( $fcbkbttn_options['fb_img_link'], 'standart-facebook-ico.png' ) )
				$fcbkbttn_options['fb_img_link'] = plugins_url( "images/standard-facebook-ico.png", __FILE__ );	

			if ( 'standart' == $fcbkbttn_options['display_option'] )
				$fcbkbttn_options['display_option'] = 'standard';

			if ( stristr( $fcbkbttn_options['fb_img_link'], 'img/' ) )
				$fcbkbttn_options['fb_img_link'] = plugins_url( str_replace( 'img/', 'images/', $fcbkbttn_options['fb_img_link'] ), __FILE__ );	

			$fcbkbttn_options_default['display_settings_notice'] = 0;

			/* show pro features */
			$fcbkbttn_options['hide_premium_options'] = array();

			$fcbkbttn_options = array_merge( $fcbkbttn_options_default, $fcbkbttn_options );
			$fcbkbttn_options['plugin_option_version'] = $fcbkbttn_plugin_info["Version"];
			update_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options );
		}
	}
}

/* Function formed content of the plugin's admin page. */
if ( ! function_exists( 'fcbkbttn_settings_page' ) ) {
	function fcbkbttn_settings_page() {
		global $fcbkbttn_options, $wp_version, $fcbkbttn_plugin_info, $fcbkbttn_options_default, $fcbkbttn_lang_codes;
		$message = $error = "";
		$upload_dir = wp_upload_dir();
		$plugin_basename = plugin_basename( __FILE__ );

		if ( ! function_exists( 'get_plugins' ) || ! function_exists( 'is_plugin_active' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$all_plugins = get_plugins();

		if ( isset( $_REQUEST['fcbkbttn_form_submit'] ) && check_admin_referer( $plugin_basename, 'fcbkbttn_nonce_name' ) ) {
			if ( isset( $_POST['bws_hide_premium_options'] ) ) {
				$hide_result = bws_hide_premium_options( $fcbkbttn_options );
				$fcbkbttn_options = $hide_result['options'];
			}

			/* Takes all the changed settings on the plugin's admin page and saves them in array 'fcbk_bttn_plgn_options'. */
			$fcbkbttn_options['link']			 =	stripslashes( esc_html( $_REQUEST['fcbkbttn_link'] ) );
			$fcbkbttn_options['link']			 = 	str_replace( 'https://www.facebook.com/profile.php?id=', '', $fcbkbttn_options['link'] );
			$fcbkbttn_options['link']			 = 	str_replace( 'https://www.facebook.com/', '', $fcbkbttn_options['link'] );

			$fcbkbttn_options['where']			 =	$_REQUEST['fcbkbttn_where'];
			$fcbkbttn_options['display_option']	 =	$_REQUEST['fcbkbttn_display_option'];
			if ( 'standard' == $fcbkbttn_options['display_option'] ) {
				$fcbkbttn_options['fb_img_link'] = plugins_url( 'images/standard-facebook-ico.png', __FILE__ );
			}				
			$fcbkbttn_options['my_page']		 =	isset( $_REQUEST['fcbkbttn_my_page'] ) ? 1 : 0;
			$fcbkbttn_options['like']			 =	isset( $_REQUEST['fcbkbttn_like'] ) ? 1 : 0;
			$fcbkbttn_options['layout_option']   =   $_REQUEST['fcbkbttn_layout_option'];
			$fcbkbttn_options['share']			 =	isset( $_REQUEST['fcbkbttn_share'] ) ? 1 : 0;
			$fcbkbttn_options['faces']           =   isset( $_REQUEST['fcbkbttn_faces'] ) ? 1 : 0;
			$fcbkbttn_options['like_action']     =   $_REQUEST['fcbkbttn_like_action'];
			$fcbkbttn_options['color_scheme']    =   $_REQUEST['fcbkbttn_color_scheme'];
			$fcbkbttn_options['width']           =   intval( $_REQUEST['fcbkbttn_width'] );
			$fcbkbttn_options['locale']			 =	$_REQUEST['fcbkbttn_locale'];
			$fcbkbttn_options['html5']			 = 	$_REQUEST['fcbkbttn_html5'];
			if ( isset( $_FILES['fcbkbttn_uploadfile']['tmp_name'] ) &&  $_FILES['fcbkbttn_uploadfile']['tmp_name'] != "" ) {
				$fcbkbttn_options['count_icon']	 =	$fcbkbttn_options['count_icon'] + 1;
				$file_ext = wp_check_filetype( $_FILES['fcbkbttn_uploadfile']['name'] );
				$fcbkbttn_options['extention']   = $file_ext['ext'];
			}

			if ( 2 < $fcbkbttn_options['count_icon'] )
				$fcbkbttn_options['count_icon']	=	1;

			$fcbkbttn_options['use_multilanguage_locale'] =	isset( $_REQUEST['fcbkbttn_use_multilanguage_locale'] ) ? 1 : 0;
			$fcbkbttn_options['display_for_excerpt'] =	isset( $_REQUEST['fcbkbttn_display_for_excerpt'] ) ? 1 : 0;

			update_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options );
			$message = __( "Settings saved", 'facebook-button-plugin' );
			
			if ( isset( $_FILES['fcbkbttn_uploadfile']['tmp_name'] ) &&  "" != $_FILES['fcbkbttn_uploadfile']['tmp_name'] ) {
				if ( ! $upload_dir["error"] ) {
					$fcbkbttn_cstm_mg_folder = $upload_dir['basedir'] . '/facebook-image';
					if ( ! is_dir( $fcbkbttn_cstm_mg_folder ) ) {
						wp_mkdir_p( $fcbkbttn_cstm_mg_folder, 0755 );
					}
				}
				$max_image_width	=	100;
				$max_image_height	=	40;
				$max_image_size		=	32 * 1024;
				$valid_types 		=	array( 'jpg', 'jpeg', 'png' );
				/* Construction to rename downloading file */
				$new_name			=	'facebook-ico' . $fcbkbttn_options['count_icon'];
				$new_ext			=	wp_check_filetype( $_FILES['fcbkbttn_uploadfile']['name'] );
				$namefile			=	$new_name . '.' . $new_ext['ext'];
				$uploadfile			=	$fcbkbttn_cstm_mg_folder . '/' . $namefile;

				/* Checks is file download initiated by user */
				if ( isset( $_FILES['fcbkbttn_uploadfile'] ) && 'custom' == $_REQUEST['fcbkbttn_display_option'] ) {
					/* Checking is allowed download file given parameters */
					if ( is_uploaded_file( $_FILES['fcbkbttn_uploadfile']['tmp_name'] ) ) {
						$filename	=	$_FILES['fcbkbttn_uploadfile']['tmp_name'];
						$ext		=	substr( $_FILES['fcbkbttn_uploadfile']['name'], 1 + strrpos( $_FILES['fcbkbttn_uploadfile']['name'], '.' ) );
						if ( filesize( $filename ) > $max_image_size ) {
							$error	=	__( "Error: File size > 32K", 'facebook-button-plugin' );
						}
						elseif ( ! in_array( strtolower( $ext ), $valid_types ) ) {
							$error	=	__( "Error: Invalid file type", 'facebook-button-plugin' );
						} else {
							$size	=	GetImageSize( $filename );
							if ( $size && $size[0] <= $max_image_width && $size[1] <= $max_image_height ) {
								/* If file satisfies requirements, we will move them from temp to your plugin folder and rename to 'facebook_ico.jpg' */
								if ( move_uploaded_file( $_FILES['fcbkbttn_uploadfile']['tmp_name'], $uploadfile ) ) {
									$message .= '. ' . __( "Upload successful.", 'facebook-button-plugin' );
									
									if ( 'standard' == $fcbkbttn_options['display_option'] ) {
										$fb_img_link = plugins_url( 'images/standard-facebook-ico.png', __FILE__ );
									} else if ( 'custom' == $fcbkbttn_options['display_option'] ) {
										$fb_img_link = $upload_dir['baseurl'] . '/facebook-image/facebook-ico' . $fcbkbttn_options['count_icon'] . '.' . $fcbkbttn_options['extention'];
									}
									$fcbkbttn_options['fb_img_link'] = $fb_img_link ;
									update_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options );
								} else {
									$error = __( "Error: moving file failed", 'facebook-button-plugin' );
								}
							} else {
								$error = __( "Error: check image width or height", 'facebook-button-plugin' );
							}
						}
					} else {
						$error = __( "Uploading Error: check image properties", 'facebook-button-plugin' );
					}
				}
			}
		}

		/*## check banner */
		$bws_hide_premium_options_check = bws_hide_premium_options_check( $fcbkbttn_options );

		/* add restore function */
		if ( isset( $_REQUEST['bws_restore_confirm'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
			$fcbkbttn_options = $fcbkbttn_options_default;
			update_option( 'fcbk_bttn_plgn_options', $fcbkbttn_options );
			$message = __( 'All plugin settings were restored.', 'facebook-button-plugin' );
		}

		/* GO PRO */
		if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) {
			$go_pro_result = bws_go_pro_tab_check( $plugin_basename, 'fcbk_bttn_plgn_options' );
			if ( ! empty( $go_pro_result['error'] ) )
				$error = $go_pro_result['error'];
			elseif ( ! empty( $go_pro_result['message'] ) )
				$message = $go_pro_result['message'];
		}/* end GO PRO ##*/ ?>
		<!-- general -->
		<div class="wrap">
			<h1><?php _e( 'Facebook Button Settings', 'facebook-button-plugin' ); ?></h1>
			<ul class="subsubsub fcbkbttn_how_to_use">
				<li><a href="https://docs.google.com/document/d/1gy5uDVoebmYRUvlKRwBmc97jdJFz7GvUCtXy3L7r_Yg/edit" target="_blank"><?php _e( 'How to Use Step-by-step Instruction', 'facebook-button-plugin' ); ?></a></li>
			</ul>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab<?php if ( ! isset( $_GET['action'] ) ) echo ' nav-tab-active'; ?>" href="admin.php?page=facebook-button-plugin.php"><?php _e( 'Settings', 'facebook-button-plugin' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'extra' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=facebook-button-plugin.php&amp;action=extra"><?php _e( 'Extra settings', 'facebook-button-plugin' ); ?></a>
				<a class="nav-tab<?php if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=facebook-button-plugin.php&amp;action=custom_code"><?php _e( 'Custom code', 'facebook-button-plugin' ); ?></a>
				<a class="nav-tab bws_go_pro_tab<?php if ( isset( $_GET['action'] ) && 'go_pro' == $_GET['action'] ) echo ' nav-tab-active'; ?>" href="admin.php?page=facebook-button-plugin.php&amp;action=go_pro"><?php _e( 'Go PRO', 'facebook-button-plugin' ); ?></a>
			</h2>
			<!-- end general -->
			<noscript><div class="error below-h2"><p><strong><?php _e( "Please, enable JavaScript in Your browser.", 'facebook-button-plugin' ); ?></strong></p></div></noscript>
			<div class="updated fade below-h2" <?php if ( empty( $message ) || "" != $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $message; ?></strong></p></div>
			<div class="error below-h2" <?php if ( "" == $error ) echo "style=\"display:none\""; ?>><p><strong><?php echo $error; ?></strong></p></div>
			<?php if ( ! empty( $hide_result['message'] ) ) { ?>
				<div class="updated fade below-h2"><p><strong><?php echo $hide_result['message']; ?></strong></p></div>
			<?php }
			bws_show_settings_notice();
			/*## check action */ 
			if ( ! isset( $_GET['action'] ) ) {
				if ( isset( $_REQUEST['bws_restore_default'] ) && check_admin_referer( $plugin_basename, 'bws_settings_nonce_name' ) ) {
					bws_form_restore_default_confirm( $plugin_basename );
				} else { /* check action ##*/ ?>
					<br>
					<div><?php $icon_shortcode = ( "facebook-button-plugin.php" == $_GET['page'] ) ? plugins_url( 'bws_menu/images/shortcode-icon.png', __FILE__ ) : plugins_url( 'social-buttons-pack/bws_menu/images/shortcode-icon.png' );
					printf( 
						__( "If you would like to add Facebook buttons to your page or post, please use %s button", 'facebook-button-plugin' ), 
						'<span class="bws_code"><img style="vertical-align: sub;" src="' . $icon_shortcode . '" alt=""/></span>' ); ?> 
						<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help">
							<div class="bws_hidden_help_text" style="min-width: 180px;">
								<?php printf( 
									__( "You can add Facebook buttons to your page or post by clicking on %s button in the content edit block using the Visual mode. If the button isn't displayed, please use the shortcode %s", 'facebook-button-plugin' ), 
									'<code><img style="vertical-align: sub;" src="' . $icon_shortcode . '" alt="" /></code>',
									'<code>[fb_button]</code>'
								); ?>
							</div>
						</div>
					</div>
					<form method="post" action="" enctype="multipart/form-data" class="bws_form">
						<div id="fcbkbttn_settings_form">
							<table class="form-table">
								<tr>
									<th scope="row"><?php _e( 'Display button', 'facebook-button-plugin' ); ?></th>
									<td>
										<fieldset>
											<label><input name='fcbkbttn_my_page' type='checkbox' value='1' <?php if ( 1 == $fcbkbttn_options['my_page'] ) echo 'checked="checked "'; ?>/> <?php _e( "My Page", 'facebook-button-plugin' ); ?></label><br />
											<label><input name='fcbkbttn_like' type='checkbox' <?php if ( 0 !== ( $fcbkbttn_options['like'] ) ) echo 'checked="checked "'; ?>/> <?php _e( "Like", 'facebook-button-plugin' ); ?></label><br />
											<label><input name='fcbkbttn_share' type='checkbox' value='1' <?php if ( 1 == $fcbkbttn_options['share'] ) echo 'checked="checked "'; ?>/> <?php _e( "Share", 'facebook-button-plugin' ); ?></label><br />
										</fieldset>
									</td>
								</tr>
								<tr>
									<th><?php _e( 'Facebook buttons position', 'facebook-button-plugin' ); ?></th>
									<td>
										<select name="fcbkbttn_where">
											<option <?php if ( 'before' == $fcbkbttn_options['where']  ) echo 'selected="selected"'; ?> value="before"><?php _e( "Before", 'facebook-button-plugin' ); ?></option>
											<option <?php if ( 'after' == $fcbkbttn_options['where']  ) echo 'selected="selected"'; ?> value="after"><?php _e( "After", 'facebook-button-plugin' ); ?></option>
											<option <?php if ( 'beforeandafter' == $fcbkbttn_options['where']  ) echo 'selected="selected"'; ?> value="beforeandafter"><?php _e( "Before and After", 'facebook-button-plugin' ); ?></option>
											<option <?php if ( 'shortcode' == $fcbkbttn_options['where'] ) echo 'selected="selected"'; ?> value="shortcode"><?php _e( "Shortcode", 'facebook-button-plugin' ); ?></option>
										</select>
									</td>
								</tr>
								<tr>
									<th><?php _e( "Facebook buttons language", 'facebook-button-plugin' ); ?></th>
									<td>
										<fieldset>
											<select name="fcbkbttn_locale">
												<?php foreach ( $fcbkbttn_lang_codes as $key => $val ) {
													echo '<option value="' . $key . '"';
													if ( $key == $fcbkbttn_options['locale'] )
														echo ' selected="selected"';
													echo '>' . esc_html ( $val ) . '</option>';
												} ?>
											</select>
											<span class="bws_info"><?php _e( 'Change the language of Facebook Button', 'facebook-button-plugin' ); ?></span><br />
											<label>
												<?php if ( array_key_exists( 'multilanguage/multilanguage.php', $all_plugins ) || array_key_exists( 'multilanguage-pro/multilanguage-pro.php', $all_plugins ) ) {
													if ( is_plugin_active( 'multilanguage/multilanguage.php' ) || is_plugin_active( 'multilanguage-pro/multilanguage-pro.php' ) ) { ?>
														<input type="checkbox" name="fcbkbttn_use_multilanguage_locale" value="1" <?php if ( 1 == $fcbkbttn_options["use_multilanguage_locale"] ) echo 'checked="checked"'; ?> />
														<?php _e( 'Use the current site language', 'facebook-button-plugin' ); ?> <span class="bws_info">(<?php _e( 'Using', 'facebook-button-plugin' ); ?> Multilanguage by BestWebSoft)</span>
													<?php } else { ?>
														<input disabled="disabled" type="checkbox" name="fcbkbttn_use_multilanguage_locale" value="1" />
														<?php _e( 'Use the current site language', 'facebook-button-plugin' ); ?>
														<span class="bws_info">(<?php _e( 'Using', 'facebook-button-plugin' ); ?> Multilanguage by BestWebSoft) <a href="<?php echo bloginfo( "url" ); ?>/wp-admin/plugins.php"><?php _e( 'Activate', 'facebook-button-plugin' ); ?> Multilanguage</a></span>
													<?php }
												} else { ?>
													<input disabled="disabled" type="checkbox" name="fcbkbttn_use_multilanguage_locale" value="1" />
													<?php _e( 'Use the current site language', 'facebook-button-plugin' ); ?>
													<span class="bws_info">(<?php _e( 'Using', 'facebook-button-plugin' ); ?> Multilanguage by BestWebSoft) <a href="http://bestwebsoft.com/products/multilanguage/?k=196fb3bb74b6e8b1e08f92cddfd54313&pn=78&v=<?php echo $fcbkbttn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>"><?php _e( 'Download', 'facebook-button-plugin' ); ?> Multilanguage</a></span>
												<?php } ?>
											</label>
										</fieldset>
									</td>
								</tr>
								<tr>
									<th><?php _e( 'Display buttons in excerpt', 'facebook-button-plugin' ); ?></th>
									<td>
										<input name='fcbkbttn_display_for_excerpt' type='checkbox' value='1' <?php if ( 1 == $fcbkbttn_options['display_for_excerpt'] ) echo 'checked="checked "'; ?>/>
									</td>
								</tr>
							</table>
							<!-- general -->
							<?php if ( ! $bws_hide_premium_options_check ) { ?>
								<div class="bws_pro_version_bloc">
									<div class="bws_pro_version_table_bloc">
										<button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'facebook-button-plugin' ); ?>"></button>
										<div class="bws_table_bg"></div>
										<table class="form-table bws_pro_version">
											<tr>
												<th><?php _e( 'Meta tags', 'facebook-button-plugin' ); ?></th>
												<td>
													<fieldset>
														<legend style="font-weight: 600;"><?php _e( 'Image', 'facebook-button-plugin' ); ?></legend>
														<label>
															<input disabled="disabled" type="radio" name="fcbkbttn_meta_image" value="featured_image" checked="checked" /> 
															<?php _e( 'Featured Image', 'facebook-button-plugin' ); ?>
														</label><br />
														<label>
															<input disabled="disabled" type="radio" name="fcbkbttn_meta_image" value="custom_image" />
															<?php _e( 'Custom Image', 'facebook-button-plugin' ); ?> <span class="bws_info">(<?php _e( 'This image will be used for all of the posts', 'facebook-button-plugin' ); ?>)</span>
														</label><br />
														<input disabled="disabled" name="fcbkbttn_meta_uploadfile" type="file" />
													</fieldset>
												</td>
											</tr>
											<tr>
												<th></th>
												<td>
													<fieldset>
														<legend style="font-weight: 600;"><?php _e( 'Description', 'facebook-button-plugin' ); ?></legend>
														<label>
															<input disabled="disabled" type="radio" name="fcbkbttn_meta_description" value="post_excerpt" /> 
															<?php _e( 'Post excerpt', 'facebook-button-plugin' );?>
														</label><br />
														<label>
															<input disabled="disabled" type="radio" name="fcbkbttn_meta_description" value="custom" checked="checked" />
															<input disabled="disabled" type="text" name="fcbkbttn_meta_description_custom" value="" /><br />
															<span class="bws_info"><?php _e( 'This description will be used for all of the posts', 'facebook-button-plugin' ); ?></span>
														</label>
													</fieldset>
												</td>
											</tr>
											<tr>
												<th scope="row" colspan="2">
													* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'facebook-button-plugin' ); ?>
												</th>
											</tr>
										</table>
									</div>
									<div class="bws_pro_version_tooltip">
										<div class="bws_info">
											<?php _e( 'Unlock premium options by upgrading to Pro version', 'facebook-button-plugin' ); ?>
										</div>
										<a class="bws_button" href="http://bestwebsoft.com/products/facebook-like-button/?k=427287ceae749cbd015b4bba6041c4b8&pn=78&v=<?php echo $fcbkbttn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Facebook Button Pro"><?php _e( 'Learn More', 'facebook-button-plugin' ); ?></a>
										<div class="clear"></div>
									</div>
								</div>
							<?php } ?>
							<!-- end general -->
							<table class="form-table">
								<tr id="fcbkbttn_id_option" class="fcbkbttn_my_page" <?php if ( 1 != $fcbkbttn_options['my_page'] ) echo 'style="display:none"'; ?>>
									<th scope="row"><?php _e( 'Your Facebook ID or username', 'facebook-button-plugin' ); ?></th>
									<td>
										<input name='fcbkbttn_link' type='text' maxlength='250' value='<?php echo $fcbkbttn_options['link']; ?>' />
									</td>
								</tr>
								<tr class="fcbkbttn_my_page" <?php if ( 1 != $fcbkbttn_options['my_page'] ) echo 'style="display:none"'; ?>>
									<th>
										<?php _e( '"My page" button image', 'facebook-button-plugin' ); ?>
									</th>
									<td>
										<?php if ( scandir( $upload_dir['basedir'] ) && is_writable( $upload_dir['basedir'] ) ) { ?>
											<select name="fcbkbttn_display_option">
												<option <?php if ( 'standard' == $fcbkbttn_options['display_option'] ) echo 'selected="selected"'; ?> value="standard"><?php _e( 'Standard Facebook image', 'facebook-button-plugin' ); ?></option>
												<option <?php if ( 'custom' == $fcbkbttn_options['display_option'] ) echo 'selected="selected"'; ?> value="custom"><?php _e( 'Custom Facebook image', 'facebook-button-plugin' ); ?></option>
											</select>
										<?php } else {
											echo __( 'To use custom image you need to setup permissions to upload directory of your site', 'facebook-button-plugin' ) . " - " . $upload_dir['basedir'];
										} ?>
									</td>
								</tr>
								<tr class="fcbkbttn_my_page" <?php if ( 1 != $fcbkbttn_options['my_page'] ) echo 'style="display:none"'; ?>>
									<th></th>
									<td>
										<?php _e( 'Current image', 'facebook-button-plugin' ); ?>:
										<img src="<?php echo $fcbkbttn_options['fb_img_link']; ?>" style="vertical-align: middle;" />
									</td>
								</tr>
								<tr class="fcbkbttn_my_page" id="fcbkbttn_display_option_custom" <?php if ( ! ( 1 == $fcbkbttn_options['my_page'] && 'custom' == $fcbkbttn_options['display_option'] ) ) echo 'style="display:none"'; ?>>
									<th></th>
									<td>
										<input name="fcbkbttn_uploadfile" type="file" /><br />
										<span class="bws_info"><?php _e( 'Image properties: max image width:100px; max image height:40px; max image size:32Kb; image types:"jpg", "jpeg", "png".', 'facebook-button-plugin' ); ?></span>
									</td>
								</tr>
								<tr id="fcbkbttn_layout_option" class="fcbkbttn_like fcbkbttn_share" <?php if ( 1 != $fcbkbttn_options['like'] && 1 != $fcbkbttn_options['share'] ) echo 'style="display: none"'; ?>>
									<th><?php _e( 'Button layout', 'facebook-button-plugin' ); ?></th>
									<td>
										<select name="fcbkbttn_layout_option">
											<option class="fcbkbttn_like_layout" <?php if ( 1 != $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?><?php if ( 'standard' == $fcbkbttn_options['layout_option'] || 1 == $fcbkbttn_options['like'] ) echo 'selected="selected"'; ?> value="standard">standard</option>
											<option <?php if ( 'box_count' == $fcbkbttn_options['layout_option']  ) echo 'selected="selected"'; ?> value="box_count">box_count</option>
											<option <?php if ( 'button_count' == $fcbkbttn_options['layout_option']  ) echo 'selected="selected"'; ?> value="button_count">button_count</option>
											<option <?php if ( 'button' == $fcbkbttn_options['layout_option'] ) echo 'selected="selected"'; ?> value="button">button</option>
											<option class="fcbkbttn_share_layout" <?php if ( 1 == $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?><?php if ( 'icon_link' == $fcbkbttn_options['layout_option'] && 0 == $fcbkbttn_options['like'] ) echo 'selected="selected"'; ?> value="icon_link">Icon link</option>
											<option class="fcbkbttn_share_layout" <?php if ( 1 == $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?><?php if ( 'icon' == $fcbkbttn_options['layout_option'] && 0 == $fcbkbttn_options['like'] ) echo 'selected="selected"'; ?> value="icon">Icon</option>
											<option class="fcbkbttn_share_layout" <?php if ( 1 == $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?><?php if ( 'link' == $fcbkbttn_options['layout_option'] && 0 == $fcbkbttn_options['like'] ) echo 'selected="selected"'; ?> value="link">Link</option>
										</select>
									</td>
								</tr>
								<tr class="fcbkbttn_like" <?php if ( 1 !== $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?>>
									<th><?php _e( 'Like button action', 'facebook-button-plugin' ); ?></th>
									<td>
										<select name="fcbkbttn_like_action">
											<option <?php if ( 'like' == $fcbkbttn_options['like_action']  ) echo 'selected="selected"'; ?> value="like"><?php _e( 'Like', 'facebook-button-plugin' ); ?></option>
											<option <?php if ( 'recommend' == $fcbkbttn_options['like_action']  ) echo 'selected="selected"'; ?> value="recommend"><?php _e( 'Recommend', 'facebook-button-plugin' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="fcbkbttn_like fcbkbttn_like_standard_layout" <?php if ( 1 !== $fcbkbttn_options['like'] || 'standard' != $fcbkbttn_options['layout_option'] ) echo 'style="display: none"'; ?>>
									<th><?php _e( 'Show faces', 'facebook-button-plugin' ); ?></th>
									<td>
										<input name="fcbkbttn_faces" type='checkbox' value="1" <?php if ( 1 == $fcbkbttn_options['faces'] ) echo 'checked="checked"'; ?> />
									</td>
								</tr>
								<tr class="fcbkbttn_like fcbkbttn_like_standard_layout" <?php if ( 'standard' !== $fcbkbttn_options['layout_option'] ) echo 'style="display:none"'; ?>>
									<th><?php _e( 'Layout width', 'facebook-button-plugin' ); ?></th>
									<td>
										<label><input name="fcbkbttn_width" type="number" step="1" min="225" value="<?php echo $fcbkbttn_options['width']; ?>"> px</label>
									</td>
								</tr>
								<tr class="fcbkbttn_like fcbkbttn_like_standard_layout" <?php if ( 1 !== $fcbkbttn_options['like'] || 'standard' != $fcbkbttn_options['layout_option'] ) echo 'style="display: none"'; ?>>
									<th><?php _e( 'Color scheme', 'facebook-button-plugin' ); ?></th>
									<td>
										<select name="fcbkbttn_color_scheme">
											<option <?php if ( 'light' == $fcbkbttn_options['color_scheme']  ) echo 'selected="selected"'; ?> value="light"><?php _e( 'Light', 'facebook-button-plugin' ); ?></option>
											<option <?php if ( 'dark' == $fcbkbttn_options['color_scheme']  ) echo 'selected="selected"'; ?> value="dark"><?php _e( 'Dark', 'facebook-button-plugin' ); ?></option>
										</select>
									</td>
								</tr>
								<tr class="fcbkbttn_like" <?php if ( 1 !== $fcbkbttn_options['like'] ) echo 'style="display: none"'; ?>>
									<th scope="row"><?php _e( 'Html tag for "Like" button', 'facebook-button-plugin' ); ?></th>
									<td>
										<fieldset>
											<label><input name='fcbkbttn_html5' type='radio' value='0' <?php if ( 0 == $fcbkbttn_options['html5'] ) echo 'checked="checked "'; ?> /><?php echo "<code>&lt;fb:like&gt;</code>"; ?></label><br />
											<label><input name='fcbkbttn_html5' type='radio' value='1' <?php if ( 1 == $fcbkbttn_options['html5'] ) echo 'checked="checked "'; ?> /><?php echo "<code>&lt;div&gt;</code>"; ?></label>
											<span class="bws_info">(<?php _e( "Use this tag to improve validation of your site", 'facebook-button-plugin' ); ?>)</span>
										</fieldset>
									</td>
								</tr>
							</table>
							<!-- general -->
							<?php if ( ! $bws_hide_premium_options_check ) { ?>
								<div class="bws_pro_version_bloc fcbkbttn_like">
									<div class="bws_pro_version_table_bloc">
										<button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'facebook-button-plugin' ); ?>"></button>
										<div class="bws_table_bg"></div>
										<table class="form-table bws_pro_version">
											<tr>
												<th><?php _e( '"Like" for an entire site on every page:', 'facebook-button-plugin' ); ?></th>
												<td><input disabled="disabled" name='fcbkbttn_entire_site_like' type='checkbox' value='1' /><br />
													<span style="color: rgb(136, 136, 136); font-size: 10px; display:inline"><?php _e( 'Notice: "Like for the entire site" option does not create an extra button. This option merely allows your users to like the entire website when this option is enabled, or a single post when this option is disabled, when clicking the regular "Like" button.', 'facebook-button-plugin'  ); ?></span>
												</td>
											</tr>
											<tr>
												<th scope="row" colspan="2">
													* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'facebook-button-plugin' ); ?>
												</th>
											</tr>
										</table>
									</div>
									<div class="bws_pro_version_tooltip">
										<div class="bws_info">
											<?php _e( 'Unlock premium options by upgrading to Pro version', 'facebook-button-plugin' ); ?>
										</div>
										<a class="bws_button" href="http://bestwebsoft.com/products/facebook-like-button/?k=427287ceae749cbd015b4bba6041c4b8&pn=78&v=<?php echo $fcbkbttn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Facebook Button Pro"><?php _e( 'Learn More', 'facebook-button-plugin' ); ?></a>
										<div class="clear"></div>
									</div>
								</div>
							<?php } ?>
							<!-- end general -->
							<p class="submit">
								<input type="hidden" name="fcbkbttn_form_submit" value="submit" />
								<input id="bws-submit-button" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'facebook-button-plugin' ); ?>" />
								<?php wp_nonce_field( $plugin_basename, 'fcbkbttn_nonce_name' ); ?>
							</p>
						</div>
						<!-- general -->
						<?php if ( ! $bws_hide_premium_options_check ) { ?>
							<div id="fcbkbttn_preview">
								<div class="bws_pro_version_bloc">
									<div class="bws_pro_version_table_bloc">
										<button type="submit" name="bws_hide_premium_options" class="notice-dismiss bws_hide_premium_options" title="<?php _e( 'Close', 'facebook-button-plugin' ); ?>"></button>
										<div class="bws_table_bg"></div>
										<div id="fcbkbttn_preview_content">
											<h3><?php _e( 'Facebook Button preview:', 'facebook-button-plugin' ); ?></h3>
											<img src='<?php echo plugins_url( 'images/preview.png', __FILE__ ); ?>' />
										</div>
									</div>
									<div class="bws_pro_version_tooltip">
										<div class="bws_info">
											<?php _e( 'Unlock premium options by upgrading to Pro version', 'facebook-button-plugin' ); ?>
										</div>
										<a class="bws_button" href="http://bestwebsoft.com/products/facebook-like-button/?k=427287ceae749cbd015b4bba6041c4b8&pn=78&v=<?php echo $fcbkbttn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Facebook Button Pro"><?php _e( 'Learn More', 'facebook-button-plugin' ); ?></a>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						<?php } ?>
						<!-- end general -->
					</form>
					<!-- general -->
					<?php bws_form_restore_default_settings( $plugin_basename );
				}
			} elseif ( 'extra' == $_GET['action'] ) { ?>
				<div class="bws_pro_version_bloc">
					<div class="bws_pro_version_table_bloc">
						<div class="bws_table_bg"></div>
						<table class="form-table bws_pro_version">
							<tr>
								<td colspan="2">
									<?php _e( 'Please choose the necessary post types (or single pages) where Facebook button will be displayed:', 'facebook-button-plugin' ); ?>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<label>
										<input disabled="disabled" checked="checked" type="checkbox" name="jstree_url" value="1" />
										<?php _e( "Show URL for pages", 'facebook-button-plugin' );?>
									</label>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<img src="<?php echo plugins_url( 'images/pro_screen_1.png', __FILE__ ); ?>" alt="<?php _e( "Example of the site's pages tree", 'facebook-button-plugin' ); ?>" title="<?php _e( "Example of site pages' tree", 'facebook-button-plugin' ); ?>" />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<input disabled="disabled" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'facebook-button-plugin' ); ?>" />
								</td>
							</tr>
							<tr>
								<th scope="row" colspan="2">
									* <?php _e( 'If you upgrade to Pro version all your settings will be saved.', 'facebook-button-plugin' ); ?>
								</th>
							</tr>
						</table>
					</div>
					<div class="bws_pro_version_tooltip">
						<div class="bws_info">
							<?php _e( 'Unlock premium options by upgrading to Pro version', 'facebook-button-plugin' ); ?>
						</div>
						<a class="bws_button" href="http://bestwebsoft.com/products/facebook-like-button/?k=427287ceae749cbd015b4bba6041c4b8&pn=78&v=<?php echo $fcbkbttn_plugin_info["Version"]; ?>&wp_v=<?php echo $wp_version; ?>" target="_blank" title="Facebook Button Pro"><?php _e( 'Learn More', 'facebook-button-plugin' ); ?></a>
						<div class="clear"></div>
					</div>
				</div>
			<?php } elseif ( 'custom_code' == $_GET['action'] ) {
				bws_custom_code_tab();
			} elseif ( 'go_pro' == $_GET['action'] ) { 
				bws_go_pro_tab_show( $bws_hide_premium_options_check, $fcbkbttn_plugin_info, $plugin_basename, 'facebook-button-plugin.php', 'facebook-button-pro.php', 'facebook-button-pro/facebook-button-pro.php', 'facebook-like-button', '427287ceae749cbd015b4bba6041c4b8', '78', isset( $go_pro_result['pro_plugin_is_activated'] ) ); 
			}
			bws_plugin_reviews_block( $fcbkbttn_plugin_info['Name'], 'facebook-button-plugin' ); ?>
		</div>
		<!-- end general -->
	<?php }
}

if ( ! function_exists( 'fcbkbttn_button' ) ) {
	function fcbkbttn_button() {
		global $post, $fcbkbttn_options;

		if ( isset( $post->ID ) )
			$permalink_post	= get_permalink( $post->ID );

		$button	= '<div class="fcbk_share">';
		
		if ( 1 == $fcbkbttn_options['my_page'] ) {
			$button .=	'<div class="fcbk_button">
							<a href="http://www.facebook.com/' . $fcbkbttn_options['link'] . '"	target="_blank">
								<img src="' . $fcbkbttn_options['fb_img_link'] . '" alt="Fb-Button" />
							</a>
						</div>';
		}

		if ( 1 == $fcbkbttn_options['like'] ) {
			$button .= '<div class="fcbk_like">';

			if ( 1 == $fcbkbttn_options['html5'] ) {
				$button .=	'<div class="fb-like" data-href="' . $permalink_post . '" data-colorscheme="' . $fcbkbttn_options['color_scheme'] . '" data-layout="' . $fcbkbttn_options['layout_option'] . '" data-action="' . $fcbkbttn_options['like_action'] . '" ';
				if ( 'standard' == $fcbkbttn_options['layout_option'] ) {
					$button .= ' data-width="' . $fcbkbttn_options['width'] . 'px"';
					$button .= ( 1 == $fcbkbttn_options['faces'] ) ? "data-show-faces='true'" : "data-show-faces='false'";
				}
				$button .= ( 1 == $fcbkbttn_options['share'] ) ? ' data-share="true"' : ' data-share="false"';
				$button .= '></div></div>';
			} else {
				$button .= '<fb:like href="' . $permalink_post . '" action="' . $fcbkbttn_options['like_action'] . '" colorscheme="' . $fcbkbttn_options['color_scheme'] . '" layout="' . $fcbkbttn_options['layout_option'] . '" ';
				if ( 'standard' == $fcbkbttn_options['layout_option'] ) {
					$button .= ( 1 == $fcbkbttn_options['faces'] ) ? "show-faces='true'" : "show-faces='false'";
					$button .= ' width="' . $fcbkbttn_options['width'] . 'px"';
				}
				$button .= ( 1 == $fcbkbttn_options['share'] ) ? ' share="true"' : ' share="false"';
				$button .= '></fb:like></div>';
			}

		} else if ( 1 != $fcbkbttn_options['like'] && 1 == $fcbkbttn_options['share'] ) {
			$button .=	'<div class="fb-share-button" data-href="' . $permalink_post . '" data-type="' . $fcbkbttn_options['layout_option'] . '"></div>';
		}

		$button .= '</div>';

		return $button;
	}
}

/* Function taking from array 'fcbk_bttn_plgn_options' necessary information to create Facebook Button and reacting to your choise in plugin menu - points where it appears. */
if ( ! function_exists( 'fcbkbttn_display_button' ) ) {
	function fcbkbttn_display_button( $content ) {

		if ( is_feed() )
			return $content;

		global $fcbkbttn_options;
		/* Query the database to receive array 'fcbk_bttn_plgn_options' and receiving necessary information to create button */
		$fcbkbttn_where	= $fcbkbttn_options['where'];
		
		$button = fcbkbttn_button();
		/* Indication where show Facebook Button depending on selected item in admin page. */
		if ( 'before' == $fcbkbttn_where ) {
			return $button . $content;
		} else if ( 'after' == $fcbkbttn_where ) {
			return $content . $button;
		} else if ( 'beforeandafter' == $fcbkbttn_where ) {
			return $button . $content . $button;
		} else if ( 'shortcode' == $fcbkbttn_where ) {
			return $content;
		} else {
			return $content;
		}
	}
}

/* Function 'fcbk_bttn_plgn_shortcode' are using to create shortcode by Facebook Button. */
if ( ! function_exists( 'fcbkbttn_shortcode' ) ) {
	function fcbkbttn_shortcode( $content ) {
		global $post, $fcbkbttn_options, $fcbkbttn_shortcode_add_script;

		if ( isset( $post->ID ) )
			$permalink_post	= get_permalink( $post->ID );
		
		$button = fcbkbttn_button();

		if ( ( 1 == $fcbkbttn_options['like'] || 1 == $fcbkbttn_options['share'] ) && isset( $permalink_post ) ) {
			$fcbkbttn_shortcode_add_script = true;			
		}
		return $button;
	}
}

/* add shortcode content  */
if ( ! function_exists( 'fcbkbttn_shortcode_button_content' ) ) {
	function fcbkbttn_shortcode_button_content( $content ) { ?>
		<div id="fcbkbttn" style="display:none;">
			<fieldset>
				<?php _e( 'Add Facebook buttons to your page or post', 'facebook-button-plugin' ); ?>
			</fieldset>
			<input class="bws_default_shortcode" type="hidden" name="default" value="[fb_button]" />
			<div class="clear"></div>
		</div>
	<?php }
}

/* Functions adds some right meta for Facebook */
if ( ! function_exists( 'fcbkbttn_meta' ) ) {
	function fcbkbttn_meta() {
		global $fcbkbttn_options;
		if ( 1 == $fcbkbttn_options['like'] || 1 == $fcbkbttn_options['share'] ) {
			if ( is_singular() ) {
				$image = '';
				if ( has_post_thumbnail( get_the_ID() ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
					$image = $image[0];
				}
				print "\n" . '<meta property="og:title" content="' . esc_attr( get_the_title() ) . '"/>';
				print "\n" . '<meta property="og:site_name" content="' . esc_attr( get_bloginfo() ) . '"/>';
				if ( ! empty( $image ) ) {
					print "\n" . '<meta property="og:image" content="' . esc_url( $image ) . '"/>';
				}
			}
		}
	}
}

if ( ! function_exists( 'fcbkbttn_get_locale' ) ) {
	function fcbkbttn_get_locale() {
		global $fcbkbttn_options, $fcbkbttn_lang_codes;

		if ( 1 == $fcbkbttn_options['use_multilanguage_locale'] && isset( $_SESSION['language'] ) ) {
			if ( array_key_exists( $_SESSION['language'], $fcbkbttn_lang_codes ) ) {
				$fcbkbttn_locale = $_SESSION['language'];
			} else {
				$locale_from_multilanguage = explode( '_', $_SESSION['language'] );
				if ( is_array( $locale_from_multilanguage ) && array_key_exists( $locale_from_multilanguage[0], $fcbkbttn_lang_codes ) )
					$fcbkbttn_locale = $locale_from_multilanguage[0];
			}
		}
		if ( empty( $fcbkbttn_locale ) )
			$fcbkbttn_locale = $fcbkbttn_options['locale'];

		return $fcbkbttn_locale;
	}
}

if ( ! function_exists( 'fcbkbttn_footer_script' ) ) {
	function fcbkbttn_footer_script() {
		global $fcbkbttn_options, $fcbkbttn_shortcode_add_script;
		if ( isset( $fcbkbttn_shortcode_add_script ) || 
			( ( 1 == $fcbkbttn_options['like'] || 1 == $fcbkbttn_options['share'] ) && 'shortcode' != $fcbkbttn_options['where'] ) ) { 
			$fcbkbttn_locale = fcbkbttn_get_locale(); ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/<?php echo $fcbkbttn_locale; ?>/sdk.js#xfbml=1&appId=1443946719181573&version=v2.6";
				fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			</script>
		<?php }
	}
}

if ( ! function_exists( 'fcbkbttn_admin_head' ) ) {
	function fcbkbttn_admin_head() {
		if ( isset( $_GET['page'] ) && ( "facebook-button-plugin.php" == $_GET['page'] || "social-buttons.php" == $_GET['page'] ) ) {
			wp_enqueue_script( 'fcbk_script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_style( 'fcbk_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
			if ( isset( $_GET['action'] ) && 'custom_code' == $_GET['action'] )
				bws_plugins_include_codemirror();
		} elseif ( ! is_admin() ) {
			wp_enqueue_style( 'fcbk_stylesheet', plugins_url( 'css/style.css', __FILE__ ) );
		}
	}
}

/*## Functions creates other links on plugins page. */
if ( ! function_exists( 'fcbkbttn_action_links' ) ) {
	function fcbkbttn_action_links( $links, $file ) {
		if ( ! is_network_admin() ) {
			/* Static so we don't call plugin_basename on every plugin row. */
			static $this_plugin;
			if ( ! $this_plugin )
				$this_plugin = plugin_basename( __FILE__ );
			if ( $file == $this_plugin ) {
				$settings_link = '<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook-button-plugin' ) . '</a>';
				array_unshift( $links, $settings_link );
			}
		}
		return $links;
	}
}
/* End function fcbkbttn_action_links */

if ( ! function_exists ( 'fcbkbttn_links' ) ) {
	function fcbkbttn_links( $links, $file ) {
		$base = plugin_basename( __FILE__ );
		if ( $file == $base ) {
			if ( ! is_network_admin() )
				$links[]	=	'<a href="admin.php?page=facebook-button-plugin.php">' . __( 'Settings', 'facebook-button-plugin' ) . '</a>';
			$links[]	=	'<a href="http://wordpress.org/plugins/facebook-button-plugin/faq/" target="_blank">' . __( 'FAQ', 'facebook-button-plugin' ) . '</a>';
			$links[]	=	'<a href="http://support.bestwebsoft.com">' . __( 'Support', 'facebook-button-plugin' ) . '</a>';
		}
		return $links;
	}
}
/* End function fcbkbttn_links */

/* add help tab  */
if ( ! function_exists( 'fcbkbttn_add_tabs' ) ) {
	function fcbkbttn_add_tabs() {
		$screen = get_current_screen();
		$args = array(
			'id' 			=> 'fcbkbttn',
			'section' 		=> '200538939'
		);
		bws_help_tab( $screen, $args );
	}
}

if ( ! function_exists ( 'fcbkbttn_plugin_banner' ) ) {
	function fcbkbttn_plugin_banner() {
		global $hook_suffix, $fcbkbttn_plugin_info;
		if ( 'plugins.php' == $hook_suffix ) {
			global $fcbkbttn_options;
			if ( empty( $fcbkbttn_options ) )
				$fcbkbttn_options = get_option( 'fcbk_bttn_plgn_options' );

			if ( isset( $fcbkbttn_options['first_install'] ) && strtotime( '-1 week' ) > $fcbkbttn_options['first_install'] )
				bws_plugin_banner( $fcbkbttn_plugin_info, 'fcbkbttn', 'facebook-like-button', '45862a4b3cd7a03768666310fbdb19db', '78', '//ps.w.org/facebook-button-plugin/assets/icon-128x128.png' );   		  
			
			if ( ! is_network_admin() )
				bws_plugin_banner_to_settings( $fcbkbttn_plugin_info, 'fcbk_bttn_plgn_options', 'facebook-button-plugin', 'admin.php?page=facebook-button-plugin.php' );
		}
		if ( isset( $_REQUEST['page'] ) && 'facebook-button-plugin.php' == $_REQUEST['page'] ) {
			bws_plugin_suggest_feature_banner( $fcbkbttn_plugin_info, 'fcbk_bttn_plgn_options', 'facebook-button-plugin' );
		}
	}
}

/* Function for delete options */
if ( ! function_exists( 'fcbkbttn_delete_options' ) ) {
	function fcbkbttn_delete_options() {
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$all_plugins = get_plugins();

		if ( ! array_key_exists( 'bws-social-buttons/bws-social-buttons.php', $all_plugins ) ) {
			if ( ! array_key_exists( 'facebook-button-pro/facebook-button-pro.php', $all_plugins ) ) {
				/* delete custom images if no PRO version */
				$upload_dir = wp_upload_dir();
				$fcbkbttn_cstm_mg_folder = $upload_dir['basedir'] . '/facebook-image/';
				if ( is_dir( $fcbkbttn_cstm_mg_folder ) ) {
					$fcbkbttn_cstm_mg_files = scandir( $fcbkbttn_cstm_mg_folder );
					foreach ( $fcbkbttn_cstm_mg_files as $value ) {
						@unlink ( $fcbkbttn_cstm_mg_folder . $value );
					}
					@rmdir( $fcbkbttn_cstm_mg_folder );
				}
			}

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				global $wpdb;
				$old_blog = $wpdb->blogid;
				/* Get all blog ids */
				$blogids = $wpdb->get_col( "SELECT `blog_id` FROM $wpdb->blogs" );
				foreach ( $blogids as $blog_id ) {
					switch_to_blog( $blog_id );
					delete_option( 'fcbk_bttn_plgn_options' );
				}
				switch_to_blog( $old_blog );
			} else {
				delete_option( 'fcbk_bttn_plgn_options' );
			}
		}
		require_once( dirname( __FILE__ ) . '/bws_menu/bws_include.php' );
		bws_include_init( plugin_basename( __FILE__ ) );
		bws_delete_plugin( plugin_basename( __FILE__ ) );
	}
}

/* Calling a function add administrative menu. */
add_action( 'admin_menu', 'fcbkbttn_add_pages' );
/* Initialization ##*/
add_action( 'plugins_loaded', 'fcbkbttn_plugins_loaded' );
add_action( 'init', 'fcbkbttn_init' );
add_action( 'admin_init', 'fcbkbttn_admin_init' );

/* Adding stylesheets */
add_action( 'wp_enqueue_scripts', 'fcbkbttn_admin_head' );
add_action( 'admin_enqueue_scripts', 'fcbkbttn_admin_head' );
/* Adding front-end stylesheets */
add_action( 'wp_head', 'fcbkbttn_meta' );
add_action( 'wp_footer', 'fcbkbttn_footer_script' );
/* Add shortcode and plugin buttons */
add_shortcode( 'fb_button', 'fcbkbttn_shortcode' );
add_filter( 'the_content', 'fcbkbttn_display_button' );
/* custom filter for bws button in tinyMCE */
add_filter( 'bws_shortcode_button_content', 'fcbkbttn_shortcode_button_content' );
/*## Additional links on the plugin page */
add_filter( 'plugin_action_links', 'fcbkbttn_action_links', 10, 2 );
add_filter( 'plugin_row_meta', 'fcbkbttn_links', 10, 2 );
/* Adding banner */
add_action( 'admin_notices', 'fcbkbttn_plugin_banner' );
/* Plugin uninstall function */
register_uninstall_hook( __FILE__, 'fcbkbttn_delete_options' );
/* end ##*/