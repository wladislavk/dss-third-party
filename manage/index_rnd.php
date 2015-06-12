<?php namespace Ds3\Libraries\Legacy; ?><? 
session_start();
require_once('admin/includes/main_include.php');

$page_sql = "select * from dental_pages where status=1 and  pageid='".s_for($_GET['pid'])."'";
$page_my = mysqli_query($con, $page_sql);
$page_myarray = mysqli_fetch_array($page_my);

if($_SESSION['loginid'] <> '')
{
$cur_page_full =  $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
$cur_ins_sql = "insert into dental_login_detail (loginid,userid,cur_page,adddate,ip_address) values('".$_SESSION['loginid']."','".$_SESSION['userid']."','".$cur_page_full."',now(),'".$_SERVER['REMOTE_ADDR']."')";
mysqli_query($con, $cur_ins_sql);
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

<script type="text/javascript" src="js/dropdowntabs.js">

/***********************************************
* Drop Down Tabs Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script type="text/javascript" src="js/ddlevelsmenu.js">

/***********************************************
* All Levels Navigational Menu- (c) Dynamic Drive DHTML code library (http://www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>

<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>
<table width="980" border="1" bgcolor="#FFFFFF" cellpadding="1" cellspacing="1" align="center">

	
  <tr>
    <td colspan="2" align="right" ><table width="980" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" valign="top" class="bg_line"><img src="images/blank.gif" width="1" height="6"></td>
      </tr>
      <tr>
        <td height="3" valign="top"></td>
      </tr>
      <tr>
        <td valign="top" class="bg_box1"><table width="800%" border="0" cellspacing="1" cellpadding="5">
          <tr>
            <td width="50%" class="doc_top_head">Dental Sleep Solutions ®
                <br>
              Practice Management</td>
            <td width="50%">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
            <td height="4" valign="top" class="bg_line"><img src="images/blank.gif" width="1" height="4"></td>
      </tr>
      <tr>
        <td style="padding-top:5px;"><div id="slidemenu" class="slidetabsmenu">
<ul>
<li><a href="#" title="Home"><span>Home</span></a></li>
<li><a href="#" title="Staff"><span>Staff</span></a></li>
<li><a href="#" title="Contacts"><span>Contacts</span></a></li>
<li><a href="#" title="Sleep Lab"><span>Sleep Lab</span></a></li>	
<li><a href="#" title="Referred By"><span>Referred By</span></a></li>	
<li><a href="#" title="Custom Text"><span>Custom Text</span></a></li>	
<li><a href="#" title="Patient" rel="dropmenu1_c"><span>Patient</span></a></li>	
<li><a href="#" title="Ledger"><span>Ledger</span></a></li>	
<li><a href="#" title="Logout"><span>Logout</span></a></li>	
</ul>
</div>

<br style="clear: left;" />
<br class="IEonlybr" />



<!--1st drop down menu -->                                                   
<div id="dropmenu1_c" class="dropmenudiv_c">
<a href="#">Questionnaire</a>
<a href="#">Clinical Exam</a>
<a href="#">Clinical Exam</a>
<a href="#">Summary Sheet</a>
<a href="#">Ledger</a>
<a href="#">Progress Notes</a>
<a href="#">Insurance</a>
<a href="#">Letters</a>
<a href="#">Flow Sheet</a>

</div>


<!--2nd drop down menu -->                                                
<div id="dropmenu2_c" class="dropmenudiv_c" style="width: 150px;">
<a href="http://www.cssdrive.com">CSS Drive</a>
<a href="http://www.javascriptkit.com">JavaScript Kit</a>
<a href="http://www.codingforums.com">Coding Forums</a>
<a href="http://www.javascriptkit.com/jsref/">JavaScript Reference</a></div>

<script type="text/javascript">
//SYNTAX: tabdropdown.init("menu_id", [integer OR "auto"])
tabdropdown.init("slidemenu")
</script>
</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="right" > 
	<div id="ddtopmenubar" class="mattblackmenu">
    	<br />
        <span class="welcome">
        <?
        if($_SESSION['userid'] != '')
        {?>
        	Hello <?=$_SESSION['name'];?>
            -
            <? 
            if($_SESSION['user_access'] == 1)
            {
            	echo "Staff Login";
            }
            if($_SESSION['user_access'] == 2)
            {
            	echo "Doctor's Login";
            }
            ?>
            [<a href="logout.php" class="leftnav">LOGOUT</a>]
            &nbsp;&nbsp;
            <?
            echo '<br><br>';
        }
        ?>
        </span>
		<? if($unload == 1) 
		{?> 
			<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('index');">Home</a>
		<?
		}
		else
		{?>
			<a href="index.php" class="leftnav">Home</a>
		<? }?>
        &nbsp;&nbsp;
        <?
        if($_SESSION['userid'] == '')
        {
        ?>
        	<a href="login.php" class="leftnav">Login</a>
	        &nbsp;&nbsp;
        <?
        }
        else
        {
        ?>
        	<!--<a href="myaccount.php" class="leftnav">My Page</a>
	        &nbsp;&nbsp; -->
            
            <? if($_SESSION['user_access'] >1)
            {?>
                <? if($unload == 1) 
				{?> 
					<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('manage_staff');">Staff</a>
				<?
				}
				else
				{?>
					<a href="manage_staff.php" class="leftnav">Staff</a>
				<? }?>
                &nbsp;&nbsp;
            <? }?>
            
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('manage_contact');">Contacts</a>
			<?
			}
			else
			{?>
	             <a href="manage_contact.php" class="leftnav">Contacts</a>
			<? }?>
             &nbsp;&nbsp;
			 
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('manage_sleeplab');">Sleep Lab</a>
			<?
			}
			else
			{?>			
				 <a href="manage_sleeplab.php" class="leftnav">Sleep Lab</a>
			<? }?>
             &nbsp;&nbsp;
			 
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('manage_referredby');">Referred By</a>
			<?
			}
			else
			{?>
				<a href="manage_referredby.php" class="leftnav">Referred By</a>
			<? }?>
			 
             &nbsp;&nbsp;
             
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('manage_custom');">Custom Text</a>
			<?
			}
			else
			{?>
				<a href="manage_custom.php" class="leftnav">Custom Text</a>
			<? }?>
             
             &nbsp;&nbsp;
             
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" <? if($_GET['pid'] <> '' && $unload == 1) {?> rel="ddsubmenu3" <? }?> onclick="Javascript: change_page1('manage_patient');">Patient</a>
			<?
			}
			else
			{?>
				<a href="manage_patient.php" class="leftnav">Patient</a>
			<? }?>
             
             &nbsp;&nbsp;
			 
			<? if($unload == 1) 
			{?> 
				<a href="Javascript: ;" class="leftnav" onclick="Javascript: change_page1('ledger');">Ledger</a>
			<?
			}
			else
			{?>
				<a href="ledger.php" class="leftnav">Ledger</a>
			<? }?>
			 
             &nbsp;&nbsp;
        <?
        }?>
	</div>
	<script type="text/javascript">
ddlevelsmenu.setup("ddtopmenubar", "topbar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
</script>




<!--HTML for the Drop Down Menus associated with Top Menu Bar-->
<!--They should be inserted OUTSIDE any element other than the BODY tag itself-->
<!--A good location would be the end of the page (right above "</BODY>")-->

<!--Top Drop Down Menu 3 HTML-->

<ul id="ddsubmenu3" class="ddsubmenustyle">
	<li><a href="q_page1.php?pid=<?=$_GET["pid"];?>">Questionnaire</a></li>
	<li><a href="ex_page4.php?pid=<?=$_GET["pid"];?>">Clinical Exam</a></li>
	<li><a href="dss_summary.php?pid=<?=$_GET['pid'];?>">Summary Sheet</a></li>
	<li><a href="manage_ledger.php?pid=<?=$_GET["pid"];?>">Ledger</a></li>
	<li><a href="manage_progress_notes.php?pid=<?=$_GET["pid"];?>">Progress Notes</a></li>
	<li><a href="manage_insurance.php?pid=<?=$_GET["pid"];?>">Insurance</a></li>
	<? if(st($_SESSION['adminuserid'] <> '')) {?>
	<li><a href="dss_letters.php?pid=<?=$_GET['pid'];?>">Letters</a></li>
	<? }?>
	<li><a href="manage_flowsheet.php?pid=<?=$_GET["pid"];?>">Flow Sheet</a></li>
</ul>	</td>
  </tr>
  <tr bgcolor="#FFFFFF">
	<td bgcolor='#FFFFFF' valign='top' height="400">

sss	</td>
</tr>
<tr bgcolor="#FFFFFF">
    <td height="23" colspan="2" align="center">[Bottom section]</td>
  </tr>
</table>
</body>
</html>
