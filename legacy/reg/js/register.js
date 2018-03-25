//step-by-step wizard

$.validator.addMethod('valueNotEquals', function(value, element, arg){
    return arg != value;
}, 'Value must not equal arg.');

$.validator.addMethod('valueIfNotMedicare', function(value, element, arg){
    if ($('input[name=p_m_ins_type]:checked').val() == 1) {
        return true;
    }

    return arg != value;
}, 'This field is required');

var lga_wizard = {
    init: function(){
        //initialize wizard
        var root = $('#register').fancyscrollable(),
            api = root.fancyscrollable(),
            index = api.getIndex(),
            page = root.find('.page').eq(index),
            pageW = $('#status').outerWidth();

        // Set page width for steps
        // Set minimum height to avoid sections being higher than the current page
        $('.page').css({ width: pageW - 10 });

        //wizard form submit
        $('#register_form').submit(function() {
            return false;
        });

        // adjust height after items have been scrolled
        api.onSeek(function(event, index){
            var page = root.find('.page').eq(index);
            $('#register').animate({ height : page.height() }, 300);
        });

        api.onBeforeSeek(function(event, index) {
            var currentIndex = api.getIndex(),
                page = root.find('.page').eq(currentIndex),
                notValid = false,
                post = null;

            if (currentIndex < index) {
                //class='validate' needs to be added to elements that needs to be validated
                if (currentIndex == 0) {
                    $.ajax({
                        url: 'includes/check_email.php',
                        type: 'post',
                        data: { email: $('#email').val(), id: $('#patientid').val() },
                        async: false,
                        success: function(data){
                            if (data == 'false' || data === false){
                                notValid = true;
                            }
                        }
                    });

                    if ($('#email').val() != $('#oldemail').val()) {
                        if (!confirm(
                            'You have changed your email from ' + $('#oldemail').val() +
                                ' to ' + $('#email').val() + '.\n\nYou will be sent an email reminder of this change.'
                        )) {
                            return false;
                        }
                    }
                }

                page.find('.validate').each(function(){
                    //assign validator to single element
                    validator = $('#register_form').validate({
                        highlight: function(element) {
                            $(element).closest('div').addClass('error');
                        },
                        unhighlight: function(element) {
                            $(element).closest('div').removeClass('error');
                        },
                        rules: {
                            firstname: 'required',
                            lastname: 'required',
                            email: {
                                required: true,
                                email: true,
                                remote: {
                                    url: 'includes/check_email.php',
                                    type: 'post',
                                    async: false,
                                    data: {
                                        email: function() { return $('#email').val(); },
                                        id:  function() { return $('#patientid').val(); }
                                    }
                                }
                            },
                            cell_phone: 'required',
                            add1: 'required',
                            city: 'required',
                            state: 'required',
                            zip: 'required',
                            dob_month: { valueNotEquals: '' },
                            dob_day: { valueNotEquals: '' },
                            dob_year: { valueNotEquals: '' },
                            gender: { valueNotEquals: '' },
                            marital_status: { valueNotEquals: '' },
                            ssn: 'required',
                            preferredcontact: 'required',
                            p_m_relation: 'required',
                            p_m_partyfname: 'required',
                            p_m_partylname: 'required',
                            ins_dob_month: { valueNotEquals: '' },
                            ins_dob_day: { valueNotEquals: '' },
                            ins_dob_year: { valueNotEquals: '' },
                            p_m_ins_medicare: 'required',
                            p_m_ins_company: 'required',
                            p_m_ins_address1: 'required',
                            p_m_ins_city: 'required',
                            p_m_ins_state: 'required',
                            p_m_ins_zip: 'required',
                            p_m_ins_phone: 'required',
                            p_m_ins_id: 'required',
                            p_m_ins_grp: { valueIfNotMedicare: '' },
                            p_m_ins_plan: 'required',
                            has_p_m_ins: 'required',
                            has_s_m_ins: 'required',
                            s_m_relation: 'required',
                            s_m_partyfname: 'required',
                            s_m_partylname: 'required',
                            ins2_dob_month: { valueNotEquals: '' },
                            ins2_dob_day: { valueNotEquals: '' },
                            ins2_dob_year: { valueNotEquals: '' },
                            s_m_ins_company: 'required',
                            s_m_ins_address1: 'required',
                            s_m_ins_city: 'required',
                            s_m_ins_state: 'required',
                            s_m_ins_zip: 'required',
                            s_m_ins_phone: 'required',
                            s_m_ins_id: 'required',
                            s_m_ins_grp: 'required',
                            s_m_ins_plan: 'required'
                        },
                        errorPlacement: function(error, element) {
                            error.appendTo(element.parent());
                        },
                        messages: {
                            firstname: 'This field is required',
                            lastname: 'This field is required',
                            email: {
                                required: 'This field is required',
                                remote: 'Error: The email address you have entered is either invalid or already in use. Please enter a different email address.',
                                email: 'The field requires a valid email address'
                            },
                            cell_phone: 'Cell phone required for security verification.',
                            add1: 'This field is required',
                            city: 'This field is required',
                            state: 'This field is required',
                            zip: 'This field is required',
                            dob_month: { valueNotEquals: 'Please enter month' },
                            dob_day: { valueNotEquals: 'Please enter day' },
                            dob_year: { valueNotEquals: 'Please enter year' },
                            gender: { valueNotEquals: 'Please select gender' },
                            marital_status: { valueNotEquals: 'Please select marital status' },
                            ssn: 'This field is required',
                            preferredcontact: 'This field is required',
                            p_m_relation: 'This field is required',
                            p_m_partyfname: 'This field is required',
                            p_m_partylname: 'This field is required',
                            ins_dob_month: { valueNotEquals: 'This field is required' },
                            ins_dob_day: { valueNotEquals: 'This field is required' },
                            ins_dob_year: { valueNotEquals: 'This field is required' },
                            p_m_ins_company: 'This field is required',
                            p_m_ins_address1: 'This field is required',
                            p_m_ins_city: 'This field is required',
                            p_m_ins_state: 'This field is required',
                            p_m_ins_zip: 'This field is required',
                            p_m_ins_phone: 'This field is required',
                            p_m_ins_id: 'This field is required',
                            p_m_ins_grp: { valueIfNotMedicare: 'This field is required' },
                            p_m_ins_plan: 'This field is required',
                            s_m_relation: 'This field is required',
                            s_m_partyfname: 'This field is required',
                            s_m_partylname: 'This field is required',
                            ins2_dob_month: { valueNotEquals: 'This field is required' },
                            ins2_dob_day: { valueNotEquals: 'This field is required' },
                            ins2_dob_year: { valueNotEquals: 'This field is required' },
                            s_m_ins_company: 'This field is required',
                            s_m_ins_address1: 'This field is required',
                            s_m_ins_city: 'This field is required',
                            s_m_ins_state: 'This field is required',
                            s_m_ins_zip: 'This field is required',
                            s_m_ins_phone: 'This field is required',
                            s_m_ins_id: 'This field is required',
                            s_m_ins_grp: 'This field is required',
                            s_m_ins_plan: 'This field is required'
                        }
                    }).element($(this));

                    if (validator == false) {
                        notValid = true;
                    }
                });

                if (currentIndex == 1) {
                    if ($('#dob_day').val() == '' || $('#dob_month').val() == '' || $('#dob_year').val() == '') {
                        $('#dob_div').addClass('error');
                    } else {
                        $('#dob_div').removeClass('error');
                    }
                } else if (currentIndex == 2) {
                    if ($('#ins_dob_day').val() == '' || $('#ins_dob_month').val() == '' || $('#ins_dob_year').val() == '') {
                        $('#ins_dob_div').addClass('error');
                    } else {
                        $('#ins_dob_div').removeClass('error');
                    }
                } else if (currentIndex == 3) {
                    if ($('#ins2_dob_day').val() == '' || $('#ins2_dob_month').val() == '' || $('#ins2_dob_year').val() == '') {
                        $('#ins2_dob_div').addClass('error');
                    } else {
                        $('#ins2_dob_div').removeClass('error');
                    }
                }

                if (notValid) {
                    $('#register').animate({ height : page.height() }, 300);
                    return false;
                }
            }

            if (currentIndex) {
                $('#last_reg_sect').val(currentIndex);
            }

            post = $('#register_form').serializeObject();

            $.post('helpers/register_submit.php', post, function(data) {
                try {
                    var r = $.parseJSON(data);

                    if (r.p_m_patient_insuranceid) {
                        $('#p_m_patient_insuranceid').val(r.p_m_patient_insuranceid);
                    } else if (r.s_m_patient_insuranceid) {
                        $('#s_m_patient_insuranceid').val(r.s_m_patient_insuranceid);
                    }

                    if (r.pc_1_patient_contactid) {
                        $('#pc_1_patient_contactid').val(r.pc_1_patient_contactid);
                    }

                    if (r.pc_2_patient_contactid) {
                        $('#pc_2_patient_contactid').val(r.pc_2_patient_contactid);
                    }

                    if (r.pc_3_patient_contactid) {
                        $('#pc_3_patient_contactid').val(r.pc_3_patient_contactid);
                    }

                    if (r.pc_4_patient_contactid) {
                        $('#pc_4_patient_contactid').val(r.pc_4_patient_contactid);
                    }

                    if (r.pc_5_patient_contactid) {
                        $('#pc_5_patient_contactid').val(r.pc_5_patient_contactid);
                    }
                } catch (exception) {}
            });

            $('#status li').removeClass('active').eq(index).addClass('active filed');
            $('#status li.active').prev('li').addClass('filed');

            // Hide current page
            window.scroll(0, 0);
        });

        // if tab is pressed on the next button seek to next page
        root.find('a.next,button.next').keydown(function(e) {
            if (e.keyCode == 9) {
                // seeks to next tab by executing our validation routine
                api.next();
                e.preventDefault();
            }
        });

        root.find('a.next2,button.next2').click(function(e) {
            api.move(2);
        });

        root.find('a.prev2,button.prev2').click(function(e) {
            api.move(-2);
        });

        root.find('a.next3,button.next3').click(function(e) {
            api.move(3);
        });

        root.find('a.prev3,button.prev3').click(function(e) {
            api.move(-3);
        });

        //disable enter key for wizard
        //Bind this keypress function to all of the input tags
        root.find('input').keypress(function (evt) {
            //Deterime where our character code is coming from within the event
            var charCode = evt.charCode || evt.keyCode;

            if (charCode  == 13) { //Enter key's keycode
                return false;
            }
        });

        api.move($('#last_reg_sect').val());
    }
};

