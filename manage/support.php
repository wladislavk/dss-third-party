<? 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_GET['rid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=0 WHERE id='".mysql_real_escape_string($_GET['rid'])."' AND create_type=0 ";
  mysql_query($u_sql);
  $u_sql = "UPDATE dental_support_responses SET viewed=0 WHERE ticket_id='".mysql_real_escape_string($_GET['rid'])."' AND response_type=0 ";
  mysql_query($u_sql);
}
?>
<link rel="stylesheet" type="text/css" href="admin/css/support.css" />
<?php
$t_sql = "SELECT t.*,
		(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed,
		(SELECT r2.attachment FROM dental_support_responses r2 WHERE r2.ticket_id=t.id ORDER BY r2.attachment DESC LIMIT 1) AS response_attachment
		 FROM dental_support_tickets t
		WHERE t.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND
		(t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.") OR
		  (t.status IN (".DSS_TICKET_STATUS_CLOSED.") AND ( 
			(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1)=0)
			OR
			(t.create_type=0 AND t.viewed=0)
			)
		)
		ORDER BY t.adddate DESC";
$t_q = mysql_query($t_sql);
?>

        <button style="margin-right:10px; float:right;" onclick="loadPopup('add_ticket.php')" class="addButton">
                Add New Ticket
        </button>
<br />
<span class="admin_head">Open Tickets</span>
<table width="98%" cellpadding="5" cellspacing="1" align="center">
  <tr class="tr_bg_h">
    <td class="col_head">Title</td>
    <td class="col_head">Body</td>
    <td class="col_head">Status</td>
    <td class="col_head">Action</td>
  </tr>
<?php

while($r = mysql_fetch_assoc($t_q)){
  if($r['create_type']=="0" && $r['viewed']=="1"){
    $ticket_read = true;
  }else{
    $ticket_read = false;
  }
?>
  <tr class="<?= (($r["viewed"]=='0' && $r["create_type"]=="0") || $r["response_viewed"]=='0')?"unviewed":""; ?>"> 
    <td><?= $r['title']; ?></td>
    <td><?= substr($r['body'], 0, 50); ?></td>
    <td><?= $dss_ticket_status_labels[$r['status']]; ?></td>
    <td><a href="view_support_ticket.php?ed=<?= $r['id']; ?>">View</a>
	<?php if($r['attachment']!='' || $r['response_attachment']!=''){ ?>
		<span class="attachment"></span>	
	<?php } ?>
	<?php if(($ticket_read && $r["response_viewed"]!='0') || $r['response_viewed'] == '1' ){ ?>
	  | <a href="?rid=<?= $r['id']; ?>">Mark Unread</a>
	<?php } ?>
	</td>
  </tr>

<?php
}
?>
</table>

<?php

$t_sql = "SELECT t.* FROM dental_support_tickets t
                WHERE t.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND
                t.status IN (".DSS_TICKET_STATUS_CLOSED.") AND
		((SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1)=1 OR
			(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1) IS NULL)
                ORDER BY t.adddate DESC";
$t_q = mysql_query($t_sql);

?>
<br />
<span class="admin_head">Closed Tickets</span>
<table width="98%" cellpadding="5" cellspacing="1" align="center">
  <tr class="tr_bg_h">
    <td class="col_head">Title</td>
    <td class="col_head">Body</td>
    <td class="col_head">Status</td>
    <td class="col_head">Action</td>
  </tr>
<?php

while($r = mysql_fetch_assoc($t_q)){
?>
  <tr> 
    <td><?= $r['title']; ?></td>
    <td><?= substr($r['body'], 0, 50); ?></td>
    <td><?= $dss_ticket_status_labels[$r['status']]; ?></td>
    <td><a href="view_support_ticket.php?ed=<?= $r['id']; ?>">View</a></td>
  </tr>

<?php
}
?>
</table>

<?php
include_once "includes/bottom.htm";
?>

