<html>

<head>
<meta http-equiv="Content-Language" content="en-us">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Accolades</title>
<LINK href="images/Style1.css" rel=stylesheet type=text/css>
<script>
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

</script>
</head>
<body OnLoad=Show()>
<center>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="209" id="AutoNumber1" height="324">
  <tr>
    <td width="207" bgcolor="#FFa05" height="32" align="center" bordercolor="#FFA500"><b>Accolades</b></td>
  </tr>
  <tr>
    <td width="207" height="265" align="center" valign="top" bordercolor="#FFA500">
    <table border="0" align=center cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="97%" id="AutoNumber2" height="265" align="right">
      <tr>
        <td width="100%" height="263" align="center" valign="top">
        <p>
        <img name=fdkbck src="Feedbacks/Adone.gif">
        </td>
      </tr>      
    </table>
    </td>
  </tr>
  <tr>
      	<td height="23" bgcolor="#FFFFFF" align=center bordercolor="#FFA500" width="207"><A href="javascript:window.close()"><b>
        Close</b></A></td>
     </tr>
</table>
</center>
</body>

</html>