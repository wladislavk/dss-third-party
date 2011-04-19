<%@ Language="VBScript" %>
<%
	If (Session("LoginStatus")) = True Then
		Response.Redirect "MyAccount.asp"
	Else 
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<TITLE>Mall Of India - An online gift service.</TITLE>
<META content="text/html; charset=windows-1252" http-equiv=Content-Type>
<META content="Mall Of India is an online gift service for the everybody who are away from their love ones." 
name=Description>
<META content="gift,gifts,presents,online services,flowers,cake,cakes,flowers,MahaLaxmi,Sweets,sweet,coin,coins,India,Indians,Parties,party,Misal,Maharashtra,Maharastrian,Marathi," 
name=keywords>
<LINK href="Style1.css" rel=stylesheet type=text/css>
</HEAD>
<SCRIPT Language="JavaScript">
function RegisterNow()
{
	window.open("Register.html","","height=400,width=645,left=75,top=75,scrollbars")
}
function MemberServices()
{
	window.open("MemberServices.asp","","scrollbars,height=400,width=600,top=50,left=50")
}
function ValidateForm()
{
	//alert("asdfasf")
	var strEmailId = document.frmMyAcct.txtEmail;
	var strPin = document.frmMyAcct.txtPin;
	if (strEmailId.value.length  == 0) 
	{
		alert('Please enter Email in Login Information')
		strEmailId.focus()
		return false;
	}
	if (GoodEmail(strEmailId.value) == false)
	{
		alert('Please enter valid Email address (like foo@bar.com), in Login Information')
		strEmailId.select()
		strEmailId.focus()
		return false;
	}
	if (strPin.value.length == 0)
	{
		alert('Please enter Password for your account')
		strPin.focus()
		return false;
	}

}
function GoodEmail(inEmail)
{
	if (inEmail == "") 
	{
		return(false);
	}
	else 
	{
		if (inEmail.indexOf("@") < 0 || inEmail.indexOf(".") < 0 || inEmail.length < 7)
		{
			return (false);
		} 
		else
		{
			return(true);
		}
	}
}
function CheckEmailId()
{
	var strEmailId = document.frmMyAcct.txtEmail;
	if (GoodEmail(strEmailId.value) == false)
		{
		alert('Please enter valid Email address (like foo@bar.com), in Login Information')
		strEmailId.select()
		}
	else
		{
		document.frmMyAcct.txtForgot.value = "Yes"
		document.frmMyAcct.action = "SendPwd.asp";
		document.frmMyAcct.submit();
		}
}
</SCRIPT>
<BODY bgcolor="#FFFFFF" topmargin="0">
 <center>
 <FORM method=post name=frmMyAcct onSubmit="return ValidateForm(this)" action="CheckLogin.asp">
 <TABLE cellpadding="5" bgcolor="#FFFFFF" width="413" style="border-collapse: collapse" bordercolor="#111111" cellspacing="0">
 <tr><td width="554" bgcolor="#FFFFFF">
   <p align="center"><b><A href="javascript:window.history.back()">Back</a></b></p></td></tr>
 <tr>
 <td width="554">
      
        <TABLE align=left border=0 cellPadding=5 cellSpacing=0 class=tbl2 style="WIDTH: 421; HEIGHT: 148; border-collapse:collapse; background-color:#FFFFFF" bordercolor="#FFA500">
                  <TBODY>
                    <TR>
                      <TD align=middle colSpan=3 width="424" style="border-style: solid; border-width: 1" height="23">&nbsp;&nbsp;&nbsp;<font color="#B22222">
                      <u><b>Login Information</b></u></font></TD></TR>
                    <TR>
                      <TD width="218" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium" height="33">
                      <p align="right"><b>Login Id:</b></TD>
                      <TD colspan="2" width="265" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium" height="33">
                      <INPUT name=txtEmail size=26 style="border-style:solid; border-width:1; WIDTH: 194px; HEIGHT: 22px" tabindex="1"> <INPUT id=txtForgot 
                        name=txtForgot type=hidden></TD></TR>
                    <TR>
                      <TD width="218" style="border-left-style: solid; border-left-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style: solid; border-bottom-width: 1" height="7">
                      <p align="right"><b>Password:</b></TD>
                      <TD width="109" style="border-top-style: none; border-top-width: medium" height="7">
                      <INPUT name=txtPin size=15 type=password style="border-style: solid; border-width: 1" tabindex="2"></TD>
                      <TD width="144" valign="baseline" align="left" style="border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium" height="7">&nbsp;<font color="#DC143C"><input type=submit value="  Submit  " style="border-style: solid; border-width: 1" tabindex="3"></font></TD></TR>
                    <TR>
                      <TD width="218" align="center" style="border-left-style: solid; border-left-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" height="45">
                      <b>New Member <A 
                        href="javascript:RegisterNow()">Click 
                        Here</A> </b>    </TD>
                      <TD colspan="2" width="265" style="border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" height="45">
                      <p align="right"><font color="#B22222"><A href="javascript:CheckEmailId()"><b>Forgot Password</b></A></font></p></TD></TR>
                    
                   </TBODY>
                   </TABLE>
                  </form> 
                  
                  </td></tr></TABLE></center>
            

</BODY>
</HTML>
<%
	End if 
%>