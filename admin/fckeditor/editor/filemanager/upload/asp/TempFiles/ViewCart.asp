<%@ Language="VBScript" %>
<%Option Explicit%>
<!-- #include file = "connection.asp" -->
<% If Session("LoginStatus") = True Then
	'Response.Write "Sess = " & Session("UsersLoginID")
		If Session("CartItems") <> "" Then
			
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
					window.location.href = "index.asp"
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
					<HTML>
						<HEAD>
						<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
						<LINK href="images/Style1.css" rel=stylesheet type=text/css>
						<TITLE>Cart Items</TITLE>
						</HEAD>
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
									//alert(str)
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
						</SCRIPT>
						<BODY OnLoad="Count(hdtextbox.value)">
						<center>
						<input type=hidden name="hdtextbox" value="<%=RecCount%>">
						<table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse" bordercolor="#FFFFFF" width="494" id="AutoNumber1" bgcolor="#66CCFF">
							  <tr>
							    <td width="150" align="left"><b>Name</b></td>
								<td width="69" align="center">
                                <p align="left"><b>Unit Price<br>
&nbsp;&nbsp; (in $)</b></td>
								<td width="67" align="center"><b>Quantity</b></td>
								
								<td width="75" align="center"><b>Total Price<br>
&nbsp;&nbsp; (in $)</b></td>
								<td width="61" align="left"><b><a href="javascript:SubmitForm()">Remove</a></b></td>

							  </tr>
							 <form name="frmCartItems" method="post" action="CheckOutNow.asp">	
							  <% While rsItemDet.EOF <> True %>
										  
							 <tr>
							  <td width="150" align="left">
							  <input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 150px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="<%=rsItemDet.Fields("ItemName").value%>" name="ProdName" readonly size="20"></td>
							  <td width="69" align="center">
							  
							  <%if rsItemDet.Fields("SalePrice").value = 0 Or rsItemDet.Fields("OriginalPrice").value = "" Then%>
							  <input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 40px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="<%=rsItemDet.Fields("OriginalPrice").value%>" name="ProdPrice<%'=ii%>" readonly size="20"></td>
							  <% Else%>
							  <input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 40px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="<%=rsItemDet.Fields("SalePrice").value%>" name="ProdPrice<%'=ii%>" readonly size="20"></td>
							  <%End If%>
							  <td width="67" align="center">
                              <input style="border-style:solid; border-width:1; WIDTH: 30px; COLOR: #000000; FONT-FAMILY: Verdana; HEIGHT: 20px" type="textbox" value=1 name="qty<%'=ii%>" size=5 OnBlur=CalTotal(this.name,this.value,hdtextbox.value)></td>
							  
							  <%if rsItemDet.Fields("SalePrice").value = 0 Or rsItemDet.Fields("OriginalPrice").value = "" Then%>
							  <td width="75" align="center"><input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 40px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="<%=rsItemDet.Fields("OriginalPrice").value%>" name="totprice<%'=ii%>" size=8 readonly></td>
							  <% Else%>
							  <td width="75" align="center"><input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 40px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="<%=rsItemDet.Fields("SalePrice").value%>" name="totprice<%'=ii%>" size=8 readonly></td>
							  <%End If%>
							  <td width="20" align="center">
							  <input type="checkbox" value="<%=rsItemDet.Fields("ItemID").value%>" name="del<%'=ii%>">
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
							  <tr>
								  <td width="474" align="left" colspan="6">&nbsp;</td>
								</tr>

								<tr>
								  <td width="474" align="left" colspan="6"><b>Grand&nbsp; Total :(in $)&nbsp;&nbsp;&nbsp;
								  </b><input type="textbox" style="BORDER-RIGHT: #000000 1px ; BORDER-TOP: #000000 1px ; BORDER-LEFT: #000000 1px ; WIDTH: 75px; COLOR: #000000; BORDER-BOTTOM: #000000 1px ; FONT-FAMILY: Verdana; HEIGHT: 20px" value="" name="grandprice" readonly size=10></td>
								</tr>
						</TABLE>
				
						<TABLE width="494" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
							<tr>
							<td width="159">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" height="10%" bgcolor="#C0C0C0" width="159"><b><A href="javascript:AddMore()">Add More Items</A></b></td>
							<td align="center" height="10%" bgcolor="#C0C0C0" width="174"><b><A href="javascript:window.history.back()">Back</A></b></td>
							<td align="center" height="10%" bgcolor="#C0C0C0" width="139"><b><A href="javascript:CheckOutNow()">Check Out</A></b></td>

						</form>
						</tr>
						</TABLE>
						</center>
						</BODY>
						</HTML>		
	<%
				End If
			Else
	%>
				<script>
					alert("Your shopping cart is empty.")
					window.history.back()
				        </script>
<%
		End If
	Else
%>
	<script>
		alert("Please login to view your cart.")
		//window.history.back()
		window.location.href = "LoginDetails.asp"
		//window.open("CartLogin.asp","","height=300,width=400,top=100,left=100")
	                    </script>
                        <p>&nbsp;</p>

<%
   End If
%>