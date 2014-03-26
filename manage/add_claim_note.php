<?php 
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if($_POST["notesub"] == 1)
{
  if($_POST['nid']==''){
		$ins_sql = "insert into dental_claim_notes set 
				claim_id = '".mysql_real_escape_string($_POST['claim_id'])."',
				note = '".mysql_real_escape_string($_POST['note'])."',
				create_type = '1',
				creator_id = '".mysql_real_escape_string($_SESSION['userid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());


		?>
		<script type="text/javascript">
			parent.window.location='view_claim.php?claimid=<?= $_POST['claim_id'];?>&pid=<?= $_POST['pid']; ?>&msg=<?=$msg;?>';
		</script>
		<?
		
		die();
  }else{
                $up_sql = "update dental_claim_notes set 
                                note = '".mysql_real_escape_string($_POST['note'])."'
				WHERE id='".mysql_real_escape_string($_POST['nid'])."'";
                mysql_query($up_sql) or die($up_sql.mysql_error());


                ?>
                <script type="text/javascript">
                        parent.window.location='view_claim.php?claimid=<?= $_POST['claim_id'];?>&pid=<?= $_POST['pid']; ?>&msg=<?=$msg;?>';
                </script>
                <?

                die();


  }
}

?>
<br /><br />
    <?

	if(isset($_GET['nid'])){
		$s = "SELECT * FROM dental_claim_notes WHERE id='".$_GET['nid']."'";
		$q = mysql_query($s);
		$r = mysql_fetch_assoc($q);
		$note = $r['note'];
	}else{
		$note = '';
	}
		
	 if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>

    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" onsubmit="return adminclaimnoteabc(this)">
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
		Add Claim Note
            </td>
        </tr>
         <tr> 
        	<td valign="top" class="frmhead">Note</td>
                <td valign="top" class="frmdata">
                            	<textarea name="note" id="note" class="field text addr tbox" style="width:100%; height:150px;"><?=$note?></textarea>
            </td>
        </tr>
        <tr >
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="notesub" value="1" />
		<input type="hidden" name="claim_id" value="<?= $_REQUEST['claim_id']; ?>" />
		<input type="hidden" name="nid" value="<?= $_REQUEST['nid']; ?>" />
		<input type="hidden" name="pid" value="<?= $_REQUEST['pid']; ?>" />
                <input type="submit" value=" Add/Edit Note" class="button" />
            </td>
        </tr>
    </table>
    </form>


      </div>

</body>
</html>
