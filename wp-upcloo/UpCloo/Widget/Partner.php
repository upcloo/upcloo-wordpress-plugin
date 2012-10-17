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
class UpCloo_Widget_Partner
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            "upcloo_partner_widget",
            __("UpCloo Network Widget", 'wp_upcloo'),
            array(
                'description' => __('The UpCloo Virtual Partner SiteKey Widget', 'wp_upcloo')
            )
        );
    }

    public function form($instance)
    {
        if ( $instance ) {
        	$title = esc_attr($instance[ 'upcloo_v_title' ]);
            $vsitekey = esc_attr($instance[ 'upcloo_v_sitekey' ]);
            $maxLinks = $instance['upcloo_v_max_links'];
        } else {
        	$title = __('Related', 'wp_upcloo');
            $vsitekey = '';
            $maxLinks = '';
        }
        ?>

        <label for="<?php echo $this->get_field_id('upcloo_v_title'); ?>"><?php _e('Title:', 'wp_upcloo'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_title'); ?>" name="<?php echo $this->get_field_name('upcloo_v_title'); ?>" type="text" value="<?php echo $title; ?>" />

        <label for="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>"><?php _e('Virtual Partner:', 'wp_upcloo'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>" name="<?php echo $this->get_field_name('upcloo_v_sitekey'); ?>" type="text" value="<?php echo $vsitekey; ?>" />

        <label for="<?php echo $this->get_field_id('upcloo_v_max_links'); ?>"><?php _e('Number of links:', 'wp_upcloo'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_max_links'); ?>" name="<?php echo $this->get_field_name('upcloo_v_max_links'); ?>" type="text" value="<?php echo $maxLinks; ?>" />

        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['upcloo_v_title'] = strip_tags($new_instance['upcloo_v_title']);
        $instance['upcloo_v_sitekey'] = strip_tags($new_instance['upcloo_v_sitekey']);
        $instance['upcloo_v_max_links'] = strip_tags($new_instance['upcloo_v_max_links']);
        return $instance;
    }

    public function widget($args, $instance)
    {
        $postTypes = get_option(UPCLOO_POSTS_TYPE);
        if (!is_array($postTypes)) {
            $postTypes = array();
        }

        if (is_single($post) && (in_array($post->post_type, $postTypes))) {
            global $post;
            $sitekey = get_option("upcloo_sitekey");

            $virtualSiteKey = $instance["upcloo_v_sitekey"];
            $title = $instance["upcloo_v_title"];
            $permalink = get_permalink($post->ID);

            echo $before_widget;

            $view = new SView();
            $view->sitekey = $sitekey;
            $view->permalink = $permalink;
            $view->vsitekey = $virtualSiteKey;
            $view->headline = $title;

            echo $view->render("upcloo-js-sdk.phtml");
            echo $after_widget;
        }
    }
}

