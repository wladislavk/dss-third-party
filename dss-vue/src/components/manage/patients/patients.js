var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    el: function() {
        return '#patients'
    },
    data: function() {
        return {
            constants           : window.constants,
            patientInfo         : '',
            selectedPatientType : '1',
            letters             : 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
            message             : '',
            patientsPerPage     : 30,
            totalPages          : 0,
            currentPageNumber   : 0,
            sortDirection       : 'asc',
            currentDirection    : 'asc',
            sortColumn          : '',
            patientId           : 0,
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
                    this.$set('selectedPatientType', this.$route.query.sh);
                } else {
                    this.$set('selectedPatientType', 1);
                }
            } else {
                this.$set('selectedPatientType', 1);
            }
        },
        '$route.query.page': function() {
            if (this.$route.query.page) {
                if (this.$route.query.page <= totalPages) {
                    this.$set('currentPageNumber', this.$route.query.page);
                }
            }
        },
        '$route.query.sort': function() {
            if (this.$route.query.sort) {
                if (this.$route.query.sort in tableHeaders) {
                    this.$set('sortColumn', this.$route.query.sort);
                }
            }
        },
        '$route.query.sortdir': function() {
            if (this.$route.query.sortdir) {
                if (this.$route.query.sortdir.toLowerCase() == 'desc') {
                    this.$set('sortDirection', this.$route.query.sortdir.toLowerCase());
                } else {
                    this.$set('sortDirection', 'asc');
                }
            }
        }
    },
    computed: {
        totalPages: function() {
            return this.patients.length / this.patientsPerPage;
        }
        /*,
        currentDirection: function() {
            if () {

            }
        }*/
    },
    created: function() {
        this.getPatients();
    },
    methods: {
        onChangePatientTypeSelect: function() {
            this.$route.router.go({
                name  : this.$route.name,
                query : {
                    sh: this.selectedPatientType
                }
            });
        },
        onClickDeletePatient: function(patientId) {
            this.deletePatient(patientId)
                .then(function(response) {
                    this.$set('message', 'Deleted Successfully');
                }, function(response) {
                    this.handleErrors('deletePatient', response);
                });
        },
        getRxLomn: function(value) {
            var title = '';

            switch (value) {
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
        getPatients: function() {
            this.findPatients()
                .then(function(response) {
                    var data = response.data.data;

                    var totalCount = data.count[0].total;
                    var patients   = data.results;

                    this.$set('patients', patients);
                }, function(response) {
                    this.handleErrors('findPatients', response);
                });
        },
        deletePatient: function(patientId) {
            patientId = patientId || 0;

            return this.$http.delete(window.config.API_PATH + 'patients/' + patientId);
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
                pageNumber      : pageNumber || 0,
                patientsPerPage : patientsPerPage || 0,
                letter          : letter || '',
                sortColumn      : sortColumn || '',
                sortDir         : sortDir || ''
            }

            return this.$http.post(window.config.API_PATH + 'patients/find', data);
        }
    }
}