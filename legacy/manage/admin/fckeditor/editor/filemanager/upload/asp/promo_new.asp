<%@Language = VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include FILE = "connection.asp" -->
<%
	Dim sql,rs
	sql = "Select CategoryID,CategoryName,ImagePath,Description from CategoryMaster where Promo = 1 order by DisplayOrder"
	Set rs = Server.CreateObject("ADODB.Recordset")
	rs.Open sql,Conn,adOpenDynamic,adLockOptimistic 
%>
<HTML>
<HEAD>
<meta http-equiv="Content-Language" content="en-us">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<script language="javascript">
</script>
<TITLE>Mall Of India</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1252">
<SCRIPT Language=javascript>
function AddToCart(str)
{
	//alert(str)
	window.open("ViewCart.asp?ItemId=" + str,"","STATUSBAR,HEIGHT=400,WIDTH=600,LEFT=100,TOP=100,SCROLLBARS")
}
</SCRIPT>
</HEAD>
<BODY>
<% If rs.EOF = True And rs.BOF = True Then%>
	<table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="101%" id="AutoNumber1" height="23">
	<tr>
		<td colspan=2 rowspan=2 height="1" bgcolor="#FFA500">
        <p align="center"><b>No Categories for promotion</b></td>
	</tr>
	</table><br>
<% Else %>
<% rs.MoveFirst %>
	<%
		Dim Count
		Count = 0
		While rs.EOF <> True 
			Count = Count + 1
			rs.MoveNext 
		Wend
		Dim i,j
		i = 0  
		j = 0
	%>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <% rs.MoveFirst %>
                        <tr>
                          <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                              <tr>
                                <td align="center"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><img src="<%=rs.Fields(2).value%>" width=73 height=74></a></td><% rs.MoveNext %>
                              </tr>
                              <tr>
							  <% rs.MovePrevious%>
                                <td><span class="gray f10 bold"><%=rs.Fields(3).value%></span> <br />
                                    <span class="dred">Price:</span><span class="gray f10 bold">$10.00<br />
                                      <br />
                                  <a href="AddToCart.asp?ItemId=<%=rs.Fields(0).Value%>"><img src="images/button_add_to_cart.gif" width="69" height="16" hspace="2" border="0" /></a><a href="MoreItemDets.asp?ItemId=<%=rs.Fields(0).Value%>"><img src="images/button_details.gif" width="69" height="16" hspace="2" border="0" /></a></span></td>
								  <% rs.MoveNext %>
                              </tr>
                          </table></td>
                          <td class="dote">&nbsp;</td>
                          <td valign="top"><table width="100%" border="0" cellspacing="2" cellpadding="2">
                              <tr>
                                <td align="center"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><img src="<%=rs.Fields(2).value%>" width=73 height=74></a></td>
                              </tr>
                              <tr>
                                <td><span class="gray f10 bold"><%=rs.Fields(3).value%></span> <br />
                                    <span class="dred">Price:</span><span class="gray f10 bold">$10.00<br />
                                    <br />
                                  <a href="AddToCart.asp?ItemId=<%=rs.Fields(0).Value%>"><img src="images/button_add_to_cart.gif" width="69" height="16" hspace="2" border="0" /></a><a href="MoreItemDets.asp?ItemId=<%=rs.Fields(0).Value%>"><img src="images/button_details.gif" width="69" height="16" hspace="2" border="0" /></a></span></td>
                              </tr>
                          </table></td>
                        </tr>
						<% End If %>
                    </table>
</BODY>
</HTML>
<%
	rs.Close 
	Set rs = Nothing
	Conn.Close
	Set Conn = Nothing
%>