<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");

	if(isset($_POST['merge_but'])){
		$l = $_POST['loser'];
		$w = $_POST['winner'];

		$w_sql = "SELECT * FROM dental_contact where contactid='".mysqli_real_escape_string($con, $w)."'";
		
		$w_r = $db->getRow($w_sql);

		$l_sql = "SELECT * FROM dental_contact where contactid='".mysqli_real_escape_string($con, $l)."'";
		
		$l_r = $db->getRow($l_sql);
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
		$updated = false;

		foreach($fields as $field){
			if(empty($w_r[$field]) && !empty($l_r[$field])) {
				if(!$first) {
					$up_sql .= ", ".$field."='".$l_r[$field]."'";
				} else {
					$up_sql = "UPDATE dental_contact SET " . $field . "='" . $l_r[$field] . "'";
					$first = false;
					$updated = true;
				}
			}
		}

		if ($updated) {
			$up_sql .= " WHERE contactid='".mysqli_real_escape_string($con, $w_r['contactid'])."'";
			$db->query($up_sql);
		}

		$loser_sql = "UPDATE dental_contact SET merge_id='".mysqli_real_escape_string($con, $w_r['contactid'])."', merge_date=NOW() WHERE contactid='".mysqli_real_escape_string($con, $l_r['contactid'])."'";
		
		$db->query($loser_sql);
		$letters_sql = "SELECT * FROM dental_letters WHERE FIND_IN_SET(".$l.", md_list)";
		
		$letters_q = $db->getResults($letters_sql);
		if ($letters_q) foreach ($letters_q as $letters_r) {
			$md_list = explode(",",$letters_r['md_list']);
			$md_key = array_search($l_r['contactid'], $md_list);
			$md_list[$md_key] = $w_r['contactid'];
			$md_input = implode(",",$md_list);
			$up_sql = "UPDATE dental_letters SET md_list='".$md_input."' WHERE letterid='".$letters_r['letterid']."'";
			
			$db->query($up_sql);
		}

		$letters_sql = "SELECT * FROM dental_letters WHERE ".$l." IN (md_referral_list)";
		
		$letters_q = $db->getResults($letters_sql);
		if ($letters_q) foreach ($letters_q as $letters_r){
			$ref_list = explode(",",$letters_r['ref_list']);
			$ref_key = array_search($l_r['contactid'], $ref_list); 
			$ref_list[$ref_key] = $w_r['contactid'];
			$ref_input = implode(",",$ref_list);
			$up_sql = "UPDATE dental_letters SET md_referral_list='".$ref_input."' WHERE letterid='".$letters_r['letterid']."'";
			
			$db->query($up_sql);
		}

		if($w_r['contactid']!=''){
			$ref_sql = "UPDATE dental_patients SET referred_by='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE referred_source='2' AND referred_by='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($ref_sql);
			$doc_sql = "UPDATE dental_patients SET docsleep='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docsleep='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docpcp='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docpcp='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docdentist='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docdentist='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
		 
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docent='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docent='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docmdother='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docmdother='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docmdother2='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docmdother2='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
			$doc_sql = "UPDATE dental_patients SET docmdother3='".mysqli_real_escape_string($con, $w_r['contactid'])."' WHERE docmdother3='".mysqli_real_escape_string($con, $l_r['contactid'])."' AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
			
			$db->query($doc_sql);
		}

		$loser_name = ($l_r['firstname']!='' || $l_r['lastname']!='')?$l_r['firstname']." ".$l_r['lastname']:"";
		$loser_name .= ($l_r['company']!='')?" (".$l_r['company'].")":"";
		$winner_name = ($w_r['firstname']!='' || $w_r['lastname']!='')?$w_r['firstname']." ".$w_r['lastname']:"";
		$winner_name .= ($w_r['company']!='')?" (".$w_r['company'].")":"";
?>
	<script type="text/javascript">
		alert('Contact <?php echo  $loser_name; ?> successfully merged with <?php echo  $winner_name; ?>');
		parent.window.location = "manage_contact.php"; 
	</script>
<?php
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
		<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
		<script type="text/javascript" src="js/masks.js"></script>
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="script/wufoo.js"></script>
	</head>

	<body>
		<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
		<?php
			$p_sql = "SELECT dct.physician, dc.firstname, dc.lastname FROM dental_contacttype dct
								JOIN dental_contact dc ON dc.contacttypeid=dct.contacttypeid
								WHERE dc.contactid='".mysqli_real_escape_string($con, $_REQUEST['winner'])."'";

			$pr = $db->getRow($p_sql);
		?>
	
		<div style="background:#fff;height:352px; padding: 20px; margin:0 3px;">
		<h2 style="margin-top:0px;">Merge Duplicate Contacts</h2>

		<strong>1. You've selected the "winner" of the merge</strong>
		<p>This "<?php echo  $pr['firstname']." ".$pr['lastname']; ?>" will be the "winner" of the merge. All info of the "loser" you choose below will be moved to "<?php echo  $pr['firstname']." ".$pr['lastname']; ?>"</p>

		<strong>2. Next, choose the person you want to merge (the "loser")</strong>
		<p>You can only choose one person. If you'd like to merge more than two people together just go through the merge process again after the merge you are performing now is done.</p>

		<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<input type="hidden" name="winner" value="<?php echo  $_REQUEST['winner']; ?>" />
			
			<?php
				$sql = "SELECT dc.* FROM dental_contact dc 
								JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid WHERE ";
				if($pr['physician']==1){
					$sql .= " dct.physician=1 ";
				} else {
					$sql .= " (dct.physician IS NULL OR dct.physician=0 OR dct.physician='') ";
				}

				$sql .= " AND dc.status=1 AND merge_id IS NULL AND docid='".$_SESSION['docid']."' AND contactid!='".mysqli_real_escape_string($con, $_REQUEST['winner'])."' ORDER BY dc.lastname ASC, dc.firstname ASC, dc.company ASC";
				
				$q = $db->getResults($sql);
			?>

			<p>
				<select name="loser">
					<?php if ($q) foreach ($q as $r) { ?>
						<?php
							$name = ($r['firstname']!='' || $r['lastname']!='')?$r['firstname']." ".$r['lastname']:"";
							$name .= ($r['company']!='')?" (".$r['company'].")":"";
						?>
						<option value="<?php echo  $r['contactid']; ?>"><?php echo  $name; ?></option>	
					<?php } ?>
				</select>
			</p>
			<br />
			<strong>3. Finally, click "Merge these contacts"</strong>
			<p><input name="merge_but" type="submit" value=" Merge these contacts" class="button" /></p>
		</form>
	</div>
</div>

<script type="text/javascript" src="script/contact.js"></script>

</body>
</html>
