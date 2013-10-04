<?php
require_once('admin/includes/main_include.php');

function similar_doctors($id){
$s = "SELECT * from dental_patient_contacts WHERE id='".$id."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$s2 = "SELECT * FROM dental_contact WHERE " .
                "contacttypeid != '11' AND " .
                "((firstname = '".$r['firstname']."' AND " .
                "lastname = '".$r['lastname']."') " .
        " OR " .
                "(add1 = '".$r['address1']."' AND add1!='' AND " .
                "city = '".$r['city']."' AND city!='' AND " .
                "state = '".$r['state']."' AND state!='' AND " .
                "zip = '".$r['zip']."' AND zip!='')) 

		AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";
$q2 = mysql_query($s2);
$docs = array();
$c = 0;
while($r2 =  mysql_fetch_assoc($q2)){
$docs[$c]['id'] = $r2['contactid'];
$docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
$docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
$docs[$c]['phone'] = $r2['phone1'];
$c++;
}

return $docs;
}

function similar_contacts($id){
$s = "SELECT * from dental_contact WHERE contactid='".$id."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$s2 = "SELECT * FROM dental_contact WHERE status IN (1,2) AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND " .
                "((firstname = '".$r['firstname']."' AND " .
                "lastname = '".$r['lastname']."') " .
        " OR " .
                "(add1 = '".$r['add1']."' AND add1!='' AND " .
                "city = '".$r['city']."' AND city!='' AND " .
                "state = '".$r['state']."' AND state!='' AND " .
                "zip = '".$r['zip']."' AND zip!='')) 

                AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";

$q2 = mysql_query($s2);
$docs = array();
$c = 0;
while($r2 =  mysql_fetch_assoc($q2)){
$docs[$c]['id'] = $r2['contactid'];
$docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
$docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
$docs[$c]['phone1'] = $r2['phone1'];
$c++;
}

return $docs;
}


function similar_patients($id){
$s = "SELECT * from dental_patients WHERE patientid='".$id."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);
$simsql = "(select count(*) FROM dental_patients dp WHERE dp.status=1 AND dp.docid='".mysql_real_escape_string($_SESSION['docid'])."' AND 
                ((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR
                (dp.add1=p.add1 AND dp.city=p.city AND dp.state=p.state AND dp.zip=p.zip))
                )


                AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";
$s2 = "SELECT * FROM dental_patients WHERE " .
		"patientid != ".$id." AND " .
		"status='1' AND docid='".mysql_real_escape_string($_SESSION['docid'])."' AND " .
		"((firstname = '".$r['firstname']."' AND " .
	        "lastname = '".$r['lastname']."') OR " .
		"(add1 = '".$r['add1']."' AND add1!= '' AND city = '".$r['city']."' AND city!='' AND state = '".$r['state']."' AND state!='' AND zip = '".$r['zip']."' AND zip!=''))


                AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";

		 
$q2 = mysql_query($s2);
$docs = array();
$c = 0;
while($r2 =  mysql_fetch_assoc($q2)){
$docs[$c]['id'] = $r2['patientid'];
$docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
$docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
$docs[$c]['phone'] = $r2['phone1'];
$c++;
}

return $docs;
}


function similar_insurance($id){
$s = "SELECT * from dental_patient_insurance WHERE id='".$id."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$s2 = "SELECT * FROM dental_contact WHERE " .
		"contacttypeid =  '11' AND " .
                "(company LIKE '%".$r['company']."%' " .
        " OR " .
                "(add1 = '".$r['address1']."' AND add1!='' AND " .
                "city = '".$r['city']."' AND city!='' AND " .
                "state = '".$r['state']."' AND state!='' AND " .
                "zip = '".$r['zip']."' AND zip!='')) 

                AND docid='".mysql_real_escape_string($_SESSION['docid'])."'";

$q2 = mysql_query($s2);
$docs = array();
$c = 0;
while($r2 =  mysql_fetch_assoc($q2)){
$docs[$c]['id'] = $r2['contactid'];
$docs[$c]['name'] = $r2['company'];
$docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
$docs[$c]['phone'] = $r2['phone1'];
$c++;
}

return $docs;
}
?>
