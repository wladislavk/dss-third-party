module.exports = {
    el: function() {
        return '#vobs'
    },
    data: function() {
        return {
            routeParameters : {
                currentPageNumber   : 0,
                sortDirection       : 'asc',
                sortColumn          : 'requested'
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

            return this.$http.post(window.config.API_PATH + 'insurance-preauth/find', data);
        }
    }
}