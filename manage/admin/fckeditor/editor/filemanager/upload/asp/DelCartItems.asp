<%@ Language=VBScript %>
<%Option Explicit%>
<%
	Dim F,F1
	F1 = Trim(Session("CartItems"))
	Response.Write "F1 = " & F1 & "<BR>"	
	Dim i,ItemIds,strTemp,a
	ItemIds = Split(Trim(Request.Form.Item("del")),",",-1,1)
	'Response.Write UBound(ItemIds) & "<BR>"
	For i = 0 To UBound(ItemIds)
		strTemp = Replace(F1,Trim(ItemIds(i))& ",","")
		F1 = strTemp
	Next
	'Response.Write "strTemp = " & strTemp & "<BR>"
	Session("CartItems") = F1 
	Response.Redirect "ViewCartNew.asp"
%>
