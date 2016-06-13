// JavaScript Document

function is_email(email)
{
	if(!email.match(/^[A-Za-z0-9\._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/))
		return false;
	return true;
}

function trim(inputString) 
{
   // Removes leading and trailing spaces from the passed string. Also removes
   // consecutive spaces and replaces it with one space. If something besides
   // a string is passed in (null, custom object, etc.) then return the input.
   if (typeof inputString != "string") { return inputString; }
   var retValue = inputString;
   var ch = retValue.substring(0, 1);
   while (ch == " ") { // Check for spaces at the beginning of the string
	  retValue = retValue.substring(1, retValue.length);
	  ch = retValue.substring(0, 1);
   }
   ch = retValue.substring(retValue.length-1, retValue.length);
   while (ch == " ") { // Check for spaces at the end of the string
	  retValue = retValue.substring(0, retValue.length-1);
	  ch = retValue.substring(retValue.length-1, retValue.length);
   }
   while (retValue.indexOf("  ") != -1) { // Note that there are two spaces in the string - look for multiple spaces within the string
	  retValue = retValue.substring(0, retValue.indexOf("  ")) + retValue.substring(retValue.indexOf("  ")+1, retValue.length); // Again, there are two spaces in each of the strings
   }
   return retValue; // Return the trimmed string back to the user
} // Ends the "trim" function

function is_date(d)
{
	if(d.search(/^(\d){1,2}[-\/\\](\d){1,2}[-\/\\]\d{4}$/)!=0)
		return false;//Bad Date Format
	var T = d.split(/[-\/]/);
	var M = T[0];
	if(M.substring(0,1) == 0)
	{
		var M = M.substring(1,2);
	}
	var D = T[1];
	if(D.substring(0,1) == 0)
	{
		var D = D.substring(1,2);
	}
	var	Y = T[2];
	return D>0 && (D<=[,31,28,31,30,31,30,31,31,30,31,30,31][M] ||	D==29 && Y%4==0 && (Y%100!=0 || Y%400==0) ) 
}

function isValidCreditCard(type, ccnum) 
{
   if (type == "Visa" || type == "VI") {
      // Visa: length 16, prefix 4, dashes optional.
      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "MasterCard" || type == "MC") {
      // Mastercard: length 16, prefix 51-55, dashes optional.
      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "Discover"  || type == "NO") {
      // Discover: length 16, prefix 6011, dashes optional.
      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "AmEx" || type == "AX") {
      // American Express: length 15, prefix 34 or 37.
      var re = /^3[4,7]\d{13}$/;
   } else if (type == "Diners") {
      // Diners: length 14, prefix 30, 36, or 38.
      var re = /^3[0,6,8]\d{12}$/;
   } else if (type == "Bankcard") {
      // Bankcard: length 16, prefix 5610 dashes optional.
      var re = /^5610-?\d{4}-?\d{4}-?\d{4}$/;
   } else if (type == "JCB") {
      // Bankcard: length 16, prefix 5610 dashes optional.
      var re = /^[3088|3096|3112|3158|3337|3528]\d{12}$/;
   } else if (type == "EnRoute") {
      // Bankcard: length 15, prefix 5610 dashes optional.
      var re = /^[2014|2149]\d{11}$/;
   } else if (type == "Switch") {
      // Bankcard: length 16, prefix 5610 dashes optional.
      var re = /^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/;
   }

   if (!re.test(ccnum)) return false;
   // Checksum ("Mod 10")
   // Add even digits in even length strings or odd digits in odd length strings.
   var checksum = 0;
   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
	  checksum += parseInt(ccnum.charAt(i-1));
   }
   // Analyze odd digits in even length strings or even digits in odd length strings.
   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
	  var digit = parseInt(ccnum.charAt(i-1)) * 2;
	  if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
   }
   if ((checksum % 10) == 0) return true; else return false;
}

function loginabc(fa)
{
	if(trim(fa.username.value) == "" )
	{
		alert("Username is Required");
		fa.username.focus();
		return false;
	}
	if(trim(fa.password.value) == "" )
	{
		alert("Password is Required");
		fa.password.focus();
		return false;
	}
	return true;
}

function passabc(fa)
{
	if(trim(fa.old_pass.value) == "" )
	{
		alert("Old Password is Required");
		fa.old_pass.focus();
		return false;
	}
	if(trim(fa.new_pass.value) == "" )
	{
		alert("New Password is Required");
		fa.new_pass.focus();
		return false;
	}
	if(trim(fa.new_pass.value) != trim(fa.re_pass.value) )
	{
		alert("Re-Enter Password Mismatch");
		fa.re_pass.focus();
		return false;
	}
	return true;
}

