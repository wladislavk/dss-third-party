var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
           physicianTypes : '',
           contact        : {}
        }
    },
    mixins: [handlerMixin],
    ready: function() {
        this.getPhysicianContactTypes()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('physicianTypes', data.physician_types);
                }
            }, function(response) {
                this.handleErrors('getPhysicianContactTypes', response);
            });

        this.getContactById()
            .then(function(response) {
                var data = response.data.data;

                if (data) {
                    this.$set('contact', data);
                }
            }, function(response) {
                this.handleErrors('getContactById', response);
            });
    },
    methods: {
        getPhysicianContactTypes: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/physician');
        },
        getContactById: function(contactId) {
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'contacts/with-contact-type', data);
        }
    }
}
