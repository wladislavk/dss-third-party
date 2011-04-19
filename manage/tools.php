<?php include 'includes/top.htm';?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup2.js" type="text/javascript"></script>

<br />


<div>
 <table>
 <tr>
 <td valign="top" style="border-right:1px solid #00457c;width:290px;" id="formLeftC">

<div style="padding-left:10px; padding-right:10px; margin-right:5px;"> 
                




<?php

$adminmemo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
$adminmemo_check_qry = mysql_query($adminmemo_check_sql);
while($adminmemo_array = mysql_fetch_array($adminmemo_check_qry)){
if($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != ''){
	?>
	  
    <div style="color:#ff0000; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;"><span class="admin_head" style="color:#ff0000;"><em> Global Memo: </em></span></div>
	<br />
	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 
echo "". $adminmemo_array['memo'] . "<br />";
?>

    </td>
    
  </tr>
  </table>
  <br />
 <?php 
 }
 } ?>

  <div style="color:#00457c; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;"><span class="admin_head" style="color:#00457c;"><em> Todays Memo: </em></span></div>
	<br />
	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
  <tr>
    <td valign="top">
    
<?php 

$memouserid = $_SESSION['userid'];
$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
$memo_check_qry = mysql_query($memo_check_sql);
while($memo_array = mysql_fetch_array($memo_check_qry)){
if($memo_array != NULL || $memo_array != ''){
echo $memo_array['memo'] . "<br /><hr />";
}
}
?>

<a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('memo.php'); getElementById('popupMemo').style.top = '200px'; return false;">Edit Memo</a>
    </td>
    
  </tr>
  </table>
  <br /> <br /><br />

 <?

$sqlddlist = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist .= " and status = 1";
}
$sqlddlist .= " order by lastname, firstname";
$myddlist = mysql_query($sqlddlist);

?>
<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Elements:</font><br />
<FORM NAME="DropDown" ACTION="http://www.cgiforme.com/jumporama/cgi/jumporama.cgi" METHOD="post" >
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php
$sqlddlist2 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist2 .= " and status = 1";
}
$sqlddlist2 .= " order by lastname, firstname";
$myddlist2 = mysql_query($sqlddlist2);
while($ddlistpname2 = (mysql_fetch_array($myddlist2))){
?>
<option value="manage_patient.php?pid=<?php echo $ddlistpname2['patientid']; ?>">
<?php echo $ddlistpname2['lastname'].", ".$ddlistpname2['firstname']." ".$ddlistpname2['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>






<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div> 




<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Flowsheet:</font><br />
<FORM NAME="DropDown">
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php

$sqlddlist3 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist3 .= " and status = 1";
}
$sqlddlist3 .= " order by lastname, firstname";
$myddlist3 = mysql_query($sqlddlist3);
while($ddlistpname3 = (mysql_fetch_array($myddlist3))){
?>
<option value="manage_flowsheet.php?pid=<?php echo $ddlistpname3['patientid']; ?>">
<?php echo $ddlistpname3['lastname'].", ".$ddlistpname3['firstname']." ".$ddlistpname3['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>  
  




<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div>  



<SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
<font style="font-size:16px; font-weight:bold;">View Patient Summary Sheet:</font><br />
<FORM NAME="DropDown">
<SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">

<?php
$sqlddlist4 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
if($_GET['sh'] != 2)
{
	$sqlddlist4 .= " and status = 1";
}
$sqlddlist4 .= " order by lastname, firstname";
$myddlist4 = mysql_query($sqlddlist4);
while($ddlistpname4 = (mysql_fetch_array($myddlist4))){
?>
<option value="dss_summ.php?pid=<?php echo $ddlistpname4['patientid']; ?>">
<?php echo $ddlistpname4['lastname'].", ".$ddlistpname4['firstname']." ".$ddlistpname4['middlename']; ?>
</option>
<?php  
}

?>                
</SELECT>
<br />

</FORM>  
  




<div style="margin-top:25px;  width:100%;">&nbsp;</div> 
<hr />
<div style="margin-top:0px; width:100%;">&nbsp;</div>  






  
  
  
              
</div>
</td>

<td valign="top">
<div style="width:660px; float:right; margin-left:5px;">

  <ul style="list-style-type:none;">
    <li>
       <a style="font-size:16px; font-weight:bold;" href="manage_files.php" class="subfoldericon">Files</a>
       
    </li>
    
    </ul>
       <ul style="padding-left: 100px;">
            <li><a href="manage_files.php" target="_self">General Files</a></li>
            <li><a href="manage_marketfiles.php" target="_self">Marketing Files</a> </li>
            <li><a href="manage_dvdfiles.php" target="_self">DVD Files</a></li>
            <li><a href="manage_applabfiles.php" target="_self">Dental App Lab Files</a></li>
            <li><a href="manage_sleeplabfiles.php" target="_self">Sleep Lab Files</a></li>
       </ul>
    <ul style="list-style-type:none;">
    <li>
       <a style="font-size:16px; font-weight:bold;" href="manage_custom.php" target="_self">Canned Text</a>
    </li>
    </ul>
    <ul style="list-style-type:none;">
    <li>
       <a style="font-size:16px; font-weight:bold;" href="manage_sleeplab.php" target="_self">Sleep Labs</a>
    </li>
  </ul>

</div>
</div>
</td></tr>
</table>



















<div id="popupMemo" style="width:750px; z-index:9999; display:none; height:400px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="popupContact" style="width:750px; display:none; height:400px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div> 

<div id="backgroundPopup"></div>

<br /><br />
<? include 'includes/bottom.htm';?> 