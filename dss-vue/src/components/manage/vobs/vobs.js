module.exports = {
    el: function() {
        return '#vobs'
    },
    data: function() {
        return {
            routeParameters : {
                patientId         : null,
                readId            : null,
                unreadId          : null,
                currentPageNumber : 0,
                sortDirection     : 'asc',
                sortColumn        : 'requested',
                viewed            : 0
            },
            vobsTotalNumber : 0,
            vobsPerPage     : 30,
            totalPages      : 0,
            vobs            : [],
            tableHeaders    : {
                'requested'    : 'Requested',
                'patient-name' : 'Patient Name',
                'status'       : 'Status',
                'comments'     : 'Comments',
                'action'       : 'Action'
            }
        }
    },
    watch: {
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
                this.updateVob('viewed', 1, this.routeParameters.readId);
            }
        },
        '$route.query.urid': function() {
            if (this.$route.query.urid > 0) {
                this.$set('routeParameters.unreadId', this.$route.query.urid);
                this.updateVob('viewed', 0, this.routeParameters.unreadId);
            }
        },
        '$route.query.viewed': function() {
            if (this.$route.query.viewed === 1) {
                this.$set('routeParameters.viewed', this.$route.query.viewed);
            } else {
                this.$set('routeParameters.viewed', null);
            }
        }
    },
    created: function() {
        this.getVobs();
    },
    methods: {
        getCurrentDirection: function(sort) {
            if (this.routeParameters.sortColumn == sort) {
                return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
            } else {
                return sort === 'name' ? 'asc': 'desc';
            }
        },
        getVobs: function() {
            this.findVobs(                
                this.vobsPerPage,
                this.routeParameters.currentPageNumber,
                this.routeParameters.sortColumn,
                this.routeParameters.sortDirection
            ).then(function(response) {
                var data = response.data.data;

                var totalCount = data.count[0].total;
                var vobs       = data.results;

                this.$set('vobsTotalNumber', totalCount);
                this.$set('vobs', vobs);
            }, function(response) {
                this.handleErrors('findVobs', response);
            });
        },
        updateVob: function(
            param,
            value,
            id
        ) {
            this.alterVob(                
                param,
                value,
                id,
                this.routeParameters.patientId
            ).then(function(response) {
                var data = response.data.data;
            }, function(response) {
                this.handleErrors('alterVob', response);
            });
        },
        findVobs: function(
            vobsPerPage,
            pageNumber,
            sortColumn,
            sortDir
        ) {
            var data = {
                page        : pageNumber || 0,
                vobsPerPage : vobsPerPage || 0,
                sortColumn  : sortColumn || '',
                sortDir     : sortDir || ''
            }

            return this.$http.post(window.config.API_PATH + 'insurance-preauthes/find', data);
        },
        alterVob: function(
            param,
            value,
            id,
            patientId
        ) {
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