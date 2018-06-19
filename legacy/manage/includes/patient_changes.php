<?php
namespace Ds3\Libraries\Legacy;

function num_patient_changes($pid)
{
    $db = new Db();

    $num_changes = 0;

    $psql = "SELECT * FROM dental_patients WHERE patientid='".$db->escape($pid)."'";
    $p = $db->getRow($psql);

    $csql = "SELECT * FROM dental_patients WHERE parent_patientid='".$db->escape($pid)."'";
    $cq = $db->getResults($csql);
    $c = (!empty($cq[0]) ? $cq[0] : []);

    $fields = [];
    $fields['firstname'] = "First Name";
    $fields['middlename'] = "Middle Name";
    $fields['lastname'] = "Last Name";
    $fields['preferred_name'] = "Preferred Name";
    $fields['email'] = "email";
    $fields['home_phone'] = "Home Phone";
    $fields['work_phone'] = "Work Phone";
    $fields['cell_phone'] = "Cell Phone";
    $fields['add1'] = "Address 1";
    $fields['add2'] = "Address 2";
    $fields['city'] = "City";
    $fields['state'] = "State";
    $fields['zip'] = "Zip";
    $fields['feet'] = "Height Feet";
    $fields['inches'] = "Height Inches";
    $fields['weight'] = "Weight";
    $fields['bmi'] = "BMI";

    $fields['dob'] = "Date of Birth";
    $fields['gender'] = "Gender";
    $fields['marital_status'] = "Marital Status";
    $fields['ssn'] = "Social Security #";
    $fields['preferredcontact'] = "Preferred Contact";
    $fields['emergency_name'] = "Emergency Name";
    $fields['emergency_relationship'] = "Emergency Relationship";
    $fields['emergency_number'] = "Emergency Number";
    $fields['p_m_relation'] = "Relationship to Insured";
    $fields['p_m_partyfname'] = "Insured First Name";
    $fields['p_m_partymname'] = "Insured Middle Name";
    $fields['p_m_partylname'] = "Insured Last Name";
    $fields['ins_dob'] = "Insured Date of Birth";
    $fields['p_m_ins_id'] = "Insurance ID";
    $fields['p_m_ins_grp'] = "Insurance Group";
    $fields['p_m_ins_plan'] = "Insurance Plan";
    $fields['p_m_ins_type'] = "Insurance Type";

    $fields['has_s_m_ins'] = "Has Secondary Insurance?";
    $fields['s_m_relation'] = "2nd Relationship to Insured";
    $fields['s_m_partyfname'] = "2nd Insured First Name";
    $fields['s_m_partymname'] = "2nd Insured Middle Name";
    $fields['s_m_partylname'] = "2nd Insured Last Name";
    $fields['ins2_dob'] = "2nd Insured Date of Birth";
    $fields['s_m_ins_id'] = "2nd Insurance ID";
    $fields['s_m_ins_grp'] = "2nd Insurance Group";
    $fields['s_m_ins_plan'] = "2nd Insurance Plan";
    $fields['s_m_ins_type'] = "2nd Insurance Type";
    $fields['employer'] = "Employer";
    $fields['emp_add1'] = "Employer Address 1";
    $fields['emp_add2'] = "Employer Address 2";
    $fields['emp_city'] = "Employer City";
    $fields['emp_state'] = "Employer State";
    $fields['emp_zip'] = "Employer Zip";
    $fields['emp_phone'] = "Employer Phone";
    $fields['emp_fax'] = "Employer Fax";

    $fields['docsleep'] = "Sleep MD";
    $fields['docpcp'] = "Primary Care Physician";
    $fields['docdentist'] = "Dentist";
    $fields['docent'] = "ENT";
    $fields['docmdother'] = "Other MD";

    if(count($cq) > 0){
        foreach($fields as $field => $label){
            if(trim($p[$field]) != trim($c[$field])){
                $num_changes++;
            }
        }
    }

    return $num_changes;
}
