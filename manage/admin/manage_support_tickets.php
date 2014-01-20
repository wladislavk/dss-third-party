<? 
include "includes/top.htm";
include_once "../includes/constants.inc";
if(isset($_GET['rid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=0 WHERE id='".mysql_real_escape_string($_GET['rid'])."' AND create_type=1 ";
  mysql_query($u_sql);
  $u_sql = "UPDATE dental_support_responses SET viewed=0 WHERE ticket_id='".mysql_real_escape_string($_GET['rid'])."' AND response_type=1 ";
  mysql_query($u_sql);
}
$sql = "select t.*,
	CONCAT(u.first_name,' ',u.last_name) as user,
	CONCAT(a.first_name,' ',a.last_name) as account,
	c.name as company,
	cat.title as category,
	(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=1 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed,
        (SELECT r3.attachment FROM dental_support_responses r3 WHERE r3.ticket_id=t.id ORDER BY r3.attachment DESC LIMIT 1) AS response_attachment,
	(SELECT a.filename FROM dental_support_attachment a WHERE a.ticket_id=t.id LIMIT 1) AS ticket_attachment,
	response.last_response
	 FROM dental_support_tickets t
		LEFT JOIN dental_users u ON u.userid=t.userid
		LEFT JOIN dental_users a ON a.userid=t.docid
                LEFT JOIN dental_user_company uc ON uc.userid=t.docid
                LEFT JOIN companies c ON c.id=uc.companyid
		LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
		LEFT JOIN (SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id ) response ON response.ticket_id=t.id
   	WHERE t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.") ";
if(is_billing($_SESSION['admin_access'])){
    $c_sql = "SELECT companyid FROM admin_company where adminid='".$_SESSION['adminuserid']."'";
    $c_q = mysql_query($c_sql);
    $c = mysql_fetch_assoc($c_q);
  $sql .= " AND u.billing_company_id='".$c['companyid']."' ";
}
if(isset($_REQUEST['catid'])){
  $sql .= " AND t.category_id = ".mysql_real_escape_string($_REQUEST['catid']);
}
$sql .= " order by COALESCE(response.last_response, t.adddate) DESC";
$my = mysql_query($sql) or die(mysql_error());
$total_rec = mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />
<span class="admin_head">
	Manage Support Tickets
</span>
<br />
<br />
<div align="right">
<button onclick="loadPopup('add_ticket.php'); return false;" class="addButton">Add Ticket</button>
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<thead>
	<tr class="tr_bg_h">
		<th valign="top" class="col_head" width="25%">
			Title
		</th>
                <th valign="top" class="col_head" width="10%">
                        User
                </th>
                <th valign="top" class="col_head" width="10%">
                        Account
                </th>
                <th valign="top" class="col_head" width="10%">
                        Company
                </th>
                <th valign="top" class="col_head" width="10%">
                        Category
                </th>
                <th valign="top" class="col_head" width="10%">
                        Date
                </th>
                <th valign="top" class="col_head" width="10%">
                        Status
                </th>
		<th valign="top" class="col_head" width="15%">
		Action
		</td>
	</tr>
	</thead>
	<tbody>
<? if(mysql_num_rows($my) == 0)
{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
		No Records
		</td>
		</tr>
		<? 
}
else
{
	while($myarray = mysql_fetch_array($my))
	{
  if($myarray['create_type']=="1" && $myarray['viewed']=="1"){
    $ticket_read = true;
  }else{
    $ticket_read = false;
  }
		$latest = ($myarray['last_response']!='')?$myarray['last_response']:$myarray['adddate'];
		?>
			<tr class="<?= (($myarray["viewed"]=='0' && $myarray["create_type"]=="1") || $myarray["response_viewed"]=='0')?"unviewed":""; ?>">
			<td valign="top">
			<?=st($myarray["title"]);?>
			</td>
			<td valign="top">
			<?= st($myarray["user"]); ?>
			</td>	
                        <td valign="top">
                        <?= st($myarray["account"]); ?>
                        </td>	
			<td valign="top">
			<?= $myarray["company"];?>
			</td>
			<td valign="top">
		 		<?= $myarray['category']; ?>	
			</td>
			<td valign="top">
				<?= date('m/d/Y h:i:s a', strtotime($latest)); ?>
			</td>
			<td valign="top">
				<?= $dss_ticket_status_labels[$myarray['status']]; ?>	
			</td>
			<td valign="top">
			<a href="view_support_ticket.php?ed=<?=$myarray["id"];?>" class="editlink" title="EDIT">
			View
			</a>
			<?php if($myarray['attachment']!='' || $myarray['response_attachment'] !='' || $myarray['ticket_attachment'] !=''){ ?>
					<span class="attachment"></span>
					<?php } ?> 
        <?php if(($ticket_read && $myarray["response_viewed"]!='0') || $myarray['response_viewed'] == '1' ){ ?>
						| <a href="?rid=<?= $myarray['id']; ?>">Mark Unread</a>
							<?php } ?>
							</td>
							</tr>
							<? 	}
}?>
</tbody>
</table>

<?php
$sql = "select t.*,
        CONCAT(u.first_name, ' ', u.last_name) as user,
	CONCAT(a.first_name, ' ', a.last_name) as account,
        c.name as company,
        cat.title as category,
        (SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=1 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed,
        (SELECT r2.adddate FROM dental_support_responses r2 WHERE r2.ticket_id=t.id ORDER BY r2.adddate DESC LIMIT 1) AS last_response,
        (SELECT r3.attachment FROM dental_support_responses r3 WHERE r3.ticket_id=t.id ORDER BY r3.attachment DESC LIMIT 1) AS response_attachment
         FROM dental_support_tickets t
                LEFT JOIN dental_users u ON u.userid=t.userid
                LEFT JOIN dental_users a ON a.userid=t.docid
		LEFT JOIN dental_user_company uc ON uc.userid=t.docid
                LEFT JOIN companies c ON c.id=uc.companyid
                LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
WHERE t.status IN (".DSS_TICKET_STATUS_CLOSED.") ";
if(isset($_REQUEST['catid'])){
	$sql .= " AND category_id = ".mysql_real_escape_string($_REQUEST['catid']);
}
$sql .= " order by adddate DESC";
$my = mysql_query($sql) or die(mysql_error());
$total_rec = mysql_num_rows($my);

?>
<span class="admin_head">
Resolved
</span>
<table class="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<thead>
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="25%">
                        Title
                </td>
                <td valign="top" class="col_head" width="10%">
                        User
                </td>
                <td valign="top" class="col_head" width="10%">
                        Company
                </td>
                <td valign="top" class="col_head" width="10%">
                        Category
                </td>
                <td valign="top" class="col_head" width="10%">
                        Date
                </td>
                <td valign="top" class="col_head" width="10%">
                        Status
                </td>
                <td valign="top" class="col_head" width="15%">
                Action
                </td>
        </tr>
	</thead>
	<tbody>
<? if(mysql_num_rows($my) == 0)
{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
		No Records
		</td>
		</tr>
		<?
}
else
{
        while($myarray = mysql_fetch_array($my))
        {
                $latest = ($myarray['last_response']!='')?$myarray['last_response']:$myarray['adddate'];
                ?>
                        <tr class="<?= (($myarray["viewed"]=='0' && $myarray["create_type"]=="1") || $myarray["response_viewed"]=='0')?"unviewed":""; ?>">
                        <td valign="top">
                        <?=st($myarray["title"]);?>
                        </td>
                        <td valign="top">
                        <?= st($myarray["user"]); ?>
                        </td>
                        <td valign="top">
                        <?= st($myarray["account"]); ?>
                        </td>
                        <td valign="top">
                        <?= $myarray["company"];?>
                        </td>
                        <td valign="top">
                                <?= $myarray['category']; ?>
                        </td>
                        <td valign="top">
                                <?= date('m/d/Y h:i:s a', strtotime($latest)); ?>
                        </td>
                        <td valign="top">
                                <?= $dss_ticket_status_labels[$myarray['status']]; ?> 
                        </td>
                        <td valign="top">
                        <a href="view_support_ticket.php?ed=<?=$myarray["id"];?>" class="editlink" title="EDIT">
                        View
                        </a>
                        <?php if($myarray['attachment']!='' || $myarray['response_attachment']!=''){ ?>
                                <span class="attachment"></span>
                                        <?php } ?>
                                        <?php if($myarray["viewed"]!='0' && $myarray["response_viewed"]!='0'){ ?>
                                                | <a href="?rid=<?= $myarray['id']; ?>">Mark Unread</a>
                                                        <?php } ?>
                                                        </td>
                                                        </tr>
                                                        <?      }

}?>
	</tbody>
</table>






<div id="popupContact">
<a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
