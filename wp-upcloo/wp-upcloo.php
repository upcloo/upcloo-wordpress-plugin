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

/* Runs when plugin is activated */
register_activation_hook(__FILE__, 'upcloo_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'upcloo_remove' );

function upcloo_install() {
    /* Creates new database field */
    add_option("upcloo_userkey", "", "", "yes");
    add_option("upcloo_sitekey", "", "", "yes");
    add_option("upcloo_network", "", "", "yes");
}


function upcloo_remove() {
    /* Deletes the database field */
    delete_option('upcloo_userkey');
    delete_option('upcloo_sitekey');
    delete_option('upcloo_network');
}

add_action('admin_menu', 'upcloo_admin_menu');

function upcloo_admin_menu() {
    add_options_page('UpCloo General Options', 'UpCloo Options', 'manage_options',
        'upcloo-general-option', 'upcloo_general_option_page') ;
}

function upcloo_general_option_page() {
    include realpath(dirname(__FILE__)) . "/general-options.php";
}
