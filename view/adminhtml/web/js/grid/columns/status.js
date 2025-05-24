define([
    'underscore',
    'Magento_Ui/js/grid/columns/select'
], function (_, Select) {
    'use strict';

    return Select.extend({
        defaults: {
            bodyTmpl: "ValeriiKhilinich_LowerPriceSpotted/grid/columns/status",
            classMappings: ['grid-severity-minor','grid-severity-notice', 'grid-severity-critical']
        },

        /**
         * Get appropriate status class for apply styles on cell.
         *
         * @param $row
         * @returns {string}
         */
        getStatusClass: function ($row) {
            return this.classMappings[$row().status];
        }
    });
});
