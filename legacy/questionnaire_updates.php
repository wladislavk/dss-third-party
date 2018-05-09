<?php namespace Ds3\Libraries\Legacy; ?><?php
include 'manage/admin/includes/config.php';
$run_updates = false;
if(true){ //to prevent output if set to false
/*****************************
** Update Complaints q page1
*****************************/
echo "<b>UPDATE Complaints Questionnaire Page 1</b><br /><br />";
$deleted = array(15, 16, 17);
$sql = "SELECT patientid, complaintid, other_complaint FROM dental_q_page1_view";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
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
  $cq = mysqli_query($con, $s);
  $c = mysqli_fetch_assoc($cq);
  $othercomp .= (trim($othercomp!=''))?", ":''; 
  $othercomp .= $c['complaint'];
}
}
if(trim($othercomp)!=''){
  if($run_updates){
    mysqli_query($con, "UPDATE dental_q_page1_view SET complaintid=CONCAT(complaintid,'0|1~') WHERE patientid='".$pid."'");
  }
}
$upsql = "UPDATE dental_q_page1_view SET other_complaint='".$othercomp."' WHERE patientid='".$pid."'";
if($run_updates){
  mysqli_query($con, $upsql);
}
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
$ssql = "SELECT other, other_therapy, patientid from dental_q_page2_view";
$sq = mysqli_query($con, $ssql);
while($sr = mysqli_fetch_assoc($sq)){

$o = $sr['other'];
$ot = $sr['other_therapy'];
$ot .= (trim($ot)!=''&&trim($o)!='')?', ':'';
$ot .= str_replace('~',', ',substr($o, 1, strlen($o)-2));
$upssql = "UPDATE dental_q_page2_view SET other_therapy='".$ot."' WHERE patientid='".$sr['patientid']."'";
if($run_updates){
  mysqli_query($con, $upssql);
}
echo $sr['patientid']." - ".$upssql."<br />";
}

$isql = "SELECT intolerance, other_intolerance, q_page2id FROM dental_q_page2_view";
$iq = mysqli_query($con, $isql);
while($ir = mysqli_fetch_assoc($iq)){
  if($ir['other_intolerance']!=''){
	$int = $ir['intolerance'];
	if($int==''){
	  $int .= "~0~";
	}else{
          $int .= "0~";
	}
  }
  $upisql = "UPDATE dental_q_page2_view SET intolerance='".$int."' WHERE q_page2id='".$ir['q_page2id']."'";
  if($run_updates){
    mysqli_query($con, $upisql);
  }
}

$cpapsql = "UPDATE dental_q_page2_view SET cur_cpap='Yes', cpap='Yes' WHERE percent_night_cpap!='' OR  nights_wear_cpap!=''";
if($run_updates){
  mysqli_query($con, $cpapsql);
}

/*****************************************
** Gum Problems
******************************************/
$gp_sql = "SELECT gum_problems, q_page3id from dental_q_page3_view";
$gp_q = mysqli_query($con, $gp_sql);
while($gp_r = mysqli_fetch_assoc($gp_q)){
  if($run_updates && trim($gp_r['gum_problems']) != ''){
	mysqli_query($con, "UPDATE dental_q_page3_view set gum_prob='Yes', gum_prob_text=gum_problems WHERE q_page3id='".$gp_r['q_page3id']."'");
  }
}


/*****************************************
** Health History
*****************************************/

//////////////////////////
//Medical History

echo "<b>UPDATE medical history</b><br /><br  />";
$mhsql = "SELECT allergens, other_allergens, medications, other_medications, history, other_history, patientid from dental_q_page3_view";
$mhq = mysqli_query($con, $mhsql);
while($mhr = mysqli_fetch_assoc($mhq)){

$all = split('~', $mhr['allergens']);
$med = split('~', $mhr['medications']);
$his = split('~', $mhr['history']);
$oa = $mhr['other_allergens'];
$om = $mhr['other_medications'];
$oh = $mhr['other_history'];
$allc = ($mhr['other_allergens']!='' || $mhr['allergens']!='')?1:0;
$medc = ($mhr['other_medications']!='' || $mhr['medications']!='')?1:0;
$hisc = ($mhr['other_history']!='' || $mhr['history']!='')?1:0;

$asql = "SELECT * from dental_allergens";
$aq = mysqli_query($con, $asql);
while($ar = mysqli_fetch_assoc($aq)){
  if(in_array($ar['allergensid'], $all)){
	$oa .= ($oa!='')?', ':'';
	$oa .= $ar['allergens'];
  }
} 

$msql = "SELECT * from dental_medications";
$mq = mysqli_query($con, $msql);
while($mr = mysqli_fetch_assoc($mq)){
  if(in_array($mr['medicationsid'], $med)){
        $om .= ($om!='')?', ':'';
        $om .= $mr['medications'];
  }
} 

$hsql = "SELECT * from dental_history";
$hq = mysqli_query($con, $hsql);
while($hr = mysqli_fetch_assoc($hq)){
  if(in_array($hr['historyid'], $his)){
        $oh .= ($oh!='')?', ':'';
        $oh .= $hr['history'];
  }
} 

$upmhsql = "UPDATE dental_q_page3_view set allergenscheck=".$allc.", medicationscheck=".$medc.", historycheck=".$hisc.", other_allergens='".$oa."', other_medications='".$om."', other_history='".$oh."' where patientid='".$mhr['patientid']."'";
if($run_updates){
  mysqli_query($con, $upmhsql);
}
echo $mhr['patientid']." - ".$upmhsql."<br />";

}

