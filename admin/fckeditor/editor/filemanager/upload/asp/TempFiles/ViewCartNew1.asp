<%@ Language="VBScript" %>
<%Option Explicit%>
<!-- #include file = "connection.asp" -->
<% If Session("LoginStatus") = True Then
	'Response.Write "Sess = " & Session("UsersLoginID")
		If Session("CartItems") <> "" Then
			Dim ij
			For ij = 1 To Request.Form.Count
				Response.Write Request.Form.Key(ij) & " = " & Request.Form.Item(ij) & "<BR>"
			Next
			
			Dim F
			F = Left(Session("CartItems"),Len(Session("CartItems"))-1)		
			'Response.Write "F =" & F & "<BR>"
			Dim sqlItemDet,rsItemDet
			sqlItemDet = "Select distinct ItemID,ItemName,OriginalPrice,SalePrice "
			sqlItemDet = sqlItemDet & "from ItemMaster "
			sqlItemDet = sqlItemDet & "where ItemID in (" & Trim(F) & ")"
			'Response.Write sqlItemDet
			Dim RecCount,ii
			ii = 1
			RecCount = 0
			Set rsItemDet = Server.CreateObject("ADODB.Recordset")
			rsItemDet.Open sqlItemDet,Conn,adOpenDynamic,adLockOptimistic
			If rsItemDet.EOF = True and rsItemDet.BOF = True Then
%>
				<script>
					alert("Your shopping cart is empty.")
					window.location.href = "eStore.asp"
				</script>	
