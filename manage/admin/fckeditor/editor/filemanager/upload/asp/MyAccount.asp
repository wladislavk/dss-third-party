<%@ Language=VBScript %>
<%Option Explicit%>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	If Session("LoginStatus") = False Then
%>
		<script>
			alert("Please Login to access to account.")
			window.location.href = "LoginDetails.asp"
		</script>
<%

		'Response.Redirect "LoginDetails.asp"
	Else
		Dim email,i,FName
		email =  Trim(Session("EmailID"))
		Fname = Trim(Session("UsersFirstName"))
		
		Dim sql,recs
		Set recs = Server.CreateObject("ADODB.Recordset")
		sql = "SELECT OrderMaster.OrderID, ItemMaster.ItemName, OrderDetails.Quantity, " 
		sql = sql & "OrderDetails.TotalPrice, OrderMaster.OrdTrackStatus "
		sql = sql & "FROM OrderMaster,ItemMaster,OrderDetails "
		sql = sql & "where ItemMaster.ItemID=OrderDetails.ItemID and "
		sql = sql & "OrderMaster.OrderID=OrderDetails.OrderID and OrderMaster.CustID = '" & email & "'" 
		sql = sql & "ORDER BY OrderMaster.OrderID;"
		recs.Open sql,Conn,adOpenDynamic,adLockOptimistic 
		
		
		Dim sqlBillingDetails,BillingRecs,str
		sqlBillingDetails = "Select BCD.Address,BCD.CC_Number,BCD.CC_ExpiryDate, "
		sqlBillingDetails = sqlBillingDetails & "SCM.CustID from BillingCustomerDetails BCD, "
		sqlBillingDetails = sqlBillingDetails & "ShoppingCustomerMaster SCM where "
		sqlBillingDetails = sqlBillingDetails & "BCD.CustID = SCM.CustID and "
		sqlBillingDetails = sqlBillingDetails & "SCM.CustID = '" & Trim(email) & "'"
		Set BillingRecs = Server.CreateObject("ADODB.Recordset")
		BillingRecs.Open sqlBillingDetails,Conn,adOpenDynamic,adLockOptimistic 
