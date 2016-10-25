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
            return this.$http.put(window.config.API_PATH + 'contacts/' + contact.contactid, contact);
        },
        insertContact: function(contact) {
            return this.$http.post(window.config.API_PATH + 'contacts', contact);
        },
        getLetterInfoByDocId: function() {
            return this.$http.post(window.config.API_PATH + 'users/letter-info');
        },
        getContactType: function(contactTypeId) {
            return this.$http.get(window.config.API_PATH + 'contact-types/' + contactTypeId);
        },
        getContactTypeWithFilter: function() {
            var data = {
                where: { physician: 1 }
            };

            return this.$http.post(window.config.API_PATH + 'contact-types/with-filter', data);
        },
        getContact: function(contactId) {
            return this.$http.get(window.config.API_PATH + 'contacts/' + contactId);
        },
        getActiveNonCorporateContactTypes: function() {
            return this.$http.post(window.config.API_PATH + 'contact-types/active-non-corporate');
        },
        getActiveQualifiers: function() {
            return this.$http.post(window.config.API_PATH + 'qualifiers/active');
        },
        getPendingVOBsByContactId: function(contactId) {
            var data = { contact_id: contactid };

            return this.$http.post(window.config.API_PATH + 'insurance-preauth/pending-VOB', data);
        }
    }
}
