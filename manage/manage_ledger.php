<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once('includes/dental_patient_summary.php');
include_once('includes/patient_info.php');

if ($patient_info)
$sql = "SELECT  "
     . "  dl.amount, sum(pay.amount) as paid_amount "
     . "FROM dental_ledger dl  "
     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
     . "WHERE dl.docid='".$_SESSION['docid']."' AND dl.patientid='".s_for($_GET['pid'])."'  "
     . "GROUP BY dl.ledgerid";
$result = $db->getResults($sql);
$ledger_balance = 0;
if ($result) foreach ($result as $row) {
  $ledger_balance -= (!empty($row['amount']) ? $row['amount'] : 0);
  $ledger_balance += (!empty($row['paid_amount']) ? $row['paid_amount'] : 0);
}
update_patient_summary((!empty($_GET['pid']) ? $_GET['pid'] : ''), 'ledger', $ledger_balance);
?>

<link rel="stylesheet" href="css/ledger.css" />

<?php
if(!isset($_GET['sort'])){
  $_GET['sort'] = 'service_date';
  $_GET['sortdir'] = 'desc';
}

if(!empty($_REQUEST["delid"]))
{
  $pat_sql2 = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
  $pat_my2 = $db->getResults($pat_sql2);
  foreach ($pat_my2 as $pat_myarray2) {
    $pat_sql3 = $db->query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".$_GET['pid']."','".$pat_myarray2['service_date']."','".$pat_myarray2['description']."','".$pat_myarray2['amount']."','".$pat_myarray2['paid_amount']."','".$pat_myarray2['transaction_code']."','".$pat_myarray2['ip_address']."','".$pat_myarray2['transaction_type']."');");
    if(!$pat_sql3){
      echo "There was an error updating the ledger record.  Please contact your system administrator.";
    }
  }  
  
  $del_sql = "delete from dental_ledger where ledgerid='".$_REQUEST["delid"]."'";
  $db->query($del_sql);
  
  $msg= "Deleted Successfully";?>

  <script type="text/javascript">
    //alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
      window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
                <?php } ?>
  </script>
  <?php
  trigger_error("Die called", E_USER_ERROR);
}

if(isset($_REQUEST["delstatementid"]) && $_REQUEST["delstatementid"] != ""){
  $sql = "DELETE FROM dental_ledger_statement WHERE id='".mysqli_real_escape_string($con,$_REQUEST['delstatementid'])."' AND patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."'";
  $db->query($sql);
  $msg = "Deleted Successfully";
          ?>
        <script type="text/javascript">
                  window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
}

if(!empty($_REQUEST["delclaimid"]))
{
  $sql = "SELECT * FROM dental_insurance where insuranceid='".$_REQUEST["delclaimid"]."' AND status = ".DSS_CLAIM_PENDING;
  $q = $db->getResults($sql);
  if(count($q)>0){
    $del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delclaimid"]."' AND status = ".DSS_CLAIM_PENDING;
    if($db->query($del_sql)){
      $up_sql = "UPDATE dental_ledger set primary_claim_id=NULL, status='".DSS_TRXN_NA."' WHERE primary_claim_id='".$_REQUEST["delclaimid"]."'";
      $db->query($up_sql);
      $msg= "Deleted Successfully";
    }else{
      $msg = "Error deleting.";
    }
  }
  ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
                  window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
                <?php } ?>
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
  
}

if(!empty($_REQUEST["delnoteid"]))
{

  $sql = "DELETE FROM dental_ledger_note WHERE id='".mysqli_real_escape_string($con,$_REQUEST['delnoteid'])."' AND patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."'";
        $q = mysqli_query($con, $sql);
         if($q){

          $msg= "Deleted Successfully";
         }else{
          $msg = "Error deleting.";
        }
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                <?php if($_GET['popup']==1){ ?>
                  parent.window.location.reload();
                <?php }else{ ?>
                  window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
                <?php } ?>
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);

}


$pat_sql = "select * from dental_patients where patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
$pat_myarray = $db->getRow($pat_sql); 

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

if(empty($pat_myarray['patientid']))
{
  ?>
  <script type="text/javascript">
    //window.location = 'manage_patient.php';
  </script>
  <?php
  //trigger_error("Die called", E_USER_ERROR);
}

