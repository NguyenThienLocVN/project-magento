<?php

class Company_Mto_Helper_Data extends Mage_Checkout_Helper_Data
{
    public function getQuoteItemProductDescription($item)
    {
        $desc = parent::getQuoteItemProductDescription($item);
        if ($item->getMtoLength()) {
            if ($desc !== '') {
                $desc .= '<br/>';
}
            $desc .= 'Length: '.$item->getMtoLength().'\'';
    }
        return $desc;
    }
}