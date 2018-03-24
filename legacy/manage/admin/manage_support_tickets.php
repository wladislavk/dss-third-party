<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';

if (
    !is_super($_SESSION['admin_access']) &&
    !is_software($_SESSION['admin_access']) &&
    !is_billing($_SESSION['admin_access'])
) { ?>
    <h2>You are not authorized to view this page.</h2>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

if (isset($_GET['rid'])) {
    $ticketId = intval($_GET['rid']);

    $db->query("UPDATE dental_support_tickets SET viewed = 0 WHERE id = '$ticketId' AND create_type = 1");
    $db->query("UPDATE dental_support_responses SET viewed = 0 WHERE ticket_id = '$ticketId' AND response_type = 1");
}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<!--link rel="stylesheet" href="css/support.css" type="text/css" /-->
<?php

$showClosed = isset($_GET['closed']);
$countDefault = 50;

$showPerPage = !empty($_GET['count']) ? intval($_GET['count']) : $countDefault;
$currentPage = !empty($_GET['page']) ? intval($_GET['page']) : 0;

$showPerPage = $showPerPage > 0 ? $showPerPage : $countDefault;
$currentOffset = $currentPage * $showPerPage;

$queryString = [];
$searchConditionals = [];
$andSearchConditional = '';

if ($showClosed) {
    $queryString['closed'] = 1;
}

if ($showPerPage != $countDefault) {
    $queryString['count'] = $showPerPage;
}

if (isset($_GET['catid'])) {
    $queryString['catid'] = intval($_GET['catid']);
}

if (isset($_GET['title']) && trim($_GET['title'])) {
    $queryString['title'] = trim($_GET['title']);
    $searchConditional['title'] = $queryString['title'];
}

if (isset($_GET['account']) && trim($_GET['account'])) {
    $queryString['account'] = trim($_GET['account']);
    $searchConditional['account'] = $queryString['account'];
}

if ($searchConditionals) {

}

if (!$showClosed) {
    $sql = "SELECT
            t.*,
            CONCAT(u.first_name, ' ', u.last_name) AS user,
            CONCAT(a.first_name, ' ', a.last_name) AS account,
            c.name AS company,
            t.company_id,
            c2.name AS ticket_company,
            cat.title AS category,
            (
                SELECT r.viewed
                FROM dental_support_responses r
                WHERE r.ticket_id = t.id
                    AND r.response_type = 1
                ORDER BY r.viewed ASC
                LIMIT 1
            ) AS response_viewed,
            (
                SELECT r3.attachment
                FROM dental_support_responses r3
                WHERE r3.ticket_id = t.id
                ORDER BY r3.attachment DESC
                LIMIT 1
            ) AS response_attachment,
            (
                SELECT a.filename
                FROM dental_support_attachment a
                WHERE a.ticket_id = t.id
                LIMIT 1
            ) AS ticket_attachment,
            response.last_response
        FROM dental_support_tickets t
            LEFT JOIN dental_users u ON u.userid = t.userid
            LEFT JOIN dental_users a ON a.userid = t.docid
            LEFT JOIN dental_user_company uc ON uc.userid = t.docid
            LEFT JOIN companies c ON c.id = uc.companyid
            LEFT JOIN companies c2 ON c2.id = t.company_id
            LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
            LEFT JOIN (
                    SELECT MAX(r2.adddate) AS last_response, r2.ticket_id
                    FROM dental_support_responses r2
                    GROUP BY r2.ticket_id
                ) response ON response.ticket_id=t.id
        WHERE t.status IN (".DSS_TICKET_STATUS_OPEN.", ".DSS_TICKET_STATUS_REOPENED.")
        ";

    if (!is_super($_SESSION['admin_access'])) {
        $sql .= " AND t.company_id = '" . intval($_SESSION['admincompanyid']) . "' ";
    }

    if ($queryString['catid']) {
        $sql .= " AND t.category_id = '{$queryString['catid']}' ";
    }

    if (strlen($queryString['title'])) {
        $sql .= " AND t.title LIKE '%" . $db->escape($queryString['title']) . "%' ";
    }

    if (strlen($queryString['account'])) {
        $sql .= " AND CONCAT(a.first_name, ' ', a.last_name) LiKE '%" . $db->escape($queryString['account']) . "%' ";
    }

    $totalSql = preg_replace(
        '/^select[\s\r\t\n]+[\s\S]+?[\s\r\t\n]from[\s\r\t\n]+(dental_support_tickets[\s\r\t\n]+t)/i',
        'SELECT COUNT(t.id) AS total FROM $1',
        $sql
    );

    $totalTickets = $db->getColumn($totalSql, 'total', 0);
    $totalPages = $totalTickets/$showPerPage;

    $sql .= " ORDER BY COALESCE(response.last_response, t.adddate) DESC LIMIT $currentOffset, $showPerPage";
    $ticketList = $db->getResults($sql);

    ?>
    <div class="page-header">
        Manage Support Tickets
    </div>
    <div class="page-header">
        Open Tickets
    </div>
    <form action="?" method="get">
        <input type="hidden" name="catid" value="<?= intval($queryString['catid']) ?>" />
        <label for="search_title">Title:</label>
        <input id="search_title" class="form-control input-sm input-inline" type="text" name="title"
               value="<?= e($queryString['title']) ?>" />
        &nbsp;
        <label for="search_account">Account:</label>
        <input id="search_account" class="form-control input-sm input-inline" type="text" name="account"
               value="<?= e($queryString['account']) ?>" />
        &nbsp;
        <input class="btn btn-primary btn-sm" type="submit" value="Search" />
        <a href="manage_support_tickets.php?closed=1" class="btn btn-success pull-right" style="margin-left:5px">
            View Closed Tickets
            <span class="glyphicon glyphicon-ok-sign"></span>
        </a>
    </form>
    <button onclick="loadPopup('add_ticket.php'); return false;" class="btn btn-success pull-right">
        Add Ticket
        <span class="glyphicon glyphicon-plus"></span>
    </button>
    <br />
    <div align="center" class="red">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>
    <?php paging($totalPages, $currentPage, http_build_query($queryString)) ?>
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
        <?php if (!count($ticketList)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="4" align="center">
                    No Records
                </td>
            </tr>
        <?php } else {
            foreach ($ticketList as $myarray) {
                if ($myarray['create_type'] == "1" && $myarray['viewed'] == "1") {
                    $ticket_read = true;
                } else {
                    $ticket_read = false;
                }

                $latest = $myarray['last_response'] != '' ? $myarray['last_response'] : $myarray['adddate'];

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
                        <?php if ($myarray["company_id"] == 0) { ?>
                            Dental Sleep Solutions
                        <?php } else { ?>
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
            <?php     }
        }?>
        </tbody>
    </table>
    <a href="manage_support_tickets.php?closed=1" class="btn btn-success pull-right" style="margin-left:5px">
        View Closed Tickets
        <span class="glyphicon glyphicon-ok-sign"></span>
    </a>
<?php } else { //isset($_GET['all'])
    $sql = "SELECT
            t.*,
            CONCAT(u.first_name, ' ', u.last_name) AS user,
            CONCAT(a.first_name, ' ', a.last_name) AS account,
            c.name AS company,
            t.company_id,
            c2.name AS ticket_company,
            cat.title AS category,
            (
                SELECT r.viewed
                FROM dental_support_responses r
                WHERE r.ticket_id = t.id
                    AND r.response_type = 1
                ORDER BY r.viewed ASC
                LIMIT 1
            ) AS response_viewed,
            (
                SELECT r2.adddate
                FROM dental_support_responses r2
                WHERE r2.ticket_id = t.id
                    ORDER BY r2.adddate DESC
                LIMIT 1
            ) AS last_response,
            (
                SELECT r3.attachment
                FROM dental_support_responses r3
                WHERE r3.ticket_id = t.id
                ORDER BY r3.attachment DESC
                LIMIT 1
            ) AS response_attachment
        FROM dental_support_tickets t
            LEFT JOIN dental_users u ON u.userid = t.userid
            LEFT JOIN dental_users a ON a.userid = t.docid
            LEFT JOIN dental_user_company uc ON uc.userid = t.docid
            LEFT JOIN companies c ON c.id = uc.companyid
            LEFT JOIN companies c2 ON c2.id = t.company_id
            LEFT JOIN dental_support_categories cat ON cat.id = t.category_id
        WHERE t.status IN (".DSS_TICKET_STATUS_CLOSED.")
        ";

    if (is_billing($_SESSION['admin_access'])) {
        $companyId = $db->getColumn("SELECT companyid
            FROM admin_company
            WHERE adminid = '" . intval($_SESSION['adminuserid']) . "'", 'companyid', 0);
        $sql .= " AND t.company_id = '$companyId' ";
    }

    if ($queryString['catid']) {
        $sql .= " AND category_id = '{$queryString['catid']}' ";
    }

    if (strlen($queryString['title'])) {
        $sql .= " AND t.title LIKE '%" . $db->escape($queryString['title']) . "%' ";
    }

    if (strlen($queryString['account'])) {
        $sql .= " AND CONCAT(a.first_name, ' ', a.last_name) LiKE '%" . $db->escape($queryString['account']) . "%' ";
    }

    $totalSql = preg_replace(
        '/^select[\s\r\t\n]+[\s\S]+?[\s\r\t\n]from[\s\r\t\n]+(dental_support_tickets[\s\r\t\n]+t)/i',
        'SELECT COUNT(t.id) AS total FROM $1',
        $sql
    );

    $totalTickets = $db->getColumn($totalSql, 'total', 0);
    $totalPages = $totalTickets/$showPerPage;

    $sql .= " ORDER BY t.adddate DESC LIMIT $currentOffset, $showPerPage";
    $ticketList = $db->getResults($sql);

    ?>
    <div class="page-header">
        Resolved
    </div>
    <form action="?" method="get">
        <input type="hidden" name="closed" value="1" />
        <input type="hidden" name="catid" value="<?= intval($queryString['catid']) ?>" />
        <label for="search_title">Title:</label>
        <input id="search_title" class="form-control input-sm input-inline" type="text" name="title"
            value="<?= e($queryString['title']) ?>" />
        &nbsp;
        <label for="search_account">Account:</label>
        <input id="search_account" class="form-control input-sm input-inline" type="text" name="account"
            value="<?= e($queryString['account']) ?>" />
        &nbsp;
        <input class="btn btn-primary btn-sm" type="submit" value="Search" />
        <a href="manage_support_tickets.php" class="btn btn-success pull-right" style="margin-left:5px">
            View Open Tickets
            <span class="glyphicon glyphicon-question-sign"></span>
        </a>
    </form>
    <?php paging($totalPages, $currentPage, http_build_query($queryString)) ?>
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
        <?php if (!count($ticketList)) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="4" align="center">
                    No Records
                </td>
            </tr>
        <?php } else {
            foreach ($ticketList as $myarray) {
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
            <?php }
        } ?>
        </tbody>
    </table>
    <a href="manage_support_tickets.php" class="btn btn-success pull-right" style="margin-left:5px">
        View Open Tickets
        <span class="glyphicon glyphicon-question-sign"></span>
    </a>
<?php } ?>
<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php include "includes/bottom.htm";?>
