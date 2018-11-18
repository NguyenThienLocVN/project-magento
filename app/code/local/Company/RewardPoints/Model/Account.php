<?php
class Company_RewardPoints_Model_Account extends Mage_Core_Model_Abstract {
    protected    $customerId = -1;
    protected    $storeId = -1;
    protected    $pointsCurrent = NULL;
    protected    $pointsReceived = NULL;
    protected    $pointsSpent = NULL;



    protected function _construct()
    {
        $this->_init('rewardpoints/account');
    }



   //public setters and getters for every attribute
    public function getRewardPoints()
    {
        $rewardPoints = $this->getResource()->getAttribute('reward_points');
        return $rewardPoints;
    }
    public function getPointsCurrent()
    {
        $point = Mage::getModel('rewardpoints/account');
        return $point->getPointCurrent();
    }
    public function getPointsReceived()
    {
        $point = Mage::getModel('rewardpoints/account');
        return $point->getPointReceived();
    }
    public function getPointsSpent()
    {
        $point = Mage::getModel('rewardpoints/account');
        return $point->getPointsSpent();
    }
    //save and load methods
    public function save() {
        $connection = Mage::getSingleton('core/resource')->getConnection('rewardpoints_write');
        $connection->beginTransaction();
        $fields = array();
        $fields['customer_id'] = $this->customerId;
        $fields['store_id'] = $this->storeId;
        $fields['points_current'] = $this->pointsCurrent;
        $fields['points_received'] = $this->pointsReceived;
        $fields['points_spent'] = $this->pointsSpent;
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
    public function load($id, $field=null) {
        if ($field === null) {
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
    //add and subtract points methods
    public function addPoints($p) {
        $this->pointsCurrent += $p;
        $this->pointsReceived += $p;
    }
    public function subtractPoints($p) {
        $this->pointsCurrent -= $p;
        $this->pointsSpent -= $p;
    }
}