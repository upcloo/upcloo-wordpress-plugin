<?php
/**
 * UpCloo Widget
 * 
 * This class enable the UpCloo widget for
 * get related contents usinv virtual site keys.
 *
 * @author Walter Dal Mut
 * @package UpCloo_Widget
 * @license MIT
 *
 * Copyright (C) 2011-2012 Walter Dal Mut, Gabriele Mittica
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
            $enableUtmTag = $instance['upcloo_v_utm_tag'];
            $utmCampaign = $instance["upcloo_v_utm_campaign"];
            $utmMedia = $instance['upcloo_v_utm_media'];
            $utmSource = $instance['upcloo_v_utm_source'];
            $maxLinks = $instance['upcloo_v_max_links'];
        } else {
        	$title = __('Related', 'wp_upcloo');
            $vsitekey = '';
            $enableUtmTag = 0;
            $utmCampaign = '';
            $utmMedia = '';
            $utmSource = __('upcloo', 'wp_upcloo');
            $maxLinks = '';
        }
        ?>
        
        <label for="<?php echo $this->get_field_id('upcloo_v_title'); ?>"><?php _e('Title:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_title'); ?>" name="<?php echo $this->get_field_name('upcloo_v_title'); ?>" type="text" value="<?php echo $title; ?>" />

        <label for="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>"><?php _e('Virtual Partner:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>" name="<?php echo $this->get_field_name('upcloo_v_sitekey'); ?>" type="text" value="<?php echo $vsitekey; ?>" />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_max_links'); ?>"><?php _e('Number of links:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_max_links'); ?>" name="<?php echo $this->get_field_name('upcloo_v_max_links'); ?>" type="text" value="<?php echo $maxLinks; ?>" />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_tag'); ?>"><?php _e('Enable UTM Tagging:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_tag'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_tag'); ?>" type="checkbox" <?php echo (($enableUtmTag) ? 'checked' : ''); ?> />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_campaign'); ?>"><?php _e('UTM Campaign:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_campaign'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_campaign'); ?>" type="text" value="<?php echo $utmCampaign; ?>" />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_media'); ?>"><?php _e('UTM Media:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_media'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_media'); ?>" type="text" value="<?php echo $utmMedia; ?>" />                
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_source'); ?>"><?php _e('UTM Source:', 'wp_upcloo'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_source'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_source'); ?>" type="text" value="<?php echo $utmSource; ?>" />
        
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['upcloo_v_title'] = strip_tags($new_instance['upcloo_v_title']);
        $instance['upcloo_v_sitekey'] = strip_tags($new_instance['upcloo_v_sitekey']);
        $instance['upcloo_v_utm_tag'] = strip_tags($new_instance['upcloo_v_utm_tag']);
        $instance['upcloo_v_utm_campaign'] = strip_tags($new_instance['upcloo_v_utm_campaign']);
        $instance['upcloo_v_utm_media'] = strip_tags($new_instance['upcloo_v_utm_media']);
        $instance['upcloo_v_utm_source'] = strip_tags($new_instance['upcloo_v_utm_source']);
        $instance['upcloo_v_max_links'] = strip_tags($new_instance['upcloo_v_max_links']);
        return $instance;
    }

    public function widget($args, $instance)
    {
        if (is_single($post)) {
            global $post;
            $sitekey = get_option("upcloo_sitekey");

            $virtualSiteKey = $instance["upcloo_v_sitekey"];
            
            echo $before_widget;
            if ($virtualSiteKey) {
                $url = sprintf(UPCLOO_REPOSITORY_END_POINT, $sitekey) . '/' . $virtualSiteKey . "/{$post->post_type}_{$post->ID}.xml";
                
                $datax = upcloo_get_from_repository("", $url);
            }
            
            $utmURL = '';
			if ($instance["upcloo_v_utm_tag"]) {

            	$utmURL = "utm_campaign={$instance["upcloo_v_utm_campaign"]}&utm_medium={$instance["upcloo_v_utm_media"]}&utm_source={$instance["upcloo_v_utm_source"]}";
               	if (strpos($url, "?") === false) {
               		$utmURL = "?{$utmURL}";
				} else {
					$utmURL = "&{$utmURL}";
				}
			}
			
			foreach ($datax->doc as $index => $doc) {
			    if (is_numeric($instance["upcloo_v_max_links"]) && $index >= $instance["upcloo_v_max_links"]) {
			        unset($datax->doc[$index]);
			        continue;
			    }
			    
			    $datax->doc[$index]->url = trim((string)$datax->doc[$index]->url) . $utmURL;
			}

			if ($datax->doc) :
    			if (function_exists(UPCLOO_USER_WIDGET_CALLBACK)) :
    			    echo call_user_func(UPCLOO_USER_WIDGET_CALLBACK, $datax);
    			else :
?>
    <li class="widget-container widget_upcloo">
        <h3 class="widget-title"><?php echo $instance["upcloo_v_title"]?></h3>
        <div>
            <ul>
            <?php 
                foreach ($datax->doc as $index => $doc):
            ?>
            	<li>
            		<a href="<?php echo $doc->url?>" <?php echo ((upcloo_is_external_site($doc->url)) ? 'target="_blank"': "")?>>
            		    <?php echo $doc->title; ?>
        		    </a>
    		    </li>
            <?php
                endforeach;
            ?>
            </ul>
        </div>
    </li>
<?php
                endif;
            endif;
            echo $after_widget;
        }
    }
}

