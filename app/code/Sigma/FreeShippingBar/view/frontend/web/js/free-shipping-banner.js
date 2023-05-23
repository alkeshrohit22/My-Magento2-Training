define([
    'uiComponent',
    'knockout',
    'Magento_Customer/js/customer-data',
    'underscore'
], function (
    Component,
    ko,
    customerData,
    _
) {
    'use strict'

    return Component.extend({
        defaults: {
            subTotal: 0.00,
            template: 'Sigma_FreeShippingBar/free-shipping-banner',
            tracks: {
                subTotal: true
            }
        },
        initialize: function () {
            this._super();
            var self = this;
            var cart = customerData.get('cart');

            customerData.getInitCustomerData().done(function () {
                if(!_.isEmpty(cart()) && !_.isUndefined(cart().subtotalAmount)) {
                    self.subTotal = parseFloat(cart().subtotalAmount);
                }
            });

            cart.subscribe(function (cart){
                if(!_.isEmpty(cart) && !_.isUndefined(cart.subtotalAmount)) {
                    self.subTotal = parseFloat(cart.subtotalAmount);
                }
            });

            self.message = ko.computed(function() {

                // subTotal == 0 and undefined then return messageDefault
                if(self.subTotal === 0 || _.isUndefined(self.subTotal) ) {
                    return self.messageDefault;
                }
                // subTotal > 0 and subTotal < 300 then return messageItemInCart
                if(self.subTotal > 0 && self.subTotal < 300) {

                    var freeShipRemainTotal = 300 - self.subTotal;
                    var formattedSubtotalRemain = self.formatCurrency(freeShipRemainTotal);
                    return self.messageItemInCart.replace('{amount}', formattedSubtotalRemain);
                }
                // subTotal > 300 return messageFreeShipping
                if(self.subTotal >= 300) {
                    return self.messageFreeShipping;
                }
            });
            console.log('Free shipping bar component loaded!!!' + this.message);
        },
        formatCurrency: function (value) {
            return '$' + value.toFixed(2);
        }
    });
})
