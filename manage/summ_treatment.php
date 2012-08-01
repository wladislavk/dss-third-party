<?php
$sql = "select * from dental_q_page1 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page1id = st($myarray['q_page1id']);
$exam_date = st($myarray['exam_date']);
$ess = st($myarray['ess']);
$tss = st($myarray['tss']);
$chief_complaint_text = st($myarray['chief_complaint_text']);
$complaintid = st($myarray['complaintid']);
$other_complaint = st($myarray['other_complaint']);
$additional_paragraph = st($myarray['additional_paragraph']);
$energy_level = st($myarray['energy_level']);
$snoring_sound = st($myarray['snoring_sound']);
$wake_night = st($myarray['wake_night']);
$breathing_night = st($myarray['breathing_night']);
$morning_headaches = st($myarray['morning_headaches']);
$hours_sleep = st($myarray['hours_sleep']);
$quit_breathing = st($myarray['quit_breathing']);
$bed_time_partner = st($myarray['bed_time_partner']);
$sleep_same_room = st($myarray['sleep_same_room']);
$told_you_snore = st($myarray['told_you_snore']);
$main_reason = st($myarray['main_reason']);
$main_reason_other = st($myarray['main_reason_other']);
$sleep_qual = st($myarray['sleep_qual']);

if($complaintid <> '')
{
        $comp_arr1 = split('~',$complaintid);

        foreach($comp_arr1 as $i => $val)
        {
                $comp_arr2 = explode('|',$val);

                $compid[$i] = $comp_arr2[0];
                $compseq[$i] = $comp_arr2[1];
        }
}
?>
	  <?php if($ess != ''){ ?>
          Baseline Epworth Sleepiness Score: <input type="text" id="ess" name="ess" value="<?= $ess; ?>" />
          <br />
	  <?php } ?>
	  <?php if($tss != ''){ ?>
          Baseline Thornton Snoring Scale: <input type="text" id="tss" name="tss" value="<?= $tss; ?>" />
	  <?php } ?>

	  <?php if($cheif_complaint_text != ''){ ?>
                    <label style="display:block;">
                        What is the main reason that you decided to seek treatment for snoring, Sleep Disordered Breathing, or Sleep Apnea?
                    </label>
                        <textarea style="width:400px; height:100px;" name="chief_complaint_text" id="chief_complain_text"><?= $chief_complaint_text; ?></textarea>
	  <?php } ?>