$rec_disp = 2000;

if(!empty($_REQUEST["page"]))
  $index_val = $_REQUEST["page"];
else
  $index_val = 0;
  
$i_val = $index_val * $rec_disp;

$docId = intval($_SESSION['docid']);
$patientId = intval($_GET['pid']);
$trxnTypeWriteOff = DSS_TRXN_PYMT_WRITEOFF;

$filedByBackOfficeConditional = filedByBackOfficeConditional('di');

if (!empty($_GET['mailed'])) {
    $andMailedOnlyConditional = 'AND di.mailed_date IS NOT NULL';
    $mailedOnlyJoin = "JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id $andMailedOnlyConditional";
} else {
    $andMailedOnlyConditional = '';
    $mailedOnlyJoin = '';
}

if (!empty($_GET['openclaims']) && $_GET['openclaims'] == 1) {
    $sql = "SELECT
            'claim',
            di.insuranceid AS ledgerid,
            di.adddate AS service_date,
            di.adddate AS entry_date,
            'Claim' AS name,
            'Insurance Claim' AS description,
            (
                SELECT SUM(dl2.amount)
                FROM dental_ledger dl2
                    INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                WHERE i2.insuranceid = di.insuranceid
            ) AS amount,
            SUM(pay.amount) AS paid_amount,
            di.status,
            di.insuranceid AS primary_claim_id,
            $filedByBackOfficeConditional AS filed_by_bo
        FROM dental_insurance di
            LEFT JOIN dental_ledger dl ON dl.primary_claim_id = di.insuranceid
            LEFT JOIN dental_ledger_payment pay ON dl.ledgerid = pay.ledgerid
        WHERE di.patientid = '$patientId'
            AND di.status NOT IN (
                " . DSS_CLAIM_PAID_INSURANCE . ", " . DSS_CLAIM_PAID_SEC_INSURANCE . ",
                " . DSS_CLAIM_PAID_PATIENT . ", " . DSS_CLAIM_PAID_SEC_PATIENT . "
            )
            $andMailedOnlyConditional
        GROUP BY di.insuranceid
    ";
} else {
    $sql = "SELECT -- Debits/Charges
            'ledger',
            dl.ledgerid,
            dl.service_date,
            dl.entry_date,
            CONCAT(p.first_name, ' ', p.last_name) AS name,
            dl.description,
            dl.amount,
            '' AS paid_amount,
            di.status,
            dl.primary_claim_id,
            '' AS payer,
            '' AS payment_type,
            di.status AS claim_status,
            '' AS filename,
            '' AS num_notes,
            '' AS num_fo_notes,
            0 AS filed_by_bo
        FROM dental_ledger dl
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment pay ON pay.ledgerid = dl.ledgerid
            LEFT JOIN dental_insurance di ON di.insuranceid = dl.primary_claim_id
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND COALESCE(dl.paid_amount, 0) = 0
            $andMailedOnlyConditional
        GROUP BY dl.ledgerid

        UNION

        SELECT -- Credits
            'ledger_payment',
            dlp.id,
            dlp.payment_date,
            dlp.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            '',
            '',
            dlp.amount,
            '',
            IF(dl.secondary_claim_id && dlp.is_secondary, dl.secondary_claim_id, dl.primary_claim_id),
            dlp.payer,
            dlp.payment_type,
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger dl
            $mailedOnlyJoin
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND dlp.amount != 0
            AND COALESCE(dlp.payment_type, 0) != '$trxnTypeWriteOff'

        UNION

        SELECT -- Adjustments from ledger
            'ledger_paid',
            dl.ledgerid,
            dl.service_date,
            dl.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            dl.description,
            dl.amount,
            dl.paid_amount,
            dl.status,
            dl.primary_claim_id,
            tc.type,
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger dl
            $mailedOnlyJoin
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment pay ON pay.ledgerid = dl.ledgerid
            LEFT JOIN dental_transaction_code tc ON tc.transaction_code = dl.transaction_code
                AND tc.docid = '$docId'
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND dl.paid_amount != 0

        UNION

        SELECT -- Adjustments from payments
            'ledger_paid',
            dlp.id,
            dlp.payment_date,
            dlp.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            COALESCE(dlp.payment_type, '0'),
            '',
            dlp.amount,
            '',
            IF(dl.secondary_claim_id && dlp.is_secondary, dl.secondary_claim_id, dl.primary_claim_id),
            dlp.payer,
            dlp.payment_type,
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger dl
            $mailedOnlyJoin
            LEFT JOIN dental_users p ON dl.producerid = p.userid
            LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
        WHERE dl.docid = '$docId'
            AND dl.patientid = '$patientId'
            AND dlp.amount != 0
            AND COALESCE(dlp.payment_type, 0) = '$trxnTypeWriteOff'

        UNION

        SELECT
            'note',
            n.id,
            n.service_date,
            n.entry_date,
            CONCAT('Note - ', p.first_name, ' ', p.last_name),
            n.note,
            '',
            '',
            n.private,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_note n
            JOIN dental_users p ON n.producerid = p.userid
        WHERE n.patientid = '$patientId'

        UNION

        SELECT
            'statement',
            s.id,
            s.service_date,
            s.entry_date,
            CONCAT(p.first_name, ' ', p.last_name),
            'Ledger statement created (Click to view)',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            s.filename,
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_statement s
            JOIN dental_users p ON s.producerid = p.userid
        WHERE s.patientid = '$patientId'

        UNION

        SELECT
            'note',
            n.id,
            n.service_date,
            n.entry_date,
            CONCAT('Note - Backoffice ID - ', p.adminid),
            n.note,
            '',
            '',
            n.private,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            0 AS filed_by_bo
        FROM dental_ledger_note n
            JOIN admin p ON n.admin_producerid = p.adminid
        WHERE n.patientid = '$patientId'

        UNION

        SELECT
            'claim',
            di.insuranceid,
            di.adddate,
            di.adddate,
            'Claim',
            'Insurance Claim',
            (
                SELECT SUM(dl2.amount)
                FROM dental_ledger dl2
                    INNER JOIN dental_insurance i2 ON dl2.primary_claim_id = i2.insuranceid
                WHERE i2.insuranceid = di.insuranceid
            ),
            SUM(pay.amount),
            di.status,
            di.primary_claim_id,
            '',
            '',
            '',
            '',
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = di.insuranceid
            ),
            (
                SELECT COUNT(id)
                FROM dental_claim_notes
                WHERE claim_id = di.insuranceid
                    AND create_type = '1'
            ),
            $filedByBackOfficeConditional AS filed_by_bo
        FROM dental_insurance di
            LEFT JOIN dental_ledger dl ON dl.primary_claim_id = di.insuranceid
            LEFT JOIN dental_ledger_payment pay ON dl.ledgerid = pay.ledgerid
        WHERE di.patientid = '$patientId'
            $andMailedOnlyConditional
        GROUP BY di.insuranceid
    ";
}

