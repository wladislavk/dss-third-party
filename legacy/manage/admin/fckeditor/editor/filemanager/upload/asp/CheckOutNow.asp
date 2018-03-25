<%@ Language=VBScript %>
<%Option Explicit%>
<!-- #include file = "connection.asp" -->
<% If Session("LoginStatus") = True Then%>
<%
	Dim sql1,rs1,count,i
	count = Request.Form.Count
	Dim ShipAddOpt	
	If Trim(Request.Form.Item("SA")) = "SAME" Then
		ShipAddOpt = "Same as registration"
	ElseIf Trim(Request.Form.Item("SA")) = "OTHER" Then 	
		ShipAddOpt = Trim(Request.Form.Item("txtShipAdd"))
		ShipAddOpt = Replace(ShipAddOpt,vbCrLf," ")
	End If
	
	Dim msg
	If Trim(Request.Form.Item("msg")) = "" Then
		msg = "None"
	Else
		msg = Trim(Request.Form.Item("msg"))
	End If
	
	Dim ordtrackstatus
	'If Trim(Request.Form.Item("msg")) = "" Then
		ordtrackstatus  = "Being Processed."
	'End If
	
	Dim OrdId,rsOrdId
	Set rsOrdId = Server.CreateObject("ADODB.Recordset") 
	rsOrdId.Open "Select max(OrderID) from OrderMaster",Conn,adOpenDynamic,adLockOptimistic
	If isNull(rsOrdId.Fields(0).Value) = True Then
		OrdId = 1
	Else
		OrdId = CDbl(rsOrdId.Fields(0).Value) + 1
	End If
	
	Conn.Execute "Delete  from TempOrderMaster where CustID = '" & Trim(Session("EmailID")) & "'"
	'Conn.Execute "Delete  from TempOrderDetails"
	Dim ItmDetails
	ItmDetails = Replace(Trim(Request.form.Item("txtItemSizes")),vbCrLf,",")
	
	Dim ShipAdd
	ShipAdd = Replace(Trim(Request.form.Item("txtShipAdd")),vbCrLf,",")
	
	Dim sqlOrdMaster
	sqlOrdMaster = "Insert into TempOrderMaster(OrderID,CustID,TotalPrice,OrdDate,OrdTime,IPAddress,OrdStatus,MsgToReceiver,OrdTrackStatus,GenVoucherNo,ItemDetails,ShipAdd) values(" & OrdId & ",'" 
	sqlOrdMaster = sqlOrdMaster & Session("EmailID") & "',"
	sqlOrdMaster = sqlOrdMaster & CDbl(Trim(Request.Form.Item("grandprice"))) & ","
	sqlOrdMaster = sqlOrdMaster & "'" & Date & "','" & Time & "','" 
	sqlOrdMaster = sqlOrdMaster & Request.ServerVariables("REMOTE_ADDR") & "',0,'"
	sqlOrdMaster = sqlOrdMaster & msg & "','"
	sqlOrdMaster = sqlOrdMaster & ordtrackstatus & "','"
	sqlOrdMaster = sqlOrdMaster & Trim(Request.Form.Item("genvoucher")) & "','" & ItmDetails & "','" & ShipAddOpt & "')" 
	Conn.Execute sqlOrdMaster
	
	
	Dim ItmIds,Qtys,TotPrice,ItmVouchers
	If Session("CartItems") <> "" Then
		ItmIds = Left(Session("CartItems"),Len(Session("CartItems"))-1)
		ItmIds = Split(ItmIds,",",-1,1)
	End If	
	Qtys = Split(Trim(Request.Form.Item("qty")),",",-1,1)
	TotPrice = Split(Trim(Request.Form.Item("totprice")),",",-1,1)
	'Response.Write "<BR>" & Request.Form.Item("totprice") &
	ItmVouchers = Split(Trim(Request.Form.Item("disvoucher")),",",-1,1)
	Dim sqlOrdDet
	'Response.Write UBound(ItmIds) & "<br>"
	If UBound(ItmIds) = 0 Then
		sqlOrdDet = "Insert into TempOrderDetails(ItemID,OrderID,Quantity,TotalPrice,ItmVoucherNo)"
		sqlOrdDet = sqlOrdDet & " values(" & Trim(ItmIds(0)) & "," & OrdId & "," 
		sqlOrdDet = sqlOrdDet & Trim(Qtys(0)) & "," & Trim(TotPrice(0)) & ",'"
		sqlOrdDet = sqlOrdDet & Trim(ItmVouchers(0)) & "')"
		'Response.Write sqlOrdDet & "<BR>"
		Conn.Execute sqlOrdDet 
	Else
		For i = 0 To UBound(ItmIds) 
			sqlOrdDet = "Insert into TempOrderDetails(ItemID,OrderID,Quantity,TotalPrice,ItmVoucherNo)"
			sqlOrdDet = sqlOrdDet & " values(" & Trim(ItmIds(i)) & "," & OrdId & "," 
			sqlOrdDet = sqlOrdDet & Trim(Qtys(i)) & "," & Trim(TotPrice(i)) & ",'"
			sqlOrdDet = sqlOrdDet & Trim(ItmVouchers(i)) & "')"
			'Response.Write sqlOrdDet & "<BR>" 
			Conn.Execute sqlOrdDet 
		Next 
	End If
	Dim sql,rs
	sql = "Select * from BillingCustomerDetails where CustID = '" & Session("EmailID") & "'"
	Set rs = Server.CreateObject("ADODB.Recordset")
	rs.Open sql,Conn,adOpenDynamic,adLockOptimistic 
	If rs.EOF = True And rs.BOF = True Then
