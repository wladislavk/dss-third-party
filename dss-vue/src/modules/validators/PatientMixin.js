module.exports = {
    created: function() {
        // http://stackoverflow.com/a/15829686
        String.prototype.toCamelCase = function() {
            return this.replace(/^([A-Z])|[\s-_](\w)/g, function(match, p1, p2, offset) {
                if (p2) return p2.toUpperCase();
                return p1.toLowerCase();
            });
        };
    },
    methods: {
        walkThroughMessages: function(messages, patient) {
            for (var property in messages) {
                if (messages.hasOwnProperty(property)) {
                    if (trim(patient[property]) == '') {
                        alert(messages[property]);
                        this.$els[property.toCamelCase()].focus();

                        return false;
                    }
                }
            }
        },
        walkThroughComplexMessages: function(messages, patient) {
            for (var property in messages) {
                if (messages.hasOwnProperty(property)) {
                    if (trim(patient[property]) != '' && patient[messages[property].connect_to] == '') {
                        alert(messages[property].message);
                        this.$els[property.toCamelCase()].focus();

                        return false;
                    }
                }
            }
        },
        validatePatientData: function(patient, pressedButtons) {
            var messages = {
                firstname  : 'First Name is Required',
                lastname   : 'Last Name is Required',
                email      : 'Email is Required',
                add1       : 'Address is Required',
                city       : 'City is Required',
                state      : 'State is Required',
                zip        : 'Zip is Required',
                gender     : 'Gender is Required',
                cell_phone : 'Cell phone is Required'
            };

            if (!this.walkThroughMessages(messages, patient)) {
                return false;
            }

            if (trim(formedFullNames.referred_name) != '' && !patient.referred_by) {
                alert('Invalid referred by.');
                this.$els.referredByName.focus();

                return false;
            }

            var date = new Date(patient.dob);
            if (date instanceof Date && !isNaN(date.valueOf())) {
                alert("Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format");
                this.$els.dob.focus();

                return false;
            }

            if (trim(patient.home_phone) == '' && trim(patient.work_phone) == '' && trim(patient.cell_phone) == '') {
                alert("Phone Number is required");

                return false;
            }

            if (patient.p_m_dss_file == 1) {
                messages = {
                    p_m_partyfname : 'Insured Party First Name is a Required Field',
                    p_m_partylname : 'Insured Party Last Name is a Required Field',
                    p_m_relation   : 'Relationship to insured party is a Required Field',
                    ins_dob        : 'Insured Date of Birth is a Required Field',
                    p_m_gender     : 'Insured Gender is a Required Field',
                    p_m_ins_co     : 'Insurance Company is a Required Field',
                    p_m_party      : 'Insurance ID. is a Required Field',
                    p_m_ins_grp    : 'Group # is a Required Field',
                    p_m_ins_type   : 'Insurance Type is a Required Field'
                };

                if (!this.walkThroughMessages(messages, patient)) {
                    return false;
                }

                if (trim(patient.p_m_ins_plan) == '' && patient.p_m_ins_type.value != 1) {
                    alert("Plan Name is a Required Field");
                    this.$els.pMInsPlan.focus();

                    return false;
                }

                if (patient.has_s_m_ins == 'Yes' && patient.s_m_dss_file == 1) {
                    messages = {
                        s_m_partyfname : 'Secondary Insured Party First Name is a Required Field',
                        s_m_partylname : 'Secondary Insured Party Last Name is a Required Field',
                        s_m_relation   : 'Secondary Relationship to insured party is a Required Field',
                        ins2_dob       : 'Secondary Insured Date of Birth is a Required Field',
                        s_m_gender     : 'Secondary Insured Gender is a Required Field',
                        s_m_ins_co     : 'Secondary Insurance Company is a Required Field',
                        s_m_party      : 'Secondary Insurance ID. is a Required Field',
                        s_m_ins_grp    : 'Secondary Group # is a Required Field',
                        s_m_ins_type   : 'Secondary Insurance Type is a Required Field'
                    };

                    if (!this.walkThroughMessages(messages, patient)) {
                        return false;
                    }

                    if (trim(patient.s_m_ins_plan) == "" && patient.p_m_ins_type.value != 1) {
                        alert("Secondary Plan Name is a Required Field");
                        this.$els.sMInsPlan.focus();

                        return false;
                    }
                }

                if (patient.s_m_ins_ass != 'Yes' && patient.s_m_ins_ass != 'No') {
                    alert("You must choose 'Accept Assignment of Benefits' or 'Payment to Patient'");
                    this.$els.sMInsAss.focus();

                    return false;
                }
            }

            if (patient.patientid > 0) {
                messages = {
                    docsleep_name : {
                        connect_to : 'docsleep',
                        message    : 'Invalid sleep md.'
                    },
                    docpcp_name   : {
                        connect_to : 'docpcp',
                        message    : 'Invalid primary care md.'
                    },
                    docdentist_name   : {
                        connect_to : 'docdentist',
                        message    : 'Invalid dentist'
                    },
                    docent_name   : {
                        connect_to : 'docent',
                        message    : 'Invalid ENT.'
                    },
                    docmdother_name   : {
                        connect_to : 'docmdother',
                        message    : 'Invalid other md.'
                    },
                };

                if (!this.walkThroughComplexMessages(messages, patient)) {
                    return false;
                }
            }

            var messageAboutChangingReferredBy = 'The referrer has been updated. Existing pending letters to the referrer may be updated or deleted and previous changes lost. Proceed?';

            if (this.isReferredByChanged && !confirm(messageAboutChangingReferredBy)) {
                return false;
            }

            // if pending VOB make sure insurance hasn't changed
            if (this.pendingVob && this.isInsuranceInfoChanged) {
                if (this.pendingVob.status == window.constants.DSS_PREAUTH_PREAUTH_PENDING) {
                    if(!confirm("Warning! This patient has a Verification of Benefits (VOB) that is currently awaiting pre-authorization from the insurance company. You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?"));
                } else {
                    if (!confirm("Warning! This patient has a pending Verification of Benefits (VOB). You have changed the patient's insurance information. This requires all VOB information to be updated and resubmitted. Do you want to save updated insurance information and resubmit VOB?")) {
                        return false;
                    }
                }
            }

            if (
                pressedButtons && pressedButtons.registration &&
                !confirm(
                    'You are about to send the patient a registration email. \
                    The patient will receive a text message activation code by clicking \
                    a link contained in this email, and the patient can complete his/her \
                    forms online. Are you sure you want to continue?'
                )
            ) {
                return false;
            }

            if (
                pressedButtons && pressedButtons.reminder &&
                !confirm(
                    'You are about to send the patient an email. \
                    Are you sure you want to continue?'
                )
            ) {
                return false;
            }

            if (patient.s_m_dss_file == 1 && patient.p_m_dss_file != 1) {
                alert(this.billingCompany.name + ' must file Primary Insurance in order to file Secondary Insurance.');

                return false;
            }

            if (patient.s_m_ins_type == 1) {
                alert("Warning! It is very rare that Medicare is listed as a patient’s Secondary Insurance.  Please verify that Medicare is the secondary payer for this patient before proceeding.");
            }

            return true;
        },
        validateDate: function(date) {
            var dateObject = new Date(date);
            if (dateObject instanceof Date && !isNaN(dateObject.valueOf())) {
                alert('Invalid Day, Month, or Year range detected. Please correct.');

                return false;
            } else {
                return true;
            }
        }
    }
}
