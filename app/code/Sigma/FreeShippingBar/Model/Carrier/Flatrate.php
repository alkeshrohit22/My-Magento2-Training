<?php

namespace Sigma\FreeShippingBar\Model\Carrier;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\OfflineShipping\Model\Carrier\Flatrate as FlatrateAlias;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Rate\ResultFactory;
use Magento\Store\Model\ScopeInterface;
use Psr\Log\LoggerInterface;

class Flatrate extends FlatrateAlias
{

    const THRESHOLD_VALUE_PATH = 'freeshippingbar/general/free_shipping_amount';

    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private ErrorFactory $rateErrorFactory,
        private LoggerInterface $logger,
        private ResultFactory $rateResultFactory,
        private MethodFactory $rateMethodFactory,
        private FlatrateAlias\ItemPriceCalculator $itemPriceCalculator,
        array $data = []
    )
    {
        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $rateResultFactory,
            $rateMethodFactory,
            $itemPriceCalculator,
            $data
        );
    }

    public function collectRates(RateRequest $request)
    {
        $result = parent::collectRates($request);

        $storeScope = ScopeInterface::SCOPE_STORE;

        $thresholdPrice = $this->scopeConfig->getValue(self::THRESHOLD_VALUE_PATH, $storeScope);

        $orderPrice = $request->getBaseSubtotalInclTax();

        if ($orderPrice >= $thresholdPrice) {
            foreach ($result->getAllRates() as $rate) {
                $rate->setPrice(0);
            }
        }

        return $result;
    }
}
