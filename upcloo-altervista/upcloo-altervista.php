<?php
/*
Plugin Name: UpCloo Related Posts (for AlterVista)
Plugin URI: http://www.upcloo.com/
Description: UpCloo is a cloud based and fully hosted service that helps you to create incredible and automatic related posts between contents of your website. Start now for free! See our <a href="http://www.upcloo.com/lista/nota/terms-of-service/15/1.html">Term of Use</a>
Version: 1.3.2-altervista
Author: UpCloo Ltd.
Author URI: http://www.upcloo.com/
License: MIT
*/

/*
 * Copyright (C) 2012 by UpCloo Ltd.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
require_once dirname(__FILE__) . '/UpClooAlterVista/Widget/Partner.php';

require_once dirname(__FILE__) . '/UpClooAlterVista/SView.php';
$upcloo_altervista_basepath = WP_PLUGIN_DIR . '/upcloo-altervista/upcloo-altervista.php';
/* Runs when plugin is activated */
register_activation_hook($upcloo_altervista_basepath, 'upcloo_altervista_install');

define("UPCLOO_ALTERVISTA_SITEKEY", "upcloo_altervista_sitekey");
define("UPCLOO_ALTERVISTA_SEED", "upcloo_altervista_seed");
define("UPCLOO_ALTERVISTA_CONFIG_ID", "upcloo_altervista_config_id");

define("UPCLOO_ALTERVISTA_RSS_FEED", "http://www.upcloo.com/contenuti/rss/0/news.xml");
define("UPCLOO_ALTERVISTA_ENDPOINT", "http://www.upcloo.com/index/ac.html");
define("UPCLOO_ALTERVISTA_TIMEOUT", 20);

define('UPCLOO_ALTERVISTA_POSTS_TYPE', "upcloo_altervista_posts_type");

define('UPCLOO_ALTERVISTA_MENU_SLUG', 'upcloo_altervista_options_menu');
define('UPCLOO_ALTERVISTA_MENU_ADVANCED_SLUG', 'upcloo_altervista_menu_advanced');

define('UPCLOO_ALTERVISTA_VIEW_PATH', dirname(__FILE__) . '/views');

define('UPCLOO_ALTERVISTA_OPTION_CAPABILITY', 'manage_options');

define('UPCLOO_ALTERVISTA_GAN_TRACKER', 'upcloo_altervista_gan_tracker');
define('UPCLOO_ALTERVISTA_MANUAL_PLACEHOLDER', 'upcloo_altervista_manual_placeholder');
define('UPCLOO_ALTERVISTA_SUMMARY_LEN', 120);

define('UPCLOO_ALTERVISTA_USE_IMAGE', "upcloo_altervista_use_image");

define('UPCLOO_ALTERVISTA_BOX_TITLE', "upcloo_altervista_box_title");

add_action('widgets_init', create_function( '', 'register_widget("UpClooAlterVista_Widget_Partner");'));
wp_register_sidebar_widget("upcloo_altervista_widget", __("UpCloo"), "upcloo_altervista_direct_widget", array('description' => __('Use UpCloo as a widget instead at the end of the body')));
add_action('wp_dashboard_setup', 'upcloo_altervista_add_dashboard_widgets' );

add_action('admin_notices', 'upcloo_altervista_show_needs_attention');

add_filter('the_content', 'upcloo_altervista_content');
add_action('admin_head', 'upcloo_altervista_admin_head');
add_action('wp_head', 'upcloo_altervista_head');
add_filter('admin_footer_text', "upcloo_altervista_admin_footer");

add_action( 'admin_menu', 'upcloo_altervista_plugin_menu' );

function upcloo_altervista_is_configured()
{
    $postTypes = get_option(UPCLOO_ALTERVISTA_POSTS_TYPE);
    if (!is_array($postTypes)) {
        $postTypes = array();
    }

    if (
        trim(get_option(UPCLOO_ALTERVISTA_SITEKEY)) != '' &&
        count($postTypes) > 0
    ) {
        return true;
    } else {
        return false;
    }
}

function upcloo_altervista_show_needs_attention()
{
    if (!upcloo_altervista_is_configured()) {
        echo '<div class="updated">
        <p>' . __("Remember that your have to configure UpCloo Plugin: ") . ' <a href="admin.php?page=upcloo_altervista_options_menu">'.__("Config Page") . '</a> - <a href="admin.php?page=upcloo_altervista_menu_advanced">'.__("Advanced Config Page").'</a></p></div>';
    }
}

function upcloo_altervista_check_menu_capability()
{
    if ( !current_user_can(UPCLOO_ALTERVISTA_OPTION_CAPABILITY) )  {
        wp_die(__( 'You do not have sufficient permissions to access this page.'));
    }
}