%>
		<script>
			alert("You are not registered.")
			window.location.href = "index.asp"
		</script>
<%
	Else
		rs.MoveFirst 
%>
	<HTML>
	<HEAD>
	<meta http-equiv="Content-Language" content="en-us">
	<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
	<LINK href="images/Style1.css" rel=stylesheet  type=text/css> 
	<SCRIPT>
	function BuyItems()
	{		
		document.frmChkOut.submit()
	}
	</SCRIPT>
	</HEAD>
	<BODY>
    <div align="center" style="width: 373; height: 386">
      <center>
      <b><u>Credit Card Details</u></b>
      <form name="frmChkOut" method="post" action="BuyItems.asp">
      <table border="0" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="107%" id="AutoNumber1" height="168" bgcolor="#FFA500">
        <tr>
          <td width="14%" align="right" height="4" style="border-right-style: none; border-right-width: medium; border-bottom-style: none; border-bottom-width: medium; border-top-style:solid; border-top-width:1; border-left-style:solid; border-left-width:1">
          <b>Name : </b> </td>
          <td width="90%" height="4" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-bottom-style: none; border-bottom-width: medium; border-top-style:solid; border-top-width:1" colspan="4">
          <input type="text" readonly value="<%=rs.fields("Name").value%>" name="txtName" size="33" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium; border-left-style:solid; border-left-width:1">
          <b>Address :</b></td>
          <td width="90%" height="13" style="border-left-style:none; border-left-width:medium; border-right-style:solid; border-right-width:1; border-top-style:none; border-top-width:medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=rs.fields("Address").value%>" name="txtAddress" size="37" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium; border-left-style:solid; border-left-width:1">
          <b>City :</b></td>
          <td width="18%" height="13" style="border-style:none; border-width:medium; ">
          <input type="text" readonly value="<%=rs.fields("City").value%>" name="txtName" size="13" style="border-style: solid; border-width: 1"></td>
          <td width="18%" height="13" style="border-style:none; border-width:medium; " colspan="2">
          <p align="right">
          <b>State :</b></td>
          <td width="64%" height="13" style="border-left-style:none; border-left-width:medium; border-right-style:solid; border-right-width:1; border-top-style:none; border-top-width:medium; border-bottom-style:none; border-bottom-width:medium">
          <input type="text" readonly value="<%=rs.fields("State").value%>" name="txtName1" size="18" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium; border-left-style:solid; border-left-width:1">
          <b>Zip : </b> </td>
          <td width="25%" height="13" style="border-style:none; border-width:medium; ">
          <input type="text" readonly value="<%=rs.fields("Zip").value%>" name="txtName2" size="13" style="border-style: solid; border-width: 1"></td>
          <td width="34%" height="13" style="border-style:none; border-width:medium; " colspan="2">
          <p align="right">
          <b>Country :</b></td>
          <td width="39%" height="13" style="border-left-style:none; border-left-width:medium; border-right-style:solid; border-right-width:1; border-top-style:none; border-top-width:medium; border-bottom-style:none; border-bottom-width:medium">
          <input type="text" readonly value="<%=rs.fields("Country").value%>" name="txtName3" size="17" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium; border-left-style:solid; border-left-width:1">
          <b>Phone No. : </b> </td>
          <td width="90%" height="13" style="border-left-style:none; border-left-width:medium; border-right-style:solid; border-right-width:1; border-top-style:none; border-top-width:medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=rs.fields("Phone").value%>" name="txtName4" size="17" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style: none; border-bottom-width: medium; border-left-style:solid; border-left-width:1">
          <b>&nbsp;</b></td>
          <td width="90%" height="13" style="border-left-style:none; border-left-width:medium; border-right-style:solid; border-right-width:1; border-top-style:none; border-top-width:medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          &nbsp;</td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width:medium ; border-top-style: none; border-top-width:medium; border-left-style:solid; border-left-width:1; border-bottom-style:none; border-bottom-width:medium">
          <b>CC Type :</b></td>
          <td width="90%" height="13" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=rs.fields("CC_Type").value%>" name="txtName" size="27" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium; border-left-style:solid; border-left-width:1">
          <b>CC No. :</b></td>
          <td width="90%" height="13" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=rs.fields("CC_Number").value%>" name="txtName" size="27" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-left-style:solid; border-left-width:1; border-bottom-style:none; border-bottom-width:medium">
          <b>Exp. Date :</b></td>
          <td width="90%" height="13" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=rs.fields("CC_ExpiryDate").value%>" name="txtName" size="13" style="border-style: solid; border-width: 1"></td>
        </tr>
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium; border-left-style:solid; border-left-width:1">
          <b>Amount :</b></td>
          <td width="90%" height="13" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type="text" readonly value="<%=Request.Form.Item("grandprice")%>" name="txtName" size="13" style="border-style: solid; border-width: 1">(in 
          $)</td>
        </tr>
        
        <tr>
          <td width="14%" align="right" height="13" style="border-right-style: none; border-right-width: medium; border-top-style: none; border-top-width: medium; border-left-style:solid; border-left-width:1; border-bottom-style:none; border-bottom-width:medium"></td>
          <td width="90%" height="13" style="border-left-style: none; border-left-width: medium; border-right-style: solid; border-right-width: 1; border-top-style: none; border-top-width: medium; border-bottom-style:none; border-bottom-width:medium" colspan="4">
          <input type=hidden name="txtOrdid" value="<%=OrdId%>"></td>
        </tr>
        
        <% If ShipAddOpt <> "S" Then%>
        <% End If%>
        <tr>
          <td width="35%" align="right" height="13" bgcolor="#C0C0C0" bordercolor="#000000" style="border-left-style: solid; border-left-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1">
          <p align="left"><a href="ViewCart.asp" target="DisplayArea"><b>Back</b></a></td>
          <td width="47%" align="right" height="13" bgcolor="#C0C0C0" bordercolor="#000000" colspan="2" style="border-right-style: none; border-right-width: medium; border-top-style:solid; border-top-width:1; border-bottom-style:solid; border-bottom-width:1">
          <p align="left">&nbsp;</td>
          <td width="47%" align="right" height="13" bgcolor="#C0C0C0" bordercolor="#000000" colspan="2" style="border-left-style: none; border-left-width: medium; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1; border-bottom-style:solid; border-bottom-width:1">
          <p><a href="javascript:BuyItems()" target="DisplayArea"><b>Check Out Now</b></a></td>
        </tr>
      </table>
      </form>
      </center>
    </div>
	</BODY>
	</HTML>
	<%
	End If
	Conn.Close
	Set Conn = Nothing
	%>
<% End If %>