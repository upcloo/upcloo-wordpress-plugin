<?php
/*
Plugin Name: UpCloo WP Plugin
Plugin URI: http://www.upcloo.com/
Description: UpCloo is a cloud based and fully hosted indexing engine that helps you  to create incredible and automatic correlations between contents of your website.
Version: 0.1
Author: Walter Dal Mut
Author URI: http://corley.it
License: MIT
*/

/*
 * Copyright (C) 2011 by Walter Dal Mut, Gabriele Mittica
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

define("UPCLOO_UPDATE_END_POINT", "%s.update.upcloo.com");
define("UPCLOO_REPOSITORY_END_POINT", "repository.upcloo.com/%s");
define("UPCLOO_POST_PUBLISH", "publish");

add_action("admin_init", "upcloo_init");

add_filter( 'the_content', 'upcloo_content' );

add_filter('admin_footer_text', "upcloo_admin_footer");

//add_action( 'add_meta_boxes', 'upcloo_add_custom_box' );

function upcloo_admin_footer($text)
{
    return $text . " • <span><a target=\"_blank\" href='http://www.upcloo.com'>UpCloo Inside<a></span>";
}

/* Adds a box to the main column on the Post and Page edit screens */
//function upcloo_add_custom_box() {
//    add_meta_box( 
//        'upcloo_sectionid',
//        __( 'UpCloo Custom Metadata', 'wp_upcloo' ),
//        'upcloo_inner_custom_box',
//       'post' 
//    );
//   add_meta_box(
//        'myplugin_sectionid',
//       __( 'UpCloo Custom Metadata', 'wp_upcloo' ), 
//        'upcloo_inner_custom_box',
//        'page'
//    );
//}

//function upcloo_inner_custom_box()
//{
//    // Use nonce for verification
//    wp_nonce_field( plugin_basename( __FILE__ ), 'upcloo_noncename' );
//
//    //The actual fields for data entry
//    echo '<label for="upcloo_custom_field">';
//    _e("Example of future implementation", 'wp_upcloo' );
//    echo '</label> ';
//    echo '<input type="text" id="myplugin_new_field" name="myplugin_new_field" value="whatever" size="25" />';
//}

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'upcloo_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'upcloo_remove');

/**
 * Intialize the plugin
 */
function upcloo_init() {
    load_plugin_textdomain('wp_upcloo', false, basename(dirname(__FILE__)));

    if (current_user_can("edit_posts") || current_user_can('publish_posts')) {
        //add_action('publish_post', 'upcloo_content_sync');
        add_action('edit_post', 'upcloo_content_sync');
    }

    /* When a page is published */
    if (current_user_can('publish_pages')) {
        add_action('publish_page', 'upcloo_content_sync');
    }

    /* Engaged on delete post */
    if (current_user_can('delete_posts')) {
        //add_action('delete_post', 'upcloo_remove_post_sync');
        add_action('trash_post', 'upcloo_remove_post_sync');
    }
}

/* Handle the remove operation */
function upcloo_remove_post_sync($pid)
{
    $endPointURL = sprintf(UPCLOO_UPDATE_END_POINT, get_option("upcloo_userkey"));

    $post = get_post($pid);

    if ($post->post_status == 'trash') {

        $xml = upcloo_model_to_xml(
            array(
                "model" => array(
                    "id" => $post->post_type . "_" . $post->ID
                    "sitekey" => get_option("upcloo_sitekey"),
                    "password" => get_option("upcloo_password"),
                )
            )
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,            $endPointURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST,           1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $xml); 
        curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml')); 
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "DELETE");

        $result=curl_exec ($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        if (is_array($headers) && $headers["http_status"] == 200) {
            //TODO: show the error.
        }
    }
}
 
