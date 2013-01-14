<?php

$sql = "select * from dental_insurance where (status=".DSS_CLAIM_PENDING." OR status=".DSS_CLAIM_SEC_PENDING.") AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate DESC";
$my=mysql_query($sql) or die(mysql_error());

?>


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
                <td valign="top" class="col_head" width="60%">
                        Date
                </td>
                <td valign="top" class="col_head" width="20%">
                        Status
                </td>
                <td valign="top" class="col_head" width="20%">
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
                        if($myarray["status"] == 1)
                        {
                                $tr_class = "tr_active";
                        }
                        else
                        {
                                $tr_class = "tr_inactive";
                        }
                        $tr_class = "tr_active";
                ?>
                        <tr class="<?=$tr_class;?>">
                                <td valign="top">
                        <?=date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
                                </td>
                                <td valign="top">
                                    <?=$dss_claim_status_labels[$myarray['status']];?>
                                </td>
                                <td valign="top">
                                        <a href="view_claim.php?claimid=<?=$myarray["insuranceid"];?>&pid=<?= $_GET['pid']; ?>" class="editlink" title="EDIT">
                                                View 
                                        </a>

                                </td>
                        </tr>
          <? } ?>
        <? } ?>
</table>

<?php


$sql = "select * from dental_insurance where status!=".DSS_CLAIM_PENDING." AND status!=".DSS_CLAIM_SEC_PENDING." AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate DESC";
$my=mysql_query($sql) or die(mysql_error());

?>


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
                <td valign="top" class="col_head" width="60%">
                        Date
                </td>
                <td valign="top" class="col_head" width="20%">
                        Status
                </td>
                <td valign="top" class="col_head" width="20%">
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
                        if($myarray["status"] == 1)
                        {
                                $tr_class = "tr_active";
                        }
                        else
                        {
                                $tr_class = "tr_inactive";
                        }
                        $tr_class = "tr_active";
                ?>
                        <tr class="<?=$tr_class;?>">
                                <td valign="top">
                        <?=date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
                                </td>
                                <td valign="top">
                                    <?=$dss_claim_status_labels[$myarray['status']];?>
                                </td>
                                <td valign="top">
					<a href="view_claim.php?claimid=<?=$myarray["insuranceid"];?>&pid=<?= $_GET['pid']; ?>" class="editlink" title="EDIT">
                                                View 
                                        </a>

                                </td>
                        </tr>
          <? } ?>
        <? } ?>
</table>
  <?php
/*
    // Display a placeholder row for any ledger trxns that need added to a new claim
    $sql = "SELECT "
         . "  ledger.* "
         . "FROM "
         . "  dental_ledger ledger "
         . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
         . "  JOIN dental_users user ON user.userid = ledger.docid "
         . "WHERE "
         . "  (ledger.primary_claim_id IS NULL || ledger.primary_claim_id ='') "
         . "  AND ledger.status = " . DSS_TRXN_PENDING . " "
         . "  AND ledger.patientid = " . $_GET['pid'] . " "
         . "  AND ledger.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " ";
    $query = mysql_query($sql);
    $num_trxns = mysql_num_rows($query);
    $row_text = ($num_trxns == 1) ? "is 1 ledger transaction" : "are $num_trxns ledger transactions";
  ?>
<?php if ($num_trxns > 0) { ?>
  <tr class="<?=$tr_class;?>">
    <td>There <?=$row_text?> ready to be added to a new claim.</td>
    <td>n/a</td>
    <td>
      <?php if ($num_trxns > 0) { ?>
        <button onclick="Javascript: window.location = 'insurance.php?pid=<?=$_GET['pid'];?>';" class="addButton">
                  Add New Claim
            </button>
      <?php } ?>
    </td>
  </tr>
  <?php
  }

    // Display a placeholder row for any ledger trxns that need added to a new claim
    $sql = "SELECT "
         . "  ledger.* "
         . "FROM "
         . "  dental_ledger ledger "
         . "  JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code "
         . "  JOIN dental_users user ON user.userid = ledger.docid "
         . "  JOIN dental_insurance ins ON ins.insuranceid = ledger.primary_claim_id "
         . "WHERE "
         . "  ins.status = " . DSS_CLAIM_PENDING . " "
         . "  AND ledger.patientid = " . $_GET['pid'] . " "
         . "  AND ledger.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.docid = " . $_SESSION['docid'] . " "
         . "  AND trxn_code.type = " . DSS_TRXN_TYPE_MED . " ";
    $query = mysql_query($sql);
    $num_trxns = mysql_num_rows($query);
    $row_text = ($num_trxns == 1) ? "is 1 ledger transaction" : "are $num_trxns ledger transactions";
  ?>
  <tr class="<?=$tr_class;?>">
    <td>There <?=$row_text?> on pending claims.</td>
    <td>n/a</td>
    <td>
    </td>
</table>
*/
?>
