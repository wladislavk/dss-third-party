<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once('admin/includes/password.php');

    $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

    $sign_r = $db->getRow($sign_sql);
    $user_sign = $sign_r['sign_notes'];

	if(!empty($_POST["notesub"]) && $_POST["notesub"] == 1) {
		$notes = $_POST['notes'];
	   	$procedure_date = ($_POST['procedure_date']!='')?date('Y-m-d', strtotime($_POST['procedure_date'])):'';	
		$editor_initials = $_POST['editor_initials'];
		if($_POST['ed'] == '') {
			$ins_sql = "insert into dental_notes set 
						patientid = '".s_for($_GET['pid'])."',
						notes = '".s_for($notes)."',
						editor_initials = '".s_for($editor_initials)."',
						procedure_date = '".s_for($procedure_date)."',
						userid = '".s_for($_SESSION['userid'])."',
						docid = '".s_for($_SESSION['docid'])."',";
			if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)) {
			  	$ins_sql .= " signed_id='".s_for($_SESSION['userid'])."', signed_on=now(),";
			}elseif(isset($_POST['signstaff'])) {
		        $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con,$_POST['username'])."'";
        		$salt_row = $db->getRow($salt_sql);
        		$pass = gen_password($_POST['password'], $salt_row['salt']);
        		$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysqli_real_escape_string($con,$_POST['username'])."' and password='".$pass."' and status=1 AND (sign_notes=1 OR userid=".$_SESSION['docid'].")";
        		
        		$check_my = $db->getResults($check_sql);
        		if(count($check_my) == 1) {
					$check_myarray = $check_my[0];
					$ins_sql .= " signed_id='".s_for($check_myarray['userid'])."', signed_on=now(),";
?>
                    <script type="text/javascript">
                        alert("Progress Note SIGNED and saved successfully.");
                    </script>
<?php
				} else {
?>
					<script type="text/javascript">
						alert("Credential invalid - unable to SIGN note. Changes to note has been successfully saved, but note is UNSIGNED.");
					</script>	
<?php
				}
			}

			$ins_sql .= " adddate = now(), ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
			
		 	$id = $db->getInsertId($ins_sql);
			$db->query("UPDATE dental_notes SET parentid='".$id."' WHERE notesid='".$id."'");	
			$msg = "Added Successfully";
			
			if(isset($_REQUEST['goto'])) {
?>
	            <script type="text/javascript">
	                parent.window.location = '<?php echo  $_REQUEST['goto']; ?>';
	            </script>
<?php
			} else {
?>
	            <script type="text/javascript">
	                parent.window.location=  'dss_summ.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>&addtopat=1';
	            </script>
<?php 		
			} 
			trigger_error("Die called", E_USER_ERROR);
		} else {
			$p_r = $db->getRow("select parentid FROM dental_notes WHERE notesid='".$_POST["ed"]."'");
			$parentid = $p_r['parentid'];
			$ins_sql = "insert into dental_notes set 
		                patientid = '".s_for($_GET['pid'])."',
		                notes = '".s_for($notes)."',
		                editor_initials = '".s_for($editor_initials)."',
		                procedure_date = '".s_for($procedure_date)."',
		                userid = '".s_for($_SESSION['userid'])."',
		                docid = '".s_for($_SESSION['docid'])."',";
            if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)) {
              	$ins_sql .= " signed_id='".s_for($_SESSION['userid'])."', signed_on=now(), ";
            } elseif(isset($_POST['signstaff'])) {
	            $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con,$_POST['username'])."'";
	            
	            $salt_row = $db->getRow($salt_sql);
				$pass = gen_password($_POST['password'], $salt_row['salt']);
				$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysqli_real_escape_string($con,$_POST['username'])."' and password='".$pass."' and status=1 AND (sign_notes=1 OR userid=".$_SESSION['docid'].")";
                      
                $check_my = $db->getResults($check_sql);
                if(count($check_my) == 1)
                {
                    $check_myarray = $check_my[0];
                    $ins_sql .= " signed_id='".s_for($check_myarray['userid'])."', signed_on=now(), ";
                } else {
?>
                    <script type="text/javascript">
                        alert("Unable to sign note due to invalid credentials. Updated note has been saved.");
                    </script>
<?php
                }
            }

            $ins_sql .= " parentid='".$parentid."', adddate = now(), ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

			$up_sql = "update dental_notes set 
						patientid = '".s_for($_GET['pid'])."',
						notes = '".s_for($notes)."',
						editor_initials = '".s_for($editor_initials)."',
						procedure_date = '".s_for($procedure_date)."',
						edited = 1,";
            if(isset($_POST['sign']) && $_SESSION['docid']==$_SESSION['userid']){
              	$up_sql .= " signed_id='".s_for($_SESSION['userid'])."', signed_on=now(), ";
            }
            
            $up_sql .= " userid = '".s_for($_SESSION['userid'])."' where notesid='".$_POST["ed"]."'";
		
			$db->query($ins_sql);
			$msg = "Edited Successfully";