if(isset($_GET['sort'])){
  if($_GET['sort']=='producer'){
    $sql .= " ORDER BY name ".$_GET['sortdir']; 
  }else{
    $sql .= " ORDER BY ".$_GET['sort']." ".$_GET['sortdir'];
  }
}

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_users = count($my);
?>

<!--
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
-->
<span class="admin_head">
  Ledger Card
</span>

&nbsp;&nbsp;&nbsp;
<?php echo $name;
if(st($pat_myarray['add1']) <> '') {?>
  <br />
  &nbsp;&nbsp;&nbsp;
  <?php echo st($pat_myarray['add1']);
}

if(st($pat_myarray['add2']) <> '') {?>
  <br />
  &nbsp;&nbsp;&nbsp;
  <?php echo st($pat_myarray['add2']);
}?>

&nbsp;&nbsp;&nbsp;
<?php echo st($pat_myarray['city']);?>  

&nbsp;&nbsp;&nbsp;
<?php echo st($pat_myarray['state']);?> 

&nbsp;&nbsp;&nbsp;
<?php echo st($pat_myarray['zip']);?> 

<br />
&nbsp;&nbsp;&nbsp;
D: <?php echo st($pat_myarray['work_phone']);?>

&nbsp;&nbsp;&nbsp;
H: <?php echo st($pat_myarray['home_phone']);?>

<br />
&nbsp;&nbsp;&nbsp;
W1: <?php echo st($pat_myarray['cell_phone']);?>

<br />

