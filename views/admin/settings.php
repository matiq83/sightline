<div class="wrap">
    <h2><?php esc_html_e('Newsletter Settings', SIGHTLINE_TEXT_DOMAIN); ?></h2>
    <hr>
    <div class="ajax-message-container"></div>
    <form method="post" class="frm_sightline frm_sightline_bootstrap ajax_save" action="sightline_save_options" enctype="multipart/form-data">
        <input type="hidden" name="frm_section" id="frm_section" value="" />
        <div class="row gutters-sm">
            <!-- Navigation -->
            <div class="col-md-2 d-none d-md-block">
                <div class="cardNav">
                    <div class="card-body">
                        <nav class="nav flex-column nav-pills nav-gap-y-1">
                            <?php
                            $link1 = '<a href="#misc_settings" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded active">';
                            $link1 .= '<svg version="1.1" width="24" height="24" class="feather feather-post-types mr-2" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><path d="M505.014,125.61L386.393,6.989c-5.759-5.769-12.797-8.123-19.306-6.465c-6.515,1.66-11.568,7.103-13.866,14.937l-5.379,18.37c-2.743,9.363-10.913,23.127-17.841,30.056l-96.355,96.37c-6.947,6.954-20.743,15.402-30.126,18.45l-55.658,18.074c-7.719,2.502-13.05,7.712-14.628,14.293c-1.577,6.58,0.815,13.64,6.554,19.361l52.987,52.998l-79.952,79.931c-0.188,0.188-0.366,0.385-0.534,0.591L1.81,498.929c-2.604,3.181-2.373,7.817,0.534,10.724c1.554,1.554,3.603,2.343,5.659,2.343c1.79,0,3.585-0.598,5.065-1.809L148.057,399.7c0.206-0.168,0.402-0.346,0.59-0.534l79.927-79.927l52.982,52.993c4.563,4.572,9.977,7.014,15.322,7.014c1.35,0,2.696-0.156,4.022-0.473c6.59-1.573,11.815-6.9,14.341-14.633l18.042-55.663c3.042-9.359,11.491-23.157,18.445-30.124l96.374-96.366c6.909-6.902,20.678-15.059,30.068-17.813l18.371-5.388c7.835-2.299,13.282-7.357,14.942-13.879C513.139,138.394,510.779,131.357,505.014,125.61z M137.615,387.57l-72.658,59.469l59.459-72.643l79.67-79.649l13.175,13.178L137.615,387.57z M495.976,140.962c-0.146,0.572-1.315,1.703-3.94,2.473l-18.37,5.388c-5.725,1.679-12.438,4.775-18.843,8.504l-8.308-8.307c-3.124-3.124-8.189-3.124-11.313,0.001c-3.124,3.124-3.124,8.189,0.001,11.313l6.205,6.204c-1.685,1.381-3.25,2.767-4.618,4.133l-96.382,96.374c-0.907,0.909-1.827,1.912-2.749,2.966l-6.068-6.067c-3.124-3.124-8.189-3.124-11.313,0.001c-3.124,3.124-3.124,8.189,0.001,11.313l7.809,7.808c-4.317,6.886-8.011,14.275-10.025,20.471l-18.038,55.651c-0.818,2.504-2.017,3.824-2.841,4.021c-0.813,0.196-2.46-0.435-4.309-2.286l-58.463-58.475c-0.059-0.063-0.111-0.129-0.172-0.19c-0.061-0.061-0.127-0.113-0.189-0.171l-82.958-82.976c-1.858-1.853-2.494-3.5-2.3-4.311c0.195-0.812,1.508-1.994,4.006-2.804l55.662-18.075c6.201-2.014,13.585-5.703,20.463-10.013l68.884,68.878c1.563,1.562,3.609,2.343,5.657,2.343s4.095-0.781,5.657-2.343c3.124-3.125,3.124-8.19,0-11.314l-67.142-67.136c1.061-0.93,2.07-1.857,2.983-2.771l96.352-96.368c1.367-1.367,2.754-2.93,4.135-4.612l67.283,67.277c1.563,1.562,3.609,2.343,5.657,2.343s4.095-0.781,5.657-2.343c3.124-3.125,3.124-8.19,0-11.314l-69.372-69.366c3.742-6.413,6.847-13.132,8.523-18.856l5.379-18.367c0.769-2.62,1.894-3.787,2.463-3.932c0.061-0.016,0.133-0.024,0.216-0.024c0.688,0,2.102,0.571,3.819,2.293c0.002,0.002,0.004,0.003,0.006,0.005l118.629,118.63C495.636,138.853,496.12,140.395,495.976,140.962z"/></svg>';
                            $link1 .= __('Newsletter Settings', SIGHTLINE_TEXT_DOMAIN);
                            $link1 .= '</a>';
                            ?>
                            <?php echo $link1; ?>


                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <!-- Navigation Tabs -->
                    <div class="card-header border-bottom mb-3 d-flex d-md-none">
                        <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                            <li class="nav-item">
                                <?php echo $link1; ?>
                            </li>

                        </ul>
                    </div>

                    <div class="card-body tab-content">
                        <!-- Content 1 -->
                        <div class="tab-pane active" id="misc_settings">
                            <h3><?php echo __('Newsletter Settings', SIGHTLINE_TEXT_DOMAIN); ?></h3>
                            <hr>

                            <!-- select2 -->
                            <div class="form-group">
                                <label><?php echo __('Sightline in the news Page', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['news_page']) ? $options['news_page'] : ""; ?>
                                <select name="news_page" class="sightline_selects2" style="width:100%;">
                                    <option value=""><?php echo __('Select Page', SIGHTLINE_TEXT_DOMAIN) ?></option>
                                    <?php
                                    foreach ($pages as $page) {
                                        if ($page->ID == $value) {
                                            echo '<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';
                                        } else {
                                            echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <small class="form-text text-muted"><?php echo __('Select the page for `Sightline in the news`', SIGHTLINE_TEXT_DOMAIN); ?></small>
                            </div>

                            <!-- select2 -->
                            <div class="form-group">
                                <label><?php echo __('Press Releases Page', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['press_page']) ? $options['press_page'] : ""; ?>
                                <select name="press_page" class="sightline_selects2" style="width:100%;">
                                    <option value=""><?php echo __('Select Page', SIGHTLINE_TEXT_DOMAIN) ?></option>
                                    <?php
                                    foreach ($pages as $page) {
                                        if ($page->ID == $value) {
                                            echo '<option selected value="' . $page->ID . '">' . $page->post_title . '</option>';
                                        } else {
                                            echo '<option value="' . $page->ID . '">' . $page->post_title . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <small class="form-text text-muted"><?php echo __('Select the page for `Press Releases`', SIGHTLINE_TEXT_DOMAIN); ?></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo __('Mailchimp API Key', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_key']) ? $options['mailchimp_key'] : ""; ?>
                                <input type="text" name="mailchimp_key" id="mailchimp_key" value="<?php echo $value ?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo __('Mailchimp Server Prefix', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_server_prefix']) ? $options['mailchimp_server_prefix'] : "us2"; ?>
                                <input type="text" name="mailchimp_server_prefix" id="mailchimp_server_prefix" value="<?php echo $value ?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo __('Mailchimp From Name', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_from_name']) ? $options['mailchimp_from_name'] : "Sightline Institute"; ?>
                                <input type="text" name="mailchimp_from_name" id="mailchimp_from_name" value="<?php echo $value ?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo __('Mailchimp Reply To', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_reply_to']) ? $options['mailchimp_reply_to'] : "editor@sightline.org"; ?>
                                <input type="text" name="mailchimp_reply_to" id="mailchimp_reply_to" value="<?php echo $value ?>" />
                            </div>
                            <div class="form-group">
                                <label><?php echo __('Mailchimp Folder', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_folder_id']) ? $options['mailchimp_folder_id'] : "ffa32bdf6a"; ?>
                                <select name="mailchimp_folder_id" class="sightline_selects2" style="width:100%;">
                                    <option value=""><?php echo __('Select Campaign Folder', SIGHTLINE_TEXT_DOMAIN) ?></option>
                                    <?php
                                    foreach ($folders->folders as $folder) {
                                        if ($folder->id == $value) {
                                            echo '<option selected value="' . $folder->id . '">' . $folder->name . '</option>';
                                        } else {
                                            echo '<option value="' . $folder->id . '">' . $folder->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?php echo __('Mailchimp List', SIGHTLINE_TEXT_DOMAIN); ?></label>
                                <?php $value = isset($options['mailchimp_list_id']) ? $options['mailchimp_list_id'] : "3e1b0f73ac"; ?>
                                <select name="mailchimp_list_id" class="sightline_selects2" style="width:100%;">
                                    <option value=""><?php echo __('Select List', SIGHTLINE_TEXT_DOMAIN) ?></option>
                                    <?php
                                    foreach ($lists->lists as $list) {
                                        if ($list->id == $value) {
                                            echo '<option selected value="' . $list->id . '">' . $list->name . '</option>';
                                        } else {
                                            echo '<option value="' . $list->id . '">' . $list->name . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="btnsaveContainer">
                                <input type="submit" data-section="misc_settings" name="btnsave" value="<?php echo __('Update Settings', SIGHTLINE_TEXT_DOMAIN); ?>" class="btn btn-primary btnsave">
                                <div class="lds-ellipsis ajax-loader"><div></div><div></div><div></div><div></div></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div><!-- .wrap -->