function profileabc(fa)
{
	if(trim(fa.username.value) == "" )
	{
		alert("Username is Required");
		fa.username.focus();
		return false;
	}
	if(trim(fa.name.value) == "" )
	{
		alert("Name is Required");
		fa.name.focus();
		return false;
	}
	if(trim(fa.email.value) == "" )
	{
		alert("Email is Required");
		fa.email.focus();
		return false;
	}
	if(! is_email(trim(fa.email.value)))
	{
		alert("Invalid Email Address");
		fa.email.focus();
		return false;
	}
	return true;
}

function ticketabc(fa){
  if(trim(fa.category_id.value) == ""){
        alert("Category is Required")
        fa.category_id.focus();
        return false;
  }
  if(trim(fa.title.value) == ""){
        alert("Title is Required")
        fa.title.focus();
        return false;
  }
  if(trim(fa.body.value) == ""){
        alert("Message is Required")
        fa.body.focus();
        return false;
  }

}


function locationabc(fa){
  if(trim(fa.location.value) == ""){
	alert("Practice location is Required")
	fa.location.focus();
	return false;
  }
  if(trim(fa.name.value) == ""){
        alert("Doctor name is Required")
        fa.name.focus();
        return false;
  }
  if(trim(fa.address.value) == ""){
        alert("Address is Required")
        fa.address.focus();
        return false;
  }
  if(trim(fa.city.value) == ""){
        alert("City is Required")
        fa.city.focus();
        return false;
  }
  if(trim(fa.state.value) == ""){
        alert("State is Required")
        fa.state.focus();
        return false;
  }
  if(trim(fa.zip.value) == ""){
        alert("Zip is Required")
        fa.zip.focus();
        return false;
  }
  if(trim(fa.phone.value) == ""){
        alert("Phone is Required")
        fa.phone.focus();
        return false;
  }
  if(trim(fa.fax.value) == ""){
        alert("Fax is Required")
        fa.fax.focus();
        return false;
  }

}

function mailinglocationabc(fa){
  if(trim(fa.mailing_practice.value) == ""){
        alert("Mailing Practice is Required")
        fa.mailing_practice.focus();
        return false;
  }
  if(trim(fa.mailing_name.value) == ""){
        alert("Mailing Name is Required")
        fa.mailing_name.focus();
        return false;
  }
  if(trim(fa.mailing_address.value) == ""){
        alert("Mailing Address is Required")
        fa.mailing_address.focus();
        return false;
  }
  if(trim(fa.mailing_city.value) == ""){
        alert("Mail City is Required")
        fa.mailing_city.focus();
        return false;
  }
  if(trim(fa.mailing_state.value) == ""){
        alert("Mailing State is Required")
        fa.mailing_state.focus();
        return false;
  }
  if(trim(fa.mailing_zip.value) == ""){
        alert("Mailing Zip is Required")
        fa.mailing_zip.focus();
        return false;
  }
  if(trim(fa.mailing_phone.value) == ""){
        alert("Mailing Phone is Required")
        fa.mailing_phone.focus();
        return false;
  }
  if(trim(fa.mailing_fax.value) == ""){
        alert("Mailing Fax is Required")
        fa.mailing_fax.focus();
        return false;
  }
  return true;
}


function staffabc(fa)
{
	if(trim(fa.username.value) == "" )
	{
		alert("Username is Required");
		fa.username.focus();
		return false;
	}
	if(fa.password && trim(fa.password.value) == "" )
	{
		alert("Password is Required");
		fa.password.focus();
		return false;
	}
	if(trim(fa.name.value) == "" )
	{
		alert("Name is Required");
		fa.name.focus();
		return false;
	}
	if(trim(fa.email.value) != "" )
	{
		if(! is_email(trim(fa.email.value)))
		{
			alert("In-Valid Email ");
			fa.email.focus();
			return false;
		}
	}else{
		alert("Email is Required");
                fa.email.focus();
                return false;
	}
}

