<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script type="text/javascript" src="admin/popup/popup.js"></script>
<script src="/manage/js/add_new_sleeplab.js" type="text/javascript"></script>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
 <script type="text/javascript">
/* PopUp Calendar v2.1
© PCI, Inc.,2000 • Freeware
webmaster@personal-connections.com
+1 (925) 955 1624
Permission granted  for unlimited use so far
as the copyright notice above remains intact. */

/* Settings. Please read readme.html file for instructions*/
var ppcDF = "m/d/Y";
var ppcMN = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
var ppcWN = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
var ppcER = new Array(4);
ppcER[0] = "Required DHTML functions are not supported in this browser.";
ppcER[1] = "Target form field is not assigned or not accessible.";
ppcER[2] = "Sorry, the chosen date is not acceptable. Please read instructions on the page.";
ppcER[3] = "Unknown error occured while executing this script.";
var ppcUC = false;
 var ppcUX = 4;
 var ppcUY = 4;

/* Do not edit below this line unless you are sure what are you doing! */

var ppcIE=(navigator.appName == "Microsoft Internet Explorer");
var ppcNN=((navigator.appName == "Netscape")&&(document.layers));
var ppcTT="<table width=\"200\" cellspacing=\"1\" cellpadding=\"2\" border=\"1\" bordercolorlight=\"#000000\" bordercolordark=\"#000000\">\n";
var ppcCD=ppcTT;var ppcFT="<font face=\"MS Sans Serif, sans-serif\" size=\"1\" color=\"#000000\">";var ppcFC=true;
var ppcTI=false;var ppcSV=null;var ppcRL=null;var ppcXC=null;var ppcYC=null;
var ppcML=new Array(31,28,31,30,31,30,31,31,30,31,30,31);
var ppcWE=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
var ppcNow=new Date();var ppcPtr=new Date();
if (ppcNN) {
 window.captureEvents(Event.RESIZE);
 window.onresize = restoreLayers;
 document.captureEvents(Event.MOUSEDOWN|Event.MOUSEUP);
 document.onmousedown = recordXY;
 document.onmouseup = confirmXY;}
function restoreLayers(e) {
 if (ppcNN) {
  with (window.document) {
   open("text/html");
   write("<html><head><title>Restoring the layer structure...</title></head>");
   write("<body bgcolor=\"#FFFFFF\" onLoad=\"history.go(-1)\">");
   write("</body></html>");
   close();}}}
function recordXY(e) {
 if (ppcNN) {
  ppcXC = e.x;
  ppcYC = e.y;
  document.routeEvent(e);}}
function confirmXY(e) {
 if (ppcNN) {
  ppcXC = (ppcXC == e.x) ? e.x : null;
  ppcYC = (ppcYC == e.y) ? e.y : null;
  document.routeEvent(e);}}
function getCalendarFor(target,rules) {
 ppcSV = target;
 ppcRL = rules;
 if (ppcFC) {setCalendar();ppcFC = false;}
 if ((ppcSV != null)&&(ppcSV)) {
  if (ppcIE) {
   var obj = document.all['PopUpCalendar'];
   obj.style.left = document.body.scrollLeft+event.clientX;
   obj.style.top  = document.body.scrollTop+event.clientY;
   obj.style.visibility = "visible";}
  else if (ppcNN) {
   var obj = document.layers['PopUpCalendar'];
   obj.left = ppcXC
   obj.top  = ppcYC
   obj.visibility = "show";}
  else {showError(ppcER[0]);}}
 else {showError(ppcER[1]);}}
function switchMonth(param) {
 var tmp = param.split("|");
 setCalendar(tmp[0],tmp[1]);}
function moveMonth(dir) {
 var obj = null;
 var limit = false;
 var tmp,dptrYear,dptrMonth;
 if (ppcIE) {obj = document.ppcMonthList.sItem;}
 else if (ppcNN) {obj = document.layers['PopUpCalendar'].document.layers['monthSelector'].document.ppcMonthList.sItem;}
 else {showError(ppcER[0]);}
 if (obj != null) {
  if ((dir.toLowerCase() == "back")&&(obj.selectedIndex > 0)) {obj.selectedIndex--;}
  else if ((dir.toLowerCase() == "forward")&&(obj.selectedIndex < 12)) {obj.selectedIndex++;}
  else {limit = true;}}
 if (!limit) {
  tmp = obj.options[obj.selectedIndex].value.split("|");
  dptrYear  = tmp[0];
  dptrMonth = tmp[1];
  setCalendar(dptrYear,dptrMonth);}
 else {
  if (ppcIE) {
   obj.style.backgroundColor = "#FF0000";
   window.setTimeout("document.ppcMonthList.sItem.style.backgroundColor = '#FFFFFF'",50);}}}
