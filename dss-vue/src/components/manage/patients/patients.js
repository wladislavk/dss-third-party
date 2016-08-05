var handlerMixin = require('../../../modules/handler/HandlerMixin.js');

module.exports = {
    el: function() {
        return '#patients'
    },
    data: function() {
        return {
            patientInfo         : '',
            selectedPatientType : '1',
            letters             : 'A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'.split(','),
            message             : '',
            patientsTotalCount  : 0,
            patientsPerPage     : 30,
            sortDirection       : 'asc',
            currentDirection    : 'asc',
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
    created: function() {

    },
    computed: {
        selectedPatientType: function() {
            if (this.$route.query.sh) {
                var foundOption = this.patientTypeSelect.find(el => el.value == this.$route.query.sh);

                if (foundOption) {
                    return this.$route.query.sh;
                } else {
                    return '1';
                }
            } else {
                return '1';
            }
        }/*,
        currentDirection: function() {
            if () {

            }
        }*/
    },
    methods: {
        onChangePatientTypeSelect: function() {
            this.$route.router.go({
                name  : this.$route.name,
                query : {
                    sh: this.selectedPatientType
                }
            });
        }
    }
}