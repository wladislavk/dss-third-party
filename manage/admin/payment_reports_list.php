<?php
namespace Ds3\Libraries\Legacy;
include 'includes/top.htm';

$back_office = true;
$sql_join_section = '';
$sql_user_filter = '1 = 1';

$adminCompanyId = intval($_SESSION['admincompanyid']);

if (is_super($_SESSION['admin_access'])) {
    $sql_join_section = 'INNER JOIN dental_users u ON u.userid = i.docid';
} elseif (is_billing($_SESSION['admin_access'])) {
    $sql_join_section .=  "INNER JOIN dental_users u ON u.userid = i.docid
            AND u.billing_company_id = '$adminCompanyId'
        INNER JOIN dental_user_company uc ON uc.userid = i.docid";
} else {
    $sql_join_section .= "INNER JOIN dental_users AS u ON u.userid = i.docid
        INNER JOIN dental_user_company uc ON uc.userid = i.docid
            AND uc.companyid = '$adminCompanyId'";
}

$header_class = 'page-header';
$table_style = 'class="table table-bordered table-hover"';

include_once('../includes/payment_reports_list.inc');
