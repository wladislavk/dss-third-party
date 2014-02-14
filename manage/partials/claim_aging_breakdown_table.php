<table class="sort_table" width="98%" align="center">
  <thead>
    <tr>
      <th>Days</th>
      <th>Since</th>
      <th>DOS</th>
      <th>Service</th>
      <th>Client</th>
      <th>Charge</th>
      <th>Ins</th>
      <th>Client</th>
      <th>Adj</th>
      <th>Balance</th>
    </tr>
  </thead>
  <tbody>
  <?php while($r = mysql_fetch_assoc($q)){ ?>
    <tr>
      <td>
        <?= ceil((date('U')-strtotime($r['mailed_date']))/(3600*24)); ?>
      </td>
      <td>
        <?= ($r['mailed_date'])?date('m/d/Y', strtotime($r['mailed_date'])):'';?>
      </td>
      <td>
        <?= ($r['service_date'])?date('m/d/Y', strtotime($r['service_date'])):''; ?>
      </td>
      <td>
         <?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
		<a href="view_claim.php?claimid=<?= $r['insuranceid']; ?>&pid=<?= $r['patientid']; ?>"><?= $r['transaction_code']; ?></a>
	<?php }else{ ?>
		<?= $r['transaction_code']; ?>
	<?php } ?>
      </td>
      <td>
	<?php if($office_type == DSS_OFFICE_TYPE_FRONT){ ?>
          <a href="manage_ledger.php?pid=<?= $r['patientid']; ?>&addtopat=1"><?= $r['firstname']." ".$r['lastname']; ?></a>
	<?php }else{ ?>
	  <?= $r['firstname']." ".$r['lastname']; ?>
	<?php } ?>
      </td>
      <td>
        $<?= number_format($r['amount'],2); ?>
      </td>
      <td>
        $<?= number_format($r['ins_payment'],2); ?>
      </td>
      <td>
        $<?= number_format($r['client_payment'],2); ?>
      </td>
      <td>
        $<?= number_format($r['adj_payment'],2); ?>
      </td>
      <td>
        $<?= number_format(($r['amount']-($r['ins_payment']+$r['client_payment']+$r['adj_payment'])),2); ?>
      </td>
    </tr>
  <?php } ?>
  </tbody>
</table>

