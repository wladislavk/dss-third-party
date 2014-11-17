<?php
    include 'includes/top.htm';

    if(!$use_letters){
?>
        <h3 style="width:100%; text-align:center;">Letters feature has been disabled.</h3>
<?php
        die();
    }

    include_once('includes/patient_info.php');
    include_once('admin/includes/general.htm');
?>

<link rel="stylesheet" href="css/letters.css" />

<?php
    if ($patient_info) { 
        function userid_asc($a, $b)
        {
            return strcmp ($a['userid'], $b['userid']);
        }

        function userid_desc($a, $b)
        {
            return strcmp ($b['userid'], $a['userid']);
        }

        function subject_asc($a, $b)
        {
            return strcmp ($a['subject'], $b['subject']);
        }

        function subject_desc($a, $b)
        {
            return strcmp ($b['subject'], $a['subject']);
        }

        function sentto_asc($a, $b)
        {
            $word_lista = explode(" ", $a['sentto']);
            $word_listb = explode(" ", $b['sentto']);
            if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
                if ($word_lista[0] == $word_listb[0]) {
                    return 0;
                } else {
                    return ($word_lista[0] < $word_listb[0]) ? -1 : 1;
                }
            }

            if (is_numeric($word_lista[0])) {
                return -1;
            }

            if (is_numeric($word_listb[0])) {
                return 1;
            }
            return strcmp ($a['sentto'], $b['sentto']);
        }

        function sentto_desc($a, $b)
        {
            $word_lista = explode(" ", $a['sentto']);
            $word_listb = explode(" ", $b['sentto']);
            if (is_numeric($word_lista[0]) && is_numeric($word_listb[0])) {
                if ($word_lista[0] == $word_listb[0]) {
                    return 0;
                } else {
                    return ($word_lista[0] > $word_listb[0]) ? -1 : 1;
                }
            }

            if (is_numeric($word_lista[0])) {
                return 1;
            }

            if (is_numeric($word_listb[0])) {
                return -1;
            }
            return strcmp ($b['sentto'], $a['sentto']);
        }

        function method_asc($a, $b)
        {
            return strcmp ($a['send_method'], $b['send_method']);
        }

        function method_desc($a, $b)
        {
            return strcmp ($b['send_method'], $a['send_method']);
        }

        function generated_date_asc($a, $b)
        {
            if ($a['generated_date'] == $b['generated_date']) {
                return 0;
            }
            return ($a['generated_date'] < $b['generated_date']) ? -1 : 1;
        }

        function generated_date_desc($a, $b)
        {
            if ($a['generated_date'] == $b['generated_date']) {
                return 0;
            }
            return ($a['generated_date'] > $b['generated_date']) ? -1 : 1;
        }

        function delivery_date_asc($a, $b)
        {
            if ($a['delivery_date'] == $b['delivery_date']) {
                return 0;
            }
            return ($a['delivery_date'] < $b['delivery_date']) ? -1 : 1;
        }

        function delivery_date_desc($a, $b)
        {
            if ($a['delivery_date'] == $b['delivery_date']) {
                return 0;
            }
            return ($a['delivery_date'] > $b['delivery_date']) ? -1 : 1;
        }

        $page = '0';
        $page_limit = '10';
        $column = 'letterid';
        $filter = "%";

        if (isset($_GET['filter'])) {
            $filter = mysqli_real_escape_string($con,$_GET['filter']);
        }

        if(!isset($_REQUEST['sort'])){
            $_REQUEST['sort'] = 'generated_date';
            if (isset($status) && $status == 'sent') {
                $_REQUEST['sortdir'] = 'DESC';
            } else {
                $_REQUEST['sortdir'] = 'ASC';
            }
        }
        $sort = $_REQUEST['sort'];
        $sortdir = $_REQUEST['sortdir'];
        $patientid = $_REQUEST['pid'];
        $page1 = (!empty($_REQUEST['page1']) ? $_REQUEST['page1'] : '');
        $page2 = (!empty($_REQUEST['page2']) ? $_REQUEST['page2'] : '');
        // Get doctor id
        $docid = $_SESSION['docid'];

        $letters_query = "SELECT dental_letters.letterid, dental_letters.templateid, dental_letters.patientid, UNIX_TIMESTAMP(dental_letters.generated_date) as generated_date, UNIX_TIMESTAMP(dental_letters.delivery_date) as delivery_date, dental_letters.send_method, dental_letters.pdf_path, dental_letters.status, dental_letters.topatient, dental_letters.md_list, dental_letters.md_referral_list, dental_patients.firstname, dental_patients.lastname, dental_patients.middlename, dental_users.name as userid FROM dental_letters JOIN dental_patients on dental_letters.patientid=dental_patients.patientid JOIN dental_users ON dental_letters.userid=dental_users.userid WHERE dental_letters.patientid = '" . $patientid . "' AND dental_patients.docid='".$docid."' AND dental_letters.deleted = '0' 
                    	AND (dental_letters.parentid IS NULL 
                    	OR dental_letters.parentid=0)
                    	AND dental_letters.templateid LIKE '".$filter."' GROUP BY dental_letters.letterid, dental_letters.parentid ORDER BY dental_letters.letterid ASC;";
        
        $letters_res = $db->getResults($letters_query);
        if (!$letters_res) {
        	print "MYSQL ERROR:".mysqli_errno($con).": ".mysqli_errno($con)."<br/>"."Error selecting letters from the database.";
        } else {
        	foreach ($letters_res as $row) {
        		$dental_letters[] = $row;
        	}
        }

        foreach ($dental_letters as $key => $letter) {
            // Get Correspondance Column
        	$template_sql = "SELECT name, template FROM dental_letter_templates WHERE id = '".$letter['templateid']."';";
        	
        	$correspondance = array();
        	$correspondance = $db->getRow($template_sql);
        	$dental_letters[$key]['id'] = $letter['letterid'];
            $dental_letters[$key]['status'] == $letter['status'];
        	if (!empty($letter['pdf_path']) && $letter['status'] != DSS_LETTER_SEND_FAILED) {
        		$dental_letters[$key]['url'] = "/manage/letterpdfs/" . $letter['pdf_path'];
        	} else {
        		$dental_letters[$key]['url'] = "/manage/edit_letter.php?fid=" . $letter['patientid'] . "&pid=" . $letter['patientid'] . "&lid=" . $letter['letterid']."&goto=letter";
        	}
        	$dental_letters[$key]['subject'] = $correspondance['name'];
        	if($letter['templateid']==99){
        		$dental_letters[$key]['subject'] = "User Generated";
        	}

	        // Get Recipients for Sent to Column
            $s = "SELECT referred_source FROM dental_patients where patientid=".mysqli_real_escape_string($con,$letter['patientid'])." LIMIT 1";

            $r = $db->getRow($s);
            $source = $r['referred_source'];
	        $contacts = get_contact_info((($letter['topatient'] == "1") ? $letter['patientid'] : ''), $letter['md_list'], $letter['md_referral_list'], $source, $letter['letterid']);
	        //  ADD IN CHILD LETTERS TO CONTACTS
            $master_sql = "SELECT letterid, topatient, patientid, md_list, md_referral_list FROM dental_letters l
			               WHERE status=0 AND deleted=0 AND parentid='".$letter['letterid']."'";
	        
            $master_q = $db->getResults($master_sql);
	        if ($master_q) foreach ($master_q as $master_r){
                $master_contacts = get_contact_info((($master_r['topatient'] == "1") ? $master_r['patientid'] : ''), $master_r['md_list'],$master_r['md_referral_list'], $source, $master_r['letterid']);
                if(isset($contacts['patient']) && isset($master_contacts['patient']) && count($contacts['patient']) && count($master_contacts['patient'])){
                    //$contacts['patient'] = array_merge($contacts['patient'], $master_contacts['patient']);
                }elseif(isset($master_contacts['patient']) && count($master_contacts['patient'])){
                    $contacts['patient'] = $master_contacts['patient'];
                }

                if(isset($contacts['mds']) && isset($master_contacts['mds']) && count($contacts['mds']) && count($master_contacts['mds'])){
                    $contacts['mds'] = array_merge($contacts['mds'], $master_contacts['mds']);
                }elseif(isset($master_contacts['mds']) && count($master_contacts['mds'])){
                    $contacts['mds'] = $master_contacts['mds'];
                }

                if(isset($contacts['md_referrals']) && isset($master_contacts['md_referrals']) && count($contacts['md_referrals']) && count($master_contacts['md_referrals'])){
                    $contacts['md_referrals'] = array_merge($contacts['md_referrals'], $master_contacts['md_referrals']);
                }elseif(isset($master_contacts['md_referrals']) && count($master_contacts['md_referrals'])){
                    $contacts['md_referrals'] = $master_contacts['md_referrals'];
                }
	        }

            $total_contacts = count((!empty($contacts['patient']) ? $contacts['patient'] : '')) + count((!empty($contacts['mds']) ? $contacts['mds'] : '')) + count((!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : ''));
            $dental_letters[$key]['total_contacts'] = $total_contacts;
            
            if ($total_contacts > 1) {
                $dental_letters[$key]['sentto'] = $total_contacts . " Contacts";
                $dental_letters[$key]['patient'] = (!empty($contacts['patient']) ? $contacts['patient'] : '');
                $dental_letters[$key]['mds'] = (!empty($contacts['mds']) ? $contacts['mds'] : '');
                $dental_letters[$key]['md_referrals'] = (!empty($contacts['md_referrals']) ? $contacts['md_referrals'] : '');
            } elseif ($total_contacts == 0) {
                $dental_letters[$key]['sentto'] = "<span class=\"red\">No Contacts</span>";
            } else {
        		// Patient: Salutation Lastname, Firstname
        		$dental_letters[$key]['sentto'] = '';
                if(isset($contacts['patient'][0])){
                    $dental_letters[$key]['sentto'] .= $contacts['patient'][0]['salutation'] . " " . $contacts['patient'][0]['lastname'] . ", " . $contacts['patient'][0]['firstname'];
                    if($letter['status']==0){
                        $dental_letters[$key]['sentto'] .=  " <a href=\"#\" onclick=\"delete_pending_letter('".$contacts['patient'][0]['letterid']."', 'patient', '".$contacts['patient'][0]['id']."', 1)\" class=\"delete_letter\" />Delete</a>";
                    }
                }

        		if(isset($contacts['mds'])){
        			$dental_letters[$key]['sentto'] .= $contacts['mds'][0]['salutation'] . " " . $contacts['mds'][0]['lastname'] . ", " . $contacts['mds'][0]['firstname'];
        			if($contacts['mds']['contacttype']){
        			    $dental_letters[$key]['sentto'] .= " - " . $contacts['mds']['contacttype'];
        			}
                    if($letter['status']==0){
        			    $dental_letters[$key]['sentto'] .=  " <a href=\"#\" onclick=\"delete_pending_letter('".$contacts['mds'][0]['letterid']."', 'md', '".$contacts['mds'][0]['id']."', 1)\" class=\"delete_letter\" />Delete</a>";
        			}
        		}

                if(isset($contacts['md_referrals'])){
                    $dental_letters[$key]['sentto'] .= $contacts['md_referrals'][0]['salutation'] . " " . $contacts['md_referrals'][0]['lastname'] . ", " . $contacts['md_referrals'][0]['firstname'];
                    if($contacts['md_referrals']['contacttype']){
                        $dental_letters[$key]['sentto'] .= " - " . $contacts['md_referrals']['contacttype'];
                    }
                    if($letter['status']==0){
                        $dental_letters[$key]['sentto'] .=  " <a href=\"#\" onclick=\"delete_pending_letter('".$contacts['md_referrals'][0]['letterid']."', 'md_referral', '".$contacts['md_referrals'][0]['id']."', 1)\" class=\"delete_letter\" />Delete</a>";
                    }
                }
	        }
            // Determine if letter is older than 7 days
            if (floor((time() - $letter['generated_date']) / $seconds_per_day) > 7 && isset($status) && $status == "pending") {
                $dental_letters[$key]['old'] = true;
            }
        }

        // Collect Letters in array
        $pending_letters = array();
        $sent_letters = array();
        foreach ($dental_letters as $letter) {
        	if ($letter['status'] == "0" || $letter['status'] == DSS_LETTER_SEND_FAILED) {
        		$pending_letters[] = $letter;
        	} else {
        		$sent_letters[] = $letter;
        	}
        }

        // Calculate numer of pages
        $num_pages1 = floor(count($pending_letters) / $page_limit);
        if (count($pending_letters) % $page_limit) {
            $num_pages1++;
        }

        // Calculate numer of pages
        $num_pages2 = floor(count($sent_letters) / $page_limit);
        if (count($sent_letters) % $page_limit) {
            $num_pages2++;
        }

        // Sort the letters array
        if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'userid_asc'); 
            usort($sent_letters, 'userid_asc'); 
        }
        if ($_REQUEST['sort'] == "userid" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'userid_desc'); 
            usort($sent_letters, 'userid_desc'); 
        }
        if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'subject_asc'); 
            usort($sent_letters, 'subject_asc'); 
        }
        if ($_REQUEST['sort'] == "subject" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'subject_desc'); 
            usort($sent_letters, 'subject_desc'); 
        }
        if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'method_asc'); 
            usort($sent_letters, 'method_asc'); 
        }
        if ($_REQUEST['sort'] == "method" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'method_desc'); 
            usort($sent_letters, 'method_desc'); 
        }
        if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'sentto_asc'); 
            usort($sent_letters, 'sentto_asc'); 
        }
        if ($_REQUEST['sort'] == "sentto" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'sentto_desc'); 
            usort($sent_letters, 'sentto_desc'); 
        }
        if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'generated_date_asc'); 
            usort($sent_letters, 'generated_date_asc'); 
        }
        if ($_REQUEST['sort'] == "generated_date" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'generated_date_desc'); 
            usort($sent_letters, 'generated_date_desc'); 
        }
        if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "ASC") {
            usort($pending_letters, 'delivery_date_asc'); 
            usort($sent_letters, 'delivery_date_asc'); 
        }
        if ($_REQUEST['sort'] == "delivery_date" && $_REQUEST['sortdir'] == "DESC") {
            usort($pending_letters, 'delivery_date_desc'); 
            usort($sent_letters, 'delivery_date_desc'); 
        }
