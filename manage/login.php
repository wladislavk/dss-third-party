<?
session_start();
require_once('admin/includes/config.php');
include_once('admin/includes/password.php');
$page_sql = "select * from dental_pages where status=1 and  pageid='".s_for($_GET['pid'])."'";
$page_my = mysql_query($page_sql);
$page_myarray = mysql_fetch_array($page_my);

if($_SESSION['loginid'] <> '')
{
$cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
$cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
mysql_query($cur_ins_sql);
}

if($_GET['pid'] <> '' && $_GET['fid'] == '')
{
	$p_form_sql = "select * from dental_forms where patientid='".s_for($_GET['pid'])."'";
	$p_form_my = mysql_query($p_form_sql);
	$p_form_myarray = mysql_fetch_array($p_form_my);
	
	$_GET['fid'] = $p_form_myarray['formid'];
}

if(strpos($_SERVER['PHP_SELF'],'q_page') === false && strpos($_SERVER['PHP_SELF'],'ex_page') === false && strpos($_SERVER['PHP_SELF'],'q_sleep') === false && strpos($_SERVER['PHP_SELF'],'q_image') === false)
{
	$unload = 0 ;
}
else
{
	$unload = 1 ;
}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/p7tbmenu.js"></script>
<script type="text/javascript" src="js/ddlevelsmenu.js">

