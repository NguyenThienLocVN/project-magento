<?php
class Company_RewardPoints_Model_Observer  {
    /**
     * Record the points for each product.
     *
     * @triggeredby: sales_order_place_after
     * @param $eventArgs array "order"=>$order
     */

    public function recordPointsForOrderEvent($observer) {

        $order = $observer->getEvent()->getOrder();
        $items = $order->getItemsCollection();
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
        Mage::log($rewardPoints, null, 'test.log');
        Mage::log($customerId, null, 'test.log');
        //record points for item into db
        $this->recordPoints($rewardPoints, $customerId);
    }

    public function recordPoints($pointsInt, $customerId) {
        $points = Mage::getModel('rewardpoints/account')->load($customerId);
        $points->addPoints($pointsInt);
        $points->save();
        return $points;
    }
}