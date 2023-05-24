<?php

namespace Sigma\ShippingAddress\Plugin\Checkout\Block;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    /**
     * @param LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        LayoutProcessor $subject,
        array $jsLayout
    ){
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['middle_name'] = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                'customScope' => 'shippingAddress.middle_name',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
                'options' => [],
                'id' => 'middle-name'
            ],
            'dataScope' => 'shippingAddress.middle_name.middle_name',
            'label' => 'Middle Name',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [
                'required-entry' => true
            ],
            'sortOrder' => 25,
            'id' => 'middle-name'
        ];

        return $jsLayout;
    }
}
