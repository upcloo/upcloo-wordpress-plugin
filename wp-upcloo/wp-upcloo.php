<?php
/*
Plugin Name: UpCloo WP Plugin
Plugin URI: http://www.upcloo.com/
Description: UpCloo is a cloud based and fully hosted indexing engine that helps you  to create incredible and automatic correlations between contents of your website.
Version: 1.0.0-Macbeth
Author: Walter Dal Mut, Gabriele Mittica
Author URI: http://www.corley.it
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

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');

load_plugin_textdomain('wp_upcloo', null, basename(dirname(__FILE__)));

require_once dirname(__FILE__) . '/UpCloo/Widget/Partner.php';

//Only secure protocol on post/page publishing (now is beta test... no https)
define("UPCLOO_UPDATE_END_POINT", "http://%s.update.upcloo.com");
define("UPCLOO_REPOSITORY_END_POINT", "http://repository.upcloo.com/%s");
define("UPCLOO_POST_PUBLISH", "publish");
define("UPCLOO_POST_TRASH", "trash");
define("UPCLOO_USER_AGENT", "WPUpCloo/1.0");
define("UPCLOO_RSS_FEED", "http://www.mxdesign.it/contenuti/rss/0/news.xml");
define("UPCLOO_POST_META", "upcloo_post_sent");
define("UPCLOO_CLOUD_IMAGE", '<img src="'.WP_PLUGIN_URL.'/wp-upcloo/upcloo.png" src="UpCloo" />');
define("UPCLOO_NOT_CLOUD_IMAGE", '<img src="'.WP_PLUGIN_URL.'/wp-upcloo/warn.png" src="UpCloo" />');
define("UPCLOO_DEFAULT_LANG", "upcloo_default_language");
define('UPCLOO_META_LANG', 'upcloo_language_field');
define('UPCLOO_ENABLE_MAIN_CORRELATION', "upcloo_enable_main_correlation");
define('UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY', "upcloo_disable_main_correlation_completely");
define('UPCLOO_MISSING_IMAGE_PLACEHOLDER', 'upcloo_missing_image_placeholder');
define('UPCLOO_POSTS_TYPE', "upcloo_posts_type");
define('UPCLOO_SUMMARY_LEN', 'upcloo_summary_len');

define('UPCLOO_USER_DEFINED_TEMPLATE_FUCTION', "upcloo_user_template_callback");

add_action("admin_init", "upcloo_init");
add_action( 'add_meta_boxes', 'upcloo_add_custom_box' );
add_action( 'widgets_init', create_function( '', 'register_widget("UpCloo_Widget_Partner");' ) );
add_action('manage_posts_custom_column',  'upcloo_my_show_columns');
add_action('manage_pages_custom_column',  'upcloo_my_show_columns');
add_action('save_post', 'upcloo_save_data');
add_action('wp_dashboard_setup', 'upcloo_add_dashboard_widgets' );
add_action('wp_ajax_upcloo_ajax_importer', 'upcloo_action_ajax_importer_callback');

add_filter( 'the_content', 'upcloo_content' );
add_filter('admin_footer_text', "upcloo_admin_footer");
add_filter('manage_pages_columns', 'upcloo_my_columns');
add_filter('manage_posts_columns', 'upcloo_my_columns');


/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'upcloo_install');

/* Runs on plugin deactivation*/
register_deactivation_hook(__FILE__, 'upcloo_remove');

/**
 * Ajax (upcloo_ajax_importer)
 * 
 * Used for importer [GET call]
 */
