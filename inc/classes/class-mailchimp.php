<?php

/*
 * Load Mailchimp functions
 *
 * @package SIGHTLINE
 */

namespace SIGHTLINE\Inc;

use SIGHTLINE\Inc\Traits\Singleton;

class Mailchimp {

    use Singleton;

    protected $api_key;
    protected $server_prefix;
    protected $campaign_id;
    protected $from_name;
    protected $reply_to;
    protected $folder_id;
    protected $list_id;

    //Construct function
    protected function __construct() {

        //load class
        $options = Options::get_instance()->get_plugin_options();
        $this->api_key = (isset($options['mailchimp_key']) && !empty($options['mailchimp_key'])) ? $options['mailchimp_key'] : '';
        $this->server_prefix = (isset($options['mailchimp_server_prefix']) && !empty($options['mailchimp_server_prefix'])) ? $options['mailchimp_server_prefix'] : 'us2';
        $this->from_name = (isset($options['mailchimp_from_name']) && !empty($options['mailchimp_from_name'])) ? $options['mailchimp_from_name'] : 'Sightline Institute';
        $this->reply_to = (isset($options['mailchimp_reply_to']) && !empty($options['mailchimp_reply_to'])) ? $options['mailchimp_reply_to'] : 'editor@sightline.org';
        $this->folder_id = (isset($options['mailchimp_folder_id']) && !empty($options['mailchimp_folder_id'])) ? $options['mailchimp_folder_id'] : 'ffa32bdf6a';
        $this->list_id = (isset($options['mailchimp_list_id']) && !empty($options['mailchimp_list_id'])) ? $options['mailchimp_list_id'] : '3e1b0f73ac'; //-> For testing f471a75b5f || 3e1b0f73ac = Sightline Newsletters II || 18df351f8f = Sightline Newsletters
    }

    /*
     * Function to get campaigns
     */

    public function get_campaigns($status = 'save', $count = 10, $type = 'regular') {

        $response = false;

        $client = $this->get_mailchimp();

        if ($client) {
            $response = $client->campaigns->list(
                    null,
                    null,
                    $count, //Maximum value is 1000
                    0,
                    $type, //"regular", "plaintext", "absplit", "rss", or "variate"
                    $status, //status "save", "paused", "schedule", "sending", or "sent"
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    'create_time', //"create_time" or "send_time"
                    'DESC'//"ASC" or "DESC"
            );
        }

        return $response;
    }

    public function update_campaign($data) {

        if (!isset($data['subject_line']) || isset($data['campaign_title']) || empty($this->campaign_id)) {
            return false;
        }

        $response = false;

        $client = $this->get_mailchimp();

        if ($client) {
            $args = [
                'settings' => [
                    'subject_line' => $data['subject_line'],
                    'from_name' => $this->from_name,
                    'reply_to' => $this->reply_to,
                    'title' => $data['campaign_title']
                ]
            ];

            $response = $client->campaigns->update($this->campaign_id, $args);
        }

        return $response;
    }

    public function set_campaign_content($data) {

        if (!isset($data['html']) || empty($this->campaign_id)) {
            return false;
        }

        $response = false;

        $client = $this->get_mailchimp();

        if ($client) {
            $args = [
                "html" => $data['html']
            ];

            $response = $client->campaigns->setContent($this->campaign_id, $args);
        }

        return $response;
    }

    public function send_test_email($data) {

        if (!isset($data['send_tests_to']) || empty($data['send_tests_to'])) {
            return false;
        }

        $response = false;

        $client = $this->get_mailchimp();

        if ($client && $this->create_campaign($data) && $this->set_campaign_content($data)) {
            $response = $client->campaigns->sendTestEmail($this->campaign_id, [
                "test_emails" => [$data['send_tests_to']], //webster@sightline.org
                "send_type" => "html",
            ]);
        }

        return $response;
    }

    public function send_campaign($data) {

        if (empty($data) || empty($this->campaign_id)) {
            return false;
        }

        $response = false;

        $client = $this->get_mailchimp();
        if ($client && $this->create_campaign($data) && $this->set_campaign_content($data)) {
            $response = $client->campaigns->send($this->campaign_id);
        }

        return $response;
    }

    public function create_campaign($data) {

        if (empty($data) || !isset($data['subject_line']) || !isset($data['campaign_title'])) {
            return false;
        }

        $campaign = null;

        if ($campaign = $this->get_campaign_by_title($data)) {
            $this->campaign_id = $campaign->id;
            return $campaign;
        }

        $client = $this->get_mailchimp();

        if ($client) {
            $args = [
                "type" => "regular",
                "recipients" => [
                    'list_id' => $this->list_id
                ],
                'settings' => [
                    'subject_line' => $data['subject_line'],
                    'from_name' => $this->from_name,
                    'reply_to' => $this->reply_to,
                    'title' => $data['campaign_title'],
                    'folder_id' => $this->folder_id
                ]
            ];

            $campaign = $client->campaigns->create($args);
            if ($campaign) {
                $this->campaign_id = $campaign->id;
            }
        }

        return $campaign;
    }

    public function get_campaign_by_title($data) {

        if (empty($data) || !isset($data['campaign_title'])) {
            return false;
        }

        $campaign_by_title = null;

        $campaigns = $this->get_campaigns();
        if ($campaigns) {
            foreach ($campaigns->campaigns as $campaign) {
                if ($campaign->settings->title == $data['campaign_title']) {
                    $campaign_by_title = $campaign;
                    break;
                }
            }
        }

        return $campaign_by_title;
    }

    public function get_campaign_folders() {

        $client = $this->get_mailchimp();

        $folders = false;

        if ($client) {
            $folders = $client->campaignFolders->list();
        }

        return $folders;
    }

    public function get_lists() {

        $client = $this->get_mailchimp();

        $lists = false;

        if ($client) {
            $lists = $client->lists->getAllLists();
        }

        return $lists;
    }

    /*
     * Function to get mailchimp API object
     */

    public function get_mailchimp() {

        if (empty($this->api_key) || empty($this->server_prefix)) {
            return false;
        }

        require_once( SIGHTLINE_INC_DIR . 'mailchimp/vendor/autoload.php' );

        $mailchimp = new \MailchimpMarketing\ApiClient();

        $mailchimp->setConfig([
            'apiKey' => $this->api_key,
            'server' => $this->server_prefix
        ]);

        return $mailchimp;
    }
}