function userabc(fa)
{
	if(trim(fa.username.value) == "" )
	{
		alert("Username is Required");
		fa.username.focus();
		return false;
	}
	if(trim(fa.npi.value) == "" )
	{
		alert("NPI Number is Required");
		fa.npi.focus();
		return false;
	}
	if(trim(fa.medicare_npi.value) == "" )
	{
		alert("Medicare NPI Number  is Required");
		fa.medicare_npi.focus();
		return false;
	}
	if(trim(fa.tax_id_or_ssn.value) == "" )
	{
		alert("Tax ID or SSN is Required");
		fa.tax_id_or_ssn.focus();
		return false;
	}
	if(trim(fa.practice.value) == "" )
	{
		alert("Practice is Required");
		fa.practice.focus();
		return false;
	}
	if(trim(fa.password.value) == "" )
	{
		alert("Password is Required");
		fa.password.focus();
		return false;
	}
	if(trim(fa.name.value) == "" )
	{
		alert("Name is Required");
		fa.name.focus();
		return false;
	}
	if(trim(fa.email.value) == "" )
	{
		alert("Email is Required");
		fa.email.focus();
		return false;
	}
	if(trim(fa.address.value) == "" )
	{
		alert("Address is Required");
		fa.address.focus();
		return false;
	}
	if(trim(fa.city.value) == "" )
	{
		alert("City is Required");
		fa.city.focus();
		return false;
	}
	if(trim(fa.state.value) == "" )
	{
		alert("State is Required");
		fa.state.focus();
		return false;
	}
	if(trim(fa.zip.value) == "" )
	{
		alert("Zip is Required");
		fa.zip.focus();
		return false;
	}
	if(trim(fa.phone.value) == "" )
	{
		alert("Phone is Required");
		fa.phone.focus();
		return false;
	}
}
function regabc(fa){
        if(trim(fa.email.value)==""){
                alert("Email is required to send registration email.");
                fa.email.focus();
                return false;
        }
        if(trim(fa.cell_phone.value)==""){
                alert("Cell phone is required to send registration email.");
                fa.cell_phone.focus();
                return false;
        }
	return confirm('You are about to send the patient a registration email. The patient will receive a text message activation code by clicking a link contained in this email, and the patient can complete his/her forms online. Are you sure you want to continue?');
	//return confirm('You are about to send the patient an email. Are you sure you want to continue?');
}

function remabc(fa){
  	return confirm('You are about to send the patient an email. Are you sure you want to continue?');
}

function sendEmail(fa){

  return true;
}


function pinabc(fa)
{
        if(trim(fa.firstname.value) == "" )
        {
                alert("First Name is Required");
                fa.firstname.focus();
                return false;
        }
        if(trim(fa.lastname.value) == "" )
        {
                alert("Last Name is Required");
                fa.lastname.focus();
                return false;
        }
        if(fa.email.value == "")
        {
                alert("Email is Required");
                fa.email.focus();
                return false;
        }
  return true;
}


