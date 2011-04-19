<%@Language = VBScript %>
<% Option Explicit %>
<% Response.Buffer = True %>
<!-- #include FILE = "connection.asp" -->
<%
	Dim sqlTop5,rsTop5
	sqlTop5 = "Select ITM.ItemID, ITM.ItemName, ITM.OriginalPrice,ITM.SalePrice "
	sqlTop5 = sqlTop5 & "from ItemMaster ITM, TopFiveBestSellers TFBS " 
	sqlTop5 = sqlTop5 & "where ITM.ItemID = TFBS.ItemID order by TFBS.Rating "
	Set rsTop5 = Server.CreateObject("ADODB.Recordset")
	rsTop5.Open sqlTop5,Conn,adOpenDynamic,adLockOptimistic 


	Dim sql,rs
	sql = "Select * from CategoryMaster"
	Set rs = SErver.CreateObject("ADODB.Recordset")
	rs.Open sql,Conn,adOpenDynamic,adLockOptimistic 
	
%>
<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<title>Mall Of India</title>
<script language="javascript">
function Register()
{
window.open("Register.html","","height=400,width=645,left=75,top=75,scrollbars")
}
function BrowseByBudget(str)
{
	if(str=="0")
		{
			alert("Please select a valid card.")
		}
		else
		{
			//alert("Valid selection.")
			document.frmBrowseByBudget.target = "DisplayArea"
			document.frmBrowseByBudget.submit()
		}

}
function DispImg()
	{
		var myArray = new Array(3)
		myArray[0] = "AdOne.gif"
		myArray[1] = "AdTwo.gif"
		myArray[2] = "AdThree.gif"
		var i
		i = Math.round(Math.random() * 2) + 0
		document.fdkbck.src = "Feedbacks/" + myArray[i]	
	}
	function Show()
	{
		var intervalID 
		intervalID = setInterval("DispImg()",5000)
	}
	function Terms()
	{
		window.open("Terms.asp","","scrollbars,height=400,width=600,top=50,left=50")
	}

	function FAQ()
	{
		window.open("FAQ.asp","","scrollbars,height=400,width=600,top=50,left=50")
	}
	function Accol()
	{
		window.open("Accol.asp","","scrollbars,height=400,width=500,top=50,left=50")
	}


</script>

</head>

<body topmargin="0" leftmargin="0">
<div id="Layer1" style="position:absolute; left:40; top:61; width:68; height:16; z-index:1"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=1" target="DisplayArea"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#663300"><b>For 
    Him</b></font></a> </div>
</div>
<div id="Layer2" style="position:absolute; left:139; top:65; width:59; height:19; z-index:2"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=2" target="DisplayArea"><font size="1" color="#663300"><b>For 
    Her</b></font></a></div>
</div>
<div id="Layer5" style="position:absolute; left:385; top:65; width:70; height:17; z-index:5"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=4" target="DisplayArea"><font size="1" color="#663300"><b>For 
    Office </b></font></a></div>
</div>
<div id="Layer3" style="position:absolute; left:465; top:65; width:71; height:14; z-index:10">
  <div align="center"><a href="ShowCatItems.asp?CatId=4" target="DisplayArea"><font size="1" color="#663300"><b>For 
    Home</b></font></a></div>
</div>
<div id="Layer6" style="position:absolute; left:215; top:65; width:65; height:14; z-index:11"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=2" target="DisplayArea"><font size="1" color="#663300"><b>For 
    Kids </b></font></a></div>
</div>
<table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="5">
  <tr>
    <td width="52%" align="middle" height="40" style="border-bottom-style: none; border-bottom-width: medium">
    <IMG align=left src="images/malllogo.jpg"></td>
    <td width="48%" height="40" align="middle">
    <img src="images/banner.swf" width=10 height=39 align="left"></td>
  </tr>
  <tr>
    <td width="100%" align="middle" height="1" colspan="2" style="border-bottom-style: none; border-bottom-width: medium"></td>
  </tr>
  <tr>
    <td width="100%" align="middle" height="19" colspan="2" style="border-left-style:none; border-left-width:medium; border-right-style:none; border-right-width:medium; border-top-style:none; border-top-width:medium; border-bottom-style:solid; border-bottom-width:1" bgcolor="#FFFFFF">
    <div align="left">
      <table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#663300" width="52%" id="AutoNumber13">
        <tr>
          <td width="16%" align="center" bgcolor="#FFA500">
          <p><A href="javascript:Register()"><b>
    <font color="#000000">Register</font></b></A></td>
          <td width="16%" align="center" bgcolor="#FFA500"><A href="LoginDetails.asp" target=DisplayArea><b>
    <font color="#000000">Login</font></b></A></td>
          <td width="17%" align="center" bgcolor="#FFA500"><A href="Logout.asp" target=DisplayArea><b>
    <font color="#000000">Logout</font></b></A></td>
          <td width="17%" align="center" bgcolor="#FFA500"><A href="viewcartnew.asp" target=DisplayArea><b>
    <font color="#000000">View Cart</font></b></A></td>
          <td width="17%" align="center" bgcolor="#FFA500"><A href="eStoreMain.asp" target=DisplayArea>
    <b><font color="#000000">e-Store</font></b></A></td>
          <td width="17%" align="center" bgcolor="#FFA500"><A href="viewcartnew.asp" target=DisplayArea><b>
    <font color="#000000">Check Out</font></b></A></td>
        </tr>
      </table>
    </div>
    </td>
  </tr>