function upcloo_action_ajax_importer_callback()
{
    $onlyMissing = $_GET["onlyMissing"];
        
    set_time_limit(600);
    
    $userSelected = get_option(UPCLOO_POSTS_TYPE);
    
    foreach ($userSelected as $key => $postType) {
        //Get all... [Content sync handle pages and posts]
        $postsCount = wp_count_posts($postType)->publish;
        
        $postsPerPage = 100;
        
        for ($i=0; $i<ceil($postsCount/$postsPerPage); $i++) {
            $args = array(
            	'numberposts'     => $postsPerPage,
                'offset'          => $i*$postsPerPage,    //TODO: handle this one
                'orderby'         => 'post_date',
                'order'           => 'ASC',
                'post_status'     => 'publish',
                'post_type'		  => $postType
            );
            
            $posts = get_posts($args);
            //Foreach post
            foreach ($posts as $post) {
                $toIndex = ($onlyMissing) ? (get_post_meta($post->ID, UPCLOO_POST_META, true) ? false : true): true;
    
                //Check if is to index
                if ($toIndex && upcloo_content_sync($post->ID)) {
                    //Force metadata update...
                    $upClooMeta = get_post_meta($post->ID, UPCLOO_POST_META, true);
                    update_post_meta($post->ID, UPCLOO_POST_META, "1", $upClooMeta);
                } 
            }
        }
    }

    //Operation ends...
    echo json_encode(array("completed" => 1));
    die();
}

function upcloo_add_force_content_send_link()
{
    global $post_ID;
    $post = get_post( $post_ID );
    
    if ($post->post_status == 'publish') :
        $upclooMeta = get_post_meta($post->ID, UPCLOO_POST_META, true);
    ?>
    <div id="upcloo-box-publish" class="misc-pub-section" style="border-top-style:solid; border-top-width:1px; border-bottom-width:0px;">
    	UpCloo: <strong><?php echo (($upclooMeta != '') ? _e("Indexed", "wp_upcloo") : _e("Not Indexed", "wp_upcloo"));?></strong> 
    		<a class="submitdelete deletion" href="/wp-admin/edit.php?post=<?php echo $post->ID; ?>&upcloo=reindex"><?php (($upclooMeta != '') ? _e("ReIndex NOW", "wp_upcloo") : _e("Index NOW", "wp_upcloo"));?></a>
    </div>
    <?php 
    endif;
}
add_action( 'post_submitbox_misc_actions', 'upcloo_add_force_content_send_link' );
function upcloo_my_columns($columns) 
{
    $columns['upcloo'] = "UpCloo";
    
    if ($_GET["upcloo"] == 'reindex') {
        $upClooMeta = get_post_meta($_GET["post"], UPCLOO_POST_META, true);
        
        if (upcloo_content_sync($_GET["post"])) {
            update_post_meta($_GET["post"], UPCLOO_POST_META, "1", $upClooMeta);
        }
    }
    
    return $columns;
}

function upcloo_my_show_columns($name) {
    global $post;
    
    switch ($name) {
        case 'upcloo':
            $upclooSent = get_post_meta($post->ID, UPCLOO_POST_META, true);
            $image = (($upclooSent == '1') ? UPCLOO_CLOUD_IMAGE : UPCLOO_NOT_CLOUD_IMAGE);
            
            //Only how can edit pages can send to upcloo...
            if (current_user_can("edit_posts") || current_user_can('edit_pages')) {
                echo "<a href='?post={$post->ID}&upcloo=reindex'>" . $image . '</a>';
            } else {
                echo $image;
            }
            
            break;
    }
}

// Create the function to output the contents of our Dashboard Widget
function upcloo_dashboard_widget_function() {
    // Display whatever it is you want to show
    $xml = simplexml_load_file(UPCLOO_RSS_FEED);
    
    $blogInfo = get_bloginfo();
    $blogTitle = urlencode(strtolower($blogInfo));    
    
    echo "<ul>";
    foreach ($xml->channel->item as $item) {
        echo "<li><a href='{$item->link}?utm_campaign=wp_dashboardwidget&utm_medium=wordpress&utm_source={$blogTitle}' target='_blank'>{$item->title}</a></li>";
    }
    echo "</ul>";
}

// Create the function use in the action hook

function upcloo_add_dashboard_widgets() {
    wp_add_dashboard_widget('upcloo_dashboard_widget', __('UpCloo News Widget'), 'upcloo_dashboard_widget_function');
}

function upcloo_admin_footer($text)
{
    return $text . " • <span><a target=\"_blank\" href='http://www.upcloo.com'>UpCloo Inside</a></span>";
}