function upcloo_content_sync($pid)
{
    if (get_option("upcloo_index_post") == "1") {
        $post = get_post($pid); 
        if ($post->post_status == UPCLOO_POST_PUBLISH) {
            $categories = array();
            $tags = array();

            $permalink = get_permalink($pid);

            if (get_option("upcloo_index_category") == "1") {
                $categories = get_the_category($pid);
            }

            if (get_option("upcloo_index_tag") == "1") {
                $tags = get_the_tags($pid);
            }

            $model = array(
                "model" => array(
                    "id" => $post->post_type . "_" . $pid,
                    "sitekey" => get_option("upcloo_sitekey"),
                    "password" => get_option("password"),
                    "title" => $post->post_title,
                    "content" => $post->post_content,
                    "summary" => $post->post_excerpt,
                    "publish_date" => $post->post_date,
                    "url" => $permalink,
                    "categories" => array(),
                    "tags" => array()
                )
            );

            if ($categories) {
                foreach ($categories as $category) {
                    $model["model"]["categories"][] = $category->name;
                }
            }

            if ($tags) {
                foreach ($tags as $tag) {
                    $model["model"]["tags"][] = $tag->name;
                }
            }

            if (!upcloo_send_content($model)) {
                //Raise the error
            }
        }
    }
}

/**
 * Send the content to indexer
 *
 * @param string $model The data model.
 * @return boolean Result of operation
 */
function upcloo_send_content($model)
{
    $endPointURL = sprintf(UPCLOO_UPDATE_END_POINT, get_option("upcloo_userkey"));

    $xml = upcloo_model_to_xml($model);

    /* raw post on curl module */
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            $endPointURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $xml); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml')); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "POST");

    $result=curl_exec ($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    if (is_array($headers) && $headers["http_code"] == 200) {
        return true;
    } else {
        return false;
    } 
}

function upcloo_model_to_xml($model)
{
    if (is_string($model)) {
        return "<![CDATA[" . $model . "]]>";        
    } else {
        foreach ($model as $key => $value) {
            if (is_int($key)) {
                $key = "element";
            }
            $xml .= sprintf("<%s>" . upcloo_model_to_xml($value) . "</%s>", $key, $key);
        }   

        return $xml;
    }
}

function upcloo_install() {
    /* Creates new database field */
    add_option("upcloo_userkey", "", "", "yes");
    add_option("upcloo_sitekey", "", "", "yes");
    add_option("upcloo_password", "", "", "no");
    add_option("upcloo_index_category", "1", "", "no");
    add_option("upcloo_index_tag", "1", "", "no");
    add_option("upcloo_index_page", "1", "", "no");
    add_option("upcloo_index_post", "1", "", "no");
    add_option("upcloo_show_on_page", "1", "", "yes");
}


function upcloo_remove() {
    /* Deletes the database field */
    delete_option('upcloo_userkey');
    delete_option('upcloo_sitekey');
    delete_option('upcloo_password');
    delete_option('upcloo_index_category');
    delete_option('upcloo_index_tag');
    delete_option('upcloo_index_page');
    delete_option('upcloo_index_post');
    delete_option('upcloo_show_on_page');
}

add_action('admin_menu', 'upcloo_admin_menu');

function upcloo_admin_menu() {
    add_options_page(__('UpCloo General Options', "wp_upcloo"), __('UpCloo Options', "wp_upcloo"), 'manage_options',
        'upcloo-general-option', 'upcloo_general_option_page') ;
}

function upcloo_general_option_page() {
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    include realpath(dirname(__FILE__)) . "/general-options.php";
}

/**
 * Working on contents
 */
function upcloo_content($content) {
    global $post;

    $original = $content;

    /**
     * Check if the content is single
     *
     * Use a filter login to perform this kind of selection
     */
    if (is_single($post) || (is_page($post) && get_option("upcloo_show_on_page") == "1")) {
        $content = "<div class=\"upcloo-related-contents\">";
        $content .= include realpath(dirname(__FILE__)) . "/related-content.php";
        $content .= "</div>";
        $content = $original . $content;
    }

    return $content;
}
