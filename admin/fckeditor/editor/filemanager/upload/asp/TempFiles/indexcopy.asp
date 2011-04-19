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
%>
<HTML>
<HEAD>
<meta http-equiv="Content-Language" content="en-us">
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
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

</script>
<TITLE>Mall Of India</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1252">
</HEAD>
<BODY OnLoad=Show() BGCOLOR=#ffffff leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid">
<div id="Layer1" style="position:absolute; left:35; top:65; width:68; height:16; z-index:1"> 
  <div align="center">
  <a href="ShowCatItems.asp?CatId=1" target="DisplayArea"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#663300"><b>For 
    Him</b></font></a> </div>
</div>
<div id="Layer2" style="position:absolute; left:133; top:67; width:59; height:17; z-index:2"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=2" target="DisplayArea"><font size="1" color="#663300"><b>For Her</b></font></a></div>
</div>
<div id="Layer3" style="position:absolute; left:222; top:67; width:54; height:17; z-index:3"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=3" target="DisplayArea"><font size="1"><b><font color="#663300">For Kids</font></b></a> 
    </font></div>
</div>
<div id="Layer4" style="position:absolute; left:282; top:64; width:100; height:16; z-index:4"> 
  <div align="center"><a href="eStore.asp" target="DisplayArea"><font size="2" color="#663300"><b><font size="1">For All</font> 
    </b></font></a></div>
</div>
<div id="Layer5" style="position:absolute; left:385; top:67; width:70; height:17; z-index:5"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=4" target="DisplayArea"><font size="1" color="#663300"><b>For Office </b></font></a></div>
</div>
<div id="Layer6" style="position:absolute; left:469; top:67; width:70; height:20; z-index:6"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=5" target="DisplayArea"><font size="1"><b><font color="#663300">For Home </font></b></font><a href="ShowCatItems.asp?CatId=5" target="DisplayArea"></div>
</div>
<div id="Layer7" style="position:absolute; left:544; top:68; width:83; height:19; z-index:7"> 
  <div align="center"><a href="ShowCatItems.asp?CatId=6" target="DisplayArea"><font size="1" color="#663300"><b>Entertainment</b></font></a></div>
</div>
<div id="Layer8" style="position:absolute; left:644px; top:83px; width:25px; height:16px; z-index:8"></div>
<div id="Layer9" style="position:absolute; left:625; top:68; width:70; height:19; z-index:9"> 
  <div align="center"><font size="1"><b><font color="#663300">Home</font></b></font></div>
</div>
<table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="24">
  <tr>
    <td width="42%" height="12" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" colspan="2" rowspan="2" 
   >&nbsp; <IMG src="images/Malllogo.jpg"></td>
    <td width="24%" height="12" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" rowspan="2" 
   >
    </td>
    <td width="17%" height="12" align="right" valign="bottom" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" rowspan="2" 
   ></td>
    <td width="17%" height="6" align="right" valign="bottom" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    
    </td>
  </tr>
  <tr>
    <td width="17%" height="6" align="right" valign="bottom" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    
    </td>
  </tr>
  <tr>
    <td width="21%" height="9" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none"></td>
    <td width="21%" height="9" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    </td>
    <td width="16%" height="9" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    <p align="center">
    </p>
    </p>
    </td>
    <td width="42%" height="9" colspan="2" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none">
    </td>
  </tr>
  
</table>
<table border="1" cellpadding="0" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" height="28">
<tr>
	<td style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
   >
    <IMG height=21 src="images/top.jpg" width=784>
	</td>
