<?php
class UpCloo_Widget_Partner
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            "upcloo_partner_widget", 
            __("UpCloo Network Widget"), 
            array(
                'description' => __('The UpCloo Virtual Partner SiteKey Widget')
            )
        ); 
    }

    public function form($instance)
    {
        if ( $instance ) {
            $title = esc_attr($instance[ 'upcloo_v_sitekey' ]);
            $enableUtmTag = $instance['upcloo_v_utm_tag'];
            $utmCampaign = $instance["upcloo_v_utm_campaign"];
            $utmMedia = $instance['upcloo_v_utm_media'];
            $utmSource = $instance['upcloo_v_utm_source'];
        } else {
            $title = __( 'Here your Virtual Site Key', 'text_domain' );
            $enableUtmTag = 0;
            $utmCampaign = '';
            $utmMedia = '';
            $utmSource = __('upcloo', text_domain);
        }
        ?>

        <label for="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>"><?php _e('Virtual Partner:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>" name="<?php echo $this->get_field_name('upcloo_v_sitekey'); ?>" type="text" value="<?php echo $title; ?>" />
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_tag'); ?>"><?php _e('Enable UTM Tagging:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_tag'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_tag'); ?>" type="checkbox" <?php echo (($enableUtmTag) ? 'checked' : ''); ?> />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_campaign'); ?>"><?php _e('UTM Campaign:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_campaign'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_campaign'); ?>" type="text" value="<?php echo $utmCampaign; ?>" />
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_media'); ?>"><?php _e('UTM Media:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_media'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_media'); ?>" type="text" value="<?php echo $utmMedia; ?>" />                
        
        <label for="<?php echo $this->get_field_id('upcloo_v_utm_source'); ?>"><?php _e('UTM Source:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_utm_source'); ?>" name="<?php echo $this->get_field_name('upcloo_v_utm_source'); ?>" type="text" value="<?php echo $utmSource; ?>" />
        
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['upcloo_v_sitekey'] = strip_tags($new_instance['upcloo_v_sitekey']);
        $instance['upcloo_v_utm_tag'] = strip_tags($new_instance['upcloo_v_utm_tag']);
        $instance['upcloo_v_utm_campaign'] = strip_tags($new_instance['upcloo_v_utm_campaign']);
        $instance['upcloo_v_utm_media'] = strip_tags($new_instance['upcloo_v_utm_media']);
        $instance['upcloo_v_utm_source'] = strip_tags($new_instance['upcloo_v_utm_source']);
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
               		$utmURL .= "?{$utmURL}";
				} else {
					$utmURL .= "&{$utmURL}";
				}
			}
?>
    <li class="widget-container widget_upcloo">
        <h3 class="widget-title">Related</h3>
        <div>
            <ul>
            <?php
            if ($datax->doc) :
                foreach ($datax->doc as $doc):
?>
<li><a href="<?php echo $doc->url . $utmURL?>" target="_blank"><?php echo $doc->title; ?></a></li>
            <?php
                endforeach;
            endif;
?>
            </ul>
        </div>
    </li>
<?php
            echo $after_widget;
        }
    }
}

