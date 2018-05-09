/**
 * @requires ApiPermissionsFormMixin
 * @requires Events
 */
Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

(function(){
    var apiPath = apiRoot + 'api/v1/api-permission/resources';
    var groupsApiPath = apiRoot + 'api/v1/api-permission/resource-groups';

    var apiPermissionResources = new Vue({
        el: '#api-permission-resources',
        mixins: [ApiPermissionsFormMixin],
        data: {
            namespace: 'api:permission:resources',
            apiPath: apiPath,
            model: {
                id: 0,
                group_id: 0,
                slug: '',
                route: ''
            },
            models: [],
            groups: []
        },
        computed: {
            indexedGroups: function () {
                var groups = Utils.plainObject(this.groups),
                    indexed = {}, n;

                for (n = 0; n < groups.length; n++) {
                    indexed[groups[n].id] = groups[n];
                }

                return indexed;
            }
        },
        methods: {
            resetModel: function () {
                this.model.id = 0;
                this.model.group_id = 0;
                this.model.slug = '';
                this.model.route = '';
            },
            setModel: function (model) {
                this.model.id = model.id;
                this.model.group_id = model.group_id;
                this.model.slug = model.slug;
                this.model.route = model.route;
            },
            loadGroups: function () {
                this.$http
                    .get(groupsApiPath)
                    .then(function (response) {
                        var data = this.getResponseData(response);
                        this.$set('groups', data.data);
                    }, function () {
                        this.notifyAction('There was an error loading the group list. Please try again in a few minutes.');
                    })
                ;
            },
            loadDependencies: function () {
                this.loadGroups();
                Events.on('api:permission:resourceGroups:update', this.loadGroups);
            }
        }
    });
}(jQuery));
