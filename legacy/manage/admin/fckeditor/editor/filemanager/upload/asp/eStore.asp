<%@Language = VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include FILE = "connection.asp" -->
<%
	Dim sql,rs
	sql = "Select CategoryID,CategoryName,ImagePath,Description from CategoryMaster order by CategoryName"
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
		<td colspan=2 align="center" rowspan=2 height="1" bgcolor="#FFA500">
        <b>No Categories for promotion</b></td>
	</tr>
	</table><br>
<% Else %>
	<% rs.MoveFirst %>
	<% While rs.EOF <> True %>
		 <a target="DisplayArea" href="ShowCatItems.asp?CatId=<%=rs.Fields("CategoryID").Value%>"><font color=red>&gt;&gt;<b>&nbsp;<%=rs.Fields("CategoryName").Value %></b></font><br><br>
		<% rs.MoveNext %>
	<% Wend %>
<% End If %>
</BODY>
</HTML>