$tmjsql = "UPDATE dental_q_page3_view set 
	tmj_cp = CASE tmj WHEN 'Popping or clicking' THEN 'Yes' ELSE 'No' END,
        tmj_pain = CASE tmj WHEN 'Pain in joint or muscles' THEN 'Yes' ELSE 'No' END
 ";
if($run_updates){
  mysqli_query($con, $tmjsql);
}

$injurysql = "UPDATE dental_q_page3_view SET
	injury = 'Yes'
	WHERE injurytohead = 'Yes' OR	
	injurytoneck = 'Yes' OR
	injurytoface = 'Yes' OR
	injurytoteeth = 'Yes' OR
	injurytomouth = 'Yes'";
if($run_updates){
  mysqli_query($con, $injurysql);
}

$gumsql = "UPDATE dental_q_page3_view SET
	gum_prob = 'Yes',
	gum_prob_text = gum_problems
	WHERE gum_problems != '' AND gum_problems IS NOT NULL";
if($run_updates){
  mysqli_query($con, $gum_sql);
}

$q4sql = "SELECT * from dental_q_page4_view";
$q4q = mysqli_query($con, $q4sql);
while($q4r = mysqli_fetch_assoc($q4q)){
  $pid = $q4r['patientid'];
  $upsql = "UPDATE dental_q_page3_view SET ";
  

  $family_had = $q4r['family_had'];
  if(strpos($family_had,'~Heart disease~') === false){
    $upsql .= " family_hd='No', ";
  }else{
    $upsql .= " family_hd='Yes', ";  
  }
  if(strpos($family_had,'~High Blood Pressure~') === false){
    $upsql .= " family_bp='No', ";
  }else{
    $upsql .= " family_bp='Yes', ";
  }
  if(strpos($family_had,'~Diabetes~') === false){
    $upsql .= " family_dia='No', ";
  }else{
    $upsql .= " family_dia='Yes', ";
  }
	
  $upsql .= " family_sd='".$q4r['family_diagnosed']."', ";
  $upsql .= " smoke='".$q4r['smoke']."', ";
  $upsql .= " smoke_packs='".$q4r['smoke_packs']."', ";
  $upsql .= " tobacco='".$q4r['tobacco']."', ";

  switch($q4r['alcohol']){
    case 'Daily':
      $al = 'Daily';
      break;
    case '1/day':
    case 'occasionally':
    case 'several days/week':
      $al = 'occasionally';
      break;
    case 'never':
      $al = 'never';
      break;
    default:
      $al = '';
      break;
  }
  $upsql .= " alcohol='".$al."', ";
  switch($q4r['sedative']){
    case 'Daily':
      $sed = 'Daily';
      break;
    case '1/day':
    case 'occasionally':
    case 'several days/week':
      $sed = 'occasionally';
      break;
    case 'never':
      $sed = 'never';
      break;
    default:
      $sed = '';
      break;
  }
  $upsql .= " sedative='".$sed."', ";
  switch($q4r['caffeine']){
    case 'Daily':
      $caf = 'Daily';
      break;
    case '1/day':
    case 'occasionally':
    case 'several days/week':
      $caf = 'occasionally';
      break;
    case 'never':
      $caf = 'never';
      break;
    default:
      $caf = '';
      break;
  }
  $upsql .= " caffeine='".$caf."', ";
  $upsql .= " additional_paragraph='".$q4r['additional_paragraph']."'";

  $upsql .= " WHERE patientid=".$pid;
  if($run_updates){
    mysqli_query($con, $upsql);
  }
}



$sql = "select * from dental_q_sleep_view";
$my = mysqli_query($con, $sql);
while($myarray = mysqli_fetch_array($my)){

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);
$eptotal = 0;
if($epworthid <> '')
{
        $epworth_arr1 = split('~',$epworthid);

        foreach($epworth_arr1 as $i => $val)
        {
                $epworth_arr2 = explode('|',$val);

                $epid[$i] = $epworth_arr2[0];
                $eptotal += $epworth_arr2[1];
        }
}

  $epsql = "UPDATE dental_q_page1_view SET ess='".$eptotal."' WHERE patientid='".$myarray['patientid']."'";
  echo $epsql."<br />";
  if($run_updates){
    mysqli_query($con, $epsql);
  }
}


$sql = "select * from dental_thorton_view";
$my = mysqli_query($con, $sql);
while($myarray = mysqli_fetch_array($my)){
$ttotal = 0;
$ttotal += $myarray['snore_1'];
$ttotal += $myarray['snore_2'];
$ttotal += $myarray['snore_3'];
$ttotal += $myarray['snore_4'];
$ttotal += $myarray['snore_5'];
  $tsql = "UPDATE dental_q_page1 SET tss='".$ttotal."' WHERE patientid='".$myarray['patientid']."'";
  echo $tsql."<br />";
  if($run_updates){
    mysqli_query($con, $tsql);
  }

}


//Update Salutation
$sql = "UPDATE dental_patients SET salutation='Ms.' WHERE salutation='Miss.'";
if($run_updates){
  mysqli_query($con, $sql);
}
$sql = "UPDATE dental_patients SET salutation='Dr.' WHERE salutation='Prof.'";
if($run_updates){
  mysqli_query($con, $sql);
}


//Move bmi to dental_patients
$sql = "SELECT patientid, feet, inches, weight, bmi from dental_q_page1";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
  $upsql = "UPDATE dental_patients set feet='".$r['feet']."', inches='".$r['inches']."', weight='".$r['weight']."', bmi='".$r['bmi']."' WHERE patientid='".$r['patientid']."'";
  echo $upsql."<br />";
  if($run_updates){
	mysqli_query($con, $upsql);
  }
}




}//close debug


?>