</tr>
</table>
<div align="center">
  <center>
  <table border="1" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#111111" width="99%" id="AutoNumber2" height="306" cellpadding="3">
    <tr>
      <td width="21%" height="304" align="left" valign="top" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
   >
      <table border="1" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#ffa500" width="100%" id="AutoNumber3" height="184">
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: 1px solid" height  ="12" bordercolor="#ffa500">
          <IMG src="images/rose.jpg"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid" 
          bordercolor="#ffa500" height="12" 
         >
          <font color="#cc0099"><b>
          Information</b></font></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
          height="12" 
          bordercolor="#ffa500"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" bordercolor="#ffa500" height="13"></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" height  ="22" bordercolor="#ffa500">
          <IMG src="images/rose.jpg"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" 
          bordercolor="#ffa500" height="23" 
         >
          <font color="#cc0099"><a href="javascript:Terms()"><b>Terms &amp; Conditions</b></a></font></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
          height="12" 
          bordercolor="#ffa500"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" bordercolor="#ffa500" height="13"></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" height  ="22" bordercolor="#ffa500">
          <a href="MyAccount.asp" target="DisplayArea"><IMG src="images/rose.jpg"></a></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" 
          bordercolor="#ffa500" height="23" 
         >
          <font color="#cc0099"><a href="MyAccount.asp" target="DisplayArea"><b>My Account</b></a></font></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
          height="12" 
          bordercolor="#ffa500"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" bordercolor="#ffa500" height="13"></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" height  ="22" bordercolor="#ffa500">
          <a href="javascript:FAQ()"><IMG src="images/rose.jpg"></A></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" 
          bordercolor="#ffa500" height="23" 
         >
          <font color="#cc0099"><a href="javascript:FAQ()"><b>FAQ's</b></a></font></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
          height="12" 
          bordercolor="#ffa500"></td>
          <td width="86%" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" bordercolor="#ffa500" height="13"></td>
        </tr>
        <tr>
          <td width="14%" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none; BORDER-TOP: medium none" bordercolor  ="#ffa500" height="22">
          <a href="SaleItems.asp" target=DisplayArea><IMG src="images/rose.jpg"></a></td>
          <td width="86%" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid; BORDER-TOP: medium none" 
          bordercolor="#ffa500" height="23">
          <font color="#cc0099"><a href="SaleItems.asp" target=DisplayArea><b>Products On Sale</b></a></font></td>
        </tr>
      </table><br>
      <table border="1" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#ffa500" width="100%" id="AutoNumber4" height="203" bgcolor="#ffffff">
        <tr>
          <td width="100%" height="13" bgcolor="#ffa500">
          &nbsp;</td>
        </tr>
        <tr>
          <td width="100%" height="187" align="left" valign="top" bgcolor="#ffffff">
          <table border="1" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="orange" width="100%" id="AutoNumber7" height="194" cellpadding="2">
            <tr>
              <td width="100%" height="190" align="left" valign="top">
              &nbsp;</td>
            </tr>
            </table>
          </td>
        </tr>
      </table>
      </td>
      <td width="60%" height="304" align="left" valign="top" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
   >
      
	
      <center>
      <DIV></DIV>
    
    <iframe Name="DisplayArea" Frameborder="0" Src="eStore.asp?page=0" Height="412" Width="444" style="BACKGROUND-COLOR: #ffa500; BORDER-BOTTOM: #ffa500 1px solid; BORDER-LEFT: #ffa500 1px solid; BORDER-RIGHT: #ffa500 1px solid; BORDER-TOP: #ffa500 1px solid" 
     ></iframe></center></td>
      <td width="20%" height="304" align="left" valign="top" style="BORDER-BOTTOM: medium none; BORDER-LEFT: medium none; BORDER-RIGHT: medium none; BORDER-TOP: medium none" 
   >
      <table border="1" cellpadding="2" cellspacing="0" style="BORDER-COLLAPSE: collapse" bordercolor="#ffa500" width="96%" id="AutoNumber5" bgcolor="#ffffff">
        <tr>
          <td width="100%" colspan="2" align="middle" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid" 
          bgcolor="#ffa500"><b>Search Items</b></td>
        </tr>
        <tr>
          <td width="50%" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: medium none" bgcolor   ="#ffffff">
          <input name="txtSearch" size="13" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid" 
           ></td>
          <td width="50%" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: medium none; BORDER-RIGHT: 1px solid" bgcolor   ="#ffffff">
          <font color="#cc0099"><b>Go</b></font></td>
        </tr>
      </table>
      <br><br>
      <br>
      <br><br>
      
      <table border="1" cellpadding="2" cellspacing="0" style="BORDER-BOTTOM: 1px solid; BORDER-COLLAPSE: collapse; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid" 
      bordercolor="#ffa500" width="138" id="AutoNumber6" 
      bgcolor="#ffffff">
      <tr>
      	<td width="132" bgcolor="#ffa500">
        <p align="center"><b>Browse By Budget</b></p></td>
      </tr>
      <tr>
      <form name="frmBrowseByBudget" action="BrowseByBudget.asp" method="get">
      	<td bgcolor="#ffffff" width="132">
        <p align="center"><FONT face=Verdana size=1>      	
      <SELECT id=select1 name=SelectBudget onchange="BrowseByBudget(this.value)" style="BORDER-BOTTOM: #111111 2px solid; BORDER-LEFT: #111111 2px solid; BORDER-RIGHT: #111111 2px solid; BORDER-TOP: #111111 2px solid; COLOR: #111111; FONT-FAMILY: Verdana; FONT-SIZE: 8pt; FONT-WEIGHT: bold; TEXT-ALIGN: left"> 
			<OPTION selected value="0">Select Range</OPTION>
			<OPTION value=1-10>$10 &amp; Below</OPTION>
			<OPTION value=11-20>$11 to $20</OPTION>
			<OPTION value=21-50>$25 to $50</OPTION>
			<OPTION value=51-100>$50 &amp; above</OPTION>
	  </SELECT></FONT></p></td></form>
      </tr>
	  </table><br>
      <br><br>
      <table border="0" cellspacing="0" style="border-style:solid; border-width:1; BORDER-COLLAPSE: collapse; " bordercolor="#ffa500" width="97%" id="AutoNumber6" bgcolor="#ffa500" height="46">
        <tr>
          <td width="65%" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: medium  none" bordercolor="#ffa500" colspan="3" 
         >
          <p align="center">
          <b>Top Ten Items</b></p></td>
        </tr>
        <% If rsTop5.EOF = True  And rsTop5.BOF = True Then %>
        	<tr>
          		<td width="65%" colspan=3 bgcolor="#ffffff" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-RIGHT: 1px solid; BORDER-TOP: 1px solid"   
          height="10" 
          bordercolor="#ffa500">
          		No Items.
          		</td>
        	</tr>
        <% Else %>
        	<% rsTop5.MoveFirst %>
        	<% While rsTop5.EOF <> True %>        	
        <tr>
          <td width="70%" bgcolor="#ffffff" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-TOP: 1px solid; BORDER-RIGTH: 1px solid"  
          bordercolor="#ffa500">
          <A href="ItemDetails.asp?ItemId=<%=rsTop5.Fields(0).Value%>" style="COLOR: red" target=DisplayArea><%= rsTop5.Fields(1).Value %></A></FONT>
          </td>          
          <%If rsTop5.Fields(3).Value = 0 or rsTop5.Fields(3).Value = "" Then %>
          <td width="30%" bgcolor="#ffffff" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-TOP: 1px solid;  BORDER-RIGTH: 1px solid" 
          bordercolor="#ffa500" 
         >
          $ <%=rsTop5.Fields(2).Value%>
          </td>
          <% Else %>
          <td width="30%" bgcolor="#ffffff" style="BORDER-BOTTOM: 1px solid; BORDER-LEFT: 1px solid; BORDER-TOP: 1px solid;  BORDER-RIGTH: 1px solid; border-right-style:solid; border-right-width:1" 
          bordercolor="#ffa500" 
         >
          $ <%=rsTop5.Fields(3).Value%>
          </td>
          <% End If %>
         </tr>
        	<% rsTop5.MoveNext %>
        <% Wend %>
        <% End If %>
        </table>
      <br>
      
      </td></tr></table></center>
      
    </div>
</a>
<table width="778">
	<tr>
		<td colspan="4" width="772" bgcolor="#FFA500" bordercolor="#FFA500">&nbsp;</td>
	</tr>
</table>
</BODY>
</HTML>
<%
	Conn.Close
	Set Conn = Nothing
%>