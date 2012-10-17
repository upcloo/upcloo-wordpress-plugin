<?php
/*
Plugin Name: UpCloo WP Plugin
Plugin URI: http://www.upcloo.com/
Description: UpCloo is a cloud based and fully hosted indexing engine that helps you  to create incredible and automatic correlations between contents of your website.
Version: 1.2.0-Gertrude
Author: UpCloo Ltd.
Author URI: http://www.corley.it/
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

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');

load_plugin_textdomain('wp_upcloo', null, basename(dirname(__FILE__)));

require_once dirname(__FILE__) . '/UpCloo/Widget/Partner.php';

require_once dirname(__FILE__) . '/SView.php';

//Only secure protocol on post/page publishing (now is beta test... no https)
define("UPCLOO_SITEKEY", "upcloo_sitekey");
define('UPCLOO_REWRITE_PUBLIC_LABEL', 'upcloo_rewrite_public_label');
define('UPCLOO_MAX_SHOW_LINKS', "upcloo_max_show_links");
define("UPCLOO_POST_PUBLISH", "publish");
define("UPCLOO_POST_TRASH", "trash");
define("UPCLOO_RSS_FEED", "http://www.mxdesign.it/contenuti/rss/0/news.xml");
define("UPCLOO_POST_META", "upcloo_post_sent");
define("UPCLOO_DEFAULT_LANG", "upcloo_default_language");
define('UPCLOO_ENABLE_MAIN_CORRELATION', "upcloo_enable_main_correlation");
define('UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY', "upcloo_disable_main_correlation_completely");
define('UPCLOO_MISSING_IMAGE_PLACEHOLDER', 'upcloo_missing_image_placeholder');
define('UPCLOO_POSTS_TYPE', "upcloo_posts_type");

define('UPCLOO_TEMPLATE_BASE', 'upcloo_template_base');
define('UPCLOO_TEMPLATE_SHOW_TITLE', 'upcloo_template_show_title');
define('UPCLOO_TEMPLATE_SHOW_FEATURED_IMAGE', 'upcloo_template_show_featured_image');
define('UPCLOO_TEMPLATE_SHOW_SUMMARY','upcloo_template_show_summary');
define('UPCLOO_TEMPLATE_SHOW_TAGS', 'upcloo_template_show_tags');
define('UPCLOO_TEMPLATE_SHOW_CATEGORIES', 'upcloo_template_show_categories');

define('UPCLOO_ENABLE_TEMPLATE_REMOTE_META', 'upcloo_enable_template_remote_meta');

define('UPCLOO_SITEMAP_PAGE', 'upcloo_sitemap');

define('UPCLOO_MENU_SLUG', 'upcloo_options_menu');
define('UPCLOO_MENU_KSWITCH_SLUG', 'upcloo_options_menu_kswitch');
define('UPCLOO_MENU_FEATURE_SLUG', 'upcloo_options_menu_feature');
define('UPCLOO_MENU_POST_TYPE_SLUG', 'upcloo_options_menu_post_type');
define('UPCLOO_MENU_ROI_SLUG', 'upcloo_options_menu_roi');
define('UPCLOO_MENU_THEME_SLUG', 'upcloo_options_menu_slug');
define('UPCLOO_MENU_REMOTE', 'upcloo_options_menu_remote');

define('UPCLOO_VIEW_PATH', dirname(__FILE__) . '/views');

define('UPCLOO_OPTION_CAPABILITY', 'manage_options');

add_action('widgets_init', create_function( '', 'register_widget("UpCloo_Widget_Partner");'));
add_action('wp_dashboard_setup', 'upcloo_add_dashboard_widgets' );

add_action('wp_head', 'upcloo_wp_head');
add_action('admin_notices', 'upcloo_show_needs_attention');

add_filter('the_content', 'upcloo_content');
add_filter('admin_footer_text', "upcloo_admin_footer");

add_action( 'admin_menu', 'upcloo_plugin_menu' );

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'upcloo_install');

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'upcloo_remove');

//If have to show meta values
if (get_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META, "wp_upcloo")) {
    //Add sitemap page
    if (array_key_exists("plugin_page", $_GET) && $_GET['plugin_page'] == UPCLOO_SITEMAP_PAGE) {
        add_action('template_redirect', 'upcloo_sitemap_page');
    }
}

function upcloo_is_configured()
{
    $postTypes = get_option(UPCLOO_POSTS_TYPE);
    if (!is_array($postTypes)) {
        $postTypes = array();
    }

    if (
        trim(get_option(UPCLOO_SITEKEY)) != '' &&
        count($postTypes) > 0
    ) {
        return true;
    } else {
        return false;
    }
}

function upcloo_show_needs_attention()
{
    if (!upcloo_is_configured()) {
        echo '<div class="updated">
        <p>' . __("Remember that your have to configure UpCloo Plugin: ", "wp_upcloo") . ' <a href="admin.php?page=upcloo_options_menu">'.__("Base Config Page", "wp_upcloo") . '</a> - <a href="admin.php?page=upcloo_options_menu_post_type">'. __("Content Types Selection", "wp_upcloo") . '</a></p>
        </div>';
    }
}

function upcloo_check_menu_capability()
{
    if ( !current_user_can(UPCLOO_OPTION_CAPABILITY) )  {
        wp_die(__( 'You do not have sufficient permissions to access this page.', "wp_upcloo"));
    }
}

//Start menu
function upcloo_plugin_menu()
{
    add_menu_page('UpCloo', __('UpCloo', "wp_upcloo"), UPCLOO_OPTION_CAPABILITY, UPCLOO_MENU_SLUG, 'upcloo_plugin_options');
    add_submenu_page(UPCLOO_MENU_SLUG, "UpCloo Post Type", __("Post Type Indexing", "wp_upcloo"), UPCLOO_OPTION_CAPABILITY, UPCLOO_MENU_POST_TYPE_SLUG, 'upcloo_plugin_menu_post_type');
    add_submenu_page(UPCLOO_MENU_SLUG, "UpCloo Indexing Feature", __("Indexing Feature", "wp_upcloo"), UPCLOO_OPTION_CAPABILITY, UPCLOO_MENU_FEATURE_SLUG, 'upcloo_plugin_menu_feature');
    add_submenu_page(UPCLOO_MENU_SLUG, "UpCloo Remote Importer", __("Remote Importer", "wp_upcloo"), UPCLOO_OPTION_CAPABILITY, UPCLOO_MENU_REMOTE_SLUG, 'upcloo_plugin_menu_remote');
}

function upcloo_plugin_menu_remote()
{
    upcloo_check_menu_capability();
    include realpath(dirname(__FILE__)) . "/options/app-remote-options.php";
}

function upcloo_plugin_menu_post_type()
{
    upcloo_check_menu_capability();
    include realpath(dirname(__FILE__)) . "/options/app-post-type-options.php";
}

function upcloo_plugin_menu_feature()
{
    upcloo_check_menu_capability();
    include realpath(dirname(__FILE__)) . "/options/app-feature-options.php";
}

function upcloo_plugin_options()
{
    upcloo_check_menu_capability();
    include realpath(dirname(__FILE__)) . "/options/app-config-options.php";
}
//End menu

/**
 * Generate a sitemap for UpCloo Remote Importer
 */
