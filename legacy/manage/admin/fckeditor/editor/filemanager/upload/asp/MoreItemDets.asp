<%@ Language=VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	Dim ItemId
	ItemId = Trim(Request.QueryString.Item("ItemId"))
	'Response.Write CatId
	Dim sqlCatItems,rsCatItems
	sqlCatItems = "SELECT ItemMaster.ItemID, ItemMaster.ItemName, ItemMaster.LongDesc, "
	sqlCatItems = sqlCatItems & "ItemMaster.BigImagePath, ItemMaster.OriginalPrice, ItemMaster.SalePrice "
	sqlCatItems = sqlCatItems & "FROM ItemMaster "
	sqlCatItems = sqlCatItems & "WHERE ItemMaster.ItemID = " & ItemId  'CategoryItemMaster.ItemID and "
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
  <center>
  
  <% If rsCatItems.EOF = True And rsCatItems.BOF = True Then%>
  			<table border="0" align=left cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="471" id="AutoNumber1" height="16" bgcolor="#66CCFF">
  			<tr>
  			<td bgcolor="#FFA500" width="471" style="border-style:solid; border-width:1; ">
            <p align="center"><b><font size="2">No Item Detail Available</font></b></td>
  			</tr>
  			<tr>
  			<td align="center" width="471" bgcolor="#FFFFFF" style="border-style:solid; border-width:1; ">&nbsp;</td>
  			</tr>
  			<tr>
  			<td align="center" bgcolor="#FFFACD" width="471" style="border-style:solid; border-width:1; ">
            <b><a href="javscript:window.history.back()">
            <font size="2">Back</font></a></b></td>
  			</tr>
			</table>
  <% Else%>
 		<% rsCatItems.MoveFirst %>
		<table border="0" align=left cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="422" id="AutoNumber1" height="1">
		<% While rsCatItems.EOF <> True %>			
			<tr>
				<td height="21" width="418" align="left" valign="top" colspan="8" bgcolor="#FFA500" style="border-style: solid; border-width: 1" bordercolor="#FFA500">
                <font family=verdana size=2><b><%=rsCatItems.Fields(1).value%></b></font></td>			
			</tr>
			<tr>
				<td height="1" width="152" align="left" valign="top" colspan="4" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1" bordercolor="#FFA500">
                <img src="<%=rsCatItems.Fields(3).value%>" height=100 width=100 border=1></td>			
				<td height="1" width="262" rowspan="2" colspan="4" style="border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500">
                <table border="0" cellpadding="2" cellspacing="0" style="border-width:0; border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2" height="141">
                  <tr>
                    <td width="100%" height="82" valign="top" colspan="2"><%=rsCatItems.Fields(2).Value%></td>
                  </tr>
                  <% If (rsCatItems.Fields(5).Value <> 0) or (rsCatItems.Fields(5).Value = "") Then%>
					<tr>
					  <td width="28%" height="25" align="right">Regular Price : </td>
					  <td width="72%" height="25"><strike><%=rsCatItems.Fields(4).Value%></strike></td>
					</tr>
					<tr>
					  <td width="48%" height="30" align="right">Sale Price :</td>
					  <td width="52%" height="30"><%=rsCatItems.Fields(5).Value%></td>
					</tr>
                  <% Else %>
					<tr>
					  <td width="28%" height="25" align="right">Regular Price : </td>
					  <td width="72%" height="25"><%=rsCatItems.Fields(4).Value%></td>
					</tr>
					<tr>
					  <td width="48%" height="30" align="right">Sale Price :</td>
					  <td width="52%" height="30">Not On Sale</td>
					</tr>
                  <% End If%>
                </table>
                </td>			
			</tr>
			<tr>
				<td height="1" width="152" align="left" colspan="4" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500"><b><%=rsCatItems.Fields(1).Value%></b></td>			
			</tr>
			<% 
				Dim sqlItmDet,rsItmDet
				sqlItmDet = "Select * from ItemMasterDetails where ItemID = " & ItemId
				Set rsItmDet = Server.CreateObject("ADODB.Recordset")
				rsItmDet.Open sqlItmDet,Conn,adOpenDynamic,adLockOptimistic
				If rsItmDet.EOF = True And rsItmDet.BOF = True Then
			%>
				<TR>
					<td align="center" height="25" width="249" colspan="5" bordercolor="#FFA500" style="border-left-style: solid; border-left-width: 1; border-right-style: none; border-right-width: medium">
                    <b>No Details</td>	
                    <td style="border-left-style: none; border-left-width: medium">
                    </td>
                    <td>
                    </td>

<td style="border-right-style: solid; border-right-width: 1" bordercolor="#FFA500">
                    </td>

				</TR>
				<% Else %>
					<% rsItmDet.MoveFirst%>
			<tr>
				<td height="25" width="406" colspan="8" style="border-style: solid; border-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">&nbsp;</td>			
			
			
			</tr>
			<tr>
				<td height="25" width="82" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">Brand Name :</td>			
				<td height="25" width="66" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500"><%=rsItmDet.Fields("BrandName").Value%></td>
			
			
				<td height="25" width="116" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">
                Color:&nbsp;&nbsp; </td>			
				<td height="25" width="142" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500"><%=rsItmDet.Fields("Color").Value%></td>
			
			
			</tr>
			<tr>
				<td height="25" width="44" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">
                Type :</td>			
				<td height="25" width="51" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500"><%=rsItmDet.Fields("Type").Value%></td>
			
			
				<td height="25" width="49" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">Weight :</td>			
				<td height="25" width="93" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500"><%=rsItmDet.Fields("Weight").Value%></td>
			
			
				<td height="25" width="40" colspan="2" style="border-style: solid; border-width: 1" bordercolor="#FFA500" bgcolor="#FFFFFF" align="right">Size :</td>			
				<td height="25" width="121" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500"><%=rsItmDet.Fields("Size").Value%></td>
			
			
			</tr>
			<% End If %>
			<tr>
				<td height="25" width="418" colspan="8" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-bottom-style: solid; border-bottom-width: 1; border-top-style: solid; border-top-width: 1" bordercolor="#FFA500"><a href="AddToCart.asp?ItemId=<%=rsCatItems.Fields(0).Value%>">Add To Cart</a><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <a href="javascript:window.history.back()">Back</a></td>
			
			
			</tr>
		<%
				rsCatItems.MoveNext 
			 Wend
		%>
   <% End If%>
  </table>
  </center>

</BODY>
</HTML>
<%
	rsCatItems.Close 
	Set rsCatItems = Nothing
	Conn.Close
	Set Conn = Nothing
%>