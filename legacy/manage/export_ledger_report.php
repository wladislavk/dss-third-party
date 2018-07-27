<?php
namespace Ds3\Libraries\Legacy;

include "includes/constants.inc";

if($_GET['dailysub']) {
    $file = 'Ledger_Report_'.date('m-d-Y', strtotime($_GET['start_date']));
} elseif($_GET['monthlysub']) {
    $file = 'Ledger_Report_'.date('m-Y', strtotime($_GET['start_date']));
} elseif($_GET['weeklysub'] || $_GET['weeklysub']) {
    $file = 'Ledger_Report_'.date('m-d-Y', strtotime($_GET['start_date'])).'_TO_'.date('m-d-Y', strtotime($_GET['end_date']));
} else {
    $file= 'Ledger_Report';
}

header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=".$file.".csv");
header("Pragma: no-cache");
header("Expires: 0");

include_once('admin/includes/main_include.php');
include("includes/sescheck.php");

session_write_close();

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
?>
Svc Date,Entry Date,Patient,Producer,Description,Charges,Credits,Adjustments,Ins
<?php
$tot_credit = 0;
$tot_adj = 0;

$db = new Db();

$newquery = "
    select 
    'ledger',
    dl.ledgerid,
    dl.service_date,
    dl.entry_date,
    dl.amount,
    dl.paid_amount,
    dl.status, 
    dl.description,
    CONCAT(p.first_name,' ',p.last_name) as name,
    pat.patientid,
    pat.firstname, 
    pat.lastname,
    tc.type as payer,
    '' as payment_type,
    dl.primary_claim_id
    from dental_ledger dl 
    JOIN dental_patients as pat ON dl.patientid = pat.patientid
    LEFT JOIN dental_users as p ON dl.producerid=p.userid
    LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
    where dl.docid='".$_SESSION['docid']."' 
    AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'
    UNION
    select 
        'ledger_payment',
        dlp.id,
        dlp.payment_date,
        dlp.entry_date,
        '',
        dlp.amount,
        '',
        '',
        CONCAT(p.first_name,' ',p.last_name),
        pat.patientid,
        pat.firstname,
        pat.lastname,
        dlp.payer,
        dlp.payment_type,
        ''
    from dental_ledger dl 
        JOIN dental_patients pat on dl.patientid = pat.patientid
        LEFT JOIN dental_users p ON dl.producerid=p.userid 
        LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
        where dl.docid='".$_SESSION['docid']."' 
        AND dlp.amount != 0
        AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."' 
    ";

        $runquery = $db->getResults($newquery);
        if ($runquery) {
            foreach ($runquery as $myarray) {
                $pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";

                $pat_myarray = $db->getRow($pat_sql);
                $name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
                echo date('m-d-Y',strtotime(st($myarray["service_date"]))).',';
                echo date('m-d-Y',strtotime(st($myarray["entry_date"]))).',';
                echo st($name).',';
                echo st($myarray["name"]).',';

                if($myarray[0]=='ledger_payment') {
                    echo $dss_trxn_payer_labels[$myarray['payer']] ." Payment - ". $dss_trxn_pymt_type_labels[$myarray['payment_type']].",";
                } else {
                    echo st($myarray["description"]);
                    echo ($myarray['primary_claim_id'])?" (".$myarray['primary_claim_id'].")":'';
                    echo ",";
                }

                echo number_format($myarray["amount"],2,'.','').',';
                $tot_charge += $myarray["amount"];

                if($myarray['ledger'] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ){
                    echo ',';
                    $tot_adj += st($myarray["paid_amount"]);
                }
                echo number_format(st($myarray["paid_amount"]),2,'.','').',';

                if(!($myarray['ledger'] == 'ledger' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){
                    echo ',';
                    $tot_credit += st($myarray["paid_amount"]);
                }

                if ($myarray['ledger'] == 'ledger') {
                    echo $dss_trxn_status_labels[$myarray["status"]] . "\r\n";
                } elseif ($myarray['ledger'] == 'claim') {
                    echo $dss_claim_status_labels[$myarray["status"]] . "\r\n";
                }
            }
        }
?>

,,,,Total,<?php echo "$".number_format($tot_charge,2,'.',''); ?>,<?php echo "$".number_format($tot_credit,2,'.',''); ?>,<?php echo "$".number_format($tot_adj,2,'.',''); ?>,
,,,,Balance,<?php echo "$".number_format($tot_charge - $tot_credit - $tot_adj,2,'.',''); ?>,,,
