<?php

/*
  Plugin Name: Tickera - Event Name on the Cart and Checkout Page
  Plugin URI: http://tanin.webdevs.com/
  Description: Adds event name on the cart page and Checkout page.
  Author: Tanin
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

    function action_woocommerce_order_item_meta_start($item_id, $item, $order)
    {
        $product_id = $item->get_product_id();
        $event_id  = get_post_meta($product_id, '_event_name', true);
        $event  = new TC_Event($event_id);

    ?>
        <br /><strong>Event:</strong> <?php echo $event->details->post_title; ?>
<?php
    };

    add_action('woocommerce_order_item_meta_start', 'action_woocommerce_order_item_meta_start', 10, 3);
}
