<?php

namespace Amper\Discounts\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

    const XML_PATH_DISCOUNTS = 'discounts/general/';

    /**
     * @param $field
     * @param $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @return mixed
     */
    public function getIsEnabled()
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNTS .'enable');
    }

    /**
     * @return mixed
     */
    public function getQtyItemDiscount()
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNTS .'qty_item_discount');
    }

    /**
     * @return mixed
     */
    public function getQtyItemDiscountAmount()
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNTS .'qty_item_discount_amount');
    }

    /**
     * @return mixed
     */
    public function getTotalCartAmount()
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNTS .'total_cart_amount');
    }

    /**
     * @return mixed
     */
    public function getTotalCartDiscount()
    {
        return $this->getConfigValue(self::XML_PATH_DISCOUNTS .'total_cart_discount');
    }

    /**
     * @param $qty
     * @return bool
     */
    public function qtyAppliesItemDiscount( $qty )
    {
        return $this->getIsEnabled()
            && ( $qty >= $this->getQtyItemDiscount() );
    }

    /**
     * @param $price
     * @return float|int
     */
    public function applyItemDiscount($price)
    {
        return $price - ($this->getQtyItemDiscountAmount() * $price) / 100;
    }

    /**
     * @param $cartSubtotal
     * @return bool
     */
    public function amountAppliesToCartDiscount($cartSubtotal)
    {
        return  $this->getIsEnabled()
            && ($cartSubtotal >= $this->getTotalCartAmount());
    }
}
