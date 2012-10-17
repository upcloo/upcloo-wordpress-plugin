<?php
/**
 * UpCloo Search
 *
 * This class enable the UpCloo Search widget for
 * searches on UpCloo distribuited index.
 *
 * @author Walter Dal Mut
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
class UpCloo_Widget_Search
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            UPCLOO_SEARCH_WIDGET_ID,
            __("UpCloo Search Widget", 'wp_upcloo'),
            array(
                'description' => __('The UpCloo Search (in the cloud) Widget', 'wp_upcloo')
            )
        );
    }

    public function form($instance)
    {
        if ( $instance ) {
        	$title = esc_attr($instance[ 'upcloo_search_title' ]);
        } else {
        	$title = __('Search in the Cloud', 'wp_upcloo');
        }
        ?>

        <label for="<?php echo $this->get_field_id('upcloo_search_title'); ?>"><?php _e('Title:', 'wp_upcloo'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_search_title'); ?>" name="<?php echo $this->get_field_name('upcloo_search_title'); ?>" type="text" value="<?php echo $title; ?>" />
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['upcloo_search_title'] = strip_tags($new_instance['upcloo_search_title']);

        return $instance;
    }

    public function widget($args, $instance)
    {
        //Nothing it use the normal search box
    }
}

