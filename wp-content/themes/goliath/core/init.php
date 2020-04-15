<?php

/*-----------------------------------------------------------------------------------*/
/* Define Constants */
/*-----------------------------------------------------------------------------------*/

	define('PLSH_PATH', get_template_directory() . '/');
	define('PLSH_URL', get_template_directory_uri() . '/');
	if ( ! defined( 'PLSH_CORE_PATH' ) ) {
		define('PLSH_CORE_PATH', get_template_directory() . '/core/');
	}
	if ( ! defined( 'PLSH_THEME_PATH' ) ) {
		define('PLSH_THEME_PATH', get_template_directory() . '/theme/');
	}
	if ( ! defined( 'PLSH_THEME_URL' ) ) {
		define('PLSH_THEME_URL', get_template_directory_uri() . '/theme/');
	}
	if ( ! defined( 'PLSH_ADMIN_PANEL_PATH' ) ) {
		define('PLSH_ADMIN_PANEL_PATH', get_template_directory() . '/core/panel/');
	}
	if ( ! defined( 'PLSH_ADMIN_PANEL_TEMPLATE_PATH' ) ) {
		define('PLSH_ADMIN_PANEL_TEMPLATE_PATH', get_template_directory() . '/core/panel/templates/');
	}
	if ( ! defined( 'PLSH_ADMIN_ASSET_URL' ) ) {
		define('PLSH_ADMIN_ASSET_URL', get_template_directory_uri() . '/core/panel/assets/');
	}
	if ( ! defined( 'PLSH_LIB_PATH' ) ) {
		define('PLSH_LIB_PATH', get_template_directory() . '/core/lib/');
	}
	if ( ! defined( 'PLSH_IMG_URL' ) ) {
		define('PLSH_IMG_URL', PLSH_THEME_URL . 'assets/images/');
	}
	if ( ! defined( 'PLSH_JS_URL' ) ) {
		define('PLSH_JS_URL', PLSH_THEME_URL . 'assets/js/');
	}
	if ( ! defined( 'PLSH_CSS_URL' ) ) {
		define('PLSH_CSS_URL', PLSH_THEME_URL . 'assets/css/');
	}

	$upload_dir = wp_upload_dir();

	if ( ! defined( 'PLSH_UPLOAD_URL' ) ) {
		define('PLSH_UPLOAD_URL',  $upload_dir['baseurl'] . '/goliath/');
	}
	if ( ! defined( 'PLSH_UPLOAD_PATH' ) ) {
		define('PLSH_UPLOAD_PATH',  $upload_dir['basedir'] . '/goliath/');
	}
	if ( ! defined( 'PLSH_TEMPLATE_PATH' ) ) {
		define('PLSH_TEMPLATE_PATH', PLSH_THEME_PATH . 'templates/');
	}
	if ( ! defined( 'PLSH_WIDGET_PATH' ) ) {
		define('PLSH_WIDGET_PATH', PLSH_THEME_PATH . 'widgets/');
	}
	if ( ! defined( 'PLSH_PLUGIN_PATH' ) ) {
		define('PLSH_PLUGIN_PATH', PLSH_THEME_PATH . 'plugins/');
	}
	if ( ! defined( 'PLSH_WOOCOMMERCE_PATH' ) ) {
		define('PLSH_WOOCOMMERCE_PATH', get_template_directory() . '/woocommerce/');
	}
	if ( ! defined( 'PLSH_IS_CHILD' ) ) {
		define('PLSH_IS_CHILD', is_child_theme());
	}

	if ( PLSH_IS_CHILD ) {
		if ( ! defined( 'PLSH_CHILD_PATH' ) ) {
			define('PLSH_CHILD_PATH', get_stylesheet_directory());
		}
		if ( ! defined( 'PLSH_CHILD_THEME_PATH' ) ) {
			define('PLSH_CHILD_THEME_PATH', get_stylesheet_directory() . '/theme/');
		}
		if ( ! defined( 'PLSH_CHILD_TEMPLATE_PATH' ) ) {
			define('PLSH_CHILD_TEMPLATE_PATH', PLSH_CHILD_THEME_PATH . 'templates/');
		}
	}

/*-----------------------------------------------------------------------------------*/
/* Load the required Framework Files */
/*-----------------------------------------------------------------------------------*/

	include_once( PLSH_CORE_PATH . 'shared-functions.php' );
	include_once( PLSH_ADMIN_PANEL_PATH . 'admin-functions.php' );
	include_once( PLSH_ADMIN_PANEL_PATH . 'admin-templates.php' );
    include_once( PLSH_CORE_PATH . 'template-functions.php' );
	include_once( PLSH_LIB_PATH . 'settings.class.php' );
    include_once( PLSH_LIB_PATH . 'uploadHandler.class.php' );
    include_once( PLSH_LIB_PATH . 'tgmPluginActivation.class.php' );
    include_once( PLSH_LIB_PATH . 'wpBootstrapNavwalker.class.php' );
	include_once( PLSH_THEME_PATH . 'settings.php' );
	include_once( PLSH_PLUGIN_PATH . 'versions.php' );
    include_once( PLSH_THEME_PATH . 'migrate.php');	//theme version change migrate
    
/*-----------------------------------------------------------------------------------*/
/* Load settings */
/*-----------------------------------------------------------------------------------*/

	$_SETTINGS = new Plsh_Settings();

/*-----------------------------------------------------------------------------------*/
/* Constants and Globals */
/*-----------------------------------------------------------------------------------*/

if ( ! defined( 'PLSH_THEME_DOMAIN' ) ) {
	define('PLSH_THEME_DOMAIN', plsh_gs('theme_slug'));
}


/*-----------------------------------------------------------------------------------*/
/* Add actions */
/*-----------------------------------------------------------------------------------*/
    
if( is_admin())
{
	add_action('admin_menu', 'plsh_load_admin_menus');
    add_action('admin_enqueue_scripts', 'plsh_load_admin_styles');
    add_action('admin_enqueue_scripts', 'plsh_load_admin_scripts');
	add_action('wp_ajax_plsh_save_sidebar', 'plsh_save_sidebar');
	add_action('wp_ajax_plsh_save_settings', 'plsh_save_settings');
    add_action('wp_ajax_plsh_load_style_preset', 'plsh_load_style_preset');
    add_action('wp_ajax_plsh_save_ads', 'plsh_save_ads');
    add_action('wp_ajax_plsh_save_ad_locations', 'plsh_save_ad_locations');
    add_action('wp_ajax_plsh_import_settings', 'plsh_import_settings');
    add_action('wp_ajax_plsh_reset_settings', 'plsh_reset_settings');
    add_action('wp_ajax_plsh_upload_image', 'plsh_upload_image');
    add_action('wp_loaded', 'plsh_version_migrate');
	add_action('wp_ajax_plsh_extra_google_fonts', 'plsh_extra_google_fonts');
	add_action('wp_ajax_plsh_remove_newsletter_notification', 'plsh_remove_newsletter_notification');
    add_action('admin_notices', 'plsh_handle_admin_actions', 5);
    add_action('admin_notices', 'plsh_page_install_notification');
    add_action('admin_notices', 'plsh_thumbnail_regenerate_notification');
    add_action('after_switch_theme', 'plsh_log_theme_version');
}

?>
