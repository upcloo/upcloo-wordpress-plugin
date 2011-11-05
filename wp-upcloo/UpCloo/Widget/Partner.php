<?php
class UpCloo_Widget_Partner
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            "upcloo_partner_widget", 
            "UpCloo Network Widget", 
            array(
                'description' => 'The UpCloo widget'
            )
        ); 
    }

    public function form($instance)
    {
        if ( $instance ) {
            $title = esc_attr( $instance[ 'upcloo_v_sitekey' ] );
        } else {
            $title = __( 'Here your Virtual Site Key', 'text_domain' );
        }
        ?>
        <label for="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>"><?php _e('Virtual Partner:'); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('upcloo_v_sitekey'); ?>" name="<?php echo $this->get_field_name('upcloo_v_sitekey'); ?>" type="text" value="<?php echo $title; ?>" />
        <?php
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['upcloo_v_sitekey'] = strip_tags($new_instance['upcloo_v_sitekey']);
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
?>
    <li class="widget-container widget_upcloo">
        <h3 class="widget-title">Related</h3>
        <div>
            <ul>
            <?php
            if ($datax->doc) :
                foreach ($datax->doc as $doc):
?>
<li><a href="<?php echo $doc->url?>" target="_blank"><?php echo $doc->title; ?></a></li>
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

