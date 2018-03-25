<%@ Language=VBScript %>
<% Option Explicit %>
<!-- #include file = "connection.asp" -->
<%  
	Dim sqlCat,rsCat	
	sqlCat = "Select CM.CategoryID,  CM.CategoryName, CM.Description, CM.ImagePath, "
	sqlCat = sqlCat & "CM.DisplayOrder from CategoryMaster CM" 
	sqlCat = sqlCat & " order by CM.DisplayOrder"
	Set rsCat = Server.CreateObject("ADODB.Recordset")
	rsCat.Open sqlCat,Conn,adOpenDynamic,adLockOptimistic 
	Dim i,j
	i=0
	j=0
%>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>RealPin.COM -An online gift service.</TITLE>
<META content="text/html; charset=windows-1252" http-equiv=Content-Type>
<META content="gift,gifts,presents,online services,flowers,cake,cakes,
flowers,Sweets,sweet,coin,coins,Parties,party'" 
name=keywords>
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
</head>
<body bgcolor="#FFFFFF" topmargin="0">
 <center>
<div align="center">
  <center>
<TABLE bgColor=#ffffff border=0 cellPadding=2 height=99 cellSpacing=0 width="475" style="border-collapse: collapse" bordercolor="#111111">
  <TBODY>
       <tr>
       	<td bgcolor="#FFA500" height="18" width="459" colspan="4"><b><u>Categories</u> : </tr></td>
       </tr>        
<% If rsCat.EOF = True And rsCat.BOF = True Then %>
		<tr>
       	<td bgcolor="#FFFFFF" height="23" width="95" bordercolor="#FFFFFF">&nbsp;</tr></td>
       	<td bgcolor="#FFFFFF" height="23" width="4" bordercolor="#FFFFFF"></td>
       	<td bgcolor="#FFFFFF" height="23" width="4" bordercolor="#FFFFFF"></td>
       	<td bgcolor="#FFFFFF" height="23" width="356" bordercolor="#FFFFFF"><b>No Categories.</td>
       </tr>      
<% 
	Else
		rsCat.MoveFirst 
		While rsCat.EOF <> True
%>
	   <tr>
       	<td bgcolor="#FFFFFF" height="17" width="95" bordercolor="#FFFFFF"><A href="ShowCatItems.asp?CatId=<%=rsCat.Fields("CategoryID").value%>"><img height=100 width=100 border=1 src="<%=rsCat.Fields("ImagePath").value%>"></a></td>
       	<!--<td bgcolor="#66ccff"><%'=rsCat.Fields("CategoryName").value%></td>-->
       	<td bgcolor="#FFFFFF" height="31" width="356" align="left" valign="top" bordercolor="#FFFFFF" rowspan="2"><%=rsCat.Fields("Description").value%></td>
       	<td bgcolor="#FFFFFF" height="31" width="4" bordercolor="#FFFFFF" rowspan="2"></td>
       	<td bgcolor="#FFFFFF" height="31" width="4" bordercolor="#FFFFFF" rowspan="2"></td>       	
       </tr>
	   <tr>
       	<td bgcolor="#FFFFFF" height="14" align="center" width="95" bordercolor="#FFFFFF">
       		<A href="ShowCatItems.asp?CatId=<%=rsCat.Fields("CategoryID").value%>"><b><%=rsCat.Fields("CategoryName").value%></b></a>
       	</td>
       </tr>
       <tr>
         <td bgcolor="#FFFFFF" height="11" width="459" colspan="4" bordercolor="#FFFFFF">
         <hr noshade width="459" color="#000000" size="1"></td>
       </tr>      	
       <% rsCat.MoveNext %>
       <% Wend %>
<% End If%>
  </TBODY>
</TABLE>
  </center>
</div>

</HTML>
<%
	Conn.Close
	Set Conn = Nothing
%>