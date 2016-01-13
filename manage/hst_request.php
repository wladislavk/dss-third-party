<?php namespace Ds3\Libraries\Legacy; ?><?php include "includes/top.htm";
require_once('includes/constants.inc');

if(isset($_POST['submit'])){

  $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '".mysqli_real_escape_string($con,$_GET['ed'])."'";
  $thorton = $db->getRow($thorton_sql);

  $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";
  $d = $db->getRow($sleepstudies);
  $diagnosis = $d['diagnosis'];
  //print_r($my_array);trigger_error("Exit called", E_USER_ERROR);
  $sd = date('Y-m-d H:i:s');
  $sql = "INSERT INTO dental_hst ("
       . "  patient_id, doc_id, user_id, company_id, ins_co_id, ins_phone, patient_ins_group_id, "
       . "  patient_ins_id, patient_firstname, patient_lastname, patient_add1, "
       . "  patient_add2, patient_city, patient_state, patient_zip, patient_dob, "
       . "  patient_cell_phone, patient_home_phone, patient_email, "
       . "  diagnosis_id, hst_type, provider_firstname, provider_lastname, "
       . "  provider_address, provider_city, provider_state, provider_zip, "
       . "  provider_signature, provider_date, "
       . "  snore_1, snore_2, snore_3, snore_4, snore_5, "
       . "  status, authorized_id, authorizeddate, adddate, ip_address "
       . ") VALUES ("
       . "  " . mysqli_real_escape_string($con,$_GET['ed']) . ", "
       . "  " . mysqli_real_escape_string($con,$_SESSION['docid']) . ", "
       . "  '" . mysqli_real_escape_string($con,$_SESSION['userid']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['company_id']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['ins_co_id']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['ins_phone']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_ins_group_id']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_ins_id']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_firstname']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_lastname']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_add1']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_add2']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_city']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_state']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_zip']) . "', "
       . "  '" . mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['patient_dob']))) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_cell_phone']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_home_phone']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['patient_email']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['diagnosis_id']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['hst_type']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_firstname']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_lastname']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_address']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_city']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_state']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_zip']) . "', "
       . "  '" . mysqli_real_escape_string($con,$_POST['provider_signature']) . "', "
       . "  '" . mysqli_real_escape_string($con,date('Y-m-d', strtotime($_POST['provider_date']))) . "', "
       . "  '" . mysqli_real_escape_string($con,$thorton['snore_1']) . "', "
       . "  '" . mysqli_real_escape_string($con,$thorton['snore_2']) . "', "
       . "  '" . mysqli_real_escape_string($con,$thorton['snore_3']) . "', "
       . "  '" . mysqli_real_escape_string($con,$thorton['snore_4']) . "', "
       . "  '" . mysqli_real_escape_string($con,$thorton['snore_5']) . "', ";

  $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
  $sign_r = $db->getRow($sign_sql);
  $user_sign = $sign_r['sign_notes'];
  if($user_sign || $_SESSION['docid']==$_SESSION['userid']){ 
     $sql .= DSS_HST_PENDING . ", 
    		'".mysqli_real_escape_string($con,$_SESSION['userid'])."', now(), ";
  }else{
     $sql .= DSS_HST_REQUESTED . ", 
              null, null, ";
  }
  $sql .= "  now(), "
         . "  '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."' "
         . ")";
  $hst_id = $db->getInsertId($sql);

  $sql = "select * from dental_q_sleep where patientid='".$pid."'";
  $myarray = $db->getRow($sql);

  $q_sleepid = st($myarray['q_sleepid']);
  $epworthid = st($myarray['epworthid']);
  $analysis = st($myarray['analysis']);

  if($epworthid <> '')
  {
    $epworth_arr1 = split('~',$epworthid);

    foreach($epworth_arr1 as $i => $val){
      $epworth_arr2 = explode('|',$val);
      $epid[$i] = $epworth_arr2[0];
      $epseq[$i] = $epworth_arr2[1];
    }
  }


  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = $db->getResults($epworth_sql);
  $epworth_number = count($epworth_my);
  foreach ($epworth_my as $epworth_myarray) {
    if(@array_search($epworth_myarray['epworthid'],$epid) === false){
      $chk = '';
    }else{
      $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
    }

    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysqli_real_escape_string($con,$hst_id)."',
                        epworth_id = '".mysqli_real_escape_string($con,$epworth_myarray['epworthid'])."',
                        response = '".mysqli_real_escape_string($con,$chk)."',
                        adddate = now(),
                        ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
      $db->query($hst_sql);
    }
  }

  $c_sql = "SELECT c.email from companies c WHERE c.id='".$_POST['company_id']."'";
  $c = $db->getRow($c_sql);

  if($c['email'] != ''){
		$headers = 'From: Dental Sleep Solutions <noreply@dentalsleepsolutions.com>' . "\r\n" .
                'Content-type: text/html' ."\r\n" .
                'Reply-To: noreply@dentalsleepsolutions.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    $subject = "New HST Order Created";
  	$user_sql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
  	$user = $db->getRow($user_sql);
		$m = "<html><body><center>
  <table width='600'>
  <tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_header_fo.png' /></td></tr>
  <tr><td width='400'>
  <h2>New HST Order Created</h2>
  <p>A new HST order has been submitted to you by ".$user['first_name']." ".$user['last_name']." at ".$user['mailing_practice']." on ".date('m/d/Y h:i p').".</p>

  <p>Please log in to your DS3 backoffice account to check the details:<a href='http://".$_SERVER['HTTP_HOST']."/manage/admin'>http://".$_SERVER['HTTP_HOST']."/manage/admin</a></p>
  </td><td><img alt='Logo' src='".$_SERVER['HTTP_HOST']."/reg/images/email/reg_logo.gif' /></td></tr>
  <tr><td colspan='2'><img alt='A message from your healthcare provider' src='".$_SERVER['HTTP_HOST']."/reg/images/email/email_footer_fo.png' /></td></tr>
  </table>
  </center><span style=\"font-size:12px;\">This email was sent by Dental Sleep Solutions&reg; on behalf of ".$ur['mailing_practice'].". ".DSS_EMAIL_FOOTER."</span></body></html>";

    mail($c['email'], $subject, $m, $headers);
  }?>