%>
			<HTML>
			<HEAD>
			<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
			<LINK href="images/Style1.css" rel=stylesheet type=text/css>
			<TITLE>Mall Of India</TITLE>
			</SCRIPT>
			</HEAD>
			<BODY bgcolor="#FFFFFF">
			<div align="center">
              <center>
			<table width="402" class="tbl2" border="0" cellpadding="5" cellspacing="0" style="BORDER-COLLAPSE: collapse; BACKGROUND-COLOR: #FFFFFF" bordercolor="#FFA500">
			<tr>
			<td align="left" width="134" style="border-style: solid; border-width: 1">
            <A href="javascript:window.history.back()"><b>Back</b></a></td>
			<td align="left" width="134" style="border-style: solid; border-width: 1">
            <p align="center"><a href="Logout.asp" target="DisplayArea"><b>Log Out</b></a></td>
			<td align="left" width="134" style="border-style: solid; border-width: 1">
            <p align="right"><a href="ViewCartNew.asp" target="DisplayArea"><b>View Cart</b></td>
			</tr>
			</table></center>
            </div>
            <br>
			<div align="center">
              <center>
			<table width="401" bgcolor=#FFFFFF style="BORDER-COLLAPSE: collapse" bordercolor="#111111" cellpadding="2" cellspacing="0">
			<tr>
			<td align="middle" width="397" style="border-style:solid; border-width:1; " bordercolor="#FFA500"><IMG height=21 src="images/Account.gif" width=102 border=0></td>
			</tr>
			<tr>
			<td bgcolor="#FFFFFF" width="397" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style:solid; border-top-width:1" bordercolor="#FFA500">Welcome back :<b>&nbsp;<%=Session("UsersFirstName")%></b></td>
			</tr>
			<tr>
			<td width="397" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500"><b>Your Previous Orders :</b></td>
			</tr>
			</table>
			  </center>
            </div>
			<div align="center">
              <center>
			<table width=401 bgcolor=#FFFFFF style="BORDER-COLLAPSE: collapse" bordercolor="#111111" cellpadding="2" cellspacing="0" height="11">		
			<tr>
				<td align=left width="72" height="11" style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"><b>OrderID</b></td>
				<td align=left width="158" height="11" style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"><b>Item Name</b></td>
				<td align=left width="82" height="11" style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"><b>
                Quantity</b></td>
				<td align=left width="89" height="11" style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500">
                <b>Price<br>(in $)</b></td>
                <td align=left width="50" height="11" style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500">
                <b>Status</b></td>
			</tr>
			<% If recs.EOF = True And recs.BOF = True Then %>
				<tr>
					<td align=left colspan=5 style="border-left-style:solid; border-left-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1;border-bottom-style:solid; border-bottom-width:1" bordercolor="#000000" bgcolor="#FFA500">
					<b>No orders given yet.</b>
					</td>
				</tr>
			<% Else %>
				<% recs.MoveFirst %>
				<%While recs.EOF <> True%>
					<tr>
						<td align=left width="72" height="1" style="border-style:solid; border-width:1; " bordercolor="#000000"><%=recs.Fields(0).value%></td>
						<td align=left width="158" height="1" style="border-style:solid; border-width:1; " bordercolor="#000000"><%=recs.Fields(1).value%></td>
						<td align=left width="86" height="1" style="border-style:solid; border-width:1; " bordercolor="#000000"><%=recs.Fields(2).value%></td>
						<td align=left width="85" height="1" style="border-style:solid; border-width:1; " bordercolor="#000000"><%=recs.Fields(3).value%></td>
						<td align=left width="85" height="1" style="border-style:solid; border-width:1; " bordercolor="#000000"><%=recs.Fields(4).value%></td>
					</tr>
				<% recs.MoveNext %>
			<%Wend%>
			<% End If %>
			</table></center>
            </div>
            <br>
			<div align="center">
              <center>
			<table bgcolor=#66ccff width=398 height="5%" border=0 style="BORDER-COLLAPSE: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
			<tr><td bgcolor="#FFFFFF" width="398"><u><b>Your Billing Details :</b></u></td>
			</tr>
			</table>
			  </center>
            </div>
            <div align="center">
              <center>
			<table bgcolor=#FFFFFF width=399 height="5%" border=0 style="BORDER-COLLAPSE: collapse" bordercolor="#111111" cellpadding="2" cellspacing="0">
			<tr>
			<td width=466 align=middle bgcolor="#FFA500" style="border-style:solid; border-width:1; "><b>Billing Address</b> </td>
			<td align=middle width="359" bgcolor="#FFA500" style="border-style:solid; border-width:1; "><b>Credit Card Number</b></td>
			<td align=middle width="235" bgcolor="#FFA500" style="border-style:solid; border-width:1; "><b>Expiry Date</b> </td>
			</tr>
			<tr>
				<%
					  BillingRecs.MoveFirst 
				      While BillingRecs.EOF <> True
				 %>
				<td width=466 align=middle bgcolor="#FFFFFF" style="border-style:solid; border-width:1;"><%=BillingRecs.Fields(0).Value%></td>
				<td align=middle width="359" bgcolor="#FFFFFF" style="border-style: solid; border-width:1">xxxxxxxxxxxx<%=Right(BillingRecs.Fields(1).Value,4)%></td>
				<td align=middle width="235" bgcolor="#FFFFFF" style="border-style:solid; border-width:1;"><%=BillingRecs.Fields(2).Value%></td>
					<%BillingRecs.MoveNext %>
				<% Wend %>
				<%
				'recs.Close
					'Set recs = Nothing
					BillingRecs.Close 
					Set BillingRecs = Nothing
					Conn.Close
					Set Conn = Nothing
				%>
			</table></center>
            </div>
            <br>
			<div align="center">
              <center>&nbsp;</center>
            </div>
            <br>
			<div align="center">
            <center>
            <p></p>
            </center>
            </div>
			</BODY>
			</HTML>
<%
		'End If
	End If
	
%>