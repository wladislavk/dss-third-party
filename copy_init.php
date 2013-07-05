<?php

include 'manage/admin/includes/config.php';


$s = "SELECT u.userid FROM dental_users u WHERE u.userid NOT IN (select distinct docid from dental_transaction_code WHERE docid IS NOT NULL) and u.docid=0";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){
  	$userid = $r['userid'];
	$code_sql = "insert into dental_transaction_code (transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, docid, amount_adjust) SELECT transaction_code, description, place, modifier_code_1, modifier_code_2, days_units, type, sortby, ".$userid.", amount_adjust FROM dental_transaction_code WHERE default_code=1";
        //mysql_query($code_sql) or die($code_sql.mysql_error());
}


$s = "SELECT u.userid FROM dental_users u WHERE u.userid NOT IN (SELECT distinct docid FROM dental_appt_types WHERE docid IS NOT NULL) and u.docid=0";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){
        $userid = $r['userid'];
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('General', 'FFF9CF', 'general', ".$userid.")");
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Follow-up', 'D6CFFF', 'follow-up', ".$userid.")");
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Sleep Test', 'CFF5FF', 'sleep_test', ".$userid.")");
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Impressions', 'DFFFCF', 'impressions', ".$userid.")");
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('New Pt', 'FFCFCF', 'new_pt', ".$userid.")");
                        //mysql_query("INSERT INTO `dental_appt_types` (name, color, classname, docid) VALUES ('Deliver Device', 'FBA16C', 'deliver_device', ".$userid.")");
}
$s = "SELECT u.userid FROM dental_users u WHERE u.userid NOT IN (SELECT distinct docid FROM dental_resources WHERE docid IS NOT NULL) and u.docid=0";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){
        $userid = $r['userid'];
                        //mysql_query("INSERT INTO `dental_resources` (name, rank, docid) VALUES ('Chair 1', 1, ".$userid.")");

}

$s = "SELECT u.userid FROM dental_users u WHERE u.userid NOT IN (SELECT docid FROM dental_custom WHERE docid IS NOT NULL group by docid having count(customid) > 4) and u.docid=0";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){
        $userid = $r['userid'];
                        $custom_sql = "insert into dental_custom (title, description, docid) SELECT title, description, ".$userid." FROM dental_custom WHERE default_text=1";
                        //mysql_query($custom_sql) or die($custom_sql.mysql_error());

}
?>
