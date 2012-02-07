<?php
include 'manage/admin/includes/config.php';


/*****************************
** Update Complaints q page1
*****************************/
echo "<b>UPDATE Complaints Questionnaire Page 1</b><br /><br />";
$deleted = array(15, 16, 17);
$sql = "SELECT patientid, complaintid, other_complaint FROM dental_q_page1";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){
$pid = $r['patientid'];
$complaintid= $r['complaintid'];
$othercomp = $r['other_complaint'];
$compid = array();
$compseq = array();
if($complaintid <> '')
{
        $comp_arr1 = split('~',$complaintid);

        foreach($comp_arr1 as $i => $val)
        {
                $comp_arr2 = explode('|',$val);

                $compid[$i] = $comp_arr2[0];
                $compseq[$i] = $comp_arr2[1];
        }
}
foreach($deleted as $d){
if(in_array($d, $compid)){
  $s = "SELECT * FROM dental_complaint WHERE complaintid='".$d."' LIMIT 1";
  $cq = mysql_query($s);
  $c = mysql_fetch_assoc($cq);
  $othercomp .= (trim($othercomp!=''))?", ":''; 
  $othercomp .= $c['complaint'];
}
}
$upsql = "UPDATE dental_q_page1 SET other_complaint='".$othercomp."' WHERE patientid='".$pid."'";
//mysql_query($upsql);
echo $pid . " - ";
echo $upsql."<br />";
//print_r($compseq);
}
echo "--------------------------------------------<br />
--------------------------------------------<br />";

/*******************************************
** OTHER ATTMPTED SURGERIES
*******************************************/
echo "<b>UPDATE Other attempted surgeries</b><br /><br  />";
$ssql = "SELECT other, other_therapy, patientid from dental_q_page2";
$sq = mysql_query($ssql);
while($sr = mysql_fetch_assoc($sq)){

$o = $sr['other'];
$ot = $sr['other_therapy'];
$ot .= (trim($ot)!=''&&trim($o)!='')?', ':'';
$ot .= str_replace('~',', ',substr($o, 1, strlen($o)-2));
$upssql = "UPDATE dental_q_page2 SET other_therapy='".$ot."' WHERE patientid='".$sr['patientid']."'";
//mysql_query($upssql);
echo $sr['patientid']." - ".$upssql."<br />";
}


/*****************************************
** MEDICAL HISTORY
*****************************************/

echo "<b>UPDATE medical history</b><br /><br  />";
$mhsql = "SELECT allergens, other_allergens, medications, other_medications, history, other_history, patientid from dental_q_page3";
$mhq = mysql_query($mhsql);
while($mhr = mysql_fetch_assoc($mhq)){

$all = split('~', $mhr['allergens']);
$med = split('~', $mhr['medications']);
$his = split('~', $mhr['history']);
$oa = $mhr['other_allergens'];
$om = $mhr['other_medications'];
$oh = $mhr['other_history'];

$asql = "SELECT * from dental_allergens";
$aq = mysql_query($asql);
while($ar = mysql_fetch_assoc($aq)){
  if(in_array($ar['allergensid'], $all)){
	$oa .= ($oa!='')?', ':'';
	$oa .= $ar['allergens'];
  }
} 

$msql = "SELECT * from dental_medications";
$mq = mysql_query($msql);
while($mr = mysql_fetch_assoc($mq)){
  if(in_array($mr['medicationsid'], $med)){
        $om .= ($om!='')?', ':'';
        $om .= $mr['medications'];
  }
} 

$hsql = "SELECT * from dental_history";
$hq = mysql_query($hsql);
while($hr = mysql_fetch_assoc($hq)){
  if(in_array($hr['historyid'], $his)){
        $oh .= ($oh!='')?', ':'';
        $oh .= $hr['history'];
  }
} 

$upmhsql = "UPDATE dental_q_page3 set other_allergens='".$oa."', other_medications='".$om."', other_history='".$oh."' where patientid='".$mhr['patientid']."'";
//mysql_query($upmhsql);
echo $mhr['patientid']." - ".$upmhsql."<br />";

}


?>
