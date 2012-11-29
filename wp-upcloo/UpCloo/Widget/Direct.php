<?php
/**
 * UpCloo Widget
 *
 * This class enable the UpCloo widget for
 * get related contents usinv virtual site keys.
 *
 * @author UpCloo Ltd.
 * @package UpCloo_Widget
 * @license MIT
 *
 * Copyright (C) 2012 UpCloo Ltd.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
 * of the Software, and to permit persons to whom the Software is furnished to do
 * so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
class UpCloo_Widget_Direct
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            "upcloo_widget",
            __("UpCloo", 'wp_upcloo'),
            array(
                'description' => __('Use UpCloo as a widget instead at the end of the body', 'wp_upcloo')
            )
        );
    }

    public function widget($args, $instance)
    {
        global $post;

        $postTypes = get_option(UPCLOO_POSTS_TYPE);
        if (!is_array($postTypes)) {
            $postTypes = array();
        }

        if (is_single($post) && (in_array($post->post_type, $postTypes))) {
            $sitekey = get_option("upcloo_sitekey");

            $title = $instance["upcloo_v_title"];
            $permalink = get_permalink($post->ID);

            $view = new SView();
            $view->setViewPath(UPCLOO_VIEW_PATH);

            $view->permalink = get_permalink($post->ID);
            $view->sitekey = get_option(UPCLOO_SITEKEY);
            $view->headline = (!(get_option(UPCLOO_REWRITE_PUBLIC_LABEL)) || trim(get_option(UPCLOO_REWRITE_PUBLIC_LABEL)) == '')
                ? __("Maybe you are also interested in", "wp_upcloo")
                :  get_option(UPCLOO_REWRITE_PUBLIC_LABEL);

            $view->limit = get_option(UPCLOO_MAX_SHOW_LINKS, "3");
            $view->theme = get_option(UPCLOO_THEME);
            $view->image = get_option(UPCLOO_IMAGE);
            $view->type = get_option(UPCLOO_TYPE);
            $view->position = get_option(UPCLOO_POPOVER_POSITION);
            $view->defaultImage = ((trim(get_option(UPCLOO_DEFAULT_IMAGE)) == "") ? upcloo_get_default_image() : get_option(UPCLOO_DEFAULT_IMAGE));
            $view->popIn = ((intval(get_option(UPCLOO_POPIN))) > 0 ? get_option(UPCLOO_POPIN) : 500);
            $view->popOut = ((intval(get_option(UPCLOO_POPOUT))) > 0 ? get_option(UPCLOO_POPOUT) : 500);
            $view->ga = ((get_option(UPCLOO_GAN_TRACKER) == true) ? "true" : "false");

            echo $view->render("upcloo-js-sdk.phtml");
        }
    }
}

