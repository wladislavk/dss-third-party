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
	<table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="102%" id="AutoNumber1" height="413">
	<% rs.MoveFirst %>
		<tr>
			<td width="50%" align=right height="31" bgcolor="#FFA500" style="border-style: solid; border-width: 1" bordercolor="#FFA500"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><font color="#000000"><b><%=rs.Fields(1).value%></b></a></td>
			<% rs.MoveNext %>
			<td width="50%" align=right height="31" bgcolor="#FFA500" style="border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1; border-bottom-style: solid; border-bottom-width: 1" bordercolor="#FFA500"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><font color="#000000"><b><%=rs.Fields(1).value%></b></a></td>
		</tr>
		<tr>
			<% rs.MovePrevious%>
			<td width="47%" height="102" style="border-right-style: solid; border-right-width: 1" bordercolor="#FFA500"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><img src="<%=rs.Fields(2).value%>" width=100 height=100></a></td>
			<% rs.MoveNext %>
			<td width="47%" height="102" style="border-right-style: solid; border-right-width: 1" bordercolor="#FFA500"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><img src="<%=rs.Fields(2).value%>" width=100 height=100></a></td>
		</tr>
		<tr>
			<% rs.MovePrevious%>
			<td width="47%" height="84" valign="top" style="text-indent: 35; border-right-style:solid; border-right-width:1" bordercolor="#FFA500"><%=rs.Fields(3).value%></td>
			<% rs.MoveNext %>
			<td width="47%" height="84" valign="top" style="text-indent: 35; border-right-style:solid; border-right-width:1" bordercolor="#FFA500"><%=rs.Fields(3).value%></td>
		</tr>
		<tr>
			<td width="100%" height="30" colspan="2" bgcolor="#FFFFFF" bordercolor="#FFFFFF"></td>
		</tr>
		<% rs.MoveNext %>
		
		<tr>
			<td width="50%" align=right height="31" bgcolor="#FFA500" bordercolor="#FFA500" style="border-top-style: none; border-top-width: medium"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><font color="#000000"><b><%=rs.Fields(1).value%></b></a></td>
			<% rs.MoveNext %>
			<td width="50%" align=right height="31" bgcolor="#FFA500" bordercolor="#FFA500" style="border-top-style: none; border-top-width: medium"><a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><font color="#000000"><b><%=rs.Fields(1).value%></b></a></td>
		</tr>
		<tr>
			<% rs.MovePrevious%>
			<td width="50%" height="102" bordercolor="#FFA500">
            <a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><img src="<%=rs.Fields(2).value%>" width=100 height=100></a></td>
			<% rs.MoveNext %>
			<a href="ShowCatItems.asp?CatId=<%=rs.Fields(0).value%>" target="DisplayArea"><td width="50%" height="102" bordercolor="#FFA500"><img src="<%=rs.Fields(2).value%>" width=100 height=100></a></td>
		</tr>
		<tr>
			<% rs.MovePrevious%>
			<td width="50%" height="84" valign="top" style="text-indent: 35" bgcolor="#FFFFFF" bordercolor="#FFA500"><%=rs.Fields(3).value%></td>
			<% rs.MoveNext %>
			<td width="50%" height="84" valign="top" style="text-indent: 35" bgcolor="#FFFFFF" bordercolor="#FFA500"><%=rs.Fields(3).value%></td>
		</tr>
<% End If %>
</table>
</a>
</BODY>
</HTML>
<%
	rs.Close 
	Set rs = Nothing
	Conn.Close
	Set Conn = Nothing
%>