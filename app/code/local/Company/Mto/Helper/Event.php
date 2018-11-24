<?php

class Company_Mto_Helper_Event extends Mage_Core_Helper_Abstract
{
    static function cartBeforeSave($observer) {
        $event = $observer->getEvent();
        $req = Mage::app()->getRequest();
        $items = $event->getQuote()->getItemsCollection();
        $mto_length = $req->get('user_length');
        $product_id = $req->get('product');
        if (!$mto_length && !$product_id) {
        //only run if the user is submitting
        // data to the cart controller.
            return;
        }
        foreach ($items as $item) {
            if ($item->getProductId() === $product_id) {
                if(!$item->getMtoLength()) {
                    $item->setMtoLength($mto_length);
                    break;
                }
            }
        }
    }

    static function attachSpecialOrderAttribs($observer) {
        $event = $observer->getEvent();
        $orderItem = $event->getOrderItem();
        $quoteItem = $event->getItem();
        $orderItem->setMtoLength( $quoteItem->getMtoLength() );
    }
}