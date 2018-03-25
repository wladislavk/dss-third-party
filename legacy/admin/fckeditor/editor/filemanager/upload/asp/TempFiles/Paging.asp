<!-- #include file="adovbs.inc" -->
<%
' BEGIN USER CONSTANTS
Dim CONN_STRING
Dim CONN_USER
Dim CONN_PASS
CONN_STRING = "DBQ=" & Server.MapPath("Mall.mdb") & ";"
CONN_STRING = CONN_STRING & "Driver={Microsoft Access Driver (*.mdb)};"

' BEGIN RUNTIME CODE
' Declare our vars
Dim iPageSize       'How big our pages are
Dim iPageCount      'The number of pages we get back
Dim iPageCurrent    'The page we want to show
Dim strOrderBy      'A fake parameter used to illustrate passing them
Dim strSQL          'SQL command to execute
Dim objPagingConn   'The ADODB connection object
Dim objPagingRS     'The ADODB recordset object
Dim iRecordsShown   'Loop controller for displaying just iPageSize records
Dim I               'Standard looping var

iPageSize = 3 ' You could easily allow users to change this

' Retrieve page to show or default to 1
If Request.QueryString("page") = "" Then
	iPageCurrent = 1
Else
	iPageCurrent = CInt(Request.QueryString("page"))
End If

Set objPagingConn = Server.CreateObject("ADODB.Connection")
objPagingConn.Open CONN_STRING

Set objPagingRS = Server.CreateObject("ADODB.Recordset")
objPagingRS.PageSize = iPageSize

objPagingRS.CursorLocation = adUseClient
objPagingRS.CacheSize = iPageSize

objPagingRS.Open "Select * from CategoryMaster", objPagingConn, adOpenStatic, adLockReadOnly


iPageCount = objPagingRS.PageCount

If iPageCurrent > iPageCount Then iPageCurrent = iPageCount
If iPageCurrent < 1 Then iPageCurrent = 1

If iPageCount = 0 Then
	Response.Write "No records found!"
Else
	' Move to the selected page
	objPagingRS.AbsolutePage = iPageCurrent

	' Start output with a page x of n line
	%>
	<p>
	<font size="+1">Page <strong><%= iPageCurrent %></strong>
	of <strong><%= iPageCount %></strong></font>
	</p>
	<%
	' Loop through our records and ouput 1 row per record
	iRecordsShown = 0
	Do While iRecordsShown < iPageSize And Not objPagingRS.EOF
		For I = 0 To objPagingRS.Fields.Count - 5
%>
			
<div align="center">
  <center>
  <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="54%" id="AutoNumber1" height="141">
    <tr>
      <td width="29%" height="120" align="left" valign="top"><%=ObjPagingRS.Fields("ImagePath").Value%></td>
      <td width="71%" height="141" align="left" valign="top">
      <%=ObjPagingRS.Fields("Description").Value%></td>
    </tr>
    </table>
  </center>
</div>
<p><%Next 'I
		' Increment the number of records we've shown
		iRecordsShown = iRecordsShown + 1
		' Can't forget to move to the next record!
		objPagingRS.MoveNext
	Loop

	' All done - close table
	'Response.Write "</table>" & vbCrLf
End If

' Close DB objects and free variables
objPagingRS.Close
Set objPagingRS = Nothing
objPagingConn.Close
Set objPagingConn = Nothing
%>

<table width=100% border=1>
<%
If iPageCurrent > 1 Then
	%>
	<tr>
	<td>
	<a href="Paging.asp?page=<%= iPageCurrent - 1 %>&order=<%= Server.URLEncode(strOrderBy) %>">[&lt;&lt;Prev]</a>
	</td>
	<tr>
	<%
End If

' You can also show page numbers:
For I = 1 To iPageCount
	If I = iPageCurrent Then
		%>
		<%'= I %>
		<%
	Else
		%>
		
		<tr>
	<td>
	<a href="Paging.asp?page=<%= iPageCurrent - 1 %>&order=<%= Server.URLEncode(strOrderBy) %>">[&lt;&lt;Prev]</a>
	</td>
	<tr>
		<%
	End If
Next 'I

If iPageCurrent < iPageCount Then
	%>
	<tr>
	<td>
	<a href="Paging.asp?page=<%= iPageCurrent - 1 %>&order=<%= Server.URLEncode(strOrderBy) %>">[&gt;&gt;Next]</a>
	</td>
	<tr>
</p>
	<%
End If

' END RUNTIME CODE
%>