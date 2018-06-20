<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";

$db = new Db();

if(isset($_POST["margins_submit"]) || isset($_POST['margins_test'])) {
    $in_sql = "UPDATE dental_users SET
            claim_margin_top = '".$db->escape($_POST['claim_margin_top'])."',
            claim_margin_left = '".$db->escape($_POST['claim_margin_left'])."'
        WHERE userid='".$_SESSION['docid']."'";
    $db->query($in_sql);
    if(isset($_POST['margins_test'])){ ?>
        <script type="text/javascript">
            window.open("claim_margin_test.php");
        </script>
        <?php
    }
}

if(isset($_POST["margins_reset"])) {
    $in_sql = "UPDATE dental_users SET
            claim_margin_top = '0',
            claim_margin_left = '0'
        WHERE userid='".$_SESSION['docid']."'";
    $db->query($in_sql);
}
?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage_claim_setup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
    Manage Profile
</span>
<br />
<br />
&nbsp;
<br />
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>
<?php
$p_sql = "SELECT * FROM dental_users where userid='".$db->escape($_SESSION['docid'])."'";
$practice = $db->getRow($p_sql);
?>
<div class="fullwidth">
    <div>
        <strong>Configuring your CMS 1500 form:</strong>
        <ol>
            <li>Insert a valid CMS 1500 form into your printer.</li>
            <li>Click "Print Test Claim" to print test data on the CMS 1500 form in your printer.</li>
            <li>Check alignment.  Adjust "Claim Margins" settings to shift the form up/down/left/right.</li>
            <li>Click "Update Margins" to save your new margins.</li>
            <li>Repeat steps 1-4 until your test claim shows the data aligned within the center of the CMS 1500 form boxes.</li>
            <li>Your printer is now calibrated for the CMS 1500 form.</li>
        </ol>
        <p>NOTE: Make sure that "Page Scaling" is set to NONE in your print settings when you print the PDF test file, or you will experience alignment issues.</p>
        <p>If you wish to reset the claim back to original settings click "Reset Margins".</p>
    </div>
    <h3>Claim Margins</h3>
    <form action="#" method="post">
        <div class="detail">
            <label>Top:</label>
            <input class="value" name="claim_margin_top" value="<?php echo $practice['claim_margin_top']; ?>" />mm. Positive values shift down, negative shift up.
        </div>
        <div class="detail">
            <label>Left:</label>
            <input class="value" name="claim_margin_left" value="<?php echo $practice['claim_margin_left']; ?>" />mm. Positive values shift right, negative shift left.
        </div>
        <div class="detail">
            <label>&nbsp;</label>
            <input type="submit" name="margins_submit" value="Update Margins" />
            <input type="submit" name="margins_reset" value="Reset Margins" />
            <input type="submit" name="margins_test" value="Print Test Claim" />
        </div>
    </form>
</div>
<div style="clear:both;"></div>
<div id="popupContact" style="width:750px;height:460px">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php include "includes/bottom.htm";?>
