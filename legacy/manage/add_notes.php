<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	include_once('admin/includes/password.php');

$db = new Db();
$docId = (int)$_SESSION['docid'];

$involvedPermissions = $db->getNumberRows("SELECT DISTINCT g.id
    FROM dental_api_permission_resource_groups g
    JOIN dental_api_permissions p ON p.group_id = g.id
    WHERE g.slug IN ('soap-notes')
    AND p.doc_id = $docId
");
$isSoapAuthorized = $involvedPermissions === 1;
$isSoapAuthorized = $isSoapAuthorized && !empty($_GET['soap']);
$conditionalNot = 'NOT';

if ($isSoapAuthorized) {
    $conditionalNot = '';
}

// Log info to debug #216
if (!empty($_GET['forced'])) {
    error_log("The following browser requested a forced template load: {$_SERVER['HTTP_USER_AGENT']}");
}

    $sign_sql = "SELECT sign_notes FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

    $sign_r = $db->getRow($sign_sql);
    $user_sign = $sign_r['sign_notes'];

	if(!empty($_POST["notesub"]) && $_POST["notesub"] == 1) {
		$notes = $_POST['notes'];

		if (!empty($_POST['is_soap'])) {
		    $notes = safeJsonEncode($_POST['soap_notes']);
        }

	   	$procedure_date = ($_POST['procedure_date']!='')?date('Y-m-d', strtotime($_POST['procedure_date'])):'';
		$editor_initials = $_POST['editor_initials'];

		if($_POST['ed'] == '') {
			$ins_sql = "insert into dental_notes set 
						patientid = '".$db->escape($_GET['pid'])."',
						status = 1,
						notes = '".$db->escape($notes)."',
						editor_initials = '".$db->escape($editor_initials)."',
						procedure_date = '".$db->escape($procedure_date)."',
						userid = '".$db->escape($_SESSION['userid'])."',
						docid = '".$db->escape($_SESSION['docid'])."',";
			if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)) {
			  	$ins_sql .= " signed_id='".$db->escape($_SESSION['userid'])."', signed_on=now(),";
			}elseif(isset($_POST['signstaff'])) {
		        $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con,$_POST['username'])."'";
        		$salt_row = $db->getRow($salt_sql);
        		$pass = gen_password($_POST['password'], $salt_row['salt']);
        		$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysqli_real_escape_string($con,$_POST['username'])."' and password='".$pass."' and status=1 AND (sign_notes=1 OR userid=".$_SESSION['docid'].")";
        		
        		$check_my = $db->getResults($check_sql);
        		if(count($check_my) == 1) {
					$check_myarray = $check_my[0];
					$ins_sql .= " signed_id='".$db->escape($check_myarray['userid'])."', signed_on=now(),";
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

			$ins_sql .= " adddate = now(), ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
			
		 	$id = $db->getInsertId($ins_sql);
			$db->query("UPDATE dental_notes SET parentid='".$id."' WHERE notesid='".$id."'");	
			$msg = "Added Successfully";

            $note = $db->getRow("SELECT *
			    FROM dental_notes
			    WHERE notesid = '$id'
            ");

			?>
            <script type="text/javascript">
                function setField(form, note)
                {
                    try {
                        parent.Events.trigger('addNote', {
                            namespace: form,
                            note: note
                        });
                    } catch (e) { /* Fall through */ }
                }

                var form = <?= json_encode($_GET['fr']) ?>,
                    note = <?= json_encode($note) ?>;

                setField(form, note);

                if (typeof parent.disablePopupRefClean !== 'undefined') {
                    parent.disablePopupRefClean();
                }
            </script>
            <?php

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
            $noteId = intval($_POST['ed']);
			$p_r = $db->getRow("select parentid, status FROM dental_notes WHERE notesid='$noteId'");
			$parentid = $p_r['parentid'];
            $isDraft = $p_r['status'] == 2;

            if ($isDraft) {
                $ins_sql = "UPDATE dental_notes SET ";
            }
            else {
                $ins_sql = "INSERT INTO dental_notes SET ";
            }

			$ins_sql .= "
			            patientid = '".$db->escape($_GET['pid'])."',
		                status = 1,
		                notes = '".$db->escape($notes)."',
		                editor_initials = '".$db->escape($editor_initials)."',
		                procedure_date = '".$db->escape($procedure_date)."',
		                userid = '".$db->escape($_SESSION['userid'])."',
		                docid = '".$db->escape($_SESSION['docid'])."',";
            if(isset($_POST['sign']) && ($_SESSION['docid']==$_SESSION['userid'] || $user_sign==1)) {
              	$ins_sql .= " signed_id='".$db->escape($_SESSION['userid'])."', signed_on=now(), ";
            } elseif(isset($_POST['signstaff'])) {
	            $salt_sql = "SELECT salt FROM dental_users WHERE username='".mysqli_real_escape_string($con,$_POST['username'])."'";

	            $salt_row = $db->getRow($salt_sql);
				$pass = gen_password($_POST['password'], $salt_row['salt']);
				$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".mysqli_real_escape_string($con,$_POST['username'])."' and password='".$pass."' and status=1 AND (sign_notes=1 OR userid=".$_SESSION['docid'].")";
                      
                $check_my = $db->getResults($check_sql);
                if(count($check_my) == 1)
                {
                    $check_myarray = $check_my[0];
                    $ins_sql .= " signed_id='".$db->escape($check_myarray['userid'])."', signed_on=now(), ";
                } else {
?>
                    <script type="text/javascript">
                        alert("Unable to sign note due to invalid credentials. Updated note has been saved.");
                    </script>
<?php
                }
            }

            $ins_sql .= " parentid='".$parentid."', adddate = now(), ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";

			$up_sql = "update dental_notes set 
						patientid = '".$db->escape($_GET['pid'])."',
						status = 1,
						notes = '".$db->escape($notes)."',
						editor_initials = '".$db->escape($editor_initials)."',
						procedure_date = '".$db->escape($procedure_date)."',
						edited = 1,";
            if(isset($_POST['sign']) && $_SESSION['docid']==$_SESSION['userid']){
              	$up_sql .= " signed_id='".$db->escape($_SESSION['userid'])."', signed_on=now(), ";
            }
            
            $up_sql .= " userid = '".$db->escape($_SESSION['userid'])."' where notesid='$noteId'";

            if ($isDraft) {
                $ins_sql .= " WHERE notesid = '$noteId'";
            }

			$db->query($ins_sql);
			$msg = "Edited Successfully";

            $note = $db->getRow("SELECT *
			    FROM dental_notes
			    WHERE notesid = '$noteId'
            ");

            ?>
            <script type="text/javascript">
                function setField(form, note)
                {
                    try {
                        parent.Events.trigger('addNote', {
                            namespace: form,
                            note: note
                        });
                    } catch (e) { /* Fall through */ }
                }

                var form = <?= json_encode($_GET['fr']) ?>,
                    note = <?= json_encode($note) ?>;

                setField(form, note);

                if (typeof parent.disablePopupRefClean !== 'undefined') {
                    parent.disablePopupRefClean();
                }
            </script>
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

	$sql = "SELECT *
        FROM dental_custom
        WHERE docid = '$docId'
            AND description $conditionalNot LIKE '%\"is_soap\":\"1\",%'
        ORDER BY title
    ";
	
	$total_rec = $db->getNumberRows($sql);
	$pat_sql = "select * from dental_patients where patientid='".$db->escape($_GET['pid'])."'";

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
	    $sql = "SELECT *
        FROM dental_custom
        WHERE docid = '$docId'
            AND description $conditionalNot LIKE '%\"is_soap\":\"1\",%'
        ORDER BY title
    ";
	    $my = $db->getResults($sql);

    $customNotes = [];
    $currentNote = null;

    if ($my) {
        foreach ($my as $myarray) {
            $description = $myarray['description'];

            try {
                $jsonDescription = json_decode($description, true);

                if (is_array($jsonDescription)) {
                    $description = $jsonDescription;
                }
            } catch (\Exception $e) {
                /* Fall through */
            }

            if (is_string($description)) {
                $description = trim(utf8_encode($description));
            }

            if (is_array($description)) {
                $description['subjective'] = trim(utf8_encode($description['subjective']));
                $description['objective'] = trim(utf8_encode($description['objective']));
                $description['assessment'] = trim(utf8_encode($description['assessment']));
                $description['plan'] = trim(utf8_encode($description['plan']));
            }

            $customNotes []= [
                'title' => trim(utf8_encode($myarray['title'])),
                'description' => $description,
            ];
        }

        if (isset($_GET['title']) && isset($customNotes[$_GET['title']])) {
            $currentNote = $_GET['title'];
        }
    }

    $doc_sql = "SELECT name from dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
    $doc_r = $db->getRow($doc_sql);
	?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
		<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
		<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="script/validation.js?v=20171219"></script>
		<script type="text/javascript" src="script/autocomplete.js?v=20160719"></script>
		<script type="text/javascript" src="js/add_notes.js?v=20171219"></script>
		<link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript">
            var customNotes = <?= json_encode($customNotes) ?>;
        </script>
	</head>
	<body>
		<script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
		<script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
    	<?php

		include("includes/calendarinc.php");

		  $thesql = "select n.*, CONCAT(u.first_name,' ',u.last_name) added_name from dental_notes n
					LEFT JOIN dental_users u on u.userid=n.userid
					where notesid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
			$themyarray = $db->getRow($thesql);
            $notes = $themyarray['notes'];
            $soapNotes = [];

            if (count($themyarray)) {
                try {
                    $soapNotes = json_decode($themyarray['notes'], true);
                } catch (\Exception $e) { /* Fall through */ }
            }
            if (!empty($soapNotes)) {
                $isSoapAuthorized = true;
            }

            if (!is_null($currentNote)) {
                $notes = $customNotes[$currentNote]['description'];
            }

            $soapDisabled = 'disabled';

            if ($isSoapAuthorized) {
                $soapDisabled = '';
            }

			$editor_initials = e($themyarray['editor_initials']);
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
	
	    <form method="get">
            <input type="hidden" name="fr" value="<?= e($_GET['fr']) ?>" />
            <input type="hidden" name="add" value="1" />
            <input type="hidden" name="soap" value="<?= $isSoapAuthorized ?>" />
            <input type="hidden" name="pid" value="<?= intval($_GET['pid']) ?>" />
            <input type="hidden" name="forced" value="1" />
		    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
		        <tr>
		            <td colspan="2" class="cat_head" style="font-size:16px;">
		               	<?php echo (!empty($but_text) ? $but_text : ''); ?>
                        <?= $isSoapAuthorized ? 'SOAP' : 'Progress' ?> Notes
					   	-
		   				Patient <i><?php echo $name;?></i>
						Entry Date: <?php echo  date('m/d/Y', strtotime($procedure_date)); ?>
		            <span id="autosave_note" style="float:right; font-size:14px; font-weight:400;"><span>
                </td>
		        </tr>
		        <tr>
		        	<td valign="top" colspan="2" class="frmhead">
						<?= $isSoapAuthorized ? 'SOAP Notes' : 'Text' ?> Templates
						<span class="red">*</span>
			            <select name="title" class="tbox">
			                <option value="">Select</option>
                            <?php foreach ($customNotes as $index=>$note) { ?>
                                <option value="<?= $index ?>" <?= !is_null($currentNote) && $index == $currentNote ? 'selected="selected"' : '' ?> <?= $note['title'] === '' ? 'style="font-style: italic"' : '' ?>>
                                    <?= htmlspecialchars($note['title'] ?: 'no title') ?>
                                </option>
                            <?php } ?>
	            		</select>
                        <span title="Click here if the text template does not load automatically.&#013;Your changes will be lost" style="cursor: pointer;">
                            <input type="submit" class="button" value="Load">
                            ?
                        </span>
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
            </table>
        </form>
        <form name="notesfrm" method="post" onSubmit="return notesabc(this)"
              action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo $_GET['pid']?>&fr=<?= e($_GET['fr']) ?>">
            <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
				<tr>
		        	<td colspan="2" valign="top" class="frmdata">
                        <div id="not-soap-container" <?= $isSoapAuthorized ? 'style="display:none;"' : '' ?>>
                            <textarea id="notes" name="notes" class="tbox" style="width:100%; height:190px;"><?php echo $notes;?></textarea>
                        </div>
                        <div id="soap-container" <?= $isSoapAuthorized ? '' : 'style="display:none;"' ?>>
                            <input <?= $soapDisabled ?> type="hidden" name="is_soap" value="<?= $isSoapAuthorized ?>">
                            <strong>Subjective</strong>
                            <textarea <?= $soapDisabled ?> id="subjective" name="soap_notes[subjective]" class="tbox"
                                      style="width:100%; height:60px;"><?= e($soapNotes['subjective']) ?></textarea>

                            <strong>Objective</strong>
                            <textarea <?= $soapDisabled ?> id="objective" name="soap_notes[objective]" class="tbox"
                                      style="width:100%; height:60px;"><?= e($soapNotes['objective']) ?></textarea>

                            <strong>Assessment</strong>
                            <textarea <?= $soapDisabled ?> id="assessment" name="soap_notes[assessment]" class="tbox"
                                      style="width:100%; height:60px;"><?= e($soapNotes['assessment']) ?></textarea>

                            <strong>Plan</strong>
                            <textarea <?= $soapDisabled ?> id="plan" name="soap_notes[plan]" class="tbox"
                                      style="width:100%; height:60px;"><?= e($soapNotes['plan']) ?></textarea>
                        </div>
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

						<a href="#" onclick="delete_note(<?= ($themyarray['patientid']) ?>, <?= $themyarray['parentid'] ?: $themyarray['notesid'] ?>);return false;" style="float:left;">Delete</a>
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
