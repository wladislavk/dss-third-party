<%@ Language=VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<% If Session("EmailID") <> "" Then
	Session("EmailID") = ""
	Session("CartItems") = ""
	Session.Abandon()
%>
		<script>			
			window.location.href = "promo.asp"
		</script>
<%
   Else
%>
		<script>
			alert("You need to login first.")
			window.location.href = "LoginDetails.asp"
		</script>		
<%
	End If
%>