function patientabc(fa)
{
	if(trim(fa.firstname.value) == "" )
	{
		alert("First Name is Required");
		fa.firstname.focus();
		return false;
	}
	if(trim(fa.lastname.value) == "" )
	{
		alert("Last Name is Required");
		fa.lastname.focus();
		return false;
	}
	if(trim(fa.referredby_name.value) != 'Type referral name' && trim(fa.referredby_name.value) != '' && trim(fa.referred_by.value) == ''){
		alert("Invalid referred by.");
		fa.referredby_name.focus();
		return false;
	}
	if(trim(fa.dob.value) != "" && ! is_date(trim(fa.dob.value)))
	{
		alert("Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format");
		fa.dob.focus();
		return false;
	}
	if( trim(fa.home_phone.value) == "" && trim(fa.work_phone.value) == "" && trim(fa.cell_phone.value) == "" && trim(fa.email.value) == "" )
	{
		alert("Either a Phone Number or Email Address are required");
		fa.home_phone.focus();
		return false;
	}
	if(trim(fa.preferredcontact.value) == "email" && fa.email.value == "")
	{
		alert("Email is Required if Preferred Contact Method is Email");
		fa.email.focus();
		return false;
	}
	if(fa.p_m_dss_file[0].checked)
	{
		if(trim(fa.p_m_partyfname.value) == "") {
			alert("Insured Party First Name is a Required Field");
			fa.p_m_partyfname.focus();
			return false;
		} else if(trim(fa.p_m_partylname.value) == "") {
			alert("Insured Party Last Name is a Required Field");
			fa.p_m_partylname.focus();
			return false;
		} else if(trim(fa.p_m_relation.value) == "") {
			alert("Relationship to insured party is a Required Field");
			fa.p_m_relation.focus();
			return false;
		} else if(trim(fa.ins_dob.value) == "") {
			alert("Insured Date of Birth is a Required Field");
			fa.ins_dob.focus();
			return false;
                } else if(trim(fa.p_m_gender.value) == "") {
                        alert("Insured Gender is a Required Field");
                        fa.p_m_gender.focus();
                        return false;
		} else if(trim(fa.p_m_ins_co.value) == "") {
			alert("Insurance Company is a Required Field");
			fa.p_m_ins_co.focus();
			return false;
		} else if(trim(fa.p_m_party.value) == "") {
			alert("Insurance ID. is a Required Field");
			fa.p_m_party.focus();
			return false;
		} else if(trim(fa.p_m_ins_grp.value) == "") {
			alert("Group # is a Required Field");
			fa.p_m_ins_grp.focus();
			return false;
		} else if(trim(fa.p_m_ins_plan.value) == "" && fa.p_m_ins_type.value != 1) {
			alert("Plan Name is a Required Field");
			fa.p_m_ins_plan.focus();
			return false;
		} else if(trim(fa.p_m_ins_type.value) == "") {
			alert("Insurance Type is a Required Field");
			fa.p_m_ins_type.focus();
			return false;
		} 
        if(fa.s_m_ins[0].checked && fa.s_m_dss_file[0].checked)
        {
                if(trim(fa.s_m_partyfname.value) == "") {
                        alert("Secondary Insured Party First Name is a Required Field");
                        fa.s_m_partyfname.focus();
                        return false;
                } else if(trim(fa.s_m_partylname.value) == "") {
                        alert("Secondary Insured Party Last Name is a Required Field");
                        fa.s_m_partylname.focus();
                        return false;
                } else if(trim(fa.s_m_relation.value) == "") {
                        alert("Secondary Relationship to insured party is a Required Field");
                        fa.s_m_relation.focus();
                        return false;
                } else if(trim(fa.ins2_dob.value) == "") {
                        alert("Secondary Insured Date of Birth is a Required Field");
                        fa.ins2_dob.focus();
                        return false;
                } else if(trim(fa.s_m_gender.value) == "") {
                        alert("Secondary Insured Gender is a Required Field");
                        fa.s_m_gender.focus();
                        return false;
                } else if(trim(fa.s_m_ins_co.value) == "") {
                        alert("Secondary Insurance Company is a Required Field");
                        fa.s_m_ins_co.focus();
                        return false;
                } else if(trim(fa.s_m_party.value) == "") {
                        alert("Secondary Insurance ID. is a Required Field");
                        fa.s_m_party.focus();
                        return false;
                } else if(trim(fa.s_m_ins_grp.value) == "") {
                        alert("Secondary Group # is a Required Field");
                        fa.s_m_ins_grp.focus();
                        return false;
                } else if(trim(fa.s_m_ins_plan.value) == "" && fa.p_m_ins_type.value != 1) {
                        alert("Secondary Plan Name is a Required Field");
                        fa.s_m_ins_plan.focus();
                        return false;
                } else if(trim(fa.s_m_ins_type.value) == "") {
                        alert("Secondary Insurance Type is a Required Field");
                        fa.s_m_ins_type.focus();
		}
	}
		var assignment_selected = false;
		for (i = 0; i < fa.p_m_ins_ass.length; i++) {
			if (fa.p_m_ins_ass[i].checked) {
				assignment_selected = true;
			}
		}
		if (!assignment_selected) {
			alert("You must choose 'Accept Assignment of Benefits' or 'Payment to Patient'");
			fa.p_m_ins_ass_yes.focus();
			return false;
		}
	}	
	if(fa.s_m_ins[0].checked && !(fa.s_m_dss_file[0].checked || fa.s_m_dss_file[1].checked)){
                        alert("Secondary DSS filing insurance is a Required Field");
                        fa.s_m_dss_file[0].focus();
                        return false;
	}
	if(fa.s_m_dss_file[0].checked)
	{
		if(trim(fa.s_m_partyfname.value) == "") {
			alert("Insured Party First Name is a Required Field");
			fa.s_m_partyfname.focus();
			return false;
		} else if(trim(fa.s_m_partylname.value) == "") {
			alert("Insured Party Last Name is a Required Field");
			fa.s_m_partylname.focus();
			return false;
		} else if(trim(fa.s_m_relation.value) == "") {
			alert("Relationship to insured party is a Required Field");
			fa.s_m_relation.focus();
			return false;
		} else if(trim(fa.ins2_dob.value) == "") {
			alert("Insured Date of Birth is a Required Field");
			fa.ins_dob.focus();
			return false;
		} else if(trim(fa.s_m_ins_co.value) == "") {
			alert("Insurance Company is a Required Field");
			fa.s_m_ins_co.focus();
			return false;
		} else if(trim(fa.s_m_party.value) == "") {
			alert("Insurance ID. is a Required Field");
			fa.s_m_party.focus();
			return false;
		} else if(trim(fa.s_m_ins_grp.value) == "") {
			alert("Group # is a Required Field");
			fa.s_m_ins_grp.focus();
			return false;
		} else if(trim(fa.s_m_ins_plan.value) == "") {
			alert("Plan Name is a Required Field");
			fa.s_m_ins_plan.focus();
			return false;
		} else if(trim(fa.s_m_ins_type.value) == "") {
			alert("Insurance Type is a Required Field");
			fa.s_m_ins_type.focus();
			return false;
		}
		var assignment_selected = false;
		for (i = 0; i < fa.s_m_ins_ass.length; i++) {
			if (fa.s_m_ins_ass[i].checked) {
				assignment_selected = true;
			}
		}
		if (!assignment_selected) {
			alert("You must choose 'Accept Assignment of Benefits' or 'Payment to Patient'");
			fa.s_m_ins_ass_yes.focus();
			return false;
		}
	}	
	if(fa.ed.value != ''){
        if(trim(fa.docsleep_name.value) != 'Type contact name' && trim(fa.docsleep_name.value) != '' && trim(fa.docsleep.value) == ''){
                alert("Invalid sleep md.");
                fa.docsleep_name.focus();
                return false;
        }
        if(trim(fa.docpcp_name.value) != 'Type contact name' && trim(fa.docpcp_name.value) != '' && trim(fa.docpcp.value) == ''){
                alert("Invalid primary care md.");
                fa.docpcp_name.focus();
                return false;
        }
        if(trim(fa.docdentist_name.value) != 'Type contact name' && trim(fa.docdentist_name.value) != '' && trim(fa.docdentist.value) == ''){
                alert("Invalid dentist");
                fa.docdentist_name.focus();
                return false;
        }
        if(trim(fa.docent_name.value) != 'Type contact name' && trim(fa.docent_name.value) != '' && trim(fa.docent.value) == ''){
                alert("Invalid ENT.");
                fa.docent_name.focus();
                return false;
        }
        if(trim(fa.docmdother_name.value) != 'Type contact name' && trim(fa.docmdother_name.value) != '' && trim(fa.docmdother.value) == ''){
                alert("Invalid other md.");
                fa.docmdother_name.focus();
                return false;
        }
	}
        return true;
}

