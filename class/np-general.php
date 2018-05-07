<?php

class NP_General {

    public function __construct() {
        new NP_Menu();
        add_action('admin_init', array($this, 'init'));
    }

    public static function is_session_started() {
        if ( php_sapi_name() === 'cli' ) return false;
        if ( version_compare(phpversion(), '5.4.0', '>=') ) return session_status() === PHP_SESSION_ACTIVE;
        return !(session_id() === '');
    }

    public function init() {
        if (!$this->is_session_started()) session_start();
        
        $settings_params = array(
            'np_app_key',
            'np_app_id',
            'np_user_key'
        );

        foreach ($settings_params as $setting) {
            register_setting('np-settings-group', $setting);
        }
    }

    public static function appkey() {
        return get_option('np_app_key', '');
    }

    public static function appID() {
        return get_option('np_app_id', '');
    }

    public static function userkey() {
        return get_option('np_user_key', '');
    }

    
}