function updateNext (value, index) {
    if (index == 1) {
        var secondary = $('input:radio[name=has_s_m_ins]:checked').val();

        if (value == 'Yes') {
            $('#ins1Next1').show();
            $('#ins1Next3').hide();

            if (secondary == 'Yes') {
                $('#insPrev1').show();
                $('#insPrev2').hide();
                $('#insPrev3').hide();
            } else {
                $('#insPrev1').hide();
                $('#insPrev2').show();
                $('#insPrev3').hide();
            }
        } else {
            $('#ins1Next1').hide();
            $('#ins1Next3').show();
            $('#insPrev1').hide();
            $('#insPrev2').hide();
            $('#insPrev3').show();
        }
    } else if (index == 2) {
        if (value == 'Yes') {
            $('#ins2Next1').show();
            $('#ins2Next2').hide();
            $('#insPrev1').show();
            $('#insPrev2').hide();
            $('#insPrev3').hide();
        } else {
            $('#ins2Next1').hide();
            $('#ins2Next2').show();
            $('#insPrev1').hide();
            $('#insPrev2').show();
            $('#insPrev3').hide();
        }
    }
}

$(document).ready(function(){
    $('input[name="p_m_ins_type"]').bind('click', updateDescription);

    $('#p_m_ins_type_1').click(function(){
        $('#p_m_ins_grp').val('NONE');
    });
});