//Start menu
function upcloo_altervista_plugin_menu()
{
    add_menu_page('UpCloo', __('UpCloo'), UPCLOO_ALTERVISTA_OPTION_CAPABILITY, UPCLOO_ALTERVISTA_MENU_SLUG, 'upcloo_altervista_plugin_options', "http://media.upcloo.com/u.png");
    add_submenu_page(UPCLOO_ALTERVISTA_MENU_SLUG, "Advanced Configs", __("Advanced Configurations"), UPCLOO_ALTERVISTA_OPTION_CAPABILITY, UPCLOO_ALTERVISTA_MENU_ADVANCED_SLUG, UPCLOO_ALTERVISTA_MENU_ADVANCED_SLUG);
}

function upcloo_altervista_plugin_options()
{
    upcloo_altervista_check_menu_capability();
    include dirname(__FILE__) . "/options/app-config-options.php";
}

function upcloo_altervista_menu_advanced()
{
    upcloo_altervista_check_menu_capability();
    include dirname(__FILE__) . '/options/app-advanced-config-options.php';
}
//End menu

// Create the function to output the contents of our Dashboard Widget
function upcloo_altervista_dashboard_widget_function()
{
    // Display whatever it is you want to show
    $xml = @simplexml_load_file(UPCLOO_ALTERVISTA_RSS_FEED);

    if ($xml !== false) {
        $blogInfo = get_bloginfo();
        $blogTitle = urlencode(strtolower($blogInfo));

        $view = new UpClooAlterVista_SView();
        $view->setViewPath(UPCLOO_ALTERVISTA_VIEW_PATH);

        $view->xml = $xml;
        $view->blogTitle = $blogTitle;
        $view->blogInfo = $blogInfo;

        echo $view->render("dashboard-widget.phtml");
    }
}

// Create the function use in the action hook

function upcloo_altervista_add_dashboard_widgets()
{
    wp_add_dashboard_widget('upcloo_altervista_dashboard_widget', __('UpCloo News Widget'), 'upcloo_altervista_dashboard_widget_function');
}

function upcloo_altervista_admin_head()
{

}

function upcloo_altervista_admin_footer($text)
{
    return $text . " • <span><a target=\"_blank\" href='http://www.upcloo.com'>UpCloo Inside</a></span>";
}

/**
 * Configure options
 *
 * This method configure options for UpCLoo
 * it is called during UpCloo plugin activation
 */
function upcloo_altervista_install() {
    /* Creates new database field */
    add_option(UPCLOO_ALTERVISTA_SITEKEY, "", "", "yes");
    add_option(UPCLOO_ALTERVISTA_SEED, "", "", "yes");
    add_option(UPCLOO_ALTERVISTA_CONFIG_ID, "upcloo_2000", "", "yes");
    add_option(UPCLOO_ALTERVISTA_POSTS_TYPE, array("post"), '', 'yes');
    add_option(UPCLOO_ALTERVISTA_MANUAL_PLACEHOLDER, false, "", "yes");
    add_option(UPCLOO_ALTERVISTA_USE_IMAGE, 1);
    add_option(UPCLOO_ALTERVISTA_BOX_TITLE, "");

    $sitekey = trim(get_option(UPCLOO_ALTERVISTA_SITEKEY, ""));

    if ($sitekey == "") {
        $response = upcloo_altervista_get_new_sitekey();

        update_option(UPCLOO_ALTERVISTA_SITEKEY, $response->sitekey);
        update_option(UPCLOO_ALTERVISTA_SEED, $response->privatekey);
    }
}

/**
 * Require a new sitekey
 *
 * This method request for a new sitekey in order
 * to use UpCloo
 *
 * @todo authorize and get the UpCloo sitekey
 */
function upcloo_altervista_get_new_sitekey()
{
    $admin_email = get_bloginfo("admin_email");
    $blog_url = parse_url(home_url()); //site_url
    $blog_url = $blog_url["host"];

    $request_args = array(
        "email" => $admin_email,
        "url" => $blog_url,
        "posts" => array()
    );
    $posts_args = array(
        "posts_per_page" => 30,
        'offset' => 0,
        'orderby' => 'post_date',
        'order' => 'DESC',
        'post_status' => 'publish'
    );
    $posts = get_posts($posts_args);
    $with_images = 0; //Count posts with images
    foreach ($posts as $post) {
        $image = false;

        if (get_post_thumbnail_id($post->ID, 'thumbnail')) {
            $image = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'thumbnail'));
            $with_images++;
        }

        array_push(
            $request_args["posts"],
            array(
                "title" => $post->post_title,
                "url" => get_permalink($post->ID),
                "summary" => upcloo_altervista_extract_summary($post),
                "image" => $image
            )
        );
    }

    $with_images = ceil($with_images / count($posts) * 100);
    if ($with_images < 30) {
        update_option(UPCLOO_ALTERVISTA_USE_IMAGE, 0);
        update_option(UPCLOO_ALTERVISTA_CONFIG_ID, "upcloo_2002");
    } else {
        update_option(UPCLOO_ALTERVISTA_USE_IMAGE, 1);
        update_option(UPCLOO_ALTERVISTA_CONFIG_ID, "upcloo_2000");
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            UPCLOO_ALTERVISTA_ENDPOINT);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($request_args));
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json'));

    $result=curl_exec ($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    $status = (int)$headers["http_code"];

    if ($status >= 200 && $status <= 300) {
        $body = json_decode($result);
        return $body;
    } else {
        trigger_error("We are experiencing some problems... Please try again later...", E_USER_ERROR);
    }
}