function required_info(fa) {
	var errors = [];
	if (trim(fa.email.value) == "" && trim(fa.home_phone.value) == "" && trim(fa.work_phone.value) == "" && trim(fa.cell_phone.value) == "") {
		errors.push("Phone number or email");
	}
	if(trim(fa.add1.value) == "" || trim(fa.city.value) == "" || trim(fa.state.value) == "" || trim(fa.zip.value) == ""){
		errors.push("Address");
	}
	if (trim(fa.dob.value) == ""){
		errors.push("Date of Birth");
	}
	if(trim(fa.gender.value) == "") {
		errors.push("Gender");
	}
	return errors;
}

function patinsabc(fa){
        if(trim(fa.company.value) == "")
        {
                alert("Company is Required");
                fa.company.focus();
                return false;
        }
        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }
        if(trim(fa.phone2.value) == "" && trim(fa.phone1.value) == "" && trim(fa.fax.value)== "")
        {
                alert("Phone or fax required");
                fa.phone1.focus();
                return false;
        }
}
function patcontactabc(fa){
  pt = $('#physician_types').val();
  pta = pt.split(',');
  if(fa.contacttypeid.value==''){
    alert("Contact type is Required");
    return false;
  }

if($.inArray(fa.contacttypeid.value, pta)!=-1){ //physician
        if(trim(fa.salutation.value) == "" )
        {
                alert("Salutation is Required");
                fa.salutation.focus();
                return false;
        }
        if(trim(fa.firstname.value) == "" )
        {
                alert("First Name is Required");
                fa.firstname.focus();
                return false;
        }
        if(trim(fa.lastname.value) == "" )
        {
                alert("Last Name is Required");
                fa.lastname.focus();
                return false;
        }
        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }
        if(trim(fa.phone2.value) == "" && trim(fa.phone1.value) == "" && trim(fa.fax.value)== "")
        {
                alert("Phone or fax required");
                fa.phone1.focus();
                return false;
        }

  }else if(fa.contacttypeid.value != ''){ //other
        if((trim(fa.firstname.value) == "" || trim(fa.lastname.value) == "") && trim(fa.company.value) == "" )
        {
                alert("First Name, Last Name or Company is Required");
                fa.lastname.focus();
                return false;
        }

        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }


  }
}
function contactabc(fa)
{
  pt = $('#physician_types').val();
  pta = pt.split(',');
  if(fa.contacttypeid.value==''){
    alert("Contact type is Required");
    return false;
  }

  if(fa.contacttypeid.value == '11'){ //INSURANCE
        if(trim(fa.company.value) == "")
        {
                alert("Company is Required");
                fa.company.focus();
                return false;
        }
        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }	  
        if(trim(fa.phone2.value) == "" && trim(fa.phone1.value) == "" && trim(fa.fax.value)== "")
        {
                alert("Phone or fax required");
                fa.phone1.focus();
                return false;
        }
  }else if($.inArray(fa.contacttypeid.value, pta)!=-1){ //physician
        if(trim(fa.salutation.value) == "" )
        {
                alert("Salutation is Required");
                fa.salutation.focus();
                return false;
        }
        if(trim(fa.firstname.value) == "" )
        {
                alert("First Name is Required");
                fa.firstname.focus();
                return false;
        }
        if(trim(fa.lastname.value) == "" )
        {
                alert("Last Name is Required");
                fa.lastname.focus();
                return false;
        }
        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }
        if(trim(fa.phone2.value) == "" && trim(fa.phone1.value) == "" && trim(fa.fax.value)== "")
        {
                alert("Phone or fax required");
                fa.phone1.focus();
                return false;
        }

  }else if(fa.contacttypeid.value != ''){ //other
        if((trim(fa.firstname.value) == "" || trim(fa.lastname.value) == "") && trim(fa.company.value) == "" )
        {
                alert("First Name, Last Name or Company is Required");
                fa.lastname.focus();
                return false;
        }

        if(trim(fa.add1.value) == "" )
        {
                alert("Address1 is Required");
                fa.add1.focus();
                return false;
        }
        if(trim(fa.city.value) == "" )
        {
                alert("City is Required");
                fa.city.focus();
                return false;
        }
        if(trim(fa.state.value) == "" )
        {
                alert("State is Required");
                fa.state.focus();
                return false;
        }
        if(trim(fa.zip.value) == "" )
        {
                alert("Zip is Required");
                fa.zip.focus();
                return false;
        }


  }
}
function customlettertemplateabc(fa)
{
        if(trim(fa.name.value) == "" )
        {
                alert("Name is Required");
                fa.name.focus();
                return false;
        }
}
function referredbyabc(fa)
{
	if(trim(fa.firstname.value) == "" )
	{
		alert("First Name is Required");
		fa.firstname.focus();
		return false;
	}
	if(trim(fa.lastname.value) == "" )
	{
		alert("Last Name is Required");
		fa.lastname.focus();
		return false;
	}
	/*if(trim(fa.middlename.value) == "" )
	{
		alert("Middle Name is Required");
		fa.middlename.focus();
		return false;
	}*/
  /*
	if(trim(fa.add1.value) == "" )
	{
		alert("Address1 is Required");
		fa.add1.focus();
		return false;
	}
	if(trim(fa.city.value) == "" )
	{
		alert("City is Required");
		fa.city.focus();
		return false;
	}
	if(trim(fa.state.value) == "" )
	{
		alert("State is Required");
		fa.state.focus();
		return false;
	}
	if(trim(fa.zip.value) == "" )
	{
		alert("Zip is Required");
		fa.zip.focus();
		return false;
	}*/
	if(trim(fa.email.value) != "" )
	{
		if(! is_email(trim(fa.email.value)))
		{
			alert("In-Valid Email");
			fa.email.focus();
			return false;
		}
	}
        if(fa.preferredcontact.value=="email" && trim(fa.email.value)==''){
                alert("An email address must be entered if preferred contact method is email");
                return false;
        }

        if(fa.preferredcontact.value=="fax" && trim(fa.fax.value)==''){
                alert("A fax number must be entered if preferred contact method is fax");
                return false;
        }
		
		if (trim(fa.add1.value) == "" && trim(fa.city.value) == "" && trim(fa.state.value) == "" && trim(fa.zip.value) == "") {
		
			return confirm('Warning! You have not entered an address for this contact. This contact will NOT receive correspondence from DSS. Are you sure you want to save without an address?');
		
		}
	
}

