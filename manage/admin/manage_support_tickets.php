<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
include_once "../includes/constants.inc";

    if(!is_super($_SESSION['admin_access']) && !is_software($_SESSION['admin_access']) && !is_billing($_SESSION['admin_access'])){
?>
        <h2>You are not authorized to view this page.</h2>
<?php
        trigger_error("Die called", E_USER_ERROR);
    }

if(isset($_GET['rid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=0 WHERE id='".mysqli_real_escape_string($con,$_GET['rid'])."' AND create_type=1 ";
  mysqli_query($con,$u_sql);
  $u_sql = "UPDATE dental_support_responses SET viewed=0 WHERE ticket_id='".mysqli_real_escape_string($con,$_GET['rid'])."' AND response_type=1 ";
  mysqli_query($con,$u_sql);
}
?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<!--link rel="stylesheet" href="css/support.css" type="text/css" /-->
<?php

if(!isset($_GET['all'])){

$sql = "select t.*,
	CONCAT(u.first_name,' ',u.last_name) as user,
	CONCAT(a.first_name,' ',a.last_name) as account,
	c.name as company,
	t.company_id,
 	c2.name as ticket_company,
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
                LEFT JOIN companies c2 ON c2.id=t.company_id
		LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
		LEFT JOIN (SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id ) response ON response.ticket_id=t.id
   	WHERE t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.") ";

if (!is_super($_SESSION['admin_access'])) {
    $sql .= " AND t.company_id = '" . intval($_SESSION['admincompanyid']) . "' ";
}

if(isset($_REQUEST['catid'])){
  $sql .= " AND t.category_id = ".mysqli_real_escape_string($con,$_REQUEST['catid']);
}
$sql .= " order by COALESCE(response.last_response, t.adddate) DESC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

?>

<div class="page-header">
	Manage Support Tickets
</div>
<div class="page-header">
Open Tickets
</div>
<a href="manage_support_tickets.php?all" class="btn btn-success pull-right" style="margin-left:5px">
    View Closed Tickets
    <span class="glyphicon glyphicon-plus"></span>
</a>
<button onclick="loadPopup('add_ticket.php'); return false;" class="btn btn-success pull-right">
    Add Ticket
    <span class="glyphicon glyphicon-plus"></span>
</button>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
<?php if(mysqli_num_rows($my) == 0)
{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
		No Records
		</td>
		</tr>
		<?php 
}
else
{
	while($myarray = mysqli_fetch_array($my))
	{
  if($myarray['create_type']=="1" && $myarray['viewed']=="1"){
    $ticket_read = true;
  }else{
    $ticket_read = false;
  }
		$latest = ($myarray['last_response']!='')?$myarray['last_response']:$myarray['adddate'];
		?>
			<tr class="<?php echo   (is_admin($_SESSION['admin_access']) && $myarray['company_id']!=0)?'low ':''; ?><?php echo  (($myarray["viewed"]=='0' && $myarray["create_type"]=="1") || $myarray["response_viewed"]=='0')?"info":""; ?>">
			<td valign="top">
			<?php echo st($myarray["title"]);?>
            <?php if($myarray['attachment']!='' || $myarray['response_attachment'] !='' || $myarray['ticket_attachment'] !=''){ ?>
                    <span class="attachment badge glyphicon glyphicon-paperclip pull-right" title="This ticket contains attachments"> <!-- space needed --></span>
                    <?php } ?>
			</td>
			<td valign="top">
			<?php echo  st($myarray["user"]); ?>
			</td>	
                        <td valign="top">
                        <?php echo  st($myarray["account"]); ?>
                        </td>	
			<td valign="top">
			<?php if($myarray["company_id"]==0){ ?>
				Dental Sleep Solutions
			<?php }else{ ?>
			<?php echo  $myarray["ticket_company"];?>
			<?php } ?>
			</td>
			<td valign="top">
		 		<?php echo  $myarray['category']; ?>	
			</td>
			<td valign="top">
				<?php echo  date('m/d/Y h:i:s a', strtotime($latest)); ?>
			</td>
			<td valign="top">
				<?php echo  $dss_ticket_status_labels[$myarray['status']]; ?>	
			</td>
			<td valign="top">
			<a href="view_support_ticket.php?ed=<?php echo $myarray["id"];?>" title="View Ticket" class="btn btn-primary btn-sm">
			View
			 <span class="glyphicon glyphicon-pencil"></span></a>
        <?php if(($ticket_read && $myarray["response_viewed"]!='0') || $myarray['response_viewed'] == '1' ){ ?>
						<a href="?rid=<?php echo  $myarray['id']; ?>" class="btn btn-default btn-sm">
                            Mark Unread
                            <span class="glyphicon glyphicon-eye-close"></span>
                        </a>
							<?php } ?>
							</td>
							</tr>
							<?php 	}
}?>
</tbody>
</table>

<a href="manage_support_tickets.php?all" class="btn btn-success pull-right" style="margin-left:5px">
    View Closed Tickets 
    <span class="glyphicon glyphicon-plus"></span>
</a>

<?php

}else{ //isset($_GET['all'])

$sql = "select t.*,
        CONCAT(u.first_name, ' ', u.last_name) as user,
	CONCAT(a.first_name, ' ', a.last_name) as account,
        c.name as company,
	t.company_id,
	c2.name as ticket_company,
        cat.title as category,
        (SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=1 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed,
        (SELECT r2.adddate FROM dental_support_responses r2 WHERE r2.ticket_id=t.id ORDER BY r2.adddate DESC LIMIT 1) AS last_response,
        (SELECT r3.attachment FROM dental_support_responses r3 WHERE r3.ticket_id=t.id ORDER BY r3.attachment DESC LIMIT 1) AS response_attachment
         FROM dental_support_tickets t
                LEFT JOIN dental_users u ON u.userid=t.userid
                LEFT JOIN dental_users a ON a.userid=t.docid
		LEFT JOIN dental_user_company uc ON uc.userid=t.docid
                LEFT JOIN companies c ON c.id=uc.companyid
                LEFT JOIN companies c2 ON c2.id=t.company_id
                LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
WHERE t.status IN (".DSS_TICKET_STATUS_CLOSED.") ";
if(is_billing($_SESSION['admin_access'])){
    $c_sql = "SELECT companyid FROM admin_company where adminid='".$_SESSION['adminuserid']."'";
    $c_q = mysqli_query($con,$c_sql);
    $c = mysqli_fetch_assoc($c_q);
  $sql .= " AND t.company_id='".$c['companyid']."' ";
}
if(isset($_REQUEST['catid'])){
	$sql .= " AND category_id = ".mysqli_real_escape_string($con,$_REQUEST['catid']);
}
$sql .= " order by adddate DESC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

?>
<div class="page-header">
Resolved
</div>
<a href="manage_support_tickets.php" class="btn btn-success pull-right" style="margin-left:5px">
    View Open Tickets
    <span class="glyphicon glyphicon-plus"></span>
</a>

<table class="sort_table table table-bordered table-hover">
	<thead>
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="25%">
                        Title
                </td>
                <td valign="top" class="col_head" width="10%">
                        User
                </td>
                <td valign="top" class="col_head" width="10%">
                        Account
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
<?php if(mysqli_num_rows($my) == 0)
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
        while($myarray = mysqli_fetch_array($my))
        {
                $latest = ($myarray['last_response']!='')?$myarray['last_response']:$myarray['adddate'];
                ?>
                        <tr class="<?php echo  (($myarray["viewed"]=='0' && $myarray["create_type"]=="1") || $myarray["response_viewed"]=='0')?"unviewed":""; ?>">
                        <td valign="top">
                        <?php echo st($myarray["title"]);?>
                        <?php if(!empty($myarray['attachment']) || !empty($myarray['response_attachment']) || !empty($myarray['ticket_attachment'])){ ?>
                        <span class="attachment badge glyphicon glyphicon-paperclip pull-right" title="This ticket contains attachments"> <!-- space needed --></span>
                        <?php } ?>
                        </td>
                        <td valign="top">
                        <?php echo  st($myarray["user"]); ?>
                        </td>
                        <td valign="top">
                        <?php echo  st($myarray["account"]); ?>
                        </td>
                        <td valign="top">
                        <?php if($myarray["company_id"]==0){ ?>
                                Dental Sleep Solutions
                        <?php }else{ ?>
                        <?php echo  $myarray["ticket_company"];?>
                        <?php } ?>
                        </td>
                        <td valign="top">
                                <?php echo  $myarray['category']; ?>
                        </td>
                        <td valign="top">
                                <?php echo  date('m/d/Y h:i:s a', strtotime($latest)); ?>
                        </td>
                        <td valign="top">
                                <?php echo  $dss_ticket_status_labels[$myarray['status']]; ?> 
                        </td>
                        <td valign="top">
                        <a href="view_support_ticket.php?ed=<?php echo $myarray["id"];?>" title="Edit" class="btn btn-primary btn-sm">
                        View
                         <span class="glyphicon glyphicon-pencil"></span></a>
                                        <?php if($myarray["viewed"]!='0' && $myarray["response_viewed"]!='0'){ ?>
                                                <a href="?rid=<?php echo  $myarray['id']; ?>" class="btn btn-default btn-sm">
                                                    Unread
                                                    <span class="glyphicon glyphicon-eye-close"></span>
                                                </a>
                                                        <?php } ?>
                                                        </td>
                                                        </tr>
                                                        <?php      }

}?>
	</tbody>
</table>

<a href="manage_support_tickets.php" class="btn btn-success pull-right" style="margin-left:5px">
    View Open Tickets
    <span class="glyphicon glyphicon-plus"></span>
</a>


<?php } ?>



<div id="popupContact">
<a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
