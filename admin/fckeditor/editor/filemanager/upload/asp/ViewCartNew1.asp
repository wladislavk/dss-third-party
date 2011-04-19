<%@ Language="VBScript" %>
<%Option Explicit%>
<!-- #include file = "connection.asp" -->
<% If Session("LoginStatus") = True Then
	'Response.Write "Sess = " & Session("UsersLoginID")
		If Session("CartItems") <> "" Then
			Dim ij
			'For ij = 1 To Request.Form.Count
				'Response.Write Request.Form.Key(ij) & " = " & Request.Form.Item(ij) & "<BR>"
			'Next
		End If
		Dim count
		count = 0 
		Dim ItemIDs,ProdNames,Qtys,ProdPrice,ItmVouchers,TotPrice,GenVoucher,GrandPrice
		Dim NewTotPrice,NewGrandPrice
		NewTotPrice = 0 
		NewGrandPrice = 0
		 
		ItemIDs = Split(Trim(Request.Form.Item("txtItemID")),",",-1,1)
		ProdNames = Split(Trim(Request.Form.Item("ProdName")),",",-1,1)
		Qtys = Split(Trim(Request.Form.Item("qty")),",",-1,1)
		ProdPrice = Split(Trim(Request.Form.Item("ProdPrice")),",",-1,1)
		ItmVouchers = Split(Trim(Request.Form.Item("disvoucher")),",",-1,1)
		TotPrice = Split(Trim(Request.Form.Item("totprice")),",",-1,1)
		GenVoucher = Trim(Request.Form.Item("genvoucher"))
		GrandPrice = Trim(Request.Form.Item("grandprice"))
		Dim sqlIV,sqlGV,rsIV,rsGV
		sqlIV = "Select ItemID,VoucherNo,DiscountAmount "
		sqlIV = sqlIV & "from ItemVoucher where ItemID in ("
		sqlIV = sqlIV & Trim(Request.Form.Item("txtItemID")) & ")"
		
		sqlGV = "Select VoucherNo,DiscountAmount from GeneralVoucher where VoucherNo = '"
		sqlGV = sqlGV & GenVoucher & "'"
		Set rsIV = Server.CreateObject("ADODB.Recordset")
		Set rsGV = Server.CreateObject("ADODB.Recordset")
		rsIV.Open sqlIV,Conn,adOpenDynamic,adLockOptimistic
		rsGV.Open sqlGV,Conn,adOpenDynamic,adLockOptimistic 
