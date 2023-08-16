<?php
declare(strict_types=1);

namespace Amper\Discounts\Observer;

use Magento\Framework\Event\ObserverInterface;
use Amper\Discounts\Helper\Data as DiscountsHelper;
use Magento\Framework\Event\Observer;

/**
 * Class Cart
 * @package Amper\Discounts\Observer
 */
class Cart implements ObserverInterface
{

    protected $discountsHelper;

    public function __construct(
        DiscountsHelper $discountsHelper
    )
    {
        $this->discountsHelper = $discountsHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(Observer $observer) {

        $item = $observer->getEvent()->getData('quote_item');

        if(  $this->discountsHelper->qtyAppliesItemDiscount( $item->getQty()) )
        {
            $priceWithDiscount = $this->discountsHelper->applyItemDiscount($item->getProduct()->getPrice());

            $item->setOriginalCustomPrice($priceWithDiscount);
            $item->setCustomPrice($priceWithDiscount);
        }
    }
}
