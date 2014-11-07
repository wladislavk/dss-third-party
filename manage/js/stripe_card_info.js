function add_cc()
{
    if (manage_staff_value) { 
        alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
        return false;
    }

    if($('.card-number').val()=='' || $('.card-cvc').val()=='' || $('.card-expiry-month').val().length!=2 || $('.card-expiry-year').val().length!=4 || $('.card-name').val()=='' || $('.card-zip').val().length!=5){
        alert('Please enter valid information for all fields');
        return false;
    }

    $('#loader').show();
    $('#payment_proceed_add_buttons').hide();

    $.ajax({
        url: "includes/stripe_token_new.php",
        type: "post",
        data: {
                id: userid, 
                name: user_name, 
                email: email,
                cnumber: $('.card-number').val(),
                cname: $('.card-name').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                cvc: $('.card-cvc').val(),
                zip: $('.card-zip').val(),
                companyid: id, 
                company: name
              },
        success: function(data){
            var r = $.parseJSON(data);
            if (r.error) {
                $('#loader').hide();      
                alert(r.error.message);
                $('#payment_proceed_add_buttons').show();
            } else {
                $('.card-number').val('');
                $('.card-cvc').val('');
                $('.card-expiry-month').val('');
                $('.card-expiry-year').val('');
                window.location = 'manage_profile.php';
            }
        },
        failure: function(data){
            $('#loader').hide();
        }
    });

    return false;
}

function update_cc()
{
    if (manage_staff_value) {
        alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
        return false;
    }

    if($('.card-number').val() == '' || $('.card-cvc').val() == '' || $('.card-expiry-month').val().length != 2 || $('.card-expiry-year').val().length != 4 || $('.card-name').val() == '' || $('.card-zip').val().length != 5) {
        alert('Please enter valid information for all fields');
        return false;
    }

    $('#loader').show();
    $('#payment_proceed_update_buttons').hide();
    $.ajax({
        url: "includes/stripe_token_update.php",
        type: "post",
        data: {
                id: userid, 
                token: cc_id,
                name: user_name, 
                email: email,
                cnumber: $('.card-number').val(),
                cname: $('.card-name').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val(),
                cvc: $('.card-cvc').val(),
                zip: $('.card-zip').val(),
                companyid: id, 
                company: name
              },
        success: function(data){
            var r = $.parseJSON(data);
            if(r.error){
                $('#loader').hide();      
                alert(r.error.message);
                $('#payment_proceed_update_buttons').show();
            } else {
                $('.card-number').val('');
                $('.card-cvc').val('');
                $('.card-expiry-month').val('');
                $('.card-expiry-year').val('');
                window.location = 'manage_profile.php';
            }
        },
        failure: function(data){
            $('#loader').hide();
        }
    });

    return false;
}