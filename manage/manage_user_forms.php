<? 
include "includes/top.htm";

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Forms
</span>
<br />
<br />
<?php if(isset($_GET['msg'])){ ?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php } ?>
 <style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
		 	Form	
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
			<tr class="tr_active">
				<td valign="top">
					Record Release
				</td>
				<td valign="top">
					<?php
						$loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
						$loc_q = mysql_query($loc_sql);
						$num_loc = mysql_num_rows($loc_q);
						if($num_loc > 1){ 
						while($loc_r = mysql_fetch_assoc($loc_q)){
						?>
                                        <a href="view_user_form.php?file=user_record_release&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
							<?php } ?>
						<?php }else{ ?>
					<a href="view_user_form.php?file=user_record_release&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
						View
					</a>
						<?php } ?>
				</td>
			</tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Financial Agreement Medicare 
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=financial_agreement_medicare&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
					Release of Liability and Assumption of Risk
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=release_liability&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>

                        <tr class="tr_active">
                                <td valign="top">
                                        Home Care Instructions
                                </td>
                                <td valign="top">
                                        <?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
                                                if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=home_care_instructions&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=home_care_instructions&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Non-dentist of Record Release
                                </td>
                                <td valign="top">
                                        <?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
                                                if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=non_dentist_of_record_release&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=non_dentist_of_record_release&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>

                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Sleep Recorder Release
                                </td>
                                <td valign="top">
                                        <?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
                                                if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=sleep_recorder_release&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=sleep_recorder_release&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>

                                </td>
                        </tr>




                        <tr class="tr_active">
                                <td valign="top">
                             		Affidavit for CPAP Intolerance           
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=affidavit_for_cpap_intolerance&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Device Titration (EMA)
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=device_titration_ema&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Device Titration
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=device_titration&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        ESS/TSS Form
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=ess_tss_form&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Financial Agreement
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=financial_agreement&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Informed Consent
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=informed_consent&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                             		LOMN Rx           
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=lomn_rx&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
					Medical Hx Update                                        
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=medical_hx_update&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
		<?php if($_SESSION['user_type']==DSS_USER_TYPE_FRANCHISEE){ ?>
                        <tr class="tr_active">
                                <td valign="top">
                                        The DSS Experience
                                </td>
                                <td valign="top">
                                        <a href="view_user_form.php?file=the_dss_experience&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                </td>
                        </tr>
			<?php } ?>
                        <tr class="tr_active">
                                <td valign="top">
                                        Patient Notices
                                </td>
                                <td valign="top">
						<?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
						if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=patient_notices&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=patient_notices&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>

                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        New Patient Form 
                                </td>
                                <td valign="top">
                                                <?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
                                                if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=new_patient&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=new_patient&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>
                                </td>
                        </tr>
                        <tr class="tr_active">
                                <td valign="top">
                                        Patient Questionnaire
                                </td>
                                <td valign="top">
                                                <?php
                                                $loc_sql = "SELECT id, location FROM dental_locations WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'";
                                                $loc_q = mysql_query($loc_sql);
                                                $num_loc = mysql_num_rows($loc_q);
                                                if($num_loc > 1){
                                                while($loc_r = mysql_fetch_assoc($loc_q)){
                                                ?>
                                        <a href="view_user_form.php?file=patient_questionnaire&locid=<?= $loc_r['id']; ?>&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View <?= $loc_r['location']; ?><br />
                                        </a>
                                                        <?php } ?>
                                                <?php }else{ ?>
                                        <a href="view_user_form.php?file=patient_questionnaire&did=<?= $_SESSION['docid']; ?>" class="editlink" title="EDIT">
                                                View
                                        </a>
                                                <?php } ?>
                                </td>
                        </tr>

</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
