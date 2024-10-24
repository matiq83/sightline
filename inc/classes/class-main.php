<?php

/*
 * Bootstraps the plugin, this class will load all other classes
 *
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Main {

    use Singleton;

    //Construct function
    protected function __construct() {

        //load class
        $this->setup_hooks();

        //Load assets
        Assets::get_instance();

        //Load cron
        //Cron::get_instance();
        //Load views
        Views::get_instance();

        //Load views
        Theme::get_instance();

        //Load admin classes
        $this->load_admin_classes();
    }

    /*
     * Function to load action and filter hooks
     */

    protected function setup_hooks() {

        //actions and filters
        add_action('init', [$this, 'load_textdomain']);
    }

    /*
     * Function to load classes only for admin side
     */

    protected function load_admin_classes() {

        if (is_admin()) {
            //Load options
            Options::get_instance();
        }
    }

    /**
     * Load plugin textdomain, i.e language directory
     */
    public function load_textdomain() {

        load_plugin_textdomain(SIGHTLINE_TEXT_DOMAIN, false, SIGHTLINE_LANG_DIR);
    }

    /*
     * Function that executes once the plugin is activated
     */

    public function sightline_install() {

        //Run code once when plugin activated
        /*
          if (! wp_next_scheduled ( SIGHTLINE_TEXT_DOMAIN.'_cron_event' )) {

          wp_schedule_event( time(), SIGHTLINE_TEXT_DOMAIN.'_cron_interval', SIGHTLINE_TEXT_DOMAIN.'_cron_event' );
          }

          $db = Db::get_instance();

          $db->create_photos_table();
         */
    }

    /*
     * Function that executes once the plugin is deactivated
     */

    public function sightline_uninstall() {

        //Run code once when plugin deactivated
        //wp_clear_scheduled_hook( SIGHTLINE_TEXT_DOMAIN.'_cron_event' );
    }
}
