<?php

namespace Sigma\FreeShippingBar\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class Freeshipping extends Template
{
    public function __construct(
        Template\Context $context,
        private ScopeConfigInterface $scopeConfig,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    public function isFreeShippingEligible(): bool
    {
        return $this->scopeConfig->isSetFlag('freeshippingbar/general/is_enable', ScopeInterface::SCOPE_STORE);
    }
    public function getFreeShippingAmount(){
        return $this->scopeConfig->getValue('freeshippingbar/general/free_shipping_amount', ScopeInterface::SCOPE_STORE);
    }
}
