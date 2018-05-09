/**
 * @requires ApiPermissionsFormMixin
 * @requires Events
 * @requires Utils
 */
Vue.http.headers.common['Authorization'] = 'Bearer ' + document.getElementById('dom-api-token').value;

(function(){
    var apiPath = apiRoot + 'api/v1/api-permission/permissions';
    var groupsApiPath = apiRoot + 'api/v1/api-permission/resource-groups';
    var usersApiPath = apiRoot + 'api/v1/users';

    var apiPermissions = new Vue({
        el: '#api-permissions',
        mixins: [ApiPermissionsFormMixin],
        data: {
            namespace: 'api:permission:permissions',
            apiPath: apiPath,
            model: {
                id: 0,
                group_id: 0,
                doc_id: 0,
                patient_id: 0
            },
            models: [],
            groups: [],
            users: []
        },
        computed: {
            filteredUsers: function () {
                var filter = Vue.filter('filterBy'),
                    sort = Vue.filter('orderBy'),
                    filtered;

                filtered = filter(this.users, this.isUserDoctor);
                filtered = sort(filtered, this.sortByFullName);

                return filtered;
            },
            indexedGroups: function () {
                var groups = Utils.plainObject(this.groups),
                    indexed = {}, n;

                for (n = 0; n < groups.length; n++) {
                    indexed[groups[n].id] = groups[n];
                }

                return indexed;
            },
            indexedUsers: function () {
                var users = Utils.plainObject(this.users),
                    indexed = {}, n;

                for (n = 0; n < users.length; n++) {
                    indexed[users[n].userid] = users[n];
                }

                return indexed;
            }
        },
        methods: {
            resetModel: function () {
                this.model.id = 0;
                this.model.group_id = 0;
                this.model.doc_id = 0;
                this.model.patient_id = 0;
            },
            setModel: function (model) {
                this.model.id = model.id;
                this.model.group_id = model.group_id;
                this.model.doc_id = model.doc_id;
                this.model.patient_id = model.patient_id;
            },
            isUserDoctor: function (user) {
                return +user.status === 1 && +user.docid === 0;
            },
            sortByFullName: function (a, b) {
                var fullA = a.last_name + ', ' + a.first_name,
                    fullB = b.last_name + ', ' + b.first_name;

                return fullA.localeCompare(fullB);
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
            loadUsers: function () {
                this.$http
                    .get(usersApiPath)
                    .then(function (response) {
                        var data = this.getResponseData(response);
                        this.$set('users', data.data);
                    }, function () {
                        this.notifyAction('There was an error loading the users list. Please try again in a few minutes.');
                    })
                ;
            },
            loadDependencies: function () {
                this.loadUsers();
                this.loadGroups();
                Events.on('api:permission:resourceGroups:update', this.loadGroups);
            }
        }
    });
}(jQuery));
