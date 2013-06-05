<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
/*$sql = "select du.name, du.userid, du.username, count(dl.ledgerid) as num_trxn from dental_users du 
    LEFT JOIN dental_ledger dl 
	ON dl.docid=du.userid 
		AND dl.status = '".DSS_PERCASE_PENDING."' 
WHERE du.docid=0
 group by du.name, du.username, du.userid";
echo $sql;
*/
if(is_super($_SESSION['admin_access'])){
  $sql = "SELECT du.*, c.name AS company_name 
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                WHERE du.docid=0";
}else{
  $sql = "SELECT du.*, c.name AS company_name 
		FROM dental_users du 
		JOIN dental_user_company uc ON uc.userid = du.userid
		JOIN companies c ON c.id=uc.companyid
		WHERE du.docid=0 AND uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'";
}
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Invoicing	
</span>
<br />


<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="14%">
			Username		
		</td>
                <td valign="top" class="col_head" width="20%">
                        Company
                </td>
		<td valign="top" class="col_head" width="15%">
			Name		
		</td>
                <td valign="top" class="col_head" width="15%">
                        Faxes (Last 30 days)
                </td>
		<td valign="top" class="col_head" width="10%">
			Unbilled Faxes		
		</td>
		<td valign="top" class="col_head" width="10%">
			Pages (Last 30 days)
		</td>
		<td valign="top" class="col_head" width="16%">
			Unbilled Pages
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
		$fax_sql = "SELECT COUNT(*) AS num_faxes, SUM(pages) AS pages FROM dental_faxes df 
        WHERE 
                df.docid='".$myarray['userid']."' AND
                df.status = '0'
";
$fax_q = mysql_query($fax_sql);
		$fax = mysql_fetch_assoc($fax_q);
                $fax30_sql = "SELECT COUNT(*) AS num_faxes, SUM(pages) AS pages FROM dental_faxes df 
        WHERE 
                df.docid='".$myarray['userid']."' AND
                df.sent_date > DATE_SUB(now(), INTERVAL 30 DAY) 
";
$fax30_q = mysql_query($fax30_sql);
                $fax30 = mysql_fetch_assoc($fax30_q);
		?>
			<tr>
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
                                <td valign="top">
                                        <?=st($myarray["company_name"]);?>
                                </td>
                                <td valign="top">
                                        <?=st($myarray["name"]);?>
                                </td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?=st($fax30["num_faxes"]);?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($fax["num_faxes"]); ?>
				</td>
				<td valign="top" align="center">
					<?php
					    echo st($fax30["pages"]); ?>
				</td>	
						
				<td valign="top">
					<?php
					    echo st($fax["pages"]); ?>
				</td>
			</tr>
	<? 	}

	}?>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
