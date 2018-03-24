<?php namespace Ds3\Libraries\Legacy; ?><?php include '../../manage/admin/includes/main_include.php'; ?>
<?php include '../../manage/includes/constants.inc'; ?>
<?php require_once '../../manage/includes/general_functions.php'; ?>
<?php require_once '../../manage/includes/notifications.php'; ?>
<?php

linkRequestData('dental_patients', $_SESSION['pid']);

        $chksql = "SELECT patientid FROM dental_patients WHERE parent_patientid='".mysqli_escape_string($con, $_SESSION['pid'])."'";
        $chkq = mysqli_query($con, $chksql);
	$chkc = mysqli_num_rows($chkq);
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
                firstname = '".mysqli_real_escape_string($con, $_POST['firstname'])."',
                middlename= '".mysqli_real_escape_string($con, $_POST['middlename'])."',
                lastname= '".mysqli_real_escape_string($con, $_POST['lastname'])."',
                preferred_name= '".mysqli_real_escape_string($con, $_POST['preferred_name'])."',
                email= '".mysqli_real_escape_string($con, $_POST['email'])."',
                home_phone = '".mysqli_real_escape_string($con, num($_POST['home_phone']))."',
                work_phone = '".mysqli_real_escape_string($con, num($_POST['work_phone']))."',
                cell_phone = '".mysqli_real_escape_string($con, num($_POST['cell_phone']))."',
                add1 = '".mysqli_real_escape_string($con, $_POST['add1'])."',
                add2 = '".mysqli_real_escape_string($con, $_POST['add2'])."',
                city = '".mysqli_real_escape_string($con, $_POST['city'])."',
                state = '".mysqli_real_escape_string($con, $_POST['state'])."',
                zip = '".mysqli_real_escape_string($con, $_POST['zip'])."',
                dob = '".mysqli_real_escape_string($con, $dob)."',
                gender = '".mysqli_real_escape_string($con, $_POST['gender'])."',
                marital_status = '".mysqli_real_escape_string($con, $_POST['marital_status'])."',
                partner_name = '".mysqli_real_escape_string($con, $_POST['partner_name'])."',
                ssn = '".mysqli_real_escape_string($con, num($_POST['ssn'], false))."',
                preferredcontact = '".mysqli_real_escape_string($con, $_POST['preferredcontact'])."',
		feet = '".mysqli_real_escape_string($con, $_POST['feet'])."',
		inches = '".mysqli_real_escape_string($con, $_POST['inches'])."',
		weight = '".mysqli_real_escape_string($con, $_POST['weight'])."',
		bmi = '".mysqli_real_escape_string($con, $_POST['bmi'])."',
                emergency_name = '".mysqli_real_escape_string($con, $_POST['emergency_name'])."',
                emergency_relationship = '".mysqli_real_escape_string($con, $_POST['emergency_relationship'])."',
                emergency_number = '".mysqli_real_escape_string($con, num($_POST['emergency_number']))."',
                p_m_relation = '".mysqli_real_escape_string($con, $_POST['p_m_relation'])."',
                p_m_partyfname = '".mysqli_real_escape_string($con, $_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysqli_real_escape_string($con, $_POST['p_m_partymname'])."',
                p_m_partylname = '".mysqli_real_escape_string($con, $_POST['p_m_partylname'])."',
		p_m_gender = '".mysqli_real_escape_string($con, $_POST['p_m_gender'])."',
                ins_dob = '".mysqli_real_escape_string($con, $ins_dob)."',
                p_m_ins_co = '".mysqli_real_escape_string($con, $_POST['p_m_ins_co'])."',
                p_m_ins_id = '".mysqli_real_escape_string($con, $_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysqli_real_escape_string($con, $_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysqli_real_escape_string($con, $_POST['p_m_ins_plan'])."',";
                if($p_m_ins_type!=''){
			$sql .= " p_m_ins_type = '".mysqli_real_escape_string($con, $p_m_ins_type)."', ";
		}
		$sql .= "
		has_p_m_ins = '".mysqli_real_escape_string($con, $_POST['has_p_m_ins'])."',
                has_s_m_ins = '".mysqli_real_escape_string($con, $_POST['has_s_m_ins'])."',
                s_m_relation = '".mysqli_real_escape_string($con, $_POST['s_m_relation'])."',
                s_m_partyfname = '".mysqli_real_escape_string($con, $_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysqli_real_escape_string($con, $_POST['s_m_partymname'])."',
                s_m_partylname = '".mysqli_real_escape_string($con, $_POST['s_m_partylname'])."',
		s_m_gender = '".mysqli_real_escape_string($con, $_POST['s_m_gender'])."',
                ins2_dob = '".mysqli_real_escape_string($con, $ins2_dob)."',
                s_m_ins_co = '".mysqli_real_escape_string($con, $_POST['s_m_ins_co'])."',
                s_m_ins_id = '".mysqli_real_escape_string($con, $_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysqli_real_escape_string($con, $_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysqli_real_escape_string($con, $_POST['s_m_ins_plan'])."',";
                if($_POST['has_s_m_ins']=="Yes"){
                        $sql .= " s_m_ins_type = '7', ";
                }
                $sql .= "
                employer = '".mysqli_real_escape_string($con, $_POST['employer'])."',
                emp_add1 = '".mysqli_real_escape_string($con, $_POST['emp_add1'])."',
                emp_add2 = '".mysqli_real_escape_string($con, $_POST['emp_add2'])."',
                emp_city = '".mysqli_real_escape_string($con, $_POST['emp_city'])."',
                emp_state = '".mysqli_real_escape_string($con, $_POST['emp_state'])."',
                emp_zip = '".mysqli_real_escape_string($con, $_POST['emp_zip'])."',
                emp_phone = '".mysqli_real_escape_string($con, num($_POST['emp_phone']))."',
                emp_fax = '".mysqli_real_escape_string($con, num($_POST['emp_fax']))."',
		docsleep = '".mysqli_real_escape_string($con, $_POST['pc_1_contactid'])."',
                docpcp = '".mysqli_real_escape_string($con, $_POST['pc_2_contactid'])."',
                docdentist = '".mysqli_real_escape_string($con, $_POST['pc_3_contactid'])."',
                docent = '".mysqli_real_escape_string($con, $_POST['pc_4_contactid'])."',
                docmdother = '".mysqli_real_escape_string($con, $_POST['pc_5_contactid'])."',
                registered = '1',
                parent_patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'
                ";

       }else{

        $sql = "UPDATE dental_patients set
                firstname = '".mysqli_real_escape_string($con, $_POST['firstname'])."',
                middlename= '".mysqli_real_escape_string($con, $_POST['middlename'])."',
                lastname= '".mysqli_real_escape_string($con, $_POST['lastname'])."',
                preferred_name= '".mysqli_real_escape_string($con, $_POST['preferred_name'])."',
                email= '".mysqli_real_escape_string($con, $_POST['email'])."',
                home_phone = '".mysqli_real_escape_string($con, num($_POST['home_phone']))."',
                work_phone = '".mysqli_real_escape_string($con, num($_POST['work_phone']))."',
                cell_phone = '".mysqli_real_escape_string($con, num($_POST['cell_phone']))."',
                add1 = '".mysqli_real_escape_string($con, $_POST['add1'])."',
                add2 = '".mysqli_real_escape_string($con, $_POST['add2'])."',
                city = '".mysqli_real_escape_string($con, $_POST['city'])."',
                state = '".mysqli_real_escape_string($con, $_POST['state'])."',
                zip = '".mysqli_real_escape_string($con, $_POST['zip'])."',
                dob = '".mysqli_real_escape_string($con, $dob)."',
                gender = '".mysqli_real_escape_string($con, $_POST['gender'])."',
                marital_status = '".mysqli_real_escape_string($con, $_POST['marital_status'])."',
                partner_name = '".mysqli_real_escape_string($con, $_POST['partner_name'])."',
                ssn = '".mysqli_real_escape_string($con, num($_POST['ssn'], false))."',
                preferredcontact = '".mysqli_real_escape_string($con, $_POST['preferredcontact'])."',
                feet = '".mysqli_real_escape_string($con, $_POST['feet'])."',
                inches = '".mysqli_real_escape_string($con, $_POST['inches'])."',
                weight = '".mysqli_real_escape_string($con, $_POST['weight'])."',
                bmi = '".mysqli_real_escape_string($con, $_POST['bmi'])."',
                emergency_name = '".mysqli_real_escape_string($con, $_POST['emergency_name'])."',
                emergency_relationship = '".mysqli_real_escape_string($con, $_POST['emergency_relationship'])."',
                emergency_number = '".mysqli_real_escape_string($con, num($_POST['emergency_number']))."',
                p_m_relation = '".mysqli_real_escape_string($con, $_POST['p_m_relation'])."',
                p_m_partyfname = '".mysqli_real_escape_string($con, $_POST['p_m_partyfname'])."',
                p_m_partymname = '".mysqli_real_escape_string($con, $_POST['p_m_partymname'])."',
                p_m_partylname = '".mysqli_real_escape_string($con, $_POST['p_m_partylname'])."',
		p_m_gender = '".mysqli_real_escape_string($con, $_POST['p_m_gender'])."',
                ins_dob = '".mysqli_real_escape_string($con, $ins_dob)."',
                p_m_ins_co = '".mysqli_real_escape_string($con, $_POST['p_m_ins_company'])."',
                p_m_ins_id = '".mysqli_real_escape_string($con, $_POST['p_m_ins_id'])."',
                p_m_ins_grp = '".mysqli_real_escape_string($con, $_POST['p_m_ins_grp'])."',
                p_m_ins_plan = '".mysqli_real_escape_string($con, $_POST['p_m_ins_plan'])."',
                p_m_ins_type = '".mysqli_real_escape_string($con, $p_m_ins_type)."',
		has_p_m_ins = '".mysqli_real_escape_string($con, $_POST['has_p_m_ins'])."',
                has_s_m_ins = '".mysqli_real_escape_string($con, $_POST['has_s_m_ins'])."',
                s_m_relation = '".mysqli_real_escape_string($con, $_POST['s_m_relation'])."',
                s_m_partyfname = '".mysqli_real_escape_string($con, $_POST['s_m_partyfname'])."',
                s_m_partymname = '".mysqli_real_escape_string($con, $_POST['s_m_partymname'])."',
                s_m_partylname = '".mysqli_real_escape_string($con, $_POST['s_m_partylname'])."',
		s_m_gender = '".mysqli_real_escape_string($con, $_POST['s_m_gender'])."',
                ins2_dob = '".mysqli_real_escape_string($con, $ins2_dob)."',
                s_m_ins_co = '".mysqli_real_escape_string($con, $_POST['s_m_ins_company'])."',
                s_m_ins_id = '".mysqli_real_escape_string($con, $_POST['s_m_ins_id'])."',
                s_m_ins_grp = '".mysqli_real_escape_string($con, $_POST['s_m_ins_grp'])."',
                s_m_ins_plan = '".mysqli_real_escape_string($con, $_POST['s_m_ins_plan'])."',";
		if($_POST['has_s_m_ins']=="Yes"){
                	$sql .= " s_m_ins_type = '7', ";
		}
		$sql .= "
                employer = '".mysqli_real_escape_string($con, $_POST['employer'])."',
                emp_add1 = '".mysqli_real_escape_string($con, $_POST['emp_add1'])."',
                emp_add2 = '".mysqli_real_escape_string($con, $_POST['emp_add2'])."',
                emp_city = '".mysqli_real_escape_string($con, $_POST['emp_city'])."',
                emp_state = '".mysqli_real_escape_string($con, $_POST['emp_state'])."',
                emp_zip = '".mysqli_real_escape_string($con, $_POST['emp_zip'])."',
                emp_phone = '".mysqli_real_escape_string($con, num($_POST['emp_phone']))."',
                emp_fax = '".mysqli_real_escape_string($con, num($_POST['emp_fax']))."',
                docsleep = '".mysqli_real_escape_string($con, $_POST['pc_1_contactid'])."',
                docpcp = '".mysqli_real_escape_string($con, $_POST['pc_2_contactid'])."',
                docdentist = '".mysqli_real_escape_string($con, $_POST['pc_3_contactid'])."',
                docent = '".mysqli_real_escape_string($con, $_POST['pc_4_contactid'])."',
                docmdother = '".mysqli_real_escape_string($con, $_POST['pc_5_contactid'])."',
                registered = '1',
		last_reg_sect = '".mysqli_real_escape_string($con, $_POST['last_reg_sect'])."'
                WHERE parent_patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'
                ";

   	}
       $q = mysqli_query($con, $sql);
	if($q){
		//echo "Successfully updated!";
	}else{
		//echo "Error";
	}

		$s_sql = "SELECT email FROM dental_patients
                        WHERE patientid=".mysqli_real_escape_string($con, $_SESSION['pid']);
                $s_q = mysqli_query($con, $s_sql);
                $s_r = mysqli_fetch_assoc($s_q);
                sendUpdatedEmail($_SESSION['pid'], $_POST['email'], $s_r['email'], 'pat');
		if(trim($_POST['email']) != trim($s_r['email'])){
			//echo create_notification($_SESSION['pid'], '', "User has updated email from ".$s_r['email']." to ".$_POST['email'].".", 'email');
		}
		
		$s = "UPDATE dental_patients set email='".mysqli_real_escape_string($con, $_POST['email'])."' WHERE patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";	
		mysqli_query($con, $s);

                $types = array(DSS_PATIENT_CONTACT_SLEEP, DSS_PATIENT_CONTACT_PRIMARY, DSS_PATIENT_CONTACT_DENTIST, DSS_PATIENT_CONTACT_ENT, DSS_PATIENT_CONTACT_OTHER);
		$updatevals = '';
                foreach($types as $t){
                        if(trim($_POST['pc_'.$t.'_contactid']) ==''){
                                if($_POST['pc_'.$t.'_firstname'] != ''){
				   if($_POST['pc_'.$t.'_patient_contactid'] == ''){
                                        $insql = "INSERT INTO dental_patient_contacts SET " .
                                                "contacttype = '" . $t . "', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "firstname = '" . mysqli_real_escape_string($con, trim($_POST['pc_'.$t.'_firstname'])) . "', " .
                                                "lastname = '" . mysqli_real_escape_string($con, trim($_POST['pc_'.$t.'_lastname'])) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_zip']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['pc_'.$t.'_phone'])) . "', " .
						"adddate = now(), " .
						"ip_address = '".mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR'])."';";
                                        mysqli_query($con, $insql);
                                        $id = mysqli_insert_id($con);
					if($updatevals!=''){ $updatevals .= ','; }
                                        $updatevals .= '"pc_'.$t.'_patient_contactid": "'.$id.'"';
				    }else{
                                        $insql = "UPDATE dental_patient_contacts SET " .
                                                "contacttype = '" . $t . "', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "firstname = '" . mysqli_real_escape_string($con, trim($_POST['pc_'.$t.'_firstname'])) . "', " .
                                                "lastname = '" . mysqli_real_escape_string($con, trim($_POST['pc_'.$t.'_lastname'])) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_zip']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['pc_'.$t.'_phone'])) . "' " .
						" WHERE id = '" . mysqli_real_escape_string($con, $_POST['pc_'.$t.'_patient_contactid']) . "'";
                                        mysqli_query($con, $insql);
				    }
                                }
                        }
                }
		if($updatevals != ''){
			echo "{".$updatevals."}";
		}



