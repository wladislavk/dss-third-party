<%@ Language = VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	Dim count,i,Name
	count = Request.Form.Count 
	Dim MyArray(2),rsEmail
	MyArray(0) = Request.Form.Item("txtEmail") 'contains CustID
	MyArray(1) = Request.Form.Item("txtPin") 'contain the password
	Dim recs,RowCount,Records,sqlEmailPwd
	sqlEmailPwd = "Select CustID,Password,FirstName,LastName from ShoppingCustomerMaster where CustID = '" & Trim(MyArray(0)) & "'"
	Set rsEmail = Server.CreateObject("ADODB.Recordset")
	rsEmail.Open sqlEmailPwd,Conn,adOpenDynamic,adLockOptimistic 
	If rsEmail.EOF = True And rsEmail.BOF = True  Then
		rsEmail.Close
		Set rsEmail = Nothing
%>
		<script>
			alert("Invalid Login ID. Please register yourself.")
			window.history.back()
		</script>
<%	Else
		rsEmail.MoveFirst 
		If (strComp(UCase(MyArray(0)),UCase(rsEmail.Fields("CustID").value),1)) = 0 Then
			If (strComp(UCase(MyArray(1)),UCase(rsEmail.Fields("Password").value),1)) = 0 Then
				Session("UsersFirstName") = rsEmail.Fields("FirstName").Value & " " & rsEmail.Fields("LastName").Value 
				Session("LoginStatus") = True
				Session("EmailID") = MyArray(0)
				'Session("EmailID") = 
				Response.Redirect "MyAccount.asp"
				'Response.Write Session("UsersFirstName")
			Else
				%>
					<script>
						alert("Invalid Password.")
						window.history.back()
					</script>
				<%
			End If
		End If	
	End If
%>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft Visual Studio 6.0">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<TITLE>User</TITLE>
</HEAD>
<BODY>

<P>&nbsp;</P>

</BODY>
</HTML>
