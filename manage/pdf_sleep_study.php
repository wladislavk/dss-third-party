<? 
include "includes/top.htm";
include_once "includes/constants.inc";

if(isset($_FILES['pdf_file'])){
  $pdf = $_FILES['pdf_file']['tmp_name'];
  exec('pdftotext '.$pdf. ' -', $out); 
  $out = implode($out, ' ');
if (preg_match_all('/DIAGNOSIS\s+([^;]+)/m', $out, $matches)) {
    $diagnosis = $matches[1][0];
}

if (preg_match_all('/DIAG_PHYS:\s+([^;]+)/m', $out, $matches)) {
    $diagnosing_doc = $matches[1][0];
}

if (preg_match_all('/DIAG_PHYS_NPI:\s+([^;]+)/m', $out, $matches)) {
    $diagnosing_npi = $matches[1][0];
}

if (preg_match_all('/AHI\s+([^;]+)/m', $out, $matches)) {
    $ahi = str_replace(',','', $matches[1][2]);
}
if (preg_match_all('/RDI\s+([^;]+)/m', $out, $matches)) {
    $rdi = str_replace(',','', $matches[1][0]);
}
if (preg_match_all('/AHI_SUPINE\s+([^;]+)/m', $out, $matches)) {
    $ahi_supine = str_replace(',','', $matches[1][0]);
}
if (preg_match_all('/RDI_SUPINE\s+([^;]+)/m', $out, $matches)) {
    $rdi_supine = str_replace(',','', $matches[1][0]);
}

if (preg_match_all('/O2_NADIR\s+([^;]+)/m', $out, $matches)) {
    $o2_nadir = str_replace(',','', $matches[1][0]);
}
if (preg_match_all('/T\<90_O2\s+([^;]+)/m', $out, $matches)) {
    $t_90 = str_replace(',','', $matches[1][0]);
}

/*
if (preg_match_all('/DENTAL_DEVICE\s+([^,]+)/m', $out, $matches)) {
    $device = $matches[1][0];
}
if (preg_match_all('/DENTAL_DEVICE_SETTING\s+([^,]+)/m', $out, $matches)) {
    $device_setting = $matches[1][0];
}
*/

                if($_FILES["pdf_file"]["name"] <> '')
                {
                        $fname = $_FILES["pdf_file"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 = str_replace("'","_",$banner1);
                        $banner1 = str_replace("&","amp",$banner1);
                        $banner1 .= ".".$extension;

                        $uploaded = uploadImage($_FILES['pdf_file'], "../../../shared/q_file/".$banner1);

                }
                else
                {
                        $banner1 = '';
                }


  $sql = "INSERT INTO dental_summ_sleeplab set
		date='".date('m/d/Y')."',
		`diagnosising_doc` = '".mysql_real_escape_string($diagnosing_doc)."',
		`diagnosising_npi` = '".mysql_real_escape_string($diagnosing_npi)."',
		`ahi` = '".mysql_real_escape_string($ahi)."' ,
		`ahisupine` = '".mysql_real_escape_string($ahi_supine)."',
		`rdi` = '".mysql_real_escape_string($rdi)."',
		`rdisupine` = '".mysql_real_escape_string($rdi_supine)."',
		`o2nadir` = '".mysql_real_escape_string($o2_nadir)."',
		`t9002` = '".mysql_real_escape_string($t_90)."',
		`patiendid` = '".mysql_real_escape_string($_GET['pid'])."',
		`filename` = '".$banner1."'";
  mysql_query($sql);

                                        $ins_sql = " insert into dental_q_image set 
                                        patientid = '".s_for($_GET['pid'])."',
                                        title = '".$sleeptesttype." ".date('m/d/Y')."',
                                        imagetypeid = '1',
                                        image_file = '".s_for($banner1)."',
                                        userid = '".s_for($_SESSION['userid'])."',
                                        docid = '".s_for($_SESSION['docid'])."',
                                        adddate = now(),
                                        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                                        mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());






}

?>


<div class="fullwidth">
<form action="pdf_sleep_study.php?pid=<?= $_GET['pid']; ?>" method="post" enctype="multipart/form-data">

<label>PDF</label>
<input type="file" name="pdf_file">
<br /><br />
<input type="submit" value="Submit" />

</form>

</div>

<?php
  include 'includes/bottom.htm';
?>
