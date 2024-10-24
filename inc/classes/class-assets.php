<?php

/*
 * Enqueue plugin assets
 *
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Assets {

    use Singleton;

    //Construct function
    protected function __construct() {

        //load class
        $this->setup_hooks();
    }

    /*
     * Function to load action and filter hooks
     */

    protected function setup_hooks() {

        //actions and filters
        //Register styles
        add_action('wp_enqueue_scripts', [$this, 'register_styles']);

        //Register styles for the admin
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'register_styles']);
        }

        //Register scripts
        add_action('wp_enqueue_scripts', [$this, 'register_scripts'], 99);

        //Register scripts for the admin
        if (is_admin()) {
            add_action('admin_enqueue_scripts', [$this, 'register_scripts'], 99);
        }
    }

    /*
     * Function to register styles
     */

    public function register_styles() {

        //Register style
        wp_register_style(SIGHTLINE_TEXT_DOMAIN . '_style', SIGHTLINE_ASSETS_DIR_URL . 'css/style.css', [], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'css/style.css'));
        wp_register_style(SIGHTLINE_TEXT_DOMAIN . '_bootstrap', SIGHTLINE_ASSETS_DIR_URL . 'css/bootstrap.min.css', [], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'css/bootstrap.min.css'));
        wp_register_style(SIGHTLINE_TEXT_DOMAIN . '_select2', SIGHTLINE_ASSETS_DIR_URL . 'css/select2.min.css', [], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'css/select2.min.css'));

        //enqueue style
        wp_enqueue_style(SIGHTLINE_TEXT_DOMAIN . '_style');
    }

    /*
     * Function to register scripts
     */

    public function register_scripts() {

        //Register script
        wp_register_script(SIGHTLINE_TEXT_DOMAIN . '_js', SIGHTLINE_ASSETS_DIR_URL . 'javascript/main.js', ['jquery'], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'javascript/main.js'), true);
        wp_register_script(SIGHTLINE_TEXT_DOMAIN . '_bootstrap', SIGHTLINE_ASSETS_DIR_URL . 'javascript/bootstrap.bundle.min.js', ['jquery'], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'javascript/bootstrap.bundle.min.js'), true);
        wp_register_script(SIGHTLINE_TEXT_DOMAIN . '_select2', SIGHTLINE_ASSETS_DIR_URL . 'javascript/select2.min.js', ['jquery'], filemtime(SIGHTLINE_ASSETS_DIR_PATH . 'javascript/select2.min.js'), true);

        wp_enqueue_script('jquery');

        //enqueue script
        wp_enqueue_script(SIGHTLINE_TEXT_DOMAIN . '_js');

        global $post;

        $options = Options::get_instance()->get_plugin_options();
        $news_page = isset($options['news_page']) ? $options['news_page'] : "";
        $press_page = isset($options['press_page']) ? $options['press_page'] : "";
        $filter_for = '';
        if (is_search()) {
            $filter_for = 'search';
        } elseif (isset($post) && $post->ID == $news_page) {
            $filter_for = 'sightline_press';
        } elseif (isset($post) && $post->ID == $press_page) {
            $filter_for = 'release';
        }
        //localize a registered script with data for a JavaScript variable
        wp_localize_script(SIGHTLINE_TEXT_DOMAIN . '_js', SIGHTLINE_TEXT_DOMAIN . '_data', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'baseurl' => SIGHTLINE_SITE_BASE_URL,
            'search' => isset($_GET['s']) ? 's=' . $_GET['s'] : '',
            'ofcategory' => isset($_GET['ofcategory']) ? $_GET['ofcategory'] : '',
            'ofpost_tag' => isset($_GET['ofpost_tag']) ? $_GET['ofpost_tag'] : '',
            'ofregion' => isset($_GET['ofregion']) ? $_GET['ofregion'] : '',
            'sightline_filter_for' => $filter_for,
            'pg' => isset($_GET['pg']) ? $_GET['pg'] : 1,
            'filter_fields_html' => do_shortcode('[searchandfilter fields="category,post_tag,region"]')
        ));
    }
}
