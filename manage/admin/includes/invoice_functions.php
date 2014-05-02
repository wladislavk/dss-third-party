<?php



function invoice_create($user_type, $user_id){

  if($user_type == '1'){
    $sql = "INSERT INTO dental_percase_invoice SET
		docid = '".mysql_real_escape_string($user_id)."',
		status = '".mysql_real_escape_string(DSS_INVOICE_PENDING)."',
		adddate = now(),
		ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";

    $q = mysql_query($sql);
    return mysql_insert_id();
  }


}



function invoice_find($user_type, $user_id){

  if($user_type == '1'){
    $sql = "SELECT id FROM dental_percase_invoice 
		WHERE docid='".mysql_real_escape_string($user_id)."'
		AND status = '".DSS_PERCASE_PENDING."'";
    $q = mysql_query($sql);
    if(mysql_num_rows($q) > 0){
        $r = mysql_fetch_assoc($q);
	return $r['id'];
    }else{
      return invoice_create($user_type, $user_id);
    }
  }

}


function invoice_add_efile{


}







?>
