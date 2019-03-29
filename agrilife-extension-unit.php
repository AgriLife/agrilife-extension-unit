<?php
/**
 * Plugin Name: AgriLife Extension Unit
 * Plugin URI: https://github.com/AgriLife/AgriLife-Extension-Unit
 * Description: Functionality for AgriLife Extension sites using AgriFlex 3
 * Version: 1.1.8
 * Author: Zach Watkins
 * Author URI: http://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * License: GPL2+
 */

require 'vendor/autoload.php';

define( 'AG_EXTUNIT_DIRNAME', 'agrilife-extension-unit' );
define( 'AG_EXTUNIT_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'AG_EXTUNIT_DIR_FILE', __FILE__ );
define( 'AG_EXTUNIT_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'AG_EXTUNIT_TEMPLATE_PATH', AG_EXTUNIT_DIR_PATH . 'view' );

// Register plugin activation functions
//$activate = new \AgriLife\Core\Activate;
//register_activation_hook( __FILE__, array( $activate, 'run') );

// Register plugin deactivation functions
//$deactivate = new \AgriLife\Core\Deactivate;
//register_deactivation_hook( __FILE__, array( $deactivate, 'run' ) );

$extension_required_dom = new \AgriLife\Extension\RequiredDOM();

$extension_asset = new \AgriLife\Extension\Asset();

$extension_custom_fields = new \AgriLife\Extension\CustomFields();

$extension_templates = new \AgriLife\Extension\Templates();

$extension_widget_areas = new \AgriLife\Extension\WidgetAreas();

add_action( 'agrilife_core_init', function() {
    $ext_landing_1_template = new \AgriLife\Core\PageTemplate();
    $ext_landing_1_template->with_path( AG_EXTUNIT_TEMPLATE_PATH )->with_file( 'landing1' )->with_name( 'Landing Page 1' );
    $ext_landing_1_template->register();
});

//$ext_widget_areas = new \AgriLife\Extension\WidgetAreas();
/*
if ( class_exists( 'Acf' ) ) {
    // Add new ACF json load point
    add_filter('acf/settings/load_json', 'extension_acf_json_load_point');
} else {
    add_action( 'admin_notices', 'agrilife_acf_notice' );
}

function extension_acf_json_load_point( $paths ) {
    $paths[] =  AG_COL_DIR_PATH . 'fields' ;
    return $paths;
}
*/