?>
		 	<?php if(isset($_REQUEST['goto'])){ ?>
		 		<script type="text/javascript">
					parent.window.location = "<?php echo  $_REQUEST['goto']; ?>";
				</script>
			<?php }else{ ?>
				<script type="text/javascript">
					parent.window.location = 'dss_summ.php?msg=<?php echo $msg;?>&pid=<?php echo $_GET['pid'];?>&addtopat=1';
				</script>
			<?php } ?>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}
	}
	$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
	
	$total_rec = $db->getNumberRows($sql);
	$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

	$pat_myarray = $db->getRow($pat_sql);
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);

	if($pat_myarray['patientid'] == '') {
?>
		<script type="text/javascript">
			window.location = 'manage_patient.php';
		</script>
<?php
		trigger_error("Die called", E_USER_ERROR);
	}
?>
	<?php
	    $sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
	    $my = $db->getResults($sql);

    $customNotes = [];

    if ($my) {
        foreach ($my as $myarray) {
            $customNotes []= [
                'title' => trim(utf8_encode($myarray['title'])),
                'description' => trim(utf8_encode($myarray['description']))
            ];
        }
    }

    $doc_sql = "SELECT name from dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
    $doc_r = $db->getRow($doc_sql);
	?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
		<script src="script/autocomplete.js"></script>
		<script type="text/javascript" src="js/add_notes.js"></script>
		<script language="javascript" type="text/javascript" src="script/validation.js"></script>
		<link rel="stylesheet" href="css/form.css" type="text/css" />
		<script type="text/javascript" src="script/wufoo.js"></script>
        <script type="text/javascript">
            var customNotes = <?= json_encode($customNotes) ?>;
        </script>
	</head>
	<body>
		<script language="JavaScript" src="calendar1.js"></script>
		<script language="JavaScript" src="calendar2.js"></script>
    	<?php
		
		include("includes/calendarinc.php");

		  $thesql = "select n.*, CONCAT(u.first_name,' ',u.last_name) added_name from dental_notes n
					LEFT JOIN dental_users u on u.userid=n.userid
					where notesid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
			$themyarray = $db->getRow($thesql);
			$notes = st($themyarray['notes']);
			$editor_initials = st($themyarray['editor_initials']);
			$procedure_date = ($themyarray['procedure_date']!='')?date('m/d/Y', strtotime($themyarray['procedure_date'])):'';
			$but_unsigned_text = "Save and keep UNSIGNED";
			$but_signed_text = "Save Progress Note and SIGN";
	
			if($themyarray["userid"] != '') {
		    	$but_unsigned_text = "Save changes and keep UNSIGNED";
		    	$but_signed_text = "Save changes and SIGN";
			} else {
				$but_unsigned_text = "Save and keep UNSIGNED";
		       	$but_signed_text = "Save Progress Note and SIGN";
				$procedure_date = date('m/d/Y');
			}
		?>	
		<?php
			if(!empty($msg)) {
		?>
			    <div align="center" class="red">
			        <?php echo $msg;?>
			    </div>
    	<?php
    		}
    	?>
	
	    <form name="notesfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo $_GET['pid']?>" method="post" onSubmit="return notesabc(this)">
		    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		        <tr>
		            <td colspan="2" class="cat_head" style="font-size:16px;">
		               	<?php echo (!empty($but_text) ? $but_text : ''); ?> Progress Notes
					   	-
		   				Patient <i><?php echo $name;?></i>
						Entry Date: <?php echo  date('m/d/Y', strtotime($procedure_date)); ?>
		            <span id="autosave_note" style="float:right; font-size:14px; font-weight:400;"><span>
                </td>
		        </tr>
		        <tr>
		        	<td valign="top" colspan="2" class="frmhead">
						Text Templates
						<span class="red">*</span>
			            <select name="title" class="tbox">
			                <option value="">Select</option>
			                    <?php foreach ($customNotes as $index=>$note) { ?>
		                            <option value="<?= $index ?>" <?= $note['title'] === '' ? 'style="font-style: italic"' : '' ?>>
		                        		<?= htmlspecialchars($note['title'] ?: 'no title') ?>
		                    		</option>
	                            <?php } ?>
	            		</select>
						<span style="float:right;">
							<?php
								$r_sql = "SELECT n.parentid, u.name FROM dental_notes n LEFT JOIN dental_users u ON n.userid=u.userid
										WHERE parentid=(select parentid from dental_notes where notesid='".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''))."')
										AND notesid != '".mysqli_real_escape_string($con,(!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : ''))."'";
								
								$r_q = $db->getResults($r_sql);
								$num_r = count($r_q);
								$r = (!empty($r_q[0]) ? $r_q[0] : '');
								if($num_r == 1) {
							?>
									Last Edited By:
							<?php
									echo $r['name'];
								} elseif($num_r > 1) {
							?>
									<a href="note_revisions.php?nid=<?php echo $r['parentid'];?>">View Revisions</a>
							<?php
								}
							?>
						</span>
		            </td>
				</tr>
				<tr>
		        	<td colspan="2" valign="top" class="frmdata">
						<textarea id="notes" name="notes" class="tbox" style="width:100%; height:190px;"><?php echo $notes;?></textarea>
		            </td>
		        </tr>
		        <tr>
		        	<td valign="top" class="frmdata">
						Editor Initials: <input type="text" id="editor_initials" name="editor_initials" value="<?php echo $editor_initials ?>" maxlength="3" />
		            </td>
		        	<td class="frmdata">
						Procedure Date: <span class="red">*</span> <input type="text" id="procedure_date" name="procedure_date" value="<?php echo $procedure_date ?>" class="calendar_top" />
						Added by: 
						<?php
							if(isset($_REQUEST['ed'])){
								echo $themyarray["added_name"];
							}else{
								$s = "SELECT first_name, last_name from dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
		
								$r = $db->getRow($s);
								echo $r['first_name']." ".$r['last_name'];
							}
						?>
		            </td>
		        </tr>        
		        <tr>
		            <td  colspan="2" align="center">
		                <span class="red">
		                    * Required Fields					
		                </span><br />
		                <input type="hidden" name="notesub" value="1" />
		                <input type="hidden" name="ed" value="<?php echo $themyarray["notesid"]?>" />
						<?php if(isset($_REQUEST['goto'])) { ?>
							<input type="hidden" value="<?php echo  $_REQUEST['goto']; ?>" name="goto" />
						<?php } ?>
						<div id="submit_buttons">
                			<input type="submit" name="<?php echo  ($_SESSION['docid'] == $_SESSION['userid'])?'unsign':'unsign_staff'; ?>" value=" <?php echo $but_unsigned_text?>" class="button" />
							<?php if($_SESSION['docid'] == $_SESSION['userid'] || $user_sign==1) { ?>
								<input type="submit"  style="margin-left: 20px;" name="sign" value=" <?php echo $but_signed_text?>" class="button" />
							<?php } else { ?>
								<input type="button" onclick="staff_sign('<?php echo $doc_r['name']; ?>');return false;" style="margin-left: 20px;" name="sign" value=" <?php echo $but_signed_text?>" class="button" />		
							<?php } ?>
						</div>

						<a href="#" onclick="delete_note(<?php echo  $themyarray['patientid']; ?>, <?php echo $themyarray['notesid']; ?>);return false;" style="float:left;">Delete</a>
						<p style="font-size:9px; text-align:left; margin-left:70px;">NOTE: For a Progress Note to be legally valid it must be SIGNED. SIGNED means that the note is stored permanently and can no longer be edited. If you wish to make future edits to a Progress Note then select UNSIGNED, but it will not become a legal part of the Patient's chart until SIGNED.</p>
						<?php if($_SESSION['docid'] != $_SESSION['userid']) { ?>
							<div id="cred_div" style="display:none;">
								<p>To SIGN this progress note an authorized user must enter credentials and click "Save changes and SIGN".<br />To save note without signing click "Save changes and keep UNSIGNED".</p>
								Authorized User: <input type="text" name="username" /><br />
								Password: <input type="password" name="password" /><br />
								<input type="submit" value=" <?php echo $but_unsigned_text?>" class="button" />
								<input type="submit" style="margin-left: 20px;" name="signstaff" value=" <?php echo $but_signed_text?>" class="button" />
							</div>
						<?php } ?>
		            </td>
		        </tr>
		    </table>
    	</form>
	</body>
</html>