function selectDate(param) {
 var arr   = param.split("|");
 var year  = arr[0];
 var month = arr[1];
 var date  = arr[2];
 var ptr = parseInt(date);
 ppcPtr.setDate(ptr);
 if ((ppcSV != null)&&(ppcSV)) {
  if (validDate(date)) {ppcSV.value = dateFormat(year,month,date);hideCalendar();}
  else {showError(ppcER[2]);if (ppcTI) {clearTimeout(ppcTI);ppcTI = false;}}}
 else {
  showError(ppcER[1]);
  hideCalendar();}}
function setCalendar(year,month) {
 if (year  == null) {year = getFullYear(ppcNow);}
 if (month == null) {month = ppcNow.getMonth();setSelectList(year,month);}
 if (month == 1) {ppcML[1]  = (isLeap(year)) ? 29 : 28;}
 ppcPtr.setYear(year);
 ppcPtr.setMonth(month);
 ppcPtr.setDate(1);
 updateContent();}
function updateContent() {
 generateContent();
 if (ppcIE) {document.all['monthDays'].innerHTML = ppcCD;}
 else if (ppcNN) {
  with (document.layers['PopUpCalendar'].document.layers['monthDays'].document) {
   open("text/html");
   write("<html>\n<head>\n<title>DynDoc</title>\n</head>\n<body bgcolor=\"#FFFFFF\">\n");
   write(ppcCD);
   write("</body>\n</html>");
   close();}}
 else {showError(ppcER[0]);}
 ppcCD = ppcTT;}
function generateContent() {
 var year  = getFullYear(ppcPtr);
 var month = ppcPtr.getMonth();
 var date  = 1;
 var day   = ppcPtr.getDay();
 var len   = ppcML[month];
 var bgr,cnt,tmp = "";
 var j,i = 0;
 for (j = 0; j < 7; ++j) {
  if (date > len) {break;}
  for (i = 0; i < 7; ++i) {
   bgr = ((i == 0)||(i == 6)) ? "#FFFFCC" : "#FFFFFF";
   if (((j == 0)&&(i < day))||(date > len)) {tmp  += makeCell(bgr,year,month,0);}
   else {tmp  += makeCell(bgr,year,month,date);++date;}}
  ppcCD += "<tr align=\"center\">\n" + tmp + "</tr>\n";tmp = "";}
 ppcCD += "</table>\n";}
function makeCell(bgr,year,month,date) {
 var param = "\'"+year+"|"+month+"|"+date+"\'";
 var td1 = "<td width=\"20\" bgcolor=\""+bgr+"\" ";
 var td2 = (ppcIE) ? "</font></span></td>\n" : "</font></a></td>\n";
 var evt = "onMouseOver=\"this.style.backgroundColor=\'#FF0000\'\" onMouseOut=\"this.style.backgroundColor=\'"+bgr+"\'\" onMouseUp=\"selectDate("+param+")\" ";
 var ext = "<span Style=\"cursor: hand\">";
 var lck = "<span Style=\"cursor: default\">";
 var lnk = "<a href=\"javascript:selectDate("+param+")\" onMouseOver=\"window.status=\' \';return true;\">";
 var cellValue = (date != 0) ? date+"" : "&nbsp;";
 if ((ppcNow.getDate() == date)&&(ppcNow.getMonth() == month)&&(getFullYear(ppcNow) == year)) {
  cellValue = "<b>"+cellValue+"</b>";}
 var cellCode = "";
 if (date == 0) {
  if (ppcIE) {cellCode = td1+"Style=\"cursor: default\">"+lck+ppcFT+cellValue+td2;}
  else {cellCode = td1+">"+ppcFT+cellValue+td2;}}
 else {
  if (ppcIE) {cellCode = td1+evt+"Style=\"cursor: hand\">"+ext+ppcFT+cellValue+td2;}
  else {
   if (date < 10) {cellValue = "&nbsp;" + cellValue + "&nbsp;";}
   cellCode = td1+">"+lnk+ppcFT+cellValue+td2;}}
 return cellCode;}
