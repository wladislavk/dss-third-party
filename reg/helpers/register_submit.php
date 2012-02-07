<?php include '../../manage/admin/includes/config.php'; ?>
<?php
        $chksql = "SELECT patientid FROM dental_patients WHERE parent_patientid='".mysql_escape_string($_SESSION['pid'])."'";
        $chkq = mysql_query($chksql);
	$chkc = mysql_num_rows($chkq);
        $dob = ($_POST['dob_month'] != '' && $_POST['dob_day'] != '' && $_POST['dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['dob_month'],$_POST['dob_day'],$_POST['dob_year'])):'';
        $ins_dob = ($_POST['ins_dob_month'] != '' && $_POST['ins_dob_day'] != '' && $_POST['ins_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins_dob_month'],$_POST['ins_dob_day'],$_POST['ins_dob_year'])):'';
        $ins2_dob = ($_POST['ins2_dob_month'] != '' && $_POST['ins2_dob_day'] != '' && $_POST['ins2_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins2_dob_month'],$_POST['ins2_dob_day'],$_POST['ins2_dob_year'])):'';
        if($chkc == 0){
        $sql = "INSERT INTO dental_patients set
                firstname = '".mysql_real_escape_string($_POST['firstname'])."',
                middlename= '".mysql_real_escape_string($_POST['middlename'])."',
                lastname= '".mysql_real_escape_string($_POST['lastname'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                home_phone = '".mysql_real_escape_string($_POST['home_phone'])."',
                work_phone = '".mysql_real_escape_string($_POST['work_phone'])."',
                cell_phone = '".mysql_real_escape_string($_POST['cell_phone'])."',
                add1 = '".mysql_real_escape_string($_POST['add1'])."',
                add2 = '".mysql_real_escape_string($_POST['add2'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
                dob = '".mysql_real_escape_string($dob)."',
                gender = '".mysql_real_escape_string($_POST['gender'])."',
                marital_status = '".mysql_real_escape_string($_POST['marital_status'])."',
                partner_name = '".mysql_real_escape_string($_POST['partner_name'])."',
                ssn = '".mysql_real_escape_string($_POST['ssn'])."',
                patient_notes = '".mysql_real_escape_string($_POST['patient_notes'])."',
                preferredcontact = '".mysql_real_escape_string($_POST['preferredcontact'])."',
                emergency_name = '".mysql_real_escape_string($_POST['emergency_name'])."',
                emergency_relationship = '".mysql_real_escape_string($_POST['emergency_relationship'])."',
                emergency_number = '".mysql_real_escape_string($_POST['emergency_number'])."',
                p_m_relation = '".mysql_real_escape_string($_POST['p_m_relation'])."',
                p_m_partyfname = '".mysql_real_escape_string($_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysql_real_escape_string($_POST['p_m_partymname'])."',
                p_m_partylname = '".mysql_real_escape_string($_POST['p_m_partylname'])."',
                ins_dob = '".mysql_real_escape_string($ins_dob)."',
                p_m_ins_co = '".mysql_real_escape_string($_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysql_real_escape_string($_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysql_real_escape_string($_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysql_real_escape_string($_POST['p_m_ins_plan'])."',
                p_m_ins_type = '".mysql_real_escape_string($_POST['p_m_ins_type'])."',
                p_m_ins_ass = '".mysql_real_escape_string($_POST['p_m_ins_ass'])."',
                has_s_m_ins = '".mysql_real_escape_string($_POST['has_s_m_ins'])."',
                s_m_relation = '".mysql_real_escape_string($_POST['s_m_relation'])."',
                s_m_partyfname = '".mysql_real_escape_string($_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysql_real_escape_string($_POST['s_m_partymname'])."',
                s_m_partylname = '".mysql_real_escape_string($_POST['s_m_partylname'])."',
                ins2_dob = '".mysql_real_escape_string($ins2_dob)."',
                s_m_ins_co = '".mysql_real_escape_string($_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysql_real_escape_string($_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysql_real_escape_string($_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysql_real_escape_string($_POST['s_m_ins_plan'])."',
                s_m_ins_type = '".mysql_real_escape_string($_POST['s_m_ins_type'])."',
                s_m_ins_ass = '".mysql_real_escape_string($_POST['s_m_ins_ass'])."',
                employer = '".mysql_real_escape_string($_POST['employer'])."',
                emp_add1 = '".mysql_real_escape_string($_POST['emp_add1'])."',
                emp_add2 = '".mysql_real_escape_string($_POST['emp_add2'])."',
                emp_city = '".mysql_real_escape_string($_POST['emp_city'])."',
                emp_state = '".mysql_real_escape_string($_POST['emp_state'])."',
                emp_zip = '".mysql_real_escape_string($_POST['emp_zip'])."',
                emp_phone = '".mysql_real_escape_string($_POST['emp_phone'])."',
                emp_fax = '".mysql_real_escape_string($_POST['emp_fax'])."',
                registered = '1',
                parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."'
                ";

       }else{

        $sql = "UPDATE dental_patients set
                firstname = '".mysql_real_escape_string($_POST['firstname'])."',
                middlename= '".mysql_real_escape_string($_POST['middlename'])."',
                lastname= '".mysql_real_escape_string($_POST['lastname'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                home_phone = '".mysql_real_escape_string($_POST['home_phone'])."',
                work_phone = '".mysql_real_escape_string($_POST['work_phone'])."',
                cell_phone = '".mysql_real_escape_string($_POST['cell_phone'])."',
                add1 = '".mysql_real_escape_string($_POST['add1'])."',
                add2 = '".mysql_real_escape_string($_POST['add2'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
                dob = '".mysql_real_escape_string($dob)."',
                gender = '".mysql_real_escape_string($_POST['gender'])."',
                marital_status = '".mysql_real_escape_string($_POST['marital_status'])."',
                partner_name = '".mysql_real_escape_string($_POST['partner_name'])."',
                ssn = '".mysql_real_escape_string($_POST['ssn'])."',
                patient_notes = '".mysql_real_escape_string($_POST['patient_notes'])."',
                preferredcontact = '".mysql_real_escape_string($_POST['preferredcontact'])."',
                emergency_name = '".mysql_real_escape_string($_POST['emergency_name'])."',
                emergency_relationship = '".mysql_real_escape_string($_POST['emergency_relationship'])."',
                emergency_number = '".mysql_real_escape_string($_POST['emergency_number'])."',
                p_m_relation = '".mysql_real_escape_string($_POST['p_m_relation'])."',
                p_m_partyfname = '".mysql_real_escape_string($_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysql_real_escape_string($_POST['p_m_partymname'])."',
                p_m_partylname = '".mysql_real_escape_string($_POST['p_m_partylname'])."',
                ins_dob = '".mysql_real_escape_string($ins_dob)."',
                p_m_ins_co = '".mysql_real_escape_string($_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysql_real_escape_string($_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysql_real_escape_string($_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysql_real_escape_string($_POST['p_m_ins_plan'])."',
                p_m_ins_type = '".mysql_real_escape_string($_POST['p_m_ins_type'])."',
                p_m_ins_ass = '".mysql_real_escape_string($_POST['p_m_ins_ass'])."',
                has_s_m_ins = '".mysql_real_escape_string($_POST['has_s_m_ins'])."',
                s_m_relation = '".mysql_real_escape_string($_POST['s_m_relation'])."',
                s_m_partyfname = '".mysql_real_escape_string($_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysql_real_escape_string($_POST['s_m_partymname'])."',
                s_m_partylname = '".mysql_real_escape_string($_POST['s_m_partylname'])."',
                ins2_dob = '".mysql_real_escape_string($ins2_dob)."',
                s_m_ins_co = '".mysql_real_escape_string($_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysql_real_escape_string($_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysql_real_escape_string($_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysql_real_escape_string($_POST['s_m_ins_plan'])."',
                s_m_ins_type = '".mysql_real_escape_string($_POST['s_m_ins_type'])."',
                s_m_ins_ass = '".mysql_real_escape_string($_POST['s_m_ins_ass'])."',
                employer = '".mysql_real_escape_string($_POST['employer'])."',
                emp_add1 = '".mysql_real_escape_string($_POST['emp_add1'])."',
                emp_add2 = '".mysql_real_escape_string($_POST['emp_add2'])."',
                emp_city = '".mysql_real_escape_string($_POST['emp_city'])."',
                emp_state = '".mysql_real_escape_string($_POST['emp_state'])."',
                emp_zip = '".mysql_real_escape_string($_POST['emp_zip'])."',
                emp_phone = '".mysql_real_escape_string($_POST['emp_phone'])."',
                emp_fax = '".mysql_real_escape_string($_POST['emp_fax'])."',
                registered = '1'
                WHERE parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."'
                ";

   	}
       $q = mysql_query($sql);
	if($q){
		echo "Successfully updated!";
	}else{
		echo "Error";
	}


?>