function upcloo_sitemap_page()
{
    header ("content-type: text/xml");

    $view = new SView();
    $view->setViewPath(UPCLOO_VIEW_PATH);

    $view->userSelected = get_option(UPCLOO_POSTS_TYPE);

    echo $view->render("sitemap.phtml");
    exit;
}


/**
 * Use only in single.php
 *
 * Call this function only in single.php theme file
 *
 * @return string The content to attach into head.
 */
function upcloo_wp_head()
{
    $metas = '';

    if (get_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META, "wp_upcloo")) {

        $postTypes = get_option(UPCLOO_POSTS_TYPE);
        if (!is_array($postTypes)) {
            $postTypes = array();
        }


        if (is_single()) {
            $m = array();

            global $post;

            //TODO: refactor...
            if (!in_array($post->post_type, $postTypes)) {
                return;
            }

            $publish_date = $post->post_date;
            $publish_date = str_replace(" ", "T", $publish_date) . "Z";

            $m[] = '<!-- UPCLOO_POST_ID '.$post->post_type . "_" . $post->ID.' UPCLOO_POST_ID -->';
            $m[] = '<!-- UPCLOO_POST_TYPE '.$post->post_type.' UPCLOO_POST_TYPE -->';
            $m[] = '<!-- UPCLOO_POST_TITLE '.$post->post_title.' UPCLOO_POST_TITLE -->';
            $m[] = '<!-- UPCLOO_POST_PUBLISH_DATE '.$publish_date.' UPCLOO_POST_PUBLISH_DATE -->';

            $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
            if ($image) {
            	if (is_array($image)) {
            		$image = $image[0];
            	}
                $m[] = '<!-- UPCLOO_POST_IMAGE '.$image.' UPCLOO_POST_IMAGE -->';
            }

            $firstname = get_user_meta($post->post_author, "first_name", true);
            $lastname = get_user_meta($post->post_author, "last_name", true);

            $m[] = '<!-- UPCLOO_POST_AUTHOR '.$firstname . " " . $lastname .' UPCLOO_POST_AUTHOR -->';

            //LANG!
            $lang = get_post_meta($post->ID, UPCLOO_META_LANG, true);
            if ($lang && !empty($lang)) {
                $m[] = '<!-- UPCLOO_POST_LANG ' . $lang . ' UPCLOO_POST_LANG -->';
            }

            $tags = get_the_tags($post->ID);
            if (is_array($tags)) {
                $elements = array();
                foreach ($tags as $element) {
                    $elements[] = $element->name;
                }
                $m[] = '<!-- UPCLOO_POST_TAGS '.implode(",", $elements).' UPCLOO_POST_TAGS -->';
            }

            $categories = get_the_category($post->ID);
            if (is_array($categories)) {
                $elements = array();
                foreach ($categories as $element) {
                    $elements[] = $element->name;
                }
                $m[] = '<!-- UPCLOO_POST_CATEGORIES '.implode(",", $elements).' UPCLOO_POST_CATEGORIES -->';
            }


            $metas = implode(PHP_EOL, $m) . PHP_EOL;
        }
    }

    echo $metas;
}

