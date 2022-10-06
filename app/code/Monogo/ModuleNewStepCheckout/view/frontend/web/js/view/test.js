define([
    'ko',
    'uiComponent',
    'mage/url',
    'mage/storage',
], function (ko, Component, urlBuilder,storage) {
    'use strict';
    var id=1;

    return Component.extend({

        defaults: {
            template: 'Monogo_ModuleNewStepCheckout/test',
        },

        productList: ko.observableArray([]),

        getProduct: function () {
            var self = this;
            // var serviceUrl = urlBuilder.build('knockout/test/product?id='+id);
            // var serviceUrl = urlBuilder.build('mycheckout/index/responsejson);
            var serviceUrl = 'http://magento.test/mycheckout/index/responsejson';
            id ++;
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    // window.mojeresponse = response;
                    //
                    // _(response).each(function(elem, key){
                    //     console.log(elem);
                    //     console.log(key);
                    //     response[key] = _(elem).values();
                    // });
                    // _.map(response, function(num){ console.log(num); });
                    self.productList.push(response);
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },

    });
});
