<?php include "includes/top.htm";
require_once('includes/constants.inc');

if(isset($_POST['submit'])){


  $thorton_sql = "SELECT * FROM dental_thorton WHERE patientid = '".mysql_real_escape_string($_GET['ed'])."'";
  $thorton_q = mysql_query($thorton_sql);
  $thorton = mysql_fetch_assoc($thorton_q);

  $sleepstudies = "SELECT diagnosis FROM dental_summ_sleeplab WHERE (diagnosis IS NOT NULL && diagnosis != '') AND filename IS NOT NULL AND patiendid = '".$pid."' ORDER BY id DESC LIMIT 1;";
  $result = mysql_query($sleepstudies);
  $d = mysql_fetch_assoc($result);
  $diagnosis = $d['diagnosis'];
  //print_r($my_array);exit;
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
       . "  " . mysql_real_escape_string($_GET['ed']) . ", "
       . "  " . mysql_real_escape_string($_SESSION['docid']) . ", "
       . "  '" . mysql_real_escape_string($_SESSION['userid']) . "', "
       . "  '" . mysql_real_escape_string($_POST['company_id']) . "', "
       . "  '" . mysql_real_escape_string($_POST['ins_co_id']) . "', "
       . "  '" . mysql_real_escape_string($_POST['ins_phone']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_ins_group_id']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_ins_id']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_firstname']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_lastname']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_add1']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_add2']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_city']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_state']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_zip']) . "', "
       . "  '" . mysql_real_escape_string(date('Y-m-d', strtotime($_POST['patient_dob']))) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_cell_phone']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_home_phone']) . "', "
       . "  '" . mysql_real_escape_string($_POST['patient_email']) . "', "
       . "  '" . mysql_real_escape_string($_POST['diagnosis_id']) . "', "
       . "  '" . mysql_real_escape_string($_POST['hst_type']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_firstname']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_lastname']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_address']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_city']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_state']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_zip']) . "', "
       . "  '" . mysql_real_escape_string($_POST['provider_signature']) . "', "
       . "  '" . mysql_real_escape_string(date('Y-m-d', strtotime($_POST['provider_date']))) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_1']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_2']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_3']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_4']) . "', "
       . "  '" . mysql_real_escape_string($thorton['snore_5']) . "', ";

    $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
    $sign_q = mysql_query($sign_sql);
    $sign_r = mysql_fetch_assoc($sign_q);
    $user_sign = $sign_r['sign_notes'];
    if($user_sign || $_SESSION['docid']==$_SESSION['userid']){ 
      
       $sql .= DSS_HST_PENDING . ", 
		'".mysql_real_escape_string($_SESSION['userid'])."', now(), ";
    }else{
       $sql .= DSS_HST_REQUESTED . ", 
                null, null, ";
    }
      $sql .= "  now(), "
       . "  '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."' "
       . ")";
  $hst = mysql_query($sql);
  $hst_id = mysql_insert_id();


$sql = "select * from dental_q_sleep where patientid='".$pid."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);

if($epworthid <> '')
{
        $epworth_arr1 = split('~',$epworthid);

        foreach($epworth_arr1 as $i => $val)
        {
                $epworth_arr2 = explode('|',$val);

                $epid[$i] = $epworth_arr2[0];
                $epseq[$i] = $epworth_arr2[1];
        }
}


  $epworth_sql = "select * from dental_epworth where status=1 order by sortby";
  $epworth_my = mysql_query($epworth_sql);
  $epworth_number = mysql_num_rows($epworth_my);
  while($epworth_myarray = mysql_fetch_array($epworth_my))
  {
    if(@array_search($epworth_myarray['epworthid'],$epid) === false)
    {
      $chk = '';
    }
    else
    {
      $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];
    }

    if($chk != ''){
      $hst_sql = "INSERT INTO dental_hst_epworth SET
                        hst_id = '".mysql_real_escape_string($hst_id)."',
                        epworth_id = '".mysql_real_escape_string($epworth_myarray['epworthid'])."',
                        response = '".mysql_real_escape_string($chk)."',
                        adddate = now(),
                        ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
      mysql_query($hst_sql);
    }
  }
  ?>
    <script type="text/javascript">
      window.location = 'add_patient.php?ed=<?= $_GET['ed']; ?>&preview=1&addtopat=1&pid=<?= $_GET['ed']; ?>';
    </script>
  <?php

}


  $sql = "SELECT u.* FROM 
                dental_patients p 
                JOIN dental_users u ON p.docid = u.userid 
                WHERE p.patientid = '".mysql_real_escape_string($_GET['ed'])."'
                        ";
  $q = mysql_query($sql);
  $user_info = mysql_fetch_assoc($q);


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
       . "  p.patientid = ".$_GET['ed'];
  $my = mysql_query($sql);
  $pat = mysql_fetch_array($my);


