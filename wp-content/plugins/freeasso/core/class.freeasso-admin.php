<?php

/**
 * Administration part
 *
 * @author jeromeklam
 *
 */
class Freeasso_Admin
{

    private static $initiated = false;

    public static function init()
    {
        if (! self::$initiated) {
            self::init_hooks();
        }
    }

    public static function init_hooks()
    {
        add_action('admin_init', array(
            'Freeasso_Admin',
            'admin_init'
        ));
        add_action('admin_menu', array(
            'Freeasso_Admin',
            'admin_menu'
        ), 5);
        self::$initiated = true;
    }

    public static function admin_init()
    {}

    public static function admin_menu()
    {
        if (class_exists('Jetpack')) {
            add_action('jetpack_admin_menu', array(
                'Freeasso_Admin',
                'load_menu'
            ));
        } else {
            self::load_menu();
        }
    }

    public static function load_menu()
    {
        if (class_exists('Jetpack')) {
            $hook = add_submenu_page('jetpack', __('FreeAsso', 'freeasso'), __('FreeAsso', 'freeasso'), 'manage_options', Freeasso_Config::FREEASSO_CONFIG, array(
                'Freeasso_Admin',
                'display_page'
            ));
        } else {
            $hook = add_options_page(__('FreeAsso', 'freeasso'), __('FreeAsso', 'freeasso'), 'manage_options', Freeasso_Config::FREEASSO_CONFIG
                , array(
                'Freeasso_Admin',
                'display_page'
            ));
        }
        if ($hook) {
            add_action("load-$hook", array(
                'Freeasso_Admin',
                'admin_help'
            ));
        }
    }

    public static function admin_help()
    {
        $current_screen = get_current_screen();
    }

    public static function display_page()
    {
        var_dump($_GET);
        $fCfg = Freeasso_Config::getInstance();
        die;
    }
}