function setSelectList(year,month) {
 var i = 0;
 var obj = null;
 if (ppcIE) {obj = document.ppcMonthList.sItem;}
 else if (ppcNN) {obj = document.layers['PopUpCalendar'].document.layers['monthSelector'].document.ppcMonthList.sItem;}
 else {/* NOP */}
 while (i < 13) {
  obj.options[i].value = year + "|" + month;
  obj.options[i].text  = year + " • " + ppcMN[month];
  i++;
  month++;
  if (month == 12) {year++;month = 0;}}}
function hideCalendar() {
 if (ppcIE) {document.all['PopUpCalendar'].style.visibility = "hidden";}
 else if (ppcNN) {document.layers['PopUpCalendar'].visibility = "hide";window.status = " ";}
 else {/* NOP */}
 ppcTI = false;
 setCalendar();
 ppcSV = null;
 if (ppcIE) {var obj = document.ppcMonthList.sItem;}
 else if (ppcNN) {var obj = document.layers['PopUpCalendar'].document.layers['monthSelector'].document.ppcMonthList.sItem;}
 else {/* NOP */}
 obj.selectedIndex = 0;}
function showError(message) {
 window.alert("[ PopUp Calendar ]\n\n" + message);}
function isLeap(year) {
 if ((year%400==0)||((year%4==0)&&(year%100!=0))) {return true;}
 else {return false;}}
function getFullYear(obj) {
 if (ppcNN) {return obj.getYear() + 1900;}
 else {return obj.getYear();}}
function validDate(date) {
 var reply = true;
 if (ppcRL == null) {/* NOP */}
 else {
  var arr = ppcRL.split(":");
  var mode = arr[0];
  var arg  = arr[1];
  var key  = arr[2].charAt(0).toLowerCase();
  if (key != "d") {
   var day = ppcPtr.getDay();
   var orn = isEvenOrOdd(date);
   reply = (mode == "[^]") ? !((day == arg)&&((orn == key)||(key == "a"))) : ((day == arg)&&((orn == key)||(key == "a")));}
  else {reply = (mode == "[^]") ? (date != arg) : (date == arg);}}
 return reply;}
function isEvenOrOdd(date) {
 if (date - 21 > 0) {return "e";}
 else if (date - 14 > 0) {return "o";}
 else if (date - 7 > 0) {return "e";}
 else {return "o";}}
function dateFormat(year,month,date) {
 if (ppcDF == null) {ppcDF = "m/d/Y";}
 var day = ppcPtr.getDay();
 var crt = "";
 var str = "";
 var chars = ppcDF.length;
 for (var i = 0; i < chars; ++i) {
  crt = ppcDF.charAt(i);
  switch (crt) {
   case "M": str += ppcMN[month]; break;
   case "m": str += (month<9) ? ("0"+(++month)) : ++month; break;
   case "Y": str += year; break;
   case "y": str += year.substring(2); break;
   case "d": str += ((ppcDF.indexOf("m")!=-1)&&(date<10)) ? ("0"+date) : date; break;
   case "W": str += ppcWN[day]; break;
    default: str += crt;}}
 return unescape(str);}
 
 </script>
  <script type="text/javascript">
 function formshowhide(status, val)
  {
  alert('YES');
  if(status == 'Yes' || status === true){
  document.getElementById(val).scheddate.style.display='inline';
	document.getElementById(val).sleeplabwheresched.style.display='inline';
	document.getElementById(val).completed.style.display='inline';
	document.getElementById(val).interpolation.style.display='inline';
	document.getElementById(val).labtype.style.display='inline';
	document.getElementById(val).copyreqdate.style.display='inline';
  }else if(status == 'No' || status === false){
  alert('YES');
  document.getElementById(val).scheddate.style.display='none';
	document.getElementById(val).sleeplabwheresched.style.display='none';
	document.getElementById(val).completed.style.display='none';
	document.getElementById(val).interpolation.style.display='none';
	document.getElementById(val).labtype.style.display='none';
	document.getElementById(val).copyreqdate.style.display='none';
  }
 </script>

<script type="text javascript">
function popitup(url) {
	newwindow=parent.window.open(url,'name','height=400,width=400');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
<script language="javascript" type="text/javascript">
function autoselect(selectedOption, updateCompleted)
{
if(selectedOption.value=="No")
//updateCompleted[0].checked=true;
else
//updateCompleted[1].checked=true;
}
</script>

<script type="text/javascript">
 function otherSelect(number) {
            var list = document.sleepstudyadd.labtype;
            var chosenItemText = list.value;
            if (chosenItemText == "PSG") {
                document.getElementById('interpretation'+number+'1').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'2').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'3').style.visibility = 'hidden';
                document.getElementById('interpretation'+number+'4').style.visibility = 'hidden';
            }
            else {
                document.getElementById('interpretation'+number+'1').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'2').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'3').style.visibility = 'visible';
                document.getElementById('interpretation'+number+'4').style.visibility = 'visible';
            }
        }

