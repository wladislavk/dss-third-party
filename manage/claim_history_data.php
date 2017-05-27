<?php
namespace Ds3\Libraries\Legacy;

$claimId = isset($claimId) ? $claimId : intval($_GET['cid']);

$sql = "SELECT *
    FROM dental_claim_electronic
    WHERE claimid = '$claimId'
    ORDER BY adddate DESC";
$my = $db->getResults($sql);
$total_rec = count($my);

$csql = "SELECT *
    FROM dental_insurance
    WHERE insuranceid = '$claimId'";
$claim = $db->getRow($csql);

$claimHistory = $db->getResults("SELECT history.*,
        user.userid, user.first_name AS user_first, user.last_name AS user_last,
        admin.adminid, admin.first_name AS admin_first, admin.last_name AS admin_last
    FROM dental_insurance_history history
        LEFT JOIN dental_users user ON user.userid = history.updated_by_user
        LEFT JOIN admin ON admin.adminid = history.updated_by_admin
    WHERE insuranceid = '$claimId'
    ORDER BY id DESC");

?>
<link rel="stylesheet" href="css/ledger.css" />
<style type="text/css">
    pre { max-height: 350px; }

    table.fullwidth td, table.fullwidth th {
        padding: 5px;
    }

    table.fullwidth td {
        border-top: 1px solid #c6c6c6;
    }

    table.fullwidth tr.expand td {
        border-top: none;
    }
</style>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<script>
jQuery(function($){
    $('a.expand').click(function(){
        var $container = $(this).closest('tr').next('tr.expand'),
            $pre = $container.find('pre:not(.hljs)');

        if ($pre.length) {
            $pre.each(function(i, block) {
                hljs.highlightBlock(block);
            });
        }

        $container.toggle();
        return false;
    });
});
</script>
<?php if (empty($is_back_office)) { ?>
    <span class="admin_head">
        Claim History
    </span>
    <br />
<?php } else { ?>
    <h2>Claim History</h2>
<?php } ?>
<?php if ($my) foreach ($my as $r) { ?>
  <div style="margin-left:20px; border:solid 1px #99c; width:80%; margin-top:20px; padding:0 20px;">
    <?php
		  if($r['reference_id']!='') {
        $w_sql = "SELECT * FROM dental_eligible_response WHERE reference_id = '" . $db->escape($r['reference_id']) . "' ORDER BY adddate DESC";
        $w_q = $db->getResults($w_sql);

        /**
         * Some Eligible responses are not status notifications, we need to filter out the ones that are not useful
         */
        foreach ($w_q as $w_r) {
            $p = json_decode($w_r['response']);

            if (!isset($p->details)) {
                continue;
            }

            $eventType = ucwords(str_replace('_', ' ', $w_r['event_type']));

            ?>
          <h3>
              <?php if (empty($is_back_office) && $eventType === 'Payment Report') { ?>
                  <a href="/manage/payment_reports_list.php"><?= e($eventType) ?></a>
              <?php } else { ?>
                  <?= e($eventType) ?>
              <?php } ?>
              on <?= $w_r['adddate'] ?>
          </h3>
          <p>
              <strong>Reference ID:</strong> <?= strlen($w_r['reference_id']) ? e($w_r['reference_id']) : '<i>Not set</i>' ?>
          </p>

          <?php if ($w_r['event_type'] !== 'claim_created') { ?>
            <p>
              Category:
                <?= $p->details->codes->category_code ?>
                -
                <?= $p->details->codes->category_label ?>
                <br />
              Status:
                <?= $p->details->codes->status_code ?>
                -
                <?= $p->details->codes->status_label ?>
            </p>
          <?php } ?>
    <?php
        }
		  }
    ?>

		<h3>Claim Electronically filed on <?php echo  $r['adddate']; ?></h3>
      <p>
          <strong>Reference ID:</strong> <?= strlen($r['reference_id']) ? e($r['reference_id']) : '<i>Not set</i>' ?>
      </p>
		<?php
 			$d = json_decode($r['response']);
      if (!empty($d)) {
        $success = $d->{"success"}; 
      } else {
        $success = '';
      }
			
			if ($success == "true"){
		?>
        <p><strong>Success Response</strong><br />
    <?php
			} else {
    ?>
        <p><strong>Error Response:</strong><br />
          <?php
              if (!empty($d->{"errors"})) {
                $errors = $d->{"errors"};
              } else {
                $errors = array();
              }
              
              foreach($errors as $error){
                echo $error->{"message"}."<br />";
              }
      			}
      		?>
		    </p>
	</div>
<?php
  }
?>
<?php if (empty($is_back_office)) { ?>
    <span class="admin_head">
        Claim Version History
    </span>
<?php } else { ?>
    <h2>Claim Version History</h2>
<?php } ?>
<table class="fullwidth table" cellpadding="0" cellspacing="0">
    <colgroup>
        <col width="12%">
        <col width="12%">
        <col width="28%">
        <col width="28%">
        <col width="20%">
    </colgroup>
    <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th colspan="2">Modified by</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($claimHistory as $r) {
        $deleted = $r['docid'] < 0 && $r['patientid'] < 0;
        ?>
        <tr>
            <td>
                <?= date('m/d/Y h:i', strtotime($r['updated_at'])) ?>
            </td>
            <td>
                <?= $deleted ? 'Deleted' : $dss_claim_status_labels[$r['status']] ?>
            </td>
            <td>
                FO: <?= $r['userid'] ? e($r['user_first'] . ' ' . $r['user_last']) : 'none' ?>
            </td>
            <td>
                BO: <?= $r['adminid'] ? e($r['admin_first'] . ' ' . $r['admin_last']) : 'none' ?>
            </td>
            <td>
                <?php if (!$deleted) { ?>
                    <a class="button expand btn btn-xs btn-success" href="#">Raw data</a>
                    <a class="button btn-xs btn btn-primary"
                        href="claim_history_versions_view.php?insid=<?= $r['insuranceid'] ?>&amp;pid=<?= $r['patientid'] ?>&amp;history_id=<?= $r['id'] ?>&amp;view=paper">
                        Paper</a>
                    <a class="button btn btn-xs btn-primary"
                        href="claim_history_versions_view.php?insid=<?= $r['insuranceid'] ?>&amp;pid=<?= $r['patientid'] ?>&amp;history_id=<?= $r['id'] ?>&amp;view=efile">
                        E-File</a>
                <?php } ?>
            </td>
        </tr>
        <tr class="expand" style="display:none">
            <td colspan="5">
                <?php if (!$deleted) { ?>
                    <pre class="yaml"><?php foreach ($r as $key=>$value) { echo e("$key: $value") . '<br>'; } ?></pre>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<p>&nbsp;</p>
