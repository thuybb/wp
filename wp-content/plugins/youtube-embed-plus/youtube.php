<?php
/*
  Plugin Name: YouTube
  Plugin URI: http://www.embedplus.com/dashboard/pro-easy-video-analytics.aspx
  Description: YouTube embed plugin. Embed a responsive YouTube video, playlist gallery, or channel gallery. Add video thumbnails, analytics, SEO, caching...
  Version: 11.7
  Author: EmbedPlus Team
  Author URI: http://www.embedplus.com
 */

/*
  YouTube
  Copyright (C) 2017 EmbedPlus.com

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.

 */

//define('WP_DEBUG', true);

class YouTubePrefs
{

    public static $curltimeout = 20;
    public static $version = '11.7';
    public static $opt_version = 'version';
    public static $optembedwidth = null;
    public static $optembedheight = null;
    public static $defaultheight = null;
    public static $defaultwidth = null;
    public static $oembeddata = null;
    public static $opt_center = 'centervid';
    public static $opt_glance = 'glance';
    public static $opt_autoplay = 'autoplay';
    public static $opt_debugmode = 'debugmode';
    public static $opt_old_script_method = 'old_script_method';
    public static $opt_cc_load_policy = 'cc_load_policy';
    public static $opt_iv_load_policy = 'iv_load_policy';
    public static $opt_loop = 'loop';
    public static $opt_modestbranding = 'modestbranding';
    public static $opt_rel = 'rel';
    public static $opt_showinfo = 'showinfo';
    public static $opt_playsinline = 'playsinline';
    public static $opt_autohide = 'autohide';
    public static $opt_controls = 'controls';
    public static $opt_theme = 'theme';
    public static $opt_color = 'color';
    public static $opt_listType = 'listType';
    public static $opt_dohl = 'dohl';
    public static $opt_hl = 'hl';
    public static $opt_nocookie = 'nocookie';
    public static $opt_playlistorder = 'playlistorder';
    public static $opt_acctitle = 'acctitle';
    public static $opt_pro = 'pro';
    public static $opt_oldspacing = 'oldspacing';
    public static $opt_responsive = 'responsive';
    public static $opt_responsive_all = 'responsive_all';
    public static $opt_origin = 'origin';
    public static $opt_widgetfit = 'widgetfit';
    public static $opt_evselector_light = 'evselector_light';
    public static $opt_stop_mobile_buffer = 'stop_mobile_buffer';
    public static $opt_defaultdims = 'defaultdims';
    public static $opt_defaultwidth = 'width';
    public static $opt_defaultheight = 'height';
    public static $opt_defaultvol = 'defaultvol';
    public static $opt_vol = 'vol';
    public static $opt_apikey = 'apikey';
    public static $opt_migrate = 'migrate';
    public static $opt_migrate_youtube = 'migrate_youtube';
    public static $opt_migrate_embedplusvideo = 'migrate_embedplusvideo';
    public static $opt_gallery_pagesize = 'gallery_pagesize';
    public static $opt_gallery_apikey = 'gallery_apikey';
    public static $opt_gallery_columns = 'gallery_columns';
    public static $opt_gallery_collapse_grid = 'gallery_collapse_grid';
    public static $opt_gallery_collapse_grid_breaks = 'gallery_collapse_grid_breaks';
    public static $opt_gallery_scrolloffset = 'gallery_scrolloffset';
    public static $opt_gallery_showtitle = 'gallery_showtitle';
    public static $opt_gallery_showpaging = 'gallery_showpaging';
    public static $opt_gallery_thumbplay = 'gallery_thumbplay';
    public static $opt_gallery_autonext = 'gallery_autonext';
    public static $opt_gallery_channelsub = 'gallery_channelsub';
    public static $opt_gallery_channelsublink = 'gallery_channelsublink';
    public static $opt_gallery_channelsubtext = 'gallery_channelsubtext';
    public static $opt_gallery_customarrows = 'gallery_customarrows';
    public static $opt_gallery_customprev = 'gallery_customprev';
    public static $opt_gallery_customnext = 'gallery_customnext';
    public static $opt_not_live_content = 'not_live_content';
    public static $opt_admin_off_scripts = 'admin_off_scripts';
    public static $opt_alloptions = 'youtubeprefs_alloptions';
    public static $alloptions = null;
    public static $yt_options = array();
    public static $dft_bpts = array(array('bp' => array('min' => 0, 'max' => 767), 'cols' => 1));
    //public static $epbase = 'http://localhost:2346';
    public static $epbase = '//www.embedplus.com';
    public static $double_plugin = false;
    public static $scriptsprinted = 0;
    public static $min = '.min';
    public static $badentities = array('&#215;', '×', '&#8211;', '–', '&amp;', '&#038;', '&#38;');
    public static $goodliterals = array('x', 'x', '--', '--', '&', '&', '&');
    public static $wizard_hook = '';
    public static $get_api_key_msg = 'The ### feature now requires a (free) YouTube API key from Google. Please follow the easy steps <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">in this video</a> to create and save your API key.';
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    public static $oldytregex = '@^\s*https?://(?:www\.)?(?:(?:youtube.com/(?:(?:watch)|(?:embed)|(?:playlist))/{0,1}\?)|(?:youtu.be/))([^\s"]+)\s*$@im';
    public static $ytregex = '@^[\r\t ]*https?://(?:www\.)?(?:(?:youtube.com/(?:(?:watch)|(?:embed)|(?:playlist))/{0,1}\?)|(?:youtu.be/))([^\s"]+)[\r\t ]*$@im';
    public static $justurlregex = '@https?://(?:www\.)?(?:(?:youtube.com/(?:(?:watch)|(?:embed)|(?:playlist))/{0,1}\?)|(?:youtu.be/))([^\[\s"]+)@i';

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        add_action('admin_init', array("YouTubePrefs", 'check_double_plugin_warning'));
        self::$alloptions = get_option(self::$opt_alloptions);
        
        add_action('admin_notices', array(get_class(), 'separate_version_message'));
        
        if (self::$alloptions == false || version_compare(self::$alloptions[self::$opt_version], self::$version, '<'))
        {
            self::initoptions();
        }

        if (self::$alloptions[self::$opt_oldspacing] == 1)
        {
            self::$ytregex = self::$oldytregex;
        }

        self::$optembedwidth = intval(get_option('embed_size_w'));
        self::$optembedheight = intval(get_option('embed_size_h'));

        self::$yt_options = array(
            self::$opt_autoplay,
            self::$opt_cc_load_policy,
            self::$opt_iv_load_policy,
            self::$opt_loop,
            self::$opt_modestbranding,
            self::$opt_rel,
            self::$opt_showinfo,
            self::$opt_playsinline,
            self::$opt_autohide,
            self::$opt_controls,
            self::$opt_hl,
            self::$opt_theme,
            self::$opt_color,
            self::$opt_listType,
            'index',
            'list',
            'start',
            'end'
        );

        add_action('media_buttons', 'YouTubePrefs::media_button_wizard', 11);


