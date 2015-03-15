<?php namespace Ds3\Legacy; ?><?php 
    include_once('admin/includes/main_include.php');
    include_once('includes/constants.inc');
    include("includes/sescheck.php");
    include_once('includes/authorization_functions.php');
    include_once 'admin/includes/claim_functions.php';
    include_once 'includes/claim_functions.php';
?>

<html>
    <head>
    </head>

    <body>
        <?php
            if(authorize((!empty($_POST['username']) ? $_POST['username'] : ''), (!empty($_POST['password']) ? $_POST['password'] : ''), DSS_USER_TYPE_ADMIN)){
                $csql = "SELECT *, REPLACE(i.total_charge,',','') AS amount_due FROM dental_insurance i WHERE i.insuranceid='".(!empty($_POST['claimid']) ? $_POST['claimid'] : '')."';";
                
                $claim = $db->getRow($csql);
                $psql = "SELECT * FROM dental_patients p WHERE p.patientid='".(!empty($_POST['patientid']) ? $_POST['patientid'] : '')."';";
                
                $pat = $db->getRow($psql);
                $msg = "Payments have been added.";
                echo "<br />";

                $sqlinsertqry = "INSERT INTO dental_ledger_payment (
                    `ledgerid` ,
                    `payment_date` ,
                    `entry_date` ,
                    `amount` ,
                    `payment_type` ,
                    `payer`,
                    `amount_allowed`,
                    `ins_paid`,
                    `deductible`,
                    `copay`,
                    `coins`,
                    `overpaid`,
                    `followup`,
                    `note`
                    ) VALUES ";
                $lsql = "SELECT * FROM dental_ledger WHERE primary_claim_id=".(!empty($_POST['claimid']) ? $_POST['claimid'] : '');

                $lq = $db->getResults($lsql);
                if ($lq) foreach ($lq as $row){
                    $id = $row['ledgerid'];
                    if($_POST['amount_'.$id]!=''){
                        $sqlinsertqry .= "(
                            ".$id.", 
                            '".date('Y-m-d', strtotime($_POST['payment_date_'.$id]))."', 
                            '".date('Y-m-d')."', 
                            '".str_replace(',','',$_POST['amount_'.$id])."', 
                            '".mysqli_real_escape_string($con,$_POST['payment_type'])."', 
                            '".mysqli_real_escape_string($con,$_POST['payer'])."',
                            '".mysqli_real_escape_string($con,$_POST['allowed'])."',
                            '".mysqli_real_escape_string($con,$_POST['ins_paid'])."',
                            '".mysqli_real_escape_string($con,$_POST['deductible'])."',
                            '".mysqli_real_escape_string($con,$_POST['copay'])."',
                            '".mysqli_real_escape_string($con,$_POST['coins'])."',
                            '".mysqli_real_escape_string($con,$_POST['overpaid'])."',
                            '".mysqli_real_escape_string($con,$_POST['followup'])."',
                            '".mysqli_real_escape_string($con,$_POST['note'])."'
                            ),";
                    }
                }

                $sqlinsertqry = substr($sqlinsertqry, 0, -1).";";
                $insqry = $db->query($sqlinsertqry);
                if(!empty($secsql)){
                    $paysql = "SELECT SUM(lp.amount) as payment
                                FROM dental_ledger_payment lp
                                JOIN dental_ledger dl on lp.ledgerid=dl.ledgerid
                                WHERE dl.primary_claim_id='".$_POST['claimid']."'
                                AND lp.payer='".DSS_TRXN_PAYER_PRIMARY."'";

                    $payr = $db->getRow($paysql);
                    //Determine new status
                    if($_POST['dispute']==1){
                        if($_FILES["attachment"]["name"]!=''){
                            $fname = $_FILES["attachment"]["name"];
                            $lastdot = strrpos($fname,".");
                            $name = substr($fname,0,$lastdot);
                            $extension = substr($fname,$lastdot+1);
                            $banner1 = $name.'_'.date('dmy_Hi');
                            $banner1 = str_replace(" ","_",$banner1);
                            $banner1 = str_replace(".","_",$banner1);
                            $banner1 .= ".".$extension;

                            @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../shared/q_file/".$banner1);
                            @chmod("../../../shared/q_file/".$banner1,0777);
                        }

                        $note_sql = "INSERT INTO dental_ledger_note SET
                            service_date = CURDATE(),
                            entry_date = CURDATE(),
                            private = 1,
                            docid = '".$_SESSION['docid']."',
                            patientid = '".$_POST['patientid']."',
                            producerid = '".$_SESSION['userid']."',
                            note = 'Insurance claim ".$_POST['claimid']." disputed because: ".mysqli_real_escape_string($con,(!empty($_POST['dispute_reason']) ? $_POST['dispute_reason'] : '')).".'";
                        
                        $db->query($note_sql);
                        if($claim['status']==DSS_CLAIM_SENT || $claim['status']==DSS_CLAIM_PAID_INSURANCE){
                            $new_status = DSS_CLAIM_DISPUTE;
                            $msg = 'Disputed Primary Insurance';

                            if($_FILES["attachment"]["name"]!=''){
                                $image_sql = "INSERT INTO dental_insurance_file (
                                    claimid,
                            		claimtype,
                            		filename,
                                    description,
                            		status,
                            		adddate,
                            		ip_address)
                                    VALUES (
                                    ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                    'primary',
                            		'".$banner1."',
                            		'".mysqli_real_escape_string($con,$_POST['dispute_reason'])."',
                            		".$new_status.",
                                    now(),
                                    '".s_for($_SERVER['REMOTE_ADDR'])."'
                                    )";

                                $db->query($image_sql);   
                            }
                        }elseif($claim['status']==DSS_CLAIM_SEC_SENT || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
                            $new_status = DSS_CLAIM_SEC_DISPUTE;
                            $msg = 'Disputed Secondary Insurance';

                            if($_FILES["attachment"]["name"]!=''){
                                $image_sql = "INSERT INTO dental_insurance_file (
                                    claimid,
                                    claimtype,
                                    filename,
                            		description,
                            		status,
                                    adddate,
                                    ip_address)
                                    VALUES (
                                    ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                    'secondary',
                                    '".$banner1."',
                            		'".mysqli_real_escape_string($con,$_POST['dispute_reason'])."',
                            		'".$new_status."',
                                    now(),
                                    '".s_for($_SERVER['REMOTE_ADDR'])."'
                                    )";

                                $db->query($image_sql);    
                            }
                        }elseif($claim['status']==DSS_CLAIM_PAID_PATIENT){
                            $new_status = DSS_CLAIM_PATIENT_DISPUTE;
                            $msg = 'Disputed Primary Insurance';

                            if($_FILES["attachment"]["name"]!=''){
                                $image_sql = "INSERT INTO dental_insurance_file (
                                    claimid,
                                    claimtype,
                                    filename,
                                    description,
                                    status,
                                    adddate,
                                    ip_address)
                                    VALUES (
                                    ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                    'primary',
                                    '".$banner1."',
                                    '".mysqli_real_escape_string($con,$_POST['dispute_reason'])."',
                                    '".$new_status."',
                                    now(),
                                    '".s_for($_SERVER['REMOTE_ADDR'])."'
                                    )";

                                $db->query($image_sql);
                            }
                        }elseif($claim['status']==DSS_CLAIM_PAID_SEC_PATIENT){
                            $new_status = DSS_CLAIM_SEC_PATIENT_DISPUTE;
                            $msg = 'Disputed Secondary Insurance';

                            if($_FILES["attachment"]["name"]!=''){
                                $image_sql = "INSERT INTO dental_insurance_file (
                                    claimid,
                                    claimtype,
                                    filename,
                                    description,
                                    status,
                                    adddate,
                                    ip_address)
                                    VALUES (
                                    ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                    'secondary',
                                    '".$banner1."',
                                    '".mysqli_real_escape_string($con,$_POST['dispute_reason'])."',
                                    '".$new_status."',
                                    now(),
                                    '".s_for($_SERVER['REMOTE_ADDR'])."'
                                    )";

                                $db->query($image_sql);
                            }
                        }
                    } else {
                        if($claim['status']==DSS_CLAIM_PAID_INSURANCE || $claim['status']==DSS_CLAIM_PAID_SEC_INSURANCE){
                            $msg = "Claim saved, status is PAID.";
                        }elseif($claim['status']==DSS_CLAIM_PENDING || $claim['status']==DSS_CLAIM_SEC_PENDING){
                            //SAVE WITHOUT CHANGING STATUS
                        }elseif($claim['status']==DSS_CLAIM_SENT){
                            if($_POST['close'] == 1){
                                if($pat['s_m_dss_file']==1 && $payr['payment']<$claim['amount_due']){ //secondary
                                    if($pat['p_m_ins_type']==1){ //medicare
	                                    if($pat['s_m_ins_ass']=="Yes"){
	                                        $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Sent".';
                                            $new_status = DSS_CLAIM_SEC_SENT;
	                                    }else{
                                            $msg = 'This patient has Medicare and Secondary Insurance. Secondary Insurance has been automatically filed by Medicare. Claim status will now be changed to "Secondary Paid to Patient".';
                                            $new_status = DSS_CLAIM_PAID_SEC_PATIENT;
                                        }
                                    }else{
	                                    $msg = 'Payment Successfully Added\n\nPrimary Insurance claim closed. This patient has secondary insurance and a claim has been auto-generated for the Secondary Insurer.';
                                        $new_status = DSS_CLAIM_SEC_PENDING;
	                                    $pat_sql = "select p.*, u.billing_company_id from dental_patients p 
                                            JOIN dental_users u ON u.userid=p.docid
                                            where p.patientid='".s_for($_POST['patientid'])."'";
             
                                        $pat_myarray = $db->getRow($pat_sql);
                                		$s_m_dss_file = $pat_myarray['s_m_dss_file'];
                                		$s_m_billing_id = $pat_myarray['billing_company_id'];
                                    }

	                                $secsql = "UPDATE dental_insurance SET 
                                        amount_paid=(SELECT SUM(lp.amount) 
                                        FROM dental_ledger_payment lp 
                                        JOIN dental_ledger dl on lp.ledgerid=dl.ledgerid 
                                        WHERE dl.primary_claim_id='".$_POST['claimid']."' 
                                        AND lp.payer='".DSS_TRXN_PAYER_PRIMARY."'),
                                        balance_due = CAST((REPLACE(total_charge,',','')-amount_paid) AS DECIMAL(6,2))
                                        WHERE insuranceid='".$_POST['claimid']."'";
                                } else {
                                    $new_status = DSS_CLAIM_PAID_INSURANCE;
                                }

                                if($_FILES["attachment"]["name"]!=''){
                                    $fname = $_FILES["attachment"]["name"];
                                    $lastdot = strrpos($fname,".");
                                    $name = substr($fname,0,$lastdot);
                                    $extension = substr($fname,$lastdot+1);
                                    $banner1 = $name.'_'.date('dmy_Hi');
                                    $banner1 = str_replace(" ","_",$banner1);
                                    $banner1 = str_replace(".","_",$banner1);
                                    $banner1 .= ".".$extension;

                                    @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../shared/q_file/".$banner1);
                                    @chmod("../../../shared/q_file/".$banner1,0777);

                                    $image_sql = "INSERT INTO dental_insurance_file (
                                        claimid,
                                        claimtype,
                                        filename,
                                    	status,
                                        adddate,
                                        ip_address)
                                        VALUES (
                                        ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                        'primary',
                                        '".$banner1."',
                                        '".$new_status."',
                                        now(),
                                        '".s_for($_SERVER['REMOTE_ADDR'])."'
                                        )";
                                    
                                    $db->query($image_sql);
                                }
                            }
                        }elseif($claim['status']==DSS_CLAIM_SEC_SENT && $_POST['close'] == 1){
                            $new_status = DSS_CLAIM_PAID_SEC_INSURANCE;

                            if($_FILES["attachment"]["name"]!=''){
                                $fname = $_FILES["attachment"]["name"];
                                $lastdot = strrpos($fname,".");
                                $name = substr($fname,0,$lastdot);
                                $extension = substr($fname,$lastdot+1);
                                $banner1 = $name.'_'.date('dmy_Hi');
                                $banner1 = str_replace(" ","_",$banner1);
                                $banner1 = str_replace(".","_",$banner1);
                                $banner1 .= ".".$extension;

                                @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../shared/q_file/".$banner1);
                                @chmod("../../../shared/q_file/".$banner1,0777);

                                $image_sql = "INSERT INTO dental_insurance_file (
                                    claimid,
                                    claimtype,
                                    filename,
		                            status,
                                    adddate,
                                    ip_address)
                                    VALUES (
                                    ".mysqli_real_escape_string($con,$_POST['claimid']).",
                                    'secondary',
                                    '".$banner1."',
                                    '".$new_status."',
                                    now(),
                                    '".s_for($_SERVER['REMOTE_ADDR'])."'
                                    )";

                                $db->query($image_sql);
                            }
                        }
                    }

                    if(isset($new_status)){
                        $x = "UPDATE dental_insurance SET status='".$new_status."'  ";
                        if($new_status == DSS_CLAIM_SENT || $new_status == DSS_CLAIM_SEC_SENT || $new_status == DSS_CLAIM_DISPUTE || $new_status == DSS_CLAIM_SEC_DISPUTE || $new_status == DSS_CLAIM_REJECTED || $new_status == DSS_CLAIM_SEC_REJECTED  || $new_status == DSS_CLAIM_PATIENT_DISPUTE || $new_status == DSS_CLAIM_SEC_PATIENT_DISPUTE){
                            $x .= ", mailed_date = NULL ";
                        }
                        if($new_status == DSS_CLAIM_SEC_PENDING){
                            $x .= ", s_m_billing_id = '".$s_m_billing_id."', s_m_dss_file = '".$s_m_dss_file."' ";
                        }
                        $x .= " WHERE insuranceid='".$_POST['claimid']."';";
                        
                        $db->query($x);
                        claim_status_history_update($_POST['claimid'], $new_status, $claim['status'], $_SESSION['userid']);
                    }

                    if(isset($_POST['close']) && $_POST['close']==1 && $new_status!=DSS_CLAIM_SEC_PENDING){
                        $new_status = DSS_CLAIM_PAID_INSURANCE;
                        $msg = 'Payment Successfully Added';
                        $x = "UPDATE dental_insurance SET status='".DSS_CLAIM_PAID_INSURANCE."'  WHERE insuranceid='".$_POST['claimid']."';";
                        
                        $db->query($x); 
                    }
                        $db->query($secsql);
                    }

                    if(!$insqry){
        ?>
                        <script type="text/javascript">
                            alert('Could not add ledger payments, please close this window and contact your system administrator');
                        </script>                               
                        <?php echo  $sqlinsertqry; ?>
        <?php
                    }else{
                        claim_history_update($_POST['claimid'], $_SESSION['userid'], $_SESSION['adminuserid']);
        ?>
                        <script type="text/javascript">
                            alert('<?php echo  $msg; ?>');
                            history.go(-1);
                        </script>
        <?php
                    }
            }else{ //NOT AUTHORIZED
        ?>
                <script type="text/javascript">
                    alert('YOU ARE NOT AUTHORIZED TO COMPLETE THIS REQUEST');
                    history.go(-1);
                </script>
        <?php
            }
        ?>
