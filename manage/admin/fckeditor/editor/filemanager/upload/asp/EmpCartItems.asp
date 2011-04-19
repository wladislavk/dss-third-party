<%@ Language=VBScript %>
<%Option Explicit%>
<%Response.Buffer = True %>
<%	
	Session("CartItems") = ""
	Response.Redirect "ViewCartNew.asp"
%>
