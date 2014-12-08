<?php
include "includes/top.htm";
if(is_billing($_SESSION['admin_access'])){
  ?><h2>You are not authorized to view this page.</h2><?php
  die();
}

if(isset($_GET['bounce'])){
  $s = "UPDATE dental_patients SET email_bounce='1'
		WHERE patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'
			AND docid='".mysqli_real_escape_string($con,$_GET['docid'])."'";
  $q = mysqli_query($con,$s);
  if($q){
  $s = "SELECT * from dental_patients where patientid='".mysqli_real_escape_string($con,$_GET['pid'])."'
                        AND docid='".mysqli_real_escape_string($con,$_GET['docid'])."'";
  $q = mysqli_query($con,$s);
  if($r = mysqli_fetch_assoc($q)){
    $msg = "Bounce marked for ".$r['firstname']." ".$r['lastname'];
  }
  }
}

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Email Bounces	
</div>
<br />

<div align="center" class="red">
	<b><?php echo (!empty($msg) ? $msg : ''); ?></b>
</div>
<form action="email_bounce.php" method="post">
 Email: <input type="text" name="email" value="<?php echo  (!empty($_REQUEST['email']) ? $_REQUEST['email'] : ''); ?>" />
<input type="submit" value="Search" class="btn btn-primary">

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
		WHERE uc.companyid = '".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."' AND p.email like '%".$_REQUEST['email']."%' AND p.parent_patientid IS NULL ORDER BY p.email ASC";
	}
	$q = mysqli_query($con,$s);
	if(mysqli_num_rows($q)==0){
		?><h3>NO RESULTS</h3><?php
	}else{
	?><table class="table table-bordered table-hover">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>User</th>
			<th>Company</th>
			<th>Action</th>
		</tr>
	<?php
	while($r = mysqli_fetch_assoc($q)){
		?><tr> 
			<td><?php echo  $r['firstname']." ".$r['lastname']; ?></td>
			<td><?php echo  $r['email']; ?></td>
			<td><?php echo  $r['user_name']; ?></td>
			<Td><?php echo  $r['company_name']; ?></td>
			<td><a style="margin-right:20px;" href="#" onclick="Javascript: loadPopup('add_patient.php?ed=<?php echo  $r['patientid']; ?>&amp;docid=<?php echo  $r['docid']; ?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
				
				<a href="email_bounce.php?pid=<?php echo  $r['patientid']; ?>&amp;docid=<?php echo  $r['docid']; ?>&bounce=1&email=<?php echo  urlencode($_REQUEST['email']); ?>" title="Edit" class="btn btn-primary btn-sm">
                                                Mark Bounce 
                                         <span class="glyphicon glyphicon-pencil"></span></a>
			</td>
		<?php
	}
	?></table><?php
	}
}
?>

<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
