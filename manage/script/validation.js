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

<!--
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

function staffabc(fa)
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
	/*if(trim(fa.middlename.value) == "" )
	{
		alert("Middle Name is Required");
		fa.middlename.focus();
		return false;
	}*/
	/*if(trim(fa.salutation.value) == "" )
	{
		alert("Salutation is Required");
		fa.salutation.focus();
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
	}
	if(trim(fa.dob.value) == "" )
	{
		alert("Birthday is Required");
		fa.dob.focus();
		return false;
	}*/
	if(trim(fa.dob.value) != "" && ! is_date(trim(fa.dob.value)))
	{
		alert("Invalid Date Format For Birthday. (mm/dd/YYYY) is valid format");
		fa.dob.focus();
		return false;
	}/*
	if(trim(fa.gender.value) == "" )
	{
		alert("Gender is Required");
		fa.gender.focus();
		return false;
	}*/
	if( trim(fa.home_phone.value) == "" && trim(fa.work_phone.value) == "" && trim(fa.cell_phone.value) == "" && trim(fa.email.value) == "" )
	{
		alert("Either a Phone Number or Email Address are required");
		fa.home_phone.focus();
		return false;
	}

	/*if(trim(fa.home_phone.value) == "" )
	{
		alert("Home Phone Number is Required");
		fa.home_phone.focus();
		return false;
	}*/
	if(trim(fa.preferredcontact.value) == "email" && fa.email.value == "")
	{
		alert("Email is Required if Preferred Contact Method is Email");
		fa.email.focus();
		return false;
	}
	/*if(trim(fa.marital_status.value) == "" )
	{
		alert("Marital Status is Required");
		fa.marital_status.focus();
		return false;
	}*/
	/*if(trim(fa.ssn.value) == "" )
	{
		alert("Patient's Soc Sec No. is Required");
		fa.ssn.focus();
		return false;
	}*/
	
	/*if(trim(fa.email.value) != "" )
	{
		if(! is_email(trim(fa.email.value)))
		{
			alert("In-Valid Email");
			fa.email.focus();
			return false;
		}
	}*/
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
			fa.ins2_dob.focus();
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
		} else if(trim(fa.p_m_ins_plan.value) == "") {
			alert("Plan Name is a Required Field");
			fa.p_m_ins_plan.focus();
			return false;
		} else if(trim(fa.p_m_ins_type.value) == "Select Type") {
			alert("Insurance Type is a Required Field");
			fa.p_m_ins_type.focus();
			return false;
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
		} else if(trim(fa.s_m_ins_type.value) == "Select Type") {
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
        return true;
}

function required_info(fa) {
	if (trim(fa.home_phone.value) != "" || trim(fa.work_phone.value) != "" || trim(fa.cell_phone.value) != "") {
		var patientphone = true;
	}
  if (fa.email.value != "") {
		var patientemail = true;
	}
	if ((patientemail || patientphone) && trim(fa.add1.value) != "" && trim(fa.city.value) != "" && trim(fa.state.value) != "" && trim(fa.zip.value) != "" && trim(fa.dob.value) != "" && trim(fa.gender.value) != "") {
		return true;
	}
	return false;
}

function contactabc(fa)
{
	if(fa.contact_type.value != 'ins'){
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
	}
	/*if(trim(fa.middlename.value) == "" )
	{
		alert("Middle Name is Required");
		fa.middlename.focus();
		return false;
	}*/
        if(trim(fa.company.value) == "" && fa.contact_type.value == 'ins')
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
	
	if(trim(fa.email.value) != "" )
	{
		if(! is_email(trim(fa.email.value)))
		{
			alert("In-Valid Email");
			fa.email.focus();
			return false;
		}
	}
	if(trim(fa.contacttypeid.value) == ""){
		alert("Contact type is Required");
		fa.contacttypeid.focus();
		return false;
	}
	if(trim(fa.contacttypeid.value) == "11" && trim(fa.phone1.value) == "")
	{
		alert("Phone number is a required field for Insurance Companies");
		fa.phone1.focus();
		return false;
	}

	if(fa.preferredcontact.value=="email" && trim(fa.email.value)==''){
		alert("An email address must be entered if preferred contact method is email");
		return false;
	}

        if(fa.preferredcontact.value=="fax" && trim(fa.fax.value)==''){
                alert("A fax number must be entered if preferred contact method is fax");
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

function notesabc(fa)
{
	if(trim(fa.notes.value) == '')
	{
		alert("Progress Notes is Required");
		fa.notes.focus();
		return false;
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
	
	if(trim(fa.image_file.value) == '' && trim(fa.ed.value) == '')
	{
		alert("Image is Required");
		fa.image_file.focus();
		return false;
	}
	
}

//-->
