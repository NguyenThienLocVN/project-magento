<?php

class Company_Mto_Sales_Model_Quote extends Mage_Sales_Model_Quote
{
    public function getItemByProduct($product)
    {
        foreach ($this->getAllItems() as $item) {
            if ($item->representProduct($product)) {
                return $item;
            }
        }
        return false;
    }
}