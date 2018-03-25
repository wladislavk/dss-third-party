<%@ Language=VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	Dim CatId
	CatId = Request.QueryString.Item("SelectBudget")
	'Response.Write CatId
	Dim Budget
	Budget = Split(CatId,"-",-1,1)
	Dim sqlCatItems,rsCatItems
	sqlCatItems = "SELECT ItemMaster.ItemID, ItemMaster.ItemName, ItemMaster.ShortDesc, "
	sqlCatItems = sqlCatItems & "ItemMaster.SmallImagePath, ItemMaster.OriginalPrice, ItemMaster.SalePrice "
	sqlCatItems = sqlCatItems & "FROM ItemMaster "
	sqlCatItems = sqlCatItems & "WHERE ItemMaster.OriginalPrice <= " & CDBL(Trim(Budget(1))) & " and ItemMaster.OriginalPrice >= " & CDBL(Trim(Budget(0))) 
	'Response.Write Budget(0) & "<BR>"
	'Response.Write Budget(1) & "<BR>"
	'Response.Write sqlCatItems & "<BR>"
	'or ItemMaster.SalePrice <=10 and "
	'sqlCatItems = sqlCatItems & "CategoryMaster.CategoryID = CategoryItemMaster.CategoryID "
	'sqlCatItems = sqlCatItems & "and CategoryMaster.CategoryID = " & CDBL(Trim(CatId)) & ";"
	Dim sqlDis,rsDis
	sqlDis = "Select ItemID,DiscountPrice from DiscountMaster"
	Set rsDis = Server.CreateObject("ADODB.Recordset")
	rsDis.Open sqlDis,Conn,adOpenDynamic,adLockOptimistic 
	
	Set rsCatItems = Server.CreateObject("ADODB.Recordset")
	rsCatItems.Open sqlCatItems,Conn,adOpenDynamic,adLockOptimistic 
%>
<HTML>
<HEAD>
<META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<SCRIPT Language=javascript>
function AddToCart(str)
{
	//alert(str)
	window.open("ViewCart.asp?ItemId=" + str,"","STATUSBAR,HEIGHT=400,WIDTH=600,LEFT=100,TOP=100,SCROLLBARS")
}
</SCRIPT>
</HEAD>
<BODY>
<div align="center" style="width: 405; height: 59">
  <center>
  
  <% If rsCatItems.EOF = True And rsCatItems.BOF = True Then%>
  			<table border="0" align=left cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="428" id="AutoNumber1" height="16" bgcolor="#66CCFF">
  			<tr>
  			<td bgcolor="#FFA500" width="422" style="border-style:solid; border-width:1; ">
            <p align="center"><b><font size="2">No Items in this category</font></b></td>
  			</tr>
  			<tr>
  			<td align="center" width="422" bgcolor="#FFFFFF" style="border-style:solid; border-width:1; ">&nbsp;</td>
  			</tr>
  			<tr>
  			<td align="center" bgcolor="#FFFACD" width="422" style="border-style:solid; border-width:1; "><b><a href="eStore.asp" target=DisplayArea>
            <font size="2">Back</font></a></b></td>
  			</tr>
			</table>
  <% Else%>
  		<% rsCatItems.MoveFirst %>
		<table border="0" align=left cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="405" id="AutoNumber1" height="47">
		<% While rsCatItems.EOF <> True %>			
			<tr>
				<td height="21" width="752" align="left" valign="top" colspan="2" bgcolor="#FFA500">
				<font size=2 family=verdana><b><%=rsCatItems.Fields(1).Value%></b></font>
				</td>			
			</tr>
			<tr>
				<td height="70" width="225" align="left" valign="top"><img src="<%=rsCatItems.Fields(3).value%>" height=100 width=100 border=1></td>			
				<td height="71" width="527" rowspan="2">
                <table border="0" cellpadding="2" cellspacing="0" style="border-width:0; border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" height="141">
                  <tr>
                    <td width="100%" height="82" valign="top" colspan="2"><%=rsCatItems.Fields(2).Value%></td>
                  </tr>
                  <% If (rsCatItems.Fields(5).Value <> 0) or (rsCatItems.Fields(5).Value = "") Then%>
					<tr>
					  <td width="23%" height="25" align="right">Regular Price : </td>
					  <td width="77%" height="25"><strike><%=rsCatItems.Fields(4).Value%></strike></td>
					</tr>
					<tr>
					  <td width="43%" height="30" align="right">Sale Price :</td>
					  <td width="57%" height="30"><%=rsCatItems.Fields(5).Value%></td>
					</tr>
                  <% Else %>
					<tr>
					  <td width="23%" height="25" align="right">Regular Price : </td>
					  <td width="77%" height="25"><%=rsCatItems.Fields(4).Value%></td>
					</tr>
					<tr>
					  <td width="43%" height="30" align="right">Sale Price :</td>
					  <td width="57%" height="30">Not On Sale</td>
					</tr>
                  <% End If%>
                </table>
                </td>			
			</tr>
			<tr>
				<td height="1" width="225" align="left">
				<font size=2 family=verdana><b><%=rsCatItems.Fields(1).Value%></b></font>
			</td>			
			</tr>
			<tr>
				<td height="25" width="684" colspan="2"><a href="AddToCart.asp?ItemId=<%=rsCatItems.Fields(0).Value%>">Add To Cart</a><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                <a href="MoreItemDets.asp?ItemId=<%=rsCatItems.Fields(0).Value%>">More Details........</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:window.history.back()"> Back</a></td>
			
			
			</tr>
			<tr>
				<td height="25" width="684" colspan="2"><hr noshade size=1></td>
			
			
			</tr>
		<%
				rsCatItems.MoveNext 
			 Wend
		%>
   <% End If%>
  </table>
  </center>
</div>
</BODY>
</HTML>
<%
	rsCatItems.Close 
	Set rsCatItems = Nothing
	Conn.Close
	Set Conn = Nothing
%>