<?php

class Company_RewardPoints_Model_Resource_Account_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('rewardpoints/account');
    }
}