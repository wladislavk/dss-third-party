<%@ Language=VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	Dim i
	Dim sql,rs
	sql = "Select CustID from ShoppingCustomerMaster where CustID = '" & Trim(padQuotes(Request.Form.Item("txtEmail"))) & "'"
	Set rs = Server.CreateObject("ADODB.Recordset")
	rs.Open sql,Conn,adOpenDynamic,adLockOptimistic 
	If rs.EOF = True And rs.BOF = True Then
		rs.Close
		Set rs = Nothing
		Dim rs1
		Set rs1 = Server.CreateObject("ADODB.Recordset")
		rs1.Open "ShoppingCustomerMaster",Conn,adOpenDynamic,adLockOptimistic 
		rs1.AddNew 
			rs1.Fields("CustID").Value = padQuotes(Request.Form.Item("txtEmail"))
			rs1.Fields("FirstName").Value = padQuotes(Request.Form.Item("txtFname"))
			rs1.Fields("LastName").Value = padQuotes(Request.Form.Item("txtLname"))
			rs1.Fields("Address").Value = padQuotes(Request.Form.Item("txtAddress1"))
			rs1.Fields("Password").Value = padQuotes(Request.Form.Item("txtPin2"))
			rs1.Fields("Country").Value = padQuotes(Request.Form.Item("txtCountry1"))
			rs1.Fields("IPAddress").Value = Request.ServerVariables("REMOTE_ADDR")
			rs1.Fields("TimeOfLogin").Value = Time 
			rs1.Fields("MemberShipStatus").Value = 0
		rs1.Update 
		rs1.Close
		Set rs1 = Nothing
		Dim rs2
		Set rs2 = Server.CreateObject("ADODB.Recordset")
		rs2.Open "BillingCustomerDetails",Conn,adOpenDynamic,adLockOptimistic 
		rs2.AddNew 
			rs2.Fields("CustID").Value = padQuotes(Request.Form.Item("txtEmail"))
			rs2.Fields("Name").Value = padQuotes(Request.Form.Item("txtFname1"))
			rs2.Fields("Address").Value = padQuotes(Request.Form.Item("txtAddress1"))
			rs2.Fields("City").Value = padQuotes(Request.Form.Item("txtCity1"))
			rs2.Fields("State").Value = padQuotes(Request.Form.Item("txtState1"))
			rs2.Fields("Zip").Value = padQuotes(Request.Form.Item("txtZip1"))
			rs2.Fields("Country").Value = padQuotes(Request.Form.Item("txtCountry1"))
			rs2.Fields("Phone").Value = padQuotes(Request.Form.Item("txtPhone1"))
			rs2.Fields("CC_Type").Value = padQuotes(Request.Form.Item("SelCC"))
			rs2.Fields("CC_Number").Value = padQuotes(Request.Form.Item("txtCCNo")) 
			rs2.Fields("CC_ExpiryDate").Value = padQuotes(Request.Form.Item("txtExpiryDate1")) & "/" & padQuotes(Request.Form.Item("txtExpiryDate2"))
		rs2.Update 
		rs2.Close
		Set rs2 = Nothing
	%>
		<SCRIPT>
			alert("You have been successfully registered.")
			window.close()
		</SCRIPT>
	<%
	Else
	%>
		<SCRIPT>
			alert("This email id is already registered.Please use another one.")
			window.history.back()
		</SCRIPT>
	<%
		rs.Close
		Set rs = Nothing
	End If
	Conn.Close
	Set Conn = Nothing
	Function padQuotes(instring)
		REM This function pads an extra single quote in strings containing quotes for 
		REM proper SQL searching.   
		Dim bodybuild   
		Dim bodystring   
		Dim Length   
		Dim i   
		bodybuild = ""
		bodystring = instring
		Length = Len(bodystring)
		   For i = 1 to length
					   If Mid(bodystring, i, 1) = "|" Then
						bodybuild = bodybuild & "' & Chr(124) & '"
					   Else
						bodybuild = bodybuild & Mid(bodystring, i, 1)
						If Mid(bodystring, i, 1) = Chr(39) Then
		                    bodybuild = bodybuild & Mid(bodystring, i, 1)
						End If   
		               End If
		   Next
		   bodystring = bodybuild
		   padQuotes = bodystring
	End Function
%>
<script>
	alert("Thanks for registering with us.")
	window.close()
</script>