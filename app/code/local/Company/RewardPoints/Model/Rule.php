<?php

class Company_RewardPoints_Model_Rule extends Mage_SalesRule_Model_Rule
{
    protected $pointsAmt = null;
    protected $couponCode = null;

    public function getPointsAmt()
    {
        return substr($this->getCouponCode(),6);
    }

    public function getCouponCode()
    {
        return Mage::getSingleton('checkout/session')->getQuote()->getCouponCode();
    }



    public function validate(Varien_Object $object) {
        if (substr($this->getCouponCode(),0,6) != 'points') {
            return parent::validate($object);
        }
        $customerId = Mage::getModel('customer/session')->getCustomerId();
        $points = Mage::getModel('rewardpoints/account')->load($customerId);
        $current = $points->getPointsCurrent();
        if ($current < $this->getPointsAmt()) {
            Mage::getSingleton('checkout/session')->addError('Not enough points available.');
            return false;
        }
        return true;
    }
    public function getDiscountAmount() {
        if (substr($this->getCouponCode(),0,6) == 'points') {
            Mage::log('pointAmt:'.$this->getPointsAmt() / 100, null, 'test.log', true);
            return ($this->getPointsAmt() / 100);
        }
        return parent::getDiscountAmount();
    }
}