%>
		<html>
		<head>
		<LINK href="images/Style1.css" rel=stylesheet type=text/css>
		<title>Mall Of India</title>
		<script>
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
		function EnableShipAdd(str)
			{
				//alert(str)
				if (str == "SAME")
				{
					document.frmCartItems.txtShipAdd.readOnly = true
				}
				if (str == "OTHER")
				{
					//alert(str)
					document.frmCartItems.txtShipAdd.readOnly = false
					document.frmCartItems.txtShipAdd.focus()
				}
			}
		</script>
		</head>
		<body>
		<form name="frmCartItems" method="post">
		<table border="1" width="399" height="114" id="AutoNumber1" bordercolorlight="#000000" bordercolordark="#000000" cellspacing="0" style="border-width:1; border-collapse: collapse" bordercolor="#FFCC66">
				    <tr bgcolor="#FFCC66"> 
				      <td height="12" colspan="6" valign="top" width="464" bordercolor="#000000" bgcolor="#FFA500">
				      <p align="center"><u><b><font face="Verdana" size="2" color="#000080">
                      Your Shopping Cart</font></b></u></td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="21" colspan="6" valign="top" width="464" bordercolor="#000000" bgcolor="#FFA500"><b>
				      <font face="Verdana" size="2">&nbsp;</font><font face="Verdana" size="1" color="#000080">All 
                      amount are in $</font></b></td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td width="196" height="15" align="center" bordercolor="#000000" bgcolor="#FFA500"><b> <font face="Verdana" size="1" color="#000080">
                      Item</font></b></td>
				      <td width="62" height="15" align="center" bordercolor="#000000" bgcolor="#FFA500"><b> <font face="Verdana" size="1" color="#000080">
                      Qty.</font></b></td>
				      <td width="137" height="15" align="center" bordercolor="#000000" bgcolor="#FFA500">
				      <p align="left"><b> <font face="Verdana" size="1" color="#000080">
                      Unit Price</font></b></td>
				      <td width="145" height="15" align="center" bordercolor="#000000" bgcolor="#FFA500"><b> <font face="Verdana" size="1" color="#000080">
                      Voucher No.</font></b></td>
				      <td width="78" height="15" align="center" bordercolor="#000000" bgcolor="#FFA500"><b> <font face="Verdana" size="1" color="#000080">
                      Total</font></b></td>
				      <!--<td width="57" height="15" align="center"> <font face="Verdana" size="1" color="#000080"> 
				        <a href="javascript:SubmitForm()"><b>Remove</font></td>-->
				    </tr>
				 <% If rsIV.EOF = True And rsIV.BOF = True Then %>
				    <% For count = 0 To UBound(ItemIDs) %>
				    <tr bgcolor="#FFCC66"> 
						<td width="196" height="14" bordercolor="#000000" bgcolor="#FFA500">
						<input type="text" value="<%=Trim(ProdNames(count))%>" readonly name="ProdName" size="20" style="border-style: solid; border-width: 1;"></td>
						<td width="62" height="14" bordercolor="#000000" bgcolor="#FFA500">				        
						    <input type="text" readonly value="<%=Trim(Qtys(count))%>" name="qty" size="3" style="border-style: solid; border-width: 1">
						</td>
						<td width="137" height="14" bordercolor="#000000" bgcolor="#FFA500">				      
							<input type="text" value="<%=Trim(ProdPrice(count))%>" readonly name="ProdPrice" size="5" style="border-style: solid; border-width: 1">
						</td>
						<td width="145" height="14" bordercolor="#000000" bgcolor="#FFA500">				         
						    <input name="disvoucher" value="none" readonly size="8" style="border-style:solid; border-width:1;">
						</td>				      
						<td width="78" height="14" align="left" bordercolor="#000000" bgcolor="#FFA500">				      
						<input readonly type="text" value="<%=Trim(TotPrice(count))%>" name="totprice" readonly size="6" style="border-style: solid; border-width: 1;">
						</td>				      
						<!--<td width="57" height="14"> 
						    <input type="checkbox" name="del" value="<%=Trim(ItemIDs(count))%>">
						</td>-->
				    </tr>
				    <% Next %>
				 <% Else %>
					<%
						rsIV.MoveFirst
						'While rsIV.EOF <> True 
						'Wend
					%>
					
					<%
						Dim ss,rr 	
						Set rr = Server.CreateObject("ADODB.Recordset")
						For count = 0 To UBound(ItemIDs)
					%>
							<tr bgcolor="#FFCC66"> 
								<td width="196" height="14" bordercolor="#000000" bgcolor="#FFA500">
								<input type="text" value="<%=Trim(ProdNames(count))%>" readonly name="ProdName" size="20" style="border-style: solid; border-width: 1;"></td>
								<td width="62" height="14" bordercolor="#000000" bgcolor="#FFA500">				        
								    <input type="text" readonly value="<%=Trim(Qtys(count))%>" name="qty" size="3" style="border-style: solid; border-width: 1">
								</td>
								<td width="137" height="14" bordercolor="#000000" bgcolor="#FFA500">				      
									<input type="text" value="<%=Trim(ProdPrice(count))%>" readonly name="ProdPrice" size="5" style="border-style: solid; border-width: 1">
								</td>
					<%
					
							ss = "Select VoucherNo,DiscountAmount from ItemVoucher where "
							ss = ss & "VoucherNo = '" & Trim(ItmVouchers(count)) & "'"
							rr.Open ss,Conn,adOpenDynamic,adLockOptimistic 
							If rr.EOF = True And rr.BOF = True Then
					%>
								<td width="145" height="14" bordercolor="#000000" bgcolor="#FFA500">				         
									<input name="disvoucher" value="none" readonly size="8" style="border-style:solid; border-width:1;">
								</td>
								<td width="78" height="14" align="left" bordercolor="#000000" bgcolor="#FFA500">				      
									<input readonly type="text" name="totprice" value="<%=Trim(TotPrice(count))%>" readonly size="6" style="border-style: solid; border-width: 1;">
								</td>		
								
						  <% Else %>
						  <%
								Dim DisAmt,AdjAmt
								DisAmt = CDbl(Trim(rr.Fields("DiscountAmount").value))
								AdjAmt = CDbl(TotPrice(count)) - CDbl (DisAmt)
								AdjAmt = Round(AdjAmt,2)
								TotPrice(count) = AdjAmt 
								
						  %>
								<td width="169" height="14" bordercolor="#000000" bgcolor="#FFA500">				         
									<input name="disvoucher" value="<%=Trim(rr.Fields("VoucherNo").value)%>" readonly size="6" style="border-style:solid; border-width:1;">
								</td>
								<td width="77" height="14" align="left" bordercolor="#000000" bgcolor="#FFA500">				      
									<input readonly type="text" name="totprice" value="<%=Trim(TotPrice(count))%>" readonly size="6" style="border-style: solid; border-width: 1;">
								</td>	
						  <% End If %>
						  <% 
								rr.Close 
								'Set rr = Nothing
						  %>
						  <!--<td width="57" height="14"> 
				          <input type="checkbox" name="del" value="<%=Trim(ItemIDs(count))%>">
				      </td>-->
					<%
											
						Next
					%>
					</tr>					 
				 <% End If %>
				 
				 <% If rsGV.EOF = True And rsGV.BOF = True Then %>
					<%
							For count = 0 To UBound(ItemIDs)
								NewGrandPrice = NewGrandPrice + Trim(TotPrice(count))
							Next
							If NewGrandPrice < 0 Then
							%>
								<script>
								alert("Your total shopping amount should be > then the discount amount.")
								window.history.back()
								</script>
							
							<%
							Else
								NewGrandPrice = Round(NewGrandPrice,2)
							End If
							'NewGrandPrice = Round(NewGrandPrice,2)
					%>
				    <tr bgcolor="#FFCC66"> 
				      <td height="13" colspan="3" align="right" width="244" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium" bordercolor="#000000" bgcolor="#FFA500"> 
				        <p align="left"> 
				        <p> 
				          <b><font size="1" face="Verdana" color="#000080">
                          General Voucher :&nbsp;&nbsp;
				          </font></b></td>
				      <td height="13" colspan="3" align="right" width="265" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1" bordercolor="#000000" bgcolor="#FFA500"> 
				        <input name="genvoucher" value="<%=GenVoucher%>" readonly size="8" style="border-style: solid; border-width: 1; float:left" tabindex="4"><font size="1" face="Verdana" color="#000080"> </font>&nbsp;&nbsp;&nbsp;
				        </td>
				    </tr>
				    <tr bgcolor="#FFCC66"> 
				      <td height="1" align="right" width="278" colspan="3" bordercolor="#000000" bgcolor="#FFA500"> 
				       <b><font size="1" face="Verdana" color="#000080">Grand 
                       Total :&nbsp;&nbsp; </font></b></td>
				      <td height="1" align="right" width="315" colspan="3" bordercolor="#000000" bgcolor="#FFA500"> 
				          <input name="grandprice" value="<%=NewGrandPrice%>" readonly size="8" style="border-style: dotted; border-width: 0; float:left"></td>
				    </tr>				  
				  <% Else %>
						<%
							
							For count = 0 To UBound(ItemIDs)
								NewGrandPrice = NewGrandPrice + Trim(TotPrice(count))
							Next
							NewGrandPrice = CDbl(NewGrandPrice) - CDbl(Trim(rsGV.Fields("DiscountAmount").value)) 
							If NewGrandPrice < 0 Then
							%>
								<script>
								alert("Your total shopping amount should be > then the discount amount.")
								window.history.back()
								</script>
							
							<%
							Else
								NewGrandPrice = Round(NewGrandPrice,2)
							End If
							'NewGrandPrice = Round(NewGrandPrice,2)
							
						%>
						 <tr bgcolor="#FFCC66"> 
							  <td height="13" colspan="3" align="right" width="244" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium" bordercolor="#000000" bgcolor="#FFA500"> 
							    <p align="left"> 
							    <p> 
							      <b><font size="1" face="Verdana" color="#000080">
							      General Voucher :&nbsp;&nbsp;
							      </font></b></td>
							  <td height="13" colspan="3" align="right" width="265" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1" bordercolor="#000000" bgcolor="#FFA500"> 
							    <input name="genvoucher" value="<%=GenVoucher%>" readonly size="8" style="border-style: solid; border-width: 1; float:left" tabindex="4"><font size="1" face="Verdana" color="#000080"> </font>&nbsp;&nbsp;&nbsp;
							    </td>
							</tr>
							<tr bgcolor="#FFCC66"> 
							  <td height="1" align="right" width="278" colspan="3" bordercolor="#000000" bgcolor="#FFA500"> 
							   <b><font size="1" face="Verdana" color="#000080">Grand 
							   Total :&nbsp;&nbsp; </font></b></td>
							  <td height="1" align="right" width="315" colspan="3" bordercolor="#000000" bgcolor="#FFA500"> 
							      <input name="grandprice" value="<%=NewGrandPrice%>" readonly size="8" style="border-style: dotted; border-width: 0; float:left"></td>
						</tr>				  
				  <% End If %>
				    <tr bgcolor="#FFCC66"> 
				      <td height="33" align="right" width="306" style="border-right-style: solid; border-right-width: 1; border-bottom-style:solid; border-bottom-width:1" bordercolor="#000000" colspan="3" bgcolor="#FFA500"> 
				      <p align="left"> 
				      <b><br>
                      <br>
                      Message For Receiver : </b>
				      <textarea name="msg" rows="5" cols="25" style="text-align: justify; border-style: solid; border-width: 1"></textarea></td>
				      <td height="33" align="left" width="309" style="border-right-style: solid; border-right-width: 1; border-bottom-style:solid; border-bottom-width:1" bordercolor="#000000" colspan="3" valign="top" bgcolor="#FFA500"> 
				      <p><b>Please enter Item details here like 
                      size,weight,color etc.</b><textarea name="txtItemSizes" rows="5" cols="16" style="text-align: justify; border-style: solid; border-width: 1"></textarea></td>
				    </tr>
				    </table>
				    <table width="399" cellspacing="0" cellpadding="2" style="border-collapse: collapse" bordercolor="#FF6600" bgcolor="#FFCC66" height="116">
				    <tr>
				    	<td colspan="4" width="395" style="border-style: solid; border-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="15">
                        <b>Select Shipping Address</b></td>
				    </tr>
				    <tr>
				    	<td width="20" style="border-left-style: solid; border-left-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="22">
                        <input type="radio" name="SA" value="SAME" checked style="border-style: solid; border-width: 0" OnClick="EnableShipAdd(this.value)"></td>
				    	<td width="157" style="border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="21">
                        <b>Same as registration</b></td>
				    	<td width="20" style="border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="21">
                        <input type="radio" name="SA" value="OTHER" style="border-style: solid; border-width: 0" OnClick="EnableShipAdd(this.value)"></td>
				    	<td width="186" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="21">
                        <b>Other</b></td>
				    </tr>
				    <tr>
				    	<td colspan=2 width="10" style="border-left-style: solid; border-left-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="69">
				    	<textarea name="txtShipAdd" readonly rows="4" cols="25" style="border-style: solid; border-width: 1"></textarea>
                        </td>
				    	<td colspan=2 width="10" style="border-left-style: solid; border-left-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#000000" bgcolor="#FFA500" height="69">
				    	&nbsp;</td>
				    </tr>

					</table>
				    <table width="399" cellspacing="0" cellpadding="2" style="border-collapse: collapse" bordercolor="#111111">
				    <tr bgcolor="#FFCC66"> 
				      <td height="1" align="right" width="127" style="border-right-style: none; border-right-width: medium; border-bottom-style:solid; border-bottom-width:1; border-left-style:solid; border-left-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"> 
				        <p align="left"><a href="EmpCartItems.asp" target="DisplayArea"><b>
                        <font size="1" face="Verdana" color="#000000">
                        Empty Cart</font></b></a>
				      </td>
				      <td height="1" align="right" width="350" style="border-left-style: none; border-left-width: medium; border-right-style: none; border-right-width: medium; border-bottom-style:solid; border-bottom-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"> 
				        <p align="center"><a href="eStoreMain.asp" target="DisplayArea"> 
				        <b><font size="1" face="Verdana" color="#000000">Continue Shopping</font></b></a>
				      </td>
				      <td height="1" align="right" width="136" style="border-left-style: none; border-left-width: medium; border-bottom-style:solid; border-bottom-width:1; border-right-style:solid; border-right-width:1; border-top-style:solid; border-top-width:1" bordercolor="#000000" bgcolor="#FFA500"> 
				        <p><a href="javascript:CheckOutNow()" target="DisplayArea"><b>
                        <font face="Verdana" size="1" color="#000000">
                        Check Out</font></b></a>
				      </td>
				    </tr>
				  </table>	
				</form>			  
				</body>
				</html>

<%
		Conn.Close
		Set Conn = Nothing
   Else
%>		
		<script>
			alert("Please login to view your cart.")
			window.location.href = "LoginDetails.asp"	
		</script>
<%
   End If
%>