<script type="text/javascript">
  function concat_checked(ids){
    var s = '';
    var first = true;
    for(var i = 0; i < ids.length; i++){
      if(ids[i].checked) {
        if(first){
          first=false;
        }else{
          s+=',';
        }
        s += ids[i].value;
      }
    }
    return s;
  }
</script>

<div align="right">
<?php if(!empty($_GET['openclaims']) && $_GET['openclaims']==1){ ?>
  <button onclick="Javascript: window.location='manage_ledger.php?<?php echo 'pid='.$_GET['pid'];?>';" class="addButton">
    View All 
  </button>
<?php }else{ ?>
  <button onclick="Javascript: window.location='manage_ledger.php?openclaims=1&<?php echo 'pid='.$_GET['pid'];?>';" class="addButton">
    Claims Outstanding 
  </button>
<?php } ?>  
  &nbsp;&nbsp;
  <button onclick="Javascript: window.open('print_ledger_report.php?<?php echo (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>')" class="addButton">
    Print Ledger
  </button>
  &nbsp;&nbsp;
  <button onclick="Javascript: loadPopup('add_ledger_entry.php?pid=<?php echo $_GET['pid'];?>');" class="addButton">
    Add New Transaction
  </button>
  &nbsp;&nbsp;
  <button onclick="Javascript: window.location='manage_ledger.php?pid=<?php echo $_GET['pid'];?>&inspay=1'" class="addButton">
    Add Ins. Payment
  </button>
  &nbsp;&nbsp;
  <button onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?php echo $_GET['pid'];?>');" class="addButton">
    Add Note 
  </button>
  &nbsp;&nbsp;
  <button onclick="Javascript: window.open('ledger_statement.php?pid=<?php echo $_GET['pid'];?>')" class="addButton">
    Create Statement 
  </button>
  &nbsp;&nbsp;
</div>
<br />
<div align="center" class="red">
<?php if(isset($_GET['inspay']) && $_GET['inspay']==1){ ?>
  Please select claim below to apply insurance payment.
<?php }else{ ?>
  <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
<?php } ?>
</div>

<form name="edit_mult_form" id="edit_mult_form" />
  <table  class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<?php if($total_rec > $rec_disp) {?>
    <TR bgColor="#ffffff">
      <TD  align="right" colspan="15" class="bp">
        Pages:
        <?php paging($no_pages,$index_val,"");?>
      </TD>        
    </TR>
<?php }?>
    <tr class="tr_bg_h">
      <td valign="top" class="col_head  <?php echo ($_GET['sort'] == 'service_date')?'arrow_'.strtolower($_GET['sortdir']):''; ?>" width="10%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=service_date&sortdir=<?php echo ($_GET['sort']=='service_date'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
      </td>
      <td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="10%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=entry_date&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='entry_date'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
      </td>
      <td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'producer')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="30%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=producer&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='producer'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Producer</a>
      </td>
      <td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'description')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="30%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=description&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='description'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Description</a>
      </td>
      <td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'amount')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="10%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=amount&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='amount'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Charges</a>
      </td>
      <td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="10%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=paid_amount&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='paid_amount'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Credits</a>
      </td>
      <td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="10%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=paid_amount&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='paid_amount'&&(!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')=='ASC')?'DESC':'ASC'; ?>">Adjustments</a>
      </td>
      <td valign="top" class="col_head" width="10%">
        Balance
      </td>
      <td valign="top" class="col_head <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'status')?'arrow_'.strtolower((!empty($_REQUEST['sortdir']) ? $_REQUEST['sortdir'] : '')):''; ?>" width="5%">
        <a href="manage_ledger.php?pid=<?php echo $_GET['pid'] ?>&sort=status&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
      </td>
      <td valign="top" class="col_head" width="20%">
        History
      </td>
      <td valign="top" class="col_head" width="20%">
        Action
      </td>
    </tr>

