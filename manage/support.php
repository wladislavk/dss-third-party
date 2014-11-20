<?php 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_GET['rid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=0 WHERE id='".mysqli_real_escape_string($con,$_GET['rid'])."' AND create_type=0 ";
  $db->query($u_sql);
  $u_sql = "UPDATE dental_support_responses SET viewed=0 WHERE ticket_id='".mysqli_real_escape_string($con,$_GET['rid'])."' AND response_type=0 ";
  $db->query($u_sql);
}
if(isset($_GET['urid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=1 WHERE id='".mysqli_real_escape_string($con,$_GET['urid'])."' AND create_type=0 ";
  $db->query($u_sql);
  $u_sql = "UPDATE dental_support_responses SET viewed=1 WHERE ticket_id='".mysqli_real_escape_string($con,$_GET['urid'])."' AND response_type=0 ";
  $db->query($u_sql);
}
?>
<link rel="stylesheet" type="text/css" href="admin/css/support.css" />
<?php
$t_sql = "SELECT t.*,
          (SELECT name FROM companies WHERE companies.id=t.company_id LIMIT 1) as company_name,
      		(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed,
      		(SELECT r2.attachment FROM dental_support_responses r2 WHERE r2.ticket_id=t.id ORDER BY r2.attachment DESC LIMIT 1) AS response_attachment,
      		(SELECT a.filename FROM dental_support_attachment a WHERE a.ticket_id=t.id LIMIT 1) as ticket_attachment,
      		response.last_response
      		 FROM dental_support_tickets t
                      LEFT JOIN (SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id ) response ON response.ticket_id=t.id
      		WHERE t.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
      		(t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.") OR
      		  (t.status IN (".DSS_TICKET_STATUS_CLOSED.") AND ( 
      			(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1)=0)
      			OR
      			(t.create_type=0 AND t.viewed=0)
      			)
      		)
      		ORDER BY t.adddate DESC";

$t_q = $db->getResults($t_sql);
?>

<button style="margin-right:10px; float:right;" onclick="loadPopup('add_ticket.php')" class="addButton">
  Add New Ticket
</button>
<br />
<span class="admin_head">Open Tickets</span>
<!-- pager -->
<div id="pager" class="pager">
	<form>
		<img src="images/first.png" class="first">
		<img src="images/prev.png" class="prev">
		<input class="pagedisplay" style="width:75px;" type="text">
		<img src="images/next.png" class="next">
		<img src="images/last.png" class="last">
	</form>
</div>
<table id="sort_table" width="98%" cellpadding="5" cellspacing="1" align="center">
  <thead>
  <tr class="tr_bg_h">
    <th class="col_head" width="23%">Title</th>
    <th class="col_head" width="33%">Body</th>
    <th class="col_head" width="14%">Company</th>
    <th class="col_head" width="9%">Date</th>
    <th class="col_head" width="8%">Status</th>
    <th class="col_head" width="13%">Action</th>
  </tr>
  </thead>
  <tbody>
<?php

if ($t_q) {
  foreach ($t_q as $r) {
    if($r['create_type']=="0" && $r['viewed']=="1"){
      $ticket_read = true;
    }else{
      $ticket_read = false;
    }
    $latest = ($r['last_response']!='')?$r['last_response']:$r['adddate'];?>
    <tr class="<?php echo (($r["viewed"]=='0' && $r["create_type"]=="0") || $r["response_viewed"]=='0')?"unviewed":""; ?>"> 
      <td><?php echo $r['title']; ?></td>
      <td><?php echo substr($r['body'], 0, 50); ?></td>
<?php 
    if ($r['company_name'] != ''){ ?>
      <td><?php echo $r['company_name']?></td>
<?php 
    }else{ ?>
      <td>Dental Sleep Solutions</td>
<?php 
    } ?>
      <td><?php echo date('m/d/Y', strtotime($latest)); ?></td>
      <td><?php echo $dss_ticket_status_labels[$r['status']]; ?></td>
      <td><a href="view_support_ticket.php?ed=<?php echo $r['id']; ?>">View</a>
<?php 
    if($r['attachment']!='' || $r['response_attachment']!='' || $r['ticket_attachment'] !=''){ ?>
    		<span class="attachment"></span>	
<?php 
  }
    if(($ticket_read && $r["response_viewed"]!='0') || $r['response_viewed'] == '1' ){ ?>
    	  | <a href="?rid=<?php echo $r['id']; ?>">Mark Unread</a>
<?php 
  } 
    //ticket type is 0 and not viewed || response_type =0 and is not viewed
    if(($r['create_type']=="0" && $r['viewed'] != "1") || $r['response_viewed'] == "0"){?>
	      | <a href="?urid=<?php echo $r['id']; ?>">Mark Read</a>
<?php
    }?>
    	</td>
    </tr>

  <?php
  }
}?>
  </tbody>
</table>

<?php

$t_sql = "SELECT t.*, 
            (SELECT name FROM companies WHERE companies.id=t.company_id LIMIT 1) as company_name FROM dental_support_tickets t
        		LEFT JOIN (SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id ) response ON response.ticket_id=t.id
                        WHERE t.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
                        t.status IN (".DSS_TICKET_STATUS_CLOSED.") AND
        		((SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1)=1 OR
        			(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=0 ORDER BY r.viewed ASC LIMIT 1) IS NULL)
                        ORDER BY t.adddate DESC";
$t_q = $db->getResults($t_sql);?>

<br />
<span class="admin_head">Closed Tickets</span>
<div id="pager2" class="pager">
  <form>
    <img src="images/first.png" class="first">
    <img src="images/prev.png" class="prev">
    <input class="pagedisplay" style="width:75px;" type="text">
    <img src="images/next.png" class="next">
    <img src="images/last.png" class="last">
  </form>
</div>

<table id="sort_table2" width="98%" cellpadding="5" cellspacing="1" align="center">
  <thead>
    <tr class="tr_bg_h">
      <th class="col_head" width="23%">Title</th>
      <th class="col_head" width="33%">Body</th>
      <th class="col_head" width="14%">Company</th>
      <th class="col_head" width="9%">Date</th>
      <th class="col_head" width="8%">Status</th>
      <th class="col_head" width="13%">Action</th>
    </tr>
  </thead>
  <tbody>
<?php
if ($t_q) {
  foreach ($t_q as $r) {
    $latest = ($r['last_response']!='')?$r['last_response']:$r['adddate'];?>
    <tr> 
      <td><?php echo $r['title']; ?></td>
      <td><?php echo substr($r['body'], 0, 50); ?></td>
<?php 
    if ($r['company_name'] != ''){ ?>
      <td><?php echo $r['company_name']?></td>
<?php 
    }else{ ?>
      <td>Dental Sleep Solutions</td>
<?php 
    } ?>
      <td><?php echo date('m/d/Y', strtotime($latest)); ?></td>
      <td><?php echo $dss_ticket_status_labels[$r['status']]; ?></td>
      <td><a href="view_support_ticket.php?ed=<?php echo $r['id']; ?>">View</a></td>
    </tr>
<?php
  }
}?>
  </tbody>
</table>

<?php
include_once "includes/bottom.htm";
?>