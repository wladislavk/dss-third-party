<?php
$sql = "SELECT "
     . "  * "
     . "FROM "
     . "  dental_insurance_preauth "
     . "WHERE "
     . "  patient_id = " . $_GET['pid'] . " "
     . "ORDER BY "
     . "  front_office_request_date DESC "
     . "LIMIT 1";
$my = mysql_query($sql) or die(mysql_error());
?>
<? if (mysql_num_rows($my) > 0) { ?>

<div style="margin:auto; width:98%">
  <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" >
    <tr class="tr_bg_h">
      <th colspan="2" valign="top" class="col_head">
        Patient Verification of Benefits Information
      </th>
    </tr>

      <?php while ($preauth = mysql_fetch_array($my)) { ?>

        <?php if($preauth['status']==DSS_PREAUTH_PENDING){ ?>

      <tr class="tr_bg">
        <td valign="top" align="center">
                Verification of benefits request was submitted <?= date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently pending.
        </td>
      </tr>

	<tr>
	  <td><a href="manage_insurance.php?pid=<?= $_GET['pid']; ?>&addtopat=1&vobdel=<?= $preauth['id']; ?>" onclick="return confirm('This will cancel the VOB request. Are you sure?');">Cancel</a></td>
	</tr>	


        <?php } elseif($preauth['status']==DSS_PREAUTH_PREAUTH_PENDING){ ?>

      <tr class="tr_bg">
        <td valign="top" align="center">
                Verification of benefits request was submitted <?= date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and is currently awaiting pre-authorization.
        </td>
      </tr>
        <?php } elseif($preauth['status']==DSS_PREAUTH_REJECTED){ ?>

      <tr class="tr_bg">
        <td valign="top" align="center" style="color:#930;">
                Verification of benefits request was submitted <?= date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and has been rejected because "<strong><?= $preauth['reject_reason']; ?></strong>".
              <a class="vob_request reject" data-reject="<?= addslashes($preauth['reject_reason']);?>" data-ut="<?= $_SESSION['user_type']; ?>" data-pid="<?= $_GET['pid']; ?>"></a>
        </td>
      </tr>


        <?php } elseif ($preauth['status']==DSS_PREAUTH_COMPLETE) { ?>
        <tr class="tr_bg">
          <td valign="top" colspan="2" align="center">
                    Verification of benefits completed on <?= date('m/d/Y', strtotime($preauth['date_completed'])); ?>.<br/>
                    Pays for replacement device every <?=$preauth['how_often'];?> years.
          </td>
        </tr>
        <tr class="tr_bg">
          <td>Benefits</td>
          <td>
            <?php $out_checked = ($preauth['network_benefits'] == '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            <?php $in_checked  = ($preauth['network_benefits'] != '1') ? 'X' : '&nbsp;&nbsp;'; ?>
            (<?= $out_checked ?>) Out of network<br/>
            (<?= $in_checked ?>) In Network
          </td>
        </tr>
        <tr class="tr_bg">
          <td>What is the patient's annual deductible?</td>
          <td>$<?= $preauth['patient_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount met?</td>
          <td>$<?= $preauth['patient_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Amount left to meet?</td>
          <td>$<?= $preauth['patient_amount_left_to_meet'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>What is the family deductible?</td>
          <td>$<?= $preauth['family_deductible'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Family amount met?</td>
          <td>$<?= $preauth['family_amount_met'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>When does the deductible reset?</td>
          <td><?= $preauth['deductible_reset_date'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Has patient's out of pocket expense been met?</td>
          <td><?= ($preauth['out_of_pocket_met'] == '0') ? 'No' : 'Yes' ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Insurance plan notes</td>
          <td><?= $preauth['code_covered_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Out-of-network notes</td>
          <td><?= $preauth['hmo_auth_notes']; ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Insurance/Patient Pay (%)</td>
          <td><?php
            if($preauth['has_out_of_network_benefits']){
                echo $preauth['out_of_network_percentage']." / ". (100-$preauth['out_of_network_percentage']);
            }else{
                echo $preauth['in_network_percentage']." / ". (100-$preauth['in_network_percentage']);
            }
        ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Device amount?</td>
          <td>$<?= $preauth['trxn_code_amount'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Expected insurance payment?</td>
          <td>$<?= $preauth['expected_insurance_payment'] ?></td>
        </tr>
        <tr class="tr_bg">
          <td>Expected patient payment?</td>
          <td>$<?= $preauth['expected_patient_payment'] ?></td>
        </tr>
	<tr>
	  <td style="font-size:10px;">Benefits are based on this insurance plan’s allowable amount, NOT your fee. The benefits quoted here are NOT a guarantee of payment, final benefits/reimbursement will be determined at the time a claim is processed.</td>
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
<?php }else{ ?>
  <a class="vob_request" data-ut="<?= $_SESSION['user_type']; ?>" data-pid="<?= $_GET['pid']; ?>"></a>
<?php } ?>

