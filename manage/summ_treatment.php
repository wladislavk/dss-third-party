<?php
$sql = "select * from dental_q_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$other_therapy = st($myarray['other_therapy']);
$dd_wearing = st($myarray['dd_wearing']);
$dd_prev = st($myarray['dd_prev']);
$dd_otc = st($myarray['dd_otc']);
$dd_fab = st($myarray['dd_fab']);
$dd_who = st($myarray['dd_who']);
$dd_experience = st($myarray['dd_experience']);
$surgery = st($myarray['surgery']);

if($dd_wearing == '' &&
  $dd_prev == '' &&
  $dd_otc == '' &&
  $dd_fab == '' &&
  $dd_who == '' &&
  $dd_experience == '' &&
  $surgery == '' &&
  $other_therapy == ''){
?>

<p>No previous treatments documented.</p>

<?php
}else{  
?>
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
<?php } ?>
