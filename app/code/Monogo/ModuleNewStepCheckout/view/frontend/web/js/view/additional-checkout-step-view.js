define([
    'ko',
    'uiComponent',
    'underscore',
    'mage/url',
    'mage/storage',
    'Magento_Checkout/js/model/step-navigator'
], function (ko, Component, _, urlBuilder, storage, stepNavigator) {
    'use strict';

    var listaproduktow = [];
    /**
     * mystep - is the name of the component's .html template,
     * <Vendor>_<Module>  - is the name of your module directory.
     */
    return Component.extend({
        defaults: {
            template: 'Monogo_ModuleNewStepCheckout/mystep'
        },
        listaproduktow: ko.observableArray(),
        productUrlId: ko.observable("mycheckout/index/responsejson?id=13"), //only for test fixe id
        // add here your logic to display step,
        isVisible: ko.observable(true),

        /**
         * @returns {*}
         */
        initialize: function () {
            this._super();

            // register your step
            stepNavigator.registerStep(
                // step code will be used as step content id in the component template
                'step_code',
                // step alias
                null,
                // step title value
                'Checkout Products',
                // observable property with logic when display step or hide step
                this.isVisible,

                _.bind(this.navigate, this),

                /**
                 * sort order value
                 * 'sort order value' < 10: step displays before shipping step;
                 * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                 * 'sort order value' > 20 : step displays after payment step
                 */
                15
            );

            return this;
        },

        /**
         * The navigate() method is responsible for navigation between checkout steps
         * during checkout. You can add custom logic, for example some conditions
         * for switching to your custom step
         * When the user navigates to the custom step via url anchor or back button we_must show step manually here
         */
        navigate: function () {
            this.isVisible(true);
        },

        /**
         * @returns void
         */
        navigateToNextStep: function () {
            stepNavigator.next();
        },

        /**
         *
         * @returns {number}
         */
        getTimeTest: function () {
            let t = new Date();
            // return  t.toDateString();
            return t.toLocaleDateString();
        },
        getMainUrl: function(){
          return ['productUrlId', urlBuilder.build('mycheckout/index/responsejson/ ')];
        },
        getProduct: function () {
            var self = this;
            var serviceUrl = urlBuilder.build('mycheckout/index/responsejson/ ');
            return storage.post(
                serviceUrl,
                ''
            ).done(
                function (response) {
                    window.mojeresponse = response;
                    _.map(response, function(num){
                        self.listaproduktow.push(num);
                        console.log('productUrlId: ', serviceUrl);
                    });
                }
            ).fail(
                function (response) {
                    alert(response);
                }
            );
        },

    });
});
