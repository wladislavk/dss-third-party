module.exports = {
    el: function() {
        return '#vobs'
    },
    data: function() {
        return {
            constants       : window.constants,
            routeParameters : {
                patientId         : null,
                readId            : null,
                unreadId          : null,
                currentPageNumber : 0,
                sortDirection     : '',
                sortColumn        : '',
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
        '$route.query.rid': function() {
            if (this.$route.query.rid > 0) {
                this.$set('routeParameters.readId', this.$route.query.rid);
            }
        },
        '$route.query.urid': function() {
            if (this.$route.query.urid > 0) {
                this.$set('routeParameters.unreadId', this.$route.query.urid);
            }
        },
        '$route.query.viewed': function() {
            if (this.$route.query.viewed) {
                this.$set('routeParameters.viewed', this.$route.query.viewed);
            }
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
        getCurrentDirection: function(sort) {
            if (this.routeParameters.sortColumn == sort || 
                (this.routeParameters.sortColumn == 'p.lastname' && sort == 'patient_name')) {
                return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
            } else {
                return sort === 'patient_name' ? 'asc' : 'desc';
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
        updateVob: function(param, value, id, patientId) {
            this.alterVob(param, value, id, patientId)
                .then(function(response) {
                    this.getVobs();
                }, function(response) {
                    this.handleErrors('alterVob', response);
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

            return this.$http.post(window.config.API_PATH + 'insurance-preauthes/find', data);
        },
        alterVob: function(param, value, id, patientId) {
            var data = {
                param     : param || '',
                value     : value || 0,
                id        : id || 0,
                patientId : patientId || 0
            }

            return this.$http.post(window.config.API_PATH + 'insurance-preauthes/update', data);
        }
    }
}
