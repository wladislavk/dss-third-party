<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");
include "../includes/general_functions.php";
include_once "includes/general.htm";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="script/jquery-1.6.2.min.js"></script>
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="../js/masks.js"></script>
<script type="text/javascript" src="script/wufoo.js"></script>
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
				create_type = '0',
				creator_id = '".mysql_real_escape_string($_SESSION['adminuserid'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());


		?>
		<script type="text/javascript">
			parent.window.location='claim_notes.php?id=<?= $_POST['claim_id'];?>&pid=<?= $_POST['pid']; ?>&msg=<?=$msg;?>';
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
                        parent.window.location='claim_notes.php?id=<?= $_POST['claim_id'];?>&pid=<?= $_POST['pid']; ?>&msg=<?=$msg;?>';
                </script>
                <?

                die();
  }
}


$sql = "select * from dental_claim_text order by Title";
$my = mysql_query($sql);

?>
<br /><br />
<script type="text/javascript">
        function change_desc(fa)
        {
                if(fa != '')
                {
                        var title_arr = new Array();
                        var desc_arr = new Array();
                        
                        <? $i=0;
                        //$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
                        //$my = mysql_query($sql);
                        while($myarray = mysql_fetch_array($my))
                        {?>
                                title_arr[<?=$i;?>] = "<?=st(addslashes($myarray['title']));?>";
                                desc_arr[<?=$i;?>] = "<?=st(trim( preg_replace( '/\n\r|\r\n/','%n%',addslashes($myarray['description']))));?>";
                        <?
                                $i++;                        }?>
                        document.getElementById("note").value = desc_arr[fa].replace(/\%n\%/g,'\r\n').replace(/&amp;/g,'&');;
                }
                else                {
                        document.getElementById("note").value = "";
                }
        }
        
</script>

    <?

        if(isset($_GET['nid'])){
                $s = "SELECT * FROM dental_claim_notes WHERE id='".$_GET['nid']."'";
                $q = mysql_query($s);
                $r = mysql_fetch_assoc($q);
                $note = $r['note'];
        }else{
                $note = '';
        }

		$but_text = "Add ";
	
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
                <td valign="top" colspan="2" class="frmhead">
                                Text Templates
                                <span class="red">*</span>
            <select name="title" class="tbox" onChange="change_desc(this.value)">
                <option value="">Select</option>
                <?
                                $j=0;
                                $my = mysql_query($sql);
                                while($myarray = mysql_fetch_array($my))
                                { ?>
                                        <option value="<?=$j;?>">
                        <?=st($myarray['title']);?>
                    </option>
                                <?
                                        $j++;
                                }?>
            </select>
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
		<input type="hidden" name="pid" value="<?= $_REQUEST['pid']; ?>" />
		<input type="hidden" name="nid" value="<?= $_REQUEST['nid']; ?>" />
                <input type="submit" value=" <?=$but_text?> Note" class="button" />
            </td>
        </tr>
    </table>
    </form>

<script type="text/javascript">
  $('#docid').change(function(){ 
	v = $(this).val();
	$.ajax({
		url: 'includes/account_users.php',
		data: {account:v},
		success: function(data){
			var r = $.parseJSON(data);
                        if(r.options){
                           $('#userid').html(r.options);      
                        }
		}
	});
  });
</script>

      </div>

</body>
</html>