</script>

   
</head>

<body style="background:none;"> 
<?php
if($_SESSION['userid'] == '')
{
	?>
	<script type="text/javascript">
		alert("Members Area, Please Login");
		window.location = "login.php";
	</script>
	<?
	die();
}

if(isset($_POST['updatestudy']) && isset($_POST['sleepstudyid'])){
$docid = $_SESSION['docid'];
$patientid = $_POST['patientid'];
$needed = $_POST['needed'];
$scheddate = $_POST['scheddate'];
$sleeplabwheresched = $_POST['sleeplabwheresched'];
$completed = $_POST['completed'];
$interpolation = $_POST['interpolation'];
$labtype = $_POST['labtype'];
$copyreqdate = $_POST['copyreqdate'];
$sleeplab = $_POST['sleeplab'];
$date = date("Ymd");
$insslquery = "UPDATE `dental_sleepstudy` SET `docid` = '".$docid."', `patientid` = '".$_POST['patientid']."', `needed` = '".$needed."',`scheddate` = '".$scheddate."',`sleeplabwheresched` = '".$sleeplabwheresched."',`completed` = '".$completed."',`interpolation` = '".$interpolation."',`labtype` = '".$labtype."',`copyreqdate` = '".$copyreqdate."',`sleeplab` = '".$sleeplab."',`date` = '".$date."' WHERE `id` = '".$_POST['sleepstudyid']."' and `patientid` = '".$patientid."';";
    if(!mysql_query($insslquery)){
      echo "Could not update sleep study, please try again!";
    }  
}


if(isset($_POST['submitnewstudy'])){
$docid = $_SESSION['docid'];
$patientid = $_POST['patientid'];
$needed = $_POST['needed'];
$scheddate = $_POST['scheddate'];
$sleeplabwheresched = $_POST['sleeplabwheresched'];
$completed = $_POST['completed'];
$interpolation = $_POST['interpolation'];
$labtype = $_POST['labtype'];
$copyreqdate = $_POST['copyreqdate'];
$sleeplab = $_POST['sleeplab'];
$date = date("Ymd");
$filename = $_FILES["file"]["name"];
$random = rand(111111111,999999999);
$scanext = end(explode('.', $filename));
$insslquery = "INSERT INTO `dental_sleepstudy` (`id`,`testnumber`,`docid`,`patientid`,`needed`,`scheddate`,`sleeplabwheresched`,`completed`,`interpolation`,`labtype`,`copyreqdate`,`sleeplab`,`scanext`,`date`) VALUES (NULL,'".$random."','".$docid."','".$_POST['patientid']."','".$needed."','".$scheddate."','".$sleeplabwheresched."','".$completed."','".$interpolation."','".$labtype."','".$copyreqdate."','".$sleeplab."','".$scanext."','".$date."');";
echo $insslquery;

if(!mysql_query($insslquery)){
echo "Could not add sleep lab, please try again!";
}else{
?>
<script type="text/javascript">
window.location.href='manage_sleep_studies.php?pid=<?php echo($_POST["patientid"]); ?>';
</script>
<?php
}


if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "application/pdf"))
&& ($_FILES["file"]["size"] < 200000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
     ?>
           <script type="text/javascript">
           alert("<?php echo($_FILES['file']['error']); ?>");
           </script>
     <?php
    }
  else
    {
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      ?>
           <script type="text/javascript">
           alert("File Already Exists");
            </script>           
           <?php
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],"sleepstudies/".$patientid.'-'.$random.".".$scanext);
       ?>
           <script type="text/javascript">
           alert("It's done! The file has been saved as: "+<?php echo($newname); ?>);
            </script>           
           <?php
      }
    }
  }
