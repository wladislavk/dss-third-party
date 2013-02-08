<?php include '../../manage/admin/includes/config.php'; ?>
<?php include '../../manage/includes/constants.inc'; ?>
<?php require_once '../../manage/includes/general_functions.php'; ?>
<?php require_once '../../manage/includes/notifications.php'; ?>
<?php
        $chksql = "SELECT patientid FROM dental_patients WHERE parent_patientid='".mysql_escape_string($_SESSION['pid'])."'";
        $chkq = mysql_query($chksql);
	$chkc = mysql_num_rows($chkq);
        $dob = ($_POST['dob_month'] != '' && $_POST['dob_day'] != '' && $_POST['dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['dob_month'],$_POST['dob_day'],$_POST['dob_year'])):'';
        $ins_dob = ($_POST['ins_dob_month'] != '' && $_POST['ins_dob_day'] != '' && $_POST['ins_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins_dob_month'],$_POST['ins_dob_day'],$_POST['ins_dob_year'])):'';
        $ins2_dob = ($_POST['ins2_dob_month'] != '' && $_POST['ins2_dob_day'] != '' && $_POST['ins2_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins2_dob_month'],$_POST['ins2_dob_day'],$_POST['ins2_dob_year'])):'';
	if($_POST['p_m_ins_type']!=''){
	  $p_m_ins_type = ($_POST['p_m_ins_type']==1)?$_POST['p_m_ins_type']:'7';
	}else{
	  $p_m_ins_type = '';
	}
        if($chkc == 0){
        $sql = "INSERT INTO dental_patients set
                firstname = '".mysql_real_escape_string($_POST['firstname'])."',
                middlename= '".mysql_real_escape_string($_POST['middlename'])."',
                lastname= '".mysql_real_escape_string($_POST['lastname'])."',
                preferred_name= '".mysql_real_escape_string($_POST['preferred_name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                home_phone = '".mysql_real_escape_string(num($_POST['home_phone']))."',
                work_phone = '".mysql_real_escape_string(num($_POST['work_phone']))."',
                cell_phone = '".mysql_real_escape_string(num($_POST['cell_phone']))."',
                add1 = '".mysql_real_escape_string($_POST['add1'])."',
                add2 = '".mysql_real_escape_string($_POST['add2'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
                dob = '".mysql_real_escape_string($dob)."',
                gender = '".mysql_real_escape_string($_POST['gender'])."',
                marital_status = '".mysql_real_escape_string($_POST['marital_status'])."',
                partner_name = '".mysql_real_escape_string($_POST['partner_name'])."',
                ssn = '".mysql_real_escape_string(num($_POST['ssn'], false))."',
                preferredcontact = '".mysql_real_escape_string($_POST['preferredcontact'])."',
                emergency_name = '".mysql_real_escape_string($_POST['emergency_name'])."',
                emergency_relationship = '".mysql_real_escape_string($_POST['emergency_relationship'])."',
                emergency_number = '".mysql_real_escape_string(num($_POST['emergency_number']))."',
                p_m_relation = '".mysql_real_escape_string($_POST['p_m_relation'])."',
                p_m_partyfname = '".mysql_real_escape_string($_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysql_real_escape_string($_POST['p_m_partymname'])."',
                p_m_partylname = '".mysql_real_escape_string($_POST['p_m_partylname'])."',
                ins_dob = '".mysql_real_escape_string($ins_dob)."',
                p_m_ins_co = '".mysql_real_escape_string($_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysql_real_escape_string($_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysql_real_escape_string($_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysql_real_escape_string($_POST['p_m_ins_plan'])."',";
                if($p_m_ins_type!=''){
			$sql .= " p_m_ins_type = '".mysql_real_escape_string($p_m_ins_type)."', ";
		}
		$sql .= "
                p_m_ins_ass = '".mysql_real_escape_string($_POST['p_m_ins_ass'])."',
		has_p_m_ins = '".mysql_real_escape_string($_POST['has_p_m_ins'])."',
                has_s_m_ins = '".mysql_real_escape_string($_POST['has_s_m_ins'])."',
                s_m_relation = '".mysql_real_escape_string($_POST['s_m_relation'])."',
                s_m_partyfname = '".mysql_real_escape_string($_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysql_real_escape_string($_POST['s_m_partymname'])."',
                s_m_partylname = '".mysql_real_escape_string($_POST['s_m_partylname'])."',
                ins2_dob = '".mysql_real_escape_string($ins2_dob)."',
                s_m_ins_co = '".mysql_real_escape_string($_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysql_real_escape_string($_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysql_real_escape_string($_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysql_real_escape_string($_POST['s_m_ins_plan'])."',";
                if($_POST['has_s_m_ins']=="Yes"){
                        $sql .= " s_m_ins_type = '7', ";
                }
                $sql .= "
                s_m_ins_ass = '".mysql_real_escape_string($_POST['s_m_ins_ass'])."',
                employer = '".mysql_real_escape_string($_POST['employer'])."',
                emp_add1 = '".mysql_real_escape_string($_POST['emp_add1'])."',
                emp_add2 = '".mysql_real_escape_string($_POST['emp_add2'])."',
                emp_city = '".mysql_real_escape_string($_POST['emp_city'])."',
                emp_state = '".mysql_real_escape_string($_POST['emp_state'])."',
                emp_zip = '".mysql_real_escape_string($_POST['emp_zip'])."',
                emp_phone = '".mysql_real_escape_string(num($_POST['emp_phone']))."',
                emp_fax = '".mysql_real_escape_string(num($_POST['emp_fax']))."',
		docsleep = '".mysql_real_escape_string($_POST['pc_1_contactid'])."',
                docpcp = '".mysql_real_escape_string($_POST['pc_2_contactid'])."',
                docdentist = '".mysql_real_escape_string($_POST['pc_3_contactid'])."',
                docent = '".mysql_real_escape_string($_POST['pc_4_contactid'])."',
                docmdother = '".mysql_real_escape_string($_POST['pc_5_contactid'])."',
                registered = '1',
                parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."'
                ";

       }else{

        $sql = "UPDATE dental_patients set
                firstname = '".mysql_real_escape_string($_POST['firstname'])."',
                middlename= '".mysql_real_escape_string($_POST['middlename'])."',
                lastname= '".mysql_real_escape_string($_POST['lastname'])."',
                preferred_name= '".mysql_real_escape_string($_POST['preferred_name'])."',
                email= '".mysql_real_escape_string($_POST['email'])."',
                home_phone = '".mysql_real_escape_string(num($_POST['home_phone']))."',
                work_phone = '".mysql_real_escape_string(num($_POST['work_phone']))."',
                cell_phone = '".mysql_real_escape_string(num($_POST['cell_phone']))."',
                add1 = '".mysql_real_escape_string($_POST['add1'])."',
                add2 = '".mysql_real_escape_string($_POST['add2'])."',
                city = '".mysql_real_escape_string($_POST['city'])."',
                state = '".mysql_real_escape_string($_POST['state'])."',
                zip = '".mysql_real_escape_string($_POST['zip'])."',
                dob = '".mysql_real_escape_string($dob)."',
                gender = '".mysql_real_escape_string($_POST['gender'])."',
                marital_status = '".mysql_real_escape_string($_POST['marital_status'])."',
                partner_name = '".mysql_real_escape_string($_POST['partner_name'])."',
                ssn = '".mysql_real_escape_string(num($_POST['ssn'], false))."',
                preferredcontact = '".mysql_real_escape_string($_POST['preferredcontact'])."',
                emergency_name = '".mysql_real_escape_string($_POST['emergency_name'])."',
                emergency_relationship = '".mysql_real_escape_string($_POST['emergency_relationship'])."',
                emergency_number = '".mysql_real_escape_string(num($_POST['emergency_number']))."',
                p_m_relation = '".mysql_real_escape_string($_POST['p_m_relation'])."',
                p_m_partyfname = '".mysql_real_escape_string($_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysql_real_escape_string($_POST['p_m_partymname'])."',
                p_m_partylname = '".mysql_real_escape_string($_POST['p_m_partylname'])."',
                ins_dob = '".mysql_real_escape_string($ins_dob)."',
                p_m_ins_co = '".mysql_real_escape_string($_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysql_real_escape_string($_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysql_real_escape_string($_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysql_real_escape_string($_POST['p_m_ins_plan'])."',
                p_m_ins_type = '".mysql_real_escape_string($p_m_ins_type)."',
                p_m_ins_ass = '".mysql_real_escape_string($_POST['p_m_ins_ass'])."',
		has_p_m_ins = '".mysql_real_escape_string($_POST['has_p_m_ins'])."',
                has_s_m_ins = '".mysql_real_escape_string($_POST['has_s_m_ins'])."',
                s_m_relation = '".mysql_real_escape_string($_POST['s_m_relation'])."',
                s_m_partyfname = '".mysql_real_escape_string($_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysql_real_escape_string($_POST['s_m_partymname'])."',
                s_m_partylname = '".mysql_real_escape_string($_POST['s_m_partylname'])."',
                ins2_dob = '".mysql_real_escape_string($ins2_dob)."',
                s_m_ins_co = '".mysql_real_escape_string($_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysql_real_escape_string($_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysql_real_escape_string($_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysql_real_escape_string($_POST['s_m_ins_plan'])."',";
		if($_POST['has_s_m_ins']=="Yes"){
                	$sql .= " s_m_ins_type = '7', ";
		}
		$sql .= "
                s_m_ins_ass = '".mysql_real_escape_string($_POST['s_m_ins_ass'])."',
                employer = '".mysql_real_escape_string($_POST['employer'])."',
                emp_add1 = '".mysql_real_escape_string($_POST['emp_add1'])."',
                emp_add2 = '".mysql_real_escape_string($_POST['emp_add2'])."',
                emp_city = '".mysql_real_escape_string($_POST['emp_city'])."',
                emp_state = '".mysql_real_escape_string($_POST['emp_state'])."',
                emp_zip = '".mysql_real_escape_string($_POST['emp_zip'])."',
                emp_phone = '".mysql_real_escape_string(num($_POST['emp_phone']))."',
                emp_fax = '".mysql_real_escape_string(num($_POST['emp_fax']))."',
                docsleep = '".mysql_real_escape_string($_POST['pc_1_contactid'])."',
                docpcp = '".mysql_real_escape_string($_POST['pc_2_contactid'])."',
                docdentist = '".mysql_real_escape_string($_POST['pc_3_contactid'])."',
                docent = '".mysql_real_escape_string($_POST['pc_4_contactid'])."',
                docmdother = '".mysql_real_escape_string($_POST['pc_5_contactid'])."',
                registered = '1',
		last_reg_sect = '".mysql_real_escape_string($_POST['last_reg_sect'])."'
                WHERE parent_patientid='".mysql_real_escape_string($_SESSION['pid'])."'
                ";

   	}
       $q = mysql_query($sql);
	if($q){
		//echo "Successfully updated!";
	}else{
		//echo "Error";
	}

		$s_sql = "SELECT email FROM dental_patients
                        WHERE patientid=".mysql_real_escape_string($_SESSION['pid']);
                $s_q = mysql_query($s_sql);
                $s_r = mysql_fetch_assoc($s_q);
                sendUpdatedEmail($_SESSION['pid'], $_POST['email'], $s_r['email'], 'pat');
		if(trim($_POST['email']) != trim($s_r['email'])){
			//echo create_notification($_SESSION['pid'], '', "User has updated email from ".$s_r['email']." to ".$_POST['email'].".", 'email');
		}
		
		$s = "UPDATE dental_patients set email='".mysql_real_escape_string($_POST['email'])."' WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";	
		mysql_query($s);

                $types = array(DSS_PATIENT_CONTACT_SLEEP, DSS_PATIENT_CONTACT_PRIMARY, DSS_PATIENT_CONTACT_DENTIST, DSS_PATIENT_CONTACT_ENT, DSS_PATIENT_CONTACT_OTHER);
		$updatevals = '';
                foreach($types as $t){
                        if(trim($_POST['pc_'.$t.'_contactid']) ==''){
                                if($_POST['pc_'.$t.'_firstname'] != ''){
				   if($_POST['pc_'.$t.'_patient_contactid'] == ''){
                                        $insql = "INSERT INTO dental_patient_contacts SET " .
                                                "contacttype = '" . $t . "', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "firstname = '" . mysql_real_escape_string(trim($_POST['pc_'.$t.'_firstname'])) . "', " .
                                                "lastname = '" . mysql_real_escape_string(trim($_POST['pc_'.$t.'_lastname'])) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['pc_'.$t.'_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['pc_'.$t.'_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['pc_'.$t.'_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['pc_'.$t.'_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['pc_'.$t.'_zip']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['pc_'.$t.'_phone'])) . "';";
                                        mysql_query($insql);
                                        $id = mysql_insert_id();
					if($updatevals!=''){ $updatevals .= ','; }
                                        $updatevals .= '"pc_'.$t.'_patient_contactid": "'.$id.'"';
				    }else{
                                        $insql = "UPDATE dental_patient_contacts SET " .
                                                "contacttype = '" . $t . "', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "firstname = '" . mysql_real_escape_string(trim($_POST['pc_'.$t.'_firstname'])) . "', " .
                                                "lastname = '" . mysql_real_escape_string(trim($_POST['pc_'.$t.'_lastname'])) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['pc_'.$t.'_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['pc_'.$t.'_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['pc_'.$t.'_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['pc_'.$t.'_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['pc_'.$t.'_zip']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['pc_'.$t.'_phone'])) . "' " .
						" WHERE id = '" . mysql_real_escape_string($_POST['pc_'.$t.'_patient_contactid']) . "'";
                                        mysql_query($insql);
				    }
                                }
                        }
                }
		if($updatevals != ''){
			echo "{".$updatevals."}";
		}
				if(trim($_POST['p_m_ins_company'])!=''){
				    if($_POST['p_m_patient_insuranceid'] == ''){
					$insql = "INSERT INTO dental_patient_insurance SET " .
                                                "insurancetype = '1', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "company = '" . mysql_real_escape_string($_POST['p_m_ins_company']) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['p_m_ins_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['p_m_ins_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['p_m_ins_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['p_m_ins_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['p_m_ins_zip']) . "', " .
                                                "fax = '" . mysql_real_escape_string($_POST['p_m_ins_fax']) . "', " .
                                                "email = '" . mysql_real_escape_string($_POST['p_m_ins_email']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['p_m_ins_phone'])) . "';";
					mysql_query($insql);
					$id = mysql_insert_id();
					echo '{"p_m_patient_insuranceid": "'.$id.'"}';
				    }else{
                                        $insql = "UPDATE dental_patient_insurance SET " .
                                                "insurancetype = '1', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "company = '" . mysql_real_escape_string($_POST['p_m_ins_company']) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['p_m_ins_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['p_m_ins_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['p_m_ins_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['p_m_ins_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['p_m_ins_zip']) . "', " .
                                                "fax = '" . mysql_real_escape_string($_POST['p_m_ins_fax']) . "', " .
                                                "email = '" . mysql_real_escape_string($_POST['p_m_ins_email']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['p_m_ins_phone'])) . "' " .
						"WHERE id = '". mysql_real_escape_string($_POST['p_m_patient_insuranceid']) ."'";
					mysql_query($insql);
				    }
				}

                                if(trim($_POST['s_m_ins_company'])!=''){
                                    if($_POST['s_m_patient_insuranceid'] == ''){
                                        $insql = "INSERT INTO dental_patient_insurance SET " .
                                                "insurancetype = '2', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "company = '" . mysql_real_escape_string($_POST['s_m_ins_company']) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['s_m_ins_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['s_m_ins_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['s_m_ins_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['s_m_ins_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['s_m_ins_zip']) . "', " .
                                                "fax = '" . mysql_real_escape_string($_POST['s_m_ins_fax']) . "', " .
                                                "email = '" . mysql_real_escape_string($_POST['s_m_ins_email']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['s_m_ins_phone'])) . "';";
                                        mysql_query($insql);
                                        $id = mysql_insert_id();
					echo '{"s_m_patient_insuranceid": "'.$id.'"}';
                                    }else{
                                        $insql = "UPDATE dental_patient_insurance SET " .
                                                "insurancetype = '2', " .
                                                "patientid = '" . mysql_real_escape_string($_SESSION['pid']) . "', " .
                                                "company = '" . mysql_real_escape_string($_POST['s_m_ins_company']) . "', " .
                                                "address1 = '" . mysql_real_escape_string($_POST['s_m_ins_address1']) . "', " .
                                                "address2 = '" . mysql_real_escape_string($_POST['s_m_ins_address2']) . "', " .
                                                "city = '" . mysql_real_escape_string($_POST['s_m_ins_city']) . "', " .
                                                "state = '" . mysql_real_escape_string($_POST['s_m_ins_state']) . "', " .
                                                "zip = '" . mysql_real_escape_string($_POST['s_m_ins_zip']) . "', " .
                                                "fax = '" . mysql_real_escape_string($_POST['s_m_ins_fax']) . "', " .
                                                "email = '" . mysql_real_escape_string($_POST['s_m_ins_email']) . "', " .
                                                "phone = '" . mysql_real_escape_string(num($_POST['s_m_ins_phone'])) . "' " .
                                                "WHERE id = '". mysql_real_escape_string($_POST['s_m_patient_insuranceid']) ."'";
                                        mysql_query($insql);
				    }
                                }



?>
