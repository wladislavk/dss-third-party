/**
 * @requires ApiPermissionsFormMixin
 * @requires Events
 */
Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

(function(){
    var apiPath = apiRoot + 'api/v1/api-permission/resource-groups';

    var apiPermissionResourceGroups = new Vue({
        el: '#api-permission-resource-groups',
        mixins: [ApiPermissionsFormMixin],
        data: {
            namespace: 'api:permission:resourceGroups',
            apiPath: apiPath,
            model: {
                id: 0,
                slug: '',
                name: '',
                authorize_per_user: 0,
                authorize_per_patient: 0
            },
            models: []
        },
        methods: {
            resetModel: function () {
                this.model.id = 0;
                this.model.slug = '';
                this.model.name = '';
                this.model.authorize_per_user = 0;
                this.model.authorize_per_patient = 0;
            },
            setModel: function (model) {
                this.model.id = model.id;
                this.model.slug = model.slug;
                this.model.name = model.name;
                this.model.authorize_per_user = model.authorize_per_user;
                this.model.authorize_per_patient = model.authorize_per_patient;
            }
        }
    });
}(jQuery));
