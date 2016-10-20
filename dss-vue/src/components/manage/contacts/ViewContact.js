var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    data: function() {
        return {
           contact         : {},
           componentParams : {}
        }
    },
    mixins: [handlerMixin],
    computed: {
        'contact.phone1': function() {
            var phone = this.contact.phone1;
            phone = phone.replace(/[^0-9]/g, '').replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');

            this.$set('contact.phone1', phone);
        }
    },
    events: {
        'setting-component-params': function(parameters) {
            this.componentParams = parameters;

            this.setCurrentContact(this.componentParams.contactId);
        }
    },
    methods: {
        setCurrentContact: function(contactId) {
            this.getContactById(contactId)
                .then(function(response) {
                    var data = response.data.data;

                    if (data) {
                        this.$set('contact', data);
                    }
                }, function(response) {
                    this.handleErrors('getContactById', response);
                });
        },
        getPhysicianContactTypes: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/physician');
        },
        getContactById: function(contactId) {
            var data = { contact_id: contactId };

            return this.$http.post(window.config.API_PATH + 'contacts/with-contact-type', data);
        }
    }
}