function updateDescription () {
    if ($(this).val() == '1') {
        $('#p_m_ins_description').html(
            'Please complete the information below for the PRIMARY INSURED PARTY listed on your MEDICARE insurance card.'
        );
    } else {
        $('#p_m_ins_description').html(
            'Please complete the information below for the PRIMARY INSURED PARTY listed on your insurance card.'
        );
    }
}

function createPassword () {
    var e = $('#email').val(),
        c = $('#code').val(),
        p1 = $('#password1').val(),
        p2 = $('#password2').val(),
        agreement = $('#agreement').is(':checked');

    if (p1.length < 8) {
        $('#first2_error').html("Password must be at least 8 characters in length.").show('slow');
    } else if (!agreement) {
        $('#first2_error').html("User Agreement must be accepted.").show('slow');
    } else if (p1 == p2) {
        $.ajax({
            url: 'includes/setup_user.php',
            type: 'post',
            data: { email: e, code: c, p: p1 },
            success: function(data){
                var r = $.parseJSON(data);

                if (r.success) {
                    window.location = "register.php";
                } else {
                    if (r.error == "code") {
                        $('#sent_text').html("Incorrect text message code!").show('slow');
                    } else {
                        $('#sent_text').html("Error.").show('slow');
                    }
                }
            },
            error: function(){
                $('#sent_text').html("There was an error retrieving the response from the server. Please notify the system admin and try again later.").show('slow');
            }
        });
    } else {
        $('#sent_text').html("Passwords don't match!").show('slow');
    }

}

function setValidClass (selector, valid) {
    if (valid === 'reset') {
        $(selector)
            .removeClass('pass_valid')
            .removeClass('pass_invalid');
        return;
    }

    if (valid) {
        $(selector)
            .addClass('pass_valid')
            .removeClass('pass_invalid');
        return;
    }

    $(selector)
        .addClass('pass_invalid')
        .removeClass('pass_valid');
}

function checkPass () {
    var p1 = $('#password1').val() || '',
        p2 = $('#password2').val() || '';

    setValidClass('#password1', p1.length < 8);

    if (p1 != '' || p2 != '') {
        setValidClass('#password2', p1 == p2);
    } else {
        setValidClass('#password2', 'reset');
    }
}
