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
      <th colspan="2" valign="top" class="col_head">
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

    <tr class="tr_bg">
      <td valign="top" align="center" style="color:#930;">
        Verification of benefits request was submitted <?php echo date('m/d/Y', strtotime($preauth['front_office_request_date'])); ?> and has been rejected because "<strong><?php echo $preauth['reject_reason']; ?></strong>".
        <a class="vob_request reject" data-reject="<?php echo addslashes($preauth['reject_reason']);?>" data-ut="<?php echo $_SESSION['user_type']; ?>" data-pid="<?php echo $_GET['pid']; ?>"></a>
      </td>
    </tr>
<?php 
    } elseif ($preauth['status']==DSS_PREAUTH_COMPLETE) { ?>
    <tr class="tr_bg">
      <td valign="top" colspan="2" align="center">
        Verification of benefits completed on <?php echo date('m/d/Y', strtotime($preauth['date_completed'])); ?>.<br/>
        Pays for replacement device every <?php echo $preauth['how_often'];?> years.
      </td>
    </tr>
    <tr class="tr_bg">
      <td>Benefits</td>
      <td>
        <?php $out_checked = ($preauth['network_benefits'] == '1') ? 'X' : '&nbsp;&nbsp;';
              $in_checked  = ($preauth['network_benefits'] != '1') ? 'X' : '&nbsp;&nbsp;'; ?>
        (<?php echo $out_checked ?>) Out of network<br/>
        (<?php echo $in_checked ?>) In Network
      </td>
    </tr>
    <tr class="tr_bg">
      <td>What is the patient's annual deductible?</td>
      <td>$<?php echo $preauth['patient_deductible'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Amount met?</td>
      <td>$<?php echo $preauth['patient_amount_met'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Amount left to meet?</td>
      <td>$<?php echo $preauth['patient_amount_left_to_meet'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>What is the family deductible?</td>
      <td>$<?php echo $preauth['family_deductible'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Family amount met?</td>
      <td>$<?php echo $preauth['family_amount_met'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>When does the deductible reset?</td>
      <td><?php echo $preauth['deductible_reset_date'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Has patient's out of pocket expense been met?</td>
      <td><?php echo ($preauth['out_of_pocket_met'] == '0') ? 'No' : 'Yes' ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Insurance plan notes</td>
      <td><?php echo $preauth['code_covered_notes']; ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Out-of-network notes</td>
      <td><?php echo $preauth['hmo_auth_notes']; ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Insurance/Patient Pay (%)</td>
      <td>
<?php
      if($preauth['has_out_of_network_benefits']){
        echo $preauth['out_of_network_percentage']." / ". (100-$preauth['out_of_network_percentage']);
      }else{
        echo $preauth['in_network_percentage']." / ". (100-$preauth['in_network_percentage']);
      }?>
      </td>
    </tr>
    <tr class="tr_bg">
      <td>Device amount?</td>
      <td>$<?php echo $preauth['trxn_code_amount'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Maximum possible insurance payment*</td>
      <td>$<?php echo $preauth['expected_insurance_payment'] ?></td>
    </tr>
    <tr class="tr_bg">
      <td>Minimum possible patient payment*</td>
      <td>$<?php echo $preauth['expected_patient_payment'] ?></td>
    </tr>
  	<tr>
  	  <td style="font-size:10px;">Final benefits are based on the insurance plan allowable amount, NOT your fee. The patient contribution is specified by the insurance plan, but out-of-network providers CANNOT know final insurance reimbursement until a claim has been submitted. THE 'MAXIMUM POSSIBLE INSURANCE PAYMENT' IS NOT A GUARANTEE OF *ANY* INSURANCE PAYMENT. DO NOT RELY ON THIS ESTIMATE WHEN CALCULATING INSURANCE REIMBURSEMENT.</td>
  	</tr>
  	<tr>
  	  <td>
  	    <a class="vob_request new" data-ut="<?php echo $_SESSION['user_type']; ?>" data-pid="<?php echo $_GET['pid']; ?>"></a>
  	  </td>
  	</tr>
<?php 
    }
  } ?>
  </table>

</div>
<?php 
}else{ ?>
  <a class="vob_request" data-ut="<?php echo $_SESSION['user_type']; ?>" data-pid="<?php echo $_GET['pid']; ?>"></a>
<?php 
} ?>

