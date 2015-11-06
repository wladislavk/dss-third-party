<?php namespace Ds3\Libraries\Legacy; ?>
<?php include 'includes/top.htm';?>
<?php

$back_office = false;
$sql_join_section = 'INNER JOIN dental_users AS u on u.userid = i.docid';
$sql_user_filter = 'i.docid = ' . $_SESSION['docid'];;
$header_class = 'admin_head';
$table_style = 'width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center"';

include_once('includes/payment_reports_list.inc');