<?php if(count($my) == 0){ ?>
    <tr class="tr_bg">
      <td valign="top" class="col_head" colspan="10" align="center">
        No Records
      </td>
    </tr>
<?php }else{
  if($_GET['sortdir']=='DESC'){
    $cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;
    $my2 = $db->getResults($sql);
    foreach ($my2 as $myarray) {
      if($myarray[0]!='claim'){
        $cur_bal += st($myarray["amount"]);
      }
      if($myarray[0]!='claim'){
        $cur_bal -= st($myarray["paid_amount"]);
      }
      $orig_bal = $cur_bal;
    }   
  }else{
    $cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;
  }
  $last_sd = '';
  $last_ed = '';
  foreach ($my as $myarray) {
    if($myarray["status"] == 1){
      $tr_class = "tr_active";
    }else{
      $tr_class = "tr_inactive";
    }
    $tr_class = "tr_active";
    if(!empty($myarray['ledger']) && $myarray['ledger'] == 'claim'){ 
      $tr_class .= ' clickable_row status_'.$myarray['status']; 
    }
    if(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' && $myarray['primary_claim_id']!='' && $myarray['primary_claim_id']!='0'){ 
      $tr_class .= ' claimed'; 
    }
    if(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
      $tr_class .= ' claimless clickable_row'; 
    }
    if(!empty($myarray['ledger']) && $myarray['ledger'] == 'statement' && $myarray['filename']!=''){ 
      $tr_class .= ' statement clickable_row'; 
    }
    if($myarray['status'] == 3 || $myarray['status'] == 5 || $myarray['status'] == 9){ 
      $tr_class .= ' completed'; 
    }
    if(!isset($_GET['inspay']) || $_GET['inspay']!=1 || !empty($myarray['ledger']) && $myarray['ledger']=="claim"){?>
    <tr 
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=="claim"){ 
        if(isset($_GET['inspay']) && $_GET['inspay']==1){
          echo 'onclick="window.location=\'view_claim.php?inspay=1&claimid='.$myarray['ledgerid'].'&pid='.$_GET['pid'].'\'"'; 
        }else{
          echo 'onclick="window.location=\'view_claim.php?claimid='.$myarray['ledgerid'].'&pid='.$_GET['pid'].'\'"'; 
        } 
      }
      if(!empty($myarray['filename'])){ 
        echo 'onclick="window.location=\''.$myarray['filename'].'\'"'; 
      } ?>
        <?= $myarray['filed_by_bo'] ? 'title="3rd party Billing is responsible for this claim"' : '' ?>
        class="<?php echo $tr_class;?> <?php echo (!empty($myarray['ledger']) ? $myarray['ledger'] : ''); ?>">
      <td valign="top"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; 
      } ?>
          >
<?php 
      if($myarray["service_date"]!=$last_sd){
        $last_sd = $myarray["service_date"];
        echo date('m-d-Y',strtotime(st($myarray["service_date"])));
      } ?>
      </td>
      <td valign="top"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; 
      } ?>
                      >
<?php 
      if($myarray["entry_date"]!=$last_ed){
        $last_ed = $myarray["entry_date"];
        echo date('m-d-Y',strtotime(st($myarray["entry_date"])));
      } ?>
      </td>
      <td valign="top"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; 
      } ?>
                      >
      <?php echo st($myarray["name"]);?>
      </td>
      <td valign="top"
          <?php if ($myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING) { ?>
              onclick="window.location='manage_insurance.php?pid=<?= $_GET['pid'] ?>&addtopat=1"
          <?php } ?>
          >
<?php echo (!empty($myarray['ledger']) && $myarray['ledger'] == 'note' && $myarray['status']==1)?"(P) ":'';
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid') && !empty($myarray['payer']))?$dss_trxn_type_labels[$myarray['payer']]." - ":'';
      echo $myarray["description"];
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":'';

      echo ((!empty($myarray['ledger']) && $myarray['ledger'] =='claim') && $myarray['ledgerid'])?"(".$myarray['ledgerid'].") ":'';
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] =='claim') && $myarray['primary_claim_id'])?"Secondary to (".$myarray['primary_claim_id'].") ":'';
      echo ($myarray['filed_by_bo'] ? '*' : '');

      echo ((!empty($myarray['ledger']) && $myarray['ledger'] =='claim') && $myarray['num_notes'] > 0)?" - Notes (".$myarray['num_notes'].") ":'';

      echo (!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING)?' (Click to file)':'';
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":'';
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":'';
      echo ((!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; ?>
      </td>
      <td valign="top" align="right"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; 
      } ?>
                                  >
<?php 
      if(st($myarray["amount"]) <> 0 && !empty($myarray['ledger']) && $myarray['ledger']!='claim') {
        echo number_format(st($myarray["amount"]),2);
        if(!empty($myarray['ledger']) && $myarray['ledger']!='claim'){
          if($_GET['sortdir']=='DESC'){
            $cur_bal -= st($myarray["amount"]);
          }else{
            $cur_bal += st($myarray["amount"]);
          }
          $cur_cha += st($myarray["amount"]); 
        }
      }?>
        &nbsp;
      </td>
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid' &&
          ($myarray['payer']==DSS_TRXN_TYPE_ADJ || $myarray['payment_type']==DSS_TRXN_PYMT_WRITEOFF)){ ?>
      <td></td>
<?php
        if($myarray['ledger']!='claim'){
          if($_GET['sortdir']=='DESC'){
            $cur_bal += st($myarray["paid_amount"]);
          }else{
            $cur_bal -= st($myarray["paid_amount"]);
          }
          $cur_adj += st($myarray["paid_amount"]);
        }
      } ?>
      <td valign="top" align="right"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; 
      } ?>
                                  >
