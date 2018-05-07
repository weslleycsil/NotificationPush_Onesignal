<?php

class NP_Menu {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    public function add_menu() {
        add_menu_page(
            'Notificações Push', // Title of the page
            'Notificações', // Text to show on the menu link
            'manage_options', // Capability requirement to see the link
            'np-home', // The 'slug' - file to display when clicking the link
            array($this, 'render_home'), //function render page
            'dashicons-admin-comments'
        );
        add_submenu_page(
            'np-home',
            'Enviar Nova Push Notification',
            'Nova Push',
            'manage_options',
            'np-new-push',
            array($this, 'render_new_push')
        );
        add_submenu_page(
            'np-home',
            'Lista de Notificações',
            'Lista de Push',
            'manage_options',
            'np-list',
            array($this, 'render_list')
        );
        add_submenu_page(
            'np-home',
            'Configurações de Push Notification',
            'Configurar',
            'manage_options',
            'np-config',
            array($this, 'render_config')
        );
    }

    public function render_config() {
        include NP_DIR.'/views/np-config.php';
    }
    public function render_new_push() {
        include NP_DIR.'/views/np-new-push.php';
    }
    public function render_list() {
        include NP_DIR.'/views/np-list.php';
    }
    public function render_home() {
        include NP_DIR.'/views/np-home.php';
    }

    public function configComplet(){
        if((get_option('np_app_key', '') == '') || (get_option('np_app_id', '') == '') || (get_option('np_user_key', '') == '')){
            return false;
        }
        return true;
    }
}