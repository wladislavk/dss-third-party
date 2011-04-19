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
}

function contactabc(fa)
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
//-->