<?php 
      if(st($myarray["paid_amount"]) <> 0 && !empty($myarray['ledger']) && $myarray['ledger']!='claim') {
        echo number_format(st($myarray["paid_amount"]),2);
      }?>
        &nbsp;
      </td>
<?php 
      if(!(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid' &&
          ($myarray['payer']==DSS_TRXN_TYPE_ADJ || $myarray['payment_type']==DSS_TRXN_PYMT_WRITEOFF))){
        if(!empty($myarray['ledger']) && $myarray['ledger']!='claim'){
          if($_GET['sortdir']=='DESC'){
            $cur_bal += st($myarray["paid_amount"]);
          }else{
            $cur_bal -= st($myarray["paid_amount"]);
          }
          $cur_pay += st($myarray["paid_amount"]);
        }?>
      <td></td>
<?php 
      } ?>
      <td valign="top" align="right"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                  >
<?php 
      if(!empty($myarray['ledger']) && ($myarray['ledger']=='ledger' || $myarray['ledger'] == 'ledger_paid' || $myarray['ledger'] == 'ledger_paid' || $myarray['ledger'] == 'ledger_payment')){
        if($_GET['sort']=='service_date' || $_GET['sort']=='entry_date'){
          $show_bal = $cur_bal;
          if($_GET['sortdir']=='DESC'){
            $show_bal += $myarray['amount']-$myarray['paid_amount'];
          }
          echo number_format(st($show_bal),2);
        }else{ ?>
          N/A
          &nbsp;
<?php 
        }
      } ?>
      </td>
      <td valign="top"
<?php 
      if(!empty($myarray['ledger']) && $myarray['ledger']=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ 
        echo 'onclick="window.location=\'manage_insurance.php?pid='.$_GET['pid'].'&addtopat=1\'"'; } ?>
                                  >
<?php
      if(!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid'){
        echo $dss_trxn_status_labels[$myarray["status"]]; 
      }elseif(!empty($myarray['ledger']) && ($myarray['ledger']=='claim' || $myarray['ledger'] == 'ledger')){
        echo (!empty($dss_claim_status_labels[$myarray["status"]]) ? $dss_claim_status_labels[$myarray["status"]] : '');
      }
            //if($myarray["status"] == '0'){echo "Pend.";}
            //if($myarray["status"] == '1'){echo "Sent ";}
            //if($myarray["status"] == '2'){echo "Filed";}
  ?>        
      </td>
      <td valign="top">
<?php 
      if( !empty($myarray['ledger']) && $myarray['ledger'] == 'ledger' || !empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_payment'){ ?>
        <a href="#" onclick="$('.history_<?php echo $myarray['ledgerid']; ?>').toggle();return false;">View</a>
<?php 
      } ?>
      </td>
      <td valign="top">
