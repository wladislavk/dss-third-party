<?php
require_once '../admin/includes/main_include.php';
//require_once '../admin/includes/general.htm';
$s = "SELECT dc.* FROM dental_contact dc
	JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
	WHERE dct.physician=1
	";
$q = mysqli_query($con, $s);
while($contact = mysqli_fetch_assoc($q)){
  $cid = $contact['contactid'];
echo $cid;
  $docid = $contact['docid']; 
  $l_sql = "SELECT * from dental_letters where md_list LIKE '%".$cid."%' OR md_referral_list like '%".$cid."%'";
  $l_q = mysqli_query($con, $l_sql);
  $l_num = mysqli_num_rows($l_q);
  $pat_sql = "SELECT * from dental_patients where 
		docsleep='".$cid."' OR 
                docpcp='".$cid."' OR 
                docdentist='".$cid."' OR 
                docent='".$cid."' OR 
                docmdother='".$cid."'";
  $pat_q = mysqli_query($con, $pat_sql);
  $pat_num = mysqli_num_rows($pat_q); 
  if($l_num==0 && $pat_num==0){
    create_welcome_letters('1', $cid, $docid);
    create_welcome_letters('2', $cid, $docid);
  }
}

// Function to Create Letters
function create_welcome_letters ($templateid, $md_list, $docid) {
$let_sql = "SELECT use_letters, intro_letters FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
error_log($let_sql);
$let_q = mysqli_query($con, $let_sql);
$let_r = mysqli_fetch_assoc($let_q);
if($let_r['use_letters'] && $let_r['intro_letters']){

  $gen_date = date('Y-m-d H:i:s');
  $status = '0';
  $delivered = '0';
  $deleted = '0';
  $columns = "templateid";
  $values = "'".mysqli_real_escape_string($con, $templateid)."'";
  if ($status == 1) {
    $columns .= ", date_sent";
    $values .= ", NOW()";
  }
  if (isset($md_list)) {
    $columns .= ", md_list";
    $values .= ", '".mysqli_real_escape_string($con, $md_list)."'";
  }
  if (isset($status)) {
                $columns .= ", status";
                $values .= ", '".mysqli_real_escape_string($con, $status)."'";
        }
  if (isset($deleted)) {
                $columns .= ", deleted";
                $values .= ", '".mysqli_real_escape_string($con, $deleted)."'";
        }

  $columns .= ", generated_date, delivered, docid, userid";
  $values .= ", '$gen_date', '$delivered', '". $docid ."', '". $docid ."'";
  $letter_query = "INSERT INTO dental_letters ($columns) VALUES ($values);";
echo $letter_query;
  $letter_insert = mysqli_query($con, $letter_query);
  if(!$letter_insert) {
    return ("MYSQL ERROR:".mysqli_errno($con).": ".mysqli_error($con)."<br/>"."Error inserting Letter to Database");
  } else {
    $id = mysqli_insert_id($con);
    // If parent and recipient ids are set, clear the recipient id from the parent

    return $id;
  }
}
}
?>