function sleeplababc(fa)
{
	if(trim(fa.company.value) == "" )
	{
		alert("Lab Name is Required");
		fa.company.focus();
		return false;
	}
	/*if(trim(fa.middlename.value) == "" )
	{
		alert("Middle Name is Required");
		fa.middlename.focus();
		return false;
	}*/
	if(trim(fa.add1.value) == "" )
	{
		alert("Address1 is Required");
		fa.add1.focus();
		return false;
	}
	if(trim(fa.city.value) == "" )
	{
		alert("City is Required");
		fa.city.focus();
		return false;
	}
	if(trim(fa.state.value) == "" )
	{
		alert("State is Required");
		fa.state.focus();
		return false;
	}
	if(trim(fa.zip.value) == "" )
	{
		alert("Zip is Required");
		fa.zip.focus();
		return false;
	}
	
	if(trim(fa.email.value) != "" )
	{
		if(! is_email(trim(fa.email.value)))
		{
			alert("In-Valid Email");
			fa.email.focus();
			return false;
		}
	}
}

function customabc(fa)
{
	if(trim(fa.title.value) == "")
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(trim(fa.description.value) == "")
	{
		alert("Description is Required");
		fa.description.focus();
		return false;
	}
}

function selabc(fa)
{
	if(trim(fa.description.value) == "")
	{
		alert("Please select/Enter something to Insert");
		fa.description.focus();
		return false;
	}
}