else
  {
 ?>
           <script type="text/javascript">
           alert("Invalid File Type");
            </script>           
           <?php
  }


 
}

?>


  <?php $i = 9999; ?>
  <form name="sleepstudyadd" id="sleepstudyadd" style="float:left;" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<table id="sleepstudyscrolltable">

						<tr style="height:25px;">

						<td>


						</td>

						</tr>

						<tr style="height:30px;">

						<td>
            

						<input type="radio" name="needed" id="needed1" value="Yes" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='visible';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='visible';">Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
						<input type="radio" name="needed" id="needed2" value="No" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';autoselect(this,document.sleepstudyadd.completed);document.getElementById('interpretation<?php echo $i; ?>1').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>2').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>3').style.visibility='hidden';document.getElementById('interpretation<?php echo $i; ?>4').style.visibility='hidden';">No

						</td>

						</tr>

						<tr style="height:43px;">

						<td>

						<input id="sleepsched<?php echo $i; ?>" name="scheddate" type="text" class="field text addr tbox" value="<?php echo $scheddate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('scheddate');" onclick="cal_sleepsched<?=$i?>.popup();" value="example 11/11/1234" />
						
						</td>
						
						</tr>
						
						<tr style="height:30px;">
						
						<td>
						
						<select name="sleeplabwheresched" id="sleeplabwheresched<?php echo $i; ?>" onclick="Javascript: scroll(0,0);loadPopup('add_patient_to.php?ed=51');">
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
            ?>
						
						<option value="<?php echo $sleeplab['sleeplabid']; ?>"><?php echo $sleeplab['company']; ?></option>
						<?php } ?>
						<option value="add new sleeplab">Add new sleeplab</option>
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:30px;">
						
						<td>
						
						<input type="radio" id="completed<?php echo $i; ?>1" name="completed" value="Yes" style="float:left;"><div id="completed<?php echo $i; ?>3" style="float:left;">Yes</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="completed<?php echo $i; ?>2" name="completed" value="No" style="float:left;"><div id="completed<?php echo $i; ?>4" style="float:left;">No</div>
						
						</td>
						
						</tr>
						
						<tr style="height:30px;">
						
						<td>
						
						<select name="labtype" onChange="otherSelect(<?php echo $i; ?>);">
						
						<option value="HST">HST</option>
            
            <option value="PSG">PSG</option>
						
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:44px;">
						
						<td>
						
						<input type="radio" id="interpretation<?php echo $i; ?>1" name="interpolation" value="Yes" style="float:left;"><div id="interpretation<?php echo $i; ?>3" style="float:left;">Yes</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="interpretation<?php echo $i; ?>2" name="interpolation" value="No" style="float:left;"><div id="interpretation<?php echo $i; ?>4" style="float:left;">No</div>
						
						</td>
						
						</tr>
						
						
						
						<tr style="height:40px;">
						
						<td>
						
						<input id="copyreqdate<?php echo $i; ?>" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $copyreqdate; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onclick="cal_copyreqdate<?=$i?>.popup();"  value="example 11/11/1234" /><span id="req_0" class="req">*</span>
						
						</td>
						
						</tr>
						
						<tr style="height:29px;">
						
						<td>
						
						<select id="sleeplab" name="sleeplab">
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
            ?>
						
						<option value="<?php echo $sleeplab['sleeplabid']; ?>"><?php echo $sleeplab['company']; ?></option>
						<?php } ?>
						<option value="add new sleeplab">Add new sleeplab</option>
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:39px;">
						
						<td>
            <input type="hidden" value="<?php echo $_GET['pid'] ?>" name="patientid" />
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
            <input name="file" type="file" />
					
						</td>
					
						</tr>
					
						<tr style="height:30px;">
					
						<td>
					
						<input type="submit" name="submitnewstudy" value="Add Study" />
					
						</td>
					
						</tr>
					
				</table>
				
				</form>



