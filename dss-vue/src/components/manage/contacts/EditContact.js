var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
            componentParams : {}
        }
    },
    mixins: [handlerMixin],
    events: {
        'setting-component-params': function(parameters) {
            this.componentParams = parameters;
        }
    },
    methods: {
        updateContact: function(contact) {
            return this.$http.
        }
    }
}
