<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<% option explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<table broder="1">
<%
dim strConn
dim rsTop
dim sqlStr
sqlStr="select * from News order by Created"

set rsTop=Server.CreateObject("ADODB.Recordset")
rsTop.Open sqlStr,Conn,adOpenDynamic,adLockOptimistic

if rsTop.BOF and rsTop.Eof then
response.Write("No Records Founds")
else
while not rsTop.eof
%>
<tr>
<td><a href="editNews.asp?newsid=<%=rsTop(0)%>"><%=rsTop(1)%></a></td>
</tr>
<%
rsTop.movenext
wend
end if
%>
</table>
