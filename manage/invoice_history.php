<? 
include "includes/top.htm";

if($_SESSION['docid'] != $_SESSION['userid']){
  ?>
  <h3 style="margin-left:20px;">You are not permitted to view this page.</h3>
  <?php
  die();
}

$sql = "SELECT pi.* FROM dental_percase_invoice pi
	WHERE pi.docid=".mysql_real_escape_string($_SESSION['docid'])." ORDER BY adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

$doc_sql = "SELECT * from dental_users WHERE userid=".mysql_real_escape_string($_GET['docid']);
$doc_q = mysql_query($doc_sql);
$doc = mysql_fetch_assoc($doc_q);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>


<span class="admin_head">
        Credit Card Billing History - <?= $doc['name']; ?>
</span>
<br />


<div align="center" class="red" style="clear:both;">
        <b><? echo $_GET['msg'];?></b>
</div>

<?php
  $charge_sql = "SELECT * FROM dental_charge
			WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $charge_q = mysql_query($charge_sql);
?>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                        Date
                </td>
                <td valign="top" class="col_head" width="20%">
                        Amount
                </td>
                <td valign="top" class="col_head" width="30%">
                        Customer 
                </td>
                <td valign="top" class="col_head" width="30%">
                        Charge
                </td>
        </tr>
        <? if(mysql_num_rows($charge_q) == 0)
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
                while($charge_r = mysql_fetch_array($charge_q))
                {
                ?>
                        <tr>
                                <td valign="top">
                                        <?=st(date('m/d/Y g:i a', strtotime($charge_r["charge_date"])));?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
                                        $<?php
                                            echo st($charge_r["amount"]); ?>
                                </td>
                                <td valign="top" style="font-weight:bold;">
                                        <a href="https://manage.stripe.com/customers/<?php
                                           echo st($charge_r["stripe_customer"]); ?>" target="_blank">
						<?php
                                           echo st($charge_r["stripe_customer"]); ?>
					</a>
                                </td>

                                <td valign="top" style="font-weight:bold;">
                                        <a href="https://manage.stripe.com/payments/<?php
                                           echo st($charge_r["stripe_charge"]); ?>" target="_blank">
                                                <?php
                                           echo st($charge_r["stripe_charge"]); ?>
                                        </a>

                                </td>

                        </tr>
        <?      }

        }?>
</table>
</form>


<br /><br />

<span class="admin_head">
        Per-case Invoice History - <?= $doc['name']; ?>
</span>
<br />


<div align="center" class="red" style="clear:both;">
        <b><? echo $_GET['msg'];?></b>
</div>


<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="25%">
			Date		
		</td>
		<td valign="top" class="col_head" width="25%">
			Total
		</td>
		<td valign="top" class="col_head" width="25%">
			Action	
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
		$case_sql = "SELECT COUNT(*) AS num_trxn, sum(percase_amount) AS ledger_total FROM dental_ledger dl 
        WHERE 
                dl.percase_invoice='".$myarray['id']."'
";
$case_q = mysql_query($case_sql);
		$case = mysql_fetch_assoc($case_q);
		$extra_sql = "SELECT sum(percase_amount) as extra_total FROM dental_percase_invoice_extra 
				WHERE percase_invoice='".$myarray['id']."'
";
		$extra_q = mysql_query($extra_sql);
		$extra = mysql_fetch_assoc($extra_q);
		?>
			<tr>
				<td valign="top">
					<?=st(date('m/d/Y g:i a', strtotime($myarray["adddate"])));?>
				</td>
				<td valign="top">
					$<?= number_format($extra['extra_total']+$case['ledger_total']+$myarray['monthly_fee_amount'],2); ?>
				</td>
				<td valign="top">
					<a href="./q_file/percase_invoice_<?= $myarray['docid'];?>_<?= $myarray['id']; ?>.pdf" class="button" title="EDIT" style="padding:3px 5px;" target="_blank">
						View PDF
					</a>
					&nbsp;&nbsp;
					<a href="invoice_history_view.php?invoice_id=<?= $myarray['id']; ?>" class="button" style="padding:3px 5px;">HTML</a>                    
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
