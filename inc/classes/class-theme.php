<?php

/*
 * Load Theme Customizations
 *
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Theme {

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
        add_action('wp_ajax_sightline_filter_posts', [$this, 'filter_posts']);
        add_action('wp_ajax_nopriv_sightline_filter_posts', [$this, 'filter_posts']);
        add_action('wp_ajax_sightline_scrap_web_page', [$this, 'scrap_web_page']);
        add_action('wp_ajax_nopriv_sightline_scrap_web_page', [$this, 'scrap_web_page']);
        add_filter('body_class', [$this, 'add_body_class'], 10, 1);
        add_filter('acf/fields/user/query/name=todays_editor', [$this, 'acf_todays_editor_choices'], 10, 1);
        add_action('acf/save_post', [$this, 'send_newsletter_now'], 100, 1);
        add_action('acf/save_post', [$this, 'create_news_item'], 100, 1);
        add_action('after_delete_post', [$this, 'after_delete_post'], 10, 2);
    }

    public function create_news_item($post_id) {

        $values = get_fields($post_id);

        if (empty($values) || !isset($values['website_url']) || !isset($values['news_item_titles']) || !isset($values['news_item_contents'])) {
            return false;
        }

        $titles = $contents = [];
        foreach ($values['news_item_titles'] as $title) {
            if ($title['new_item_title']['select_this_title']) {
                $titles[] = $title['new_item_title']['title'];
            }
        }

        foreach ($values['news_item_contents'] as $content) {
            if ($content['new_item_content']['select_this_content']) {
                $contents[] = $content['new_item_content']['content'];
            }
        }

        global $user_ID;
        $new_post = array(
            'post_title' => implode(" ", $titles),
            'post_content' => implode(" ", $contents),
            'post_status' => 'draft',
            'post_date' => date('Y-m-d H:i:s'),
            'post_author' => $user_ID,
            'post_type' => 'news_item'
        );
        $news_id = wp_insert_post($new_post);
        update_field('newsitemlink', $values['website_url'], $news_id);
        wp_delete_post($post_id, true);
    }

    public function after_delete_post($post_id, $post) {

        if ($post->post_type == 'scraping-news-item') {
            wp_safe_redirect('post-new.php?post_type=scraping-news-item');
            exit();
        }
    }

    public function scrap_web_page() {

        $link = filter_input(INPUT_POST, 'url');

        $html = file_get_contents($link);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        $titles = $this->get_titles_from_dom($dom);
        $contents = $this->get_contents_from_dom($dom);

        if (count($titles) > 0 || count($contents) > 0) {
            $return = array('error' => false, 'titles' => $titles, 'contents' => $contents);
        } else {
            $return = array('error' => true, 'message' => __('Unable to scrap this web url. Please try again with some other URL.'));
        }
        wp_send_json($return);
    }

    public function get_contents_from_dom($dom) {

        $contents = [];
        $counter = 0;
        $tags = ['p', 'div'];
        foreach ($tags as $tag) {
            foreach ($dom->getElementsByTagName($tag) as $item) {
                $text = trim($item->textContent);
                if (count(explode(" ", $text)) > 5) {
                    $contents[$counter] = $text;
                    $counter++;
                }
            }
            if (count($contents) > 5) {
                break;
            }
        }

        return array_values(array_unique($contents));
    }

    public function get_titles_from_dom($dom) {

        $titles = [];
        $counter = 0;
        for ($i = 1; $i <= 5; $i++) {
            foreach ($dom->getElementsByTagName('h' . $i) as $item) {
                $title = trim($item->textContent);
                if (count(explode(" ", $title)) > 5) {
                    $titles[$counter] = $title;
                    $counter++;
                }
            }
            if (count($titles) > 5) {
                break;
            }
        }

        return array_values(array_unique($titles));
    }

    public function send_newsletter_now($post_id) {

        $values = get_fields($post_id);

        if (empty($values) || !isset($values['subject_line']) || !isset($values['preview_line']) || !isset($values['todays_editor'])) {
            return false;
        }

        $news_query = $this->get_news_query();
        if (!$news_query) {
            return false;
        }

        $views = Views::get_instance();

        $data = $values;

        $banner = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
        if ($banner) {
            $data['banner'] = $banner[0];
        }

        $data['news_date'] = get_the_date('n-j-y', $news_query->posts[0]->ID);
        $data['title'] = 'Sightline Daily';
        $data['news_query'] = $news_query;
        $data['campaign_title'] = 'Daily Newsletter ' . $data['news_date'];
        $data['subject_line'] = $this->get_subject_line($data);
        $data['html'] = $views->load_view('admin/newsletter', ['data' => $data]);

        $mailchimp = Mailchimp::get_instance();
        if (isset($data['send_tests_to']) && !empty($data['send_tests_to'])) {
            $mailchimp->send_test_email($data);
        }

        if (isset($data['send_newsletter_now']) && $data['send_newsletter_now']) {
            $response = $mailchimp->send_campaign($data);
            if ($response !== FALSE) {//If success, then mailchimp will return empty response
                $this->update_news_items($news_query);
            } else {
                print_r($response);
            }
        }
    }

    public function get_news_query() {

        $news_query = new \WP_Query(array(
            'post_type' => 'news_item',
            'post_status' => array('draft', 'future'),
            'orderby' => array('date' => 'DESC', 'menu_order' => 'ASC'),
            'posts_per_page' => 10
        ));
        if (!$news_query->have_posts()) {
            return false;
        }

        return $news_query;
    }

    public function update_news_items($news_query) {

        if (empty($news_query)) {
            return false;
        }

        $news_query->rewind_posts();
        global $post;
        while ($news_query->have_posts()) : $news_query->the_post();
            $post->post_status = 'publish';
            wp_update_post($post);
        endwhile;
    }

    public function get_subject_line($data) {

        $month_formats = array(
            1 => 'Jan.',
            2 => 'Feb.',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'Aug.',
            9 => 'Sept.',
            10 => 'Oct.',
            11 => 'Nov.',
            12 => 'Dec.'
        );
        $date = \DateTime::createFromFormat('n-j-y', $data['news_date']);
        $formatted_date = $month_formats[intval($date->format('n'))] . ' ' . $date->format('j');

        $subject_line = sprintf($data['title'] . ', %s: %s', $formatted_date, $data['subject_line']);

        return $subject_line;
    }

    public function acf_todays_editor_choices($args) {

        $args['meta_key'] = 'todays_editor';
        //$args['exclude'] = [156, 108];

        return $args;
    }

    public function add_body_class($classes) {

        global $post;

        $options = Options::get_instance()->get_plugin_options();
        $news_page = isset($options['news_page']) ? $options['news_page'] : "";
        $press_page = isset($options['press_page']) ? $options['press_page'] : "";

        if (is_search() || (isset($post) && $post->ID == $news_page) || (isset($post) && $post->ID == $press_page)) {
            $classes[] = 'sightline_filter_posts_required';
        }

        return $classes;
    }

    public function get_requested_data() {

        $page = isset($_REQUEST['pg']) ? $_REQUEST['pg'] : 1;
        $cat = isset($_REQUEST['ofcategory']) ? $_REQUEST['ofcategory'] : 0;
        $tag = isset($_REQUEST['ofpost_tag']) ? $_REQUEST['ofpost_tag'] : 0;
        $region = isset($_REQUEST['ofregion']) ? $_REQUEST['ofregion'] : 0;
        $queryString = isset($_REQUEST['sightline_query']) ? $_REQUEST['sightline_query'] : '';
        $filterFor = isset($_REQUEST['sightline_filter_for']) ? $_REQUEST['sightline_filter_for'] : 'search';

        return ['cat' => $cat, 'tag' => $tag, 'region' => $region, 'queryString' => $queryString, 'filterFor' => $filterFor, 'page' => $page];
    }

    public function get_query_args($data = []) {

        if (empty($data)) {
            $data = $this->get_requested_data();
        }

        $query_args = [];
        parse_str($data['queryString'], $query_args);

        if (current_user_can('manage_options')) {
            $query_args['post_status'] = ['publish', 'private'];
        } else {
            $query_args['post_status'] = ['publish'];
        }

        if ($data['filterFor'] == 'search') {
            $query_args['post_type'] = 'any';
        } else {
            $query_args['post_type'] = $data['filterFor'];
        }

        $query_args['paged'] = $data['page'];

        $cat_args = $tag_args = $region_args = null;

        if (!empty($data['cat'])) {
            $cat_args = [
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $data['cat']
            ];
        }

        if (!empty($data['tag'])) {
            $tag_args = [
                'taxonomy' => 'post_tag',
                'field' => 'id',
                'terms' => $data['tag']
            ];
        }

        if (!empty($data['region'])) {
            $region_args = [
                'taxonomy' => 'region',
                'field' => 'id',
                'terms' => $data['region']
            ];
        }

        if (!empty($data['cat']) || !empty($data['tag']) || !empty($data['region'])) {
            $query_args['tax_query'] = [
                'relation' => 'AND',
                $cat_args,
                $tag_args,
                $region_args
            ];
        }

        return $query_args;
    }

    /*
     * Function to show the filtered posts
     */

    public function filter_posts() {

        $data = $this->get_requested_data();
        $query_args = $this->get_query_args($data);

        $error = false;
        $message = '';

        $post_query = new \WP_Query($query_args);

        $views = Views::get_instance();
        $concat = '&';
        if (empty($data['queryString'])) {
            $concat = '?';
        }
        $params = $data['queryString'] . $concat . 'ofcategory=' . $data['cat'] . '&ofpost_tag=' . $data['tag'] . '&ofregion=' . $data['region'] . '&sightline_filter_for=' . $data['filterFor'];

        $pagination = Pagination::get_instance();
        $pagination->setTotalPage($post_query->max_num_pages);
        $pagination->setPageGetVar('pg');
        $pagination->setPaginationFor($data['filterFor']);
        $pagination->setParams($params);
        $pagination->setCurrPage($data['page']);
        $pagination_html = $pagination->getContent();

        $html = $views->load_view('front/filter_posts', ['post_query' => $post_query, 'pagination_html' => $pagination_html, 'filter_for' => $data['filterFor']]);

        $return = array('error' => $error, 'message' => $message, 'html' => $html);
        wp_send_json($return);
    }
}
