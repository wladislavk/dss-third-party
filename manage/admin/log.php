<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

$doc_sql = "select * from dental_users where userid = '".s_for($_GET['led'])."'";
$doc_my = mysql_query($doc_sql);
$doc_myarray = mysql_fetch_array($doc_my);


$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_login where userid='".$_GET['led']."' order by login_date desc";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>
	
    <span class="admin_head">
    	Login Data For <i><?=st($doc_myarray['username']);?></i>
    </span>
    
    <br /><br /><br />
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<? if($total_rec > $rec_disp) {?>
        <TR bgColor="#ffffff">
            <TD  align="right" colspan="15" class="bp">
                Pages:
                <?
                     paging($no_pages,$index_val,"led=".$_GET['led']);
                ?>
            </TD>        
        </TR>
        <? }?>
        <tr class="tr_bg_h">
            <td valign="top" class="col_head" width="30%">
                Login Date	
            </td>
            <td valign="top" class="col_head" width="30%">
                Logout Date
            </td>
            <td valign="top" class="col_head" width="40%">
                IP Address
            </td>
        </tr>
        <? if(mysql_num_rows($my) == 0)
        { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
        <? 
        }
        else
        {
            while($myarray = mysql_fetch_array($my))
            {
                if($myarray["status"] == 1)
                {
                    $tr_class = "tr_active";
                }
                else
                {
                    $tr_class = "tr_inactive";
                }
            ?>
                <tr class="<?=$tr_class;?>">
                    <td valign="top">
                    	<?= date('m-d-Y H:i',strtotime(st($myarray["login_date"])));?>
                    </td>
                    <td valign="top">
                        <?= (($myarray["logout_date"]!='')?date('m-d-Y H:i',strtotime(st($myarray["logout_date"]))):'');?>
                    </td>
                    <td valign="top">
                        <?=st($myarray["ip_address"]);?>
                    </td>
                </tr>
        <? 	}
        }?>
    </table>
    
</body>
</html>
