<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include "includes/general_functions.php";
//include "includes/top.htm";

if(isset($_POST['merge_but'])){
  $l = $_POST['loser'];
  $w = $_POST['winner'];

  $w_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_string($w)."'";
  $w_q = mysql_query($w_sql);
  $w_r = mysql_fetch_assoc($w_q);

  $l_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_string($l)."'";
  $l_q = mysql_query($l_sql);
  $l_r = mysql_fetch_assoc($l_q);

$fields = array();
$fields[] = "salutation";
$fields[] = "firstname";
$fields[] = "lastname";
$fields[] = "company";
$fields[] = "add1";
$fields[] = "add2";
$fields[] = "city";
$fields[] = "state";
$fields[] = "zip";
$fields[] = "phone1";
$fields[] = "phone2";
$fields[] = "fax";
$fields[] = "email";
$fields[] = "national_provider_id";
$fields[] = "qualifier";
$fields[] = "qualifierid";
$fields[] = "greetings";
$fields[] = "sincerely";
$fields[] = "contacttypeid";
$fields[] = "notes";
$fields[] = "preferredcontact";
$fields[] = "status";
$fields[] = "referredby_info";
$fields[] = "referredby_notes";
$fields[] = "dea_number";
$first = true;
$up_sql = "UPDATE dental_contact SET ";
  foreach($fields as $field){
    if($w_r[$field]=='' && $l_r[$field]!=''){
	if(!$first){
      	  $up_sql .= ", ".$field."='".$l_r[$field]."'";
	}else{
	  $first = false;
	}
    }

  }
  $up_sql .= " WHERE contactid='".mysql_real_escape_string($w_r['contactid'])."'";
  mysql_query($up_sql);
 $loser_sql = "UPDATE dental_contact SET merge_id='".mysql_real_escape_string($w_r['contactid'])."', merge_date=NOW() WHERE contactid='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($loser_sql);
$letters_sql = "SELECT * FROM dental_letters WHERE FIND_IN_SET(".$l.", md_list)";
$letters_q = mysql_query($letters_sql);
while($letters_r = mysql_fetch_assoc($letters_q)){
  $md_list = explode(",",$letters_r['md_list']);
  $md_key = array_search($l_r['contactid'], $md_list);
  $md_list[$md_key] = $w_r['contactid'];
  $md_input = implode(",",$md_list);
  $up_sql = "UPDATE dental_letters SET md_list='".$md_input."' WHERE letterid='".$letters_r['letterid']."'";
echo $up_sql;
  mysql_query($up_sql);
}

$letters_sql = "SELECT * FROM dental_letters WHERE ".$l." IN (md_referral_list)";
$letters_q = mysql_query($letters_sql);
while($letters_r = mysql_fetch_assoc($letters_q)){
  $ref_list = explode(",",$letters_r['ref_list']);
  $ref_key = array_search($l_r['contactid'], $ref_list); 
  $ref_list[$ref_key] = $w_r['contactid'];
  $ref_input = implode(",",$ref_list);
  $up_sql = "UPDATE dental_letters SET md_referral_list='".$ref_input."' WHERE letterid='".$letters_r['letterid']."'";
  mysql_query($up_sql);
}




  $ref_sql = "UPDATE dental_patients SET referred_by='".mysql_real_escape_string($w_r['contactid'])."' WHERE referred_source='2' AND referred_by='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($ref_sql);

  $doc_sql = "UPDATE dental_patients SET docsleep='".mysql_real_escape_string($w_r['contactid'])."' WHERE docsleep='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docpcp='".mysql_real_escape_string($w_r['contactid'])."' WHERE docpcp='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docdentist='".mysql_real_escape_string($w_r['contactid'])."' WHERE docdentist='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docent='".mysql_real_escape_string($w_r['contactid'])."' WHERE docent='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docmdother='".mysql_real_escape_string($w_r['contactid'])."' WHERE docmdother='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docmdother2='".mysql_real_escape_string($w_r['contactid'])."' WHERE docmdother2='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);
  $doc_sql = "UPDATE dental_patients SET docmdother3='".mysql_real_escape_string($w_r['contactid'])."' WHERE docmdother3='".mysql_real_escape_string($l_r['contactid'])."'";
  mysql_query($doc_sql);



}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
  <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="js/masks.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>

	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>

    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
	<input type="hidden" name="winner" value="<?= $_REQUEST['winner']; ?>" />
	<?php
		$p_sql = "SELECT dct.physician FROM dental_contacttype dct
				JOIN dental_contact dc ON dc.contacttypeid=dct.contacttypeid
				WHERE dc.contactid='".mysql_real_escape_string($_REQUEST['winner'])."'"; 
		$p_q = mysql_query($p_sql);
                $pr = mysql_fetch_assoc($p_q);

		$sql = "SELECT dc.* FROM dental_contact dc 
			JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid WHERE ";
 		if($pr['physician']==1){
		  $sql .= " dct.physician=1 ";
		}else{
		  $sql .= " (dct.physician IS NULL OR dct.physician=0 OR dct.physician='') ";
		}
		$sql .= " AND merge_id IS NULL ORDER BY dc.lastname ASC, dc.firstname ASC, dc.company ASC";
		$q = mysql_query($sql);
        ?>
	<select name="loser">
	  <?php while($r = mysql_fetch_assoc($q)){ ?>
	  <?php
		$name = ($r['firstname']!='' || $r['lastname']!='')?$r['firstname']." ".$r['lastname']:$r['company'];
	  ?>
	  <option value="<?= $r['contactid']; ?>"><?= $name; ?></option>	
	  <?php } ?>
	</select>
<br />
                <input name="merge_but" type="submit" value=" Merge Contact" class="button" />
    </form>

      </div>
<script type="text/javascript" src="script/contact.js"></script>

</body>
</html>
