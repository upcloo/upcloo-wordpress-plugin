<?php
class UpCloo_Widget_Partner
    extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            "upcloo_partner_widget", 
            "UpCloo_Widget_Partner", 
            array(
                'description' => 'The UpCloo widget'
            )
        ); 
    }
}