?>

        <div style="padding-left: 15px;">
            <h1 class="blue">Patient Letters</h1>
            <form name="filter_letters" action="/manage/patient_letters.php" method="get">
                <input type="hidden" name="pid" value="<?php echo $patientid;?>" />
                Filter by type: <select name="filter" onchange="document.filter_letters.submit();">
                    <option value="%"></option>
                    <?php
                        $templates = "SELECT id, name FROM dental_letter_templates WHERE default_letter=1 ORDER BY id ASC;";
                        
                        $result = $db->getResults($templates);
                        foreach ($result as $row) {
                            print "<option " . (($filter == $row['id']) ? "selected " : "") . "value=\"" . $row['id'] . "\">" . $row['id'] . " - " . $row['name'] . "</option>";
                        }
                    ?>
                </select>
            </form>
        </div>
        <div style="float: right;margin-right:40px;">
            <form method="get" action="/manage/new_letter.php">
                <input type="hidden" name="pid" value="<?php echo $patientid?>" />
                <input class="addButton" type="submit" value="Create New Letter">
            </form>
        </div>
        <div style="padding-left: 15px; clear: left;float: left;">
            <h2 class="blue">Pending Letters</h2>
        </div>
        <div class="letters-pager">Page(s): <?php paging1($num_pages1,$page1,"pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir",$page2); ?></div>
        <div style="clear:both;">
            <table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
                <tr class="tr_bg_h">
                    <td class="col_head <?php echo  ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondance</a></th>
                    <td class="col_head <?php echo  ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent To</a></th>
                    <td class="col_head <?php echo  ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Generated On</a></th>
                </tr>
                <?php
                    $i = $page_limit * $page1;
                    $end = $i + $page_limit;
                    while ($i < count($pending_letters) && $i < $end) {
                        $userid = $pending_letters[$i]['userid'];
                        $url = $pending_letters[$i]['url'];
                        $id = $pending_letters[$i]['id'];
                        $subject = $pending_letters[$i]['subject'];
                        $sentto = $pending_letters[$i]['sentto'];
                        $status = $pending_letters[$i]['status'];
                        $total_contacts = $pending_letters[$i]['total_contacts'];
                        $generated = date('m/d/Y', $pending_letters[$i]['generated_date']);
                        
                        if (!empty($pending_letters[$i]['old'])) {
                            $alert = " bgcolor=\"#FF9696\"";
                        } elseif ($pending_letters[$i]['status'] == DSS_LETTER_SEND_FAILED) {
                            $alert = " bgcolor=\"#FF9696\"";
                        } else  {
                            $alert = null;
                        }
	            ?>
                		<tr<?php echo  $alert; ?>>
                            <td>
                                <a href="<?php echo  $url; ?>"><?php echo  $subject; ?></a>
                    			<?php if ($pending_letters[$i]['status'] == DSS_LETTER_SEND_FAILED) { ?>
                    				- Send failed
                    			<?php } ?>
                		    </td>
		                    <td>
			                    <?php if($total_contacts > 1) { ?>
                                    <a href="#" onclick="$('#contacts_<?php echo  $id; ?>').toggle(); return false;"><?php echo  $sentto; ?></a>
                                    <div style="display:none;" id="contacts_<?php echo  $id; ?>">
                                        <?php foreach($pending_letters[$i]['patient'] as $pat) { ?>
                                            <br />
                                            <?php echo $pat['salutation']." ".$pat['firstname']." ".$pat['lastname']; ?>
                                            <a href="#" onclick="delete_pending_letter('<?php echo  $pat['letterid']; ?>', 'patient', '<?php echo  $pat['id']; ?>', 0); return false;" class="delete_letter" />Delete</a>
                                        <?php }
				                            foreach($pending_letters[$i]['mds'] as $md) {
					                    ?>
                                                <br />
                                                <?php echo $md['salutation']." ".$md['firstname']." ".$md['lastname']; ?>
                                                <a href="#" onclick="delete_pending_letter('<?php echo  $md['letterid']; ?>', 'md', '<?php echo  $md['id']; ?>', 0); return false;" class="delete_letter" />Delete</a>
                                        <?php }
                                            foreach($pending_letters[$i]['md_referrals'] as $md_referral){
                                        ?>
                                                <br />
                                                <?php echo $md_referral['salutation']." ".$md_referral['firstname']." ".$md_referral['lastname']; ?>
                                                <a href="#" onclick="delete_pending_letter('<?php echo  $md_referral['letterid']; ?>', 'md_referral', '<?php echo  $md_referral['id']; ?>', 0); return false;" class="delete_letter" />Delete</a>
                                        <?php } ?>
                                    </div>
                                <?php } else {
    				                echo $sentto;
				                }
			                    ?>
                            </td>
		                    <td>
                                <?php echo  $generated; ?>
                            </td>
                        </tr>
	            <?php
		              $i++;
                    }
                ?>
            </table>

            <script type="text/javascript" src="/manage/js/patient_letters.js"></script>

            <div style="padding-left: 15px; clear: left;float: left;">
                <h2 class="blue">Sent Letters</h2>
            </div>
            <div class="letters-pager">Page(s): <?php paging2($num_pages2,$page2,"pid=$patientid&filter=$filter&sort=$sort&sortdir=$sortdir",$page1); ?></div>
            <div style="clear:both;">
                <table cellpadding="3px" id="letters-table" width="97%" style="margin: 0 auto;">
                    <tr class="tr_bg_h">
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'userid')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=userid&sortdir=<?php echo ($_REQUEST['sort']=='userid'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">User ID</a></th>
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'subject')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=subject&sortdir=<?php echo ($_REQUEST['sort']=='subject'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondance</a></th>
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'sentto')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=sentto&sortdir=<?php echo ($_REQUEST['sort']=='sentto'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Sent To</a></th>
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'method')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=method&sortdir=<?php echo ($_REQUEST['sort']=='method'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Method</a></th>
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'generated_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=generated_date&sortdir=<?php echo ($_REQUEST['sort']=='generated_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Generated On</a></th>
                        <td class="col_head <?php echo  ($_REQUEST['sort'] == 'delivery_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>"><a href="patient_letters.php?pid=<?php echo $patientid;?>&page=<?php echo $page;?>&filter=<?php echo $filter;?>&sort=delivery_date&sortdir=<?php echo ($_REQUEST['sort']=='delivery_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Delivered On</a></th>
                    </tr>
                    <?php
                        $i = $page_limit * $page2;
                        $end = $i + $page_limit;
                        while ($i < count($sent_letters) && $i < $end) {
                            $userid = $sent_letters[$i]['userid'];
                            $url = $sent_letters[$i]['url'];
                            $subject = $sent_letters[$i]['subject'];
                            $sentto = $sent_letters[$i]['sentto'];
                        	$method = $sent_letters[$i]['send_method'];
                            $generated = date('m/d/Y', $sent_letters[$i]['generated_date']);
                            $delivered = ($sent_letters[$i]['delivery_date'] != '' )?date('m/d/Y', $sent_letters[$i]['delivery_date']):'';
                            $total_contacts = $sent_letters[$i]['total_contacts'];
                            $id = $sent_letters[$i]['id'];
                            if ($sent_letters[$i]['old']) {
                                $alert = " bgcolor=\"#FF9696\"";
                            } else {
                                $alert = null;
                            }
	                ?>
		                    <tr>
                                <td><?php echo  $userid; ?></td>
		                        <td>
                                    <a href="<?php echo  $url; ?>"><?php echo  $subject; ?></a>
                                </td>
		                        <td>
                                    <?php if($total_contacts > 1) { ?>
                                        <a href="#" onclick="$('#contacts_<?php echo  $id; ?>').toggle();return false;"><?php echo  $sentto; ?></a>
                                        <div style="display:none;" id="contacts_<?php echo  $id; ?>">
                                            <?php foreach($sent_letters[$i]['patient'] as $pat) { ?>
                                                    <br />
                                            <?php
                                                    echo $pat['salutation']." ".$pat['firstname']." ".$pat['lastname'];
                                                }
                                                foreach($sent_letters[$i]['mds'] as $md) {
                                            ?>
                                                    <br />
                                            <?php
                                                    echo $md['salutation']." ".$md['firstname']." ".$md['lastname'];
                                                }
                                                foreach($sent_letters[$i]['md_referrals'] as $md_referral){
                                            ?>
                                                    <br />
                                            <?php
                                                    echo $md_referral['salutation']." ".$md_referral['firstname']." ".$md_referral['lastname'];
                                                }
                                            ?>
                                        </div>
                                    <?php }else{
                                        echo $sentto;
                                    }
                                    ?>
		                        </td>
                        		<td><?php echo  $method; ?></td>
                        		<td><?php echo  $generated; ?></td>
                        		<td><?php echo  $delivered; ?></td>
                            </tr>
	                <?php
		                $i++;
                    }
                    ?>
                </table>
            </div>
<?php
    } else {  // end pt info check
    	print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
    }
?>

<?php include 'includes/bottom.htm'; ?>