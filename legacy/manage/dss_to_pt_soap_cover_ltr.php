<?php namespace Ds3\Libraries\Legacy; ?><?php 
	if($_GET['backoffice'] == '1') {
		include 'admin/includes/top.htm';
	} else {
		include 'includes/top.htm';
	}
?>

	<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript" src="/manage/js/edit_letter.js?v=20160404"></script>

<?php
	$letterid = mysqli_real_escape_string($con, !empty($_GET['lid']) ? $_GET['lid'] : '');
	// Select Letter
	$letter_query = "SELECT templateid, patientid, topatient, md_list, md_referral_list FROM dental_letters where letterid = ".$letterid.";";
	
	$letter_result = $db->getResults($letter_query);
	if ($letter_result) foreach ($letter_result as $row) {
		$templateid = $row['templateid'];
		$patientid = $row['patientid'];
		$topatient = $row['topatient'];
		$md_list = $row['md_list'];
		$md_referral_list = $row['md_referral_list'];
		$mds = explode(",", $md_list);
		$md_referrals = explode(",", $md_referral_list);
	}
	// Get Letter Subject
	$template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$templateid.";";
	
	$template_result = $db->getRow($template_query);
	$title = $template_result['name'];
	// Get Franchisee Name
	$franchisee_query = "SELECT name FROM dental_users WHERE userid = '".$_SESSION['docid']."';";
	
	$franchisee_result = $db->getRow($franchisee_query);
	$franchisee_name = $franchisee_result['name'];
?>

	<br />
	<span class="admin_head">
		<?php print $title; ?>
	</span>
	<br />
	&nbsp;&nbsp;
	<a href="<?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == '1' ? "/manage/admin/manage_letters.php?status=pending&backoffice=1" : "/manage/letters.php?status=pending"); ?>" class="editlink" title="Pending Letters">
		<b>&lt;&lt;Back</b></a>
	<br /><br>

<?php
	if ($topatient) {
	  $contact_info = get_contact_info($patientid, $md_list, $md_referral_list);
	} else {
	  $contact_info = get_contact_info('', $md_list, $md_referral_list);
	}

	$letter_contacts = array();
	if ($contact_info) {
		if (!empty($contact_info['patient'])) foreach ($contact_info['patient'] as $contact) {
		  $letter_contacts[] = array_merge(array('type' => 'patient'), $contact);
		}
		foreach ($contact_info['mds'] as $contact) {
		  $letter_contacts[] = array_merge(array('type' => 'md'), $contact);
		}
		if (!empty($contact_info['md_referrals'])) foreach ($contact_info['md_referrals'] as $contact) {
		  $letter_contacts[] = array_merge(array('type' => 'md_referral'), $contact);
		}
	}

	$numletters = count($letter_contacts);
	$todays_date = date('F d, Y');

	$template = "<p>%todays_date%</p>
		<p>
		%patient_fullname%<br />
		%addr1%<br />
		%addr2%
		%city%, %state% %zip%<br />
		</p>

		<p>Dear %patient_firstname%:</p>

		<p>Thank you for choosing Dental Sleep Solutions&reg; and Dr. %franchisee_fullname% to treat your sleep disordered breathing.  As you are no doubt now aware, Dental Sleep Solutions&reg; dentists are some of the most highly trained and educated dentists in dental sleep medicine.  Our dentists are committed to helping you breathe better, sleep better, and feel better.</p>

		<p>We have attached a summary of the clinical notes made by Dr. %franchisee_lastname% for your records.  We hope that you will take an active role in your treatment therapy.  Please take the time to visit our website, too, at www.dentalsleepsolutions.com and give us a shout to let us know how we are doing.</p>

		<p>In the meantime, spread the word!  Many of your friends and family members could likely benefit from a dental sleep medicine consultation.  Dental Sleep Solutions&reg; is expanding its network of participating dentists regularly --  please check out our website for details.</p>

		<p>Thank you for choosing Dental Sleep Solutions&reg;!</p>

		<p>Sincerely,
		<br />
		<br />
		<br />
		Dr. %franchisee_fullname%</p>";
