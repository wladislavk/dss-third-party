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
$sql = "SELECT * FROM dental_users du WHERE du.docid=0";
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
	Per-case  Invoice	
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
		<td valign="top" class="col_head" width="20%">
			Username		
		</td>
		<td valign="top" class="col_head" width="40%">
			Name		
		</td>
		<td valign="top" class="col_head" width="20%">
			E0486 (Last 30 days)		
		</td>
		<td valign="top" class="col_head" width="10%">
			History
		</td>
		<td valign="top" class="col_head" width="10%">
			Invoice
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
		$case_sql = "SELECT COUNT(*) AS num_trxn FROM dental_ledger dl 
                JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$myarray['userid']."' AND
                dl.percase_status = '".DSS_PERCASE_PENDING."'
";
$case_q = mysql_query($case_sql);
		$case = mysql_fetch_assoc($case_q);
		?>
			<tr>
				<td valign="top">
					<?=st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["name"]);?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($case["num_trxn"]); ?>
				</td>
				<td valign="top" align="center">
					<a href="#">History</a>
				</td>	
						
				<td valign="top">
					<a href="percase_invoice.php?docid=<?=$myarray["userid"];?>" class="button" title="EDIT" style="padding:3px 5px;">
						Create
					</a>
                    
				</td>
			</tr>
	<? 	}

		?>
		<tr>
			<td valign="top" class="col_head" colspan="3">&nbsp;
				
			</td>
			<td valign="top" class="col_head" colspan="2">
				<input type="hidden" name="sortsub" value="1" />
				<input type="submit" value=" Change " class="button" />
			</td>
		</tr>
		<?
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