?>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#" onsubmit="return check_fields(this);">
  <?php
                          $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                                        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysql_real_escape_string($_SESSION['docid'])."'
                                        WHERE h.id='".mysql_real_escape_string($_GET['hst_co'])."' AND h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                                 $bu_q = mysql_query($bu_sql);
                          $bu_r = mysql_fetch_assoc($bu_q); ?>
			<input type="hidden" name="company_id" value="<?= $bu_r['id']; ?>"  />
  <h2 align="center"><strong><?=$bu_r['name']; ?></strong></h2>
  <h3 align="center">Home Sleep Test Order Form For
	<?= $pat['patient_firstname']." ".$pat['patient_lastname']; ?>
  </h3>

  <p align="left">
    <label for="patient_name">Patient First Name</label>
    <input type="text" name="patient_firstname" id="patient_firstname" value="<?= $pat['patient_firstname']; ?>"/>
    <label for="patient_name">Patient Last Name</label>
    <input type="text" name="patient_lastname" id="patient_lastname" value="<?= $pat['patient_lastname'];?>" />
    <label for="patient_dob">DOB</label>
    <input type="text" name="patient_dob" id="patient_dob" value="<?= $pat['patient_dob'];?>" />
  </p>
  <p align="left">
    <label for="patient_address"> Address 1</label>
    <input type="text" name="patient_add1" id="patient_add1" value="<?= $pat['patient_add1'];?>" />
    <label for="patient_address"> Address 2</label>
    <input type="text" name="patient_add2" id="patient_add2" value="<?= $pat['patient_add2'];?>" />
    <label for="patient_city">City</label>
    <input type="text" name="patient_city" id="patient_city" value="<?= $pat['patient_city'];?>" />
    <label for="patient_state">State</label>
    <input type="text" name="patient_state" id="patient_state" value="<?= $pat['patient_state'];?>" />
    <label for="patient_zip">Zip</label>
    <input type="text" name="patient_zip" id="patient_zip" value="<?= $pat['patient_zip'];?>" />
  </p>
  <p align="left">
    <label for="patient_mobile_phone">Mobile phone</label>
    <input type="text" name="patient_cell_phone" id="patient_cell_phone" value="<?= $pat['patient_cell_phone'];?>"/>
    <label for="patient_home_phone">Home Phone</label>
    <input type="text" name="patient_home_phone" id="patient_home_phone" value="<?= $pat['patient_home_phone'];?>" />
    <label for="patient_email">Email</label>
    <input type="text" name="patient_email" id="patient_email" value="<?= $pat['patient_email']; ?>" />
  </p>
  <p align="left">
    <label for="patient_ins_name">Insurance Company</label>
	<select name="ins_co_id">
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            while($ins_contact_res = mysql_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($pat['p_m_ins_co'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>
                                
                                <?php } ?>
                                </select>

    <label for="ins_phone">Ins. Phone Number</label>
    <input type="text" name="ins_phone" id="ins_phone"  value="<?= $pat['ins_phone']; ?>" />
<br />
    <label for="patient_ins_id">ID Number</label>
    <input type="text" name="patient_ins_id" id="patient_ins_id" value="<?= $pat['patient_ins_id']; ?>" />
    <label for="patient_ins_group_id">Group Number</label>
    <input type="text" name="patient_ins_group_id" id="patient_ins_group_id" value="<?= $pat['patient_ins_group_id']; ?>" />
  </p>
<p>&nbsp;</p>
  <p align="left">Diganosis / Reason for Study  </p>
<hr />
  <p align="left">
  <?php
                                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                                                                           $ins_diag_my = mysql_query($ins_diag_sql);

                                                                                while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
                                                                                {
                                                                                ?>
                                                                                        <input type="radio" name="diagnosis_id" value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" >
                                                                                        <label> <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?></label>
                                                                                <?
                                                                                }?>

  </p>
  <p>&nbsp;</p>
  <p align="left">Home Sleep Diagnostic Testing</p>
  <hr />
  <p align="left">
    <input type="radio" name="hst_type" id="hst_order1" value="1" />
    <label for="hst_order">In-Home Sleep Test (2 nights)</label>
    <input type="radio" name="hst_type" id="hst_order2" value="2" />
    <label for="hst_order2">In-Home Sleep Test with PAP</label>
    <input type="radio" name="hst_type" id="hst_order3" value="3" />
    <label for="hst_order3">In-Home Sleep Test with OAT (titration)</label>
  </p>
  <p>&nbsp;</p>
  <p align="left">Provider Information</p>
  <hr />
  <p align="left">
  Deliver HST Results/Report via my <strong>DS3 Software</strong></p>
  <p align="left">
  <label for="provider_name">Provider First Name</label>
  <input type="text" name="provider_firstname" id="provider_firstname" value="<?= $user_info['first_name']; ?>" />
  <label for="provider_name">Provider Last Name</label>
  <input type="text" name="provider_lastname" id="provider_lastname" value="<?= $user_info['last_name']; ?>" />
  <label for="provider_phone">Phone</label>
  <input type="text" name="provider_phone" id="provider_phone" value="<?= $user_info['phone']; ?>" />
  </p>
  <p align="left">
    <label for="provider_address"> Address</label>
    <input type="text" name="provider_address" id="provider_address" value="<?= $user_info['address']; ?>" />
    <label for="provider_city">City</label>
    <input type="text" name="provider_city" id="provider_city" value="<?= $user_info['city']; ?>" />
    <br />
    <label for="provider_state">State</label>
    <input type="text" name="provider_state" id="provider_state" value="<?= $user_info['state']; ?>" />
    <label for="provider_zip">Zip</label>
    <input type="text" name="provider_zip" id="provider_zip" value="<?= $user_info['zip']; ?>" />
  </p>
  <p align="left">Please provider electronic communications via DS3 Software ONLY.</p>
  <p align="left">
    <label for="provider_signature">Provider Signature</label>
    <input type="text" name="provider_signature" id="provider_signature" />
    <label for="provider_date">Date</label>
    <input type="text" name="provider_date" id="provider_date" value="<?= date('m/d/Y'); ?>" />
  </p>
  <p align="left">Transmitted Electronically Via DS3 Software.</p>
  <p align="left">&nbsp;</p>
  <p align="left"><?= $bu_r['name']; ?></p>
  <p align="left">Office: <?= format_phone($bu_r['phone']); ?> - Fax: <?= format_phone($bu_r['fax']); ?> - Email: <?= $bu_r['email']; ?></p>

  <p><input type="submit" name="submit" value="Request HST" />
	<a style="float:right;" href="add_patient.php?ed=<?= $_GET['ed']; ?>&pid=<?=$_GET['ed'];?>" onclick="return confirm('Are you sure you want to cancel?');">Cancel</a>
</p>
</form>
<br />

<script type="text/javascript">
  function check_fields(f){
    var errors= new Array();
    if(f.patient_firstname.value==''){
      errors.push('First Name');
    }
    if(f.patient_lastname.value==''){
      errors.push('Last Name');
    }
    if(f.patient_dob.value==''){
      errors.push('DOB');
    }
    if(f.patient_add1.value=='' || f.patient_city.value=='' || f.patient_state.value=='' || f.patient_zip.value==''){
      errors.push('Address');
    }
    if($('input[name=diagnosis_id]:checked').size() == 0){
      errors.push('Diagnosis');
    }
    if($('input[name=hst_type]:checked').size() == 0){
      errors.push('Home Sleep Diagnostic Testing');
    }
    if(f.provider_firstname.value==''){
      errors.push('Provider First Name');
    }
    if(f.provider_lastname.value==''){
      errors.push('Provider Last Name');
    }
    if(f.provider_phone.value==''){
      errors.push('Provider Phone');
    }
    if(f.provider_address.value=='' || f.provider_city.value=='' || f.provider_state.value=='' || f.provider_zip.value==''){
      errors.push('Provider Address');
    }


    if(errors.length > 0){
      var a = "Following fields must be entered.\n"; 
      for (var i = 0; i < errors.length; i++) {
        a += errors[i]+"\n";
      } 
      alert(a);
      return false;
    }
    return true;
  }
</script>

<?php include "includes/bottom.htm";?>

