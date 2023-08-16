<?php
declare(strict_types=1);

namespace Amper\Discounts\Model\Total\Quote;

use Amper\Discounts\Helper\Data as DiscountsHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Class Custom
 * @package Amper\Discounts\Model\Total\Quote
 */
class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var DiscountsHelper
     */
    protected $discountsHelper;

    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        PriceCurrencyInterface $priceCurrency,
        DiscountsHelper $discountsHelper

    )
    {
        $this->priceCurrency   = $priceCurrency;
        $this->discountsHelper = $discountsHelper;
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        if(!$this->discountsHelper->amountAppliesToCartDiscount($quote->getSubtotal()))
        {
            return $this;
        }

        parent::collect($quote, $shippingAssignment, $total);

        // Discount will be applied based off the subtotal without taking into account the shipping amount.
        $baseDiscount = ( $this->discountsHelper->getTotalCartDiscount() * $quote->getSubtotal()) / 100;

        $discount = $this->priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('customdiscount', -$discount);
        $total->addBaseTotalAmount('customdiscount', -$baseDiscount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);
        $quote->setCustomDiscount(-$discount);

        return $this;
    }
}
