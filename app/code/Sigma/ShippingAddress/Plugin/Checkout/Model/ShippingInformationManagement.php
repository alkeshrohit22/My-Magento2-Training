<?php

namespace Sigma\ShippingAddress\Plugin\Checkout\Model;

use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Quote\Model\QuoteRepository;

class ShippingInformationManagement
{
    /**
     * @param QuoteRepository $quoteRepository
     */
    public function __construct(
        private QuoteRepository $quoteRepository
    )
    {
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        if(!$extAttributes = $addressInformation->getExtensionAttributes()){
            return;
        }

        $quote = $this->quoteRepository->getActive($cartId);

        $quote->setMiddleName($extAttributes->getMiddleName());
    }
}