<%
			Else
				rsItemDet.MoveFirst
				While rsItemDet.EOF <> True
					RecCount = RecCount + 1
					rsItemDet.MoveNext 
				Wend
				'Response.Write RecCount
				rsItemDet.MoveFirst 
	%>
				<html>
				<head>
				<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
				<meta name="ProgId" content="FrontPage.Editor.Document">
				<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
				<title>Mall Of India</title>
				<SCRIPT Language=javascript>
				function Count(str)
					{								
						var i
						i = 0
						var tot
						tot = 0	
						if(parseInt(str)>1)
						{
							for(i=0;i<parseInt(str);i++)
							{
								tot  = parseFloat(tot) + parseFloat(document.frmCartItems.totprice[i].value)
							}							
						}
						else
						{
							tot= parseFloat(document.frmCartItems.totprice.value)	
						}
						document.frmCartItems.grandprice.value = parseFloat(tot)
								
						var len = document.frmCartItems.elements.length
						//var i = 0
						for(i=0;i<len;i++)
						{
							if (document.frmCartItems.elements[i].type == "checkbox")
							{
								if (document.frmCartItems.elements[i].checked)
								{
									document.frmCartItems.elements[i].checked == false
								}
							}
						}
					}
				function CalTotal(str1,str2,str3)
					{
						//alert(str3)
						var i
						i = 0
						var tot
						tot = 0	
						if(parseInt(str3)>1)
						{
							for(i=0;i<parseInt(str3);i++)
							{
								document.frmCartItems.totprice[i].value = parseFloat(document.frmCartItems.ProdPrice[i].value) * parseFloat(document.frmCartItems.qty[i].value)
							}
							for(i=0;i<parseInt(str3);i++)
							{
										
								tot  = parseFloat(tot) + parseFloat(document.frmCartItems.totprice[i].value)
							}
							//alert(tot)		
						}
						else	
						{
							document.frmCartItems.totprice.value = parseFloat(document.frmCartItems.ProdPrice.value) * parseFloat(document.frmCartItems.qty.value)
							tot = parseFloat(document.frmCartItems.ProdPrice.value) * parseFloat(document.frmCartItems.qty.value)
						}	
						document.frmCartItems.grandprice.value = parseFloat(tot)
					}
				function SubmitForm()
				{
					var i
					i = 0
					var count = 0
					var len = document.frmCartItems.elements.length
					for(i=0;i<len;i++)
						{
							if (document.frmCartItems.elements[i].type == "checkbox")
							{
								if (document.frmCartItems.elements[i].checked == true)
								{
									count = 1
								}
							}
						}
					if (count == 0)
						{
							alert("Please choose atleast one Item to delete")
						}
					else
						{
							window.document.frmCartItems.action = "DelCartItems.asp"
							window.document.frmCartItems.method = "post"
							window.document.frmCartItems.submit()
						}
				}
				function CheckOutNow()
				{
					window.document.frmCartItems.action = "CheckOutNow.asp"
					window.document.frmCartItems.method = "post"
					window.document.frmCartItems.submit()
				}
				function AddMore()
				{
					window.location.href = "eStore.asp"
				}
				function UpdateCart()
				{
					alert("hi")
					
					window.open("UpdateCart.asp","_top","")
					window.close()
				}
				</SCRIPT>
				</head>
				<body>
				<input type=hidden name="hdtextbox" value="<%=RecCount%>">
				<form name="frmCartItems" method=post>
				  <table border="1" width="404" height="82" id="AutoNumber1" bordercolorlight="#FF6600" bordercolordark="#663300" cellspacing="0" style="border-collapse: collapse" bordercolor="#FFCC66">
				    <tr bgcolor="#FFCC66"> 
				      <td height="12" colspan="6" valign="top" width="439">
				      <p align="center"><u><b><font face="Verdana" size="2" color="#000080">Your 
				      Shopping Cart</font></b></u></td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="21" colspan="6" valign="top" width="439"><b>
				      <font face="Verdana" size="2">&nbsp;</font><font face="Verdana" size="1" color="#000080">All 
				      amount are in $</font></b></td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td width="176" height="15" align="center"><b> <font face="Verdana" size="1" color="#000080">Item</font></b></td>
				      <td width="62" height="15" align="center"><b> <font face="Verdana" size="1" color="#000080">Qty.</font></b></td>
				      <td width="133" height="15" align="center">
				      <p align="left"><b> <font face="Verdana" size="1" color="#000080">Unit Price</font></b></td>
				      <td width="144" height="15" align="center"><b> <font face="Verdana" size="1" color="#000080">Voucher 
				        No.</font></b></td>
				      <td width="77" height="15" align="center"><b> <font face="Verdana" size="1" color="#000080">Total</font></b></td>
				      <td width="57" height="15" align="center"><b> <font face="Verdana" size="1" color="#000080"> 
				        <a href="javascript:SubmitForm()"><b>Remove</b></font></td>
				    </tr>
				    <% While rsItemDet.EOF <> True %>
				    <tr bgcolor="#FFCC66"> 
				      <td width="176" height="14" bordercolor="#FF6600">
				      <input type="text" readonly value="<%=rsItemDet.Fields("ItemName").value%>" name="ProdName" size="17" style="border-style: solid; border-width: 1;"></td>
				      <td width="62" height="14"> 
				        <p align="center"> 
				          <input type="text" name="qty" size="4" style="border-style: solid; border-width: 1" tabindex="1" value="1" OnBlur=CalTotal(this.name,this.value,hdtextbox.value)>
				      </td>
				      <td width="133" height="14">
				      <%if rsItemDet.Fields("SalePrice").value = 0 Or rsItemDet.Fields("OriginalPrice").value = "" Then%>				      
						<input type="text" readonly value="<%=rsItemDet.Fields("OriginalPrice").value%>" name="ProdPrice" size="7" style="border-style: solid; border-width: 1">				      
				      <% Else %>
						<input type="text" readonly value="<%=rsItemDet.Fields("SalePrice").value%>" name="ProdPrice" size="7" style="border-style: solid; border-width: 1">
				      <% End If %>
				      </td>
				      <td width="144" height="14">				         
				          <input name="disvoucher" value="none" size="8" style="border-style:solid; border-width:1; float: left" tabindex="2">
				      </td>
				      
				      <td width="77" height="14" align="left">
				      <%if rsItemDet.Fields("SalePrice").value = 0 Or rsItemDet.Fields("OriginalPrice").value = "" Then%>
				      <input readonly type="text" name="totprice" value="<%=rsItemDet.Fields("OriginalPrice").value%>" size="6" style="border-style: solid; border-width: 1; " tabindex="3">
				      
				      <% Else %>
				      <input type="text" readonly value="<%=rsItemDet.Fields("SalePrice").value%>" name="totprice" size="6" style="border-style: solid; border-width: 1">
				      <% End If %>
				      </td>				      
				      <td width="57" height="14"> 
				          <input type="checkbox" name="del" value="<%=rsItemDet.Fields("ItemID").value%>">
				      </td>
				    </tr>
				    <% rsItemDet.MoveNext %>
					<% ii = ii + 1%>
				    <% Wend %>
				    <%
						rsItemDet.Close
						Set rsItemDet = Nothing
						Conn.Close
						Set Conn = Nothing
					 %>
				    <tr bgcolor="#FFCC66"> 
				      <td height="13" colspan="3" align="right" width="240" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium" bordercolor="#FF6600"> 
				        <p align="left"> 
				        <p> 
				          <b><font size="1" face="Verdana" color="#000080">General Voucher :&nbsp;&nbsp;
				          </font></b></td>
				      <td height="13" colspan="3" align="right" width="240" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium" bordercolor="#FF6600"> 
				        <input name="genvoucher" size="8" style="border-style: solid; border-width: 1; float:left" tabindex="4"><font size="1" face="Verdana" color="#000080">
				        <!--<a href="javascript:UpdateCart()"><b>Update Cart</font></b></a>-->&nbsp;&nbsp;&nbsp;&nbsp;
				        </td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="1" align="right" width="274" colspan="3"> 
				       <b><font size="1" face="Verdana" color="#000080">Grand 
				          Total :&nbsp;&nbsp; </font></b></td>
				      <td height="1" align="right" width="290" colspan="3"> 
				          <input name="grandprice"readonly size="8" style="border-style: dotted; border-width: 0; float:left"></td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="1" align="right" width="587" style="border-right-style: none; border-right-width: medium; border-bottom-style:solid; border-bottom-width:1" bordercolor="#FF6600" colspan="6"> 
				      &nbsp;
				      </td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="1" align="right" width="138" style="border-right-style: none; border-right-width: medium; border-bottom-style:solid; border-bottom-width:1" bordercolor="#FFCC66"> 
				        <p align="center"><b><font size="1" face="Verdana" color="#000080">
                        Empty Cart</font></b>
				      </td>
				      <td height="1" align="right" width="310" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-bottom-style:solid; border-bottom-width:1" bordercolor="#FFCC66" colspan="3"> 
				        <p align="center"> 
				        <b><font size="1" face="Verdana" color="#000080">&nbsp; Continue 
				          Shopping</font></b>
				      </td>
				      <td height="1" colspan="2" align="right" width="139" style="border-left-style: none; border-left-width: medium; border-bottom-style:solid; border-bottom-width:1" bordercolor="#FFCC66"> 
				        <p align="center"><b><font face="Verdana" size="1" color="#000080">Check 
				          Out</font></b>
				      </td>
				    </tr>
				  </table>
				  <form>
				</body>
				</html>
	<%
				End If
			Else
	%>
				<script>
					alert("Your shopping cart is empty.")
					window.location.href="eStore.asp"
				</script>
<%
		End If
	Else
%>
		<script>
			alert("Please login to view your cart.")
			window.location.href = "LoginDetails.asp"	
		        </script>
<%
   End If
%>