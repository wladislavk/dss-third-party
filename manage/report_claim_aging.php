<?php 
  include "includes/top.htm";
?>

<link rel="stylesheet" href="css/ledger.css" />

<?php
  $sql = "SELECT p.firstname, p.lastname,
		      p.patientid
		      FROM dental_patients p
	        WHERE p.docid='".$_SESSION['docid']."'
	        AND (SELECT (SUM(COALESCE(CONVERT(REPLACE(i.total_charge,',',''),DECIMAL(11,2)),0)) -
	        COALESCE((SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
          LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
          WHERE dl.primary_claim_id=i.insuranceid), 0)
	         )
	        FROM dental_insurance i 
          WHERE i.patientid=p.patientid AND i.mailed_date IS NOT NULL) > 0
	        ORDER BY p.lastname ASC, p.firstname ASC
	        ";

  $my = $db->getResults($sql);
  $total_rec = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />

<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Claim Aging Report
</span>

<div>
  &nbsp;&nbsp;
  <a href="ledger.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

<br /><br />

<div align="center" class="red">
	<b>
    <?php
      if (!empty($_GET['msg'])) {
        echo $_GET['msg'];
      } else {
        echo '';
      }
        
    ?>
  </b>
</div>

<table class="ledger sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<thead>
	 <tr class="tr_bg_h">
		<th valign="top" class="col_head">
			Patient Name
		</th>

		<th valign="top" class="col_head">
			0-29 Days	
		</th>

    <th valign="top" class="col_head">
      30-59 Days
    </th>

    <th valign="top" class="col_head">
      60-89 Days
    </th>

    <th valign="top" class="col_head">
      90-119 Days
    </th>

    <th valign="top" class="col_head">
      120+
    </th>

    <th valign="top" class="col_head">
      Total
    </th>
	 </tr>
	</thead>	
	<tbody>
	 <?php
      $total_029 = $total_3059 = $total_6089 = $total_90119 = $total_120 = $grand_total = 0;

  		if ($total_rec)
      foreach($my as $r) {
        $c_total = $p_total = $pat_total = 0;
        
        $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysqli_real_escape_string($con,$r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
        
        $c_q = $db->getResults($c_sql);
        if (count($c_q)) foreach ($c_q as $c_r) {
          $c_total += $c_r['total_charge'];
          $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
      		          LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
      		          WHERE dl.primary_claim_id='".mysqli_real_escape_string($con,$c_r['insuranceid'])."'";
          
          $p_r = $db->getRow($p_sql);
          $p_total = $p_r['paid_amount'];
        }

        $pat_total+=$c_total - $p_total;
        $total_029+=$c_total - $p_total;
	 ?>
			<tr>
				<td valign="top">
          <a href="manage_ledger.php?pid=<?php echo  $r['patientid']; ?>&addtopat=1"><?php echo  $r['firstname']." ".$r['lastname'];?></a>
				</td>

				<td valign="top">
				  <?php if (($c_total-$p_total) != 0) { ?>
            <a href="manage_ledger.php?pid=<?php echo   $r['patientid']; ?>&addtopat=1">$<?php echo   number_format(($c_total - $p_total),2); ?></a>
				  <?php } else { ?>
            $<?php echo number_format(($c_total - $p_total),2); ?>
				  <?php } ?>
				</td>

        <?php
          $c_total = $p_total = 0;

          $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysqli_real_escape_string($con,$r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 30 DAY)";
          
          $c_q = $db->getResults($c_sql);
          $p_sql = '';

          if (count($c_q)) foreach ($c_q as $c_r) {
            $c_total += $c_r['total_charge'];
            
            $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
          	          LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
          	          WHERE dl.primary_claim_id='".mysqli_real_escape_string($con,$c_r['insuranceid'])."'";
            
            $p_r = $db->getRow($p_sql);
            $p_total = $p_r['paid_amount'];
          }

          $pat_total+=$c_total - $p_total;
          $total_3059+=$c_total - $p_total;
        ?>

  			<td valign="top">
          <?php if (($c_total-$p_total) != 0) { ?>
            <a href="manage_ledger.php?pid=<?php echo $r['patientid']; ?>&addtopat=1">$<?php echo number_format(($c_total - $p_total),2); ?></a>
          <?php }else{ ?>
            $<?php echo number_format(($c_total - $p_total),2); ?>
          <?php } ?>
  			</td>

        <?php
          $c_total = $p_total = 0;
          $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysqli_real_escape_string($con,$r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 60 DAY)";
          $c_q = $db->getResults($c_sql);
          $p_sql = '';

          if (count($c_q)) foreach ($c_q as $c_r) {
            $c_total += $c_r['total_charge'];
            
            $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                      LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                      WHERE dl.primary_claim_id='".mysqli_real_escape_string($con,$c_r['insuranceid'])."'";
            
            $p_r = $db->getRow($p_sql);
            $p_total = $p_r['paid_amount'];
          }

          $pat_total+=$c_total - $p_total;
          $total_6089+=$c_total - $p_total;
        ?>

        <td valign="top">
          <?php if (($c_total-$p_total) != 0) { ?>
            <a href="manage_ledger.php?pid=<?php echo $r['patientid']; ?>&addtopat=1">$<?php echo number_format(($c_total - $p_total),2); ?></a>
          <?php } else { ?>
            $<?php echo number_format(($c_total - $p_total),2); ?>
          <?php } ?>
        </td>

        <?php
          $c_total = $p_total = 0;
          $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysqli_real_escape_string($con,$r['patientid'])."' AND mailed_date > DATE_SUB(CURDATE(), INTERVAL 120 DAY) AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 90 DAY)";
          
          $c_q = $db->getResults($c_sql);
          $p_sql = '';

          if (count($c_q)) foreach ($c_q as $c_r) {
            $c_total += $c_r['total_charge'];
            
            $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                      LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                      WHERE dl.primary_claim_id='".mysqli_real_escape_string($con,$c_r['insuranceid'])."'";
            
            $p_r = $db->getRow($p_sql);
            $p_total = $p_r['paid_amount'];
          }

          $pat_total += $c_total - $p_total;
          $total_90119 += $c_total - $p_total;
        ?>
        
        <td valign="top">
          <?php if (($c_total-$p_total) != 0) { ?>
            <a href="manage_ledger.php?pid=<?php echo   $r['patientid']; ?>&addtopat=1">$<?php echo number_format(($c_total - $p_total),2); ?></a>
          <?php } else { ?>
            $<?php echo number_format(($c_total - $p_total),2); ?>
          <?php } ?>
        </td>

        <?php
          $c_total = $p_total = 0;
          $c_sql = "SELECT COALESCE(CONVERT(REPLACE(total_charge,',',''),DECIMAL(11,2)),0) as total_charge, insuranceid FROM dental_insurance WHERE patientid='".mysqli_real_escape_string($con,$r['patientid'])."' AND mailed_date <= DATE_SUB(CURDATE(), INTERVAL 120 DAY)";
          
          $c_q = $db->getResults($c_sql);
          $p_sql = '';

          foreach ($c_q as $c_r) {
            $c_total += $c_r['total_charge'];
            
            $p_sql = "SELECT sum(dlp.amount) paid_amount FROM dental_ledger dl
                      LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid=dl.ledgerid
                      WHERE dl.primary_claim_id='".mysqli_real_escape_string($con,$c_r['insuranceid'])."'";
            
            $p_r = $db->getRow($p_sql);
            $p_total = $p_r['paid_amount'];
          }

          $pat_total += $c_total - $p_total;
          $total_120 += $c_total - $p_total;
        ?>
        
        <td valign="top">
          <?php if (($c_total-$p_total) != 0) { ?>
            <a href="manage_ledger.php?pid=<?php echo   $r['patientid']; ?>&addtopat=1">$<?php echo number_format(($c_total - $p_total),2); ?></a>
          <?php } else { ?>
            $<?php echo number_format(($c_total - $p_total),2); ?>
          <?php } ?>

        </td>

        <td valign="top">
					<?php $grand_total+=$pat_total; ?>
          $<?php echo   number_format($pat_total,2); ?>
        </td>
			</tr>
	 <?php } ?> 
	</tbody>
  
  <tfoot>
		<tr>
			<td valign="top">
				<b>Totals</b>
			</td>

			<td valign="top">
			  <strong><?php echo "$".number_format($total_029,2); ?></strong>
			</td>

      <td valign="top">
        <strong><?php echo "$".number_format($total_3059,2); ?></strong>
      </td>
      
      <td valign="top">
        <strong><?php echo "$".number_format($total_6089,2); ?></strong>
      </td>
      
      <td valign="top">
        <strong><?php echo "$".number_format($total_90119,2); ?></strong>
      </td>
      
      <td valign="top">
        <strong><?php echo "$".number_format($total_120,2); ?></strong>
      </td>
      
      <td valign="top">
        <strong><?php echo "$".number_format($grand_total,2); ?></strong>
      </td>
    </tr>
	</tfoot>
</table>

<?php include 'report_claim_aging_breakdown.php'; ?>

<div id="popupContact" style="width:750px;">
	  <a id="popupContactClose"><button>X</button></a>

    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>

<div id="backgroundPopup"></div>

<br /><br />	

<?php include "includes/bottom.htm";?>
