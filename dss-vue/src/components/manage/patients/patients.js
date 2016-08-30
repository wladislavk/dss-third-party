var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    el: function() {
        return '#patients'
    },
    data: function() {
        return {
            constants           : window.constants,
            patientInfo         : '',
            routeParameters     : {
                patientId           : null,
                currentPageNumber   : 0,
                sortDirection       : 'asc',
                selectedPatientType : '1',
                sortColumn          : 'name',
                currentLetter       : null
            },
            letters             : 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
            message             : '',
            patientsTotalNumber : 0,
            patientsPerPage     : 30,
            totalPages          : 0,
            patientTypeSelect   : [
                { text: 'Active Patients', value: '1' },
                { text: 'All Patients', value: '2' },
                { text: 'In-active Patients', value: '3' }
            ],
            patients            : [],
            tableHeaders        : {
                'name'            : 'Name',
                'tx'              : 'Ready for Tx',
                'next-visit'      : 'Next Visit',
                'last-visit'      : 'Last Visit',
                'last-treatment'  : 'Last Treatment',
                'appliance'       : 'Appliance',
                'appliance-since' : 'Appliance Since',
                'vob'             : 'VOB',
                'rx-lomn'         : 'Rx./L.O.M.N.',
                'ledger'          : 'Ledger'
            },
            segments            : [
                '', 'Initial Contact', 'Consult', 'Sleep Study',
                'Impressions', 'Delaying Tx / Waiting', 'Refused Treatment',
                'Device Delivery', 'Check / Follow Up', 'Pt. Non-Compliant',
                'Home Sleep Test', 'Treatment Complete', 'Annual Recall',
                'Termination', 'Not a Candidate', 'Baseline Sleep Test',
            ]
        }
    },
    mixins: [handlerMixin],
    watch: {
        '$route.query.sh': function() {
            if (this.$route.query.sh) {
                var foundOption = this.patientTypeSelect.find(el => el.value == this.$route.query.sh);

                if (foundOption) {
                    this.$set('routeParameters.selectedPatientType', this.$route.query.sh);
                } else {
                    this.$set('routeParameters.selectedPatientType', 1);
                }
            }
        },
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
        '$route.query.letter': function() {
            if (this.letters.indexOf(this.$route.query.letter) > -1) {
                this.$set('routeParameters.currentLetter', this.$route.query.letter);
            } else {
                this.$set('routeParameters.currentLetter', null);
            }
        },
        '$route.query.delid': function() {
            if (this.$route.query.delid > 0) {
                this.onDeletePatient(this.$route.query.delid);
            }
        },
        'routeParameters': {
            handler: function() {
                this.getPatients();
            },
            deep: true
        }
    },
    computed: {
        totalPages: function() {
            return this.patientsTotalNumber / this.patientsPerPage;
        }
    },
    created: function() {
        this.getPatients();
    },
    methods: {
        onChangePatientTypeSelect: function() {
            this.$route.router.go({
                name  : this.$route.name,
                query : {
                    sh: this.routeParameters.selectedPatientType
                }
            });
        },
        onDeletePatient: function(patientId) {
            this.deletePatient(patientId)
                .then(function(response) {
                    this.$set('message', 'Deleted Successfully');
                }, function(response) {
                    this.handleErrors('deletePatient', response);
                });
        },
        getRxLomn: function(value) {
            var title = '';

            switch (+value) {
                case 3:
                    title = 'Yes';
                    break;
                case 2:
                    title = 'Yes/No';
                    break;
                case 1:
                    title = 'No/Yes';
                    break;
                default:
                    title = 'No';
                    break;
            }

            return title;
        },
        formatLedger: function(value) {
            return accounting.formatMoney(value, '$');
        },
        checkIfThisWeek: function(value) {
            var totalDays = moment(value).diff(moment(), 'days');
            var negative  = (moment(value) - moment()) < 0;

            if (totalDays >= 0 && $totalDays <= 7 && !negative) {
                return true;
            } else {
                return false;
            }
        },
        isNegativeTime: function(value) {
            return (moment(value) - moment()) < 0;
        },
        readyForTx: function(insuranceNoError, numSleepStudy) {
            return +insuranceNoError && numSleepStudy != 0;
        },
        getCurrentDirection: function(sort) {
            if (this.routeParameters.sortColumn == sort) {
                return this.routeParameters.sortDirection.toLowerCase() === 'asc' ? 'desc' : 'asc';
            } else {
                return sort === 'name' ? 'asc': 'desc';
            }
        },
        getPatients: function() {
            this.findPatients(
                this.routeParameters.patientId,
                this.routeParameters.selectedPatientType,
                this.routeParameters.currentPageNumber,
                this.patientsPerPage,
                this.routeParameters.currentLetter,
                this.routeParameters.sortColumn,
                this.routeParameters.sortDirection
            ).then(function(response) {
                    var data = response.data.data;

                    var totalCount = data.count[0].total;
                    var patients   = data.results;

                    this.$set('patientsTotalNumber', totalCount);
                    this.$set('patients', patients);
                }, function(response) {
                    this.handleErrors('findPatients', response);
                });
        },
        deletePatient: function(patientId) {
            patientId = patientId || 0;

            return this.$http.delete(window.config.API_PATH + 'patients-by-doctor/' + patientId);
        },
        findPatients: function(
            patientId,
            type,
            pageNumber,
            patientsPerPage,
            letter,
            sortColumn,
            sortDir
        ) {
            var data = {
                patientId       : patientId || 0,
                type            : type || 0,
                page            : pageNumber || 0,
                patientsPerPage : patientsPerPage || 0,
                letter          : letter || '',
                sortColumn      : sortColumn || '',
                sortDir         : sortDir || ''
            }

            return this.$http.post(window.config.API_PATH + 'patients/find', data);
        }
    }
}