        self::do_ytprefs();
        add_action('admin_menu', 'YouTubePrefs::ytprefs_plugin_menu');
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array('YouTubePrefs', 'my_plugin_action_links'));

        if (!is_admin())
        {
            if (self::$alloptions[self::$opt_old_script_method] == 1)
            {
                add_action('wp_print_scripts', array('YouTubePrefs', 'jsvars'));
                add_action('wp_enqueue_scripts', array('YouTubePrefs', 'jsvars'));
            }

            add_action('wp_enqueue_scripts', array('YouTubePrefs', 'ytprefsscript'), 100);
            add_action('wp_enqueue_scripts', array('YouTubePrefs', 'fitvids'), 101);
        }

        if (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG)
        {
            self::$min = '';
        }

        add_action("wp_ajax_my_embedplus_glance_vids", array('YouTubePrefs', 'my_embedplus_glance_vids'));
        add_action("wp_ajax_my_embedplus_glance_count", array('YouTubePrefs', 'my_embedplus_glance_count'));
        add_action("wp_ajax_my_embedplus_dismiss_double_plugin_warning", array('YouTubePrefs', 'my_embedplus_dismiss_double_plugin_warning'));
        add_action("wp_ajax_my_embedplus_gallery_page", array('YouTubePrefs', 'my_embedplus_gallery_page'));
        add_action("wp_ajax_nopriv_my_embedplus_gallery_page", array('YouTubePrefs', 'my_embedplus_gallery_page'));
        add_action('admin_enqueue_scripts', array('YouTubePrefs', 'admin_enqueue_scripts'), 10, 1);
    }
    
    public static function separate_version_message()
    {
        if (self::$alloptions[self::$opt_pro] && strlen(trim(self::$alloptions[self::$opt_pro])) > 10)
        {
            $class = 'notice notice-error is-dismissible';
            $message = 'Important message to YouTube Pro users: From version 11.7 onward, you must <a href="https://www.embedplus.com/youtube-pro/download/?prokey=' . esc_attr(self::$alloptions[self::$opt_pro]) . '" target="_blank">download the separate plugin here</a> to regain your Pro features. All your settings will automatically migrate after installing the separate Pro download. Thank you for your support and patience during this transition.';

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), wp_kses_post($message));
        }
    }

    public static function my_plugin_action_links($links)
    {
        $links[] = '<a href="' . esc_url(admin_url('admin.php?page=youtube-my-preferences')) . '">Settings</a>';
        $links[] = '<a href="https://www.embedplus.com/dashboard/pro-easy-video-analytics.aspx" target="_blank">Pro Version</a>';
        return $links;
    }

    public static function show_glance_list()
    {
        $glancehref = self::show_glance();
        $cnt = self::get_glance_count();

        //display via list
        return
                '<li class="page-count">
            <a href="' . $glancehref . '" class="thickbox ytprefs_glance_button" id="ytprefs_glance_button" title="YouTube Embeds At a Glance">
                ' . number_format_i18n($cnt) . ' With YouTube
            </a>
        </li>';
    }

    public static function show_glance_table()
    {
        $glancehref = self::show_glance();
        $cnt = self::get_glance_count();
        return
                '<tr>
            <td class="first b"><a title="YouTube Embeds At a Glance" href="' . $glancehref . '" class="thickbox ytprefs_glance_button">' . number_format_i18n($cnt) . '</a></td>
            <td class="t"><a title="YouTube Embeds At a Glance" href="' . $glancehref . '" id="ytprefs_glance_button" class="thickbox ytprefs_glance_button">With YouTube</a></td>
        </tr>';
    }

    public static function get_glance_count()
    {
        global $wpdb;
        $query_sql = "
                SELECT count(*) as mytotal
                FROM $wpdb->posts
                WHERE (post_content LIKE '%youtube.com/%' OR post_content LIKE '%youtu.be/%')
                AND post_status = 'publish'";

        $query_result = $wpdb->get_results($query_sql, OBJECT);

        return intval($query_result[0]->mytotal);
    }

    public static function show_glance()
    {
        $glancehref = admin_url('admin.php?page=youtube-ep-glance') . '&random=' . rand(1, 1000) . '&TB_iframe=true&width=780&height=800';
        return $glancehref;
    }

    public static function try_get_ytid($url)
    {
        $theytid = null;
        if (strpos($url, 'v=') !== false)
        {
            $url_params = explode('?', $url);
            $kvp = self::keyvalue($url_params[1], true);
            $theytid = $kvp['v'];
        }
        else if (strpos($url, "youtu.be") !== false)
        {
            $shortpath = explode('/', parse_url($url, PHP_URL_PATH));
            $theytid = $shortpath[1];
        }
        return $theytid;
    }

    public static function wizard()
    {
        ?>
        <div class="wrap" id="epyt_wiz_wrap">
            <div class="smallnote center"> Please periodically check the YouTube plugin tab on your admin panel to review the latest options. </div>

            <?php
            $form_valid = true;
            $acc_expand = '';
            $get_pro_link = self::$epbase . '/dashboard/pro-easy-video-analytics.aspx';



            $step1_video_errors = '';
            $step1_video_error_invalid = 'Sorry, that does not seem to be a link to an existing video. Please confirm that the link works in your browser, and then copy that full link in your address bar to paste here.';
            $step1_playlist_errors = '';
            $step1_playlist_error_invalid = 'Sorry, that does not seem to be a link to an existing playlist. Please confirm that the link works in your browser, and then copy that full link in your address bar to paste here.';
            $step1_channel_errors = '';
            $step1_channel_error_invalid = 'Sorry, that does not seem to be a link to an existing video. Please confirm that the link works in your browser, and then copy that full link in your address bar to paste here.';
            $step1_live_errors = '';
            $step1_live_error_invalid = 'Sorry, that does not seem to be a valid link to an existing video or channel. Please confirm that the link works in your browser, and then copy that full link in your address bar to paste here.';
            $if_live_preview = false;
            if (isset($_POST['wizform_submit']))
            {
                $submit_type = $_POST['wizform_submit'];
                if ($submit_type === 'step1_video')
                {
                    // validate
                    $search = sanitize_text_field(trim($_POST['txtUrl']));

                    try
                    {
                        if (empty($search))
                        {
                            throw new Exception();
                        }
                        if (preg_match(self::$justurlregex, $search))
                        {
                            //$search = esc_url($search);

                            try
                            {
                                $theytid = self::try_get_ytid($search);

                                if ($theytid == null)
                                {
                                    $form_valid = false;
                                    $step1_video_errors = $step1_video_error_invalid;
                                    $acc_expand = 'h3_video';
                                }
                                else
                                {

                                    $odata = self::get_oembed('http://youtube.com/watch?v=' . $theytid, 1920, 1280);
                                    if (is_object($odata))
                                    {
                                        ?>

                                        <div id="step2_video" class="center">

                                            <h2>
                                                <?php
                                                if (isset($odata->title))
                                                {
                                                    echo sanitize_text_field($odata->title);
                                                }
                                                ?>
                                            </h2>
                                            <p class="center">
                                                <a class="ui-button ui-widget ui-corner-all" href="<?php echo $get_pro_link; ?>" target="_blank"><span class="ui-icon ui-icon-gear"></span> Customize (PRO)</a>
                                                &nbsp; <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] https://www.youtube.com/watch?v=<?php echo esc_attr($theytid) ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert Into Editor</a>
                                            </p>
                                            &nbsp; Or Copy Code:
                                            <span class="copycode">[embedyt] https://www.youtube.com/watch?v=<?php echo esc_attr($theytid) ?>[/embedyt]</span>
                                            <div class="clearboth" style="height: 10px;">
                                            </div>
                                            <div class="center relative">
                                                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($theytid) ?>?rel=0" allowfullscreen="" width="854" height="480" frameborder="0"></iframe>
                                            </div>

                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        $form_valid = false;
                                        $step1_video_errors = $step1_video_error_invalid;
                                        $acc_expand = 'h3_video';
                                    }
                                }
                            }
                            catch (Exception $ex)
                            {
                                $form_valid = false;
                                $step1_video_errors = $step1_video_error_invalid;
                                $acc_expand = 'h3_video';
                            }
                        }
                        else
                        {
                            $search_options = new stdClass();
                            $search_options->q = $search;
                            $search_options->pageToken = null;
                            ?>
                            <div id="step2_video_search" class="center">
                                <h2>You searched for: <em class="orange"><?php echo sanitize_text_field($search); ?></em> </h2>

                                <?php
                                $search_page = self::get_search_page($search_options);
                                echo $search_page->html;
                                ?>
                            </div>
                            <?php
                        }

                        // // if valid, set and display next step
                        // if not,form_valid = false and  set accordion expander and error messages
                    }
                    catch (Exception $ex)
                    {
                        $form_valid = false;
                        $step1_video_errors = $step1_video_error_invalid;
                        $acc_expand = 'h3_video';
                    }
                }
                else if ($submit_type === 'step1_playlist')
                {
                    $search = sanitize_text_field(trim($_POST['txtUrlPlaylist']));
                    try
                    {
                        if (empty($search))
                        {
                            throw new Exception();
                        }
                        if (preg_match(self::$justurlregex, $search))
                        {
                            try
                            {
                                $theytid = null;
                                try
                                {
                                    $theytid = self::try_get_ytid($search);
                                }
                                catch (Exception $ex)
                                {
                                    
                                }

                                $urlparams = explode('?', $search);
                                $qvars = array();
                                parse_str($urlparams[1], $qvars);
                                $theplaylistid = $qvars["list"];

                                $odata = self::get_oembed('https://youtube.com/playlist?list=' . $theplaylistid, 1920, 1280);

                                if (is_object($odata))
                                {
                                    $rel = 'https://www.youtube.com/embed?listType=playlist&list=' . (esc_attr($theplaylistid) . (empty($theytid) ? '' : '&v=' . esc_attr($theytid)));
                                    ?>

                                    <div id="step2_playlist" class="center">

                                        <h2>
                                            <?php
                                            if (isset($odata->title))
                                            {
                                                echo 'Playlist: ' . sanitize_text_field($odata->title);
                                            }
                                            ?>
                                        </h2>
                                        <p class="center">
                                            <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] <?php echo $rel; ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert as Playlist</a>
                                            &nbsp; <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] <?php echo $rel . '&layout=gallery'; ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert as Gallery</a>
                                            &nbsp; <a class="ui-button ui-widget ui-corner-all" href="<?php echo $get_pro_link; ?>" target="_blank"><span class="ui-icon ui-icon-gear"></span> Customize (PRO)</a>
                                        </p>
                                        <p>
                                            Or Copy Code:
                                        </p>
                                        <p>
                                            Playlist Layout: <span class="copycode">[embedyt] <?php echo $rel; ?>[/embedyt]</span>
                                        </p>
                                        <p>
                                            Gallery Layout: <span class="copycode">[embedyt] <?php echo $rel . '&layout=gallery'; ?>[/embedyt]</span>
                                        </p>
                                        <div class="clearboth" style="height: 10px;">
                                        </div>
                                        <div class="center relative">
                                            <iframe src="<?php echo $rel; ?>" allowfullscreen="" width="854" height="480" frameborder="0"></iframe>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    $form_valid = false;
                                    $step1_playlist_errors = $step1_playlist_error_invalid;
                                    $acc_expand = 'h3_playlist';
                                }
                            }
                            catch (Exception $ex)
                            {
                                $form_valid = false;
                                $step1_playlist_errors = $step1_playlist_error_invalid;
                                $acc_expand = 'h3_playlist';
                            }
                        }
                    }
                    catch (Exception $ex)
                    {
                        $form_valid = false;
                        $step1_playlist_errors = $step1_playlist_error_invalid;
                        $acc_expand = 'h3_playlist';
                    }
                }
                else if ($submit_type === 'step1_channel')
                {
                    $search = sanitize_text_field(trim($_POST['txtUrlChannel']));
                    try
                    {
                        if (empty($search))
                        {
                            throw new Exception();
                        }
                        if (preg_match(self::$justurlregex, $search))
                        {
                            try
                            {
                                $theytid = null;
                                try
                                {
                                    $theytid = self::try_get_ytid($search);
                                }
                                catch (Exception $ex)
                                {
                                    
                                }
                                $chanvid = self::get_video_snippet($theytid);
                                if ($chanvid)
                                {
                                    $thechannel = self::get_channel_snippet($chanvid->snippet->channelId);

                                    if ($thechannel)
                                    {
                                        $theplaylistid = $thechannel->contentDetails->relatedPlaylists->uploads;
                                        $rel = 'https://www.youtube.com/embed?listType=playlist&list=' . (esc_attr($theplaylistid));
                                        ?>

                                        <div id="step2_channel" class="center">

                                            <h2>
                                                <?php
                                                echo 'Channel: ' . sanitize_text_field($chanvid->snippet->channelTitle);
                                                ?>
                                            </h2>
                                            <p class="center">
                                                <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] <?php echo $rel; ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert as Playlist</a>
                                                &nbsp; <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] <?php echo $rel . '&layout=gallery'; ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert as Gallery</a>
                                                &nbsp; <a class="ui-button ui-widget ui-corner-all" href="<?php echo $get_pro_link; ?>" target="_blank"><span class="ui-icon ui-icon-gear"></span> Customize (PRO)</a>
                                            </p>
                                            <p>
                                                Or Copy Code:
                                            </p>
                                            <p>
                                                Playlist Layout: <span class="copycode">[embedyt] <?php echo $rel; ?>[/embedyt]</span>
                                            </p>
                                            <p>
                                                Gallery Layout: <span class="copycode">[embedyt] <?php echo $rel . '&layout=gallery'; ?>[/embedyt]</span>
                                            </p>
                                            <div class="clearboth" style="height: 10px;">
                                            </div>
                                            <div class="center relative">
                                                <iframe src="<?php echo $rel; ?>" allowfullscreen="" width="854" height="480" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        $form_valid = false;
                                        $step1_channel_errors = $step1_channel_error_invalid;
                                        $acc_expand = 'h3_channel';
                                    }
                                }
                                else
                                {
                                    $form_valid = false;
                                    $step1_channel_errors = $step1_channel_error_invalid;
                                    $acc_expand = 'h3_channel';
                                }
                            }
                            catch (Exception $ex)
                            {
                                $form_valid = false;
                                $step1_channel_errors = $step1_channel_error_invalid;
                                $acc_expand = 'h3_channel';
                            }
                        }
                    }
                    catch (Exception $ex)
                    {
                        $form_valid = false;
                        $step1_channel_errors = $step1_channel_error_invalid;
                        $acc_expand = 'h3_channel';
                    }
                }
                else if ($submit_type === 'step1_live')
                {
                    $search = sanitize_text_field(trim($_POST['txtUrlLive']));
                    try
                    {
                        if (empty($search))
                        {
                            throw new Exception();
                        }

                        try
                        {
                            $thechannel = false;
                            $chanmatch = array();
                            preg_match('@/channel/(.+)@', $search, $chanmatch);
                            if (!empty($chanmatch))
                            {
                                $thechannel = self::get_channel_snippet($chanmatch[1]);
                            }
                            else
                            {
                                $theytid = null;
                                try
                                {
                                    $theytid = self::try_get_ytid($search);
                                }
                                catch (Exception $ex)
                                {
                                    
                                }
                                $chanvid = self::get_video_snippet($theytid);
                                if ($chanvid)
                                {
                                    $thechannel = self::get_channel_snippet($chanvid->snippet->channelId);
                                }
                            }
                            if ($thechannel)
                            {
                                $live_attempt = self::get_live_snippet($thechannel->id);
                                if ($live_attempt)
                                {
                                    $if_live_preview = $live_attempt->id->videoId;
                                }
                                $rel = 'https://www.youtube.com/embed?live=1&channel=' . (esc_attr($thechannel->id));
                                ?>

                                <div id="step2_channel" class="center">

                                    <h2>
                                        <?php
                                        echo 'Live Stream From Channel: ' . sanitize_text_field($thechannel->snippet->title);
                                        ?>
                                    </h2>
                                    <p class="center">
                                        <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] <?php echo $rel; ?>[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert Into Editor</a>
                                        &nbsp; <a class="ui-button ui-widget ui-corner-all" href="<?php echo $get_pro_link; ?>" target="_blank"><span class="ui-icon ui-icon-gear"></span> Customize (PRO)</a>
                                    </p>
                                    <p>
                                        Or Copy Code:
                                    </p>
                                    <p>
                                        <span class="copycode">[embedyt] <?php echo $rel; ?>[/embedyt]</span>
                                    </p>
                                    <div class="clearboth" style="height: 10px;">
                                    </div>
                                    <?php
                                    if ($if_live_preview)
                                    {
                                        ?>
                                        <div class="center relative">
                                            <iframe src="https://www.youtube.com/embed/<?php echo esc_attr($if_live_preview) ?>?rel=0" allowfullscreen="" width="854" height="480" frameborder="0"></iframe>
                                        </div>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <?php
                            }
                            else
                            {
                                $form_valid = false;
                                $step1_live_errors = $step1_live_error_invalid;
                                $acc_expand = 'h3_live';
                            }
                        }
                        catch (Exception $ex)
                        {
                            $form_valid = false;
                            $step1_live_errors = $step1_live_error_invalid;
                            $acc_expand = 'h3_live';
                        }
                    }
                    catch (Exception $ex)
                    {
                        $form_valid = false;
                        $step1_live_errors = $step1_live_error_invalid;
                        $acc_expand = 'h3_live';
                    }
                }
                else
                {
                    $form_valid = false;
                    $acc_expand = 'h3none';
                }
            }

            if (!isset($_POST['wizform_submit']) || ($form_valid === false))
            {
                if ($form_valid === false)
                {
                    ?>
                    <script type="text/javascript">
                        var _EPYTWIZ_ = _EPYTWIZ_ || {};
                        _EPYTWIZ_.acc_expand = '<?php echo sanitize_key($acc_expand) ?>';</script>
                    <?php
                }
                ?>

                <div class="wiz-accordion">
                    <h3 class="header-go"><a href="<?php echo admin_url('admin.php?page=youtube-my-preferences#jumpdefaults'); ?>">Check my general YouTube embedding instructions and settings. </a></h3>
                    <div class="header-go-content"></div>
                    <h3 id="h3_video"><a href="#">Embed a single video.</a></h3>
                    <div>
                        <h4 class="center">Single video directions</h4>
                        <p>
                            Search YouTube videos by title below (example: <em>TED talks</em>). Or, if you already have the URL for the video, you can paste it below (example: <em>https://www.youtube.com/watch?v=YVvn8dpSAt0</em> )
                        </p>
                        <form name="wizform_video" method="post" action="" class="wizform" id="wizform_video">
                            <div class="center txt-button-align">
                                <input name="txtUrl" maxlength="200" id="txtUrl" class="txturlpastecustom ui-widget ui-widget-content ui-corner-all" placeholder="Search by title or paste URL here" type="text"> <button name="wizform_submit" class="ui-button ui-widget ui-corner-all" type="submit" value="step1_video">Submit</button>
                            </div>
                            <p class="badpaste orange bold" style="display: none;">
                                Please do not paste full embedcode above, only simple links to the YouTube video.
                                <br />
                                We have attempted to correct it above, but please doublecheck!
                            </p>
                        </form>
                        <?php echo $step1_video_errors ? '<p class="orange bold">' . $step1_video_errors . '</p>' : ''; ?>
                    </div>
                    <h3 id="h3_playlist"><a href="#">Embed a playlist. </a></h3>
                    <div>
                        <h4 class="center">Playlist directions</h4>
                        <div class="playlist-tabs">
                            <ul>
                                <li><a href="#ptabs-1">Self-contained layout directions</a></li>
                                <li><a href="#ptabs-2">Gallery layout directions</a></li>
                            </ul>
                            <div id="ptabs-1">
                                <img src="<?php echo plugins_url('/images/icon-playlist-self.jpg', __FILE__) ?>" class="icon-playlist" />
                                <ol>
                                    <li>Go to the page for the playlist that lists all of its videos (<a href="https://www.youtube.com/playlist?list=PL70DEC2B0568B5469" target="_blank">Example &raquo;</a>). </li>
                                    <li>You may then click on the video that you want the playlist to start with.</li>
                                    <li>Copy the URL in your browser and paste it in the textbox below. You'll notice that a playlist URL contains the playlist ID (e.g. "PL...")</li>
                                    <li>Click "Get Playlist" to continue.</li>
                                </ol>
                                <div class="clearboth">
                                </div>
                            </div>
                            <div id="ptabs-2">
                                <img src="<?php echo plugins_url('/images/icon-playlist-gallery.jpg', __FILE__) ?>" class="icon-playlist" />
                                <ol>
                                    <li>Go to the page for the playlist that lists all of its videos (<a href="https://www.youtube.com/playlist?list=PL70DEC2B0568B5469" target="_blank">Example &raquo;</a>). </li>
                                    <li>Copy the URL in your browser and paste it in the textbox below. You'll notice that a playlist URL contains the playlist ID (e.g. "PL...")</li>
                                    <li>Click "Get Playlist" to continue.</li>
                                </ol>
                                <div class="clearboth">
                                </div>
                            </div>
                        </div>

                        <form name="wizform_playlist" method="post" action="" class="wizform" id="wizform_playlist">
                            <div class="center txt-button-align">
                                <input name="txtUrlPlaylist" maxlength="200" id="txtUrlPlaylist" class="txturlpastecustom ui-widget ui-widget-content ui-corner-all" placeholder="Paste the playlist link here" type="text">
                                <button name="wizform_submit" class="ui-button ui-widget ui-corner-all" type="submit" value="step1_playlist">Get Playlist</button>
                            </div>
                        </form>
                        <?php echo $step1_playlist_errors ? '<p class="orange bold">' . $step1_playlist_errors . '</p>' : ''; ?>
                    </div>
                    <h3 id="h3_channel"><a href="#">Embed a channel.  </a></h3>
                    <div>
                        <h4 class="center">Channel directions</h4>
                        <?php
                        if (!self::has_api_key())
                        {
                            echo str_replace('###', '"search for channel"', self::$get_api_key_msg);
                        }
                        else
                        {
                            ?>
                            <p>
                                Enter a link to any video that belongs to the user's channel. Example: https://www.youtube.com/watch?v=YVvn8dpSAt0
                            </p>
                            <form name="wizform_channel" method="post" action="" class="wizform" id="wizform_channel">
                                <div class="center txt-button-align">
                                    <input name="txtUrlChannel" maxlength="200" id="txtUrlChannel" class="txturlpastecustom ui-widget ui-widget-content ui-corner-all" placeholder="Paste YouTube link here" type="text"> <button name="wizform_submit" class="ui-button ui-widget ui-corner-all" type="submit" value="step1_channel">Get Channel</button>
                                </div>
                                <p class="badpaste orange bold" style="display: none;">
                                    Please do not paste full embedcode above, only simple links to the YouTube video.
                                    <br />
                                    We have attempted to correct it above, but please doublecheck!
                                </p>
                            </form>
                            <?php echo $step1_channel_errors ? '<p class="orange bold">' . $step1_channel_errors . '</p>' : ''; ?>
                            <?php
                        }
                        ?>
                    </div>
                    <h3 id="h3_live"><a href="#">Embed a live stream. <sup class="orange">NEW</sup> </a></h3>
                    <div>
                        <h4 class="center">Live stream directions</h4>
                        <?php
                        if (!self::has_api_key())
                        {
                            echo str_replace('###', 'live stream', self::$get_api_key_msg);
                        }
                        else
                        {
                            ?>
                            <ol>
                                <li>Enter in the URL of the channel that the live feed belongs to.
                                    <ul class="ul-disc">
                                        <li><small>Example: https://www.youtube.com/<strong>channel</strong>/UCnM5iMGiKsZg-iOlIO2ZkdQ </small></li>
                                        <li><small>(If you do not know the exact channel URL, enter in the URL to any single video that belongs to that channel, to automatically retrieve the channel URL. Example: https://www.youtube.com/watch?v=fIW8Vvfbojc )</small></li>
                                    </ul>
                                </li>
                                <li>On the YouTube settings page, enter in the "Default Not Live Content" field what content should display while your channel is <em>not</em> currently streaming.
                                </li>
                            </ol>
                            <form name="wizform_live" method="post" action="" class="wizform" id="wizform_live">
                                <div class="center txt-button-align">
                                    <input name="txtUrlLive" maxlength="200" id="txtUrlLive" class="ui-widget ui-widget-content ui-corner-all" placeholder="Paste YouTube link here" type="text"> <button name="wizform_submit" class="ui-button ui-widget ui-corner-all" type="submit" value="step1_live">Submit</button>
                                </div>
                            </form>
                            <?php echo $step1_live_errors ? '<p class="orange bold">' . $step1_live_errors . '</p>' : ''; ?>
                            <?php
                        }
                        ?>
                    </div>
                    <h3 class="header-go"><a href="<?php echo self::$epbase . '/dashboard/pro-easy-video-analytics.aspx'; ?>">Check my performance, blocked countries, deleted videos, etc. (PRO) </a></h3>
                    <div class="header-go-content"></div>
                </div>
                <a id="lnkYthealth" class="ythealth imglink" href="<?php echo self::$epbase ?>/dashboard/pro-easy-video-analytics.aspx" target="_blank">
                    <img src="<?php echo plugins_url('/images/ythealth.png', __FILE__) ?>">
                    <div class="tip">
                        <span class=orange>(PRO)</span> Click to request an instant YouTube diagnostic report to see what (if any) important service problems that Google/YouTube are having right now that might affect your embeds, playlists, and analytics. This report includes issues affecting all types of embeds (standard and advanced players) and sites (not just WordPress). It also considers different devices; e.g. phones, tablets, and PCs.
                    </div>
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }

    public static function has_api_key()
    {
        if (isset(self::$alloptions[self::$opt_apikey]) && strlen(trim(self::$alloptions[self::$opt_apikey])) > 0)
        {
            return true;
        }

        return false;
    }

    public static function get_live_snippet($channel)
    {
        $apiEndpoint = 'https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&maxResults=1&type=video&eventType=live&safeSearch=none&videoEmbeddable=true&key=' . self::$alloptions[self::$opt_apikey]
                . '&channelId=' . urlencode($channel);
        $apiResult = wp_remote_get($apiEndpoint, array('timeout' => self::$curltimeout));

        if (is_wp_error($apiResult))
        {
            return false;
        }

        $jsonResult = json_decode($apiResult['body']);

        if (isset($jsonResult->error))
        {
            return false;
        }

        if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items) && count($jsonResult->items))
        {
            return $jsonResult->items[0];
        }

        return false;
    }

    public static function get_video_snippet($vid)
    {
        $apiEndpoint = 'https://www.googleapis.com/youtube/v3/videos?part=snippet&maxResults=1&key=' . self::$alloptions[self::$opt_apikey]
                . '&id=' . urlencode($vid);
        $apiResult = wp_remote_get($apiEndpoint, array('timeout' => self::$curltimeout));

        if (is_wp_error($apiResult))
        {
            return false;
        }

        $jsonResult = json_decode($apiResult['body']);

        if (isset($jsonResult->error))
        {
            return false;
        }

        if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items) && count($jsonResult->items))
        {
            return $jsonResult->items[0];
        }

        return false;
    }

    public static function get_channel_snippet($channid)
    {
        $apiEndpoint = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails,snippet&key=' . self::$alloptions[self::$opt_apikey]
                . '&id=' . urlencode($channid);
        $apiResult = wp_remote_get($apiEndpoint, array('timeout' => self::$curltimeout));

        if (is_wp_error($apiResult))
        {
            return false;
        }

        $jsonResult = json_decode($apiResult['body']);

        if (isset($jsonResult->error))
        {
            return false;
        }

        if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items) && count($jsonResult->items))
        {
            return $jsonResult->items[0];
        }

        return false;
    }

    public static function get_search_page($options)
    {
        $gallobj = new stdClass();
        $pageSize = 20;

        if (!self::has_api_key())
        {
            $gallobj->html = '<div>' . str_replace('###', 'search', self::$get_api_key_msg) . '</div>';
            return $gallobj;
        }

        $apiEndpoint = 'https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=' . $pageSize . '&type=video&safeSearch=none&videoEmbeddable=true&key=' . self::$alloptions[self::$opt_apikey]
                . '&q=' . urlencode($options->q);
        if (!empty($options->pageToken))
        {
            $apiEndpoint .= '&pageToken=' . $options->pageToken;
        }

        $code = '';
        $apiResult = wp_remote_get($apiEndpoint, array('timeout' => self::$curltimeout));

        if (is_wp_error($apiResult))
        {
            $gallobj->html = '<div>Sorry, there was a YouTube API error: <em>' . htmlspecialchars(strip_tags($apiResult->get_error_message())) . '</em>' .
                    ' Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.' .
                    '</div>';
            return $gallobj;
        }

        $jsonResult = json_decode($apiResult['body']);

        if (isset($jsonResult->error))
        {
            if (isset($jsonResult->error->message))
            {
                $gallobj->html = '<div>Sorry, there was a YouTube API error: <em>' . htmlspecialchars(strip_tags($jsonResult->error->message)) . '</em>' .
                        ' Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.' .
                        '</div>';
                return $gallobj;
            }
            $gallobj->html = '<div>Sorry, there may be an issue with your YouTube API key. Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.</div>';
            return $gallobj;
        }

        $totalResults = $jsonResult->pageInfo->totalResults;

        $nextPageToken = '';
        $prevPageToken = '';
        if (isset($jsonResult->nextPageToken))
        {
            $nextPageToken = $jsonResult->nextPageToken;
        }

        if (isset($jsonResult->prevPageToken))
        {
            $prevPageToken = $jsonResult->prevPageToken;
        }

        $cnt = 0;

        $code .= '<div class="epyt-search-results">';

        if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items))
        {
            foreach ($jsonResult->items as $item)
            {

                $thumb = new stdClass();

                $thumb->id = isset($item->snippet->resourceId->videoId) ? $item->snippet->resourceId->videoId : null;
                $thumb->id = $thumb->id ? $thumb->id : $item->id->videoId;
                $thumb->title = $item->snippet->title;

                if (isset($item->snippet->thumbnails->high->url))
                {
                    $thumb->img = $item->snippet->thumbnails->high->url;
                    $thumb->quality = 'high';
                }
                elseif (isset($item->snippet->thumbnails->default->url))
                {
                    $thumb->img = $item->snippet->thumbnails->default->url;
                    $thumb->quality = 'default';
                }
                elseif (isset($item->snippet->thumbnails->medium->url))
                {
                    $thumb->img = $item->snippet->thumbnails->medium->url;
                    $thumb->quality = 'medium';
                }
                else
                {
                    $thumb->img = plugins_url('/images/deleted-video-thumb.png', __FILE__);
                    $thumb->quality = 'medium';
                }


                $code .= self::get_search_result_html($thumb, $options);
                $cnt++;
                $code .= '<div class="clear-both"></div>';
            }
        }

        $code .= '<div class="clear-both"></div></div>';

        $totalPages = ceil($totalResults / $pageSize);
        $pagination = '<div class="epyt-pagination">';

        $txtprev = self::$alloptions[self::$opt_gallery_customarrows] ? self::$alloptions[self::$opt_gallery_customprev] : _('Prev');
        $pagination .= '<div tabindex="0" role="button" class="epyt-pagebutton epyt-prev ' . (empty($prevPageToken) ? ' hide ' : '') . '" data-q="' . esc_attr($options->q)
                . '" data-pagetoken="' . esc_attr($prevPageToken)
                . '"><div class="arrow">&laquo;</div> <div>' . $txtprev . '</div></div>';


        $pagination .= '<div class="epyt-pagenumbers ' . ($totalPages > 1 ? '' : 'hide') . '">';
        $pagination .= '<div class="epyt-current">1</div><div class="epyt-pageseparator"> / </div><div class="epyt-totalpages">' . $totalPages . '</div>';
        $pagination .= '</div>';

        $txtnext = self::$alloptions[self::$opt_gallery_customarrows] ? self::$alloptions[self::$opt_gallery_customnext] : _('Next');
        $pagination .= '<div tabindex="0" role="button" class="epyt-pagebutton epyt-next' . (empty($nextPageToken) ? ' hide ' : '') . '" data-q="' . esc_attr($options->q)
                . '" data-pagetoken="' . esc_attr($nextPageToken)
                . '"><div>' . $txtnext . '</div> <div class="arrow">&raquo;</div></div>';

        $pagination .= '<div class="epyt-loader"><img alt="loading" width="16" height="11" src="' . plugins_url('images/gallery-page-loader.gif', __FILE__) . '"></div>';
        $pagination .= '</div>';

        $code = $pagination . $code . $pagination;
        $gallobj->html = $code;
        return $gallobj;
    }

    public static function get_search_result_html($thumb, $options)
    {
        $get_pro_link = self::$epbase . '/dashboard/pro-easy-video-analytics.aspx';
        $escId = esc_attr($thumb->id);
        $code = '';

        $code .= '<div class="resultdiv" data-vid="' . $escId . '">
            <div class="resultinfo">
                <a class="pointer thumb load-movie" style="background-image: url(' . esc_url($thumb->img) . ')"></a>
                <a class="resulttitle pointer load-movie"><span class="ui-icon ui-icon-circle-triangle-e"></span> ' . sanitize_text_field($thumb->title) . '</a>
                <br>
                <span style="display: block;" id="scrollwatch' . $escId . '"></span>
                <div class="resultsubinfo">
                    <p>
                        <a class="ui-button ui-widget ui-corner-all" href="' . $get_pro_link . '" target="_blank"><span class="ui-icon ui-icon-gear"></span> Customize (PRO)</a>
                        &nbsp; <a class="ui-button ui-widget ui-corner-all inserttopost" rel="[embedyt] https://www.youtube.com/watch?v=' . $escId . '[/embedyt]"><span class="ui-icon ui-icon-arrowthickstop-1-s"></span> Insert Into Editor</a>
                    </p>
                    &nbsp; Or Copy Code:
                    <span class="copycode">[embedyt] https://www.youtube.com/watch?v=' . $escId . '[/embedyt]</span>
                </div>
            </div>
        </div>
        <div id="moviecontainer' . $escId . '" class="center moviecontainer relative" style="display: none;">
            Preview: <a id="closeme' . $escId . '" class="closeme" data-vid="' . $escId . '">
                &times;
            </a>
            <div id="watch' . $escId . '">
            </div>
        </div>';

        return $code;
    }

    public static function glance_page()
    {
        ?>
        <div class="wrap">
            <style type="text/css">
                #wphead {display:none;}
                #wpbody{margin-left: 0px;}
                .wrap {font-family: Arial; padding: 0px 10px 0px 10px; line-height: 180%;}
                .bold {font-weight: bold;}
                .orange {color: #f85d00;}
                #adminmenuback {display: none;}
                #adminmenu, adminmenuwrap {display: none;}
                #wpcontent, .auto-fold #wpcontent {margin-left: 0px;}
                #wpadminbar {display:none;}
                html.wp-toolbar {padding: 0px;}
                #footer, #wpfooter, .auto-fold #wpfooter {display: none;}
                #wpfooter {clear: both}
                .acctitle {background-color: #dddddd; border-radius: 5px; padding: 7px 15px 7px 15px; cursor: pointer; margin: 10px; font-weight: bold; font-size: 12px;}
                .acctitle:hover {background-color: #cccccc;}
                .accbox {display: none; position: relative; margin:  5px 8px 30px 15px; clear: both; line-height: 180%;}
                .accclose {position: absolute; top: -38px; right: 5px; cursor: pointer; width: 24px; height: 24px;}
                .accloader {padding-right: 20px;}
                .accthumb {display: block; width: 300px; float: left; margin-right: 25px;}
                .accinfo {width: 300px; float: left;}
                .accvidtitle {font-weight: bold; font-size: 16px;}
                .accthumb img {width: 300px; height: auto; display: block;}
                .clearboth {clear: both;}
                .pad20 {padding: 20px;}
                .center {text-align: center;}
            </style>
            <script type="text/javascript">
                function accclose(ele)
                {
                    jQuery(ele).parent('.accbox').hide(400);
                }

                (function ($j)
                {
                    $j(document).ready(function () {


                        $j('.acctitle').click(function () {
                            var $acctitle = $j(this);
                            var $accbox = $j(this).parent().children('.accbox');
                            var pid = $accbox.attr("data-postid");
                            $acctitle.prepend('<img alt="loading" class="accloader" src="<?php echo plugins_url('images/ajax-loader.gif', __FILE__) ?>" />');
                            jQuery.ajax({
                                type: "post",
                                dataType: "json",
                                timeout: 30000,
                                url: wpajaxurl,
                                data: {action: 'my_embedplus_glance_vids', postid: pid},
                                success: function (response) {
                                    if (response.type === "success") {
                                        $accbox.html(response.data),
                                                $accbox.show(400);
                                    }
                                    else {
                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {

                                },
                                complete: function () {
                                    $acctitle.children('.accloader').remove();
                                }

                            });
                        });
                    });
                })(jQuery);</script>
            <?php
            global $wpdb;
            $query_sql = "
                SELECT SQL_CALC_FOUND_ROWS *
                FROM $wpdb->posts
                WHERE (post_content LIKE '%youtube.com/%' OR post_content LIKE '%youtu.be/%')
                AND post_status = 'publish'
                order by post_date DESC LIMIT 0, 10";

            $query_result = $wpdb->get_results($query_sql, OBJECT);

            if ($query_result !== null)
            {
                $total = $wpdb->get_var("SELECT FOUND_ROWS();");
                global $post;
                echo '<h2><img alt="YouTube Plugin Icon" src="' . plugins_url('images/youtubeicon16.png', __FILE__) . '" /> 10 Latest Posts/Pages with YouTube Videos (' . $total . ' Total)</h2>';
                ?>

                We recommend using this page as an easy way to check the results of the global default settings you make on your recent embeds. Or, simply use it as an index to jump right to your posts that contain YouTube embeds.

                <?php
                if ($total > 0)
                {
                    echo '<ul class="accord">';
                    foreach ($query_result as $post)
                    {
                        echo '<li>';
                        setup_postdata($post);
                        the_title('<div class="acctitle">', ' &raquo;</div>');
                        echo '<div class="accbox" data-postid="' . $post->ID . '"></div><div class="clearboth"></div></li>';
                    }
                    echo '</ul>';
                }
                else
                {
                    echo '<p class="center bold orange">You currently do not have any YouTube embeds yet.</p>';
                }
            }

            wp_reset_postdata();
            ?>
            To remove this feature from your dashboard, simply uncheck <i>Show "At a Glance" Embed Links</i> in the <a target="_blank" href="<?php echo admin_url('admin.php?page=youtube-my-preferences#jumpdefaults') ?>">plugin settings page &raquo;</a>.

        </div>
        <?php
    }

    public static function my_embedplus_glance_vids()
    {
        $result = array();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $postid = intval($_REQUEST['postid']);
            $currpost = get_post($postid);

            $thehtml = '<img alt="close" class="accclose" onclick="accclose(this)" src="' . plugins_url('images/accclose.png', __FILE__) . '" />';

            $matches = Array();
            $ismatch = preg_match_all(self::$justurlregex, $currpost->post_content, $matches);

            if ($ismatch)
            {
                foreach ($matches[0] as $match)
                {
                    $link = trim(preg_replace('/&amp;/i', '&', $match));
                    $link = preg_replace('/\s/', '', $link);
                    $link = trim(str_replace(self::$badentities, self::$goodliterals, $link));

                    $linkparamstemp = explode('?', $link);

                    $linkparams = array();
                    if (count($linkparamstemp) > 1)
                    {
                        $linkparams = self::keyvalue($linkparamstemp[1], true);
                    }
                    if (strpos($linkparamstemp[0], 'youtu.be') !== false && !isset($linkparams['v']))
                    {
                        $vtemp = explode('/', $linkparamstemp[0]);
                        $linkparams['v'] = array_pop($vtemp);
                    }

                    $vidid = $linkparams['v'];

                    if ($vidid != null)
                    {
                        try
                        {
                            $odata = self::get_oembed('https://youtube.com/watch?v=' . $vidid, 1920, 1280);
                            $postlink = get_permalink($postid);
                            if ($odata != null && !is_wp_error($odata))
                            {
                                $_name = esc_attr(sanitize_text_field($odata->title));
                                $_description = esc_attr(sanitize_text_field($odata->author_name));
                                $_thumbnailUrl = esc_url("https://i.ytimg.com/vi/" . $vidid . "/0.jpg");

                                $thehtml .= '<a target="_blank" href="' . $postlink . '" class="accthumb"><img alt="YouTube Video" src="' . $_thumbnailUrl . '" /></a>';
                                $thehtml .= '<div class="accinfo">';
                                $thehtml .= '<a target="_blank" href="' . $postlink . '" class="accvidtitle">' . $_name . '</a>';
                                $thehtml .= '<div class="accdesc">' . (strlen($_description) > 400 ? substr($_description, 0, 400) . "..." : $_description) . '</div>';
                                $thehtml .= '</div>';
                                $thehtml .= '<div class="clearboth pad20"></div>';
                            }
                            else
                            {
                                $thehtml .= '<p class="center bold orange">This <a target="_blank" href="' . $postlink . '">post/page</a> contains a video that has been removed from YouTube.';
                                $thehtml .='<br><a target="_blank" href="https://www.embedplus.com/dashboard/pro-easy-video-analytics.aspx">Activate delete video tracking to catch these cases &raquo;</a>';
                                $thehtml .= '</strong>';
                            }
                        }
                        catch (Exception $ex)
                        {
                            
                        }
                    }
                    else if (isset($linkparams['list']))
                    {
                        // if playlist
                        try
                        {
                            $odata = self::get_oembed('https://youtube.com/playlist?list=' . $linkparams['list'], 1920, 1280);
                            $postlink = get_permalink($postid);
                            if ($odata != null && !is_wp_error($odata))
                            {
                                $_name = esc_attr(sanitize_text_field($odata->title));
                                $_description = esc_attr(sanitize_text_field($odata->author_name));
                                $_thumbnailUrl = esc_url($odata->thumbnail_url);

                                $thehtml .= '<a target="_blank" href="' . $postlink . '" class="accthumb"><img alt="YouTube Video" src="' . $_thumbnailUrl . '" /></a>';
                                $thehtml .= '<div class="accinfo">';
                                $thehtml .= '<a target="_blank" href="' . $postlink . '" class="accvidtitle">' . $_name . '</a>';
                                $thehtml .= '<div class="accdesc">' . (strlen($_description) > 400 ? substr($_description, 0, 400) . "..." : $_description) . '</div>';
                                $thehtml .= '</div>';
                                $thehtml .= '<div class="clearboth pad20"></div>';
                            }
                            else
                            {
                                $thehtml .= '<p class="center bold orange">This <a target="_blank" href="' . $postlink . '">post/page</a> contains a video that has been removed from YouTube.';
                                $thehtml .='<br><a target="_blank" href="https://www.embedplus.com/dashboard/pro-easy-video-analytics.aspx">Activate delete video tracking to catch these cases &raquo;</a>';
                                $thehtml .= '</strong>';
                            }
                        }
                        catch (Exception $ex)
                        {
                            
                        }
                    }
                }
            }



            if ($currpost != null)
            {
                $result['type'] = 'success';
                $result['data'] = $thehtml;
            }
            else
            {
                $result['type'] = 'error';
            }
            echo json_encode($result);
        }
        else
        {
            $result['type'] = 'error';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        die();
    }

    public static function my_embedplus_glance_count()
    {
        $result = array();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $thehtml = '';

            try
            {
                if (version_compare(get_bloginfo('version'), '3.8', '>='))
                {
                    $result['container'] = '#dashboard_right_now ul';
                    $thehtml .= self::show_glance_list();
                }
                else
                {
                    $result['container'] = '#dashboard_right_now .table_content table tbody';
                    $thehtml .= self::show_glance_table();
                }
                $result['type'] = 'success';
                $result['data'] = $thehtml;
            }
            catch (Exception $e)
            {
                $result['type'] = 'error';
            }

            echo json_encode($result);
        }
        else
        {
            $result['type'] = 'error';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        die();
    }

    public static function media_button_wizard()
    {
        add_thickbox();

        $wizhref = admin_url('admin.php?page=youtube-ep-wizard') .
//                '&wpversion=' . get_bloginfo('version') .
//                '&settingsurl=' . urlencode(admin_url('admin.php?page=youtube-my-preferences#jumpdefaults')) .
//                '&blogwidth=' . YouTubePrefs::get_blogwidth() .
//                '&domain=' . urlencode(site_url()) .
//                '&myytdefaults=' . urlencode(http_build_query(YouTubePrefs::$alloptions)) .
                '&random=' . rand(1, 1000) .
                '&TB_iframe=true&width=950&height=800';
        ?>
        <a href="<?php echo $wizhref; ?>" class="thickbox button ytprefs_media_link" id="ytprefs_wiz_button" title="Visual YouTube Search Tool and Wizard - For easier embedding"><span></span> YouTube</a>
        <?php
    }

    public static function check_double_plugin_warning()
    {
        if (is_plugin_active('embedplus-for-wordpress/embedplus.php'))
        {
            add_action('admin_notices', array("YouTubePrefs", "double_plugin_warning"));
        }
    }

    public static function double_plugin_warning()
    {
        global $pagenow;
        $user_id = get_current_user_id();
        if ($pagenow != 'plugins.php' || get_user_meta($user_id, 'embedplus_double_plugin_warning', true) != 1)
        {
            //echo '<div class="error">' . $_SERVER['QUERY_STRING'] .'</div>';
            if ($pagenow == 'plugins.php' || strpos($_SERVER['QUERY_STRING'], 'youtube-my-preferences') !== false ||
                    strpos($_SERVER['QUERY_STRING'], 'embedplus-video-analytics-dashboard') !== false ||
                    strpos($_SERVER['QUERY_STRING'], 'youtube-ep-analytics-dashboard') !== false ||
                    strpos($_SERVER['QUERY_STRING'], 'embedplus-official-options') !== false)
            {
                ?>
                <style type="text/css">
                    .embedpluswarning img
                    {
                        vertical-align: text-bottom;
                    }
                    div.bgyellow {background-color: #FCFC94; position: relative;}
                    a.epxout, a.epxout:hover {font-weight: bold; color: #ffffff; background-color: #ff8888; text-decoration: none;
                                              border-radius: 20px; font-size: 15px; position: absolute; top: 3px; right: 3px;
                                              line-height: 20px; text-align: center; width: 20px; height: 20px; display: block; cursor: pointer;}
                    </style>
                    <div class="error bgyellow embedpluswarningbox">
                    <p class="embedpluswarning">
                        <?php
                        if ($pagenow == 'plugins.php')
                        {
                            echo '<a class="epxout">&times;</a>';
                        }
                        ?>
                        Seems like you have two different YouTube plugins by the EmbedPlus Team installed: <b><img alt="YouTube Icon" src="<?php echo plugins_url('images/youtubeicon16.png', __FILE__) ?>" /> YouTube</b> and <b><img alt="YouTube Icon" src="<?php echo plugins_url('images/btn_embedpluswiz.png', __FILE__) ?>" /> Advanced YouTube Embed.</b> We strongly suggest keeping only the one you prefer, so that they don't conflict with each other while trying to create your embeds.</p>
                </div>
                <iframe allowTransparency="true" src="<?php echo self::$epbase . '/both-plugins-conflict.aspx' ?>" style="width:2px; height: 2px;" ></iframe>
                <script type="text/javascript">
                    (function ($) {
                        $(document).ready(function () {
                            $('.epxout').click(function () {
                                $.ajax({
                                    type: "post",
                                    dataType: "json",
                                    timeout: 30000,
                                    url: wpajaxurl,
                                    data: {action: 'my_embedplus_dismiss_double_plugin_warning'},
                                    success: function (response) {
                                        if (response.type == "success") {
                                            $(".embedpluswarningbox").hide();
                                        }
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                    },
                                    complete: function () {
                                    }
                                });
                            });
                        });
                    })(jQuery);</script>
                <?php
            }
        }
    }

    public static function my_embedplus_dismiss_double_plugin_warning()
    {
        $result = array();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $user_id = get_current_user_id();
            update_user_meta($user_id, 'embedplus_double_plugin_warning', 1);
            $result['type'] = 'success';
            echo json_encode($result);
        }
        else
        {
            $result['type'] = 'error';
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        die();
    }

    public static function jsvars()
    {
        $loggedin = current_user_can('edit_posts');
        if (!($loggedin && self::$alloptions[self::$opt_admin_off_scripts]))
        {
            ?>
            <script data-cfasync="false">
                window._EPYT_ = window._EPYT_ || {
                    ajaxurl: "<?php echo admin_url('admin-ajax.php'); ?>",
                    security: "<?php echo wp_create_nonce('embedplus-nonce'); ?>",
                    gallery_scrolloffset: <?php echo intval(self::$alloptions[self::$opt_gallery_scrolloffset]) ?>,
                    eppathtoscripts: "<?php echo plugins_url('scripts/', __FILE__); ?>",
                    epresponsiveselector: <?php echo self::get_responsiveselector(); ?>,
                    version: "<?php echo self::$alloptions[self::$opt_version] ?>",
                    epdovol: true,
                    evselector: '<?php echo self::get_evselector(); ?>',
                    stopMobileBuffer: <?php echo self::$alloptions[self::$opt_stop_mobile_buffer] == '1' ? 'true' : 'false' ?>
                };</script>
            <?php
        }
    }

    public static function fitvids()
    {
        $loggedin = current_user_can('edit_posts');
        if (!($loggedin && self::$alloptions[self::$opt_admin_off_scripts]))
        {
            wp_enqueue_script('__ytprefsfitvids__', plugins_url('scripts/fitvids' . self::$min . '.js', __FILE__), array('__ytprefs__'), false, true);
        }
    }

    public static function initoptions()
    {
        $arroptions = get_option(self::$opt_alloptions);
        if ($arroptions !== false)
        {
            $bak = str_replace('.', '_', $arroptions[self::$opt_version]);
            add_option(self::$opt_alloptions . '_backup_' . $bak, $arroptions);
        }

        // backup settings for migration
        if (isset($arroptions[self::$opt_pro]) && strlen(trim($arroptions[self::$opt_pro])) > 10)
        {
            add_option(self::$opt_alloptions . '_migrate', $arroptions);
        }

        //vanilla defaults
        $_center = 0;
        $_glance = 1;
        $_autoplay = get_option('youtubeprefs_autoplay', 0);
        $_cc_load_policy = get_option('youtubeprefs_cc_load_policy', 0);
        $_iv_load_policy = get_option('youtubeprefs_iv_load_policy', 1);
        $_loop = get_option('youtubeprefs_loop', 0);
        $_modestbranding = get_option('youtubeprefs_modestbranding', 0);
        $_rel = get_option('youtubeprefs_rel', 1);
        $_showinfo = get_option('youtubeprefs_showinfo', 1);
        $_theme = get_option('youtubeprefs_theme', 'dark');
        $_color = get_option('youtubeprefs_color', 'red');
        $_autohide = 2;
        $_pro = '';
        $_nocookie = 0;
        $_playlistorder = 0;
        $_acctitle = 0;
        $_migrate = 0;
        $_migrate_youtube = 0;
        $_migrate_embedplusvideo = 0;
        $_controls = 2;
        $_oldspacing = 1;
        $_responsive = 0;
        $_responsive_all = 1;
        $_widgetfit = 1;
        $_evselector_light = 0;
        $_stop_mobile_buffer = 1;
        $_defaultdims = 0;
        $_defaultwidth = '';
        $_defaultheight = '';
        $_playsinline = 0;
        $_origin = 0;
        $_defaultvol = 0;
        $_vol = '';
        $_apikey = '';
        $_hl = '';
        $_dohl = 0;
        $_gallery_columns = 3;
        $_gallery_collapse_grid = 0;
        $_gallery_collapse_grid_breaks = self::$dft_bpts;
        $_gallery_scrolloffset = 20;
        $_gallery_showtitle = 1;
        $_gallery_showpaging = 1;
        $_gallery_autonext = 0;
        $_gallery_thumbplay = 1;
        $_gallery_channelsub = 0;
        $_gallery_channelsublink = '';
        $_gallery_channelsubtext = 'Subscribe to my channel';
        $_gallery_customarrows = 0;
        $_gallery_customprev = 'Prev';
        $_gallery_customnext = 'Next';
        $_gallery_pagesize = 15;
        $_not_live_content = '';
        $_debugmode = 0;
        $_admin_off_scripts = 0;
        $_old_script_method = 0;

        //update vanilla to previous settings if exists
        if ($arroptions !== false)
        {
            $_center = self::tryget($arroptions, self::$opt_center, 0);
            $_glance = self::tryget($arroptions, self::$opt_glance, 1);
            $_autoplay = self::tryget($arroptions, self::$opt_autoplay, 0);
            $_cc_load_policy = self::tryget($arroptions, self::$opt_cc_load_policy, 0);
            $_iv_load_policy = self::tryget($arroptions, self::$opt_iv_load_policy, 1);
            $_loop = self::tryget($arroptions, self::$opt_loop, 0);
            $_modestbranding = self::tryget($arroptions, self::$opt_modestbranding, 0);
            $_rel = self::tryget($arroptions, self::$opt_rel, 1);
            $_showinfo = self::tryget($arroptions, self::$opt_showinfo, 1);
            $_theme = self::tryget($arroptions, self::$opt_theme, 'dark');
            $_color = self::tryget($arroptions, self::$opt_color, 'red');
            $_autohide = self::tryget($arroptions, self::$opt_autohide, 2);
            $_pro = self::tryget($arroptions, self::$opt_pro, '');
            $_nocookie = self::tryget($arroptions, self::$opt_nocookie, 0);
            $_playlistorder = self::tryget($arroptions, self::$opt_playlistorder, 0);
            $_acctitle = self::tryget($arroptions, self::$opt_acctitle, 0);
            $_migrate = self::tryget($arroptions, self::$opt_migrate, 0);
            $_migrate_youtube = self::tryget($arroptions, self::$opt_migrate_youtube, 0);
            $_migrate_embedplusvideo = self::tryget($arroptions, self::$opt_migrate_embedplusvideo, 0);
            $_controls = self::tryget($arroptions, self::$opt_controls, 2);
            $_oldspacing = self::tryget($arroptions, self::$opt_oldspacing, 1);
            $_responsive = self::tryget($arroptions, self::$opt_responsive, 0);
            $_responsive_all = self::tryget($arroptions, self::$opt_responsive_all, 1);
            $_widgetfit = self::tryget($arroptions, self::$opt_widgetfit, 1);
            $_evselector_light = self::tryget($arroptions, self::$opt_evselector_light, 0);
            $_stop_mobile_buffer = self::tryget($arroptions, self::$opt_stop_mobile_buffer, 1);
            $_defaultdims = self::tryget($arroptions, self::$opt_defaultdims, 0);
            $_defaultwidth = self::tryget($arroptions, self::$opt_defaultwidth, '');
            $_defaultheight = self::tryget($arroptions, self::$opt_defaultheight, '');
            $_playsinline = self::tryget($arroptions, self::$opt_playsinline, 0);
            $_origin = self::tryget($arroptions, self::$opt_origin, 0);
            $_defaultvol = self::tryget($arroptions, self::$opt_defaultvol, 0);
            $_vol = self::tryget($arroptions, self::$opt_vol, '');
            $_apikey = self::tryget($arroptions, self::$opt_apikey, '');
            $_hl = self::tryget($arroptions, self::$opt_hl, '');
            $_dohl = self::tryget($arroptions, self::$opt_dohl, 0);
            $_gallery_pagesize = self::tryget($arroptions, self::$opt_gallery_pagesize, 15);
            $_gallery_columns = self::tryget($arroptions, self::$opt_gallery_columns, 3);
            $_gallery_collapse_grid = self::tryget($arroptions, self::$opt_gallery_collapse_grid, 0);
            $_gallery_collapse_grid_breaks = self::tryget($arroptions, self::$opt_gallery_collapse_grid_breaks, self::$dft_bpts);
            $_gallery_scrolloffset = self::tryget($arroptions, self::$opt_gallery_scrolloffset, 20);
            $_gallery_showtitle = self::tryget($arroptions, self::$opt_gallery_showtitle, 1);
            $_gallery_showpaging = self::tryget($arroptions, self::$opt_gallery_showpaging, 1);
            $_gallery_autonext = self::tryget($arroptions, self::$opt_gallery_autonext, 0);
            $_gallery_thumbplay = self::tryget($arroptions, self::$opt_gallery_thumbplay, 1);
            $_gallery_channelsub = self::tryget($arroptions, self::$opt_gallery_channelsub, $_gallery_channelsub);
            $_gallery_channelsublink = self::tryget($arroptions, self::$opt_gallery_channelsublink, $_gallery_channelsublink);
            $_gallery_channelsubtext = self::tryget($arroptions, self::$opt_gallery_channelsubtext, $_gallery_channelsubtext);
            $_gallery_customarrows = self::tryget($arroptions, self::$opt_gallery_customarrows, $_gallery_customarrows);
            $_gallery_customnext = self::tryget($arroptions, self::$opt_gallery_customnext, $_gallery_customnext);
            $_gallery_customprev = self::tryget($arroptions, self::$opt_gallery_customprev, $_gallery_customprev);
            $_not_live_content = self::tryget($arroptions, self::$opt_not_live_content, $_not_live_content);
            $_debugmode = self::tryget($arroptions, self::$opt_debugmode, 0);
            $_admin_off_scripts = self::tryget($arroptions, self::$opt_admin_off_scripts, $_admin_off_scripts);
            $_old_script_method = self::tryget($arroptions, self::$opt_old_script_method, 0);
        }
        else
        {
            $_oldspacing = 0;
        }

        $all = array(
            self::$opt_version => self::$version,
            self::$opt_center => $_center,
            self::$opt_glance => $_glance,
            self::$opt_autoplay => $_autoplay,
            self::$opt_cc_load_policy => $_cc_load_policy,
            self::$opt_iv_load_policy => $_iv_load_policy,
            self::$opt_loop => $_loop,
            self::$opt_modestbranding => $_modestbranding,
            self::$opt_rel => $_rel,
            self::$opt_showinfo => $_showinfo,
            self::$opt_theme => $_theme,
            self::$opt_color => $_color,
            self::$opt_autohide => $_autohide,
            self::$opt_pro => $_pro,
            self::$opt_nocookie => $_nocookie,
            self::$opt_playlistorder => $_playlistorder,
            self::$opt_acctitle => $_acctitle,
            self::$opt_migrate => $_migrate,
            self::$opt_migrate_youtube => $_migrate_youtube,
            self::$opt_migrate_embedplusvideo => $_migrate_embedplusvideo,
            self::$opt_controls => $_controls,
            self::$opt_oldspacing => $_oldspacing,
            self::$opt_responsive => $_responsive,
            self::$opt_responsive_all => $_responsive_all,
            self::$opt_widgetfit => $_widgetfit,
            self::$opt_evselector_light => $_evselector_light,
            self::$opt_stop_mobile_buffer => $_stop_mobile_buffer,
            self::$opt_defaultdims => $_defaultdims,
            self::$opt_defaultwidth => $_defaultwidth,
            self::$opt_defaultheight => $_defaultheight,
            self::$opt_playsinline => $_playsinline,
            self::$opt_origin => $_origin,
            self::$opt_defaultvol => $_defaultvol,
            self::$opt_vol => $_vol,
            self::$opt_apikey => $_apikey,
            self::$opt_hl => $_hl,
            self::$opt_dohl => $_dohl,
            self::$opt_gallery_columns => $_gallery_columns,
            self::$opt_gallery_collapse_grid => $_gallery_collapse_grid,
            self::$opt_gallery_collapse_grid_breaks => $_gallery_collapse_grid_breaks,
            self::$opt_gallery_scrolloffset => $_gallery_scrolloffset,
            self::$opt_gallery_showtitle => $_gallery_showtitle,
            self::$opt_gallery_showpaging => $_gallery_showpaging,
            self::$opt_gallery_autonext => $_gallery_autonext,
            self::$opt_gallery_thumbplay => $_gallery_thumbplay,
            self::$opt_gallery_channelsub => $_gallery_channelsub,
            self::$opt_gallery_channelsublink => $_gallery_channelsublink,
            self::$opt_gallery_channelsubtext => $_gallery_channelsubtext,
            self::$opt_gallery_customarrows => $_gallery_customarrows,
            self::$opt_gallery_customprev => $_gallery_customprev,
            self::$opt_gallery_customnext => $_gallery_customnext,
            self::$opt_gallery_pagesize => $_gallery_pagesize,
            self::$opt_not_live_content => $_not_live_content,
            self::$opt_debugmode => $_debugmode,
            self::$opt_admin_off_scripts => $_admin_off_scripts,
            self::$opt_old_script_method => $_old_script_method
        );

        update_option(self::$opt_alloptions, $all);
        update_option('embed_autourls', 1);
        self::$alloptions = get_option(self::$opt_alloptions);
    }

    public static function tryget($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    public static function wp_above_version($ver)
    {
        global $wp_version;
        if (version_compare($wp_version, $ver, '>='))
        {
            return true;
        }
        return false;
    }

    public static function do_ytprefs()
    {
        add_filter('autoptimize_filter_js_exclude', 'YouTubePrefs::ao_override_jsexclude', 10, 1);
        if (!is_admin())
        {
            add_filter('the_content', 'YouTubePrefs::apply_prefs_content', 1);
            add_filter('widget_text', 'YouTubePrefs::apply_prefs_widget', 1);
            add_shortcode('embedyt', array('YouTubePrefs', 'apply_prefs_shortcode'));
            if (self::$alloptions[self::$opt_migrate] == 1)
            {
                if (self::$alloptions[self::$opt_migrate_youtube] == 1)
                {
                    add_shortcode('youtube', array('YouTubePrefs', 'apply_prefs_shortcode_youtube'));
                    add_shortcode('youtube_video', array('YouTubePrefs', 'apply_prefs_shortcode_youtube'));
                }
                if (self::$alloptions[self::$opt_migrate_embedplusvideo] == 1)
                {
                    add_shortcode('embedplusvideo', array('YouTubePrefs', 'apply_prefs_shortcode_embedplusvideo'));
                }
            }
        }
    }

    public static function ao_override_jsexclude($exclude)
    {
        if (strpos($exclude, 'ytprefs' . self::$min . '.js') === false)
        {
            return $exclude . ",ytprefs' . self::$min . '.js,__ytprefs__";
        }
        return $exclude;
    }

    public static function apply_prefs_shortcode($atts, $content = null)
    {
        $content = trim($content);
        $currfilter = current_filter();
        if (preg_match(self::$justurlregex, $content))
        {
            return self::get_html(array($content), $currfilter == 'widget_text' ? false : true);
        }
        return '';
    }

    public static function apply_prefs_shortcode_youtube($atts, $content = null)
    {
        $content = 'https://www.youtube.com/watch?v=' . trim($content);
        $currfilter = current_filter();
        if (preg_match(self::$justurlregex, $content))
        {
            return self::get_html(array($content), $currfilter == 'widget_text' ? false : true);
        }
        return '';
    }

    public static function apply_prefs_shortcode_embedplusvideo($atts, $content = null)
    {
        $atts = shortcode_atts(array(
            "height" => self::$defaultheight,
            "width" => self::$defaultwidth,
            "vars" => "",
            "standard" => "",
            "id" => "ep" . rand(10000, 99999)
                ), $atts);

        $epvars = $atts['vars'];
        $epvars = preg_replace('/\s/', '', $epvars);
        $epvars = preg_replace('/¬/', '&not', $epvars);
        $epvars = str_replace('&amp;', '&', $epvars);

        $epparams = self::keyvalue($epvars, true);

        if (isset($epparams) && isset($epparams['ytid']))
        {
            $start = isset($epparams['start']) && is_numeric($epparams['start']) ? '&start=' . intval($epparams['start']) : '';
            $end = isset($epparams['end']) && is_numeric($epparams['end']) ? '&end=' . intval($epparams['end']) : '';
            $end = isset($epparams['stop']) && is_numeric($epparams['stop']) ? '&end=' . intval($epparams['stop']) : '';

            $url = 'https://www.youtube.com/watch?v=' . trim($epparams['ytid']) . $start . $end;

            $currfilter = current_filter();
            if (preg_match(self::$justurlregex, $url))
            {
                return self::get_html(array($url), $currfilter == 'widget_text' ? false : true);
            }
        }
        return '';
    }

    public static function apply_prefs_content($content)
    {
        $content = preg_replace_callback(self::$ytregex, "YouTubePrefs::get_html_content", $content);
        return $content;
    }

    public static function apply_prefs_widget($content)
    {
        $content = preg_replace_callback(self::$ytregex, "YouTubePrefs::get_html_widget", $content);
        return $content;
    }

    public static function get_html_content($m)
    {
        return self::get_html($m, true);
    }

    public static function get_html_widget($m)
    {
        return self::get_html($m, false);
    }

    public static function get_gallery_page($options)
    {
        $gallobj = new stdClass();

        $options->pageSize = min(intval($options->pageSize), 50);
        $options->columns = intval($options->columns);
        $options->showTitle = intval($options->showTitle);
        $options->showPaging = intval($options->showPaging);
        $options->autonext = intval($options->autonext);
        $options->thumbplay = intval($options->thumbplay);

        if (empty($options->apiKey))
        {
            $gallobj->html = '<div>Please enter your YouTube API key to embed galleries.</div>';
            return $gallobj;
        }

        $apiEndpoint = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status&playlistId=' . $options->playlistId
                . '&maxResults=' . $options->pageSize
                . '&key=' . $options->apiKey;
        if ($options->pageToken != null)
        {
            $apiEndpoint .= '&pageToken=' . $options->pageToken;
        }

        $code = '';
        $init_id = null;

        $apiResult = wp_remote_get($apiEndpoint, array('timeout' => self::$curltimeout));

        if (is_wp_error($apiResult))
        {
            $gallobj->html = '<div>Sorry, there was a YouTube API error: <em>' . htmlspecialchars(strip_tags($apiResult->get_error_message())) . '</em>' .
                    ' Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.' .
                    '</div>';
            return $gallobj;
        }

        if (self::$alloptions[self::$opt_debugmode] == 1 && current_user_can('manage_options'))
        {
            $redactedEndpoint = preg_replace('@&key=[^&]+@i', '&key=PRIVATE', $apiEndpoint);
            $active_plugins = get_option('active_plugins');
            $gallobj->html = '<pre onclick="_EPADashboard_.selectText(this);" class="epyt-debug">CLICK this debug text to auto-select all. Then, COPY the selection.' . "\n\n" .
                    'THIS IS DEBUG MODE OUTPUT. UNCHECK THE OPTION IN THE SETTINGS PAGE ONCE YOU ARE DONE DEBUGGING TO PUT THINGS BACK TO NORMAL.' . "\n\n" . $redactedEndpoint . "\n\n" . print_r($apiResult, true) . "\n\nActive Plugins\n\n" . print_r($active_plugins, true) . '</pre>';
            return $gallobj;
        }

        $jsonResult = json_decode($apiResult['body']);

        if (isset($jsonResult->error))
        {
            if (isset($jsonResult->error->message))
            {
                $gallobj->html = '<div>Sorry, there was a YouTube API error: <em>' . htmlspecialchars(strip_tags($jsonResult->error->message)) . '</em>' .
                        ' Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.' .
                        '</div>';
                return $gallobj;
            }
            $gallobj->html = '<div>Sorry, there may be an issue with your YouTube API key. Please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.</div>';
            return $gallobj;
        }



        $resultsPerPage = $options->pageSize; // $jsonResult->pageInfo->resultsPerPage;
        $totalResults = $jsonResult->pageInfo->totalResults;

        $nextPageToken = '';
        $prevPageToken = '';
        if (isset($jsonResult->nextPageToken))
        {
            $nextPageToken = $jsonResult->nextPageToken;
        }

        if (isset($jsonResult->prevPageToken))
        {
            $prevPageToken = $jsonResult->prevPageToken;
        }

        $cnt = 0;
        $colclass = ' epyt-cols-' . $options->columns . ' ';
        $code .= '<div class="epyt-gallery-allthumbs ' . $colclass . '">';

        if (isset($jsonResult->items) && $jsonResult->items != null && is_array($jsonResult->items))
        {
            foreach ($jsonResult->items as $item)
            {

                $thumb = new stdClass();

                $thumb->id = isset($item->snippet->resourceId->videoId) ? $item->snippet->resourceId->videoId : null;
                $thumb->id = $thumb->id ? $thumb->id : $item->id->videoId;
                $thumb->title = $options->showTitle ? $item->snippet->title : '';
                $thumb->privacyStatus = isset($item->status->privacyStatus) ? $item->status->privacyStatus : null;

                if ($cnt == 0 && $options->pageToken == null)
                {
                    $init_id = $thumb->id;
                }

                if ($thumb->privacyStatus == 'private')
                {
                    $thumb->img = plugins_url('/images/private.png', __FILE__);
                    $thumb->quality = 'medium';
                }
                else
                {
                    if (isset($item->snippet->thumbnails->high->url))
                    {
                        $thumb->img = $item->snippet->thumbnails->high->url;
                        $thumb->quality = 'high';
                    }
                    elseif (isset($item->snippet->thumbnails->default->url))
                    {
                        $thumb->img = $item->snippet->thumbnails->default->url;
                        $thumb->quality = 'default';
                    }
                    elseif (isset($item->snippet->thumbnails->medium->url))
                    {
                        $thumb->img = $item->snippet->thumbnails->medium->url;
                        $thumb->quality = 'medium';
                    }
                    else
                    {
                        $thumb->img = plugins_url('/images/deleted-video-thumb.png', __FILE__);
                        $thumb->quality = 'medium';
                    }
                }

                $code .= self::get_thumbnail_html($thumb, $options);
                $cnt++;

                if ($cnt % $options->columns === 0)
                {
                    $code .= '<div class="epyt-gallery-rowbreak"></div>';
                }
            }
        }

        $code .= '<div class="epyt-gallery-clear"></div></div>';

        $totalPages = ceil($totalResults / $resultsPerPage);
        $pagination = '<div class="epyt-pagination">';

        $txtprev = self::$alloptions[self::$opt_gallery_customarrows] ? self::$alloptions[self::$opt_gallery_customprev] : _('Prev');
        $pagination .= '<div tabindex="0" role="button" class="epyt-pagebutton epyt-prev ' . (empty($prevPageToken) ? ' hide ' : '') . '" data-playlistid="' . esc_attr($options->playlistId)
                . '" data-pagesize="' . intval($options->pageSize)
                . '" data-pagetoken="' . esc_attr($prevPageToken)
                . '" data-columns="' . intval($options->columns)
                . '" data-showtitle="' . intval($options->showTitle)
                . '" data-showpaging="' . intval($options->showPaging)
                . '" data-autonext="' . intval($options->autonext)
                . '" data-thumbplay="' . intval($options->thumbplay)
                . '"><div class="arrow">&laquo;</div> <div>' . $txtprev . '</div></div>';


        $pagination .= '<div class="epyt-pagenumbers ' . ($totalPages > 1 ? '' : 'hide') . '">';
        $pagination .= '<div class="epyt-current">1</div><div class="epyt-pageseparator"> / </div><div class="epyt-totalpages">' . $totalPages . '</div>';
        $pagination .= '</div>';

        $txtnext = self::$alloptions[self::$opt_gallery_customarrows] ? self::$alloptions[self::$opt_gallery_customnext] : _('Next');
        $pagination .= '<div tabindex="0" role="button" class="epyt-pagebutton epyt-next' . (empty($nextPageToken) ? ' hide ' : '') . '" data-playlistid="' . esc_attr($options->playlistId)
                . '" data-pagesize="' . intval($options->pageSize)
                . '" data-pagetoken="' . esc_attr($nextPageToken)
                . '" data-columns="' . intval($options->columns)
                . '" data-showtitle="' . intval($options->showTitle)
                . '" data-showpaging="' . intval($options->showPaging)
                . '" data-autonext="' . intval($options->autonext)
                . '" data-thumbplay="' . intval($options->thumbplay)
                . '"><div>' . $txtnext . '</div> <div class="arrow">&raquo;</div></div>';

        $pagination .= '<div class="epyt-loader"><img alt="loading" width="16" height="11" src="' . plugins_url('images/gallery-page-loader.gif', __FILE__) . '"></div>';
        $pagination .= '</div>';

        if ($options->showPaging == 0)
        {
            $pagination = '<div class="epyt-pagination"></div>';
        }
        $code = $pagination . $code . $pagination;
        $gallobj->html = $code;
        $gallobj->init_id = $init_id;
        return $gallobj;
    }

    public static function get_thumbnail_html($thumb, $options)
    {
        $escId = esc_attr($thumb->id);
        $code = '';
        $code .= '<div tabindex="0" role="button" data-videoid="' . $escId . '" class="epyt-gallery-thumb">';
        $code .= '<div class="epyt-gallery-img-box"><div class="epyt-gallery-img" style="background-image: url(' . esc_url($thumb->img) . ')">' .
                '<div class="epyt-gallery-playhover"><img alt="play" class="epyt-play-img" width="30" height="23" src="' . plugins_url('images/playhover.png', __FILE__) . '" /><div class="epyt-gallery-playcrutch"></div></div>' .
                '</div></div>';
        if (!empty($thumb->title))
        {
            $code .= '<div class="epyt-gallery-title">' . esc_html($thumb->title) . '</div>';
        }
        else
        {
            $code .= '<div class="epyt-gallery-notitle"><span>' . esc_html($thumb->title) . '</span></div>';
        }
        $code .= '</div>';
        return $code;
    }

    public static function my_embedplus_gallery_page()
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            //check_ajax_referer('embedplus-nonce', 'security');
            $options = (object) $_POST['options'];
            $options->apiKey = self::$alloptions[self::$opt_apikey];
            echo self::get_gallery_page($options)->html;
            die();
        }
    }

    public static function get_html($m, $iscontent)
    {
        //$time_start = microtime(true);

        $link = trim(str_replace(self::$badentities, self::$goodliterals, $m[0]));

        $link = preg_replace('/\s/', '', $link);
        $linkparamstemp = explode('?', $link);

        $linkparams = array();
        if (count($linkparamstemp) > 1)
        {
            $linkparams = self::keyvalue($linkparamstemp[1], true);
        }
        if (strpos($linkparamstemp[0], 'youtu.be') !== false && !isset($linkparams['v']))
        {
            $vtemp = explode('/', $linkparamstemp[0]);
            $linkparams['v'] = array_pop($vtemp);
        }

        if (isset($linkparams['channel']) && isset($linkparams['live']) && $linkparams['live'] == '1')
        {
            $live_error_msg = ' To embed live videos, please make sure you performed the <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">steps in this video</a> to create and save a proper server API key.';
            if (isset(self::$alloptions[self::$opt_apikey]))
            {

                try
                {
                    $ytapilink_live = 'https://www.googleapis.com/youtube/v3/search?order=date&maxResults=1&type=video&eventType=live&safeSearch=none&videoEmbeddable=true&channelId=' . $linkparams['channel'] . '&part=snippet&key=' . self::$alloptions[self::$opt_apikey];
                    $apidata_live = wp_remote_get($ytapilink_live, array('timeout' => self::$curltimeout));
                    if (!is_wp_error($apidata_live))
                    {
                        $raw = wp_remote_retrieve_body($apidata_live);
                        if (!empty($raw))
                        {
                            $json = json_decode($raw, true);
                            if (!isset($json['error']) && is_array($json) && count($json['items']))
                            {
                                $linkparams['v'] = $json['items'][0]['id']['videoId'];
                            }
                            else if (isset($json['error']))
                            {
                                return $live_error_msg;
                            }
                        }
                    }
                }
                catch (Exception $ex)
                {
                    return $live_error_msg;
                }
            }
            else
            {
                return $live_error_msg;
            }

            if (!isset($linkparams['v']))
            {
                return apply_filters('the_content', trim(self::$alloptions[self::$opt_not_live_content]));
            }
        }

        $youtubebaseurl = 'youtube';
        $voloutput = '';
        $acctitle = '';

        $finalparams = $linkparams + self::$alloptions;

        self::init_dimensions($link, $linkparams, $finalparams);

        if (self::$alloptions[self::$opt_nocookie] == 1)
        {
            $youtubebaseurl = 'youtube-nocookie';
        }

        if (self::$alloptions[self::$opt_defaultvol] == 1)
        {
            $voloutput = ' data-vol="' . self::$alloptions[self::$opt_vol] . '" ';
        }

        if (self::$alloptions[self::$opt_dohl] == 1)
        {
            $locale = get_locale();
            $finalparams[self::$opt_hl] = $locale;
        }
        else
        {
            unset($finalparams[self::$opt_hl]);
        }

        $centercode = '';
        if ($finalparams[self::$opt_center] == 1)
        {
            $centercode = ' style="display: block; margin: 0px auto;" ';
        }

        if (self::$alloptions[self::$opt_acctitle] == 1)
        {
            try
            {
                //attr escape
                if (self::$oembeddata)
                {
                    $acctitle = self::$oembeddata->title;
                }
                else
                {

                    if (isset($linkparams['list']))
                    {
                        $odata = self::get_oembed('https://youtube.com/playlist?list=' . $linkparams['list'], 1920, 1280);
                        if (is_object($odata) && isset($odata->title))
                        {
                            $acctitle = $odata->title;
                        }
                    }
                    else
                    {
                        $odata = self::get_oembed('https://youtube.com/watch?v=' . $linkparams['v'], 1920, 1280);
                        if (is_object($odata) && isset($odata->title))
                        {
                            $acctitle = $odata->title;
                        }
                    }
                }

                if ($acctitle)
                {
                    $acctitle = ' title="' . esc_attr($acctitle) . '" ';
                }
            }
            catch (Exception $e)
            {
                
            }
        }

        // playlist cleanup
        $videoidoutput = isset($linkparams['v']) ? $linkparams['v'] : '';

        if ((self::$alloptions[self::$opt_playlistorder] == 1 || isset($finalparams['plindex'])) && isset($finalparams['list']))
        {
            try
            {
                $videoidoutput = '';
                if (isset($finalparams['plindex']))
                {
                    $finalparams['index'] = intval($finalparams['plindex']);
                }
            }
            catch (Exception $ex)
            {
                
            }
        }

        $galleryWrapper1 = '';
        $galleryWrapper2 = '';
        $galleryCode = '';
        $galleryid_ifm_data = '';
        if (
                isset($finalparams['layout']) && strtolower($finalparams['layout']) == 'gallery' && isset($finalparams['list'])
        )
        {
            $gallery_options = new stdClass();
            $gallery_options->playlistId = $finalparams['list'];
            $gallery_options->pageToken = null;
            $gallery_options->pageSize = $finalparams[self::$opt_gallery_pagesize];
            $gallery_options->columns = intval($finalparams[self::$opt_gallery_columns]);
            $gallery_options->showTitle = intval($finalparams[self::$opt_gallery_showtitle]);
            $gallery_options->showPaging = intval($finalparams[self::$opt_gallery_showpaging]);
            $gallery_options->autonext = intval($finalparams[self::$opt_gallery_autonext]);
            $gallery_options->thumbplay = intval($finalparams[self::$opt_gallery_thumbplay]);
            $gallery_options->apiKey = self::$alloptions[self::$opt_apikey];

            $galleryid = 'epyt_gallery_' . rand(10000, 99999);
            $galleryid_ifm_data = ' data-epytgalleryid="' . $galleryid . '" ';

            $subbutton = '';
            if (self::$alloptions[self::$opt_gallery_channelsub] == 1)
            {
                $subbutton = '<div class="epyt-gallery-subscribe"><a target="_blank" class="epyt-gallery-subbutton" href="' .
                        esc_url(self::$alloptions[self::$opt_gallery_channelsublink]) . '?sub_confirmation=1"><img alt="subscribe" src="' . plugins_url('images/play-subscribe.png', __FILE__) . '" />' .
                        htmlspecialchars(self::$alloptions[self::$opt_gallery_channelsubtext], ENT_QUOTES) . '</a></div>';
            }

            $gallery_page_obj = self::get_gallery_page($gallery_options);

            $galleryWrapper1 = '<div class="epyt-gallery" data-currpage="1" id="' . $galleryid . '">';
            $galleryWrapper2 = '</div>';
            $galleryCode = $subbutton . '<div class="epyt-gallery-list">' . $gallery_page_obj->html . '</div>';
            $videoidoutput = isset($gallery_page_obj->init_id) ? $gallery_page_obj->init_id : '';
        }


        $code1 = '<iframe ' . $centercode . ' id="_ytid_' . rand(10000, 99999) . '" width="' . self::$defaultwidth . '" height="' . self::$defaultheight .
                '" src="https://www.' . $youtubebaseurl . '.com/embed/' . $videoidoutput . '?';
        $code2 = '" class="__youtube_prefs__' . ($iscontent ? '' : ' __youtube_prefs_widget__') .
                '"' . $voloutput . $acctitle . $galleryid_ifm_data . ' allowfullscreen data-no-lazy="1"></iframe>';

        $origin = '';

        try
        {
            if (self::$alloptions[self::$opt_origin] == 1)
            {
                $url_parts = parse_url(site_url());
                $origin = 'origin=' . $url_parts['scheme'] . '://' . $url_parts['host'] . '&';
            }
        }
        catch (Exception $e)
        {
            $origin = '';
        }
        $finalsrc = 'enablejsapi=1&' . $origin;

        if (count($finalparams) > 1)
        {
            foreach ($finalparams as $key => $value)
            {
                if (in_array($key, self::$yt_options))
                {
                    if (!empty($galleryCode) && ($key == 'listType' || $key == 'list'))
                    {
                        
                    }
                    else
                    {
                        if (!(isset($finalparams['live']) && $key == 'loop'))
                        {
                            $finalsrc .= htmlspecialchars($key) . '=' . htmlspecialchars($value) . '&';
                            if ($key == 'loop' && $value == 1 && !isset($finalparams['list']))
                            {
                                $finalsrc .= 'playlist=' . $finalparams['v'] . '&';
                            }
                        }
                    }
                }
            }
        }

        $code = $galleryWrapper1 . $code1 . $finalsrc . $code2 . $galleryCode . $galleryWrapper2;
        //. '<!--' . $m[0] . '-->';
        self::$defaultheight = null;
        self::$defaultwidth = null;
        self::$oembeddata = null;

        return $code;
    }

    public static function debuglog($str)
    {
        $handle = fopen(__DIR__ . "\\debug.txt", "a+");
        fwrite($handle, $str);
        fclose($handle);
    }

    public static function keyvalue($qry, $includev)
    {
        $ytvars = explode('&', $qry);
        $ytkvp = array();
        foreach ($ytvars as $k => $v)
        {
            $kvp = explode('=', $v);
            if (count($kvp) == 2 && ($includev || strtolower($kvp[0]) != 'v'))
            {
                $ytkvp[$kvp[0]] = $kvp[1];
            }
        }

        return $ytkvp;
    }

    public static function secondsToDuration($seconds)
    {
        $remaining = $seconds;
        $parts = array();
        $multipliers = array(
            'hours' => 3600,
            'minutes' => 60,
            'seconds' => 1
        );

        foreach ($multipliers as $type => $m)
        {
            $parts[$type] = (int) ($remaining / $m);
            $remaining -= ($parts[$type] * $m);
        }

        return $parts;
    }

    public static function formatDuration($parts)
    {
        $default = array(
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0
        );

        extract(array_merge($default, $parts));

        return "T{$hours}H{$minutes}M{$seconds}S";
    }

    public static function init_dimensions($url, $urlkvp, $finalparams)
    {
        // get default dimensions; try embed size in settings, then try theme's content width, then just 480px
        if (self::$defaultwidth == null)
        {
            global $content_width;
            if (empty($content_width))
            {
                $content_width = $GLOBALS['content_width'];
            }

            if (isset($urlkvp['width']) && is_numeric($urlkvp['width']))
            {
                self::$defaultwidth = $urlkvp['width'];
            }
            else if (self::$alloptions[self::$opt_defaultdims] == 1 && (isset(self::$alloptions[self::$opt_defaultwidth]) && is_numeric(self::$alloptions[self::$opt_defaultwidth])))
            {
                self::$defaultwidth = self::$alloptions[self::$opt_defaultwidth];
            }
            else if (self::$optembedwidth)
            {
                self::$defaultwidth = self::$optembedwidth;
            }
            else if ($content_width)
            {
                self::$defaultwidth = $content_width;
            }
            else
            {
                self::$defaultwidth = 480;
            }



            if (isset($urlkvp['height']) && is_numeric($urlkvp['height']))
            {
                self::$defaultheight = $urlkvp['height'];
            }
            else if (self::$alloptions[self::$opt_defaultdims] == 1 && (isset(self::$alloptions[self::$opt_defaultheight]) && is_numeric(self::$alloptions[self::$opt_defaultheight])))
            {
                self::$defaultheight = self::$alloptions[self::$opt_defaultheight];
            }
            else
            {
                self::$defaultheight = self::get_aspect_height($url, $urlkvp, $finalparams);
            }
        }
    }

    public static function get_oembed($url, $height, $width)
    {
        require_once( ABSPATH . WPINC . '/class-oembed.php' );
        $oembed = _wp_oembed_get_object();
        $args = array();
        $args['width'] = $width;
        $args['height'] = $height;
        $args['discover'] = false;
        self::$oembeddata = $oembed->fetch('https://www.youtube.com/oembed', $url, $args);
        return self::$oembeddata;
    }

    public static function get_aspect_height($url, $urlkvp, $finalparams)
    {

        // attempt to get aspect ratio correct height from oEmbed
        $aspectheight = round((self::$defaultwidth * 9) / 16, 0);


        if ($url)
        {
            $odata = self::get_oembed($url, self::$defaultwidth, self::$defaultwidth);

            if ($odata)
            {
                $aspectheight = $odata->height;
            }
        }

        if ($finalparams[self::$opt_controls] != 0 && $finalparams[self::$opt_autohide] != 1)
        {
            //add 28 for YouTube's own bar: DEPRECATED
            //$aspectheight += 28;
        }
        return $aspectheight;
    }

    public static function ytprefs_plugin_menu()
    {
        add_menu_page('YouTube Settings', 'YouTube Free', 'manage_options', 'youtube-my-preferences', 'YouTubePrefs::ytprefs_show_options', plugins_url('images/youtubeicon16.png', __FILE__), '10.000392854349');
        add_submenu_page('youtube-my-preferences', '', '', 'manage_options', 'youtube-my-preferences', 'YouTubePrefs::ytprefs_show_options');

        add_submenu_page(null, 'YouTube Posts', 'YouTube Posts', 'manage_options', 'youtube-ep-glance', 'YouTubePrefs::glance_page');
        self::$wizard_hook = add_submenu_page(null, 'YouTube Wizard', 'YouTube Wizard', 'edit_posts', 'youtube-ep-wizard', 'YouTubePrefs::wizard');
    }

    public static function custom_admin_pointers_check()
    {
        //return false; // ooopointer shut all off;
        $admin_pointers = self::custom_admin_pointers();
        foreach ($admin_pointers as $pointer => $array)
        {
            if ($array['active'])
            {
                return true;
            }
        }
    }

    public static function glance_script()
    {
        add_thickbox();
        ?>
        <script type="text/javascript">
            function widen_ytprefs_glance() {
                setTimeout(function () {
                    jQuery("#TB_window").animate({marginLeft: '-' + parseInt((780 / 2), 10) + 'px', width: '780px'}, 300);
                    jQuery("#TB_window iframe").animate({width: '780px'}, 300);
                }, 15);
            }

            (function ($j)
            {
                $j(document).ready(function () {

                    $j.ajax({
                        type: "post",
                        dataType: "json",
                        timeout: 30000,
                        url: wpajaxurl,
                        data: {action: 'my_embedplus_glance_count'},
                        success: function (response) {
                            if (response.type === "success") {
                                $j(response.container).append(response.data);
                                $j(".ytprefs_glance_button").click(widen_ytprefs_glance);
                                $j(window).resize(widen_ytprefs_glance);
                                if (typeof ep_do_pointers === 'function')
                                {
                                    //ep_do_pointers($j);
                                }
                            }
                            else {
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {

                        },
                        complete: function () {
                        }
                    });
                });
            })(jQuery);</script>
        <?php
    }

    public static function custom_admin_pointers_footer()
    {
        $admin_pointers = self::custom_admin_pointers();
        ?>
        <script type="text/javascript">
            /* <![CDATA[ */
            function ep_do_pointers($)
            {
        <?php
        foreach ($admin_pointers as $pointer => $array)
        {
            if ($array['active'])
            {
                ?>
                        $('<?php echo $array['anchor_id']; ?>').pointer({
                            content: '<?php echo $array['content']; ?>',
                            position: {
                                edge: '<?php echo $array['edge']; ?>',
                                align: '<?php echo $array['align']; ?>'
                            },
                            close: function () {
                                $.post(wpajaxurl, {
                                    pointer: '<?php echo $pointer; ?>',
                                    action: 'dismiss-wp-pointer'
                                });
                            }
                        }).pointer('open');
                <?php
            }
        }
        ?>
            }

            ep_do_pointers(jQuery); // switch off all pointers via js ooopointer
            /* ]]> */
        </script>
        <?php
    }

    public static function custom_admin_pointers()
    {
        $dismissed = explode(',', (string) get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true));
        $version = str_replace('.', '_', self::$version); // replace all periods in version with an underscore
        $prefix = 'custom_admin_pointers' . $version . '_';

        $new_pointer_content = '<h3>' . __('New Update') . '</h3>'; // ooopointer

        $new_pointer_content .= '<p>'; // ooopointer
        if (!(self::$alloptions[self::$opt_pro] && strlen(trim(self::$alloptions[self::$opt_pro])) > 0))
        {
            $new_pointer_content .= __("This update has code refactoring to separate and streamline the Free and <a target=_blank href=" . self::$epbase . '/dashboard/pro-easy-video-analytics.aspx?ref=frompointer' . ">Pro versions &raquo;</a>");
        }
        else
        {
            $new_pointer_content .= __("This update has code refactoring to separate and streamline the Free and Pro versions. " . '<strong>Important message to YouTube Pro users</strong>: From version 11.7 onward, you must <a href="https://www.embedplus.com/youtube-pro/download/?prokey=' . esc_attr(self::$alloptions[self::$opt_pro]) . '" target="_blank">download the separate plugin here</a> to regain your Pro features. All your settings will automatically migrate after installing the separate Pro download. Thank you for your support and patience during this transition.');
        }
        $new_pointer_content .= '</p>';

        return array(
            $prefix . 'new_items' => array(
                'content' => $new_pointer_content,
                'anchor_id' => 'a.toplevel_page_youtube-my-preferences', //'#ytprefs_glance_button', 
                'edge' => 'top',
                'align' => 'left',
                'active' => (!in_array($prefix . 'new_items', $dismissed) )
            ),
        );
    }

    public static function postchecked($idx)
    {
        return isset($_POST[$idx]) && $_POST[$idx] == (true || 'on');
    }

    public static function output_scriptvars()
    {
        self::$scriptsprinted++;
        if (self::$scriptsprinted == 1)
        {
            $blogwidth = self::get_blogwidth();
            $epprokey = self::$alloptions[self::$opt_pro];
            $myytdefaults = http_build_query(self::$alloptions);
            ?>
            <script type="text/javascript">
                var wpajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
                if (window.location.toString().indexOf('https://') === 0)
                {
                    wpajaxurl = wpajaxurl.replace("http://", "https://");
                }

                var epblogwidth = <?php echo $blogwidth; ?>;
                var epprokey = '<?php echo $epprokey; ?>';
                var epbasesite = '<?php echo self::$epbase; ?>';
                var epversion = '<?php echo self::$version; ?>';
                var myytdefaults = '<?php echo $myytdefaults; ?>';
                var eppluginadminurl = '<?php echo admin_url('admin.php?page=youtube-my-preferences'); ?>';
                // Create IE + others compatible event handler
                var epeventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
                var epeventer = window[epeventMethod];
                var epmessageEvent = epeventMethod === "attachEvent" ? "onmessage" : "message";
                // Listen to message from child window
                epeventer(epmessageEvent, function (e)
                {
                    var embedcode = "";
                    try
                    {
                        if (e.data.indexOf("youtubeembedplus") === 0)
                        {
                            embedcode = e.data.split("|")[1];
                            if (embedcode.indexOf("[") !== 0)
                            {
                                embedcode = "<p>" + embedcode + "</p>";
                            }

                            if (window.tinyMCE !== null && window.tinyMCE.activeEditor !== null && !window.tinyMCE.activeEditor.isHidden())
                            {
                                if (typeof window.tinyMCE.execInstanceCommand !== 'undefined')
                                {
                                    window.tinyMCE.execInstanceCommand(
                                            window.tinyMCE.activeEditor.id,
                                            'mceInsertContent',
                                            false,
                                            embedcode);
                                }
                                else
                                {
                                    send_to_editor(embedcode);
                                }
                            }
                            else
                            {
                                embedcode = embedcode.replace('<p>', '\n').replace('</p>', '\n');
                                if (typeof QTags.insertContent === 'function')
                                {
                                    QTags.insertContent(embedcode);
                                }
                                else
                                {
                                    send_to_editor(embedcode);
                                }
                            }
                            tb_remove();
                        }
                    }
                    catch (err)
                    {

                    }


                }, false);</script>
            <?php
        }
    }

    public static function ytprefs_show_options()
    {

        if (!current_user_can('manage_options'))
        {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        if (self::$double_plugin)
        {
            self::double_plugin_warning();
        }

        $ytprefs_submitted = 'ytprefs_submitted';

        // Read in existing option values from database

        $all = get_option(self::$opt_alloptions);

        // See if the user has posted us some information
        // If they did, this hidden field will be set to 'Y'
        if (isset($_POST[$ytprefs_submitted]) && $_POST[$ytprefs_submitted] == 'Y')
        {
            // Read their posted values

            $new_options = array();
            $new_options[self::$opt_center] = self::postchecked(self::$opt_center) ? 1 : 0;
            $new_options[self::$opt_glance] = self::postchecked(self::$opt_glance) ? 1 : 0;
            $new_options[self::$opt_autoplay] = self::postchecked(self::$opt_autoplay) ? 1 : 0;
            $new_options[self::$opt_debugmode] = self::postchecked(self::$opt_debugmode) ? 1 : 0;
            $new_options[self::$opt_admin_off_scripts] = self::postchecked(self::$opt_admin_off_scripts) ? 1 : 0;
            $new_options[self::$opt_old_script_method] = self::postchecked(self::$opt_old_script_method) ? 1 : 0;
            $new_options[self::$opt_cc_load_policy] = self::postchecked(self::$opt_cc_load_policy) ? 1 : 0;
            $new_options[self::$opt_iv_load_policy] = self::postchecked(self::$opt_iv_load_policy) ? 1 : 3;
            $new_options[self::$opt_loop] = self::postchecked(self::$opt_loop) ? 1 : 0;
            $new_options[self::$opt_modestbranding] = self::postchecked(self::$opt_modestbranding) ? 1 : 0;
            $new_options[self::$opt_rel] = self::postchecked(self::$opt_rel) ? 1 : 0;
            $new_options[self::$opt_showinfo] = self::postchecked(self::$opt_showinfo) ? 1 : 0;
            $new_options[self::$opt_playsinline] = self::postchecked(self::$opt_playsinline) ? 1 : 0;
            $new_options[self::$opt_origin] = self::postchecked(self::$opt_origin) ? 1 : 0;
            $new_options[self::$opt_controls] = self::postchecked(self::$opt_controls) ? 2 : 0;
            $new_options[self::$opt_autohide] = self::postchecked(self::$opt_autohide) ? 1 : 2;
            $new_options[self::$opt_theme] = self::postchecked(self::$opt_theme) ? 'dark' : 'light';
            $new_options[self::$opt_color] = self::postchecked(self::$opt_color) ? 'red' : 'white';
            $new_options[self::$opt_nocookie] = self::postchecked(self::$opt_nocookie) ? 1 : 0;
            $new_options[self::$opt_playlistorder] = self::postchecked(self::$opt_playlistorder) ? 1 : 0;
            $new_options[self::$opt_acctitle] = self::postchecked(self::$opt_acctitle) ? 1 : 0;
            $new_options[self::$opt_migrate] = self::postchecked(self::$opt_migrate) ? 1 : 0;
            $new_options[self::$opt_migrate_youtube] = self::postchecked(self::$opt_migrate_youtube) ? 1 : 0;
            $new_options[self::$opt_migrate_embedplusvideo] = self::postchecked(self::$opt_migrate_embedplusvideo) ? 1 : 0;
            $new_options[self::$opt_oldspacing] = self::postchecked(self::$opt_oldspacing) ? 1 : 0;
            $new_options[self::$opt_responsive] = self::postchecked(self::$opt_responsive) ? 1 : 0;
            $new_options[self::$opt_widgetfit] = self::postchecked(self::$opt_widgetfit) ? 1 : 0;
            $new_options[self::$opt_evselector_light] = self::postchecked(self::$opt_evselector_light) ? 1 : 0;
            $new_options[self::$opt_stop_mobile_buffer] = self::postchecked(self::$opt_stop_mobile_buffer) ? 1 : 0;
            $new_options[self::$opt_defaultdims] = self::postchecked(self::$opt_defaultdims) ? 1 : 0;
            $new_options[self::$opt_defaultvol] = self::postchecked(self::$opt_defaultvol) ? 1 : 0;
            $new_options[self::$opt_dohl] = self::postchecked(self::$opt_dohl) ? 1 : 0;
            $new_options[self::$opt_gallery_showtitle] = self::postchecked(self::$opt_gallery_showtitle) ? 1 : 0;
            $new_options[self::$opt_gallery_showpaging] = self::postchecked(self::$opt_gallery_showpaging) ? 1 : 0;
            $new_options[self::$opt_gallery_autonext] = self::postchecked(self::$opt_gallery_autonext) ? 1 : 0;
            $new_options[self::$opt_gallery_thumbplay] = self::postchecked(self::$opt_gallery_thumbplay) ? 1 : 0;
            $new_options[self::$opt_gallery_channelsub] = self::postchecked(self::$opt_gallery_channelsub) ? 1 : 0;
            $new_options[self::$opt_gallery_customarrows] = self::postchecked(self::$opt_gallery_customarrows) ? 1 : 0;
            $new_options[self::$opt_gallery_collapse_grid] = self::postchecked(self::$opt_gallery_collapse_grid) ? 1 : 0;

            $_defaultwidth = '';
            try
            {
                $_defaultwidth = is_numeric(trim($_POST[self::$opt_defaultwidth])) ? intval(trim($_POST[self::$opt_defaultwidth])) : $_defaultwidth;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_defaultwidth] = $_defaultwidth;

            $_defaultheight = '';
            try
            {
                $_defaultheight = is_numeric(trim($_POST[self::$opt_defaultheight])) ? intval(trim($_POST[self::$opt_defaultheight])) : $_defaultheight;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_defaultheight] = $_defaultheight;

            $_responsive_all = 1;
            try
            {
                $_responsive_all = is_numeric(trim($_POST[self::$opt_responsive_all])) ? intval(trim($_POST[self::$opt_responsive_all])) : $_responsive_all;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_responsive_all] = $_responsive_all;

            $_vol = '';
            try
            {
                $_vol = is_numeric(trim($_POST[self::$opt_vol])) ? intval(trim($_POST[self::$opt_vol])) : $_vol;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_vol] = $_vol;

            $_gallery_pagesize = 15;
            try
            {
                $_gallery_pagesize = is_numeric(trim($_POST[self::$opt_gallery_pagesize])) ? intval(trim($_POST[self::$opt_gallery_pagesize])) : $_gallery_pagesize;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_gallery_pagesize] = $_gallery_pagesize;


            $_gallery_columns = 3;
            try
            {
                $_gallery_columns = is_numeric(trim($_POST[self::$opt_gallery_columns])) ? intval(trim($_POST[self::$opt_gallery_columns])) : $_gallery_columns;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_gallery_columns] = $_gallery_columns;


            $_gallery_collapse_grid_breaks = self::$dft_bpts;
            try
            {
                $_gallery_collapse_grid_breaks = is_array($_POST[self::$opt_gallery_collapse_grid_breaks]) ? $_POST[self::$opt_gallery_collapse_grid_breaks] : $_gallery_collapse_grid_breaks;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_gallery_collapse_grid_breaks] = $_gallery_collapse_grid_breaks;



            $_gallery_scrolloffset = 20;
            try
            {
                $_gallery_scrolloffset = is_numeric(trim($_POST[self::$opt_gallery_scrolloffset])) ? intval(trim($_POST[self::$opt_gallery_scrolloffset])) : $_gallery_scrolloffset;
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_gallery_scrolloffset] = $_gallery_scrolloffset;

            $_gallery_channelsublink = '';
            try
            {
                $_gallery_channelsublink = trim(strip_tags($_POST[self::$opt_gallery_channelsublink]));
                $pieces = explode('?', $_gallery_channelsublink);
                $_gallery_channelsublink = trim($pieces[0]);
            }
            catch (Exception $ex)
            {
                $_gallery_channelsublink = '';
            }
            $new_options[self::$opt_gallery_channelsublink] = $_gallery_channelsublink;


            $_gallery_channelsubtext = '';
            try
            {
                $_gallery_channelsubtext = stripslashes(trim($_POST[self::$opt_gallery_channelsubtext]));
            }
            catch (Exception $ex)
            {
                $_gallery_channelsubtext = '';
            }
            $new_options[self::$opt_gallery_channelsubtext] = $_gallery_channelsubtext;


            $_gallery_custom_prev = 'Prev';
            try
            {
                $_gallery_custom_prev = trim(strip_tags($_POST[self::$opt_gallery_customprev]));
            }
            catch (Exception $ex)
            {
                $_gallery_custom_prev = 'Prev';
            }
            $new_options[self::$opt_gallery_customprev] = $_gallery_custom_prev;


            $_gallery_custom_next = 'Next';
            try
            {
                $_gallery_custom_next = trim(strip_tags($_POST[self::$opt_gallery_customnext]));
            }
            catch (Exception $ex)
            {
                $_gallery_custom_next = 'Next';
            }
            $new_options[self::$opt_gallery_customnext] = $_gallery_custom_next;

            $_not_live_content = '';
            try
            {
                $_not_live_content = wp_kses_post($_POST[self::$opt_not_live_content]);
            }
            catch (Exception $ex)
            {
                $_not_live_content = '';
            }
            $new_options[self::$opt_not_live_content] = $_not_live_content;


            $_apikey = $all[self::$opt_apikey];
            try
            {
                $_curr_apikey = $all[self::$opt_apikey];
                $_schema_apikey = '';
                if (isset($_POST[self::$opt_apikey]))
                {
                    $_schema_apikey = trim(str_replace(array(' ', "'", '"'), array('', '', ''), strip_tags($_POST[self::$opt_apikey])));
                }

                $_gallery_apikey = trim(str_replace(array(' ', "'", '"'), array('', '', ''), strip_tags($_POST[self::$opt_gallery_apikey])));

                if (!empty($_schema_apikey) && $_schema_apikey != $_curr_apikey)
                {
                    $_apikey = $_schema_apikey;
                }
                if (!empty($_gallery_apikey) && $_gallery_apikey != $_curr_apikey)
                {
                    $_apikey = $_gallery_apikey;
                }
            }
            catch (Exception $ex)
            {
                
            }
            $new_options[self::$opt_apikey] = $_apikey;

            $all = $new_options + $all;

            update_option(self::$opt_alloptions, $all);
            ?>
            <div class="updated"><p><strong><?php _e('Changes saved.'); ?></strong></p></div>
            <?php
        }


        // Now display the settings editing screen

        echo '<div class="wrap" style="max-width: 1000px;">';

        // header

        echo "<h2>" . '<img alt="YouTube Plugin Icon" src="' . plugins_url('images/youtubeicon16.png', __FILE__) . '" /> ' . __('YouTube Settings') . "</h2>";

        // settings form
        ?>

        <style type="text/css">
            .wrap {font-family: Arial; color: #000000;}
            #ytform p { line-height: 20px; margin-bottom: 11px; }
            #ytform ul li {margin-left: 30px; list-style: disc outside none;}
            .ytindent {padding: 0px 0px 0px 20px; font-size: 12px;}
            .ytindent ul, .ytindent p {font-size: 12px;}
            .shadow {-webkit-box-shadow: 0px 0px 20px 0px #000000; box-shadow: 0px 0px 20px 0px #000000;}
            .gopro {margin: 0px;}
            .gopro img {vertical-align: middle;
                        width: 19px;
                        height: 19px;
                        padding-bottom: 4px;}
            .gopro li {margin-bottom: 0px;}
            .orange {color: #f85d00;}
            .bold {font-weight: bold;}
            .grey{color: #888888;}
            #goprobox {border-radius: 15px; padding: 10px 15px 15px 15px; margin-top: 15px; border: 3px solid #CCE5EC; position: relative;}
            #nonprosupport {border-radius: 15px; padding: 10px 15px 20px 15px;  border: 3px solid #ff6655;}
            .pronon {font-weight: bold; color: #f85d00;}
            ul.reglist li {margin: 0px 0px 0px 30px; list-style: disc outside none;}
            .procol {width: 475px; float: left;}
            .ytindent .procol ul {font-size: 11px;}
            .smallnote, .ytindent .smallnote {font-style: italic; font-size: 10px;}
            .italic {font-style: italic;}
            .ytindent h3 {font-size: 15px; line-height: 22px; margin: 5px 0px 10px 0px;}
            #wizleftlink {float: left; display: block; width: 240px; font-style: italic; text-align: center; text-decoration: none;}
            .button-primary {font-weight: bold; white-space: nowrap;}
            p.submit {margin: 10px 0 0 0; padding: 10px 0 5px 0;}
            .wp-core-ui p.submit .button-primary {font-size: 20px; height: 50px; padding: 0 20px 1px;
                                                  background: #2ea2cc; /* Old browsers */
                                                  background: -moz-linear-gradient(top,  #2ea2cc 0%, #007396 98%); /* FF3.6+ */
                                                  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#2ea2cc), color-stop(98%,#007396)); /* Chrome,Safari4+ */
                                                  background: -webkit-linear-gradient(top,  #2ea2cc 0%,#007396 98%); /* Chrome10+,Safari5.1+ */
                                                  background: -o-linear-gradient(top,  #2ea2cc 0%,#007396 98%); /* Opera 11.10+ */
                                                  background: -ms-linear-gradient(top,  #2ea2cc 0%,#007396 98%); /* IE10+ */
                                                  background: linear-gradient(to bottom,  #2ea2cc 0%,#007396 98%); /* W3C */
                                                  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2ea2cc', endColorstr='#007396',GradientType=0 ); /* IE6-9 */
            }
            p.submit em {display: inline-block; padding-left: 20px; vertical-align: middle; width: 240px; margin-top: -6px;}
            #opt_pro {box-shadow: 0px 0px 5px 0px #1870D5; width: 320px;vertical-align: top;}
            #goprobox h3 {font-size: 13px;}
            .chx {border-left: 5px solid rgba(100, 100, 100,.1); margin-bottom: 20px;}
            .chx p {margin: 0px 0px 5px 0px;}
            .cuz {background-image: linear-gradient(to bottom,#4983FF,#0C5597) !important; color: #ffffff;}
            .brightpro {background-image: linear-gradient(to bottom,#ff5500,#cc2200) !important; color: #ffffff;}
            #boxdefaultdims {font-weight: bold; padding: 0px 10px; <?php echo $all[self::$opt_defaultdims] ? '' : 'display: none;' ?>}
            #boxcustomarrows {font-weight: bold; padding: 0px 10px; <?php echo $all[self::$opt_gallery_customarrows] ? 'display: block;' : 'display: none;' ?>}
            #boxchannelsub {font-weight: bold; padding: 0px 10px; <?php echo $all[self::$opt_gallery_channelsub] ? 'display: block;' : 'display: none;' ?>}
            #box_collapse_grid {font-weight: bold; padding: 0px 10px; <?php echo isset($all[self::$opt_gallery_collapse_grid]) && $all[self::$opt_gallery_collapse_grid] ? 'display: block;' : 'display: none;' ?>}
            .textinput {border-width: 2px !important;}
            h3.sect {border-radius: 10px; background-color: #D9E9F7; padding: 5px 5px 5px 10px; position: relative; font-weight: bold;}
            h3.sect a {text-decoration: none; color: #E20000;}
            h3.sect a.button-primary {color: #ffffff;} 
            h4.sect {border-radius: 10px; background-color: #D9E9F7; padding: 5px 5px 5px 10px; position: relative; font-weight: bold;}

            .ytnav {margin-bottom: 15px;}
            .ytnav a {font-weight: bold; display: inline-block; padding: 5px 10px; margin: 0px 15px 0px 0px; border: 1px solid #cccccc; border-radius: 6px;
                      text-decoration: none; background-color: #ffffff;}
            .ytnav a:last-child {margin-right: 0;}
            .jumper {height: 25px;}
            .ssschema {float: right; width: 350px; height: auto; margin-right: 10px;}
            .ssfb {float: right; height: auto; margin-right: 10px; margin-left: 15px; margin-bottom: 10px;}
            .totop {position: absolute; right: 20px; top: 5px; color: #444444; font-size: 10px;}
            input[type=checkbox] {border: 1px solid #000000;}
            .chktitle {display: inline-block; padding: 1px 5px 1px 5px; border-radius: 3px; background-color: #ffffff; border: 1px solid #dddddd;}
            b, strong {font-weight: bold;}
            input.checkbox[disabled], input[type=radio][disabled] {border: 1px dashed #444444;}
            .pad10 {padding: 10px;}
            #boxdohl {font-weight: bold; padding: 0px 10px;  <?php echo $all[self::$opt_dohl] ? '' : 'display: none;' ?>}
            #boxdefaultvol {font-weight: bold; padding: 0px 10px;  <?php echo $all[self::$opt_defaultvol] ? '' : 'display: none;' ?>}
            .vol-output {display: none; width: 30px; color: #008800;}
            .vol-range {background-color: #dddddd; border-radius: 3px; cursor: pointer;}
            input#vol {vertical-align: middle;}
            .vol-seeslider {display: none;}
            .indent-option {margin-left: 25px;}
            #boxmigratelist { <?php echo $all[self::$opt_migrate] ? '' : 'display: none;' ?>}
            #boxresponsive_all { <?php echo $all[self::$opt_responsive] ? '' : 'display: none;' ?> padding-left: 25px; border-left: 5px solid rgba(100, 100, 100,.1); margin-left: 5px;}
            .apikey-msg {display: inline-block; width: 45%; vertical-align: top;}
            .apikey-video{margin-left: 3%; display: inline-block; width: 50%; position: relative; padding-top: 29%}
            .apikey-video iframe{display: block; width: 100%; height: 100%; position: absolute; top: 0; left: 0;}
            #boxnocookie {display: inline-block; border-radius: 3px; padding: 2px 4px 2px 4px; color: red; background-color: yellow; font-weight: bold; <?php echo $all[self::$opt_nocookie] ? '' : 'display: none;' ?>}
            .strike {text-decoration: line-through;}
            .upgchecks { padding: 20px; border-radius: 15px; border: 1px dotted #777777; background-color: #fcfcfc; }
            .clearboth {clear: both;}
            div.hr {clear: both; border-bottom: 1px dotted #A8BDD8; margin: 20px 0 20px 0;}
            .wp-pointer-buttons a.close {margin-top: 0 !important;}
            .pad20{padding: 20px 0 20px 0;}
            .ssgallery {float: right; width: 130px; height: auto; margin-left: 15px; border: 3px solid #ffffff;}
            .sssubscribe{display: block; width: 400px; height: auto;}
            .ssaltgallery {float: right; height: auto; margin-right: 10px; margin-left: 15px; margin-bottom: 10px; width: 350px;}
            .sspopupplayer {float: right; height: auto; margin-right: 10px; margin-left: 15px; margin-bottom: 10px; width: 350px;}
            .sswizardbutton {    max-width: 70%; height: auto;}
            .save-changes-follow {position: fixed; z-index: 10000; bottom: 0; right: 0; background-color: #ffffff; padding: 0 20px; border-top-left-radius: 20px; border: 2px solid #aaaaaa; border-right-width: 0; border-bottom-width: 0;
                                  -webkit-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
                                  -moz-box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75);
                                  box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); }

        </style>

        <div class="ytindent">
            <br>
            <div id="jumphowto"></div>
            <div class="ytnav">
                <a href="#jumpapikey">API Key</a>
                <a href="#jumphowto">How To</a>
                <a href="#jumpwiz">Visual Wizard</a>
                <a href="#jumpdefaults">Defaults</a>
                <a href="#jumpcompat">Compatibility</a>
                <a href="#jumpgallery">Galleries</a>
                <a href="#jumpoverride">Override Defaults</a>
                <a target="_blank" href="<?php echo self::$epbase . "/dashboard/pro-easy-video-analytics.aspx?ref=protab" ?>" style="border-color: #888888;">Upgrade?</a>
                <a href="#jumpsupport">Support</a>
            </div>

            <form name="form1" method="post" action="" id="ytform">
                <input type="hidden" name="<?php echo $ytprefs_submitted; ?>" value="Y">

                <div class="jumper" id="jumpapikey"></div>
                <h3 class="sect">
                    YouTube API Key
                </h3>
                <p>
                    Some features (such as galleries, and some wizard features) now require you to create a free YouTube API key from Google. 
                </p>
                <p>
                    <b class="chktitle">YouTube API Key:</b> 
                    <input type="text" name="<?php echo self::$opt_gallery_apikey; ?>" id="<?php echo self::$opt_gallery_apikey; ?>" value="<?php echo trim($all[self::$opt_apikey]); ?>" class="textinput" style="width: 250px;">
                    <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">Click this link &raquo;</a> and follow the video to get your API key. Don't worry, it's an easy process.
                </p>

                <h3 class="sect">
                    How to Insert a YouTube Video or Playlist &nbsp; <a class="smallnote" href="#jumpgallery">(For gallery directions, go here &raquo;)</a>
                </h3>
                <p>
                    <b>For videos:</b> <i>Method 1 - </i> Do you already have a URL to the video you want to embed in a post, page, or even a widget? All you have to do is paste it on its own line, as shown below (including the https:// part). Easy, eh?<br>
                    <i>Method 2 - </i> If you want to do some formatting (e.g. add HTML to center a video) or have two or more videos next to each other on the same line, wrap each link with the <code>[embedyt]...[/embedyt]</code> shortcode. <b>Tip for embedding videos on the same line:</b> As shown in the example image below, decrease the size of each video so that they fit together on the same line (See the "How To Override Defaults" section for height and width instructions).
                </p>
                <p>
                    <b>For galleries:</b> <a href="#jumpgallery">Click here</a> to scroll down to gallery settings and directions.
                </p>
                <p>
                    <b>For self-contained playlists:</b> Go to the page for the playlist that lists all of its videos (<a target="_blank" href="http://www.youtube.com/playlist?list=PL70DEC2B0568B5469">Example &raquo;</a>). Click on the video that you want the playlist to start with. Copy and paste that browser URL into your blog on its own line. If you want the first video to always be the latest video in your playlist, check the option "Playlist Ordering" in the settings down below (you will also see this option available if you use the Pro Wizard). If you want to have two or more playlists next to each other on the same line, wrap each link with the <code>[embedyt]...[/embedyt]</code> shortcode.
                </p>                
                <p>
                    <b>For self-contained channel playlists:</b> At your editor, click on the <img style="vertical-align: text-bottom;" src="<?php echo plugins_url('images/wizbuttonbig.png', __FILE__) ?>"> wizard button and choose the option <i>Search for a video or channel to insert in my editor.</i> Then, click on the <i>channel playlist</i> option there (instead of <i>single video</i>). Search for the channel username and follow the rest of the directions there.
                </p>
                <p>
                    <b>Examples:</b><br><br>
                    <img style="width: 900px; height: auto;" class="shadow" src="<?php echo plugins_url('images/sshowto.png', __FILE__) ?>" />
                </p>
                <p>
                    Always follow these rules for any URL:
                </p>
                <ul class="reglist">
                    <li>Make sure the URL is really on its own line by itself. Or, if you need multiple videos on the same line, make sure each URL is wrapped properly with the shortcode (Example:  <code>[embedyt]http://www.youtube.com/watch?v=ABCDEFGHIJK&width=400&height=250[/embedyt]</code>)</li>
                    <li>Make sure the URL is <strong>not</strong> an active hyperlink (i.e., it should just be plain text). Otherwise, highlight the URL and click the "unlink" button in your editor: <img src="<?php echo plugins_url('images/unlink.png', __FILE__) ?>"/></li>
                    <li>Make sure you did <strong>not</strong> format or align the URL in any way. If your URL still appears in your actual post instead of a video, highlight it and click the "remove formatting" button (formatting can be invisible sometimes): <img src="<?php echo plugins_url('images/erase.png', __FILE__) ?>"/></li>
                    <li>If you really want to align the video, try wrapping the link with the shortcode first. For example: <code>[embedyt]http://www.youtube.com/watch?v=ABCDEFGHIJK[/embedyt]</code> Using the shortcode also allows you to have two or more videos next to each other on the same line.  Just put the shortcoded links together on the same line. For example:<br>
                        <code>[embedyt]http://www.youtube.com/watch?v=ABCDEF[/embedyt] [embedyt]http://www.youtube.com/watch?v=GHIJK[/embedyt]</code>
                </ul>       

                <div class="jumper" id="jumpwiz"></div>
                <h3 class="sect">Visual YouTube Wizard <a href="#top" class="totop">&#9650; top</a></h3>

                <p>
                    Let's say you don't know the exact URL of the video you wish to embed.  Well, we've made the ability to directly search YouTube and insert videos right from your editor tab as a free feature to all users.  
                    Simply click the <img style="vertical-align: text-bottom;" src="<?php echo plugins_url('images/wizbuttonbig.png', __FILE__) ?>"> wizard button found above 
                    your editor to start the wizard (see image above to locate this button).  There, you'll be given the option to enter your search terms.  
                    Click the "Search" button to view the results.  Each result will have an <span class="button-primary cuz">&#9660; Insert Into Editor</span> button that 
                    you can click to directly embed the desired video link to your post without having to copy and paste.             
                </p>
                <p>
                    <b class="orange">Even more options are available to PRO users!</b> If you download our PRO version, you can simply click the <a href="<?php echo self::$epbase . '/dashboard/pro-easy-video-analytics.aspx?ref=protab' ?>" target="_blank" class="button-primary cuz">&#9658; Customize</a> button within the wizard to further personalize your embeds without having to enter special codes yourself.
                    <br>
                    <br>

                    <a href="<?php echo self::$epbase ?>/dashboard/pro-easy-video-analytics.aspx" target="_blank" style="text-decoration: none;"><img style="width: 500px; margin: 0 auto; display: block;" src="<?php echo plugins_url('images/ssprowizard.png', __FILE__) ?>" ></a>

                </p>
                <div class="jumper" id="jumpdefaults"></div>
                <h3 class="sect">
                    <?php _e("Default YouTube Options") ?> <a href="#top" class="totop">&#9650; top</a>
                </h3>
                <p>
                    <?php _e("One of the benefits of using this plugin is that you can set site-wide default options for all your videos (click \"Save Changes\" when finished). However, you can also override them (and more) on a per-video basis. Directions on how to do that are in the next section.") ?>
                </p>

                <div class="ytindent chx">
                    <p>
                        <input name="<?php echo self::$opt_glance; ?>" id="<?php echo self::$opt_glance; ?>" <?php checked($all[self::$opt_glance], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_glance; ?>"><?php _e('<b class="chktitle">At a glance:</b> Show "At a Glance" Embed Links on the dashboard homepage.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_center; ?>" id="<?php echo self::$opt_center; ?>" <?php checked($all[self::$opt_center], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_center; ?>"><?php _e('<b class="chktitle">Centering:</b> Automatically center all your videos (not necessary if all your videos span the whole width of your blog).') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_autoplay; ?>" id="<?php echo self::$opt_autoplay; ?>" <?php checked($all[self::$opt_autoplay], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_autoplay; ?>"><?php _e('<b class="chktitle">Autoplay:</b>  Automatically start playing your videos.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_iv_load_policy; ?>" id="<?php echo self::$opt_iv_load_policy; ?>" <?php checked($all[self::$opt_iv_load_policy], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_iv_load_policy; ?>"><?php _e('<b class="chktitle">Annotations:</b> Show annotations by default.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_loop; ?>" id="<?php echo self::$opt_loop; ?>" <?php checked($all[self::$opt_loop], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_loop; ?>"><?php _e('<b class="chktitle">Looping:</b> Loop all your videos.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_modestbranding; ?>" id="<?php echo self::$opt_modestbranding; ?>" <?php checked($all[self::$opt_modestbranding], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_modestbranding; ?>"><?php _e('<b class="chktitle">Modest Branding:</b> No YouTube logo will be shown on the control bar.  Instead, the logo will only show as a watermark when the video is paused/stopped.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_rel; ?>" id="<?php echo self::$opt_rel; ?>" <?php checked($all[self::$opt_rel], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_rel; ?>"><?php _e('<b class="chktitle">Related Videos:</b> Show related videos at the end.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_showinfo; ?>" id="<?php echo self::$opt_showinfo; ?>" <?php checked($all[self::$opt_showinfo], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_showinfo; ?>"><?php _e('<b class="chktitle">Show Title:</b> Show the video title and other info.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_acctitle; ?>" id="<?php echo self::$opt_acctitle; ?>" <?php checked($all[self::$opt_acctitle], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_acctitle; ?>"><b class="chktitle">Accessible Title Attributes: </b> Improve accessibility by using title attributes for screen reader support. It should help your site pass functional accessibility evaluations (FAE). </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_theme; ?>" id="<?php echo self::$opt_theme; ?>" <?php checked($all[self::$opt_theme], 'dark'); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_theme; ?>"><?php _e('<b class="chktitle strike">Dark Theme:</b> Use the dark theme (uncheck to use light theme). <b>Note: YouTube has deprecated this option and will always use the dark theme.</b>') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_color; ?>" id="<?php echo self::$opt_color; ?>" <?php checked($all[self::$opt_color], 'red'); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_color; ?>"><?php _e('<b class="chktitle">Red Progress Bar:</b> Use the red progress bar (uncheck to use a white progress bar). Note: Using white will disable the modestbranding option.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_defaultdims; ?>" id="<?php echo self::$opt_defaultdims; ?>" <?php checked($all[self::$opt_defaultdims], 1); ?> type="checkbox" class="checkbox">                        
                        <span id="boxdefaultdims">
                            Width: <input type="text" name="<?php echo self::$opt_defaultwidth; ?>" id="<?php echo self::$opt_defaultwidth; ?>" value="<?php echo trim($all[self::$opt_defaultwidth]); ?>" class="textinput" style="width: 50px;"> &nbsp;
                            Height: <input type="text" name="<?php echo self::$opt_defaultheight; ?>" id="<?php echo self::$opt_defaultheight; ?>" value="<?php echo trim($all[self::$opt_defaultheight]); ?>" class="textinput" style="width: 50px;">
                        </span>

                        <label for="<?php echo self::$opt_defaultdims; ?>"><?php _e('<b class="chktitle">Default Dimensions:</b> Make your videos have a default size. (NOTE: Checking the responsive option will override this size setting) ') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_responsive; ?>" id="<?php echo self::$opt_responsive; ?>" <?php checked($all[self::$opt_responsive], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_responsive; ?>"><?php _e('<b class="chktitle">Responsive Video Sizing:</b> Make your videos responsive so that they dynamically fit in all screen sizes (smart phone, PC and tablet). NOTE: While this is checked, any custom hardcoded widths and heights you may have set will dynamically change too. <b>Do not check this if your theme already handles responsive video sizing.</b>') ?></label>
                    <div id="boxresponsive_all">
                        <input type="radio" name="<?php echo self::$opt_responsive_all; ?>" id="<?php echo self::$opt_responsive_all; ?>1" value="1" <?php checked($all[self::$opt_responsive_all], 1); ?> >
                        <label for="<?php echo self::$opt_responsive_all; ?>1">Responsive for all YouTube videos</label> &nbsp;&nbsp;
                        <input type="radio" name="<?php echo self::$opt_responsive_all; ?>" id="<?php echo self::$opt_responsive_all; ?>0" value="0" <?php checked($all[self::$opt_responsive_all], 0); ?> >
                        <label for="<?php echo self::$opt_responsive_all; ?>0">Responsive for only videos embedded via this plugin</label>
                    </div>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_widgetfit; ?>" id="<?php echo self::$opt_widgetfit; ?>" <?php checked($all[self::$opt_widgetfit], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_widgetfit; ?>"><?php _e('<b class="chktitle">Autofit Widget Videos:</b> Make each video that you embed in a widget area automatically fit the width of its container.</b>') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_playsinline; ?>" id="<?php echo self::$opt_playsinline; ?>" <?php checked($all[self::$opt_playsinline], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_playsinline; ?>">
                            <b class="chktitle">iOS Playback:</b> Check this to allow your embeds to play inline within your page when viewed on iOS (iPhone and iPad) browsers. Uncheck it to have iOS launch your embeds in fullscreen instead.
                            <em>Disclaimer: YouTube/Google has issues with this iOS related parameter, but we are providing it here in the event that they support it consistently.</em>
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_origin; ?>" id="<?php echo self::$opt_origin; ?>" <?php checked($all[self::$opt_origin], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_origin; ?>"><b class="chktitle">Extra Player Security: </b>
                            Add site origin information with each embed code as an extra security measure. In YouTube's/Google's own words, checking this option "protects against malicious third-party JavaScript being injected into your page and hijacking control of your YouTube player." We especially recommend checking it as it adds higher security than the built-in YouTube embedding method that comes with the current version of WordPress (i.e. oembed).
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_nocookie; ?>" id="<?php echo self::$opt_nocookie; ?>" <?php checked($all[self::$opt_nocookie], 1); ?> type="checkbox" class="checkbox">
                        <span id="boxnocookie">
                            Uncheck this option if you are planning to embed galleries and playlists on your site. Furthermore, videos on mobile devices may have problems if you leave this checked.
                        </span>
                        <label for="<?php echo self::$opt_nocookie; ?>">
                            <b class="chktitle">No Cookies:</b> Prevent YouTube from leaving tracking cookies on your visitors browsers unless they actual play the videos. This is coded to apply this behavior on links in your past post as well. <b>NOTE: Research shows that YouTube's support of Do Not Track can be error-prone. </b>
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_controls; ?>" id="<?php echo self::$opt_controls; ?>" <?php checked($all[self::$opt_controls], 2); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_controls; ?>"><b class="chktitle">Show Controls:</b> Show the player's control bar. Unchecking this option creates a cleaner look but limits what your viewers can control (play position, volume, etc.).</label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_autohide; ?>" id="<?php echo self::$opt_autohide; ?>" <?php checked($all[self::$opt_autohide], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_autohide; ?>"><b class="chktitle strike">Autohide Controls:</b> Slide away the control bar after the video starts playing. It will automatically slide back in again if you mouse over the video. If you unchecked "Show Controls" above, then what you select for Autohide does not matter since there are no controls to even hide.
                            <strong>Note: YouTube has deprecated this option, and will always autohide the controls.</strong>
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_defaultvol; ?>" id="<?php echo self::$opt_defaultvol; ?>" <?php checked($all[self::$opt_defaultvol], 1); ?> type="checkbox" class="checkbox">                        
                        <label for="<?php echo self::$opt_defaultvol; ?>">
                            <b class="chktitle">Volume Initialization: </b>
                            Set an initial volume level for all of your embedded videos.  Check this and you'll see a <span class="vol-seeslider">slider</span> <span class="vol-seetextbox">textbox</span> for setting the start volume to a value between 0 (mute) and 100 (max) percent.  Leaving it unchecked means you want the visitor's default behavior.  This feature is experimental and is less predictable on a page with more than one embed. Read more about why you might want to <a href="<?php echo self::$epbase ?>/mute-volume-youtube-wordpress.aspx" target="_blank">initialize YouTube embed volume here &raquo;</a>
                        </label>
                        <span id="boxdefaultvol">
                            Volume: <span class="vol-output"></span> <input min="0" max="100" step="1" type="text" name="<?php echo self::$opt_vol; ?>" id="<?php echo self::$opt_vol; ?>" value="<?php echo trim($all[self::$opt_vol]); ?>" >
                        </span>
                    </p>

                    <p>
                        <input name="<?php echo self::$opt_cc_load_policy; ?>" id="<?php echo self::$opt_cc_load_policy; ?>" <?php checked($all[self::$opt_cc_load_policy], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_cc_load_policy; ?>"><?php _e('<b class="chktitle">Closed Captions:</b> Turn on closed captions by default.') ?></label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_dohl; ?>" id="<?php echo self::$opt_dohl; ?>" <?php checked($all[self::$opt_dohl], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_dohl; ?>"><b class="chktitle">Player Localization / Internationalization: </b>
                            Automatically detect your site's default language (using get_locale) and set your YouTube embeds interface language so that it matches. Specifically, this will set the player's tooltips and caption track if your language is natively supported by YouTube. We suggest checking this if English is not your site's default language.  <a href="<?php echo self::$epbase ?>/youtube-iso-639-1-language-codes.aspx" target="_blank">See here for more details &raquo;</a></label>
                    </p>                    
                    <p>
                        <input name="<?php echo self::$opt_playlistorder; ?>" id="<?php echo self::$opt_playlistorder; ?>" <?php checked($all[self::$opt_playlistorder], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_playlistorder; ?>">
                            <b class="chktitle">Playlist Ordering:</b> 
                            Check this option if you want your playlists to begin with the latest added video by default. (Unchecking this will force playlists to always start with your selected specific video, even if you add videos to the playlist later).
                            Note that this is not for setting the thumbnail list order of galleries,  just the standard playlist player that YouTube provides.
                        </label>
                    </p>
                    <p>
                        <label for="<?php echo self::$opt_not_live_content; ?>">
                            <b class="chktitle">Default "Not Live" Content:</b> <sup class="orange">NEW</sup>
                            Below, enter what you would like to appear while your channel is not currently streaming live.
                        </label>
                        <?php
                        wp_editor(
                                wp_kses_post($all[self::$opt_not_live_content]), self::$opt_not_live_content, array('textarea_rows' => 5)
                        );
                        ?> 
                    </p>


                </div>

                <div class="jumper" id="jumpcompat"></div>
                <h3 class="sect">Compatibility Settings <a href="#top" class="totop">&#9650; top</a></h3>
                <p>
                    With tens of thousands of active users, our plugin may not work with every plugin out there. Below are some settings you may wish to try out. 
                </p>
                <div class="ytindent chx">
                    <p>
                        <input name="<?php echo self::$opt_old_script_method; ?>" id="<?php echo self::$opt_old_script_method; ?>" <?php checked($all[self::$opt_old_script_method], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_old_script_method; ?>">
                            <b class="chktitle">Use Legacy Scripts: </b>
                            This is a legacy option for users with theme issues that require backwards compatibility (v.10.5 or earlier). It may also help with caching plugin or CDN plugin issues.
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_admin_off_scripts; ?>" id="<?php echo self::$opt_admin_off_scripts; ?>" <?php checked($all[self::$opt_admin_off_scripts], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_admin_off_scripts; ?>">
                            <b class="chktitle">Turn Off Scripts While Editing: </b>
                            Front-end editors and visual pagebuilders often run Javascript while you're in edit mode. Check this to turn off this plugin's Javascript during edit mode, if you see conflicts.
                            Don't worry, all other visitors to your site will still view your site normally.
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_migrate; ?>" id="<?php echo self::$opt_migrate; ?>" <?php checked($all[self::$opt_migrate], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_migrate; ?>">
                            <b class="chktitle">Migrate Shortcodes: </b> Inherit shortcodes from other plugins. This is useful for when a plugin becomes deprecated, or you simply prefer this plugin's features.
                        </label>
                    <div id="boxmigratelist">
                        <ul>
                            <li><input name="<?php echo self::$opt_migrate_embedplusvideo; ?>" id="<?php echo self::$opt_migrate_embedplusvideo; ?>" <?php checked($all[self::$opt_migrate_embedplusvideo], 1); ?> type="checkbox" class="checkbox"><label for="<?php echo self::$opt_migrate_embedplusvideo; ?>"><b>"YouTube Advanced Embed":</b>   <code>[embedplusvideo]</code> shortcode</label></li>
                            <li><input name="<?php echo self::$opt_migrate_youtube; ?>" id="<?php echo self::$opt_migrate_youtube; ?>" <?php checked($all[self::$opt_migrate_youtube], 1); ?> type="checkbox" class="checkbox"><label for="<?php echo self::$opt_migrate_youtube; ?>"><b>"YouTube Embed":</b> <code>[youtube]</code> and <code>[youtube_video]</code> shortcodes</label></li>
                            <li class="smallnote orange" style="list-style: none;">This feature is beta. More shortcodes coming.</li>
                        </ul>

                    </div>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_oldspacing; ?>" id="<?php echo self::$opt_oldspacing; ?>" <?php checked($all[self::$opt_oldspacing], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_oldspacing; ?>">
                            <b class="chktitle">Legacy Spacing:</b> Continue the spacing style from version 4.0 and older. Those versions required you to manually add spacing above and below your video. Unchecking this will automatically add the spacing.
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_evselector_light; ?>" id="<?php echo self::$opt_evselector_light; ?>" <?php checked($all[self::$opt_evselector_light], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_evselector_light; ?>">
                            <b class="chktitle">Theme Video Problems: </b> 
                            Check this option if you're having issues with autoplayed videos or background videos etc. that have been generated by your theme.
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_stop_mobile_buffer; ?>" id="<?php echo self::$opt_stop_mobile_buffer; ?>" <?php checked($all[self::$opt_stop_mobile_buffer], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_stop_mobile_buffer; ?>">
                            <b class="chktitle">Mobile Autoplay Problems: </b> 
                            Autoplay works for desktop, but mobile devices don't allow autoplay due to network carrier data charges. For mobile devices, this option may help the player to properly display the video for the visitor to click on.
                        </label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_debugmode; ?>" id="<?php echo self::$opt_debugmode; ?>" <?php checked($all[self::$opt_debugmode], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_debugmode; ?>">
                            <b class="chktitle">Debug Mode: </b> If you ask for support, we may ask you to turn on debug mode here.
                            It may print out some diagnostic info so that we can help you solve your issue. 
                        </label>
                    </p>

                </div>
                <div class="jumper" id="jumpgallery"></div>
                <h3 class="sect">Gallery Settings and Directions <a href="#top" class="totop">&#9650; top</a></h3>
                <img class="ssgallery" src="<?php echo plugins_url('images/ssgallery.png', __FILE__) ?>">
                <p>
                    <a target="_blank" href="<?php echo self::$epbase ?>/responsive-youtube-playlist-channel-gallery-for-wordpress.aspx">You can now make playlist embeds (and channel-playlist embeds) have a gallery layout &raquo;</a>. <strong>First, you must obtain your YouTube API key</strong>. 
                    Don't worry, it's an easy process. Just <a href="https://www.youtube.com/watch?v=LpKDFT40V0U" target="_blank">click this link &raquo;</a> and follow the video on that page to get your API key. Since Google updates their API Key generation directions frequently, follow the general steps shown in the video.
                    Then paste your API key in the "YouTube API Key" box at the top of this screen, and click the "Save Changes" button.
                </p>

                <p>
                    Below are the settings for galleries:
                </p>
                <div class="ytindent chx">

                    <p>
                        <label for="<?php echo self::$opt_gallery_pagesize; ?>"><b class="chktitle">Gallery Page Size:</b></label>
                        <select name="<?php echo self::$opt_gallery_pagesize; ?>" id="<?php echo self::$opt_gallery_pagesize; ?>" style="width: 60px;">
                            <?php
                            $gps_val = intval(trim($all[self::$opt_gallery_pagesize]));
                            $gps_val = min($gps_val, 50);
                            for ($gps = 1; $gps <= 50; $gps++)
                            {
                                ?><option <?php echo $gps_val == $gps ? 'selected' : '' ?> value="<?php echo $gps ?>"><?php echo $gps ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        Enter how many thumbnails per page should be shown at once (YouTube allows a maximum of 50 per page).
                    </p>
                    <p>
                        <label for="<?php echo self::$opt_gallery_columns; ?>"><b class="chktitle">Number of Columns:</b></label>
                        <input name="<?php echo self::$opt_gallery_columns; ?>" id="<?php echo self::$opt_gallery_columns; ?>" type="number" class="textinput" style="width: 60px;" value="<?php echo trim($all[self::$opt_gallery_columns]); ?>">                        
                        Enter how many thumbnails can fit per row.
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_collapse_grid; ?>" id="<?php echo self::$opt_gallery_collapse_grid; ?>" <?php checked($all[self::$opt_gallery_collapse_grid], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_collapse_grid; ?>">
                            <b class="chktitle">Stack Thumbnails for Mobile:</b> <sup class="orange">NEW</sup> Check this option to responsively stack thumbnails on smaller screens, for the grid layout.
                        </label>
                        <span id="box_collapse_grid">
                            <?php
                            foreach ($all[self::$opt_gallery_collapse_grid_breaks] as $idx => $bpts)
                            {
                                ?>
                                On screens up to
                                <input type="number" name="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][bp][max]'; ?>"
                                       id="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][bp][max]'; ?>" 
                                       value="<?php echo intval(trim($bpts['bp']['max'])); ?>" class="textinput" style="width: 70px;">px wide, stack thumbnails to 1 column.
                                <input type="hidden" name="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][cols]'; ?>"
                                       id="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][cols]'; ?>"
                                       value="<?php echo intval(trim($bpts['cols'])); ?>">
                                <input type="hidden" name="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][bp][min]'; ?>"
                                       id="<?php echo self::$opt_gallery_collapse_grid_breaks . '[' . $idx . '][bp][min]'; ?>"
                                       value="<?php echo intval(trim($bpts['bp']['min'])); ?>">
                                       <?php
                                   }
                                   ?>
                            <span class="smallnote grey pad20"><br>Note: a common mobile screen width is 767 pixels.</span>
                        </span>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_showpaging; ?>" id="<?php echo self::$opt_gallery_showpaging; ?>" <?php checked($all[self::$opt_gallery_showpaging], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_showpaging; ?>"><b class="chktitle">Show Pagination:</b> Show the Next/Previous buttons and page numbering.</label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_customarrows; ?>" id="<?php echo self::$opt_gallery_customarrows; ?>" <?php checked($all[self::$opt_gallery_customarrows], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_customarrows; ?>">
                            <b class="chktitle">Custom Next/Previous Text:</b> If you want your gallery viewers to see something besides "Next" and "Prev" when browsing through thumbnails, enter your replacement text here. This feature can be quite useful for non-English sites.  For example, a French site might replace Prev with Pr&eacute;c&eacute;dent  and Next with Suivant.
                        </label>
                        <span id="boxcustomarrows">
                            Previous Page: <input type="text" name="<?php echo self::$opt_gallery_customprev; ?>" id="<?php echo self::$opt_gallery_customprev; ?>" value="<?php echo esc_attr(trim($all[self::$opt_gallery_customprev])); ?>" class="textinput" style="width: 100px;"> &nbsp;
                            Next Page: <input type="text" name="<?php echo self::$opt_gallery_customnext; ?>" id="<?php echo self::$opt_gallery_customnext; ?>" value="<?php echo esc_attr(trim($all[self::$opt_gallery_customnext])); ?>" class="textinput" style="width: 100px;">
                        </span>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_channelsub; ?>" id="<?php echo self::$opt_gallery_channelsub; ?>" <?php checked($all[self::$opt_gallery_channelsub], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_channelsub; ?>">
                            <b class="chktitle">Show Subscribe Button: </b> Are you the channel owner for all your galleries? Check this box to add a "Subscribe" button to all your galleries as shown below.  This might help you convert your site's visitors to YouTube subscribers of your channel.
                        </label>
                        <span id="boxchannelsub">
                            Channel URL: <input type="text" placeholder="https://www.youtube.com/user/YourChannel" name="<?php echo self::$opt_gallery_channelsublink; ?>" id="<?php echo self::$opt_gallery_channelsublink; ?>" value="<?php echo esc_url(trim($all[self::$opt_gallery_channelsublink])); ?>" class="textinput" style="width: 200px;"> &nbsp;
                            Button text: <input type="text" name="<?php echo self::$opt_gallery_channelsubtext; ?>" id="<?php echo self::$opt_gallery_channelsubtext; ?>" value="<?php echo esc_attr(trim($all[self::$opt_gallery_channelsubtext])); ?>" class="textinput" style="width: 200px;">
                        </span>
                    </p>
                    <p><img class="sssubscribe" src="<?php echo plugins_url('images/sssubscribe.png', __FILE__) ?>"></p>

                    <p>
                        <label for="<?php echo self::$opt_gallery_scrolloffset; ?>"><b class="chktitle">Scroll Offset:</b></label>
                        <input name="<?php echo self::$opt_gallery_scrolloffset; ?>" id="<?php echo self::$opt_gallery_scrolloffset; ?>" type="number" class="textinput" style="width: 60px;" value="<?php echo trim($all[self::$opt_gallery_scrolloffset]); ?>">
                        After you click on a thumbnail, the gallery will automatically smooth scroll up to the actual player. If you need it to scroll a few pixels further, increase this number.
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_showtitle; ?>" id="<?php echo self::$opt_gallery_showtitle; ?>" <?php checked($all[self::$opt_gallery_showtitle], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_showtitle; ?>"><b class="chktitle">Show Thumbnail Title:</b> Show titles with each thumbnail.</label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_autonext; ?>" id="<?php echo self::$opt_gallery_autonext; ?>" <?php checked($all[self::$opt_gallery_autonext], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_autonext; ?>"><b class="chktitle">Automatic Continuous Play:</b>  Automatically play the next video in the gallery as soon as the current video finished.</label>
                    </p>
                    <p>
                        <input name="<?php echo self::$opt_gallery_thumbplay; ?>" id="<?php echo self::$opt_gallery_thumbplay; ?>" <?php checked($all[self::$opt_gallery_thumbplay], 1); ?> type="checkbox" class="checkbox">
                        <label for="<?php echo self::$opt_gallery_thumbplay; ?>"><b class="chktitle">Thumbnail Click Plays Video:</b> Clicking on a gallery thumbnail autoplays the video. Uncheck this and visitors must also click the video's play button after clicking the thumbnail.</label>
                    </p>
                    <div class="pad20">
                        <p>
                            Ready to get started with an actual gallery?  Just click the plugin wizard button and pick your desired gallery embedding choice.
                        </p>
                        <p><img class="sswizardbutton" src="<?php echo plugins_url('images/sswizardbutton.jpg', __FILE__) ?>"></p>
                    </div>
                </div>


                <div class="jumper" id="jumpprosettings"></div>
                <div class="upgchecks">
                    <h3 class="sect">Want the PRO Features?</h3>
                    <p class="orange">Below are descriptions for some of our PRO features for enhanced SEO and performance, once you purchase and install our separate PRO plugin (the PRO plugin works for all your past embed links).</p>
                    <p>
                        <img class="ssaltgallery" src="<?php echo plugins_url('images/ssaltgalleryall.jpg', __FILE__) ?>" />
                        <select disabled>
                            <option value="">Gallery Style</option>
                        </select>
                        <label>
                            <b class="chktitle">Alternate Gallery Styling: </b> <span class="pronon">(PRO Users)</span> 
                            Switch from the grid style of the FREE version to another gallery style. Right now, we provide a vertical (single column) and horizontal (single row) list style as alternatives to the grid, with more designs coming. These current alternatives were inspired by the standard YouTube playlist player's "table of contents," except our gallery's video lists are always visible and shown under the playing video.
                            <a target="_blank" href="<?php echo self::$epbase ?>/responsive-youtube-playlist-channel-gallery-for-wordpress.aspx">Read more here &raquo;</a>
                        </label>
                    </p>

                    <div class="hr"></div>
                    <p>
                        <img class="ssaltgallery" src="<?php echo plugins_url('images/ssverticallayout.png', __FILE__) ?>" />
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Show Gallery Descriptions (for vertical list styling): </b>  <span class="pronon">(PRO Users)</span> 
                            For the vertical list layout, this option will show full video descriptions (taken directly from YouTube.com) with each thumbnail. Note: these descriptions only apply the vertical list layout; other layouts don't have enough room.
                        </label>
                    </p>
                    <div class="hr"></div>
                    <p>
                        <img class="ssaltgallery" src="<?php echo plugins_url('images/ssaltgallerycircles.jpg', __FILE__) ?>" />
                        <select disabled>
                            <option value="">Select Thumbnail Shape</option>
                        </select>
                        <label>
                            <b class="chktitle">Gallery Thumbnail Shape: </b> <span class="pronon">(PRO Users)</span> 
                            Differentiate your gallery by showing different thumbnail shapes.  We currently offer rectangle and circle shapes.
                            <a target="_blank" href="<?php echo self::$epbase ?>/responsive-youtube-playlist-channel-gallery-for-wordpress.aspx">Read more here &raquo;</a>
                        </label>
                    </p>

                    <div class="hr"></div>
                    <p>
                        <img class="sspopupplayer" src="<?php echo plugins_url('images/sspopupplayer.jpg', __FILE__) ?>" />
                        <label>
                            <b class="chktitle">Gallery Video Display Mode: </b> <sup class="orange">NEW</sup> <span class="pronon">(PRO Users)</span>
                            Display your gallery videos simply above the thumbnails (default), or as a popup lightbox.
                        </label>
                        <br>
                        <input type="radio" disabled> Default &nbsp; <input type="radio" disabled> Popup lightbox
                    </p>

                    <div class="hr"></div>
                    <p>
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Faster Page Loads (Caching): </b>  <span class="pronon">(PRO Users)</span> 
                            Use embed caching to speed up your page loads. By default, WordPress needs to request information from YouTube.com's servers for every video you embed, every time a page is loaded. These data requests can add time to your total page load time. Turn on this feature to cache that data (instead of having to request for the same information every time you load a page). This should then make your pages that have videos load faster.  It's been noted that even small speed ups in page load can help increase visitor engagement, retention, and conversions. Caching also makes galleries run faster.
                        </label>
                    <div class="indent-option">
                        <label>
                            <b class="chktitle">Cache Lifetime (hours): </b> 
                            <input disabled value="24" type="number">
                            Tip: If your pages rarely change, you may wish to set this to a much higher value than 24 hours.
                        </label>
                    </div>
                    </p>
                    <div class="hr"></div>

                    <p>
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Video SEO Tags:</b>  <span class="pronon">(PRO Users)</span> Update your YouTube embeds with Google, Bing, and Yahoo friendly schema markup for videos.
                        </label>
                    </p>
                    <div class="hr"></div>
                    <p>
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Special Lazy-Loading Effects:</b>  <span class="pronon">(PRO Users)</span> 
                            Add eye-catching special effects that will make your YouTube embeds bounce, flip, pulse, or slide as they lazy load on the screen.  Check this box to select your desired effect. <a target="_blank" href="<?php echo self::$epbase ?>/add-special-effects-to-youtube-embeds-in-wordpress.aspx">Read more here &raquo;</a>
                        </label>
                    </p>
                    <div class="hr"></div>
                    <p>
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Facebook Open Graph Markup:</b> <span class="pronon">(PRO Users)</span>   Include Facebook Open Graph markup with the videos you embed with this plugin.  We follow the guidelines for videos as described here: <a href="https://developers.facebook.com/docs/sharing/webmasters#media" target="_blank">https://developers.facebook.com/docs/sharing/webmasters#media</a>
                        </label>
                    </p>
                    <div class="hr"></div>
                    <p>
                        <img class="ssfb" src="<?php echo plugins_url('images/youtube_thumbnail_sample.jpg', __FILE__) ?>" />
                        <input disabled type="checkbox" class="checkbox">
                        <label>
                            <b class="chktitle">Featured Thumbnail Images:</b>  <span class="pronon">(PRO Users)</span> 
                            Automatically grab the thumbnail image of the first video embedded in each post or page, and use it as the featured image. 
                            All you have to do is click Update on a post or page and the plugin does the rest! 
                            (Example shown on the right) <a target="_blank" href="<?php echo self::$epbase ?>/add-youtube-video-thumbnails-featured-image-wordpress.aspx">Read more here &raquo;</a>
                        </label>
                    </p>
                    <div class="hr"></div>
                    <p>
                        <a href="<?php echo self::$epbase ?>/dashboard/pro-easy-video-analytics.aspx" target="_blank">Purchase and download the PRO plugin to get the above and several other features &raquo;</a>
                    </p>                    
                    <div class="clearboth"></div>
                </div>

                <hr>

                <div class="jumper" id="jumpoverride"></div>

                <h3 class="sect">
                    <?php _e("How To Override Defaults / Other Options") ?> <a href="#top" class="totop">&#9650; top</a>
                </h3>
                <p>Suppose you have a few videos that need to be different from the above defaults. You can add options to the end of a link as displayed below to override the above defaults. Each option should begin with '&'.
                    <br><span class="smallnote orange">PRO users: You can use the big blue <a href="<?php echo self::$epbase . '/dashboard/pro-easy-video-analytics.aspx?ref=protab' ?>" target="_blank">customize</a> buttons that you will see inside the wizard, instead of memorizing the following.</span>
                    <?php
                    _e('<ul>');
                    _e("<li><strong>width</strong> - Sets the width of your player. If omitted, the default width will be the width of your theme's content.<em> Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&width=500</strong>&height=350</em></li>");
                    _e("<li><strong>height</strong> - Sets the height of your player. <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA&width=500<strong>&height=350</strong></em> </li>");
                    _e("<li><strong>autoplay</strong> - Set this to 1 to autoplay the video (or 0 to play the video once). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&autoplay=1</strong></em> </li>");
                    _e("<li><strong>cc_load_policy</strong> - Set this to 1 to turn on closed captioning (or 0 to leave them off). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&cc_load_policy=1</strong></em> </li>");
                    _e("<li><strong>iv_load_policy</strong> - Set this to 3 to turn off annotations (or 1 to show them). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&iv_load_policy=3</strong></em> </li>");
                    _e("<li><strong>loop</strong> - Set this to 1 to loop the video (or 0 to not loop). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&loop=1</strong></em> </li>");
                    _e("<li><strong>modestbranding</strong> - Set this to 1 to remove the YouTube logo while playing (or 0 to show the logo). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&modestbranding=1</strong></em> </li>");
                    _e("<li><strong>rel</strong> - Set this to 0 to not show related videos at the end of playing (or 1 to show them). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&rel=0</strong></em> </li>");
                    _e("<li><strong>showinfo</strong> - Set this to 0 to hide the video title and other info (or 1 to show it). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&showinfo=0</strong></em> </li>");
                    _e("<li><strong>theme</strong> - Set this to 'light' to make the player have the light-colored theme (or 'dark' for the dark theme). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&theme=light</strong></em> </li>");
                    _e("<li><strong>color</strong> - Set this to 'white' to make the player have a white progress bar (or 'red' for a red progress bar). Note: Using white will disable the modestbranding option. <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&color=white</strong></em> </li>");
                    _e("<li><strong>controls</strong> - Set this to 0 to completely hide the video controls (or 2 to show it). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&controls=0</strong></em> </li>");
                    _e("<li><strong>autohide</strong> - Set this to 1 to slide away the control bar after the video starts playing. It will automatically slide back in again if you mouse over the video. (Set to  2 to always show it). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&autohide=1</strong></em> </li>");
                    _e("<li><strong>playsinline</strong> - Set this to 1 to allow videos play inline with the page on iOS browsers. (Set to 0 to have iOS launch videos in fullscreen instead). <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&playsinline=1</strong></em> </li>");
                    _e("<li><strong>origin</strong> - Set this to 1 to add the 'origin' parameter for extra JavaScript security. <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA<strong>&origin=1</strong></em> </li>");
                    _e('</ul>');

                    _e("<p>You can also start and end each individual video at particular times. Like the above, each option should begin with '&'</p>");
                    _e('<ul>');
                    _e("<li><strong>start</strong> - Sets the time (in seconds) to start the video. <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA&width=500&height=350<strong>&start=20</strong></em> </li>");
                    _e("<li><strong>end</strong> - Sets the time (in seconds) to stop the video. <em>Example: http://www.youtube.com/watch?v=quwebVjAEJA&width=500&height=350<strong>&end=100</strong></em> </li>");
                    _e('</ul>');
                    ?>
                <div class="save-changes-follow"> <?php self::save_changes_button(isset($_POST[$ytprefs_submitted]) && $_POST[$ytprefs_submitted] == 'Y'); ?> </div>
            </form>
            <div class="jumper" id="jumppro"></div>
            <div id="goprobox">
                <h3 class="sect">
                    <a href="<?php echo self::$epbase ?>/dashboard/pro-easy-video-analytics.aspx" class="button-primary" target="_blank">Want to go PRO? (Low Prices) &raquo;</a> &nbsp; 
                    PRO users help keep new features coming and our coffee cups filled. Go PRO and get these perks in return:
                </h3>
                <div class="procol">
                    <ul class="gopro">
                        <li>
                            <img src="<?php echo plugins_url('images/iconcache.png', __FILE__) ?>">
                            Faster Page Loads (Caching)
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/iconwizard.png', __FILE__) ?>">
                            Full Visual Embedding Wizard (Easily customize embeds without memorizing codes)
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/icongallery.png', __FILE__) ?>">
                            Alternate Gallery Styling (popup/lightbox player, slider and list layouts, and more)
                        </li>       
                        <li>
                            <img src="<?php echo plugins_url('images/iconfx.png', __FILE__) ?>">
                            Add eye-catching special effects as your videos load
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/deletechecker.png', __FILE__) ?>">
                            Deleted Video Checker (alerts you if YouTube deletes videos you embedded)
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/globe.png', __FILE__) ?>">
                            Alerts when visitors from different countries are blocked from viewing your embeds
                        </li>                 
                        <li>
                            <img src="<?php echo plugins_url('images/mobilecompat.png', __FILE__) ?>">
                            Check if your embeds have restrictions that can block mobile viewing
                        </li>       

                    </ul>
                </div>
                <div class="procol" style="max-width: 465px;">
                    <ul class="gopro">
                        <li>
                            <img src="<?php echo plugins_url('images/videothumbs.png', __FILE__) ?>">
                            Featured thumbnail images (just click 'Update')  
                        </li>       
                        <li>
                            <img src="<?php echo plugins_url('images/prioritysupport.png', __FILE__) ?>">
                            Priority support (Puts your request in front)
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/bulletgraph45.png', __FILE__) ?>">
                            User-friendly video analytics dashboard
                        </li>

                        <li id="fbstuff">
                            <img src="<?php echo plugins_url('images/iconfb.png', __FILE__) ?>">
                            Automatic Open Graph tagging for Facebook
                        </li>
                        <!--                            <li>
                                                        <img src="<?php echo plugins_url('images/iconythealth.png', __FILE__) ?>">
                                                        Instant YouTube embed diagnostic reports
                                                    </li>                          -->
                        <li>
                            <img src="<?php echo plugins_url('images/vseo.png', __FILE__) ?>">
                            Automatic tagging for video SEO (will even work for your old embeds)
                        </li>
                        <li>
                            <img src="<?php echo plugins_url('images/iconvolume.png', __FILE__) ?>">
                            Fine-Grained Volume Initialization – Individual video volume settings in the wizard
                        </li>       

                        <li>
                            <img src="<?php echo plugins_url('images/infinity.png', __FILE__) ?>">
                            Unlimited PRO upgrades and downloads
                        </li>
                        <!--                            <li>
                                                        <img src="<?php echo plugins_url('images/questionsale.png', __FILE__) ?>">
                                                        What else? You tell us!                                
                                                    </li>                           -->
                    </ul>
                </div>
                <div style="clear: both;"></div>
                <br>
                <a href="<?php echo self::$epbase ?>/dashboard/pro-easy-video-analytics.aspx" class="button-primary brightpro" target="_blank">Click here to go PRO &raquo;</a>
            </div>

            <div class="jumper" id="jumpsupport"></div>
            <div id="nonprosupport">
                <h3 class="bold">Support tips for all users (Free and PRO)</h3>
                We've found that a common support request has been from users that are pasting video links on single lines, as required, but are not seeing the video embed show up. One of these suggestions is usually the fix:
                <ul class="reglist">
                    <li>Make sure the URL is really on its own line by itself. Or, if you need multiple videos on the same line, make sure each URL is wrapped properly with the shortcode (Example:  <code>[embedyt]http://www.youtube.com/watch?v=ABCDEFGHIJK&width=400&height=250[/embedyt]</code>)</li>
                    <li>Make sure the URL is not an active hyperlink (i.e., it should just be plain text). Otherwise, highlight the URL and click the "unlink" button in your editor: <img src="<?php echo plugins_url('images/unlink.png', __FILE__) ?>"/>.</li>
                    <li>Make sure you did <strong>not</strong> format or align the URL in any way. If your URL still appears in your actual post instead of a video, highlight it and click the "remove formatting" button (formatting can be invisible sometimes): <img src="<?php echo plugins_url('images/erase.png', __FILE__) ?>"/></li>
                    <li>Try wrapping the URL with the <code>[embedyt]...[/embedyt]</code> shortcode. For example: <code>[embedyt]http://www.youtube.com/watch?v=ABCDEFGHIJK[/embedyt]</code> Using the shortcode also allows you to have two or more videos next to each other on the same line.  Just put the shortcoded links together on the same line. For example:<br>
                        <code>[embedyt]http://www.youtube.com/watch?v=ABCDEF&width=400&height=250[/embedyt] [embedyt]http://www.youtube.com/watch?v=GHIJK&width=400&height=250[/embedyt]</code>
                        <br> TIP: As shown above, decrease the size of each video so that they fit together on the same line (See the "How To Override Defaults" section for height and width instructions)
                    </li>
                    <li>If you upload a new video to a playlist or channel and that video is not yet showing up on a gallery you embedded, you should clear/reset any caching plugins you have. This will force your site to retrieve the freshest version of your playlist and/or channel video listing.  If you don't reset you cache, then you'll have to wait until cache lifetime expires.</li>
                    <li>Finally, there's a slight chance your custom theme is the issue, if you have one. To know for sure, we suggest temporarily switching to one of the default WordPress themes (e.g., "Twenty Fourteen") just to see if your video does appear. If it suddenly works, then your custom theme is the issue. You can switch back when done testing.</li>
                    <li>If your videos always appear full size, try turning off "Responsive video sizing."</li>
                    <li>If none of the above work, you can contact us here if you still have issues: ext@embedplus.com. We'll try to respond within a week.</li>
                </ul>
                <p>
                    Deactivating the No Cookies option has also been proven to solve player errors.
                </p>
                <p>
                    We also have a YouTube channel. We use it to provide users with some helper videos and a way to keep updated on new features as they are introduced. <a href="https://www.youtube.com/subscription_center?add_user=EmbedPlus" target="_blank">Subscribe for tips and updates here &raquo;</a>
                </p>
            </div>
            <br>

            <div class="ytnav">
                <a href="#jumpapikey">API Key</a>
                <a href="#jumphowto">How To</a>
                <a href="#jumpwiz">Visual Wizard</a>
                <a href="#jumpdefaults">Defaults</a>
                <a href="#jumpcompat">Compatibility</a>
                <a href="#jumpgallery">Galleries</a>
                <a href="#jumpoverride">Override Defaults</a>
                <a target="_blank" href="<?php echo self::$epbase . "/dashboard/pro-easy-video-analytics.aspx?ref=protab" ?>" style="border-color: #888888;">Upgrade?</a>
                <a href="#jumpsupport">Support</a>
            </div>


            <script type="text/javascript">

                function savevalidate()
                {
                    var valid = true;
                    var alertmessage = '';
                    if (jQuery("#<?php echo self::$opt_defaultdims; ?>").is(":checked"))
                    {
                        if (!(jQuery.isNumeric(jQuery.trim(jQuery("#<?php echo self::$opt_defaultwidth; ?>").val())) &&
                                jQuery.isNumeric(jQuery.trim(jQuery("#<?php echo self::$opt_defaultheight; ?>").val()))))
                        {
                            alertmessage += "Please enter valid numbers for default height and width, or uncheck the option.";
                            jQuery("#boxdefaultdims input").css("background-color", "#ffcccc").css("border", "2px solid #000000");
                            valid = false;
                        }
                    }

                    if (jQuery("#<?php echo self::$opt_gallery_customarrows; ?>").is(":checked"))
                    {
                        if (!jQuery.trim(jQuery("#<?php echo self::$opt_gallery_customprev; ?>").val()) ||
                                !jQuery.trim(jQuery("#<?php echo self::$opt_gallery_customnext; ?>").val()))
                        {
                            alertmessage += "Please enter valid text for both the custom gallery Prev and Next buttons, or uncheck the option.";
                            jQuery("#boxcustomarrows input").css("background-color", "#ffcccc").css("border", "2px solid #000000");
                            valid = false;
                        }
                    }


                    if (jQuery("#<?php echo self::$opt_gallery_channelsub; ?>").is(":checked"))
                    {
                        if (!jQuery.trim(jQuery("#<?php echo self::$opt_gallery_channelsublink; ?>").val()) ||
                                !jQuery.trim(jQuery("#<?php echo self::$opt_gallery_channelsubtext; ?>").val()))
                        {
                            alertmessage += "Please enter valid text for both the subscribe text and subscribe URL, or uncheck the option.";
                            jQuery("#boxchannelsub input").css("background-color", "#ffcccc").css("border", "2px solid #000000");
                            valid = false;
                        }
                    }


                    if (jQuery("#<?php echo self::$opt_gallery_collapse_grid; ?>").is(":checked"))
                    {
                        var emptyStacks = [];
                        jQuery("#box_collapse_grid input").each(function () {
                            var val = jQuery(this).val();
                            if (jQuery.trim(val) === '' || !jQuery.isNumeric(val))
                            {
                                emptyStacks.push(this);
                                jQuery(this).css("background-color", "#ffcccc").css("outline", "2px solid #000000");
                            }
                        });
                        if (emptyStacks.length)
                        {
                            alertmessage += "Please enter a valid number for the gallery stacking screen width.";
                            valid = false;
                        }
                    }



                    if (jQuery("#<?php echo self::$opt_defaultvol; ?>").is(":checked"))
                    {
                        if (!(jQuery.isNumeric(jQuery.trim(jQuery("#<?php echo self::$opt_vol; ?>").val()))))
                        {
                            alertmessage += "Please enter a number between 0 and 100 for the default volume, or uncheck the option.";
                            jQuery("#boxdefaultvol input").css("background-color", "#ffcccc").css("border", "2px solid #000000");
                            valid = false;
                        }
                    }

                    if (!valid)
                    {
                        alert(alertmessage);
                    }
                    return valid;
                }


                jQuery(document).ready(function ($) {
                    jQuery('#<?php echo self::$opt_defaultdims; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxdefaultdims").show(500);
                        }
                        else
                        {
                            jQuery("#boxdefaultdims").hide(500);
                        }

                    });
                    jQuery('#<?php echo self::$opt_gallery_customarrows; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxcustomarrows").show(500);
                        }
                        else
                        {
                            jQuery("#boxcustomarrows").hide(500);
                        }

                    });
                    jQuery('#<?php echo self::$opt_gallery_collapse_grid; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#box_collapse_grid").show(500);
                        }
                        else
                        {
                            jQuery("#box_collapse_grid").hide(500);
                        }
                    });
                    jQuery('#<?php echo self::$opt_gallery_channelsub; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxchannelsub").show(500);
                        }
                        else
                        {
                            jQuery("#boxchannelsub").hide(500);
                        }

                    });
                    jQuery('#<?php echo self::$opt_responsive; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxresponsive_all").show(500);
                        }
                        else
                        {
                            jQuery("#boxresponsive_all").hide(500);
                        }
                    });
                    jQuery('#<?php echo self::$opt_migrate; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxmigratelist").show(500);
                        }
                        else
                        {
                            jQuery("#boxmigratelist").hide(500);
                        }
                    });
                    jQuery('#<?php echo self::$opt_nocookie; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxnocookie").show(500);
                        }
                        else
                        {
                            jQuery("#boxnocookie").hide(500);
                        }

                    });
                    jQuery('#<?php echo self::$opt_defaultvol; ?>').change(function ()
                    {
                        if (jQuery(this).is(":checked"))
                        {
                            jQuery("#boxdefaultvol").show(500);
                        }
                        else
                        {
                            jQuery("#boxdefaultvol").hide(500);
                        }

                    });
                    var rangedetect = document.createElement("input");
                    rangedetect.setAttribute("type", "range");
                    var canrange = rangedetect.type !== "text";
                    //canrange = false;
                    if (canrange)
                    {
                        $("input#vol").prop("type", "range").addClass("vol-range").on("input change", function () {
                            $('.vol-output').text($(this).val() > 0 ? $(this).val() + '%' : 'Mute');
                        });
                        $('.vol-output').css("display", "inline-block").text($("input#vol").val() > 0 ? $("input#vol").val() + '%' : 'Mute');
                        $('.vol-seeslider').show();
                        $('.vol-seetextbox').hide();
                    }
                    else
                    {
                        $("input#vol").width(40);
                    }

                });</script>
            <?php
            if (function_exists('add_thickbox'))
            {
                add_thickbox();
            }
            ?>

            <?php
        }

        public static function save_changes_button($submitted)
        {
            $button_label = 'Save Changes';
            if ($submitted)
            {
                $button_label = 'Changes Saved';
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        setTimeout(function () {
                            jQuery('input.ytprefs-submit').val('Save Changes');
                        }, 3000);
                    });</script>
                <?php
            }
            ?>
            <p class="submit">
                <input type="submit" onclick="return savevalidate();" name="Submit" class="button-primary ytprefs-submit" value="<?php _e($button_label) ?>" />
                <em>If you're using a separate caching plugin and you do not see your changes after saving, you might want to reset your cache.</em>
            </p>
            <?php
        }

        public static function ytprefsscript()
        {
            $loggedin = current_user_can('edit_posts');
            if (!($loggedin && self::$alloptions[self::$opt_admin_off_scripts]))
            {
                wp_enqueue_style(
                        '__EPYT__style', plugins_url('styles/ytprefs' . self::$min . '.css', __FILE__)
                );
                $cols = floatval(self::$alloptions[self::$opt_gallery_columns]);
                $cols = $cols == 0 ? 3.0 : $cols;
                $colwidth = 100.0 / $cols;
                $custom_css = "
                .epyt-gallery-thumb {
                        width: " . round($colwidth, 3) . "%;
                }
                ";

                if (self::$alloptions[self::$opt_gallery_collapse_grid] == 1)
                {
                    foreach (self::$alloptions[self::$opt_gallery_collapse_grid_breaks] as $idx => $bpts)
                    {
                        $custom_css .= "
                         @media (min-width:" . $bpts['bp']['min'] . "px) and (max-width: " . $bpts['bp']['max'] . "px) {
                            .epyt-gallery-rowbreak {
                                display: none;
                            }
                            .epyt-gallery-allthumbs[class*=\"epyt-cols\"] .epyt-gallery-thumb {
                                width: " . round(100.0 / intval($bpts['cols']), 3) . "% !important;
                            }
                          }";
                    }
                }

                wp_add_inline_style('__EPYT__style', $custom_css);

                wp_enqueue_script('__ytprefs__', plugins_url('scripts/ytprefs' . self::$min . '.js', __FILE__), array('jquery'));

                if (self::$alloptions[self::$opt_old_script_method] != 1)
                {
                    $my_script_vars = array(
                        'ajaxurl' => admin_url('admin-ajax.php'),
                        'security' => wp_create_nonce('embedplus-nonce'),
                        'gallery_scrolloffset' => intval(self::$alloptions[self::$opt_gallery_scrolloffset]),
                        'eppathtoscripts' => plugins_url('scripts/', __FILE__),
                        'epresponsiveselector' => self::get_responsiveselector(),
                        'epdovol' => true,
                        'version' => self::$alloptions[self::$opt_version],
                        'evselector' => self::get_evselector(),
                        'stopMobileBuffer' => self::$alloptions[self::$opt_stop_mobile_buffer] == '1' ? true : false
                    );

                    wp_localize_script('__ytprefs__', '_EPYT_', $my_script_vars);
                }

                ////////////////////// cloudflare accomodation
                //add_filter('script_loader_tag', 'YouTubePrefs::set_cfasync', 10, 3);
            }
        }

        public static function set_cfasync($tag, $handle, $src)
        {
            if ('__ytprefs__' !== $handle)
            {
                return $tag;
            }
            return str_replace('<script', '<script data-cfasync="false" ', $tag);
        }

        public static function get_evselector()
        {
            $evselector = 'iframe.__youtube_prefs__[src], iframe[src*="youtube.com/embed/"], iframe[src*="youtube-nocookie.com/embed/"]';

            if (self::$alloptions[self::$opt_evselector_light] == 1)
            {
                $evselector = 'iframe.__youtube_prefs__[src]';
            }

            return $evselector;
        }

        public static function get_responsiveselector()
        {
            $responsiveselector = '[]';
            if (self::$alloptions[self::$opt_widgetfit] == 1)
            {
                $responsiveselector = '["iframe.__youtube_prefs_widget__"]';
            }
            if (self::$alloptions[self::$opt_responsive] == 1)
            {
                if (self::$alloptions[self::$opt_responsive_all] == 1)
                {
                    $responsiveselector = '["iframe[src*=\'youtube.com\']","iframe[src*=\'youtube-nocookie.com\']","iframe[data-ep-src*=\'youtube.com\']","iframe[data-ep-src*=\'youtube-nocookie.com\']","iframe[data-ep-gallerysrc*=\'youtube.com\']"]';
                }
                else
                {
                    $responsiveselector = '["iframe.__youtube_prefs__"]';
                }
            }
            return $responsiveselector;
        }

        public static function admin_enqueue_scripts($hook)
        {
            wp_enqueue_style('embedplusyoutube', plugins_url() . '/youtube-embed-plus/scripts/embedplus_mce' . self::$min . '.css');
            add_action('wp_print_scripts', array('YouTubePrefs', 'output_scriptvars'));
            wp_enqueue_script('__ytprefs_admin__', plugins_url('scripts/ytprefs-admin' . self::$min . '.js', __FILE__), array('jquery'));

            if ((get_bloginfo('version') >= '3.3') && YouTubePrefs::custom_admin_pointers_check())
            {
                add_action('admin_print_footer_scripts', array('YouTubePrefs', 'custom_admin_pointers_footer'));
                wp_enqueue_script('wp-pointer');
                wp_enqueue_style('wp-pointer');
            }

            if (YouTubePrefs::$alloptions['glance'] == 1)
            {
                add_action('admin_print_footer_scripts', 'YouTubePrefs::glance_script');
            }

            if ($hook == self::$wizard_hook)
            {
                wp_enqueue_style('__ytprefs_admin__wizard_ui', plugins_url() . '/youtube-embed-plus/styles/jquery-ui' . self::$min . '.css');
                wp_enqueue_style('__ytprefs_admin__wizard', plugins_url() . '/youtube-embed-plus/styles/ytprefs-wizard' . self::$min . '.css');
                wp_enqueue_script('__ytprefs_admin__wizard_script', plugins_url('scripts/ytprefs-wizard' . self::$min . '.js', __FILE__), array('jquery-ui-accordion', 'jquery-ui-tabs'));
            }
        }

        public static function get_blogwidth()
        {
            $blogwidth = null;
            try
            {
                $embed_size_w = intval(get_option('embed_size_w'));

                global $content_width;
                if (empty($content_width))
                {
                    $content_width = $GLOBALS['content_width'];
                }

                $blogwidth = $embed_size_w ? $embed_size_w : ($content_width ? $content_width : 450);
            }
            catch (Exception $ex)
            {
                
            }

            $blogwidth = preg_replace('/\D/', '', $blogwidth); //may have px

            return $blogwidth;
        }

    }

    $youtubeplgplus = new YouTubePrefs();




    