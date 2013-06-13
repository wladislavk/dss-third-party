<? 
include "includes/top.htm";
include_once "../includes/constants.inc";
if(isset($_GET['rid'])){
  $u_sql = "UPDATE dental_support_tickets SET viewed=0 WHERE id='".mysql_real_escape_string($_GET['rid'])."' LIMIT 1";
  mysql_query($u_sql);
}
$sql = "select t.*,
	(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id=t.id AND r.response_type=1 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed
	 FROM dental_support_tickets t
   	WHERE t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.") ";
if(isset($_REQUEST['catid'])){
  $sql .= " AND t.category_id = ".mysql_real_escape_string($_REQUEST['catid']);
}
$sql .= " order by t.adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/support.css" type="text/css" />
<span class="admin_head">
	Manage Support Tickets
</span>
<br />
<br />


<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="25%">
			Title
		</td>
		<td valign="top" class="col_head" width="50%">
 			Body
		</td>
                <td valign="top" class="col_head" width="10%">
                        Status 
                </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
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

		?>
			<tr class="<?= ($myarray["viewed"]=='0' || $myarray["response_viewed"]=='0')?"unviewed":""; ?>">
				<td valign="top">
					<?=st($myarray["title"]);?>
				</td>
				<td valign="top">
					<?= st(substr($myarray["body"], 0 , 50)); ?>
				</td>		
                                <td valign="top">
                                        <?= $dss_ticket_status_labels[$myarray["status"]];?>
                                </td>
				<td valign="top">
					<a href="view_support_ticket.php?ed=<?=$myarray["id"];?>" class="editlink" title="EDIT">
						View
					</a>
                   		<?php if($myarray['attachment']!=''){ ?>
					| <a href="../q_file/<?= $myarray['attachment']; ?>">Attachment</a>
				<?php } ?> 
        <?php if($myarray["viewed"]!='0' && $myarray["response_viewed"]!='0'){ ?>
          | <a href="?rid=<?= $myarray['id']; ?>">Mark Unread</a>
        <?php } ?>
				</td>
			</tr>
	<? 	}
	}?>
</table>

<?php
$sql = "select * FROM dental_support_tickets 
        WHERE status IN (".DSS_TICKET_STATUS_CLOSED.") ";
if(isset($_REQUEST['catid'])){
  $sql .= " AND category_id = ".mysql_real_escape_string($_REQUEST['catid']);
}
$sql .= " order by adddate DESC";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);

?>
<span class="admin_head">
        Resolved
</span>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="25%">
                        Title
                </td>
                <td valign="top" class="col_head" width="50%">
                        Body
                </td>
                <td valign="top" class="col_head" width="10%">
                        Status
                </td>
                <td valign="top" class="col_head" width="15%">
                        Action
                </td>
        </tr>
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

                ?>
                        <tr>
                                <td valign="top">
                                        <?=st($myarray["title"]);?>
                                </td>
                                <td valign="top">
                                        <?= st(substr($myarray["body"], 0 , 50)); ?>
                                </td>
                                <td valign="top">
                                        <?= $dss_ticket_status_labels[$myarray["status"]];?>
                                </td>
                                <td valign="top">
                                        <a href="view_support_ticket.php?ed=<?=$myarray["id"];?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                <?php if($myarray['attachment']!=''){ ?>
                                        | <a href="../q_file/<?= $myarray['attachment']; ?>">Attachment</a>
                                <?php } ?>
                                </td>
                        </tr>
        <?      }
        }?>
</table>






<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
