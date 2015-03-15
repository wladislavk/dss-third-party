<?php namespace Ds3\Legacy; ?><?php
    include "includes/top.htm";
    include_once('includes/constants.inc');

    $sql = "SELECT * FROM dental_hst WHERE id='".mysqli_real_escape_string($con, $_GET['hst_id'])."'";

    $hst = $db->getRow($sql);
?>
    <link href="/manage/css/hst_view.css" rel="stylesheet" type="text/css">

    <form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#">
        <h2 align="center">
            <strong>Sleep Services</strong>
        </h2>
        <h3 align="center">Home Sleep Test Order Form</h3>
        <?php
            $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
                        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'
                        WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";

            $bu_q = $db->getResults($bu_sql);
            if ($bu_q) foreach ($bu_q as $bu_r) {
        ?>
                <input type="radio" <?php echo  ($bu_r['id']==$hst['company_id'])?'checked="checked"':'';?>  name="company_id" value="<?php echo  $bu_r['id']; ?>"  /> <?php echo  $bu_r['name']; ?><br />
        <?php
            }
        ?>

        <p align="left">
            <label for="patient_name">Patient First Name:</label>
            <?php echo  $hst['patient_firstname']; ?><br />
            <label for="patient_name">Patient Last Name:</label>
            <?php echo  $hst['patient_lastname'];?><br />
            <label for="patient_dob">DOB:</label>
            <?php echo  $hst['patient_dob'];?>
        </p>
        <p align="left">
            <label for="patient_address"> Address 1</label>
            <?php echo  $hst['patient_add1'];?><br />
            <label for="patient_address"> Address 2</label>
            <?php echo  $hst['patient_add2'];?><br />
            <label for="patient_city">City</label>
            <?php echo  $hst['patient_city'];?><br />
            <label for="patient_state">State</label>
            <?php echo  $hst['patient_state'];?><br />
            <label for="patient_zip">Zip</label>
            <?php echo  $hst['patient_zip'];?>
        </p>
        <p align="left">
            <label for="patient_mobile_phone">Mobile phone</label>
            <?php echo  $hst['patient_cell_phone'];?><br />
            <label for="patient_home_phone">Home Phone</label>
            <?php echo  $hst['patient_home_phone'];?><br />
            <label for="patient_email">Email</label>
            <?php echo  $hst['patient_email']; ?>
        </p>
        <p align="left">
            <label for="patient_ins_name">Insurance Company</label>

            <?php
              $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$_SESSION['docid']."' AND contactid='".mysqli_real_escape_string($con, $hst['ins_co_id'])."'";
              
              $ins_contact_res = $db->getRow($ins_contact_qry);
            ?>

            <?php echo addslashes($ins_contact_res['company']); ?>                       
            <br />
            <label for="ins_phone">Ins. Phone Number</label>
            <?php echo  $hst['ins_phone']; ?><br />
            <label for="patient_ins_id">ID Number</label>
            <?php echo  $hst['patient_ins_id']; ?><br />
            <label for="patient_ins_group_id">Group Number</label>
            <?php echo  $hst['patient_ins_group_id']; ?>
        </p>
        <p>&nbsp;</p>
        <p align="left">Diganosis / Reason for Study  </p>
        <hr />
        <p align="left">
            <?php
                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby AND ins_diagnosisid='".mysqli_real_escape_string($con, $hst['diagnosis_id'])."'";

                $ins_diag_myarray = $db->getRow($ins_diag_sql);
            ?>
            <label> <?php echo st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?></label>
        </p>
        <p>&nbsp;</p>
        <p align="left">Home Sleep Diagnostic Testing</p>
        <hr />
        <p align="left">

        <?php
            switch($hst['hst_order']) {
                case 1:
        ?>
                    <label for="hst_order">In-Home Sleep Test (2 nights)</label>
        <?php
        	        break;
                case 2:
        ?>
                    <label for="hst_order2">In-Home Sleep Test with PAP</label>
        <?php
                    break;
                case 3:
        ?>
                    <label for="hst_order3">In-Home Sleep Test with OAT (titration)</label>
        <?php
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
            <?php echo  $hst['provider_firstname']; ?><br />
            <label for="provider_name">Provider Last Name</label>
            <?php echo  $hst['provider_lastname']; ?><br />
            <label for="provider_phone">Phone</label>
            <?php echo  $hst['provider_phone']; ?>
        </p>
        <p align="left">
            <label for="provider_address"> Address</label>
            <?php echo  $hst['address']; ?><br />
            <label for="provider_city">City</label>
            <?php echo  $hst['city']; ?><br />
            <label for="provider_state">State</label>
            <?php echo  $hst['state']; ?><br />
            <label for="provider_zip">Zip</label>
            <?php echo  $hst['zip']; ?>
        </p>
        <p align="left">Please provider electronic communications via DS3 Software ONLY.</p>
        <p align="left">
        <label for="provider_signature">Provider Signature</label>
        <?php echo $hst['provider_signature']; ?><br />
        <label for="provider_date">Date</label>
        <?php echo (($hst['provider_date'])?date('m/d/Y', strtotime($hst['provider_date'])):''); ?>
        </p>
        <p align="left">Transmitted Electronically Via DS3 Software.</p>
        <p align="left">&nbsp;</p>
        <p align="left">Sleep Services</p>
        <p align="left">Office: 888-322-7108 - Fax:888-800-3851 - Email: Orders@HSTSleepServices.com</p>
    </form>
    <br />

<?php include "includes/bottom.htm";?>
