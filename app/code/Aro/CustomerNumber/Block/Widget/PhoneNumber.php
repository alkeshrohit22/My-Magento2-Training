<?php

namespace Aro\CustomerNumber\Block\Widget;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\OptionInterface;
use Magento\Customer\Helper\Address;
use Magento\Customer\Model\Options;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template\Context;

class PhoneNumber extends AbstractWidget
{
    const ATTRIBUTE_CODE = 'phone_number';

    /**
     * @return string
     */

    public function __construct(
        Context $context,
        Address $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        private Options $options,
        private AddressMetadataInterface $addressMetadata,
        array $data = [])
    {
        parent::__construct($context,
            $addressHelper,
            $customerMetadata,
            $data
        );
        $this->_isScopePrivate = true;
    }

    /**
     * Initialize block
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('Aro_CustomerNumber::widget/phone-number.phtml');
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->_getAttribute('phone_number') ? (bool)$this->_getAttribute('phone_number')->isVisible() : false;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->_getAttribute('phone_number') ? (bool)$this->_getAttribute('phone_number')->isRequired() : false;
    }

    public function getPhoneNumber()
    {
        return $this->_getData('phone_number');
    }



//    public function setPhoneNumber($number) {
//        $this->phoneNumber = $number;
//        return $this;
//    }

}
