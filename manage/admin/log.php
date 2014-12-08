<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

$doc_sql = "select * from dental_users where userid = '".s_for($_GET['led'])."'";
$doc_my = mysqli_query($con,$doc_sql);
$doc_myarray = mysqli_fetch_array($doc_my);


$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_login where userid='".$_GET['led']."' order by login_date desc";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con,$sql);
$num_users=mysqli_num_rows($my);

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
	
    <div class="page-header">
    	Login Data For <i><?=st($doc_myarray['username']);?></i>
    </div>
    
    <br /><br /><br />
    <table class="table table-bordered table-hover">
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
        <? if(mysqli_num_rows($my) == 0)
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
            while($myarray = mysqli_fetch_array($my))
            {
                if(!empty($myarray["status"]) && $myarray["status"] == 1)
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
