<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once 'includes/constants.inc';

$sql = "SELECT 
    i.company as 'ins_co', 'primary' as 'ins_rank', i.phone1 as 'ins_phone',
    p.p_m_ins_co, p.p_m_ins_grp as 'patient_ins_group_id', p.p_m_ins_id as 'patient_ins_id',
    p.firstname as 'patient_firstname', p.lastname as 'patient_lastname',
    p.add1 as 'patient_add1', p.add2 as 'patient_add2', p.city as 'patient_city',
    p.state as 'patient_state', p.zip as 'patient_zip', p.dob as 'patient_dob',
    p.cell_phone as 'patient_cell_phone', p.home_phone as 'patient_home_phone',
    p.email as 'patient_email',
    p.p_m_partyfname as 'insured_first_name', p.p_m_partylname as 'insured_last_name',
    p.ins_dob as 'insured_dob', d.npi as 'doc_npi', r.national_provider_id as 'referring_doc_npi', 
    d.medicare_npi as 'doc_medicare_npi', d.tax_id_or_ssn as 'doc_tax_id_or_ssn',
    tc.amount as 'trxn_code_amount', q2.confirmed_diagnosis as 'diagnosis_code',
    d.userid as 'doc_id', p.home_phone as 'patient_phone'
    FROM dental_patients p
    LEFT JOIN dental_contact r ON p.referred_by = r.contactid
    JOIN dental_contact i ON p.p_m_ins_co = i.contactid
    JOIN dental_users d ON p.docid = d.userid
    JOIN dental_transaction_code tc ON p.docid = tc.docid AND tc.transaction_code = 'E0486'
    LEFT JOIN dental_q_page2_pivot q2 ON p.patientid = q2.patientid
    WHERE p.patientid = ".(!empty($_GET['ed']) ? $_GET['ed'] : '');

$pat = $db->getRow($sql);
?>
<form id="hst_order_sleep_services" class="fullwidth" name="form1" method="post" action="#">
    <h2 align="center">
        <strong>Choose a Home Sleep Testing (HST) Company</strong>
    </h2>
    <h3 align="center">Home Sleep Test Company Form For
        <?php echo $pat['patient_firstname']." ".$pat['patient_lastname']; ?>
    </h3>
    <?php
    $bu_sql = "SELECT h.*, uhc.id as uhc_id FROM companies h 
        JOIN dental_user_hst_company uhc ON uhc.companyid=h.id AND uhc.userid='".$db->escape( $_SESSION['docid'])."'
        WHERE h.company_type='".DSS_COMPANY_TYPE_HST."' ORDER BY name ASC";

    $bu_q = $db->getResults($bu_sql);
    if ($bu_q) {
        foreach ($bu_q as $bu_r) {
            if ($bu_r['logo']) { ?>
                <img src="q_file/<?php echo $bu_r['logo']; ?>" />
                <br /><br />
                <?php
            } ?>
            <a href="hst_request.php?ed=<?php echo $_GET['ed'];?>&hst_co=<?php echo $bu_r['id']; ?>" class="button"><?php echo $bu_r['name']; ?></a><br />
            <br /><br />
            <?php
        }
    }
    ?>
</form>
<a style="float:right;margin-right:20px;" href="add_patient.php?ed=<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>&pid=<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : '');?>" onclick="return confirm('Are you sure you want to cancel?');">Cancel</a>
<br />
<?php include "includes/bottom.htm";?>
