<?php
namespace Ds3\Libraries\Legacy;
include 'includes/top.htm';

$back_office = false;
$docId = intval($_SESSION['docid']);

$sql_join_section = 'INNER JOIN dental_users u ON u.userid = i.docid';
$sql_user_filter = "i.docid = '$docId'";
$header_class = 'admin_head';
$table_style = 'width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center"';

include_once('includes/payment_reports_list.inc');