function ledgerabc(fa)
{
	if(trim(fa.service_date.value) == "")
	{
		alert("Service Date is Required");
		fa.service_date.focus();
		return false;
	}
	
	if(! is_date(trim(fa.service_date.value)))
	{
		alert("Invalid Date Format For Service Date");
		fa.service_date.focus();
		return false;
	}
	
	if(trim(fa.entry_date.value) == "")
	{
		alert("Entry Date is Required");
		fa.entry_date.focus();
		return false;
	}
	
	if(! is_date(trim(fa.entry_date.value)))
	{
		alert("Invalid Date Format for Entry Date");
		fa.entry_date.focus();
		return false;
	}
/*	
	if(trim(fa.transaction_type.value) == "")
	{
		alert("Transaction Type is Required");
		fa.transaction_type.focus();
		return false;
	}
	
	
	if(trim(fa.description.value) == "")
	{
		alert("Description is Required");
		fa.description.focus();
		return false;
	}
	if(trim(fa.transaction_type.value) == 'Entry')
	{
		if(trim(fa.amount.value) == "")
		{
			alert("Amount is Required");
			fa.amount.focus();
			return false;
		}
		
		if(isNaN(trim(fa.amount.value)))
		{
			alert("Only Numbers for Amount.");
			fa.amount.focus();
			return false;
		}
	}
	if(trim(fa.transaction_type.value) == 'Payment')
	{
		if(trim(fa.paid_amount.value) == "")
		{
			alert("Paid Amount is Required");
			fa.paid_amount.focus();
			return false;
		}
		
		if(isNaN(trim(fa.paid_amount.value)))
		{
			alert("Only Numbers for Paid Amount.");
			fa.paid_amount.focus();
			return false;
		}
	}
*/
	if(fa.status.checked && fa.old_status.value==0){
	    if(!confirm('An insurance claim will be generated and filed. Are you sure you want to do this?')){
        	return false;
    	    }
	}
	return true;
}


function addledgerabc(fa)
{
        if(trim(fa.service_date.value) == "")
        {
                alert("Service Date is Required");
                fa.service_date.focus();
                return false;
        }

        if(! is_date(trim(fa.service_date.value)))
        {
                alert("Invalid Date Format For Service Date");
                fa.service_date.focus();
                return false;
        }

        if(trim(fa.entry_date.value) == "")
        {
                alert("Entry Date is Required");
                fa.entry_date.focus();
                return false;
        }

        if(! is_date(trim(fa.entry_date.value)))
        {
                alert("Invalid Date Format for Entry Date");
                fa.entry_date.focus();
                return false;
        }
        if(trim(fa.transaction_type.value) == "0")
        {
                alert("Transaction Type is Required");
                fa.transaction_type.focus();
                return false;
        }
        if(trim(fa.proccode.value) == "0")
        {
                alert("Procedure Code is Required");
                fa.proccode.focus();
                return false;
        }
  return true;
}