/* Adds a box to the main column on the Post and Page edit screens */
function upcloo_add_custom_box() {
   add_meta_box( 
       'upcloo_language_metabox',
       __( 'UpCloo Language Definer', 'wp_upcloo' ),
       'upcloo_inner_custom_box',
      'post' 
   );
  add_meta_box(
       'upcloo_language_metabox',
      __( 'UpCloo Language Definer', 'wp_upcloo' ), 
       'upcloo_inner_custom_box',
       'page'
   );
}

function upcloo_inner_custom_box()
{
    global $post;

    $metadataLang = get_post_meta($post->ID, UPCLOO_META_LANG, true);
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'upcloo_language_metabox_nonce' );

    //The actual fields for data entry
    echo '<label for="'.UPCLOO_META_LANG.'">';
    _e("Select the language of your article/page", 'wp_upcloo' );
    echo '</label> ';
    $selectBoxHTML = '<select name="'.UPCLOO_META_LANG.'">%s</select>';
   
    $defaultLang = ($metadataLang != '') ? $metadataLang : get_option(UPCLOO_DEFAULT_LANG);
   
    $languages = array(
    	'it' => __('Italian', 'wp_upcloo'),
    	'en' => __('English', 'wp_upcloo')
    );
   
    $options = '';
    foreach ($languages as $code => $language) {
        $options .= '<option value="'.$code.'" '.(($code == $defaultLang) ? 'selected="selected"' : '').'>' .__($language, 'wp_upcloo') . '</option>';
    }
   
    $selectBoxHTML = sprintf($selectBoxHTML, $options);
   
    echo $selectBoxHTML;
}

/**
 * Intialize the plugin
 */
function upcloo_init() {
    
//     if (current_user_can("edit_posts") || current_user_can('publish_posts')) {
//         //add_action('publish_post', 'upcloo_content_sync');
//         add_action('edit_post', 'upcloo_content_sync');
//     }

    /* When a page is published */
//     if (current_user_can('publish_pages')) {
//         add_action('publish_page', 'upcloo_content_sync');
//     }

    /* Engaged on delete post */
//     if (current_user_can('delete_posts')) {
//         //add_action('delete_post', 'upcloo_remove_post_sync');
//         add_action('trash_post', 'upcloo_remove_post_sync');
//     }
}

function upcloo_save_data($post_id)
{
    global $meta_box;

    $new = $_POST[UPCLOO_META_LANG];
    $old = get_post_meta($post_id, UPCLOO_META_LANG, true);
    
    if ('' == $new && $old) {
        delete_post_meta($post_id, $new, $old);
    } else {
        update_post_meta($post_id, UPCLOO_META_LANG, $new);
    }
}

