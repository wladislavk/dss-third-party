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
        <?= $r['transaction_code']; ?>
      </td>
      <td>
        <?= $r['firstname']." ".$r['lastname']; ?>
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

