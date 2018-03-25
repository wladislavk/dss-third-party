<%@ Language=VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include file = "connection.asp" -->
<%
	Dim Count,i,Email,recs,Records,sqlPwd,RowCount
	Email = Request.Form.Item("txtEmail")
	sqlPwd = "Select Password from ShoppingCustomerMaster where CustID = '" & Email & "'" 
	Set recs = Server.CreateObject("ADODB.Recordset")
	recs.Open sqlPwd,Conn,adOpenDynamic,adLockOptimistic 
	If recs.EOF =  True And recs.BOF = True  Then
		'Response.Write "No such Email Id registered." 
		recs.Close 
		Set recs = Nothing
		
%>
		<script>
			alert("Invalid email id.")
		</script>
<%
	Else
		Dim mail
		Set mail = Server.CreateObject("CDONTS.NewMail")
		Dim HTML
		HTML = "<html>"
		HTML = HTML & "<head>"
		HTML = HTML & "<meta http-equiv=Content-Language content=en-us>"
		HTML = HTML & "<meta name=GENERATOR content=Microsoft FrontPage 5.0>"
		HTML = HTML & "<meta name=ProgId content=FrontPage.Editor.Document>"
		HTML = HTML & "<meta http-equiv=Content-Type content=text/html; charset=windows-1252>"
		HTML = HTML & "<title>Mail</title>"
		HTML = HTML & "</head>"
		HTML = HTML & "<body>"
		HTML = HTML & "<p>Dear Customer,</p>"
		HTML = HTML & "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your detladial login details as follows :</p>"
		HTML = HTML & "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Login ID"
		HTML = HTML & "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
		HTML = HTML & "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;"
		HTML = HTML & "&nbsp;&nbsp;&nbsp;&nbsp;" &  Email & "</p>"
		HTML = HTML & "<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Password "
		HTML = HTML & "or Pin&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
		HTML = HTML & recs.Fields("Password").Value & "</p>"
		HTML = HTML & "<p>Thank You,</p>"
		HTML = HTML & "<p>Customer Service</p>"
		HTML = HTML & "<p>DeltaDial.com</p>"
		HTML = HTML & "</body>"
		HTML = HTML & "</html>"	
		
		mail.BodyFormat = 0
		mail.MailFormat = 0
		mail.To = Email
		mail.From = "rahmanc@vcinetwork.com"
		mail.Subject = "Your DeltaDial details."
		mail.Body = HTML 
		mail.Send 
		set mail = nothing
		recs.Close 
		Set recs = Nothing
		Conn.Close
		Set Conn = Nothing
%>
		<script>
		 alert("Your password has been sent to the following email id :<%=Email%>")
		 window.history.back()
		</script>
<%
	End If
%>

