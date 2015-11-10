<?php
namespace Ds3\Libraries\Legacy;
include 'includes/top.htm';

$back_office = true;
$sql_join_section = '';
$sql_user_filter = '1=1';
if (is_super($_SESSION['admin_access'])) {
    $sql_join_section .= ""
. "  INNER JOIN dental_users AS u on u.userid = i.docid "
;

} elseif (is_billing($_SESSION['admin_access'])) {
    $sql_join_section .=  ""
. "  INNER JOIN dental_users AS u on u.userid = i.docid AND u.billing_company_id = '" . mysqli_real_escape_string($con, $_SESSION['admincompanyid']) . "' "
. "  INNER JOIN dental_user_company uc ON uc.userid = i.docid "
;
} else {
    $sql_join_section .= ""
. "  INNER JOIN dental_users AS u on u.userid = i.docid "
. "  INNER JOIN dental_user_company uc ON uc.userid = i.docid AND uc.companyid = '" . mysqli_real_escape_string($con, $_SESSION['admincompanyid']) . "' "
;
}
$header_class = 'page-header';
$table_style = 'class="table table-bordered table-hover"';

include_once('../includes/payment_reports_list.inc');
