<?php
declare(strict_types=1);
/**
 * @by SwiftOtter, Inc. 7/3/21
 * @website https://swiftotter.com
 **/

namespace Amper\Discounts\Observer;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Event\ObserverInterface;
use Amper\Discounts\Helper\Data as DiscountsHelper;

/**
 * Class Updatecart
 * @package VendorName\Changeprice\Observer
 */
class Updatecart implements ObserverInterface
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var DiscountsHelper
     */
    protected $discountsHelper;


    /**
     * Updatecart constructor.
     * @param CheckoutSession $checkoutSession
     */
    public function __construct (
        CheckoutSession $checkoutSession,
        DiscountsHelper $discountsHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->discountsHelper = $discountsHelper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!$this->discountsHelper->getIsEnabled())
        {
            return;
        }

        $data = $observer->getEvent()->getData('info');

        $convert_data = (array)$data;

        foreach ($convert_data as $itemsdata => $datainfo) {
            foreach ($datainfo as $itemId => $itemInfo) {
                $item = $this->checkoutSession->getQuote()->getItemById($itemId);

                if (!$item) {
                    continue;
                }

                if(  $this->discountsHelper->qtyAppliesItemDiscount( $item->getQty()) ) {
                    $priceWithDiscount = $this->discountsHelper->applyItemDiscount($item->getProduct()->getPrice());

                    $item->setOriginalCustomPrice($priceWithDiscount);
                    $item->setCustomPrice($priceWithDiscount);
                }
            }
        }
    }
}
