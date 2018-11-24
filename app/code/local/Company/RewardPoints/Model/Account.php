<?php
class Company_RewardPoints_Model_Account extends Mage_Core_Model_Abstract {
    public    $customerId = null;
    public    $storeId = null;
    public    $pointsCurrent = NULL;
    public    $pointsReceived = NULL;
    public    $pointsSpent = NULL;
    public    $couponCode = NULL;


    public function _construct()
    {
        $this->_init('rewardpoints/account');
    }

   //public setters and getters for every attribute
    public function setPointsCurrent($data)
    {
        $this->pointsCurrent = (int)$data;
    }
    public function setPointsReceived($data)
    {
        $this->pointsReceived = (int)$data;
    }
    public function setPointsSpent($data)
    {
        $this->pointsSpent = (int)$data;
    }

    public function getPointsCurrent()
    {
        return (int)$this->pointsCurrent;
    }
    public function getPointsReceived()
    {
        return (int)$this->pointsReceived;
    }
    public function getPointsSpent()
    {
        return (int)$this->pointsSpent;
    }




    public function save() {

        $this->customerId = Mage::getModel('customer/session')->getCustomerId();
        $this->storeId = Mage::app()->getStore()->getStoreId();

        $connection = Mage::getSingleton('core/resource')->getConnection('rewardpoints_write');
        $connection->beginTransaction();
        $fields = array();
        $fields['customer_id'] = $this->customerId;
        $fields['store_id'] = $this->storeId;
        $fields['points_current'] = $this->pointsCurrent;
        $fields['points_received'] = $this->pointsReceived;
        $fields['points_spent'] = $this->pointsReceived - $this->pointsCurrent;

        try {
            $this->_beforeSave();
            if (!is_null($this->rewardpointsAccountId)) {
                $where = $connection->quoteInto('customer_id=?', $fields['customer_id']);
                $connection->update('rewardpoints_account', $fields, $where);
            } else {
                $connection->insert('rewardpoints_account', $fields);
                $this->rewardpointsAccountId = $connection->lastInsertId('rewardpoints_account');
            }
            $connection->commit();
            $this->_afterSave();
        }
        catch (Exception $e) {
            $connection->rollBack();
            throw $e;
        }
        return $this;


    }
    public function load($id, $field = null) {
        if ($field == null) {
            $field = 'customer_id';
        }
        $connection = Mage::getSingleton('core/resource')->getConnection('rewardpoints_read');

        $select = $connection->select()
            ->from('rewardpoints_account')
            ->where('rewardpoints_account.'.$field.'=?', $id);
        $data = $connection->fetchRow($select);

        if (!$data) {
            return $this;
        }

        $this->setRewardpointsAccountId($data['rewardpoints_account_id']);
        $this->setCustomerId($data['customer_id']);
        $this->setStoreId($data['store_id']);
        $this->setPointsCurrent($data['points_current']);
        $this->setPointsReceived($data['points_received']);
        $this->setPointsSpent($data['points_spent']);
        $this->_afterLoad();
        return $this;
    }
    public function addPoints($p) {
        (int)$this->pointsCurrent += $p;
        (int)$this->pointsReceived += $p;
    }
    public function subtractPoints($p) {
        (int) $this->pointsCurrent -= $p;
        (int)$this->pointsSpent -= $p;
    }
}