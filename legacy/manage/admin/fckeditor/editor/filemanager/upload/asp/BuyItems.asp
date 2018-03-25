<%@ Language=VBScript %>
<%Option Explicit%>
<!-- #include file = "connection.asp" -->
<% If Session("LoginStatus") = True Then %>
	<%
		Dim OrdId
		OrdId = Trim(Request.Form.Item("txtOrdid"))
		'Response.Write OrdId & "<BR>"
		Dim sqlOrdMaster
		sqlOrdMaster = "INSERT INTO OrderMaster SELECT TempOrderMaster.*"
		sqlOrdMaster = sqlOrdMaster & " FROM TempOrderMaster where CustID = '" & Session("EmailID") & "'"
		Conn.Execute sqlOrdMaster 
		
		Dim sqlOrdMaster1
		sqlOrdMaster1 = "INSERT INTO OrderDetails SELECT TempOrderDetails.*"
		sqlOrdMaster1 = sqlOrdMaster1 & " FROM TempOrderDetails where OrderID = " & CDbl(OrdId)
		Conn.Execute sqlOrdMaster1 
		
		'Dim sqlOrdMaster2,rsOrdMaster2,i,sqlOrdMaster3
		'sqlOrdMaster2 = "Select ItemID,OrderID,Quantity FROM TempOrderDetails where OrderID = " & CDbl(OrdId)
		'Set rsOrdMaster2 = Server.CreateObject("ADODB.RecordSet")
		'rsOrdMaster2.Open sqlOrdMaster2,Conn,adOpenDynamic,adLockOptimistic 
		'rsOrdMaster2.MoveFirst 
		'While rsOrdMaster2.EOF <> True 
			'For i = 1 To rsOrdMaster2.Fields("Quantity").Value
				 'sqlOrdMaster3 = "Insert into ItemPinDetails(ItemID,OrderID) values("
				 'sqlOrdMaster3 = sqlOrdMaster3 & Trim(rsOrdMaster2.Fields("ItemID").Value) & ","
				 'sqlOrdMaster3 = sqlOrdMaster3 & Trim(rsOrdMaster2.Fields("OrderID").Value) & ")"
				 'Response.Write sqlOrdMaster3 & "<BR>"
				 'Conn.Execute sqlOrdMaster3
			'Next
			'rsOrdMaster2.MoveNext 	
		'Wend
		'rsOrdMaster2.Close
		'Set rsOrdMaster2 = Nothing
		
		Dim Del1
		Del1 = "Delete from TempOrderMaster where CustID = '" & Session("EmailID") & "'"
		
		Dim Del2
		Del2 = "Delete from TempOrderDetails where OrderID = " & OrdId
		
		Conn.Execute Del1
		Conn.Execute Del2
		
	%>
	<HTML>
	<HEAD>
	<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
	<LINK href="images/Style1.css" rel=stylesheet  type=text/css> 
	</HEAD>
	<BODY>

	<P>Thank you for using the services of MallOfIndia.com. Our
    administrative department will get back to you shortly.</P>

	<P>&nbsp;</P>

	<P>Thank You,<br>
&nbsp;&nbsp; Sales<br>
    MallOfIndia.com</P>

	<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="103%" id="AutoNumber1" bgcolor="#FFA500">
      <tr>
        <td width="100%">
        <p align="center"><a href="eStoreMain.asp" target="DisplayArea"><b>Main Page</b></a></td>
      </tr>
    </table>

	</BODY>
	</HTML>
	<%
		Dim mail
		Set mail = Server.CreateObject("CDONTS.NewMail")
		mail.To = "mohit@dialworld.com"
		mail.Bcc = "sdsinha@att.net"
		mail.From = Session("EmailID")
		mail.Subject = "New order from mallofindia.com"
		mail.Body = "You have just received a new order from MALL OF INDIA.Please be be kind to check and complete the order."
		mail.Send 
		Set mail = Nothing
		Session("CartItems") = ""
	%>
<% End If %>