<?php if($complaintid != '' || in_array('0', $compid)){ ?>
<h3>Complaints</h3>
<ul>
		<?php if($complaintid != ''){ ?>
                    <?
                                        $complaint_sql = "select * from dental_complaint where status=1 order by sortby";
                                        $complaint_my = mysql_query($complaint_sql);
                                        $complaint_number = mysql_num_rows($complaint_my);
                                        while($complaint_myarray = mysql_fetch_array($complaint_my))
                                        {
                                                if(@array_search($complaint_myarray['complaintid'],$compid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else
                                                {
                                                   #     $chk = ($compseq[@array_search($complaint_myarray['complaintid'],$compid)])?1:0;
							?><li><?= $complaint_myarray['complaint']; ?></li><?php
                                                }
					}

?>
<?php } ?>
<?php if($other_complaint != '' && in_array('0', $compid)){ ?>
<li><?= $other_complaint; ?></li>
<?php } ?>
</ul>
<?php } ?>


<h3>Subjective Signs/Symptoms</h3>

                    <div>
                        <span class="full">
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
				<?php if($energy_level != ''){ ?>
                                <tr>
                                        <td valign="top" width="60%">
                                        Rate your overall energy level 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?= $energy_level;?>
                                    </td>
                                </tr>
				<? } ?>
                                <?php if($sleep_qual != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        Rate your sleep quality 0-10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?=$sleep_qual;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($told_you_snore != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Have you been told you snore?
                                    </td>
                                    <td valign="top">
                                            <?=$told_you_snore;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($snoring_sound != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        Rate the sound of your snoring 0 -10 (10 being the highest)
                                    </td>
                                    <td valign="top">
                                      <?=$snoring_sound ;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($wake_night != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many times per night do you wake up?
                                    </td>
                                    <td valign="top">
                                                <?=$wake_night;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($hours_sleep != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        On average how many hours of sleep do you get per night?
                                    </td>
                                    <td valign="top">
                                                <?=$hours_sleep;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($morning_headaches != ''){ ?>
                                                               <tr>
                                        <td valign="top">
                                        How often do you wake up with morning headaches?
                                    </td>
                                    <td valign="top">
                                            <?= $morning_headaches;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($bed_time_partner != ''){ ?>
                                                                                                <tr>
                                        <td valign="top">
                                        Do you have a bed time partner?
                                    </td>
                                    <td valign="top">
                                            <?= $bed_time_partner;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($sleep_same_room != ''){ ?>
                                                                <tr>
                                        <td valign="top">
                                        If yes do they sleep in the same room?
                                    </td>
                                    <td valign="top">
                                            <?= $sleep_same_room;?>
                                    </td>
                                </tr>
                                <? } ?>
                                <?php if($quit_breathing != ''){ ?>
                                <tr>
                                        <td valign="top">
                                        How many times per night does your bedtime partner notice you quit breathing?
                                    </td>
                                    <td valign="top">
                                            <?= $quit_breathing;?>
                                    </td>
                                </tr>
                                <? } ?>

                            </table>

                        </span>
                    </div>



<?php
/******************************
*
*
* Q_PAGE2
*
*/

$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page2id = st($myarray['q_page2id']);

$polysomnographic = st($myarray['polysomnographic']);
$sleep_center_name_text = st($myarray['sleep_center_name_text']);
$sleep_study_on = st($myarray['sleep_study_on']);
$confirmed_diagnosis = st($myarray['confirmed_diagnosis']);
$rdi = st($myarray['rdi']);
$ahi = st($myarray['ahi']);
$cpap = st($myarray['cpap']);
$cur_cpap = st($myarray['cur_cpap']);
$intolerance = st($myarray['intolerance']);
$other_intolerance = st($myarray['other_intolerance']);
$other_therapy = st($myarray['other_therapy']);
$other = st($myarray['other']);
$affidavit = st($myarray['affidavit']);
$type_study = st($myarray['type_study']);
$nights_wear_cpap = st($myarray['nights_wear_cpap']);
$percent_night_cpap = st($myarray['percent_night_cpap']);
$custom_diagnosis = st($myarray['custom_diagnosis']);
$sleep_study_by = st($myarray['sleep_study_by']);
$triedquittried = st($myarray['triedquittried']);
$timesovertime = st($myarray['timesovertime']);
$dd_wearing = st($myarray['dd_wearing']);
$dd_prev = st($myarray['dd_prev']);
$dd_otc = st($myarray['dd_otc']);
$dd_fab = st($myarray['dd_fab']);
$dd_who = st($myarray['dd_who']);
$dd_experience = st($myarray['dd_experience']);
$surgery = st($myarray['surgery']);

if($cpap == '')
        $cpap = 'No';
?>
                                <?php if($polysomnographic != ''){ ?>
                    <div>
                        <span>
                                                        Have you had a sleep study

<?= ($polysomnographic == '1')?'Yes':'No'; ?> 
<?php if($polysomnographic == '1'){ ?>                  
                                <?php if($sleep_center_name_text != ''){ ?>
                            At <?=$sleep_center_name_text;?>
                                <? } ?>
                                <?php if($sleep_study_on != ''){ ?>
                            Date
                            <?=$sleep_study_on;?>
                                <? } ?>
<?php } ?>
                        </span>
                    </div>
		<?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        CPAP Intolerance
                    </label>
                                <?php if($cpap != ''){ ?>
                    <div>
                        <span>
                                Have you tried CPAP?
                            <input type="radio" class="cpap_radio" name="cpap" value="Yes" <? if($cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />
                            Yes

                            <input type="radio" class="cpap_radio" name="cpap" value="No" <? if($cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No

                </span>
                        </div>
                                <? } ?>
                                <?php if($cur_cpap != ''){  ?>
                    <div class="cpap_options">
                        <span>
                                Are you currently using CPAP?
                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="Yes" <? if($cur_cpap == 'Yes') echo " checked";?> onclick="chk_cpap()"  />                            Yes

                            <input type="radio" class="cur_cpap_radio" name="cur_cpap" value="No" <? if($cur_cpap == 'No') echo " checked";?> onclick="chk_cpap()"  />
                            No

                        </span>
                        </div>

                                <? } ?>
                                <?php if($nights_wear_cpap != ''){ ?>
                                        <div class="cpap_options2">                        <span>
                                                        If currently using CPAP, how many nights / week do you wear it? <input id="nights_wear_cpap" name="nights_wear_cpap" type="text" class="field text addr tbox" value="<?=$nights_wear_cpap;?>" maxlength="255" style="width:225px;" />
                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                <?php if($percent_night_cpap != ''){ ?>
                                        <div class="cpap_options2">
                        <span>
                                                        How many hours each night do you wear it? <input id="percent_night_cpap" name="percent_night_cpap" type="text" class="field text addr tbox" value="<?=$percent_night_cpap;?>" maxlength="255" style="width:225px;" />

                                                        <br />&nbsp;
                                                </span>
                                        </div>
                                <? } ?>
                                <?php if($intolerance != ''){ ?>
                        <div id="cpap_options" class="cpap_options">
                        <span>
                                What are your chief complaints about CPAP?

                            <br />

                            <?
                                                        $intolerance_sql = "select * from dental_intolerance where status=1 order by sortby";
                                                        $intolerance_my = mysql_query($intolerance_sql);

                                                        while($intolerance_myarray = mysql_fetch_array($intolerance_my))
                                                        {
                                                        ?>
                                                                <input type="checkbox" id="intolerance" name="intolerance[]" value="<?=st($intolerance_myarray['intoleranceid'])?>" <? if(strpos($intolerance,'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                <?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
                                                                <input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st($intolerance_myarray['intoleranceid']).'~') === false) {} else { echo " checked";}?> />
                                <?php } ?>
                                &nbsp;&nbsp;
                                <?=st($intolerance_myarray['intolerance']);?><br />
                                                        <?
                                                        }
                                                        ?>
                                        <input type="checkbox" id="cpap_other" name="intolerance[]" value="0" <? if(strpos($intolerance,'~'.st('0~')) === false) {} else { echo " checked";}?> onclick="chk_cpap_other()" />
                                <?php if($intolerance != $pat_row['intolerance'] && $showEdits){ ?>
                                                                <input type="checkbox" disabled="disabled" <? if(strpos($pat_row['intolerance'],'~'.st('0~')) === false) {} else { echo " checked";}?> />
                                <?php } ?>

&nbsp;&nbsp; Other<br />
                        </span>
                                        </div>
                                <? } ?>
                                <?php if($other_intolerance != ''){ ?>
                    <br />
                    <div class="cpap_options">
                        <span class="cpap_other_text">
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_intolerance" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_intolerance;?></textarea>
                                                        <br />&nbsp;
                        </span>
                    </div>
                                <? } ?>

                    <label class="desc" id="title0" for="Field0">
                        Dental Devices
                    </label>
                                <?php if($dd_wearing != ''){ ?>
                    <div>
                        <span>
                                Are you currently wearing a dental device?
                            <input type="radio" class="dd_wearing_radio" name="dd_wearing" value="Yes" <? if($dd_wearing == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" class="dd_wearing_radio" name="dd_wearing" value="No" <? if($dd_wearing == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_prev != ''){ ?>
                    <div>
                        <span>
                                Have you previously tried a dental device?
                            <input type="radio" class="dd_prev_radio" name="dd_prev" value="Yes" <? if($dd_prev == 'Yes') echo " checked";?> onclick="chk_dd()"  />
                            Yes

                            <input type="radio" class="dd_prev_radio" name="dd_prev" value="No" <? if($dd_prev == 'No') echo " checked";?> onclick="chk_dd()"  />
                            No
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_otc != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Was it over-the-counter (OTC)?
                            <input type="radio" class="dd_otc_radio" name="dd_otc" value="Yes" <? if($dd_otc == 'Yes') echo " checked";?> />
                            Yes

                            <input type="radio" class="dd_otc_radio" name="dd_otc" value="No" <? if($dd_otc == 'No') echo " checked";?> />
                            No
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_otc', $pat_row['dd_otc'], $dd_otc, true, $showEdits, 'radio');
                            ?>

                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_fab != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Was it fabricated by a dentist?
                            <input type="radio" class="dd_fab_radio" name="dd_fab" value="Yes" <? if($dd_fab == 'Yes') echo " checked";?> />
                            Yes

                            <input type="radio" class="dd_fab_radio" name="dd_fab" value="No" <? if($dd_fab == 'No') echo " checked";?> />
                            No
                        <span>
                    </div>
                                <? } ?>
                                <?php if($dd_who != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Who <input type="text" id="dd_who" name="dd_who" value="<?= $dd_who; ?>" />
                        </span>
                    </div>
                                <? } ?>
                                <?php if($dd_experience != ''){ ?>
                    <div class="dd_options">
                        <span>
                                Describe your experience<br />
                                <textarea id="dd_experience" name="dd_experience"><?= $dd_experience; ?></textarea>
                            <?php
                                showPatientValue('dental_q_page2', $_GET['pid'], 'dd_experience', $pat_row['dd_experience'], $dd_experience, true, $showEdits);
                            ?>

                        </span>
                    </div>
                                <? } ?>
                    <label class="desc" id="title0" for="Field0">
                        Surgery
                    </label>
                                <?php if($surgery != ''){ ?>
                    <div>
                        <span>
                                Have you had surgery for snoring or sleep apnea?
                            <input type="radio" class="surgery_radio" name="surgery" value="Yes" <? if($surgery == 'Yes') echo " checked";?> onclick="chk_s()" />
                            Yes

                            <input type="radio" class="surgery_radio" name="surgery" value="No" <? if($surgery == 'No') echo " checked";?> onclick="chk_s()" />
                            No
                        </span>                    </div>
                                <? } ?>
                                <?php 
                  $s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".mysql_real_escape_string($_REQUEST['pid'])."'";
                  $s_q = mysql_query($s_sql);
		  $s_num = mysql_num_rows($s_q);
				if($s_num != 0){ ?>
                    <div class="s_options">
                        <span>
Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)
        <table id="surgery_table">
        <tr><th>Date</th><th>Surgeon</th><th>Surgery</th><th></th></tr>
                <?php
                  $s_count = 0;
                  while($s_row = mysql_fetch_assoc($s_q)){
                ?>
          <tr id="surgery_row_<?= $s_count; ?>">
                <td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="<?= $s_row['id']; ?>" /><input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" value="<?= $s_row['surgery_date']; ?>" /></td>
                <td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" value="<?= $s_row['surgeon']; ?>" /></td>
                <td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" value="<?= $s_row['surgery']; ?>" /></td>
          </tr>
                <?php
                        $s_count++;
                        }
                ?>
          <tr id="surgery_row_<?= $s_count; ?>">
                <td><input type="hidden" name="surgery_id_<?= $s_count; ?>" value="0" /><input type="text" id="surgery_date_<?= $s_count; ?>" name="surgery_date_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgeon_<?= $s_count; ?>" name="surgeon_<?= $s_count; ?>" /></td>
                <td><input type="text" id="surgery_<?= $s_count; ?>" name="surgery_<?= $s_count; ?>" /></td>
          </tr>
        </table>
                        </span>
                    </div>
		<?php } ?>

	<?php if($other_therapy != ''){ ?>
                    <label class="desc" id="title0" for="Field0">
                        OTHER ATTEMPTED THERAPIES
                    </label>
                    <div>
                        <span>
                            Please comment about other therapy attempts and how each impacted your snoring and apnea and sleep quality.
                            <br />
                            <textarea name="other_therapy" class="field text addr tbox" style="width:650px; height:100px;" ><?=$other_therapy;?></textarea>

                        </span>
                        </div>
	<? } ?>