function dailyabc(fa)
{
	if(trim(fa.d_mm.value) == '')
	{
		alert("Select Month ");
		fa.d_mm.focus();
		return false;
	}
	
	if(trim(fa.d_dd.value) == '')
	{
		alert("Select Day ");
		fa.d_dd.focus();
		return false;
	}
	
	if(trim(fa.d_yy.value) == '')
	{
		alert("Select Year ");
		fa.d_yy.focus();
		return false;
	}
	
	dd = fa.d_mm.value+'-'+fa.d_dd.value+'-'+fa.d_yy.value
	
	if(! is_date(dd))
	{
		alert("Invalid Date Format for Entry Date");
		fa.d_mm.focus();
		return false;
	}
}

function monthlyabc(fa)
{
	if(trim(fa.d_mm.value) == '')
	{
		alert("Select Month ");
		fa.d_mm.focus();
		return false;
	}
	
	if(trim(fa.d_yy.value) == '')
	{
		alert("Select Year ");
		fa.d_yy.focus();
		return false;
	}
}

var noteclick = '';
$(document).ready(function(){
$("form input[type=submit]").click(function() {
  noteclick = $(this).attr('name');
});
});
function notesabc(fa)
{
	if(trim(fa.notes.value) == '')
	{
		alert("Progress Notes is Required");
		fa.notes.focus();
		return false;
	}
	if(trim(fa.procedure_date.value) == '')
        {
                alert("Procedure Date is Required");
                fa.procedure_date.focus();
                return false;
        }
	if(noteclick=='unsign'){
		return confirm("Warning: A progress note is not considered legally valid until SIGNED. To save your changes and keep the note unsigned (in order to make future changes) click OK. At any time you can sign the note by clicking the \Save Progress Note and SIGN\ button.");
	}else if(noteclick=='unsign_staff'){
		return confirm("Warning: A progress note is not considered legally valid until SIGNED. To save your changes and keep the note unsigned (in order to make future changes) click OK. Administrators can sign the note by clicking the \"Save Progress Note and SIGN\" button.");
	}else if(noteclick=='sign'){
		return confirm("This progress note will become a legally valid part of the patient's chart; no further changes can be made after saving. Proceed?");
	}
}

function patientreportabc(fa)
{
	if(trim(fa.d_mm.value) != '' || trim(fa.d_dd.value) != '' || trim(fa.d_yy.value) != '')
	{
		dd = fa.d_mm.value+'-'+fa.d_dd.value+'-'+fa.d_yy.value
	
		if(! is_date(dd))
		{
			alert("Invalid Date Format for From Date");
			fa.d_mm.focus();
			return false;
		}
	}
	
	if(trim(fa.d_mm1.value) != '' || trim(fa.d_dd1.value) != '' || trim(fa.d_yy1.value) != '')
	{
		dd1 = fa.d_mm1.value+'-'+fa.d_dd1.value+'-'+fa.d_yy1.value
	
		if(! is_date(dd1))
		{
			alert("Invalid Date Format for To Date");
			fa.d_mm1.focus();
			return false;
		}
	}	
}

function formreportabc(fa)
{
	if(trim(fa.d_mm.value) != '' || trim(fa.d_dd.value) != '' || trim(fa.d_yy.value) != '')
	{
		dd = fa.d_mm.value+'-'+fa.d_dd.value+'-'+fa.d_yy.value
	
		if(! is_date(dd))
		{
			alert("Invalid Date Format for From Date");
			fa.d_mm.focus();
			return false;
		}
	}
	
	if(trim(fa.d_mm1.value) != '' || trim(fa.d_dd1.value) != '' || trim(fa.d_yy1.value) != '')
	{
		dd1 = fa.d_mm1.value+'-'+fa.d_dd1.value+'-'+fa.d_yy1.value
	
		if(! is_date(dd1))
		{
			alert("Invalid Date Format for To Date");
			fa.d_mm1.focus();
			return false;
		}
	}	
}

function imageabc(fa)
{
	if(trim(fa.imagetypeid.value) == '')
	{
		alert("Image Type is Required");
		fa.imagetypeid.focus();
		return false;
	}
	
	if(trim(fa.title.value) == '')
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.imagetypeid.value!='0' && trim(fa.image_file.value) == '' && trim(fa.ed.value) == '')
	{
		alert("Image is Required");
		fa.image_file.focus();
		return false;
	}
	document.getElementById('loader').style.display="block";	
}
