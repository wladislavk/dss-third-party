//CHECK LEDGER PAYMENT SUBMISSION
function validSubmission(f)
{
    returnval = true;
    if(!authShown){
        //CHECK PAYMENT IS ENTERED

        isEmptyPaymentAmount = false;
        isEmptyPaymentDate = false;

        for (var i = 0; i < $('.claims').length; i++) {
            var claim = $($('.claims')[i]);

            if (claim.find('.allowed_amount').val() != '' ||
                claim.find('.ins_paid').val() != '' ||
                claim.find('.deductible').val() != '' ||
                claim.find('.copay').val() != '' ||
                claim.find('.coins').val() != '' ||
                claim.find('.overpaid').val() != '' ||
                claim.find('.followup').val() != '' ||
                claim.find('.note').val() != ''
            ) {
                if (claim.find('.payment_amount').val() == '') {
                    isEmptyPaymentAmount = true;
                    break;
                }

                if (claim.find('.payment_date').val() == '') {
                    isEmptyPaymentDate = true;
                    break;
                }
            }
        }

        if (isEmptyPaymentAmount || isEmptyPaymentDate) {
            alert('Fields "Paid Amount" and "Payment Date" are required for line-items with data entered in other fields.');
            return false;
        }

        allowed = false;
        $('.allowed_amount').each( function(){
            if( $(this).val()!=''){
                allowed = true;
            }

        });

        if( !allowed ){
           returnval = confirm('You did not enter "Amount Allowed". This information is normally listed on the patient\'s EOB.  Proceed anyway?');
        }

        //DISPUTE CLAIM
        if(f.dispute.checked){
            //CHECK IF ALREADY DISPUTED
            if(DISPUTE_OR_SEC_DISPUTE_OR_PATIENT_DISPUTE_OR_SEC_PATIENT_DISPUTE){
                alert('This claim is already under dispute. Please uncheck the "Dispute" box and resubmit. Please contact the DSS Corporate office if you have further questions regarding your dispute.');
                returnval = false;
            }else if(PENDING_OR_SEC_PENDING){
                alert('A pending claim cannot be disputed. You cannot dispute a claim until it has been sent.');
                returnval = false;
            }else if(f.attachment.value ==''){
                alert('A disputed claim must have attachments from insurance company.');
                returnval = false;
            }else if(f.dispute_reason.value == ''){
                alert('You must provide a reason to dispute a claim.');
                returnval = false;
            }else{
                //Dispute valid
            }
            //NO DISPUTE
        }else{
            if(DISPUTE_OR_SEC_DISPUTE_OR_PATIENT_DISPUTE_OR_SEC_PATIENT_DISPUTE){
                if(!confirm("You have posted payment to a claim that is currently under dispute. Do you want to change claim status from Dispute to PAID?")){
                    alert("You can make changes to the claim but they will not affect the already-submitted dispute. Please contact the DSS Corporate office if you have updates to this disputed claim.");
                    returnval =  false;
                }
            }
            //Already status paid
            if(PAID_INSURANCE){
                //VALID
                //PENDING
            }else if(PENDING){
                if(f.payer.value == DSS_TRXN_PAYER_PRIMARY){
                    alert('You listed Primary Insurance as the "Payer" for this transaction. However, the Primary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Primary Insurance. Please choose another Payer.');
                    returnval = false;
                }else if(f.payer.value == DSS_TRXN_PAYER_SECONDARY){
                    alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
                    returnval = false;
                }else if(f.close.checked){
                    alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
                    returnval = false;
                }else{
                    //VALID
                } 
            //SEC PENDING
            }else if(DSS_CLAIM_SEC_PENDING){
                if(f.payer.value == DSS_TRXN_PAYER_PRIMARY && f.close.checked){
                    alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
                    returnval = false;
                }else if(f.payer.value != DSS_TRXN_PAYER_SECONDARY && f.close.checked){
                    alert('You have selected "Pay Claim". However, the pending insurance claim for this transaction has not been submitted and the claim cannot be closed. Payment will be saved and claim status will remain PENDING.');
                    returnval = false;
                }else if(f.payer.value == DSS_TRXN_PAYER_SECONDARY){
                    alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
                    returnval = false;
                }else{

                }
            }else if(DSS_CLAIM_SENT || DSS_CLAIM_EFILE_ACCEPTED){
                if(f.payer.value == DSS_TRXN_PAYER_PRIMARY){
                    if(f.close.checked){
                        if(f.attachment.value =='' && num_pa){
                            if(!confirm('You did not upload an Explanation of Benefits (EOB) to this claim.  It is strongly recommended that you attach an EOB later for record keeping.')){
                                returnval = false;
                            }
                        }
                        //file secondary
                        //VALID
                    }else{
                        if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
                    }
                }else if(f.payer.value == DSS_TRXN_PAYER_SECONDARY){
                    alert('You listed Secondary Insurance as the "Payer" for this transaction. However, the Secondary insurance claim for this transaction has not been sent and therefore "Payer" field cannot be Secondary Insurance. Please choose another Payer.');
                    returnval = false;
                }else{
                    if(f.close.checked){
                        //VALID      
                    }else{
                        if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
                    }
                }
            }else if(DSS_CLAIM_SEC_SENT){
                if(f.close.checked){
                    if(f.attachment.value =='' && num_sa){
                        if(!confirm('A claim must have an EOB attached to close.')) {
                            returnval = false;
                        }
                    }
                    //VALID
                }else{
                    if(!confirm('You did not select the "Close Claim" checkbox. Are you sure you want keep this claim open after submitting this payment?')){ returnval = false; }
                }
            }else{
                //WHAT HAPPENS?
            }
        }
    }
    if(returnval){
        if(user_access){
            return true;
        }else{
            if(!authShown){
                return true; //To bypass auth until figured out
                showAuthBox();
                authShown = true;
                return false;
            }else{
                return true;
            }
        }
    }else{
        return returnval;
    }
}

var authShown = false;

function showAuthBox()
{
    document.getElementById('form_div').style.display = 'none';
    document.getElementById('auth_div').style.display = 'block';
}

function showsubmitbutton()
{
    document.getElementById('linecountbtn').style.display = "none";
    document.getElementById('linecount').style.display = "none";
    document.getElementById('submitbtn').style.display = "block";
    document.getElementById('submitbtn').style.cssFloat = "right";
}

function updateType(payer)
{
    v = payer.value;
    if(v==1 || v==0){
        document.getElementById('payment_type').selectedIndex = 2;
    }else if(v==2){
        document.getElementById('payment_type').selectedIndex = 0;
    }else if(v==3 || v==4){
        document.getElementById('payment_type').selectedIndex = 4;
    }
}