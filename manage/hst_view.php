<?php include "includes/top.htm";
require_once('includes/constants.inc');

$sql = "SELECT * FROM dental_hst WHERE id='".mysql_real_escape_string($_GET['hst_id'])."'";
$q = mysql_query($sql);
$hst = mysql_fetch_assoc($q);
?>
<style type="text/css">
  label{
    font-weight:bold;
  }
</style>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#">
  <h2 align="center"><strong>Sleep Services</strong></h2>
  <h3 align="center">Home Sleep Test Order Form</h3>
  <?php
                          $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                                        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysql_real_escape_string($_SESSION['docid'])."'
                                        WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";
                                 $bu_q = mysql_query($bu_sql);
                          while($bu_r = mysql_fetch_assoc($bu_q)){ ?>
                            <input type="radio" <?= ($bu_r['id']==$hst['company_id'])?'checked="checked"':'';?>  name="company_id" value="<?= $bu_r['id']; ?>"  /> <?= $bu_r['name']; ?><br />
                          <?php } ?>

  <p align="left">
    <label for="patient_name">Patient First Name:</label>
    <?= $hst['patient_firstname']; ?><br />
    <label for="patient_name">Patient Last Name:</label>
    <?= $hst['patient_lastname'];?><br />
    <label for="patient_dob">DOB:</label>
    <?= $hst['patient_dob'];?>
  </p>
  <p align="left">
    <label for="patient_address"> Address 1</label>
    <?= $hst['patient_add1'];?><br />
    <label for="patient_address"> Address 2</label>
    <?= $hst['patient_add2'];?><br />
    <label for="patient_city">City</label>
    <?= $hst['patient_city'];?><br />
    <label for="patient_state">State</label>
    <?= $hst['patient_state'];?><br />
    <label for="patient_zip">Zip</label>
    <?= $hst['patient_zip'];?>
  </p>
  <p align="left">
    <label for="patient_mobile_phone">Mobile phone</label>
    <?= $hst['patient_cell_phone'];?><br />
    <label for="patient_home_phone">Home Phone</label>
    <?= $hst['patient_home_phone'];?><br />
    <label for="patient_email">Email</label>
    <?= $hst['patient_email']; ?>
  </p>
  <p align="left">
    <label for="patient_ins_name">Insurance Company</label>
                            <?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."' AND contactid='".mysql_real_escape_string($hst['ins_co_id'])."'";
                            $ins_contact_qry_run = mysql_query($ins_contact_qry);
                            $ins_contact_res = mysql_fetch_array($ins_contact_qry_run);
                            ?>
                            <?php echo addslashes($ins_contact_res['company']); ?>
                                
    <br />
    <label for="ins_phone">Ins. Phone Number</label>
    <?= $hst['ins_phone']; ?><br />
    <label for="patient_ins_id">ID Number</label>
    <?= $hst['patient_ins_id']; ?><br />
    <label for="patient_ins_group_id">Group Number</label>
    <?= $hst['patient_ins_group_id']; ?>
  </p>
<p>&nbsp;</p>
  <p align="left">Diganosis / Reason for Study  </p>
<hr />
  <p align="left">
  <?php
                                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby AND ins_diagnosisid='".mysql_real_escape_string($hst['diagnosis_id'])."'";
                                                                           $ins_diag_my = mysql_query($ins_diag_sql);

                                                                                $ins_diag_myarray = mysql_fetch_array($ins_diag_my);
                                                                                ?>
                                                                                        <label> <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?></label>

  </p>
  <p>&nbsp;</p>
  <p align="left">Home Sleep Diagnostic Testing</p>
  <hr />
  <p align="left">
  <?php
    switch($hst['hst_order']){
     case 1:
    	?><label for="hst_order">In-Home Sleep Test (2 nights)</label><?php
 	break;
     case 2:
        ?><label for="hst_order2">In-Home Sleep Test with PAP</label><?php
	break;
     case 3:
        ?><label for="hst_order3">In-Home Sleep Test with OAT (titration)</label><?php
        break;
   }
  ?>
  </p>
  <p>&nbsp;</p>
  <p align="left">Provider Information</p>
  <hr />
  <p align="left">
  Deliver HST Results/Report via my <strong>DS3 Software</strong></p>
  <p align="left">
  <label for="provider_name">Provider First Name</label>
  <?= $hst['provider_firstname']; ?><br />
  <label for="provider_name">Provider Last Name</label>
  <?= $hst['provider_lastname']; ?><br />
  <label for="provider_phone">Phone</label>
  <?= $hst['provider_phone']; ?>
  </p>
  <p align="left">
    <label for="provider_address"> Address</label>
    <?= $hst['address']; ?><br />
    <label for="provider_city">City</label>
    <?= $hst['city']; ?><br />
    <label for="provider_state">State</label>
    <?= $hst['state']; ?><br />
    <label for="provider_zip">Zip</label>
    <?= $hst['zip']; ?>
  </p>
  <p align="left">Please provider electronic communications via DS3 Software ONLY.</p>
  <p align="left">
    <label for="provider_signature">Provider Signature</label>
    <?= $hst['provider_signature']; ?><br />
    <label for="provider_date">Date</label>
    <?= (($hst['provider_date'])?date('m/d/Y', strtotime($hst['provider_date'])):''); ?>
  </p>
  <p align="left">Transmitted Electronically Via DS3 Software.</p>
  <p align="left">&nbsp;</p>
  <p align="left">Sleep Services</p>
  <p align="left">Office: 888-322-7108 - Fax:888-800-3851 - Email: Orders@HSTSleepServices.com</p>

</form>
<br />
<?php include "includes/bottom.htm";?>