/* Handle the remove operation */
function upcloo_remove_post_sync($pid)
{
    $endPointURL = sprintf(UPCLOO_UPDATE_END_POINT, get_option("upcloo_userkey"));

    $post = get_post($pid);

    if ($post->post_status == UPCLOO_POST_TRASH) {

        $xml = upcloo_model_to_xml(
            array(
                "model" => array(
                    "id" => $post->post_type . "_" . $post->ID,
                    "sitekey" => get_option("upcloo_sitekey"),
                    "password" => get_option("upcloo_password")
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
        curl_setopt($ch, CURLOPT_USERAGENT,      UPCLOO_USER_AGENT);

        $result=curl_exec ($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        if (is_array($headers) && $headers["http_code"] != 200) {
            return false;
        }
        
        return true;
    }
}
 
/**
 * Mantain updated the contents
 * 
 * @param int $pid The content PID
 * @return boolean if the content is indexed.
 */
function upcloo_content_sync($pid)
{
    $post = get_post($pid); 
    $language = get_post_meta($post->ID, UPCLOO_META_LANG, true);
    
    $postsType = get_option(UPCLOO_POSTS_TYPE);
    
    /* Check if the content must be indexed */
    //TODO: add check condition on post type!
    if (in_array($post->post_type, $postsType)) {
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
            
            //For taxonomies remove builtin and elements must public
            $taxonomies_data = array();
            
            $args=array(
				'public'   => true,
              	'_builtin' => false
            );
            $taxonomies = get_taxonomies($args,'names', 'and');
            foreach ($taxonomies as $taxonomy) {
                $terms = wp_get_post_terms($pid, $taxonomy);
                
                $taxonomies_data[$taxonomy] = array();
                foreach ($terms as $term) {
                    $taxonomies_data[$taxonomy][] = $term->name;
                }
            }
            
            $firstname = get_user_meta($post->post_author, "first_name", true);
            $lastname = get_user_meta($post->post_author, "last_name", true);

            $publish_date = $post->post_date;
            $publish_date = str_replace(" ", "T", $publish_date) . "Z";
            
            $summary = $post->post_excerpt;
            
            //If no summary 
            if (empty($summary)) {
                //Cut the first part of text
                //and use it as a summary
                $content = $post->post_content;

                //Get the max summary len
                $len = upcloo_get_max_summary_len();
                if (strlen($content) > $len) {
                    $pos = strpos($content, ".", $len);
                    if ($pos === false) {
                        //No dot... what I do?
                        $summary = substr($content, 0 , $len); // I fill the summary with content.
                    } else {
                        $summary = substr($content, 0, $pos+1);
                    }
                } else {
                    $summary = $content;
                }
            }
            
            $model = array(
                "model" => array(
                    "id" => $post->post_type . "_" . $pid,
                    "sitekey" => get_option("upcloo_sitekey"),
                    "password" => get_option("upcloo_password"),
                    "title" => $post->post_title,
                    "content" => $post->post_content,
                    "summary" => $summary,
                    "publish_date" => $publish_date,
                    "type" => $post->post_type,
                    "url" => $permalink,
                    "author" => $firstname . " " . $lastname,
                    "categories" => array(),
                    "tags" => array()
                )
            );
            
            $image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail');
            if ($image) {
                $model["model"]['image'] = $image[0];
            }
            
            if ($language != '') {
                $model["model"]["lang"] = $language;
            }
 
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
            
            if (is_array($taxonomies_data) && count($taxonomies_data)) {
                $model["model"]["dynamics_tags"] = $taxonomies_data;                
            }
            
            return upcloo_send_content($model);
        }
    }
}

/**
 * 
 * Get the max summary len
 * 
 * @return int The max summary len
 */
function upcloo_get_max_summary_len()
{
    $len = get_option(UPCLOO_SUMMARY_LEN);
    
    if (is_numeric($len)) {
        $len = (int)$len;
    
        if ($len <= 0) {
            $len = 120;
        }
    } else {
        $len = 120;
    }
    
    return $len;
}

/**
 * Send the content to indexer
 *
 * @param array $model The data model.
 * @return boolean Result of operation
 */
function upcloo_send_content($model)
{
    $userKey = trim(get_option("upcloo_userkey"));

    //If the user key is empty
    if (empty($userKey)) {
        return false;
    }

    $endPointURL = sprintf(UPCLOO_UPDATE_END_POINT, $userKey);

    $xml = upcloo_model_to_xml($model);
    
    /* raw post on curl module */
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            $endPointURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST,           1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $xml); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml')); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,  "POST");
    curl_setopt($ch, CURLOPT_USERAGENT,      UPCLOO_USER_AGENT);

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
        return "<![CDATA[" . strip_tags($model) . "]]>";        
    } else {
        $xml = "";
        if ($model && is_array($model)) {
            foreach ($model as $key => $value) {
                if (is_int($key)) {
                    $key = "element";
                }
                $xml .= "<{$key}>" . upcloo_model_to_xml($value) . "</{$key}>";
            }   
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
    add_option("upcloo_max_show_links", "10", "", "yes");
    add_option("upcloo_utm_tag", "0", "", "yes");
    add_option("upcloo_utm_campaign", "", "", "yes");
    add_option("upcloo_utm_medium", "", "", "yes");
    add_option("upcloo_utm_source", "", "", "yes");
    add_option(UPCLOO_DEFAULT_LANG, "it", "", "yes");
    add_option(UPCLOO_ENABLE_MAIN_CORRELATION, "1", "", "yes");
    add_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY, '0', '', 'yes');
    add_option(UPCLOO_MISSING_IMAGE_PLACEHOLDER, '', '', 'yes');
    add_option(UPCLOO_POSTS_TYPE, '', '', 'yes');
    add_option(UPCLOO_SUMMARY_LEN, '', '', 'no');
}


function upcloo_remove() {
    /* Deletes the database field */
    delete_option('upcloo_userkey');
    delete_option('upcloo_sitekey');
    delete_option('upcloo_password');
    delete_option('upcloo_index_category');
    delete_option('upcloo_index_tag');
    delete_option('upcloo_max_show_links');
    delete_option("upcloo_utm_tag");
    delete_option("upcloo_utm_campaign");
    delete_option("upcloo_utm_medium");
    delete_option("upcloo_utm_source");
    delete_option(UPCLOO_DEFAULT_LANG);
    delete_option(UPCLOO_ENABLE_MAIN_CORRELATION);
    delete_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY);
    delete_option(UPCLOO_MISSING_IMAGE_PLACEHOLDER);
    delete_option(UPCLOO_POSTS_TYPE);
    delete_option(UPCLOO_SUMMARY_LEN);
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
 * Get content on public side
 */
function upcloo_content($content) {
    global $post;
    global $current_user;
    
    get_currentuserinfo();
    
    $original = $content;

    $upClooMeta = get_post_meta($post->ID, UPCLOO_POST_META, true);
    
    if (get_option(UPCLOO_DISABLE_MAIN_CORRELATION_COMPLETELY) == "1") {
        return $original;
    }
    
    $postTypes = get_option(UPCLOO_POSTS_TYPE);
    
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
        /**
         * If not sent to upcloo send it and store the result.
         * 
         * Only not logged in user can send to UpCloo in automode
         */
        if (!$current_user->id && $upClooMeta == '') {
            if (upcloo_content_sync($post->ID)) {
                update_post_meta($post->ID, UPCLOO_POST_META, "1", $upClooMeta);
            }
        }
        
        //Get it 
        $listOfModels = upcloo_get_from_repository($post->post_type . "_" . $post->ID);
        
        $content = '';
        if ($listOfModels && property_exists($listOfModels, "doc") && is_array($listOfModels->doc) && count($listOfModels->doc)) {
            
            //Check if exists user template system (functions.php of template?)
            if (function_exists(UPCLOO_USER_DEFINED_TEMPLATE_FUCTION)) {
                $content = call_user_func(UPCLOO_USER_DEFINED_TEMPLATE_FUCTION, $listOfModels);
                
                return $original . $content;  //SELF TEMPLATE!
            }
            
            $index = 0;
            $maxContents = get_option("upcloo_max_show_links")/1;
            $content .= "<div class=\"upcloo-related-contents\">";
            //User override the default label
            if (!(get_option('upcloo_rewrite_public_label')) || trim(get_option('upcloo_rewrite_public_label')) == '') {
                $content .= "<h2>" . __("Maybe you are interested at", "wp_upcloo") . ":</h2>";
            } else {
                $content .= '<h2>' . get_option('upcloo_rewrite_public_label') . '</h2>';
            }
            
            if (get_option("upcloo_template_base", "wp_upcloo") == 1) {
                foreach ($listOfModels->doc as $element) {
                    //max links cutter
                    if (is_int($maxContents) && $maxContents > 0) {
                        if ($index >= $maxContents) {
                            break;
                            $index=0;
                        }
                    
                        $index++;
                    }
                    
                    $finalURL = upcloo_get_utm_tag_url($element->url);
                    
                    $content .= '<div class="upcloo_template_element">';

                    //Show if featured image
                    if (get_option('upcloo_template_show_featured_image', 'wp_upcloo') == 1) {
                        //Get the image path
                        $imagePath =  ((is_string($element->image)) ? $element->image : get_option(UPCLOO_MISSING_IMAGE_PLACEHOLDER));
                        //Append the image to the content
                        $content .= '<div class="upcloo_post_image"><a href="'. $finalURL .'"><img src="' . $imagePath . '" alt="" /></a></div>';
                    }
                    
                    //Show if title
                    if (get_option('upcloo_template_show_title', 'wp_upcloo') == 1) {
                        $content .= '<div class="upcloo_post_title"><a href="'.$finalURL.'">' . $element->title . '</a></div>';
                    }
                    
                    //Show if summary
                    if (get_option('upcloo_template_show_summary', 'wp_upcloo') == 1) {
                        $content .= '<div class="upcloo_post_summary">' . $element->description . '</div>';
                    }

                    //Show if categories
                    if (get_option('upcloo_template_show_categories', 'wp_upcloo') == 1) {
                        $content .= "<div class=\"upcloo_post_categories\">";
                        foreach ($element->categories->category as $category) {
                            $content .= '<div class="upcloo_post_categories_category">' . $category . '</div>';
                        }
                        $content .= "</div>";
                    }
                    
                    //Show if tags
                    if (get_option('upcloo_template_show_tags', 'wp_upcloo') == 1) {
                        $content .= "<div class=\"upcloo_post_tags\">";
                        foreach ($element->tags->tag as $tag) {
                            $content .= '<div class="upcloo_post_tags_tag">' . $tag . '</div>';
                        }
                        $content .= "</div>";
                    }
                    
                    $content .= '</div>';
                }
            } else {
            
                $content .= "<ul>";
                foreach ($listOfModels->doc as $element) {
                    //max links cutter
                    if (is_int($maxContents) && $maxContents > 0) {
                        if ($index >= $maxContents) {
                            break;
                            $index=0;
                        }
    
                        $index++;
                    }
                    
                    $finalURL = upcloo_get_utm_tag_url($element->url);
                    
                    $content .= "<li><a href=\"{$finalURL}\">{$element->title}</a></li>";    
                }
    
                $content .= "</ul>";
            }
            $content .= "</div>";
        }
        $content = $original . $content;
    }

    return $content;
}

/**
 * 
 * Get the URL
 * 
 * @param string $finalURL
 * @return string The url
 */
function upcloo_get_utm_tag_url($finalURL)
{
    //Prepare link UTM
    $utmURL = '';
    if (get_option("upcloo_utm_tag", "wp_upcloo")) {
        $utmURL .= 'utm_campaign=' .
        get_option("upcloo_utm_campaign", "wp_upcloo") . '&utm_medium=' .
        get_option("upcloo_utm_medium", "wp_upcloo") . '&utm_source=' .
        get_option("upcloo_utm_source", "wp_upcloo");
    }
    
    if (get_option("upcloo_utm_tag", "wp_upcloo")) {
        if (strpos($finalURL, "?")) {
            $finalURL .= '&';
        } else {
            $finalURL .= '?';
        }
    }
    
    $finalURL .= $utmURL;
    
    return $finalURL;
}

/* Get related contents from repository  */
function upcloo_get_from_repository($name, $endPointURL = false)
{
    if ($endPointURL === false) {
        $endPointURL = sprintf(UPCLOO_REPOSITORY_END_POINT, get_option("upcloo_sitekey"));
        if (get_option('upcloo_enable_vsitekey_as_primary') && get_option('upcloo_enable_vsitekey_as_primary') == 1) {
            $endPointURL = sprintf(UPCLOO_REPOSITORY_END_POINT, get_option("upcloo_sitekey"));
            $endPointURL  .= "/" . get_option("upcloo_vsitekey_as_primary");
        } 
        $endPointURL .= "/{$name}.xml";
    }
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            $endPointURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml')); 

    $result=curl_exec ($ch);
    $headers = curl_getinfo($ch);
    curl_close($ch);

    if (is_array($headers) && $headers["http_code"] == 200) {
        return json_decode(json_encode(simplexml_load_string($result)));
    }
}
