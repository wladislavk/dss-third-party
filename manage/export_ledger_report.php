<? 
//include "includes/top.htm";


if($_GET['dailysub']){
$file = 'Ledger_Report_'.date('m-d-Y', strtotime($_GET['start_date']));
}elseif($_GET['monthlysub']){
$file = 'Ledger_Report_'.date('m-Y', strtotime($_GET['start_date']));
}elseif($_GET['weeklysub'] || $_GET['weeklysub']){
$file = 'Ledger_Report_'.date('m-d-Y', strtotime($_GET['start_date'])).'_TO_'.date('m-d-Y', strtotime($_GET['end_date']));
}else{
$file= 'Ledger_Report';
}




header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=".$file.".csv");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");



  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date']; 

$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

if(isset($_GET['pid'])){
$sql = "select * from dental_ledger where patientid='".$_GET['pid']."' "; 
}else{
$sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
}


$sql .= " order by service_date";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp.";";
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>
Svc Date,Entry Date,Patient,Producer,Description,Charges,Credits,Ins
<?php	$tot_charges = 0;
		$tot_credit = 0;
		if(isset($_GET['pid'])){
		$newquery = "SELECT * FROM dental_ledger WHERE  docid='".$_SESSION['docid']."' AND `patientid` = '".$_GET['pid']."'";
		}else{
    $newquery = "SELECT * FROM dental_ledger WHERE `docid` = '".$_SESSION['docid']."'";
    }
                if($start_date)
                   $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";

                $runquery = mysql_query($newquery);
		while($myarray = mysql_fetch_array($runquery))
		{
			$pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
			$pat_my = mysql_query($pat_sql);
			$pat_myarray = mysql_fetch_array($pat_my);
			
			$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
			
                	 echo date('m-d-Y',strtotime(st($myarray["service_date"]))).',';
                	 echo date('m-d-Y',strtotime(st($myarray["entry_date"]))).',';
                	 echo st($name).',';
                	 echo st($myarray["producer"]).',';
                	 echo st($myarray["description"]).',';
                         echo number_format($myarray["amount"],2,'.','').',';
          $tot_charge += $myarray["amount"];

	                	echo number_format(st($myarray["paid_amount"]),2,'.','').',';
						$tot_credit += st($myarray["paid_amount"]);
          if($myarray["status"] == 1){
	           echo "Sent\r\n";
	          }elseif($myarray["status"] == 2){
             echo "Filed\r\n";
            }else{
             echo "Pend\r\n";
            }
				
	 	}
			?>

,,,,Total,<?php echo "$".number_format($tot_charge,2,'.',''); ?>,<?php echo "$".number_format($tot_credit,2,'.',''); ?>,

