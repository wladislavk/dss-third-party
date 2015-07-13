<?php namespace Ds3\Libraries\Legacy; ?><?php 
    include "includes/top.htm";
    include_once "includes/constants.inc";
    require "includes/calendarinc.php";

    $sql = "SELECT * FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE (dl.primary_claim_id='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."' or dl.secondary_claim_id='".$_GET['cid']."');";
    $payments = $db->getRow($sql);
    $csql = "SELECT i.*, CONCAT(p.firstname, ' ',p.lastname) name FROM dental_insurance i JOIN dental_patients p ON p.patientid=i.patientid WHERE i.insuranceid='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."';";
    $claim = $db->getRow($csql);
    $pasql = "SELECT * FROM dental_insurance_file where claimid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."' AND
    		  (status = ".DSS_CLAIM_SENT." OR status = ".DSS_CLAIM_DISPUTE." OR status = ".DSS_CLAIM_EFILE_ACCEPTED.")";

    $num_pa = $db->getNumberRows($pasql);
    $sasql = "SELECT * FROM dental_insurance_file where claimid='".mysqli_real_escape_string($con,(!empty($_GET['cid']) ? $_GET['cid'] : ''))."' AND
              (status = ".DSS_CLAIM_SEC_SENT." OR status = ".DSS_CLAIM_SEC_DISPUTE." OR status = ".DSS_CLAIM_EFILE_ACCEPTED.")";

    $num_sa = $db->getNumberRows($sasql);
