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
		return -1;//Bad Date Format
	var T = d.split(/[-\/]/);
	var M = T[0];
	var D = T[1];
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


function adminticketabc(fa){

  if(trim(fa.docid.value) == ""){
        alert("Account is Required")
        fa.docid.focus();
        return false;
  }
  if(trim(fa.userid.value) == ""){
        alert("User is Required")
        fa.userid.focus();
        return false;
  }
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

function areaabc(fa)
{
	if(trim(fa.area.value) == "" )
	{
		alert("Area is Required");
		fa.area.focus();
		return false;
	}
}

function userregabc(fa){
        if(trim(fa.first_name.value) == "" )
        {
                alert("First Name is Required");
                fa.first_name.focus();
                return false;
        }
        if(trim(fa.last_name.value) == "" )
        {
                alert("Last Name is Required");
                fa.last_name.focus();
                return false;
        }
        if(trim(fa.phone.value) == "" )
        {
                alert("Cell Phone is Required");
                fa.phone.focus();
                return false;
        }
        if(trim(fa.email.value) == "" )
        {
                alert("Email is Required");
                fa.email.focus();
                return false;
        }
  return true;
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
	if(!fa.ein.checked && !fa.ssn.checked){
		alert("EIN or SSN is Required");
		fa.ein.focus();
		return false;
        }
	if(trim(fa.practice.value) == "" )
	{
		alert("Practice is Required");
		fa.practice.focus();
		return false;
	}
	if(fa.password){
	if(trim(fa.password.value) == "" )
	{
		alert("Password is Required");
		fa.password.focus();
		return false;
	}
	var pass = fa.password.value;
	if(pass.search(/[A-Za-z]/)<0){
		alert("Password must contain an alpha character");
		fa.password.focus();
		return false;
	}
        if(pass.search(/[0-9]/)<0){
                alert("Password must contain a numeric character");
                fa.password.focus();
                return false;
        }
	if(trim(fa.password.value) != trim(fa.password2.value)){
		alert("Password fields must match");
		fa.password.focus();
		return false;
	}
	}
	if(trim(fa.first_name.value) == "" )
	{
		alert("First Name is Required");
		fa.first_name.focus();
		return false;
	}
        if(trim(fa.last_name.value) == "" )
        {
                alert("Last Name is Required");
                fa.last_name.focus();
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
		alert("In-Valid Email ");
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

function staffabc(fa)
{
	if(trim(fa.username.value) == "" )
	{
		alert("Username is Required");
		fa.username.focus();
		return false;
	}
	if(fa.password){
	if(trim(fa.password.value) == "" )
	{
		alert("Password is Required");
		fa.password.focus();
		return false;
	}
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

function pageabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
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
	if(trim(fa.middlename.value) == "" )
	{
		alert("Middle Name is Required");
		fa.middlename.focus();
		return false;
	}
	if(trim(fa.salutation.value) == "" )
	{
		alert("Salutation is Required");
		fa.salutation.focus();
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
	if(trim(fa.dob.value) == "" )
	{
		alert("Birthday is Required");
		fa.dob.focus();
		return false;
	}
	if(trim(fa.gender.value) == "" )
	{
		alert("Gender is Required");
		fa.gender.focus();
		return false;
	}
	if(trim(fa.marital_status.value) == "" )
	{
		alert("Marital Status is Required");
		fa.marital_status.focus();
		return false;
	}
	if(trim(fa.ssn.value) == "" )
	{
		alert("Patient's Soc Sec No. is Required");
		fa.ssn.focus();
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
  return true;
}


function complaintabc(fa)
{
	if(trim(fa.complaint.value) == "" )
	{
		alert("Complaint is Required");
		fa.complaint.focus();
		return false;
	}
}

function intoleranceabc(fa)
{
	if(trim(fa.intolerance.value) == "" )
	{
		alert("Intolerance is Required");
		fa.intolerance.focus();
		return false;
	}
}

function allergensabc(fa)
{
	if(trim(fa.allergens.value) == "" )
	{
		alert("Allergens is Required");
		fa.allergens.focus();
		return false;
	}
}

function medicationsabc(fa)
{
	if(trim(fa.medications.value) == "" )
	{
		alert("Medications is Required");
		fa.medications.focus();
		return false;
	}
}

function historyabc(fa)
{
	if(trim(fa.history.value) == "" )
	{
		alert("Medical History is Required");
		fa.history.focus();
		return false;
	}
}

function tongueabc(fa)
{
	if(trim(fa.tongue.value) == "" )
	{
		alert("Tongue is Required");
		fa.tongue.focus();
		return false;
	}
}

function uvulaabc(fa)
{
	if(trim(fa.uvula.value) == "" )
	{
		alert("Uvula is Required");
		fa.uvula.focus();
		return false;
	}
}

function soft_palateabc(fa)
{
	if(trim(fa.soft_palate.value) == "" )
	{
		alert("Soft Palate is Required");
		fa.soft_palate.focus();
		return false;
	}
}

function gag_reflexabc(fa)
{
	if(trim(fa.gag_reflex.value) == "" )
	{
		alert("Gag Reflex is Required");
		fa.gag_reflex.focus();
		return false;
	}
}

function nasal_passagesabc(fa)
{
	if(trim(fa.nasal_passages.value) == "" )
	{
		alert("Nasal Passages is Required");
		fa.nasal_passages.focus();
		return false;
	}
}

function maxillaabc(fa)
{
	if(trim(fa.maxilla.value) == "" )
	{
		alert("Maxilla is Required");
		fa.maxilla.focus();
		return false;
	}
}

function mandibleabc(fa)
{
	if(trim(fa.mandible.value) == "" )
	{
		alert("Mandible is Required");
		fa.mandible.focus();
		return false;
	}
}

function exam_teethabc(fa)
{
	if(trim(fa.exam_teeth.value) == "" )
	{
		alert("Teeth Examination is Required");
		fa.exam_teeth.focus();
		return false;
	}
}

function diagnosticabc(fa)
{
	if(trim(fa.diagnostic.value) == "" )
	{
		alert("Diagnostic Test is Required");
		fa.diagnostic.focus();
		return false;
	}
}

function assessmentabc(fa)
{
	if(trim(fa.assessment.value) == "" )
	{
		alert("Assessment is Required");
		fa.assessment.focus();
		return false;
	}
}

function assess_additionabc(fa)
{
	if(trim(fa.assess_addition.value) == "" )
	{
		alert("Assessment Addition is Required");
		fa.assess_addition.focus();
		return false;
	}
}

function consultationabc(fa)
{
	if(trim(fa.consultation.value) == "" )
	{
		alert("Consultation is Required");
		fa.consultation.focus();
		return false;
	}
}

function evaluation_newabc(fa)
{
	if(trim(fa.evaluation_new.value) == "" )
	{
		alert("Evaluation New is Required");
		fa.evaluation_new.focus();
		return false;
	}
}

function evaluation_estabc(fa)
{
	if(trim(fa.evaluation_est.value) == "" )
	{
		alert("Evaluation Established is Required");
		fa.evaluation_est.focus();
		return false;
	}
}

function contacttypeabc(fa)
{
	if(trim(fa.contacttype.value) == "" )
	{
		alert("Contact Type is Required");
		fa.contacttype.focus();
		return false;
	}
}

function accesscodeabc(fa)
{
        if(trim(fa.access_code.value) == "" )
        {
                alert("Access Code is Required");
                fa.access_code.focus();
                return false;
        }
}

function imagetypeabc(fa)
{
	if(trim(fa.imagetype.value) == "" )
	{
		alert("Image Type is Required");
		fa.imagetype.focus();
		return false;
	}
}

function qualifierabc(fa)
{
	if(trim(fa.qualifier.value) == "" )
	{
		alert("Qualifier is Required");
		fa.qualifier.focus();
		return false;
	}
}

function epworthabc(fa)
{
	if(trim(fa.epworth.value) == "" )
	{
		alert("Epworth is Required");
		fa.epworth.focus();
		return false;
	}
}

function palpationabc(fa)
{
	if(trim(fa.palpation.value) == "" )
	{
		alert("Palpation is Required");
		fa.palpation.focus();
		return false;
	}
}

function joint_examabc(fa)
{
	if(trim(fa.joint_exam.value) == "" )
	{
		alert("Joint Examination is Required");
		fa.joint_exam.focus();
		return false;
	}
}

function jointabc(fa)
{
	if(trim(fa.joint.value) == "" )
	{
		alert("Joint is Required");
		fa.joint.focus();
		return false;
	}
}

function range_motionabc(fa)
{
	if(trim(fa.range_motion.value) == "" )
	{
		alert("Range Motion is Required");
		fa.range_motion.focus();
		return false;
	}
}

function screeningabc(fa)
{
	if(trim(fa.screening.value) == "" )
	{
		alert("Screening is Required");
		fa.screening.focus();
		return false;
	}
}

function deviceabc(fa)
{
	if(trim(fa.device.value) == "" )
	{
		alert("Device is Required");
		fa.device.focus();
		return false;
	}
}

function followupabc(fa)
{
	if(trim(fa.followup.value) == "" )
	{
		alert("Follow Up is Required");
		fa.followup.focus();
		return false;
	}
}

function ins_diagnosisabc(fa)
{
	if(trim(fa.ins_diagnosis.value) == "" )
	{
		alert("Insurance Diagnosis is Required");
		fa.ins_diagnosis.focus();
		return false;
	}
}

function place_serviceabc(fa)
{
	if(trim(fa.place_service.value) == "" )
	{
		alert("Place of Service is Required");
		fa.place_service.focus();
		return false;
	}
}

function type_serviceabc(fa)
{
	if(trim(fa.type_service.value) == "" )
	{
		alert("Type of Service is Required");
		fa.type_service.focus();
		return false;
	}
}

function cpt_codeabc(fa)
{
	if(trim(fa.cpt_code.value) == "" )
	{
		alert("CPT Code is Required");
		fa.cpt_code.focus();
		return false;
	}
}

function modifier_codeabc(fa)
{
	if(trim(fa.modifier_code.value) == "" )
	{
		alert("Modifier Code is Required");
		fa.modifier_code.focus();
		return false;
	}
}

function ins_typeabc(fa)
{
	if(trim(fa.ins_type.value) == "" )
	{
		alert("Insurance Type is Required");
		fa.ins_type.focus();
		return false;
	}
}

function doc_welcomeabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_educationalabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_marketingabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_dvdabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_lababc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_newabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function doc_insuranceabc(fa)
{
	if(trim(fa.title.value) == "" )
	{
		alert("Title is Required");
		fa.title.focus();
		return false;
	}
	
	if(fa.video_file.value != '')
	{
		var fname = fa.video_file.value;
		var lastdot = fname.split(".");
		var ll = lastdot.length;
		var ext_arr = parseInt(ll-1);
		var ext = '';
		ext = lastdot[ext_arr].toLowerCase();
		
		if(ext != 'flv')
		{
			alert("Only Upload FLV Files for Video File.");
			fa.video_file.focus();
			return false;
		}
	}
	
}

function transaction_codeabc(fa)
{
	if(trim(fa.transaction_code.value) == "" )
	{
		alert("Transaction Code is Required");
		fa.transaction_code.focus();
		return false;
	}
}

//-->
