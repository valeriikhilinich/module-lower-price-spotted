define([
    "jquery",
    "mage/translate",
    "uiComponent",
    "Magento_Ui/js/model/messageList",
], function ($, $t, Component, messageContainer) {
    "use strict";

    return Component.extend({
        defaults: {
            selectedSource: "url", // Possible values: url or description
            submitUrl: "",

            tracks: {
                selectedSource: true
            }
        },

        /**
         * @param form
         */
        submitForm: function (form) {
            const $form = $(form);

            if (!$form.valid()) {
                return;
            }

            this._sendRequest($form.serialize())
                .done(function ({ success }) {
                    if (success) {
                        $form[0].reset()
                        window.scrollTo(0, 0)
                    }
                })
        },

        /**
         * @private
         */
        _sendRequest: function (data) {
            return $.ajax({
                type: 'POST',
                url: this.submitUrl,
                data,
                dataType: 'json',
                showLoader: true
            }).fail(function () {
                messageContainer.addErrorMessage({
                    message: $t('Something went wrong while sending the request.')
                })
            })
        }
    })
});