<?php 
      if((!empty($myarray['ledger']) && $myarray['ledger']=='ledger'&&($myarray['claim_status']!=DSS_CLAIM_SENT&&$myarray['claim_status']!=DSS_CLAIM_SEC_SENT))||!empty($myarray['ledger']) && $myarray['ledger'] == 'ledger_paid'){ ?>
        <a href="Javascript:;" 
<?php
      // column 'edit_ledger_entries' is exist in 'dental_users' table
      // $pla_sql = "SELECT edit_ledger_entries FROM dental_users where userid='".$_SESSION['userid']."'";
      // $pla = $db->getRow($pla_sql);
        if(!empty($pla) && $pla['edit_ledger_entries'] != '1' && $_SESSION['docid']!=$_SESSION['userid']){?>
                                    onclick="alert('You do not have permission to edit ledger entries.  Please contact your office manager to resolve this issue.');" 
<?php 
        }else{ ?>
                                    onclick="Javascript: loadPopup('add_ledger.php?ed=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>');" 
<?php 
        } ?>
                                    class="editlink" title="EDIT">
          Edit 
        </a>
<?php 
        if($myarray['primary_claim_id']!=0 && $myarray['primary_claim_id']!=''){ ?> 
        <a href="view_claim.php?claimid=<?php echo $myarray['primary_claim_id']; ?>&pid=<?php echo $_GET['pid'];?>" class="editlink" title="PAYMENT">
          Pay 
        </a>
<?php 
        }else{ ?>
        <a href="Javascript:;" onclick="javascript: loadPopup('add_ledger_payment.php?ed=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="PAYMENT">
          Pay 
        </a>
<?php 
        }
      }elseif(!empty($myarray['ledger']) && $myarray['ledger']=='note'){ ?>
        <a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_note.php?ed=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="EDIT">
          Edit 
        </a>
<?php 
      }elseif(!empty($myarray['ledger']) && $myarray['ledger']=='claim'){
        if($myarray['status']!=DSS_CLAIM_SENT && $myarray['status']!=DSS_CLAIM_SEC_SENT && $myarray['status']!=DSS_CLAIM_PAID_INSURANCE && $myarray['status']!=DSS_CLAIM_PAID_PATIENT && $myarray['status']!=DSS_CLAIM_PAID_SEC_INSURANCE ){ ?>
        <a href="insurance_v2.php?insid=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>" class="editlink" title="EDIT">
          Edit 
        </a>
<?php 
        }
        if($myarray['status']==DSS_CLAIM_PENDING){ ?>
        <a href="<?php echo $_SERVER['PHP_SELF']?>?delclaimid=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
          Delete 
        </a>
<?php 
        }
      }elseif(!empty($myarray['ledger']) && $myarray['ledger']=='ledger_payment'){ ?>
        <a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_payment.php?ed=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="PAYMENT">
          Edit 
        </a>
<?php 
      }elseif(!empty($myarray['ledger']) && $myarray['ledger']=='statement'){ ?>
        <a href="<?php echo $_SERVER['PHP_SELF']?>?delstatementid=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
          Delete 
        </a>
<?php 
      } ?>
      </td>
    </tr>