<script type="text/javascript">
  window.location = 'add_patient.php?ed=<?php echo $_GET['ed']; ?>&preview=1&addtopat=1&pid=<?php echo $_GET['ed']; ?>';
</script>
    <?php
}

$sql = "SELECT u.* FROM 
          dental_patients p 
          JOIN dental_users u ON p.docid = u.userid 
          WHERE p.patientid = '".mysqli_real_escape_string($con,!empty($_GET['ed']) ? $_GET['ed'] : '')."'
                      ";

$user_info = $db->getRow($sql);

$sql = "SELECT "
     . "  i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone', "
     . "  p.p_m_ins_co, p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id', "
     . "  p.firstname as 'patient_firstname', p.lastname as 'patient_lastname', "
     . "  p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city', "
     . "  p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob', "
     . "  p.cell_phone as 'patient_cell_phone', p.home_phone as 'patient_home_phone', "
     . "  p.email as 'patient_email', "
     . "  p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name', "
     . "  p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', "       . "  d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn', "
     . "  tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code', "
     . "  d.userid as 'doc_id', p.home_phone as 'patient_phone'  "
     . "FROM "
     . "  dental_patients p  "
     . "  LEFT JOIN dental_contact r ON p.referred_by = r.contactid  "
     . "  LEFT JOIN dental_contact i ON p.p_m_ins_co = i.contactid "
     . "  JOIN dental_users d ON p.docid = d.userid "
     . "  LEFT JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486' "
     . "  LEFT JOIN dental_q_page2 q2 ON p.patientid = q2.patientid  "
     . "WHERE "
     . "  p.patientid = ".(!empty($_GET['ed']) ? $_GET['ed'] : '');

$pat = $db->getRow($sql);

?>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#" onsubmit="return check_fields(this);">
<?php
$bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
            JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'
            WHERE h.id='".mysqli_real_escape_string($con,(!empty($_GET['hst_co']) ? $_GET['hst_co'] : ''))."' AND h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
$bu_r = $db->getRow($bu_sql);

$diagnosticNightsLimit = 2;
$oatNightsLimit = 3;