// Create the function to output the contents of our Dashboard Widget
function upcloo_dashboard_widget_function()
{
    // Display whatever it is you want to show
    $xml = simplexml_load_file(UPCLOO_RSS_FEED);

    $blogInfo = get_bloginfo();
    $blogTitle = urlencode(strtolower($blogInfo));

    $view = new SView();
    $view->setViewPath(UPCLOO_VIEW_PATH);

    $view->xml = $xml;
    $view->blogTitle = $blogTitle;
    $view->blogInfo = $blogInfo;

    echo $view->render("dashboard-widget.phtml");
}

// Create the function use in the action hook

function upcloo_add_dashboard_widgets()
{
    wp_add_dashboard_widget('upcloo_dashboard_widget', __('UpCloo News Widget', "wp_upcloo"), 'upcloo_dashboard_widget_function');
}

function upcloo_admin_footer($text)
{
    return $text . " • <span><a target=\"_blank\" href='http://www.upcloo.com'>UpCloo Inside</a></span>";
}

/**
 * Configure options
 *
 * This method configure options for UpCLoo
 * it is called during UpCloo plugin activation
 */
function upcloo_install() {
    /* Creates new database field */
    add_option(UPCLOO_SITEKEY, "", "", "yes");
    add_option(UPCLOO_MAX_SHOW_LINKS, "5", "", "yes");
    add_option(UPCLOO_ENABLE_MAIN_CORRELATION, "1", "", "yes");
    add_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY, '0', '', 'yes');
    add_option(UPCLOO_POSTS_TYPE, array("post"), '', 'yes');
    add_option(UPCLOO_REWRITE_PUBLIC_LABEL, '','', 'yes');
    add_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META, '0', '', 'yes');
}

/**
 * Remove all options
 *
 * This method remove all UpCloo option
 * it is called by disable plugin action.
 */
function upcloo_remove() {
    /* Deletes the database field */
    delete_option(UPCLOO_MAX_SHOW_LINKS);
    delete_option(UPCLOO_ENABLE_MAIN_CORRELATION);
    delete_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY);
    delete_option(UPCLOO_REWRITE_PUBLIC_LABEL);
    delete_option(UPCLOO_POSTS_TYPE);
    delete_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META);
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
function upcloo_content($content, $noPostBody = false)
{
    global $post;
    global $current_user;

    get_currentuserinfo();

    $postTypes = get_option(UPCLOO_POSTS_TYPE);
    if (!is_array($postTypes)) {
        $postTypes = array();
    }

    if (get_option(UPCLOO_ENABLE_TEMPLATE_REMOTE_META, "wp_upcloo")) {
        //TODO: this part is written twice... clear...
        if ((is_single($post) && (in_array($post->post_type, $postTypes)))) {
            $content = "<!-- UPCLOO_POST_CONTENT -->{$content}<!-- UPCLOO_POST_CONTENT -->";
        }
    }

    $original = $content;

    if (get_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY) == "1") {
        return $content;
    }

    /**
     * Check if the content is single
     *
     * @todo refactor this check
     * Use a filter login to perform this kind of selection
     *
     * Check if UpCloo is enabled
     */
    if (
        (is_single($post) && (in_array($post->post_type, $postTypes)))
        &&
        (get_option(UPCLOO_ENABLE_MAIN_CORRELATION) || (!get_option(UPCLOO_ENABLE_MAIN_CORRELATION) && $current_user->has_cap('edit_users'))))
    {
        $view = new SView();
        $view->setViewPath(UPCLOO_VIEW_PATH);

        $view->permalink = get_permalink($post->ID);
        $view->sitekey = get_option(UPCLOO_SITEKEY);
        $view->headline = (!(get_option(UPCLOO_REWRITE_PUBLIC_LABEL)) || trim(get_option(UPCLOO_REWRITE_PUBLIC_LABEL)) == '')
            ? __("Maybe you are interested at", "wp_upcloo")
            :  get_option(UPCLOO_REWRITE_PUBLIC_LABEL);


        $content .= $view->render("upcloo-js-sdk.phtml");
    }


    return $content;
}

/**
 * Get base domain path of an url
 *
 * @param string $url
 * @return boolean The base url in case of success, false otherwise.
 */
function upcloo_is_external_site($url)
{
    $urlSchema = @parse_url($url);
    if ($urlSchema) {
        if ($urlSchema["host"] == $_SERVER["SERVER_NAME"]) {
            return false;
        } else {
            return true;
        }
    }

    return true;
}

function upcloo_explode_sitekey($sitekey)
{
    $chunks = array();
    if (strpos($sitekey, "-") !== false) {
        $chunks = explode("-", $sitekey);
    } else {
        $chunks[0] = false;
        $chunks[1] = $sitekey;
    }

    return $chunks;
}

