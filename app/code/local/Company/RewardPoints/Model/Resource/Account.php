<?php

class Company_Rewardpoints_Model_Resource_Account extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('rewardpoints/account', 'rewardpoints_account_id');
    }
}