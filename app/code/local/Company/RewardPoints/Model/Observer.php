<?php
class Company_RewardPoints_Model_Observer extends Varien_Event_Observer {
    /**
     * Record the points for each product.
     *
     * @triggeredby: sales_order_place_after
     * @param $eventArgs array "order"=>$order
     */

    public function recordPointsForOrderEvent(Varien_Event_Observer $observer) {
        $order = $observer->getEvent()->getOrder();
        $items =$order->getItemsCollection();
        //grab the customerId
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        //load all products for each sales item
        $rewardPoints = 0;
        $prodIds = array();
        foreach ($items as $_item) {
            $prodIds[] = $_item->getProductId();
        }
        //load products from quote IDs to get the points
        //(this won't work if points were set dynamically
        // in the addToCart process)
        $prod = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('reward_points')
            ->addIdFilter($prodIds);

        //sum up points per product per quantity
        foreach ($items as $_item) {
            $rewardPoints += $prod->getItemById($_item->getProductId())->getRewardPoints() * $_item->getQtyOrdered();
        }

        Mage::log('Reward:'.$rewardPoints.' customer:'.$customerId, null, 'test.log', true);

        //record points for item into db
        $this->recordPoints($rewardPoints, $customerId);

        Mage::log('Code input:'.$order->getCouponCode(), null, 'test.log', true);
        //subtract points for this order
        if ($couponCode = $order->getCouponCode()) {
            $this->useCouponPoints($couponCode, $customerId);
        }
    }

    public function recordPoints($pointsInt, $customerId) {
        $points = Mage::getModel('rewardpoints/account')->load($customerId);
        $points->addPoints((int)$pointsInt);
        $points->save();
    }

    public function useCouponPoints($couponCode, $customerId) {
        if ('points' !== substr($couponCode,0,6)) {
            return;
        }
        $pointsAmt = substr($couponCode,6);
        $points = Mage::getModel('rewardpoints/account')->load($customerId);
        $points->subtractPoints($pointsAmt);

        $points->setPointsSpent($pointsAmt);

        $points->save();
    }
}