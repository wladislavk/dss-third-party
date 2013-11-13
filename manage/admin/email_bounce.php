<? 
include "includes/top.htm";
if(is_billing($_SESSION['admin_access'])){
  ?><h2>You are not authorized to view this page.</h2><?php
  die();
}

if(isset($_GET['bounce'])){
  $s = "UPDATE dental_patients SET email_bounce='1'
		WHERE patientid='".mysql_real_escape_string($_GET['pid'])."'
			AND docid='".mysql_real_escape_string($_GET['docid'])."'";
  $q = mysql_query($s);
  if($q){
  $s = "SELECT * from dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'
                        AND docid='".mysql_real_escape_string($_GET['docid'])."'";
  $q = mysql_query($s);
  if($r = mysql_fetch_assoc($q)){
    $msg = "Bounce marked for ".$r['firstname']." ".$r['lastname'];
  }
  }
}

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Email Bounces	
</span>
<br />

<div align="center" class="red">
	<b><? echo $msg;?></b>
</div>
<form action="email_bounce.php" method="post">
 Email: <input type="text" name="email" value="<?= $_REQUEST['email']; ?>" />
<input type="submit" value="Search" />

</form>


<?php

if(isset($_REQUEST['email'])){

	if(is_super($_SESSION['admin_access'])){
	  $s = "SELECT p.*, u.name as user_name, c.name as company_name FROM dental_patients p
		LEFT JOIN dental_users u ON u.userid = p.docid
                LEFT JOIN dental_user_company uc ON uc.userid=p.docid
                LEFT JOIN companies c ON c.id=uc.companyid
		WHERE p.email like '%".$_REQUEST['email']."%' AND p.parent_patientid IS NULL ORDER BY p.email ASC";
	}else{
	  $s = "SELECT p.*, u.name as user_name, c.name as company_name FROM dental_patients p 
		JOIN dental_user_company uc ON uc.userid = p.docid
		LEFT JOIN dental_users u ON u.userid = p.docid
		LEFT JOIN companies c ON c.id=uc.companyid
		WHERE uc.companyid = '".mysql_real_escape_string($_SESSION['admincompanyid'])."' AND p.email like '%".$_REQUEST['email']."%' AND p.parent_patientid IS NULL ORDER BY p.email ASC";
	}
	$q = mysql_query($s);
	if(mysql_num_rows($q)==0){
		?><h3>NO RESULTS</h3><?php
	}else{
	?><table width="80%">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>User</th>
			<th>Company</th>
			<th>Action</th>
		</tr>
	<?php
	while($r = mysql_fetch_assoc($q)){
		?><tr> 
			<td><?= $r['firstname']." ".$r['lastname']; ?></td>
			<td><?= $r['email']; ?></td>
			<td><?= $r['user_name']; ?></td>
			<Td><?= $r['company_name']; ?></td>
			<td><a style="margin-right:20px;" href="#" onclick="Javascript: loadPopup('add_patient.php?ed=<?= $r['patientid']; ?>&amp;docid=<?= $r['docid']; ?>');" class="editlink" title="EDIT">
						Edit
					</a>
				
				<a href="email_bounce.php?pid=<?= $r['patientid']; ?>&amp;docid=<?= $r['docid']; ?>&bounce=1&email=<?= urlencode($_REQUEST['email']); ?>" class="editlink" title="EDIT">
                                                Mark Bounce 
                                        </a>
			</td>
		<?php
	}
	?></table><?php
	}
}
?>

<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