</table>
<table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber3">
  <tr>
    <td width="100%" style="border-top-style: none; border-top-width: medium"><IMG height=21 src="images/top.jpg" width=781></td>
  </tr>
</table>
<table border="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber4" height="220" cellpadding="2">
  <tr>
    <td width="18%" height="220" align="left" valign="top" rowspan="7" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    <table border="1" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#FFA500" width="97%" id="AutoNumber9" height="305">
      <tr>
        <td width="100%" height="28" align="left" valign="top">
        <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber10" height="53">
          <tr>
            <td align="middle" width="100%" bgcolor="#ffa500" height="20" style="BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" bordercolor="#FFA500">
            <a href="SaleItems.asp" target="DisplayArea"><b>
            <font color="#111111">Products On Sale</font></b></a></td>
          </tr>
          <tr>
            <td align="middle" width="100%" bgcolor="#ffffff" height="25" valign="top" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none">
            <a href="SaleItems.asp" target="DisplayArea"><p align="left">Click here to view the products on sale.</p></a></td>
          </tr>
        </table>
        </td>
      </tr>
      <tr>
        <td width="100%" height="18" align="left" valign="top" style="BORDER-LEFT: medium none; BORDER-RIGHT: medium none"  ></td>
      </tr>
      <tr>
        <td width="100%" height="30" align="middle" bgcolor="#ffa500">
        <p align="center"><b>Categories</b></p></td>
      </tr>
      <tr>
        <td width="100%" height="214" align="left" valign="top">
        <iframe Name="CatArea" Frameborder="0" Src="eStore.asp" Height="207" Width="167" border="0" style="border-style: solid; border-width: 0; ">
        </iframe>

        </td>
      </tr>
      <tr>
        <td width="100%" height="12" align="left" valign="top" style="BORDER-LEFT: medium none; BORDER-RIGHT: medium none"  >
  
        </td>
      </tr>

      <tr>
        <td width="100%" height="188" align="left" valign="top">
        <table border="1" cellpadding="2" cellspacing="1" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber11">    
          <tr>
            <td width="100%" bgcolor="#ffa500" colspan="2" align="middle" bordercolor="#FFA500"><b>Top 
            Ten Items</b></td>
          </tr>
          <% If rsTop5.EOF = True  And rsTop5.BOF = True Then %>
          <tr>
            <td width="100%" bordercolor="#FFA500" style="border-bottom-style: none; border-bottom-width: medium">No Items</td>
          </tr>
          <% Else %>
          <% rsTop5.MoveFirst %>
        	<% While rsTop5.EOF <> True %>        	
        		<tr>
          			<td width="70%" bgcolor="#ffffff" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none; BORDER-RIGTH: 1px solid; border-right-style:none; border-right-width:medium"  
          			bordercolor="#ffa500"><A href="ItemDetails.asp?ItemId=<%=rsTop5.Fields(0).Value%>" style="COLOR: red" target=DisplayArea><%= rsTop5.Fields(1).Value %></A></FONT> &nbsp;</td>          
          			<%If rsTop5.Fields(3).Value = 0 or rsTop5.Fields(3).Value = "" Then %>
          				<td width="30%" bgcolor="#ffffff" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none;  BORDER-RIGTH: 1px solid; border-right-style:none; border-right-width:medium" 
          				bordercolor="#ffa500">
          				$ <%=rsTop5.Fields(2).Value%>
          				</td>
          			<% Else %>
          				<td width="30%" bgcolor="#ffffff" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-TOP: medium none;  BORDER-RIGTH: 1px solid; border-right-style:none; border-right-width:medium" 
          				bordercolor="#ffa500">
          				$ <%=rsTop5.Fields(3).Value%>
         				</td>
          			<% End If %>
          		</tr>
          		<% rsTop5.MoveNext %>
        	<% Wend %>
        	<% End If %>
        </table>
        </td>
      </tr>
    </table>
    </td>
    <td width="62%" height="220" align="left" valign="top" rowspan="7" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
   >
    <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber12" height="518">
      <tr>
          <td width="100%" height="514" align="left" valign="top" bordercolor="#FFA500">
          <iframe Name="DisplayArea" Frameborder="0" Src="promo.asp" Height="507" Width="456" border="0" style="border-style: solid; border-width: 0">
        </iframe>
            <div id="Layer7" style="position:absolute; left:543; top:66; width:83; height:19; z-index:7"> 
              <div align="left"><a href="ShowCatItems.asp?CatId=6" target="DisplayArea"><font size="1" color="#663300"><b>Entertainment</b></font></a></div>
            </div>
            <div id="Layer4" style="position:absolute; left:308; top:62; width:50; height:17; z-index:4"> 
              <div align="center"><a href="eStoreMain.asp" target="DisplayArea"><font size="2" color="#663300"><b><font size="1">For 
                All</font> </b></font></a></div>
            </div>
            <div id="Layer9" style="position:absolute; left:637; top:66; width:45; height:19; z-index:9"> 
              <div align="center"><font size="1"><b><font color="#663300"><a href="promo.asp" target="DisplayArea">Home</font></b></font></a></div>
            </div>
          </td>
      </tr>
      </table>
    </td>
    <td width="20%" height="49" align="left" valign="top" style="BORDER-LEFT: medium none" >
    <table border="1" cellpadding="2" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#FFA500" width="100%" id="AutoNumber5" height="54">
      <tr>
        <td width="100%" bgcolor="#ffa500" height="27" style="border-left-style: solid; border-left-width: 1; border-right-style: solid; border-right-width: 1; border-top-style: solid; border-top-width: 1">
        <p align="center"><b>Search<font size="1"> Items</font></b></p></td>
      </tr>
      <tr>
        <td width="100%" height="24">
          <input name="txtSearch" size="13" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid" 
           ><b><font size="2">&nbsp; <font color="#ff00ff">Go</font></font></b></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="20%" height="15" align="left" valign="top" style="BORDER-LEFT: medium none" ></td>
  </tr>
  <tr>
    <td width="20%" height="1" align="left" valign="top" style="BORDER-LEFT: medium none" >
    <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#FFA500" width="100%" id="AutoNumber6" height="55">
      <tr>
        <td width="100%" bgcolor="#ffa500" height="27">
        <p align="center"><b>Browse By Budget</b></p></td>
      </tr>
      <tr>
        <td width="100%" height="25">
        <p align="center"><FONT face=Verdana size=1>  
       <form name="frmBrowseByBudget" action="BrowseByBudget.asp" method="get">    	
      <SELECT id=select1 name=SelectBudget onchange="BrowseByBudget(this.value)" style="BORDER-BOTTOM: #111111 2px solid; BORDER-LEFT: #111111 2px solid; BORDER-RIGHT: #111111 2px solid; BORDER-TOP: #111111 2px solid; COLOR: #111111; FONT-FAMILY: Verdana; FONT-SIZE: 8pt; FONT-WEIGHT: bold; TEXT-ALIGN: left"> 
			<OPTION selected value="0">Select Range</OPTION>
			<OPTION value=1-10>$10 &amp; Below</OPTION>
			<OPTION value=11-20>$11 to $20</OPTION>
			<OPTION value=21-50>$25 to $50</OPTION>
			<OPTION value=51-100>$50 &amp; above</OPTION>
	  </SELECT></FONT></p></td>
	  </form>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="20%" height="16" align="left" valign="top" style="BORDER-LEFT: medium none" ></td>
  </tr>
  <tr>
    <td width="20%" height="140" align="left" valign="top" style="BORDER-LEFT: medium none" >
    <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#FFA500" width="100%" id="AutoNumber7" height="167">
      <tr>
        <td width="100%" align="middle" height="165" >
        <b>Banner 1</b></td>
      </tr>
    </table>
    </td>
  </tr>
  <tr>
    <td width="20%" height="12" align="left" valign="top" style="BORDER-LEFT: medium none" ></td>
  </tr>
  <tr>
    <td width="20%" height="159" align="left" valign="top" style="BORDER-LEFT: medium none" >
    <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#FFA500" width="100%" id="AutoNumber8" height="184">
      <tr>
        <td width="100%" align="middle" height="182" >
        <b>Banner 2</b></td>
      </tr>
    </table>
    </td>
  </tr>
  </table>
  <table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="780" id="AutoNumber8" height="21">
  <tr>
  	<td height="19" bgcolor="#ffa500" align="middle" width="190"><a href="javascript:FAQ()"><b>FAQ</b></td>
  	<td height="19" bgcolor="#ffa500" align="middle" width="190"><a href="javascript:Terms()"><b>Terms</b></td>
  	<td height="19" bgcolor="#ffa500" align="middle" width="191"><b>Information</b></td>
  	<td height="19" bgcolor="#ffa500" align="middle" width="209"><a href="javascript:Accol()"><b>Accolades</b></A></td>
  </tr>
  </table>
</body>
</html>
<%
	Conn.Close
	Set Conn = Nothing
%>