?>
    <input type="hidden" name="company_id" value="<?php echo $bu_r['id']; ?>" />
    <input type="hidden" name="provider_signature" id="provider_signature" value="1" />
    <h2 align="center"><strong><?php echo $bu_r['name']; ?></strong></h2>
    <h3 align="center">Home Sleep Test Order Form For
        <?php echo $pat['patient_firstname']." ".$pat['patient_lastname']; ?>
    </h3>
    <ul class="frmhead">
        <li>
            <label class="desc">Patient Information</label>
            <hr />
            <span>
                <input type="text" name="patient_firstname" id="patient_firstname" value="<?php echo $pat['patient_firstname']; ?>"/>
                <label for="patient_firstname">Patient First Name</label>
            </span>
            <span>
                <input type="text" name="patient_lastname" id="patient_lastname" value="<?php echo $pat['patient_lastname'];?>" />
                <label for="patient_lastname">Patient Last Name</label>
            </span>
            <span>
                <input type="text" name="patient_dob" id="patient_dob" value="<?php echo $pat['patient_dob'];?>" />
                <label for="patient_dob">DOB</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_add1" id="patient_add1" value="<?php echo $pat['patient_add1'];?>" />
                <label for="patient_add1"> Address 1</label>
            </span>
            <span>
                <input type="text" name="patient_add2" id="patient_add2" value="<?php echo $pat['patient_add2'];?>" />
                <label for="patient_add2"> Address 2</label>
            </span>
            <span>
                <input type="text" name="patient_city" id="patient_city" value="<?php echo $pat['patient_city'];?>" />
                <label for="patient_city">City</label>
            </span>
            <span>
                <input type="text" name="patient_state" id="patient_state" value="<?php echo $pat['patient_state'];?>" />
                <label for="patient_state">State</label>
            </span>
            <span>
                <input type="text" name="patient_zip" id="patient_zip" value="<?php echo $pat['patient_zip'];?>" />
                <label for="patient_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="patient_cell_phone" id="patient_cell_phone" value="<?php echo $pat['patient_cell_phone'];?>"/>
                <label for="patient_cell_phone">Mobile phone</label>
            </span>
            <span>
                <input type="text" name="patient_home_phone" id="patient_home_phone" value="<?php echo $pat['patient_home_phone'];?>" />
                <label for="patient_home_phone">Home Phone</label>
            </span>
            <span>
                <input type="text" name="patient_email" id="patient_email" value="<?php echo $pat['patient_email']; ?>" />
                <label for="patient_email">Email</label>
            </span>
        </li>
        <li>
            <span>
                <select name="ins_co_id" id="ins_co_id">
                    <?php

                    $ins_contact_qry = "SELECT * FROM dental_contact WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                    $ins_contact_qry_run = $db->getResults($ins_contact_qry);

                    foreach ($ins_contact_qry_run as $ins_contact_res) { ?>
                        <option value="<?php echo (!empty($ins_contact_res['contactid']) ? $ins_contact_res['contactid'] : ''); ?>"
                            <?= !empty($ins_contact_res['contactid']) && $pat['p_m_ins_co'] == $ins_contact_res['contactid'] ? "selected=\"selected\"" : '' ?>>
                            <?php echo addslashes(!empty($ins_contact_res['company']) ? $ins_contact_res['company'] : ''); ?>
                        </option>
                    <?php } ?>
                </select>
                <label for="ins_co_id">Insurance Company</label>
            </span>
            <span>
                <input type="text" name="ins_phone" id="ins_phone"  value="<?= $pat['ins_phone']; ?>" />
                <label for="ins_phone">Ins. Phone Number</label>
            </span>
            <span>
                <input type="text" name="patient_ins_id" id="patient_ins_id" value="<?= $pat['patient_ins_id']; ?>" />
                <label for="patient_ins_id">ID Number</label>
            </span>
            <span>
                <input type="text" name="patient_ins_group_id" id="patient_ins_group_id" value="<?= $pat['patient_ins_group_id']; ?>" />
                <label for="patient_ins_group_id">Group Number</label>
            </span>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Diganosis / Reason for Study</label>
            <hr />
            <?php

            $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
            $ins_diag_my = $db->getResults($ins_diag_sql);

            foreach ($ins_diag_my as $ins_diag_myarray) { ?>
                <input type="radio" name="diagnosis_id" value="<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>"
                    id="diagnosis-<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>">
                <label for="diagnosis-<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>">
                    <?php echo st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                </label>
                <br />
            <?php } ?>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Home Sleep Diagnostic Testing</label>
            <hr />
            <input type="radio" name="hst_type" id="hst_order1" value="1" />
            <label for="hst_order1">
                In-Home Diagnostic Sleep Test
                &mdash;
                number of nights:
            </label>
            <select name="hst_1_nights">
                <?php for ($n=1;$n<=$diagnosticNightsLimit;$n++) { ?>
                    <option <?= $n == 2 ? 'selected' : '' ?>><?= $n ?></option>
                <?php } ?>
            </select>
        </li>
        <li>
            <input type="radio" name="hst_type" id="hst_order2" value="2" />
            <label for="hst_order2">In-Home Sleep Test with PAP</label>
        </li>
        <li>
            <input type="radio" name="hst_type" id="hst_order3" value="3" />
            <label for="hst_order3">
                In-Home Sleep Test with OAT (titration)
                &mdash;
                number of nights:
            </label>
            <select name="hst_3_nights">
                <?php for ($n=1;$n<=$oatNightsLimit;$n++) { ?>
                    <option <?= $n == 1 ? 'selected' : '' ?>><?= $n ?></option>
                <?php } ?>
            </select>
            <p class="container" style="display:none;">
                <span>Device position:</span>
                <span class="field-position">
                    <input type="text" id="device-position-0" name="hst_device_position[0]" />
                    <label for="device-position-0">For night 1</label>
                </span>
            </p>
        </li>
    </ul>
    <p></p>
    <ul class="frmhead">
        <li>
            <label class="desc">Provider Information</label>
            <hr />
            <label>Deliver HST Results/Report via my <strong>DS3 Software</strong></label>
        </li>
        <li>
            <span>
                <input type="text" name="provider_firstname" id="provider_firstname" value="<?php echo $user_info['first_name']; ?>" />
                <label for="provider_firstname">Provider First Name</label>
            </span>
            <span>
                <input type="text" name="provider_lastname" id="provider_lastname" value="<?php echo $user_info['last_name']; ?>" />
                <label for="provider_lastname">Provider Last Name</label>
            </span>
            <span>
                <input type="text" name="provider_phone" id="provider_phone" value="<?php echo $user_info['phone']; ?>" />
                <label for="provider_phone">Phone</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_address" id="provider_address" value="<?php echo $user_info['address']; ?>" />
                <label for="provider_address"> Address</label>
            </span>
            <span>
                <input type="text" name="provider_city" id="provider_city" value="<?php echo $user_info['city']; ?>" />
                <label for="provider_city">City</label>
            </span>
            <span>
                <input type="text" name="provider_state" id="provider_state" value="<?php echo $user_info['state']; ?>" />
                <label for="provider_state">State</label>
            </span>
            <span>
                <input type="text" name="provider_zip" id="provider_zip" value="<?php echo $user_info['zip']; ?>" />
                <label for="provider_zip">Zip</label>
            </span>
        </li>
        <li>
            <span>
                <input type="text" name="provider_date" id="provider_date" value="<?php echo date('m/d/Y'); ?>" />
                <label for="provider_date">Date</label>
            </span>
        </li>
        <li>
            <p>
                <label class="desc">Transmitted Electronically Via DS3 Software.</label>
            </p>
            <label class="desc"><?= e($bu_r['name']) ?></label>
        </li>
        <li>
            Office: <?= format_phone($bu_r['phone']) ?>
            -
            Fax: <?= format_phone($bu_r['fax']) ?>
            -
            Email: <?= e($bu_r['email']) ?>
        </li>
    </ul>
    <p>
        <strong>By the below order HST button you are providing a digital signature ordering the HST</strong>
    </p>
    <p>
        <input class="button" type="submit" name="submit" value="Request HST" />
        <a class="red" style="float:right;" href="add_patient.php?ed=<?php echo $_GET['ed']; ?>&pid=<?php echo $_GET['ed'];?>"
            onclick="return confirm('Are you sure you want to cancel?');">Cancel</a>
    </p>
</form>
<br />

<script src="js/hst_request.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        var $hstRadioButtons = $('[name=hst_type]:radio'),
            $hstContainers = $hstRadioButtons.closest('li');

        $hstRadioButtons.change(function(){
            $hstContainers.find('.container').hide();
            $(this).closest('li').find('.container').show();
        });

        $('[name=hst_3_nights]').change(function(){
            var $this = $(this),
                $container = $hstContainers.last().find('.container'),
                $fields = $container.find('span.field-position'),
                $first = $fields.first(),
                $rest = $fields.not(':eq(0)'),
                $clone;

            $rest.remove();

            for (var n=1;n<$this.val();n++) {
                $clone = $first.clone();
                $clone.find('input').attr('id', 'device-position-' + n).attr('name', 'hst_device_position[' + n + ']');
                $clone.find('label').attr('for', 'device-position-' + n).text('For night ' + (n + 1));
                $clone.appendTo($container);
            }
        });
    });
</script>

<?php include "includes/bottom.htm";?>

