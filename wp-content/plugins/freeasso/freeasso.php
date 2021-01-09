<?php
/**
 Plugin Name: FreeAsso
 Description: Plugin de gestion des liens avec l'administration FreeAsso.
 Author: KLAM Jérôme
 */

// Make sure we don't expose any info if called directly
if (! function_exists('add_action')) {
    echo 'I\'m just a plugin !!';
    exit();
}

// Basic constants
define('FREEASSO_VERSION', '1.0.0');
define('FREEASSO_MINIMUM_WP_VERSION', '5.6');
define('FREEASSO_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Ugly way, no PSR, :(
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-tools.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-api-base.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso-config.php';
require_once FREEASSO_PLUGIN_DIR . 'core/class.freeasso.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-sites.php';
require_once FREEASSO_PLUGIN_DIR . 'api/class.freeasso-api-stats.php';

// Go all
add_action('init', [
    'Freeasso',
    'init'
]);

// Go admin
if (is_admin() || (defined('WP_CLI') && WP_CLI)) {
    require_once (FREEASSO_PLUGIN_DIR . 'core/class.freeasso-admin.php');
    add_action('init', [
        'Freeasso_Admin',
        'init'
    ]);
}

// Filters
add_filter('the_content', [
    'Freeasso',
    'filterStats'
]);

$freeassoSites = Freeasso_Api_Sites::getFactory();
$freeassoSites->getSites();