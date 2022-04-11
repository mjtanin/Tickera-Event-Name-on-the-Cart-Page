<?php

/*
  Plugin Name: Tickera - Event Name on the Cart and Checkout Page
  Plugin URI: http://webdevs.com/
  Description: Adds event name on the cart page and Checkout page.
  Author: webdevs.com
  Author URI: 
  Version: 1.0.1
  TextDomain: wd_tc
  Domain Path: /languages/
  Copyright 2022 Webdevs
 */


defined('ABSPATH') || exit;

if (class_exists('TC_Event')) {
    add_action('tc_before_checkout_owner_info_ticket_title', 'tc_event_name_before_ticket_type_name', 10, 1);

    function tc_event_name_before_ticket_type_name($ticket_type_id)
    {
        $event_id  = get_post_meta($ticket_type_id, '_event_name', true);
        $event  = new TC_Event($event_id);

?>
        <h2><?php echo $event->details->post_title; ?></h2>
    <?php
    }

    add_filter("woocommerce_after_cart_item_name", 'cart_after_name_change');
    function cart_after_name_change($ticket_type_id)
    {
        $event_id  = get_post_meta($ticket_type_id['product_id'], '_event_name', true);
        $event  = new TC_Event($event_id);

    ?>
        <p class="event-name"><strong>Event:</strong> <?php echo $event->details->post_title; ?></p>
<?php
    }
}
