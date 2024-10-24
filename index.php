<?php

/*
  Plugin Name: SIGHTLINE
  Description: SIGHTLINE
  Version: 1.0.0
  Author: Muhammad Atiq
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL); 
//Global define variables
define('SIGHTLINE_PLUGIN_NAME', 'SIGHTLINE');
define('SIGHTLINE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SIGHTLINE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SIGHTLINE_SLUG', plugin_basename(__DIR__));
define('SIGHTLINE_SITE_BASE_URL', rtrim(get_bloginfo('url'), "/") . "/");
define('SIGHTLINE_LANG_DIR', SIGHTLINE_PLUGIN_PATH . 'language/');
define('SIGHTLINE_INC_DIR', SIGHTLINE_PLUGIN_PATH . 'inc/');
define('SIGHTLINE_VIEWS_DIR', SIGHTLINE_PLUGIN_PATH . 'views/');
define('SIGHTLINE_ASSETS_DIR_URL', SIGHTLINE_PLUGIN_URL . 'assets/');
define('SIGHTLINE_ASSETS_DIR_PATH', SIGHTLINE_PLUGIN_PATH . 'assets/');
define('SIGHTLINE_SETTINGS_KEY', '_sightline_options');
define('SIGHTLINE_TEXT_DOMAIN', 'sightline');
define('SIGHTLINE_UPDATE_URL', 'http://portfolio.itfledge.com/wp0822/wp-content/plugins/');

//Plugin update checker
require SIGHTLINE_PLUGIN_PATH . 'update/plugin-update-checker.php';

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$updateChecker = PucFactory::buildUpdateChecker(
                SIGHTLINE_UPDATE_URL . SIGHTLINE_SLUG . '.json',
                __FILE__,
                SIGHTLINE_SLUG
);

//Load the classes
require_once SIGHTLINE_PLUGIN_PATH . '/inc/helpers/autoloader.php';

//Get main class instance
$main = SIGHTLINE\Inc\Main::get_instance();

//Plugin activation hook
register_activation_hook(__FILE__, [$main, 'sightline_install']);

//Plugin deactivation hook
register_deactivation_hook(__FILE__, [$main, 'sightline_uninstall']);
