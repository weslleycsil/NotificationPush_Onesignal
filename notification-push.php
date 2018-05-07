<?php

defined( 'ABSPATH' ) or die('This page may not be accessed directly.');

/*
Plugin Name: Push Notification
Plugin URI: https://twcreativs.com.br
Description: Plugin para enviar push notifications!
Version: 1.0.0
Author: Weslley Silva
Author URI: https://twcreativs.com.br
*/
require_once 'class/np-request.php';
require_once 'class/np-general.php';
require_once 'class/np-push.php';
require_once 'class/np-onesignal.php';
require_once 'class/np-menu.php';

define('NP_DIR', dirname(__FILE__));
define('NP_BASE_NAME', plugin_basename(__FILE__));
define('VERSION', '1.0.0');

function np_remove(){
    //codigo para a remoção do plugin
   /* global $wpdb, $np_table_name;

    $table_name = $wpdb->prefix . $np_table_name;

    $drop_sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($drop_sql);*/
    $settings_params = array(
        'np_app_key',
        'np_app_id',
        'np_user_key'
    );
    
    foreach ($settings_params as $setting) {
        unregister_setting('np-settings-group', $setting);
    }

    foreach ($settings_params as $setting) {
        delete_option($setting);
    }
}

register_uninstall_hook(__FILE__, 'np_remove');

$np = new NP_General();