<?php 
      if( !empty($myarray['ledger']) && in_array($myarray['ledger'], ['ledger', 'ledger_payment'])){ ?>
    <tr class="history_<?php echo $myarray['ledgerid']; ?>" style="display:none;">
      <td>Updated At</td>
      <td>Service Date</td>
      <td>Producer</td>
      <td>Description</td>
      <td>Charges</td>
      <td>Credits</td>
      <td>Update By</td>
    </tr>
<?php
        $ledgerId = intval($myarray['ledgerid']);
        $patientId = intval($_GET['pid']);
        $docId = intval($_SESSION['docid']);

        if ($myarray['ledger'] === 'ledger') {
            $h_sql = "select
                    'ledger',
                    dl.ledgerid,
                    dl.service_date,
                    dl.entry_date,
                    CONCAT(p.first_name,' ',p.last_name) as name,
                    dl.description,
                    dl.amount,
                    di.status,
                    dl.primary_claim_id,
                    di.status as claim_status,
                    dl.updated_at,
                    CONCAT(u.first_name,' ',u.last_name) as updated_user,
                    CONCAT(a.first_name,' ',a.last_name) as updated_admin
                from dental_ledger_history dl
                    LEFT JOIN dental_users p ON dl.producerid=p.userid
                    LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
                    LEFT JOIN dental_insurance di on di.insuranceid = dl.primary_claim_id
                    LEFT JOIN dental_users u ON u.userid=dl.updated_by_user
                    LEFT JOIN admin a ON a.adminid=dl.updated_by_admin
                where dl.docid = '$docId' and dl.patientid = '$patientId'
                    and coalesce(dl.paid_amount, 0) = 0
                    AND dl.ledgerid = '$ledgerId'
                ORDER BY dl.updated_at ASC
            ";
        } else {
            $h_sql = "SELECT
                    'ledger_payment' AS ledger,
                    dlp.id AS ledgerid,
                    dlp.payment_date AS service_date,
                    dlp.entry_date,
                    CONCAT(p.first_name, ' ', p.last_name) AS name,
                    '' AS description,
                    dlp.amount AS paid_amount,
                    '' AS status,
                    IF(
                        dl.secondary_claim_id && dlp.is_secondary,
                        dl.secondary_claim_id,
                        dl.primary_claim_id
                    ) AS primary_claim_id,
                    '' AS claim_status,
                    dl.updated_at,
                    CONCAT(u.first_name,' ',u.last_name) as updated_user,
                    CONCAT(a.first_name,' ',a.last_name) as updated_admin
                FROM dental_ledger_history dl
                    LEFT JOIN dental_users p ON dl.producerid = p.userid
                    LEFT JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
                    LEFT JOIN dental_users u ON u.userid = dl.updated_by_user
                    LEFT JOIN admin a ON a.adminid = dl.updated_by_admin
                WHERE dl.docid = '$docId'
                    AND dl.patientid = '$patientId'
                    AND dlp.amount != 0
                    AND dlp.id = '$ledgerId'";
        }

        $h_q = $db->getResults($h_sql);
        //Table 'dentalsl_site_dev.dental_ledger_history' doesn't exist
        if (!empty($h_q)) {
          foreach ($h_q as $h_r) {?>  
    <tr class="history_<?php echo $myarray['ledgerid']; ?>" style="display:none;">
      <td><?php echo $h_r['updated_at']; ?></td>
      <td><?php echo $h_r['service_date']; ?></td>
      <td><?php echo $h_r['name']; ?></td>
      <td><?php echo $h_r['description']; ?></td>
      <td><?php echo $h_r['amount']; ?></td>
      <td><?php echo $h_r['paid_amount']; ?></td>
      <td><?php if($h_r['updated_admin']!=''){
                echo $h_r['updated_admin'];
                }elseif($h_r['updated_user']!=''){
                echo $h_r['updated_user'];
                } ?>
      </td>
    </tr>
<?php 
          }
        } 
      }
    }
  }
}?>
    <tr class="tr_bg_h" style="color:#fff; font-weight: bold">
      <td></td>  
      <td></td>
      <td></td>
      <td style="color:#fff;" >Totals</td>
      <td style="color:#fff;">Charges</td>
      <td style="color:#fff;">Credits</td>
      <td style="color:#fff;">Adjustments</td>
      <td style="color:#fff;">Balance</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr class="tr_bg_h" style="color:#fff; font-weight: bold">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td style="color:#fff;"><?php echo (!empty($cur_cha) ? $cur_cha : '') ? number_format(st($cur_cha),2) : '0'; ?></td>
      <td style="color:#fff;"><?php echo (!empty($cur_pay) ? $cur_pay : '') ? number_format(st($cur_pay),2) : '0'; ?></td>
      <td style="color:#fff;"><?php echo (!empty($cur_adj) ? $cur_adj : '') ? number_format(st($cur_adj),2) : '0'; ?></td>
<?php 
if($_GET['sortdir']=='DESC'){ ?>
      <td style="color:#fff;"><?php echo (!empty($orig_bal) ? $orig_bal : '') ? number_format(st($orig_bal),2) : '0'; ?></td>
<?php 
}else{ ?>
      <td style="color:#fff;"><?php echo (!empty($cur_bal) ? $cur_bal : '') ? number_format(st($cur_bal),2) : '0'; ?></td>
<?php 
} ?>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="8">
        <center><button class="addButton" onclick="Javascript: loadPopup('view_ledger_record.php?pid=<?php echo $_GET['pid']; ?>');return false;">
        View Ledger Records
        </button></center>
      </td>
    </tr> 
  </table>
</form> 

<?php include 'ledger_summary_report.php'; ?>

<div id="popupContact" style="width:750px;">
  <a id="popupContactClose"><button>X</button></a>
  <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />  

<?php

// } else {  // end pt info check
//  print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
// }

?>

<?php include "includes/bottom.htm";?>