/**
 * Check if is a single, UpCloo, available and selected post
 *
 * Return true if this post is single and a type selected
 * by the user configuration
 *
 * @param stdclass $post WordPress post data object
 * @return boolean if is an UpCloo ready post
 */
function upcloo_altervista_is_valid_content($post)
{
    $postTypes = get_option(UPCLOO_ALTERVISTA_POSTS_TYPE);
    if (!is_array($postTypes)) {
        $postTypes = array();
    }

    if (is_singular($post) && (in_array($post->post_type, $postTypes)) && !is_active_widget(false,false,'upcloo_altervista_widget')) {
        return true;
    } else {
        return false;
    }
}

/**
 * Get content on public side
 *
 * Get the content on public side with UpCloo
 * related posts or other contents.
 *
 * You can disable the post body using the $noPostBody
 * parameter. This parameter is used only if you
 * call the UpCloo call back by hand.
 *
 * @param string $content The original post content
 * @param boolean $noPostBody disable original post content into response
 *
 * @return string The content rewritten using UpCloo
 */
function upcloo_altervista_content($content, $noPostBody = false)
{
    global $post;

    if (upcloo_altervista_is_valid_content($post)) {
        $view = new UpClooAlterVista_SView();
        $view->setViewPath(UPCLOO_ALTERVISTA_VIEW_PATH);

        $view->permalink = get_permalink($post->ID);
        $view->sitekey = get_option(UPCLOO_ALTERVISTA_SITEKEY);
        $view->configId = get_option(UPCLOO_ALTERVISTA_CONFIG_ID, "upcloo_1000");

        $content .= $view->render("upcloo-js-sdk.phtml");
    }

    return $content;
}

/**
 * Add UpCloo metas
 *
 * UpCloo metas simplify and optimize the UpCloo
 * page parsing
 *
 */
function upcloo_altervista_head()
{
    global $post;

    if (upcloo_altervista_is_valid_content($post)) {
        echo '<meta property="upcloo:title" content="' . $post->post_title . '" />' . PHP_EOL;

        // If featured exists add the dedicated meta info
        if (get_post_thumbnail_id($post->ID, 'thumbnail')) {
            echo '<meta property="upcloo:image" content="' . wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'thumbnail'))  . '" />' . PHP_EOL;
        }

        $post_summary = upcloo_altervista_extract_summary($post);
        echo '<meta property="upcloo:summary" content="' . $post_summary . '" />' . PHP_EOL;
    }
}

function upcloo_altervista_extract_summary($post)
{
    $post_summary = trim($post->post_excerpt);
    if($post_summary == '') {
        //compute the summary
        $body = $post->post_content;
        if (strlen($body) > UPCLOO_ALTERVISTA_SUMMARY_LEN && ($pos = strpos($body, ".", UPCLOO_ALTERVISTA_SUMMARY_LEN)) !== false) {
            $post_summary = substr($body, 0, $pos+1);
        } else {
            $post_summary = $body;
        }
    }
    return $post_summary;
}


function upcloo_altervista_direct_widget()
{
    global $post;

    $postTypes = get_option(UPCLOO_ALTERVISTA_POSTS_TYPE);
    if (!is_array($postTypes)) {
        $postTypes = array();
    }

    if (is_singular($post) && (in_array($post->post_type, $postTypes))) {
        $sitekey = get_option("upcloo_altervista_sitekey");

        $title = $instance["upcloo_altervista_v_title"];
        $permalink = get_permalink($post->ID);

        $view = new UpClooAlterVista_SView();
        $view->setViewPath(UPCLOO_ALTERVISTA_VIEW_PATH);

        $view->permalink = get_permalink($post->ID);
        $view->sitekey = get_option(UPCLOO_ALTERVISTA_SITEKEY);
        $view->configId = get_option(UPCLOO_ALTERVISTA_CONFIG_ID, "upcloo_1000");

        echo $view->render("upcloo-js-sdk.phtml");
    }
}