$p_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.p_m_ins_co=c.contactid WHERE p.patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
                                        $p_m_q = mysqli_query($con, $p_m_sql);
                                        $p_m_r = mysqli_fetch_assoc($p_m_q);



				if(trim($_POST['p_m_ins_company'])!=''){
				    if($_POST['p_m_patient_insuranceid'] == ''){
					if(
						$p_m_r['company'] != $_POST['p_m_ins_company'] ||
                                                $p_m_r['address1'] != $_POST['p_m_ins_address1'] ||
                                                $p_m_r['address2'] != $_POST['p_m_ins_address2'] ||
                                                $p_m_r['city'] != $_POST['p_m_ins_city'] ||
                                                $p_m_r['state'] != $_POST['p_m_ins_state'] ||
                                                $p_m_r['zip'] != $_POST['p_m_ins_zip'] ||
                                                num($p_m_r['fax']) != num($_POST['p_m_ins_fax']) ||
                                                $p_m_r['email'] != $_POST['p_m_ins_email'] ||
                                                num($p_m_r['phone']) != num($_POST['p_m_ins_phone']) 

					){
					  $insql = "INSERT INTO dental_patient_insurance SET " .
                                                "insurancetype = '1', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "company = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_company']) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_zip']) . "', " .
                                                "fax = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_fax']) . "', " .
                                                "email = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_email']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['p_m_ins_phone'])) . "';";
					  mysqli_query($con, $insql);
					  $id = mysqli_insert_id($con);
					  echo '{"p_m_patient_insuranceid": "'.$id.'"}';
					}
				    }else{
                                        $insql = "UPDATE dental_patient_insurance SET " .
                                                "insurancetype = '1', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "company = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_company']) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_zip']) . "', " .
                                                "fax = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_fax']) . "', " .
                                                "email = '" . mysqli_real_escape_string($con, $_POST['p_m_ins_email']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['p_m_ins_phone'])) . "' " .
						"WHERE id = '". mysqli_real_escape_string($con, $_POST['p_m_patient_insuranceid']) ."'";
					mysqli_query($con, $insql);
				    }
				}


                                        $s_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.s_m_ins_co=c.contactid WHERE p.patientid='".mysqli_real_escape_string($con, $_SESSION['pid'])."'";
                                        $s_m_q = mysqli_query($con, $s_m_sql);
                                        $s_m_r = mysqli_fetch_assoc($s_m_q);

                                if(trim($_POST['s_m_ins_company'])!=''){
                                    if($_POST['s_m_patient_insuranceid'] == ''){
                                        if(
                                                $s_m_r['company'] != $_POST['s_m_ins_company'] ||
                                                $s_m_r['address1'] != $_POST['s_m_ins_address1'] ||
                                                $s_m_r['address2'] != $_POST['s_m_ins_address2'] ||
                                                $s_m_r['city'] != $_POST['s_m_ins_city'] ||
                                                $s_m_r['state'] != $_POST['s_m_ins_state'] ||
                                                $s_m_r['zip'] != $_POST['s_m_ins_zip'] ||
                                                num($s_m_r['fax']) != num($_POST['s_m_ins_fax']) ||
                                                $s_m_r['email'] != $_POST['s_m_ins_email'] ||
                                                num($s_m_r['phone']) != num($_POST['s_m_ins_phone']) 

                                        ){

                                          $insql = "INSERT INTO dental_patient_insurance SET " .
                                                "insurancetype = '2', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "company = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_company']) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_zip']) . "', " .
                                                "fax = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_fax']) . "', " .
                                                "email = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_email']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['s_m_ins_phone'])) . "';";
                                          mysqli_query($con, $insql);
                                          $id = mysqli_insert_id($con);
					  echo '{"s_m_patient_insuranceid": "'.$id.'"}';
					}
                                    }else{
                                        $insql = "UPDATE dental_patient_insurance SET " .
                                                "insurancetype = '2', " .
                                                "patientid = '" . mysqli_real_escape_string($con, $_SESSION['pid']) . "', " .
                                                "company = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_company']) . "', " .
                                                "address1 = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_address1']) . "', " .
                                                "address2 = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_address2']) . "', " .
                                                "city = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_city']) . "', " .
                                                "state = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_state']) . "', " .
                                                "zip = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_zip']) . "', " .
                                                "fax = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_fax']) . "', " .
                                                "email = '" . mysqli_real_escape_string($con, $_POST['s_m_ins_email']) . "', " .
                                                "phone = '" . mysqli_real_escape_string($con, num($_POST['s_m_ins_phone'])) . "' " .
                                                "WHERE id = '". mysqli_real_escape_string($con, $_POST['s_m_patient_insuranceid']) ."'";
                                        mysqli_query($con, $insql);
				    }
                                }



?>