?>

	<form action="/manage/dss_to_pt_soap_cover_ltr.php?pid=<?php echo $patientid?>&lid=<?php echo $letterid?><?php print (!empty($_GET['backoffice']) && $_GET['backoffice'] == 1 ? "&backoffice=".$_GET['backoffice'] : ""); ?>" method="post" class="letter">
		<input type="hidden" name="numletters" value="<?php echo $numletters?>" />
		<?php
		if ($_POST != array()) {
			foreach ($_POST['duplicate_letter'] as $key => $value) {
		    	$dupekey = $key;
		  	}
		  	// Check for updated templates
			foreach ($letter_contacts as $key => $contact) {
				$search = array();
				$replace = array();
				$search[] = '%todays_date%';
				$replace[] = "<strong>" . $todays_date . "</strong>";
				$search[] = '%patient_fullname%';
				$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . " " . $letter_contacts[$key]['firstname'] . " " . $letter_contacts[$key]['lastname'] . "</strong>";
				$search[] = '%patient_firstname%';
				$replace[] = "<strong>" . $letter_contacts[$key]['firstname'] . "</strong>";
				$search[] = "%salutation%";
				$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
				$search[] = '%practice%';
				$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
				$search[] = '%addr1%';
				$replace[] = "<strong>" . $letter_contacts[$key]['add1'] . "</strong>";
				$search[] = '%addr2%';
				$replace[] = ($letter_contacts[$key]['add2']) ? "<strong>" . $letter_contacts[$key]['add2'] . "</strong><br />" : "<!--%addr2%-->";
				$search[] = '%city%';
				$replace[] = "<strong>" . $letter_contacts[$key]['city'] . "</strong>";
				$search[] = '%state%';
				$replace[] = "<strong>" . $letter_contacts[$key]['state'] . "</strong>";
				$search[] = '%zip%';
				$replace[] = "<strong>" . $letter_contacts[$key]['zip'] . "</strong>";
				$search[] = "%franchisee_fullname%";
				$replace[] = "<strong>" . $franchisee_name . "</strong>";
				$search[] = "%franchisee_lastname%";
				$replace[] = "<strong>" . preg_replace('/^.*[ ]([^ ]+)$/', '$1', ($franchisee_name)) . "</strong>";
    			$new_template[$key] = str_replace($replace, $search, $_POST['letter'.$key]);
    			// Letter hasn't been edited, but a new template exists in hidden field
 				if ($new_template[$key] == null && $_POST['new_template'][$key] != null) {
					$new_template[$key] = $_POST['new_template'][$key];
    			}
			    // Template hasn't changed
			    if ($new_template[$key] == $template) {
					$new_template[$key] = null;	
			    }
  			}
		  	// Duplicate Letter Template
			if (isset($_POST['duplicate_letter']) && !$duplicated) {
				$dupe_template = $new_template[$dupekey];
			    foreach ($letter_contacts as $key => $contact) {
			      $new_template[$key] = $dupe_template;
			    }
				$duplicated = true;
			}
			// Reset Letter
			if (isset($_POST['reset_letter'])) {
				foreach ($_POST['reset_letter'] as $key => $value) {
					$resetid = $key;
				}
				$new_template[$resetid] = null;
			}
		}

		foreach ($letter_contacts as $key => $contact) {
			// Token search and replace arrays
			$search = array();
			$replace = array();
			$search[] = '%todays_date%';
			$replace[] = "<strong>" . $todays_date . "</strong>";
			$search[] = '%patient_fullname%';
			$replace[] = "<strong>" . $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'] . "</strong>";
			$search[] = '%patient_firstname%';
			$replace[] = "<strong>" . $contact['firstname'] . "</strong>";
			$search[] = "%salutation%";
			$replace[] = "<strong>" . $letter_contacts[$key]['salutation'] . "</strong>";
			$search[] = '%practice%';
			$replace[] = ($letter_contacts[$key]['company']) ? "<strong>" . $letter_contacts[$key]['company'] . "</strong><br />" : "<!--%practice%-->";	
			$search[] = '%addr1%';
			$replace[] = "<strong>" . $contact['add1'] . "</strong>";
			$search[] = '%addr2%';
			$replace[] = ($contact['add2']) ? "<strong>" . $contact['add2'] . "</strong><br />" : "<!--%addr2%-->";
			$search[] = '%city%';
			$replace[] = "<strong>" . $contact['city'] . "</strong>";
			$search[] = '%state%';
			$replace[] = "<strong>" . $contact['state'] . "</strong>";
			$search[] = '%zip%';
			$replace[] = "<strong>" . $contact['zip'] . "</strong>";
			$search[] = '%franchisee_fullname%';
			$replace[] = "<strong>" . $franchisee_name . "</strong>";
			$search[] = "%franchisee_lastname%";

			$mas = explode(" ", $franchisee_name);

			$replace[] = "<strong>" . array_pop($mas) . "</strong>";
	
		 	if (!empty($new_template[$key])) {
			  	$letter[$key] = str_replace($search, $replace, $new_template[$key]);
				$new_template[$key] = htmlentities($new_template[$key]);
			} else {
			  	$letter[$key] = str_replace($search, $replace, $template);
		 	}

			// Catch Post Send Submit Button and Send letters Here
			if (!empty($_POST['send_letter'][$key]) && $numletters == $_POST['numletters']) {
			    if (count($letter_contacts) == 1) {
			  		$parent = true;
			    }
    			$letterid = $letterid;
		 		$type = $contact['type'];
				$recipientid = $contact['id'];
				if ($_GET['backoffice'] == '1') {
					$message = $letter[$key];
					$search= array("<strong>","</strong>");
					$message = str_replace($search, "", $message);	
					deliver_letter($letterid, $message);
				} else {
			    	$sentletterid = send_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
				}

				if ($parent) {
?>
					<script type="text/javascript">
						window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
					</script>
<?php
				}
    			continue;
  			}
			// Catch Post Delete Button and Delete letters Here
			if (!empty($_POST['delete_letter'][$key]) && $numletters == $_POST['numletters']) {
				if (count($letter_contacts) == 1) {
					$parent = true;
				}
				$type = $contact['type'];
				$recipientid = $contact['id'];
				$letterid = delete_letter($letterid, $parent, $type, $recipientid, $new_template[$key]);
				if ($parent) {
?>
					<script type="text/javascript">
						window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
					</script>
<?php
				}
				continue;
			}
?>
<?php // loop through letters ?>
			<div align="right">
				<button class="addButton" onclick="Javascript: edit_letter('letter<?php echo $key?>');return false;" >
					Edit Letter
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="duplicate_letter[<?php echo $key?>]" class="addButton" value="Duplicate" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_print.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','Print_letter','width=800,height=500,scrollbars=1');" >
					Print Letter 
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<button class="addButton" onclick="Javascript: window.open('dss_intro_to_md_from_dss_word.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>','word_letter','width=800,height=500,scrollbars=1');" >
					Word Document
				</button>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="send_letter[<?php echo $key?>]" class="addButton" value="Send Letter" />
				&nbsp;&nbsp;&nbsp;&nbsp;
			</div>

			<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
				<tr>
					<td valign="top">
						<div id="letter<?php echo $key?>">
						<?php print $letter[$key]; ?>
						</div>
						<input type="hidden" name="new_template[<?php echo $key?>]" value="<?php echo (!empty($new_template[$key]) ? $new_template[$key] : '')?>" />
					</td>
				</tr>
			</table>
			<div align="right">
				<input type="submit" name="reset_letter[<?php echo $key?>]" class="addButton" value="Reset" />
				&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" name="delete_letter[<?php echo $key?>]" class="addButton" value="Delete" />
				&nbsp;&nbsp;&nbsp;&nbsp;
			</div>

			<hr width="90%" />
<?php
		}
?>
		<br><br€>
		</form>
		</td>
	</tr>
</table>

<?php
	if(!empty($_GET['backoffice']) && $_GET['backoffice'] == '1') {
	  	include 'admin/includes/bottom.htm';
	} else {
		include 'includes/bottom.htm';
	} 
?>
