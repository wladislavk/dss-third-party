var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    el: function() {
        return '#vobs'
    },
    data: function() {
        return {
            constants       : window.constants,
            routeParameters : {
                patientId         : null,
                currentPageNumber : 0,
                sortDirection     : 'desc',
                sortColumn        : 'status',
                viewed            : null
            },
            totalVobs       : 0,
            vobsPerPage     : 20,
            totalPages      : 0,
            vobs            : [],
            message         : '',
            tableHeaders    : {
                'request_date' : 'Requested',
                'patient_name' : 'Patient Name',
                'status'       : 'Status',
                'comments'     : 'Comments',
                'action'       : 'Action'
            }
        }
    },
    mixins: [handlerMixin],
    watch: {
        '$route.query.page': function() {
            if (this.$route.query.page) {
                if (this.$route.query.page <= this.totalPages) {
                    this.$set('routeParameters.currentPageNumber', this.$route.query.page);
                }
            }
        },
        '$route.query.sort': function() {
            if (this.$route.query.sort) {
                if (this.$route.query.sort in this.tableHeaders) {
                    this.$set('routeParameters.sortColumn', this.$route.query.sort);
                } else {
                    this.$set('routeParameters.sortColumn', null);
                }
            }
        },
        '$route.query.sortdir': function() {
            if (this.$route.query.sortdir) {
                if (this.$route.query.sortdir.toLowerCase() == 'desc') {
                    this.$set('routeParameters.sortDirection', this.$route.query.sortdir.toLowerCase());
                } else {
                    this.$set('routeParameters.sortDirection', 'asc');
                }
            }
        },
        '$route.query.pid': function() {
            if (this.$route.query.pid > 0) {
                this.$set('routeParameters.patientId', this.$route.query.pid);
            } else {
                this.$set('routeParameters.patientId', null);
            }
        },
        '$route.query.viewed': function() {
            this.$set('routeParameters.viewed', this.$route.query.viewed);
        },
        'routeParameters': {
            handler: function() {
                this.getVobs();
            },
            deep: true
        }
    },
    computed: {
        totalPages: function() {
            return this.totalVobs / this.vobsPerPage;
        }
    },
    created: function() {
        this.getVobs();
    },
    methods: {
        setViewStatus: function(vob) {
            var data = { viewed: vob.viewed == 0 ? 1 : 0 };

            this.updateVob(vob.id, data)
                .then(function(response) {
                    this.$route.router.go({
                        name: this.$route.name,
                        query: {
                            pid: vob.patient_id || 0
                        }
                    });

                    var foundVob = this.vobs.find(el => el.id == vob.id);
                    foundVob.viewed = data.viewed;
                }, function(response) {
                    this.handleErrors('updateVob', response);
                });
        },
        getCurrentDirection: function(sort) {
            if (this.routeParameters.sortColumn == sort) {
                return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
            } else {
                return 'asc';
            }
        },
        getVobs: function() {
            this.findVobs(                
                this.vobsPerPage,
                this.routeParameters.currentPageNumber,
                this.routeParameters.sortColumn,
                this.routeParameters.sortDirection,
                this.routeParameters.viewed
            ).then(function(response) {
                var data = response.data.data;

                if (data.result.length) {
                    this.$set('vobs', data.result);
                    this.$set('totalVobs', data.total);
                }
            }, function(response) {
                this.handleErrors('findVobs', response);
            });
        },
        findVobs: function(
            vobsPerPage,
            pageNumber,
            sortColumn,
            sortDir,
            viewed
        ) {
            var data = {
                page        : pageNumber || 0,
                vobsPerPage : vobsPerPage,
                sortColumn  : sortColumn || 'status',
                sortDir     : sortDir || 'desc',
                viewed      : viewed
            }

            return this.$http.post(window.config.API_PATH + 'insurance-preauth/vobs/find', data);
        },
        updateVob: function(id, data) {
            id = id || 0;

            return this.$http.put(window.config.API_PATH + 'insurance-preauth/' + id, data);
        }
    }
}