<?php
$calendar_vars = array();
$sleepstudyquery = "SELECT * FROM dental_sleepstudy WHERE docid=".$_SESSION['docid']." AND patientid='".$_GET['pid']."' ORDER BY id DESC;";
$sleepstudyres = mysql_query($sleepstudyquery);
if($sleepstudyres){
$numrows = mysql_num_rows($sleepstudyres);
}
if($numrows){
 $i = $numrows;
 $di = 0; 
 while($sleepstudy = mysql_fetch_array($sleepstudyres)){
  $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
 $sleeplabres = mysql_query($sleeplabquery);
 $calendar_vars[$i]['scheddate_id'] = "scheddate$i";
 $calendar_vars[$i]['copyreqdate_id'] = "copyreqdate$i"
 ?>
 <form id="sleepstudy<?php echo $i; ?>" name="sleepstudy<?php echo $i; ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>?pid=<?php echo $_GET['pid']; ?>" method="POST" style="height:400px;width:150px;float:left;">
 <div id="sleepstudyscrolltable<?php echo $i; ?>">
 <table id="sleepstudyscrolltable" style="border-right: 1px solid #000000;float: left;margin-right: 27px;width: 150px;">

						<tr style="height:25px;">

						<td style="text-align:center;">

             <?php echo $i; ?>
						</td>

						</tr>

						<tr style="height:30px;">

						<td>
            <?php if($sleepstudy['needed'] == "Yes"){
             ?>
             <script type="text/javascript">
             document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);
             </script>
             <?php
            }else{
            ?>
             <script type="text/javascript">
             document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);
             </script>
             <?php            
            } ?>
						<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);" name="needed" value="Yes"<?php if($sleepstudy['needed'] == "Yes"){ echo " checked='checked'";} ?>>Yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						<input type="radio" onclick="document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);" name="needed" value="No"<?php if($sleepstudy['needed'] == "No"){ echo " checked='checked'";} ?>>No

						</td>

						</tr>

						<tr style="height:43px;">
            <div id="hideifno<?php echo $i; ?>">
						<td>
            
            
						<input id="scheddate<?php echo $i; ?>" name="scheddate" type="text" class="field text addr tbox" value="<?php echo $sleepstudy['scheddate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onClick="cal_scheddate<?=$i?>.popup();" onChange="validateDate('scheddate');"  value="example 11/11/1234" />
						
						<script id="js<?php echo $i; ?>" type="text/javascript">
                var cal<?php echo $i; ?> = new CalendarPopup();
            </script>
						
						</td>
						
						</tr>
						
						<tr style="height:30px;">
						
						<td name="sleeplabwheresched">
						
						<select id="sleeplabwheresched<?php echo $i; ?>" name="sleeplabwheresched">
						<option value="add new sleeplab">Add new sleeplab</option>
						<?php
            while($sleeplab = mysql_fetch_array($sleeplabres)){
            ?>
						
						<option value="<?php echo $sleeplab['sleeplabid']; ?>" <?php if($sleepstudy['sleeplabwheresched'] == $sleeplab['sleeplabid']){echo " selected='selected'";} ?>><?php echo $sleeplab['company']; ?></option>
						<?php } ?>
						<option value="add new sleeplab">Add new sleeplab</option>
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:30px;">
						
						<td>
						<div id="completed">
						
						<input type="radio" id="completed<?php echo $i."1"; ?>" name="completed" value="Yes" <?php if($sleepstudy['completed'] == "Yes"){echo " checked='checked'";} ?> style="float:left;"><div id="completed<?php echo $i."3"; ?>" style="float:left;">Yes</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="completed<?php echo $i."2"; ?>" name="completed" value="No" <?php if($sleepstudy['completed'] == "No"){echo " checked='checked'";} ?> style="float:left;"><div id="completed<?php echo $i."4"; ?>" style="float:left;">No</div>
            </div>						
						</td>
						
						</tr>
						<?php if($sleepstudy['needed'] == "Yes"){
             ?>
             <script type="text/javascript">
             document.getElementById('scheddate<?php echo $i; ?>').style.visibility='visible';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='visible';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);
             </script>
             <?php
            }else{
            ?>
             <script type="text/javascript">
             document.getElementById('scheddate<?php echo $i; ?>').style.visibility='hidden';document.getElementById('sleeplabwheresched<?php echo $i; ?>').style.visibility='hidden';autoselect(this,document.sleepstudy<?php echo $i; ?>.completed);
             </script>
             <?php            
             }?>
						<tr style="height:30px;">
						
						<td name="labtype">
						
						<select name="labtype" id="labtype<?php echo $i; ?>" onChange="otherSelect2(sleepstudy<?php echo $i; ?>,<?php echo $i; ?>);">
						
						<option value="PSG" <?php if($sleepstudy['labtype'] == "PSG"){echo " selected='selected'";} ?>>PSG</option>
						
						<option value="HST" <?php if($sleepstudy['labtype'] == "HST"){echo " selected='selected'";} ?>>HST</option>
						
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:44px;">
						
						<td name="interpolation">
						
						<input type="radio" id="interpretation<?php echo $i; ?>1" name="interpolation" value="Yes" <?php if($sleepstudy['interpolation'] == "Yes"){echo " checked='checked'";} ?> style="float:left;"><div id="interpretation<?php echo $i; ?>3" style="float:left;">Yes</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<input type="radio" id="interpretation<?php echo $i; ?>2" name="interpolation" value="No"<?php if($sleepstudy['interpolation'] == "No"){echo " checked='checked'";} ?> style="float:left;"><div id="interpretation<?php echo $i; ?>4" style="float:left;">No</div>
						
						</td>
						
						</tr>
						
						<script type="text/javascript">
            <?php if($sleepstudy['labtype'] == "PSG"){ ?>
						    document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'hidden';
                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'hidden';
            <?php
            }else{
            ?>
                document.getElementById('interpretation<?php echo $i; ?>1').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>2').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>3').style.visibility = 'visible';
                document.getElementById('interpretation<?php echo $i; ?>4').style.visibility = 'visible';
            <?php } ?>
            </script> 
						
						<tr style="height:40px;">
						
						<td name="copyreqdate">
						
						<input id="copyreqdate<?=$i?>" name="copyreqdate" type="text" class="field text addr tbox" value="<?php echo $sleepstudy['copyreqdate']; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('copyreqdate');" onclick="cal_copyreqdate<?=$i?>.popup();" value="example 11/11/1234" /><span id="req_0" class="req">*</span>
						
						</td>
						
						</tr>
						
						<tr style="height:25px;">
						
						<td name="sleeplab">
						
						<select id="sleeplab" name="sleeplab">
						<?php
            $sleeplabquery = "SELECT * FROM dental_sleeplab WHERE docid=".$_SESSION['docid'];
            $sleeplabres = mysql_query($sleeplabquery);
            while($sleeplab = mysql_fetch_array($sleeplabres)){
            ?>
						
						<option value="<?php echo $sleeplab['sleeplabid']; ?>" <?php if($sleeplab['sleeplabid'] == $sleepstudy['sleeplab']){ echo " selected='selected'";}?>><?php echo $sleeplab['company']; ?></option>
						<?php } ?>
						<option value="add new sleeplab">Add new sleeplab</option>
						</select>
						
						</td>
						
						</tr>
						
						<tr style="height:39px;">
						
						<td>
						

						&nbsp;&nbsp;&nbsp;<a style="font-weight:bold; font-size:15px;" href="javascript: void(0)" onClick="window.open('sleepstudies/<?php echo($_GET['pid']); ?>-<?php echo $sleepstudy['testnumber']; ?>.<?php echo $sleepstudy['scanext']; ?>','windowname1','width=400, height=400');return false;">View Scan</a>
						
						</td>
						</div>
						</tr>
						<tr style="height:30px;">
						
						<td>
						<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
						<input type="hidden" name="sleepstudyid" value="<?php echo $sleepstudy['id']; ?>">
            <input type="submit" name="updatestudy" value="Update Study" />
						
						
						</td>
						
						</tr>
					
				</table>
				</div>
</form>				
 <?php
 $di++;
 ?>
 <script type="text/javascript">
 <!--var cal<?php echo($i); ?> = new calendar2(document.forms['sleepstudy<?php echo($i); ?>'].elements['scheddate']);-->
 </script>
 <?php
 
 
 $i--;
 }
 }
 ?>

<script type="text/javascript">
	var cal_sleepsched9999 = new calendar2(document.getElementById('sleepsched9999'));
	var cal_copyreqdate9999 = new calendar2(document.getElementById('copyreqdate9999'));
	<?php
	foreach ($calendar_vars as $key => $calid) {
		print "var cal_" . $calid['scheddate_id'] . " = new calendar2(document.getElementById('" . $calid['scheddate_id'] . "'));";
		print "var cal_" . $calid['copyreqdate_id'] . " = new calendar2(document.getElementById('" . $calid['copyreqdate_id'] . "'));";
	}
	?>
</script> 

				
				</body>
				</html>
