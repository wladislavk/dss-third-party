<? 
include "includes/top.htm";

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
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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

	$s = "SELECT * FROM dental_patients WHERE email like '%".$_REQUEST['email']."%' AND parent_patientid IS NULL ORDER BY email ASC";
	$q = mysql_query($s);
	if(mysql_num_rows($q)==0){
		?><h3>NO RESULTS</h3><?php
	}else{
	?><table width="80%">
		<tr>
			<th>Name</th>
			<th>Email</th>
			<th>Action</th>
		</tr>
	<?php
	while($r = mysql_fetch_assoc($q)){
		?><tr> 
			<td><?= $r['firstname']." ".$r['lastname']; ?></td>
			<td><?= $r['email']; ?></td>
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
