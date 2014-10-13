<?php
$sql = "SELECT "
       . "  * "
       . "FROM "
       . "  dental_insurance_preauth "
       . "WHERE "
       . "  patient_id = " . $_GET['pid'] . " ";
if(isset($_GET['vob_id']) && $_GET['vob_id']!=''){
  $sql .= " AND id='".mysql_real_escape_string($_GET['vob_id'])."' ";
}
$sql .= " ORDER BY "
         . "  front_office_request_date DESC "
         . "LIMIT 1";
$my = $db->getResults($sql) or die(mysql_error());
if (count($my) > 0) { ?>

<div style="margin:auto; width:95%">
  <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" >
    <tr class="tr_bg_h">
      <th colspan="3" valign="top" class="col_head">
        Patient Verification of Benefits Information
      </th>
    </tr>

<?php 
  foreach ($my as $preauth) {
    if($preauth['status']==DSS_PREAUTH_PENDING){ ?>

    <tr class="tr_bg">
      <td valign="top" align="center">
        Verification of benefits request was submitted <?php echo date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently pending.
      </td>
    </tr>
  	<tr>
  	  <td><a href="manage_insurance.php?pid=<?php echo $_GET['pid']; ?>&addtopat=1&vobdel=<?php echo $preauth['id']; ?>" onclick="return confirm('This will cancel the VOB request. Are you sure?');">Cancel</a></td>
    </tr>	
<?php 
    } elseif($preauth['status']==DSS_PREAUTH_PREAUTH_PENDING){ ?>

    <tr class="tr_bg">
      <td valign="top" align="center">
              Verification of benefits request was submitted <?php echo date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently awaiting pre-authorization.
      </td>
    </tr>
<?php 
    } elseif($preauth['status']==DSS_PREAUTH_REJECTED){ ?>

        <?php } elseif ($preauth['status']==DSS_PREAUTH_COMPLETE) { ?>
        <tr class="tr_bg">
          <td valign="top" colspan="3" align="center">
                    Verification of benefits completed on <?= date('m/d/Y', strtotime($preauth['date_completed'])); ?>.<br/>
                    Pays for replacement device every <?=$preauth['how_often'];?> years.
          </td>
        </tr>
        <tr class="tr_bg">
          <?php
             $out_table_class = ($preauth['network_benefits'] == '1') ? 'highlight' : 'no_highlight';
             $in_table_class = ($preauth['network_benefits'] != '1') ? 'highlight' : 'no_highlight';
          ?>
          <td>Benefits</td>
          <td class=<?= $out_table_class?>>
            <?php $out_checked = ($preauth['network_benefits'] == '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            (<?= $out_checked ?>) Out of network<br/>
          </td>
          <td class=<?= $in_table_class?>> 
            <?php $in_checked  = ($preauth['network_benefits'] != '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            (<?= $in_checked ?>) In Network
          </td>
        </tr>
        <tr class="tr_bg">
          <td>What is the patient's annual deductible?</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['patient_deductible'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_patient_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount met?</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['patient_amount_met'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_patient_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount left to meet?</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['patient_amount_left_to_meet'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_patient_amount_left_to_meet'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>What is the family deductible?</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['family_deductible'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_family_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Family amount met?</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['family_amount_met'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_family_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>When does the deductible reset?</td>
          <td colspan="2" class="highlight"><?= $preauth['deductible_reset_date'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Has patient's out of pocket expense been met?</td>
          <td class=<?= $out_table_class?>><?= ($preauth['out_of_pocket_met'] == '0') ? 'No' : 'Yes' ?></td>
          <td class=<?= $in_table_class?>><?= ($preauth['in_out_of_pocket_met'] == '0') ? 'No' : 'Yes' ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Insurance plan notes</td>
          <td colspan="2" class="highlight"><?= $preauth['code_covered_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Out-of-network notes</td>
          <td colspan="2" class="highlight"><?= $preauth['hmo_auth_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Insurance/Patient Pay (%)</td>
            <td class=<?= $out_table_class?>><?= $preauth['out_of_network_percentage']." / ". (100-$preauth['out_of_network_percentage']); ?></td>
            <td class=<?= $in_table_class?>><?= $preauth['in_network_percentage']." / ". (100-$preauth['in_network_percentage']); ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Device amount?</td>
          <td colspan="2" class="highlight">$<?= $preauth['trxn_code_amount'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Maximum possible insurance payment*</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['expected_insurance_payment'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_expected_insurance_payment'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Minimum possible patient payment*</td>
          <td class=<?= $out_table_class?>>$<?= $preauth['expected_patient_payment'] ?></td>
          <td class=<?= $in_table_class?>>$<?= $preauth['in_expected_patient_payment'] ?></td>
        </tr>
	<tr>
	  <td style="font-size:10px;">Final benefits are based on the insurance plan allowable amount, NOT your fee. The patient contribution is specified by the insurance plan, but out-of-network providers CANNOT know final insurance reimbursement until a claim has been submitted. THE 'MAXIMUM POSSIBLE INSURANCE PAYMENT' IS NOT A GUARANTEE OF *ANY* INSURANCE PAYMENT. DO NOT RELY ON THIS ESTIMATE WHEN CALCULATING INSURANCE REIMBURSEMENT.</td>
	</tr>
	<tr>
	  <td>
	    <a class="vob_request new" data-ut="<?= $_SESSION['user_type']; ?>" data-pid="<?= $_GET['pid']; ?>"></a>
	  </td>
	</tr>
        <?php } ?>
	<?php } ?>
  </table>

</div>
<?php 
}else{ ?>
  <a class="vob_request" data-ut="<?php echo $_SESSION['user_type']; ?>" data-pid="<?php echo $_GET['pid']; ?>"></a>
<?php 
} ?>