?>

    <div class="fullwidth">
      <br />
      <span class="admin_head">
        Claim Payment - Claim <?php echo  (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?> - <?php echo  $claim['name']; ?>
      </span>
      <br /><br />
        <script type="text/javascript">
            var DISPUTE_OR_SEC_DISPUTE_OR_PATIENT_DISPUTE_OR_SEC_PATIENT_DISPUTE = <?php echo  ($claim['status']==DSS_CLAIM_DISPUTE || $claim['status']==DSS_CLAIM_SEC_DISPUTE || $claim['status']==DSS_CLAIM_PATIENT_DISPUTE || $claim['status']==DSS_CLAIM_SEC_PATIENT_DISPUTE) ? 1 : 0; ?>;
            var PENDING_OR_SEC_PENDING = <?php echo  ($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING) ? 1 : 0; ?>;
            var PAID_INSURANCE = <?php echo  ($claim['status']==DSS_CLAIM_PAID_INSURANCE) ? 1 : 0; ?>;
            var PENDING = <?php echo  ($claim['status']==DSS_CLAIM_PENDING) ? 1 : 0; ?>;
            var DSS_TRXN_PAYER_PRIMARY = <?php echo  DSS_TRXN_PAYER_PRIMARY; ?>;
            var DSS_TRXN_PAYER_SECONDARY = <?php echo  DSS_TRXN_PAYER_SECONDARY; ?>;
            var DSS_CLAIM_SEC_PENDING = <?php echo  ($claim['status'] == DSS_CLAIM_SEC_PENDING) ? 1 : 0; ?>;
            var DSS_CLAIM_SENT = <?php echo  ($claim['status'] == DSS_CLAIM_SENT) ? 1 : 0; ?>;
            var DSS_CLAIM_SEC_SENT = <?php echo  ($claim['status']==DSS_CLAIM_SEC_SENT) ? 1 : 0; ?>;
            var DSS_CLAIM_EFILE_ACCEPTED = <?php echo  ($claim['status']==DSS_CLAIM_EFILE_ACCEPTED) ? 1 : 0; ?>;
            var num_pa = <?php echo  ($num_pa == 0) ? 1 : 0; ?>;
            var num_sa = <?php echo  ($num_sa == 0) ? 1 : 0; ?>;
            var user_access = <?php echo  ($_SESSION['user_access']==2) ? 1 : 0;?>;
        </script>

        <script type="text/javascript" src="/manage/js/ledger_payments_advanced.js"></script>
        <link rel="stylesheet" href="css/form.css" type="text/css" />

        <form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_payments_advanced.php" onsubmit="return validSubmission(this)" method="POST" enctype="multipart/form-data"> 
            <div style="width:200px; margin:0 auto; text-align:center;">
                <input type="hidden" value="0" id="currval" />
            </div>
            <?php
                $sql = "SELECT dlp.*, dl.description, dl.amount as ledger_amount FROM dental_ledger_payment dlp JOIN dental_ledger dl on dlp.ledgerid=dl.ledgerid WHERE (dl.primary_claim_id='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."' or dl.secondary_claim_id='".$_GET['cid']."');";
                $p_sql = $db->getResults($sql);
                if(count($p_sql)==0){
            ?>
                    <div style="margin-left:50px;">No Previous Payments</div>
            <?php
                }else{
            ?>
                <table style="width: 98%" border="1">
                  <tr>
                    <th>Payment Date</th>
                    <th>Entry Date</th>
                    <th>Description</th>
                    <th>Paid By</th>
                    <th>Payment Type</th>
                    <th>Billed Amount</th>
                    <th>Allowed</th>
                    <th>Paid Amount</th>
                    <th>Ins. Paid</th>
                    <th>Deductible</th>
                    <th>Copay</th>
                    <th>CoIns</th>
                    <th>Overpaid</th>
                    <th>Follow-up</th>
                    <th>Note</th>
                  </tr>
            <?php
                    if ($p_sql) foreach ($p_sql as $p){
                        if (!empty($p['followup']) && strtotime($p['followup']) > 0) {
                            $followUp = preg_replace('/ .*$/', '', $p['followup']);
                        } else {
                            $followUp = '';
                        }
            ?>
                  <tr>
                    <td><?php echo  date('m/d/Y', strtotime($p['payment_date'])); ?></td>
                    <td><?php echo  date('m/d/Y', strtotime($p['entry_date'])); ?></dt>
                    <td><?php echo  $p['description']; ?></td>
                    <td><?php echo  $dss_trxn_payer_labels[$p['payer']]; ?></td>
                    <td><?php echo  $dss_trxn_pymt_type_labels[$p['payment_type']]; ?></td>
                    <td><?php echo  ($p['ledger_amount'] > 0 ? $p['ledger_amount'] : ""); ?></td>
                    <td><?php echo  ($p['amount_allowed'] > 0 ? $p['amount_allowed'] : ""); ?></td>
                    <td><?php echo  ($p['amount'] > 0 ? $p['amount'] : ""); ?></td>
                    <td><?php echo  ($p['ins_paid'] > 0 ?  $p['ins_paid'] : ""); ?></td>
                    <td><?php echo  ($p['deductible'] > 0 ? $p['deductible'] : ""); ?></td>
                    <td><?php echo  ($p['copay'] > 0 ? $p['copay'] : ""); ?></td>
                    <td><?php echo  ($p['coins'] > 0 ? $p['coins'] : ""); ?></td>
                    <td><?php echo  ($p['overpaid'] > 0 ? $p['overpaid'] : ""); ?></td>
                    <td><?php echo  $followUp ?></td>
                    <td><?php echo  $p['note']; ?></td>
                  </tr>
            <?php 
                    }
            ?>
                </table>
                </br>
                </br>
                </br>
            <?php
                }
            ?>
                <span class="admin_head">
                  Add Advanced Claim Payment
                </span>
                </br>
                <div id="form_div">
                    <div id="select_fields" style="margin: 10px;">
                        <label>Paid By</label>
                        <select id="payer" name="payer" onchange="updateType(this)" style="width:170px;margin: 0pt 10px 0pt 0pt;" >
                            <option value="<?php echo  DSS_TRXN_PAYER_PRIMARY; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PAYER_SECONDARY; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PAYER_PATIENT; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PAYER_WRITEOFF; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PAYER_DISCOUNT; ?>"><?php echo  $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]; ?></option>
                        </select>
                        <label>Payment Type</label>
                        <select id="payment_type" name="payment_type" style="width:120px;margin: 0pt 10px 0pt 0pt; " >
                            <option value="<?php echo  DSS_TRXN_PYMT_CREDIT; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PYMT_DEBIT; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]; ?></option>
                            <option selected="selected" value="<?php echo  DSS_TRXN_PYMT_CHECK; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PYMT_CASH; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]; ?></option>
                            <option value="<?php echo  DSS_TRXN_PYMT_WRITEOFF; ?>"><?php echo  $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]; ?></option>
                        </select>
                    </div>

                    <link rel="stylesheet" href="/manage/css/ledger_payments_advanced.css" type="text/css" />

                    <table style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
                        <tr>
                            <td>Service Date</td>
                            <td>Description</td>
                            <td>Billled Amount</td>
                            <td>Allowed</td>
                            <td>Paid Amount <span class="req">*</span></td>
                            <td>Ins. Paid</td>
                            <td>Deductible</td>
                            <td>Copay</td>
                            <td>CoIns</td>
                            <td>Overpaid</td>
                            <td>Follow-up</td>
                            <td>Payment Date <span class="req">*</span></td>
                            <td>Note</td>
                        </tr>
                        <?php
                            $lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id='".(!empty($_GET['cid']) ? $_GET['cid'] : '')."' or secondary_claim_id='".$_GET['cid']."'";
                            
                            $lq = $db->getResults($lsql);
                            if ($lq) foreach ($lq as $row){
                        ?>
                                <tr class="claims">
                                    <td><?php echo  $row['service_date']; ?></td>
                                    <td><?php echo  $row['description']; ?></td>
                                    <td>$<?php echo  $row['amount']; ?></td>
                                    <td><input class="allowed_amount dollar_input" type="text" name="allowed_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['allowed']) ? $row['allowed'] : ''); ?>" /></td>
                                    <td><input class="payment_amount dollar_input" type="text" name="amount_<?= $row['ledgerid']; ?>" /></td>
                                    <td><input class="ins_paid dollar_input" type="text" name="ins_paid_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['ins_paid']) ? $row['ins_paid'] : ''); ?>" /></td>
                                    <td><input class="deductible dollar_input" type="text" name="deductible_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['deductible']) ? $row['deductible'] : ''); ?>" /></td>
                                    <td><input class="copay dollar_input" type="text" name="copay_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['copay']) ? $row['copay'] : ''); ?>" /></td>
                                    <td><input class="coins dollar_input" type="text" name="coins_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['coins']) ? $row['coins'] : ''); ?>" /></td>
                                    <td><input class="overpaid dollar_input" type="text" name="overpaid_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['overpaid']) ? $row['overpaid'] : ''); ?>" /></td>
                                    <td><input class="followup calendar_top" type="text" id="followup_<?= $row['ledgerid']; ?>" name="followup_<?= $row['ledgerid']; ?>" value="<?= $row['followup']; ?>" /></td>
                                    <td><input class="calendar_top payment_date" type="text" id="payment_date_<?= $row['ledgerid']; ?>" name="payment_date_<?= $row['ledgerid']; ?>" value="<?= date('m/d/Y'); ?>" /></td>
                                    <td><input class="note" type="text" name="note_<?= $row['ledgerid']; ?>" value="<?php echo  (!empty($row['note']) ? $row['note'] : ''); ?>" /></td>
                                </tr>
                        <?php
                            }
                        ?>
                    </table>
                    <br />

                    <input type="checkbox" id="close" name="close" onclick=" if(this.checked){ $('#dispute').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').hide('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value="1"  <?= (isset($_GET['close']) && $_GET['close']==1)?'checked="checked"':''; ?> /> <label >Close Claim</label>
                    <br />
                    <input type="checkbox" id="dispute" name="dispute" onclick=" if(this.checked){ $('#close').removeAttr('checked');$('#ins_attach').show('slow');$('#dispute_reason_div').show('slow'); }else{ $('#ins_attach').hide('slow');$('#dispute_reason_div').hide('slow'); }" value='1' /> <label>Dispute</label>
                    <div id="dispute_reason_div" style="display: none">
                        <label>Reason for dispute:</label> <input type="text" name="dispute_reason" />
                    </div>
                    <div id="ins_attach" style="display: none">
                        <label>Explanation of Benefits:</label> <input type="file" name="attachment" /><br />
                    </div>

                    <input type="hidden" name="claimid" value="<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>">
                    <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
                    <input type="hidden" name="producer" value="<?php echo $_SESSION['username']; ?>">
                    <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
                    <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
                    <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                    <input type="hidden" name="entrycount" value="javascript::readCookie();">

                    <div style="width:200px;float:right;margin-left:10px;text-align:left;" id="submitButton">
                        <input style="width:auto;" type="submit" value="Submit Payments" />
                    </div>
                </div>

                <div id="auth_div" style="display:none; padding: 10px;">
                    <p>You are not authorized to complete this transaction. Please have an authorized user enter their credentials.</p>
                    Username: <input type="text" name="username" /><br />
                    Password: <input type="password" name="password" /><br />
                    <input type="submit" value="Submit" style="width:auto;" />
                </div>

        </form>

        <br><br>
        <a href="view_claim.php?claimid=<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:left;">Cancel</a>
        <a href="add_ledger_payments.php?cid=<?php echo (!empty($_GET['cid']) ? $_GET['cid'] : ''); ?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="button" style="float:right;">Simple Payment</a>
        <div style="clear:both;"></div>
    </div>

<?php include 'includes/bottom.htm'; ?>