/***********************************************
* All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<script language="javascript" type="text/javascript">
function display(){
    document.getElementById("future_dental_det").style.display = "block"; 
}
function hide(id){
    document.getElementById("future_dental_det").style.display = "none";
}
function displaysmoke(){
    document.getElementById("smoke").style.display = "block"; 
}
function hidesmoke(id){
    document.getElementById("smoke").style.display = "none";
}
</script>
<script language="javascript" type="text/javascript" src="script/hideshow.js"></script>

<script type="text/javascript">

//SuckerTree Horizontal Menu (Sept 14th, 06)
//By Dynamic Drive: http://www.dynamicdrive.com/style/

var menuids=["treemenu1"] //Enter id(s) of SuckerTree UL menus, separated by commas

function buildsubmenus_horizontal(){
for (var i=0; i<menuids.length; i++){
  var ultags=document.getElementById(menuids[i]).getElementsByTagName("ul")
    for (var t=0; t<ultags.length; t++){
		if (ultags[t].parentNode.parentNode.id==menuids[i]){ //if this is a first level submenu
			ultags[t].style.top=ultags[t].parentNode.offsetHeight+"px" //dynamically position first level submenus to be height of main menu item
			ultags[t].parentNode.getElementsByTagName("a")[0].className="mainfoldericon"
		}
		else{ //else if this is a sub level menu (ul)
		  ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
    	ultags[t].parentNode.getElementsByTagName("a")[0].className="subfoldericon"
		}
    ultags[t].parentNode.onmouseover=function(){
    this.getElementsByTagName("ul")[0].style.visibility="visible"
    }
    ultags[t].parentNode.onmouseout=function(){
    this.getElementsByTagName("ul")[0].style.visibility="hidden"
    }
    }
  }
}

if (window.addEventListener)
window.addEventListener("load", buildsubmenus_horizontal, false)
else if (window.attachEvent)
window.attachEvent("onload", buildsubmenus_horizontal)

</script>
  <SCRIPT LANGUAGE="javascript">

function LinkUp() 
{
var number = document.DropDown.DDlinks.selectedIndex;
window.location.href = document.DropDown.DDlinks.options[number].value;
}
</SCRIPT>
</head>
<body onload="document.getElementById('future_dental_det').style.display = 'none';parent.frames[0].document.getElementById('hideshow1').style.display='block';parent.frames[0].document.getElementById('hideshow2').style.display='none';parent.frames[0].document.getElementById('hideshow3').style.display='none';parent.frames[0].document.getElementById('hideshow4').style.display='none';parent.frames[0].document.getElementById('hideshow5').style.display='none';">
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />

<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>  
<table width="980" border="0" cellpadding="1" cellspacing="1" align="center">
<!-- Header and nav goes here -->
  <tr>
    <td colspan="2" align="right" > 
	
	</td>
  </tr>
  <tr>
	<td valign='top' height="400">
	<div style="float:right;margin-right:20px;margin-top:8px;">
  
  <div style="text-align:center; float:left;width:50px; color:#00457c; padding-right:20px;"><a style="color:#00457c;text-decoration:none;" href="index.php" target="_self"><img border="0" src="images/homeIcon.png"><br />Home</a></div>

  <div style="text-align:center;float:right;width:50px;margin-top:7px;"><div><a style="color:#00457c;text-decoration:none;" href="#" target="_self">Login Below</div>

  </div>

  
  
  </div>

  
  
  
  <div style="height:116px; width:980px; background:url(images/dss_01.png) #0b5c82 no-repeat top left;"><div style="font-size:24px; font-weight:bold; font-family:arial; color:#FFFFFF; padding-top:20px; margin-left:20px;">Dental Sleep Solutions &reg;<font style="color:#000; font-size:14px; font-weight:bolder;padding-left:110px;font-style:italic;">Practice Management</font></div>
     
    <div style="margin-top:30px; margin-left:20px; float:left;">
    <form name="form" action="search.php" method="get">
  <input type="text" name="q" />
  <input type="submit" name="Submit" value="Patient Search By Last Name" />
</form>
    </div>
    
     <div style="clear:both;"></div>
  </div>
  <div style="height:40px; background:url(images/dss_03.jpg) #0b5c82 repeat-y top left;width:100%;"><div style="width:98.6%; background:#00457c;margin:0 auto;"><div class="suckertreemenu">
<ul id="treemenu1" style="padding-top:3px;">
<li><a href="manage_patient.php">PATIENT</a>
<?php if($_SERVER["SCRIPT_NAME"] == "/manage/manage_patient.php"){ ?>
  <ul>
  
              <li><a href="#" onclick="Javascript: loadPopup('add_patient.php?ed=<? echo $_GET["pid"];?>&preview=1');">Patient Info</a></li>
              <li><a href="q_page1.php?pid=<?=$_GET["pid"];?>">Questionnaire</a></li>
							<li><a href="ex_page4.php?pid=<?=$_GET["pid"];?>">Clinical Exam</a> </li>
							<li><a href="dss_summ.php?pid=<?=$_GET['pid'];?>">Summary Sheet</a> </li>
							<li><a href="manage_ledger.php?pid=<?=$_GET["pid"];?>">Ledger</a> </li>
							<li><a href="manage_progress_notes.php?pid=<?=$_GET["pid"];?>">Progress Notes</a></li>
							<li><a href="manage_insurance.php?pid=<?=$_GET["pid"];?>">Insurance</a></li>
							<? //if(st($_SESSION['adminuserid'] <> '')) {?>
								<li><a href="dss_letters.php?fid=<?=$_GET["fid"];?>&pid=<?=$_GET['pid'];?>">Letters</a></li>
							<? //}?>
							<li><a href="manage_flowsheet.php?pid=<?=$_GET["pid"];?>">Flow Sheet</a></li>
  </ul>
  <?php } ?>
</li>
<li><a href="ledger.php">REPORTS</a></li>
<li><a href="directory.php">DIRECTORY</a>
  <ul>
      <li><a href="manage_contact.php">Contacts</a></li>
      <li><a href="manage_staff.php">Staff</a></li>
      <li><a href="manage_referredby.php">Referrers</a></li>
      <li><a href="manage_fcontact.php">Corporate Contacts</a></li>
  </ul>

<li><a href="tools.php">TOOLS</a>
  <ul>
    <li>
       <a href="manage_files.php">Files</a>
       <ul style="border-top:1px solid #095d81;">
            <li><a target="_self" href="manage_files.php">General Files</a></li>
            <li><a target="_self" href="manage_marketfiles.php">Marketing Files</a> </li>
            <li><a target="_self" href="manage_dvdfiles.php">DVD Files</a></li>
            <li><a target="_self" href="manage_applabfiles.php">Dental App Lab Files</a></li>
            <li><a target="_self" href="manage_sleeplabfiles.php">Sleep Lab Files</a></li>
       </ul>
    </li>
    <li>
       <a href="manage_custom.php">Canned Text</a>
    </li>
    <li>
       <a href="manage_sleeplabs.php">Sleep Labs</a>
    </li>
  </ul>
</li>
</ul>
<br style="clear: left;" />
</div>
</div>
<div style="clear:both;"></div>
</div>


<div style="background:url(images/dss_03.jpg) repeat-y top left #FFFFFF;" id="contentMain">
<div style="clear:both;"></div>

 
 

<?php

if($_POST["loginsub"] == 1)
{
	$salt_sql = "SELECT salt FROM dental_users WHERE username='".mysql_real_escape_string($_POST['username'])."'";
	$salt_q = mysql_query($salt_sql);
	$salt_row = mysql_fetch_assoc($salt_q);

	$pass = gen_password($_POST['password'], $salt_row['salt']);
	
	$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysql_real_escape_string($_POST['username'])."' and password='".$pass."' and status=1";
	$check_my = mysql_query($check_sql);
	
	if(mysql_num_rows($check_my) == 1) 
	{
		$check_myarray = mysql_fetch_array($check_my);
		
		/*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);*/
		
		session_register("userid");
		session_register("username");
		session_register("name");
		session_register("user_access");
		session_register("docid");
		
		$_SESSION['userid']=$check_myarray['userid'];
		$_SESSION['username']=$check_myarray['username'];
		$_SESSION['name']=$check_myarray['name'];
		$_SESSION['user_access']=$check_myarray['user_access'];
		if($check_myarray['docid'] != 0)
		{
			$_SESSION['docid']=$check_myarray['docid'];
		}
		else
		{
			$_SESSION['docid']=$check_myarray['userid'];
		}
		$_SERVER['QUERY_STRING'];
		$ins_sql = "insert into dental_login (docid,userid,login_date,ip_address) values('".$_SESSION['docid']."','".$_SESSION['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
		mysql_query($ins_sql);
		
		$ins_id = mysql_insert_id();
		
		$_SESSION['loginid']=$ins_id;
		
		?>
		<script type="text/javascript">
			window.location.replace('index.php');
		</script>
		<?
		die();
	}
	else
	{
		$msg='Wrong username or password';
		?>
		<script type="text/javascript">
			window.location.replace('login.php?msg=<?=$msg;?>');
		</script>
		<?
		die();
	}
}
?>
<br />
<span class="admin_head">
	Login
</span>
<br />
<br />

<br /><br /><br /><br /><br /><br />
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
<table border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
    <tr bgcolor="#FFFFFF">
        <td colspan="2" class="t_head">
	        <B>Login</B>
        </td>
    </tr>
	<? if($_GET['msg']!="")
    {
    ?> 
        <tr bgcolor="#FFFFFF">
            <td colspan="2" >
                <span class="red">
					<?=$_GET['msg'];?>
                </span>
            </td>
        </tr>
    <? }?>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
        	User name
        </td>
        <td class="t_data">
        	<input type="text" name="username">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
        	Password
        </td>
        <td class="t_data">
        	<input type="password" name="password">
        </td>
	</tr>
    <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center">
            <input type="hidden" name="loginsub" value="1">
            <input type="submit" name="btnsubmit" value=" Login " class="addButton">
        </td>
    </tr>
</table>
</FORM>
<a href="forgot_password.php">Forgot Password</a>


<? include 'includes/bottom.htm';?>
