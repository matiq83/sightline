<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type"  content="text/html charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php echo $data['title']; ?></title>
        <style type="text/css">
            @media only screen and (max-width: 645px) {
                table.container {
                    width: 480px !important;
                }
                td.banner img, img.full-width {
                    width: 480px !important;
                    height: 100px !important;
                }
                td.heading {
                    padding: 15px 30px !important;
                }
                td.image-row img {
                    width: 480px !important;
                    height: 217px !important;
                }
                td.heading h1 {
                    font-size: 20px !important;
                }
                table.featured-box table {
                    width: 100% !important;
                }
                table.social-icons-box {
                    width: 170px !important;
                }
                table.stay-connected {
                    display: none !important;
                }
                table.grid-links {
                    width: 480px !important;
                }
                table.grid-link-table {
                    width: 50% !important;
                    text-align: center !important;
                }
            }
            @media only screen and (max-width: 480px) {
                table.container {
                    width: 100% !important;
                }
                table.intro-content {
                    border-bottom-width: 20px !important;
                }
                td.banner img, img.full-width {
                    width: 100% !important;
                    height: auto !important;
                }
                td.daily-banner {
                    padding: 10px 30px 10px 30px !important;
                    background-position: center !important;
                    text-align: center !important;
                }
                td.daily-banner > div {
                    width: 100% !important;
                    text-align: center !important;
                }
                td.daily-banner > div span {
                    display: inline-block !important;
                }
                td.image-row img {
                    width: 100% !important;
                    height: auto !important;
                }
                table.social-icons-box {
                    width: 100% !important;
                    padding-bottom: 10px !important;
                }
                table.stay-connected {
                    display: block !important;
                }
                table.stay-connected td {
                    width: 100% !important;
                    padding-bottom: 15px !important;
                }
                table.social-links {
                    float:none !important;
                    width: 100% !important;
                }
                table.button {
                    width: 100% !important;
                    float: none !important;
                }
                table.grid-links {
                    width: 100% !important;
                }
                .logo-image {
                    width: 130px !important;
                }
            }
            @media only screen and (max-width: 440px) {
                table.footer-links td {
                    display: block !important;
                    padding-bottom: 5px;
                }
            }
            @media only screen and (max-width: 400px) {
                table.grid-link-table {
                    width: 100% !important;
                }
            }
            .custom_intro_content{
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body style="margin: 0;">
        <!-- Start Intro Content -->
        <table class="intro-content" width="100%" style=" border: 0; border-bottom: 35px solid #29473d;" cellspacing="0" cellpadding="0" bgcolor="#29473d">
            <tbody><tr>
                    <td style="">
                        <!-- Start Container Table -->
                        <table class="container" width="620" bgcolor="#edf5f2" align="center" border="0" cellpadding="0" cellspacing="0" style="border: 0;">
                            <tbody>
                                <tr>
                                    <td style="text-align: center; padding: 20px 10px 18px;">
                                        <?php
                                        if ($data['custom_content']) {
                                            echo '<div class="custom_intro_content">';
                                            if (isset($data['intro_image']['url'])) {
                                                if (isset($data['intro_image_link']['url'])) {
                                                    echo '<a href="' . $data['intro_image_link']['url'] . '" target="' . $data['intro_image_link']['target'] . '">';
                                                }
                                                ?>
                                                <img src="<?php echo $data['intro_image']['url']; ?>"  style="max-width: 100% !important; height: auto !important;margin-bottom: 20px;"/>
                                                <?php
                                                if (isset($data['intro_image_link']['url'])) {
                                                    echo '</a>';
                                                }
                                            }
                                            if (isset($data['special_intro_blurb']) && !empty($data['special_intro_blurb'])) {
                                                echo '<div class="special_intro_blurb">' . nl2br($data['special_intro_blurb']) . '</div>';
                                            }
                                            echo '</div>';
                                        }
                                        ?>
                                        <span style="font-size: 12px; font-family: 'Arial', sans-serif; color: #000; font-weight: bold;"><?php echo $data['preview_line']; ?></span>
                                        <div style="height: 10px;"></div>
                                        <span style="font-size: 12px; font-family: 'Arial', sans-serif; color: #000000;"><b>Call for Volunteers</b><br><br>
                                            Want to help shape Sightline Institute's forthcoming new website? Share from 30 minutes to 1 hour of your time in user testing as we design our new online home. <a style="color: #cf7300; text-decoration: none;" target="_blank" href="https://us2.list-manage.com/survey?u=68f459341f4f6a1872189d42a&amp;id=31bc8b438c">Sign up here</a> to learn more and participate. Thank you in advance!</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Intro Content -->

        <!-- Start Outer Table -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#29473d" style="border: 0;">
            <tbody><tr>
                    <td>
                        <!-- Start Container Table -->
                        <table class="container" width="620" align="center" border="0" cellpadding="0" cellspacing="0" style="border: 0;">
                            <!-- Start Banner Row -->
                            <tbody><tr>
                                    <td valign="bottom" class="daily-banner" bgcolor="#edf5f2" style="background: #edf5f2; padding: 10px 30px 10px; text-align: center; font-family: 'Arial', sans-serif; font-size: 12px;">										<table>
                                            <tbody><tr>
                                                    <td style="width: 280px; text-align: left; padding: 10px 0;">
                                                        <a href="<?php echo SIGHTLINE_SITE_BASE_URL; ?>">
                                                            <img class="logo-image" src="<?php echo SIGHTLINE_ASSETS_DIR_URL; ?>images/logo-sightline.png">
                                                        </a>
                                                    </td>
                                                    <td style="width: 280px; text-align: left; padding: 10px 0 10px 6px; font-family: 'Arial', sans-serif; font-size: 12px;">
                                                        <h1 style="font-family: 'Arial', sans-serif; font-size: 18px; font-weight: 400; line-height: 1.1em; margin: 0;"><?php echo $data['title']; ?></h1>
                                                        <p style="font-family: 'Arial', sans-serif; font-size: 12px;">Today's top sustainability headlines for Cascadia, picked fresh each morning by Sightline Institute.</p>
                                                        <div>
                                                            <span style="font-family: 'Arial', sans-serif; font-size: 12px;"><?php echo get_the_time('l, F d'); ?>.</span>
                                                            <span style="font-family: 'Arial', sans-serif; font-size: 12px;">Today's editor: <a href="<?php echo get_author_posts_url($data['todays_editor']->data->ID); ?>" style="color: #cf7300; text-decoration: none;" target="_blank"><?php echo $data['todays_editor']->data->display_name; ?></a></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                <!-- End Banner Row -->

                                <tr>
                                    <td valign="top" class="heading" bgcolor="#73baa4" style="padding: 3px; color: #ffffff; font-family: Arial, sans-serif; font-weight: normal; font-size: 12px;">
                                    </td>
                                </tr>
                                <!-- Start Image Row -->
                                <?php if (isset($data['banner'])) { ?>
                                    <tr>
                                        <td valign="top" class="image-row" bgcolor="#ffffff">
                                            <img src="<?php echo $data['banner']; ?>" alt="" style="max-width:100% !important; height: auto !important;" />
                                        </td>
                                    </tr>
                                <?php } ?>
                                <!-- End Image Row -->
                                <!-- Start Content Row -->
                                <tr>
                                    <td valign="top" class="content" bgcolor="#ffffff" style="padding: 22px 30px; color: #484569; font-family: Arial, sans-serif; font-weight: normal; font-size: 17px; line-height: 24px;">
                                        <h2 style="color: #000; font-size: 24px; font-weight: bold; font-family: 'Arial', sans-serif; margin: 15px 0 0; line-height: 34px; padding-bottom: 8px;">News Picks</h2>
                                        <div class="article-list" style="padding: 0; margin: 0;">
                                            <?php
                                            if ($data['news_query']) {
                                                $i = 0;
                                                while ($data['news_query']->have_posts()) {
                                                    $i++;
                                                    $data['news_query']->the_post();
                                                    $excerpt = get_the_excerpt();
                                                    $excerpt = substr($excerpt, 0, 200); // Only display first 200 characters of excerpt
                                                    $excerpt_result = substr($excerpt, 0, strrpos($excerpt, ' ')) . '...';
                                                    ?>
                                                    <div style="padding: 0; margin: 0 0 25px;">
                                                        <h3 class="post-title" style="margin: 0; line-height: 18px; padding-bottom: 5px;">
                                                            <a style="text-decoration: none; color: #29473d; font-family: 'Arial', sans-serif; font-size: 18px; line-height: 18px; font-weight: bold; display: inline-block; margin: 0 0 0;" href="<?php the_permalink(); ?>" target="_blank"><?php echo $i; ?>. <?php the_title(); ?></a>
                                                        </h3>
                                                        <div class="post-excerpt" style="font-size: 17px; font-family: 'Arial', sans-serif; line-height: 21px; color: #414042;"><?php echo $excerpt_result; ?></div>
                                                        <div class="post-meta" style="font-size: 12px; font-family: 'Arial', sans-serif; line-height: 17px; margin-top: 5px; color: #414042;"><em><?php echo get_the_author(); ?></em>, <?php echo get_the_time('F d'); ?></div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <table class="button" width="170" border="0" cellspacing="0" cellpadding="0">
                                            <tbody><tr>
                                                    <td valign="top" bgcolor="" style="text-align: center;">
                                                        <a href="<?php echo SIGHTLINE_SITE_BASE_URL; ?>news/" target="_blank" style="font-family: Arial, sans-serif; padding: 16px 15px 14px; color: #ffffff; text-decoration: none; text-transform: uppercase; background: #73b59f; display: block;">
                                                            See all news »				</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <br>

                                        <p style="font-size: 14px; font-style: italic; color: #666; line-height: 20px; padding-top: 20px; margin-top: 0; margin-bottom: 0;">
                                            *Note: Many of the stories we select come from news outlets that require a subscription. Please consider supporting your local and/or favorite publications for full access to their stories. Sightline's own original articles are free to access at all times, thanks to generous donors who support our work.
                                        </p>
                                        <table class="featured-box donate-thanks-box" bgcolor="#df5f2" width="100%" border="1" cellspacing="0" cellpadding="0" style="background-color: #e8f0ed; border: 1px solid #73b59f; text-align: center; font-family: Arial, sans-serif; font-size: 10px; margin-bottom: 30px; margin-top: 30px;">
                                            <tbody><tr>
                                                    <td valign="top" class="post-footer" style="padding: 15px 20px;">
                                                        <table align="left" width="" style="width: 330px; max-width: 100%; margin: 5px 0;">
                                                            <tbody><tr>
                                                                    <td style="text-align: left; color: #414042; font-family: Arial, sans-serif; font-weight: normal; font-size: 15px; line-height: 20px;">
                                                                        <span style="color: #73b59f; font-family: 'Arial', sans-serif; font-size: 17px; font-weight: bold; display: inline-block; margin-bottom: 5px;">Thanks to: Nancy Padberg</span><br>
                                                                        Sightline Institute's work is made possible through the generosity of community members like you!
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        <table valign="top" class="button" width="170" align="right" border="0" cellspacing="0" cellpadding="0" style="margin-top: 15px;">
                                                            <tbody><tr>
                                                                    <td valign="top" bgcolor="" style="text-align: center;">
                                                                        <a href="<?php echo SIGHTLINE_SITE_BASE_URL; ?>donate/" target="_blank" style="font-family: Arial, sans-serif; padding: 16px 15px 14px; color: #ffffff; font-size: 16px; text-decoration: none; text-transform: uppercase; background: #73b59f; display: inline-block;">
                                                                            Donate Now
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>

                                    </td>
                                </tr>
                                <!-- End Content Row -->
                                <!-- Start Donate Now Row -->
                                <tr>
                                    <td valign="top" class="donate-row" bgcolor="#ffffff" style="padding: 15px 30px; color: #484569; font-family: Arial, sans-serif; font-weight: normal; font-size: 17px;">
                                        <table class="social-icons-box" width="380" align="left" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 10px;">
                                            <tbody><tr>
                                                    <td class="social-icons-box-cell" valign="top" style="padding: 17px 30px 15px; border: 1px solid #74bba5;">
                                                        <table class="stay-connected" align="left" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                                    <td valign="top" style="color: #74bba5; text-align: center; text-transform: uppercase; font-family: Arial, sans-serif; font-weight: bold; font-size: 12px;">
                                                                        Stay Connected
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        <table class="social-links" align="right" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody><tr>
                                                                    <td style="padding: 0 2px;">
                                                                        <a href="https://www.facebook.com/SightlineInstitute/" target="_blank">
                                                                            <img src="http://pivotsend.com/Sightline/images/facebook-icon.jpg" alt="Facebook Icon" border="0" width="16" height="16">
                                                                        </a>
                                                                    </td>
                                                                    <td width="5"></td>
                                                                    <td style="padding: 0 2px;">
                                                                        <a href="https://twitter.com/sightline" target="_blank">
                                                                            <img src="http://pivotsend.com/Sightline/images/twitter-icon.jpg" alt="Twitter Icon" border="0" width="16" height="16">
                                                                        </a>
                                                                    </td>
                                                                    <td width="5"></td>
                                                                    <td style="padding: 0 2px;">
                                                                        <a href="https://plus.google.com/+SightlineOrg/posts" target="_blank">
                                                                            <img src="http://pivotsend.com/Sightline/images/googleplus-icon.jpg" alt="Google Plus Icon" border="0" width="16" height="16">
                                                                        </a>
                                                                    </td>
                                                                    <td width="5"></td>
                                                                    <td style="padding: 0 2px;">
                                                                        <a href="https://www.linkedin.com/company/71281" target="_blank">
                                                                            <img src="http://pivotsend.com/Sightline/images/linkedin-icon.jpg" alt="LinkedIn Icon" border="0" width="16" height="16">
                                                                        </a>
                                                                    </td>
                                                                    <td width="5"></td>
                                                                    <td style="padding: 0 2px;">
                                                                        <a href="https://www.youtube.com/user/videosightline" target="_blank">
                                                                            <img src="http://pivotsend.com/Sightline/images/youtube-icon.jpg" alt="YouTube Icon" border="0" width="16" height="16">
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        <table class="button" width="170" align="right" border="0" cellspacing="0" cellpadding="0">
                                            <tbody><tr>
                                                    <td valign="top" bgcolor="" style="text-align: center;">
                                                        <a href="<?php echo SIGHTLINE_SITE_BASE_URL; ?>donate/" target="_blank" style="font-family: Arial, sans-serif; padding: 16px 15px 14px; color: #ffffff; text-decoration: none; text-transform: uppercase; background: #d7740a; display: block;">
                                                            Donate Now
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                <!-- End Donate Now Row -->
                                <!-- Start Footer Row -->
                                <tr>
                                    <td valign="top" bgcolor="#ffffff" style="padding: 5px 30px; color: #2e483f; background-color: #ffffff; font-weight: normal;">
                                        <table class="footer-links" bgcolor="#ffffff" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 10px 0 25px; border-top: 1px solid #363636; text-align: center; font-family: Arial, sans-serif; font-size: 10px;">
                                            <tbody><tr>
                                                    <td><a href="https://sightline.us2.list-manage.com/unsubscribe?u=68f459341f4f6a1872189d42a&amp;id=3e1b0f73ac&amp;t=b&amp;e=[UNIQID]&amp;c=2d08371a4a" style="color: #2e483f; text-decoration: none;">Unsubscribe from ALL emails.</a></td>
                                                    <td width="5"></td>
                                                    <td><a href="https://sightline.us2.list-manage.com/profile?u=68f459341f4f6a1872189d42a&amp;id=3e1b0f73ac&amp;e=[UNIQID]&amp;c=2d08371a4a" style="color: #2e483f; text-decoration: none;">Manage all subscriptions</a></td>
                                                    <td width="5"></td>
                                                    <td><a href="http://www.sightline.org/signup/" style="color: #2e483f; text-decoration: none;">Not subscribed? Sign up here.</a></td>
                                                    <td width="5"></td>
                                                    <td><a href="http://www.sightline.org/site_policies/" style="color: #2e483f; text-decoration: none;">Privacy Policy</a></td>
                                                </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                <!-- End Footer Row -->
                                <!-- Start Post Footer Row -->
                                <tr>
                                    <td valign="top" class="post-footer" style="padding: 22px 50px 30px; text-align: center; color: #ffffff; font-family: Arial, sans-serif; font-weight: normal; font-size: 10px; line-height: 15px;">								Brought to you by Sightline Institute · 1402 3rd Ave Ste 500 · Seattle, WA 98101-2130 · USA. Sightline is a nonprofit, 501(c)3, working to build a sustainable Northwest—a place with strong communities, a green economy, and a healthy environment. Sightline Institute is non-partisan and does not oppose, support, or endorse any political candidate or party.
                                        <br>
                                        <br>
                                        Add <a href="mailto:editor@sightline.org" style="color:#d7740a;text-decoration:none;" target="_blank">editor@sightline.org</a> to your address book to ensure our emails reach you. Want to change how you receive these emails?
                                        <br>
                                        <br>
                                        Click here to <a href="https://sightline.us2.list-manage.com/profile?u=68f459341f4f6a1872189d42a&amp;id=3e1b0f73ac&amp;e=[UNIQID]&amp;c=2d08371a4a" style="color:#d7740a;text-decoration:none;" target="_blank">update your newsletters choices and preferences</a>
                                        Or permanently <a href="https://sightline.us2.list-manage.com/unsubscribe?u=68f459341f4f6a1872189d42a&amp;id=3e1b0f73ac&amp;t=b&amp;e=[UNIQID]&amp;c=2d08371a4a" style="color:#d7740a;text-decoration:none;" target="_blank">unsubscribe from ALL Sightline newsletters</a>
                                    </td>
                                </tr>
                                <!-- End Post Footer Row -->
                            </tbody></table>
                        <!-- End Container Table -->
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- End Outer Table -->
    </body>
</html>