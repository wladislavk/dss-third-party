<%@ Language="VBScript" %>
<%Option Explicit%>
<%
	Dim ItemId,F
	ItemId = Request.QueryString.Item("ItemId")
	If ItemId <> "" Then
		Session("CartItems") = Session("CartItems") & ItemId & ","
	End If 
%>
	<script>
		alert("Item successfully added.\nPlease click on 'View Cart' to checkout.")
		window.history.back()
	</script>