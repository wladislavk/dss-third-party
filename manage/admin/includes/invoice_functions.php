<?php



// create new invoice for user and return id
function invoice_create($user_type, $user_id, $inv_type){

  if($user_type == '1'){ //Front office is billed
    $sql = "INSERT INTO dental_percase_invoice SET
		docid = '".mysql_real_escape_string($user_id)."',
		status = '".mysql_real_escape_string(DSS_INVOICE_PENDING)."',
		invoice_type = '".mysql_real_escape_string($inv_type)."',
		adddate = now(),
		ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
  }elseif($user_type == '2'){ //Billing company is billed
    $sql = "INSERT INTO dental_percase_invoice SET
                companyid = '".mysql_real_escape_string($user_id)."',
                status = '".mysql_real_escape_string(DSS_INVOICE_PENDING)."',
		invoice_type = '".DSS_INVOICE_TYPE_SU_BC."',
                adddate = now(),
                ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
  }


}


//Find existing pending invoice for user
function invoice_find($user_type, $user_id, $inv_type = DSS_INVOICE_TYPE_SU_FO){

  if($user_type == '1'){
    $sql = "SELECT id FROM dental_percase_invoice 
		WHERE docid='".mysql_real_escape_string($user_id)."'
		AND invoice_type='".mysql_real_escape_string($inv_type)."'
		AND status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
	return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_create($user_type, $user_id, $inv_type);
    }
  }elseif($user_type == '2'){
    $sql = "SELECT id FROM dental_percase_invoice 
                WHERE companyid='".mysql_real_escape_string($user_id)."'
		AND invoice_type='".DSS_INVOICE_TYPE_SU_BC."',
                AND status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_create($user_type, $user_id, $inv_type);
    }
  }

}


function invoice_add_efile($user_type, $user_id, $eid){
  $inv_id = invoice_find($user_type, $user_id);
  $sql = "UPDATE dental_claim_electronic SET
    	percase_invoice = '".mysql_real_escape_string($inv_id)."'
	WHERE id='".mysql_real_escape_string($eid)."'";
  return mysql_query($sql);
}

function invoice_add_claim($user_type, $user_id, $eid){
  $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
  $sql = "UPDATE dental_insurance SET
        percase_invoice = '".mysql_real_escape_string($inv_id)."'
        WHERE insuranceid='".mysql_real_escape_string($eid)."'";
  return mysql_query($sql);
}

function invoice_add_e0486($user_type, $user_id, $eid){
  $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
  $sql = "UPDATE dental_ledger SET
        percase_invoice = '".mysql_real_escape_string($inv_id)."'
        WHERE ledgerid='".mysql_real_escape_string($eid)."'";
  return mysql_query($sql);
}

function invoice_add_vob($user_type, $user_id, $eid){
  $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
  $sql = "UPDATE dental_insurance_preauth SET
        invoice_id = '".mysql_real_escape_string($inv_id)."'
        WHERE id='".mysql_real_escape_string($eid)."'";
  
  return mysql_query($sql);
}




// create new eligibility invoice for user and return id
function invoice_eligibility_create($user_type, $user_id){

    $inv_id = invoice_find($user_type, $user_id);
    $sql = "INSERT INTO dental_eligibility_invoice SET
                invoice_id = '".mysql_real_escape_string($inv_id)."',
                adddate = now(),
                ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
}

//find existing pending eligibility
function invoice_eligibility_find($user_type, $user_id){
  if($user_type == '1'){
    $sql = "SELECT ei.id FROM dental_percase_invoice i
		JOIN dental_eligibility_invoice ei ON ei.invoice_id=i.id
                WHERE i.docid='".mysql_real_escape_string($user_id)."'
                AND i.status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_eligibility_create($user_type, $user_id);
    }
  }elseif($user_type == '2'){
    $sql = "SELECT ei.id FROM dental_percase_invoice i
                JOIN dental_eligibility_invoice ei ON ei.invoice_id=i.id
                WHERE i.companyid='".mysql_real_escape_string($user_id)."'
                AND i.status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_eligibility_create($user_type, $user_id);
    }
  }
}

function invoice_add_eligibility($user_type, $user_id, $eid){
  $inv_id = invoice_eligibility_find($user_type, $user_id);
  $sql = "UPDATE dental_eligibility SET
        eligibility_invoice_id = '".mysql_real_escape_string($inv_id)."'
        WHERE id='".mysql_real_escape_string($eid)."'";
  error_log($sql);
  return mysql_query($sql);
}

//////////////////
//ENROLLMENTS

// create new eligibility invoice for user and return id
function invoice_enrollment_create($user_type, $user_id){

  if($user_type == '1'){
    $inv_id = invoice_find($user_type, $user_id);
    $sql = "INSERT INTO dental_enrollment_invoice SET
                invoice_id = '".mysql_real_escape_string($inv_id)."',
                adddate = now(),
                ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
  }elseif($user_type == '2'){
    $inv_id = invoice_find($user_type, $user_id);
    $sql = "INSERT INTO dental_enrollment_invoice SET
                invoice_id = '".mysql_real_escape_string($inv_id)."',
                adddate = now(),
                ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
  }

}

//find existing pending eligibility
function invoice_enrollment_find($user_type, $user_id){
  if($user_type == '1'){
    $sql = "SELECT ei.id FROM dental_percase_invoice i
                JOIN dental_enrollment_invoice ei ON ei.invoice_id=i.id
                WHERE i.companyid='".mysql_real_escape_string($user_id)."'
                AND i.status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_enrollment_create($user_type, $user_id);
    }
  }elseif($user_type == '2'){
    $sql = "SELECT ei.id FROM dental_percase_invoice i
                JOIN dental_enrollment_invoice ei ON ei.invoice_id=i.id
                WHERE i.docid='".mysql_real_escape_string($user_id)."'
                AND i.status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_enrollment_create($user_type, $user_id);
    }
  }
}

function invoice_add_enrollment($user_type, $user_id, $eid){
  $inv_id = invoice_enrollment_find($user_type, $user_id);
  $sql = "UPDATE dental_eligible_enrollment SET
        enrollment_invoice_id = '".mysql_real_escape_string($inv_id)."'
        WHERE id='".mysql_real_escape_string($eid)."'";
  return mysql_query($sql);
}

// create new eligibility invoice for user and return id
function invoice_fax_create($user_type, $user_id){

  if($user_type == '1'){
    $inv_id = invoice_find($user_type, $user_id);
    $sql = "INSERT INTO dental_fax_invoice SET
                invoice_id = '".mysql_real_escape_string($inv_id)."',
                adddate = now(),
                ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    $q = mysql_query($sql);
    return mysql_insert_id();
  }
}

//find existing pending faxes
function invoice_fax_find($user_type, $user_id){
  if($user_type == '1'){
    $sql = "SELECT fi.id FROM dental_percase_invoice i
                JOIN dental_fax_invoice fi ON fi.invoice_id=i.id
                WHERE i.docid='".mysql_real_escape_string($user_id)."'
                AND i.status = '".DSS_INVOICE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
        return $r['id'];
    }else{  // if no pending invoice create new
      return invoice_fax_create($user_type, $user_id);
    }
  }
}

function invoice_add_fax($user_type, $user_id, $fid){
  $inv_id = invoice_fax_find($user_type, $user_id);
  $sql = "UPDATE dental_faxes SET
        fax_invoice_id = '".mysql_real_escape_string($inv_id)."'
        WHERE id='".mysql_real_escape_string($fid)."'";
  return mysql_query($sql);
}

?>
