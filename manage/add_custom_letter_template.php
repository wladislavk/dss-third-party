<?php namespace Ds3\Legacy; ?><?php
    include "includes/top.htm";

    if(isset($_POST['update_btn'])){
        if(!empty($_GET['ed'])){
            $s = "UPDATE dental_letter_templates_custom SET
            	  name='".mysqli_real_escape_string($con,$_POST['name'])."',
            	  body='".mysqli_real_escape_string($con,$_POST['body'])."'
            	  WHERE 
            	  docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
            	  id='".mysqli_real_escape_string($con,$_GET['ed'])."'";

            $db->query($s);
        }else{
            $s = "INSERT INTO dental_letter_templates_custom SET
                  name='".mysqli_real_escape_string($con,$_POST['name'])."',
                  body='".mysqli_real_escape_string($con,$_POST['body'])."',
                  docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."',
            	  adddate=now(),
            	  ip_address = '".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
                  
            $db->query($s);
        }
?>
    	<script type="text/javascript">
    	   window.location = "manage_custom_letters.php";
    	</script>
<?php
    }

    $sql = "select * from dental_letter_templates_custom WHERE id='".mysqli_real_escape_string($con,!empty($_GET['ed']) ? $_GET['ed'] : '')."' ";
    $r = $db->getRow($sql);

    if(isset($_GET['cid'])){
        if($_GET['cid'][0]!='C'){
            $c_sql = "SELECT body FROM dental_letter_templates WHERE id = ".mysqli_real_escape_string($con,$_GET['cid']).";";
        } else {
            $c_sql = "SELECT body FROM dental_letter_templates_custom WHERE id = ".mysqli_real_escape_string($con,substr($_GET['cid'],1)).";";
        }

        $c_r = $db->getRow($c_sql);
        $body = $c_r['body'];
        //To replace franchisee to doctor so software users don't get confused.
        $body = str_replace('%franchisee_', '%doctor_', $body);
    }else{
        $body = $r['body'];
    }
?>
    <script type="text/javascript" src="3rdParty/spry/SpryTabbedPanels.js"></script>
    <link rel="stylesheet" href="3rdParty/spry/SpryTabbedPanels.css" />
    <script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce4/tinymce.min.js"></script>
    <script language="javascript" type="text/javascript" src="script/validation.js"></script>
    <script type="text/javascript" src="js/edit_letter.js"></script>

    <span class="admin_head">
    	Manage Custom Letter Templates 
    </span>
    <br /><br />
    <div style="width:900px;margin-left:20px;">
        <p>Instructions for Creating Custom Letters: 
        <a id="hide_instruct" href="#" onclick="$('#custom_instructions').hide();$('#show_instruct').show();$(this).hide(); return false;">Hide Instructions</a>
        <a id="show_instruct" href="#" onclick="$('#custom_instructions').show();$('#hide_instruct').show();$(this).hide(); return false;" style="display:none;">Show Instructions</a>
        </p>
        <div id="custom_instructions">
            <p>1.  What you type into the letter below will become a part of your new letter.</p>
            <p>2.  You can choose any number of  "variables" from the tabs and lists below to insert into your letter.  To do this first select, copy, and then paste the text under the "variable" column (e.g. " %todays_date% ") into the body of your new letter.</p>
            <p>Example:<br />
            I want the letter to start "Dear John" where 'John' is the first name of the patient.  In the body of the letter, type "Dear" and then a space, and then copy and past the variable under the Patient General tab, under the description "Patient's first name", which would be "%patient_firstname%".  So now your letter should look like:  "Dear %patient_firstname%"  -- which will read "Dear John" when the letter is actually used.</p>
            <p>3.  You must NAME your new letter in the "Name" field above to distinguish it from all other letters in your software.</p>
            <p>4.  When finished, click SAVE.</p>
            <p>5.  Now, anytime you wish to use this letter, go to a patient chart and choose "Create New Letter" in the 'Letters' tab.  The letter will be available in your drop down menu with the name you gave it.</p>
            <p>NOTE: You CANNOT modify or customize any of the existing DS3 letter templates that are triggered from the Tracker page (you can only create your own new letter templates). You CANNOT presently create automatic triggers for your letters from the Tracker page.</p> 
            </p>
        </div>
        <form style="display:block;" action="?ed=<?php echo  (!empty($_GET['ed']) ? $_GET['ed'] : '');?>" method="post" onsubmit="return customlettertemplateabc(this)">
            <br />
            <div style="margin-left:20px;width:930px;">
                Name: <input type="text" id="name" name="name" value="<?php echo  $r['name']; ?>" />
                <br /><br />
                <textarea id="body" name="body" style="width:920px; height:500px;"><?php echo  $body; ?></textarea>
                <input type="submit" name="update_btn" value="Save" class="addButton" />
                <?php if(isset($_GET['ed']) && $_GET['ed']!='') { ?>
                    <a class="addButton" style="float:right;" href="manage_custom_letters.php?delid=<?php echo  $_GET['ed']; ?>" onclick="return confirm('Warning, you are attempting to delete a letter template. Any letters already using this template will not be affected, but you will not be able to create new letters with the template after it is deleted. Proceed?');">Delete Letter</a>
                    <a class="addButton" style="float:right;" href="manage_custom_letters.php">Cancel Changes</a>
                <?php } else { ?>
                    <a class="addButton" style="float:right;" href="manage_custom_letters.php">Cancel</a>
                <?php } ?>
            </div>
        </form>
        <div style=" width:900px;margin:20px 0 0 20px;">
            <?php include 'includes/custom_var.php';?>
        </div>
        <div style="clear:both;"></div>
        <br /><br />	
        <?php include "includes/bottom.htm";?>

<script type="text/javascript" src="js/add_custom_letter_template.js"></script>
