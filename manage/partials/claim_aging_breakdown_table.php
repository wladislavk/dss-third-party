<?php namespace Ds3\Libraries\Legacy; ?><table class="sort_table" width="98%" align="center">
  <thead>
    <tr>
      <th width="10%">Days</th>
      <th width="10%">Since</th>
      <th width="10%">DOS</th>
      <th width="10%">Service</th>
<?php if(defined('DSS_OFFICE_BACK') && $office_type==DSS_OFFICE_BACK){ ?>
      <th width="10%">Patient</th>
      <th width="10%">Account</th>
<?php }else{ ?>
      <th width="10%">Client</th>
<?php } ?>
      <th width="10%">Charge</th>
      <th width="10%">Ins</th>
      <th width="10%">Client</th>
      <th width="10%">Adj</th>
      <th width="10%">Balance</th>
    </tr>
  </thead>
  <tbody>
  <?php if ($q) foreach ($q as $r) { ?>
    <tr>
      <td>
        <?php echo  ceil((date('U')-strtotime($r['mailed_date']))/(3600*24)); ?>
      </td>
      <td>
        <?php echo  ($r['mailed_date'])?date('m/d/Y', strtotime($r['mailed_date'])):'';?>
      </td>
      <td>
        <?php echo  ($r['service_date'])?date('m/d/Y', strtotime($r['service_date'])):''; ?>
      </td>
      <td>
         <?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
		<a href="view_claim.php?claimid=<?php echo  $r['insuranceid']; ?>&pid=<?php echo  $r['patientid']; ?>"><?php echo  $r['transaction_code']; ?></a>
	<?php }else{ ?>
		<?php echo  $r['transaction_code']; ?>
	<?php } ?>
      </td>
      <td>
	<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
          <a href="manage_ledger.php?pid=<?php echo  $r['patientid']; ?>&addtopat=1"><?php echo  $r['firstname']." ".$r['lastname']; ?></a>
	<?php }else{ ?>
          <a href="view_patient.php?pid=<?php echo  $r['patientid']; ?>"><?php echo  $r['firstname']." ".$r['lastname']; ?></a>
	<?php } ?>
      </td>
<?php if(defined('DSS_OFFICE_BACK') && $office_type==DSS_OFFICE_BACK){ ?>
      <td>
	<?php echo  $r['doc_name']; ?>
      </td>
<?php } ?>
      <td>
        $<?php echo  number_format($r['amount'],2); ?>
      </td>
      <td>
        $<?php echo  number_format($r['ins_payment'],2); ?>
      </td>
      <td>
        $<?php echo  number_format($r['client_payment'],2); ?>
      </td>
      <td>
        $<?php echo  number_format($r['adj_payment'],2); ?>
      </td>
      <td>
        $<?php echo  number_format(($r['amount']-($r['ins_payment']+$r['client_payment']+$r['adj_payment'])),2); ?>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>

