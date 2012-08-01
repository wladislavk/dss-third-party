<?php

$sql = "select * from dental_q_page3 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_page3id = st($myarray['q_page3id']);
$allergens = st($myarray['allergens']);
$other_allergens = st($myarray['other_allergens']);
$medications = st($myarray['medications']);
$other_medications = st($myarray['other_medications']);
$history = st($myarray['history']);
$other_history = st($myarray['other_history']);
$dental_health = st($myarray['dental_health']);
$injurytohead = st($myarray['injurytohead']);
        $injurytoface = st($myarray['injurytoface']);
        $injurytoneck = st($myarray['injurytoneck']);
        $injurytoteeth = st($myarray['injurytoteeth']);
        $injurytomouth = st($myarray['injurytomouth']);
        $drymouth = st($myarray['drymouth']);
$removable = st($myarray['removable']);
$year_completed = st($myarray['year_completed']);
$tmj = st($myarray['tmj']);
$gum_problems = st($myarray['gum_problems']);
$dental_pain = st($myarray['dental_pain']);
$dental_pain_describe = st($myarray['dental_pain_describe']);
$completed_future = st($myarray['completed_future']);
$clinch_grind = st($myarray['clinch_grind']);
$wisdom_extraction = st($myarray['wisdom_extraction']);
$jawjointsurgery = st($myarray['jawjointsurgery']);
$no_allergens = st($myarray['no_allergens']);
$no_medications = st($myarray['no_medications']);
$no_history = st($myarray['no_history']);
$orthodontics = st($myarray['orthodontics']);
$psql = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
$pmy = mysql_query($psql);
$pmyarray = mysql_fetch_array($pmy);
$premedcheck = st($pmyarray["premedcheck"]);
$allergenscheck = st($myarray["allergenscheck"]);
$medicationscheck = st($myarray["medicationscheck"]);
$historycheck = st($myarray["historycheck"]);
$premeddet = st($pmyarray["premed"]);
$family_hd = st($myarray["family_hd"]);

$family_bp = st($myarray["family_bp"]);
$family_dia = st($myarray["family_dia"]);
$family_sd = st($myarray["family_sd"]);
$alcohol = st($myarray['alcohol']);
$sedative = st($myarray['sedative']);
$caffeine = st($myarray['caffeine']);
$smoke = st($myarray['smoke']);
$smoke_packs = st($myarray['smoke_packs']);
$tobacco = st($myarray['tobacco']);
$additional_paragraph = st($myarray['additional_paragraph']);
        $wisdom_extraction_text = $myarray['wisdom_extraction_text'];
        $removable_text  = $myarray['removable_text'];
        $dentures  = $myarray['dentures'];
        $dentures_text  = $myarray['dentures_text'];
        $tmj_cp  = $myarray['tmj_cp'];
        $tmj_cp_text  = $myarray['tmj_cp_text'];
        $tmj_pain  = $myarray['tmj_pain'];
        $tmj_pain_text  = $myarray['tmj_pain_text'];
        $tmj_surgery  = $myarray['tmj_surgery'];
        $tmj_surgery_text  = $myarray['tmj_surgery_text'];
        $injury  = $myarray['injury'];
        $injury_text  = $myarray['injury_text'];
        $gum_prob  = $myarray['gum_prob'];
        $gum_prob_text  = $myarray['gum_prob_text'];
        $gum_surgery  = $myarray['gum_surgery'];
        $gum_surgery_text  = $myarray['gum_surgery_text'];
        $clinch_grind_text  = $myarray['clinch_grind_text'];
        $future_dental_det = $myarray['future_dental_det'];
        $drymouth_text = $myarray['drymouth_text'];

?>
		<label class="desc" id="title0" for="Field0" style="width:90%;">
                            Premedication
                            <span id="req_0" class="req">*</span>
                        </label><br />
                        <div>
			  <?php if($premedcheck != ''){ ?>
                            <span>
                                Have you been told you should receive pre-medication before dental procedures?
                                <input id="premedcheck" class="premedcheck_radio" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='block'" value="1" /> Yes
                                <input id="premedcheck" class="premedcheck_radio" name="premedcheck" tabindex="5" type="radio"  <?php if($premedcheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('pm_det').style.display='none'" value="0" /> No
                            </span>
                          <?php } ?>
                          <?php if($premeddet != ''){ ?>
                            <span id="pm_det" <?php if($premedcheck == 0 && (!$showEdits || $premedcheck==$dpp_row['premedcheck'])){ echo 'style="display:none;"';} ?>>
                                What medication(s) and why do you require it?<br />
                                <textarea name="premeddet" id="premeddet" class="field text addr tbox" style="width:610px;" tabindex="18" ><?=$premeddet;?></textarea>
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'premeddet', $dpp_row['premeddet'], $premeddet, true, $showEdits);
                            ?>

                            </span>
                          <?php } ?>
                       </div>

                          <?php if($allergenscheck != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%">
                        Allergens
                    </label><br />
                    <div>
                        <span>
                            <span>
                                Do you have any known allergens (for example: aspirin, latex, penicillin, etc)?
                                <input id="allergenscheck" class="allergenscheck_radio" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('a_det').style.display='block'" value="1" /> Yes
                        <input id="allergenscheck" class="allergenscheck_radio" name="allergenscheck" tabindex="5" type="radio"  <?php if($allergenscheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('a_det').style.display='none'" value="0" /> No
                    </span>
                          <?php if($other_allergens != ''){ ?>
                            <span id="a_det" <?php if($allergenscheck == 0 && (!$showEdits || $allergenscheck==$dpp_row['allergenscheck'])){ echo 'style="display:none;"';} ?>>
                                Please list everything you are allergic to:<br />
                               <textarea name="other_allergens" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_allergens;?></textarea>
                            </span>
                          <?php } ?>
                        </span>
                    </div>
                          <?php } ?>

                          <?php if($medicationscheck != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%">
                        Current Medications
                    </label><br />
                    <div>
                        <span>
                            <span>
                                Are you currently taking any medications?
                                <input id="medicationscheck" class="medicationscheck_radio" name="medicationscheck" tabindex="5" type="radio"  <?php if($medicationscheck == 1){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('m_det').style.display='block'" value="1" /> Yes
                                <input id="medicationscheck" class="medicationscheck_radio" name="medicationscheck" tabindex="5" type="radio"  <?php if($medicationscheck == 0){ echo "checked=\"checked\"";} ?> onclick="document.getElementById('m_det').style.display='none'" value="0" /> No
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'medicationscheck', $pat_row['medicationscheck'], $medicationscheck, true, $showEdits, 'radio');
                            ?>

                            </span>
                          <?php if($other_medications != ''){ ?>
                        <span id="m_det" <?php if($medicationscheck == 0 && (!$showEdits || $medicationscheck==$dpp_row['medicationscheck'])){ echo 'style="display:none;"';} ?>>
                                Please list all medication you are currently taking: <br />
                            <textarea name="other_medications" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_medications;?></textarea>
                        </span>
                          <?php } ?>
                        </span>
                    </div>

                          <?php } ?>
                          <?php if($other_history != ''){ ?>
                    <label class="desc" id="title0" for="Field0" style="width:90%;">
                        Medical History
                    </label>
                    <div>
                        <span>
                            <span>
                                Please list all medical diagnoses and surgeries from birth until now (for example: heart attack, high blood pressure, asthma, stroke, hip replacement, HIV, diabetes, etc):
                            </span>
                             <span id="h_det" >
                                <textarea name="other_history" class="text addr tbox" style="width:650px; height:100px;" tabindex="10"><?=$other_history;?></textarea>
                             </span>
                        </span>
                    </div>
                          <?php } ?>
                        <br />

                    <label class="desc" id="title0" for="Field0">
                        Dental History
                    </label>
		<?php if($dental_health != ''){ ?>
                    <div>
                        <span class="full">
                                                        How would you describe your dental health?
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="dental_health" style="width:250px;">
                                <option value=""></option>
                                <option value="Excellent" <? if($dental_health == 'Excellent' ) echo " selected";?>>
                                        Excellent
                                </option>
                                <option value="Good" <? if($dental_health == 'Good' ) echo " selected";?>>
                                        Good
                                </option>
                                <option value="Fair" <? if($dental_health == 'Fair' ) echo " selected";?>>
                                        Fair
                                </option>
                                <option value="Poor" <? if($dental_health == 'Poor' ) echo " selected";?>>
                                        Poor
                                </option>
                            </select>

                                                </span>
                                        </div>
                <?php } ?>
                <?php if($wisdom_extraction != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Have you ever had teeth extracted?</label>

                                                        <input type="radio" class="extra wisdom_extraction_radio" name="wisdom_extraction" value="Yes" <? if($wisdom_extraction == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra wisdom_extraction_radio" name="wisdom_extraction" value="No" <? if($wisdom_extraction == 'No') echo " checked";?> />No

                                                        <span id="wisdom_extraction_extra">Please describe: <input type="text" class="field text addr tbox" id="wisdom_extraction_text" name="wisdom_extraction_text" value="<?= $wisdom_extraction_text; ?>" />
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($removable != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Do you wear removable partials?</label>

                                                        <input type="radio" class="extra removable_radio" name="removable" value="Yes" <? if($removable == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra removable_radio" name="removable" value="No" <? if($removable == 'No') echo " checked";?> />No

                                                        <span id="removable_extra">Please describe: <input type="text" class="field text addr tbox" id="removable_text" name="removable_text" value="<?= $removable_text; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($dentures != ''){ ?>
                                       <div>
                        <span>
                                                        <label>Do you wear dentures?</label>

                                                        <input type="radio" class="extra dentures_radio" name="dentures" value="Yes" <? if($dentures == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra dentures_radio" name="dentures" value="No" <? if($dentures == 'No') echo " checked";?> />No

                                                        <span id="dentures_extra">Please describe: <input type="text" class="field text addr tbox" id="dentures_text" name="dentures_text" value="<?= $dentures_text; ?>" />

</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($orthodontics != ''){ ?>

                                        <div>
                        <span>
                                                        <label>Have you worn orthodontics (braces)?</label>

                                                        <input type="radio" class="extra orthodontics_radio" name="orthodontics" value="Yes" <? if($orthodontics == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra orthodontics_radio" name="orthodontics" value="No" <? if($orthodontics == 'No') echo " checked";?>  />No

                                                        <span id="orthodontics_extra">Year completed: <input id="year_completed" name="year_completed" type="text" class="field text addr tbox" value="<?=$year_completed;?>" maxlength="255" style="width:225px;" />
                        </span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($tmj_cp != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Does your TMJ (jaw joint) click or pop?</label>
                                                        <input type="radio" class="extra tmj_cp_radio" name="tmj_cp" value="Yes" <? if($tmj_cp == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra tmj_cp_radio" name="tmj_cp" value="No" <? if($tmj_cp == 'No') echo " checked";?> />No

                                                        <span id="tmj_cp_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_cp_text" name="tmj_cp_text" value="<?= $tmj_cp_text; ?>" />

</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($tmj_pain != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Do you have pain in this joint?</label>
                                                        <input type="radio" class="extra tmj_pain_radio" name="tmj_pain" value="Yes" <? if($tmj_pain == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra tmj_pain_radio" name="tmj_pain" value="No" <? if($tmj_pain == 'No') echo " checked";?> />No

                                                        <span id="tmj_pain_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_pain_text" name="tmj_pain_text" value="<?= $tmj_pain_text; ?>" />
</span>
                                                </span>
                                        </div>

                <?php } ?>
                <?php if($tmj_surgery != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Have you had TMJ (jaw joint) surgery?</label>
                                                        <input type="radio" class="extra tmj_surgery_radio" name="tmj_surgery" value="Yes" <? if($tmj_surgery == 'Yes') echo " checked";?> />Yes

                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <input type="radio" class="extra tmj_surgery_radio" name="tmj_surgery" value="No" <? if($tmj_surgery == 'No') echo " checked";?> />No

                                                        <span id="tmj_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="tmj_surgery_text" name="tmj_surgery_text" value="<?= $tmj_surgery_text; ?>" />
</span>

                                                </span>
                                        </div>
                <?php } ?>
                <?php if($gum_prob != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Have you ever had gum problems?</label>
                            <input id="gum_prob" name="gum_prob" type="radio" class="extra gum_prob_radio" value="Yes" <?= ($gum_prob=='Yes')?'checked="checked"':'';?> /> Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="gum_prob" name="gum_prob" type="radio" class="extra gum_prob_radio" value="No" <?= ($gum_prob=='No')?'checked="checked"':'';?> /> No

                                                        <span id="gum_prob_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_prob_text" name="gum_prob_text"  value="<?= $gum_prob_text; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($gum_surgery != ''){ ?>

                                        <div>
                        <span>
                                                        <label>Have you ever had gum surgery?</label>

                                                        <input type="radio" class="extra gum_surgery_radio" name="gum_surgery" value="Yes" <? if($gum_surgery == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra gum_surgery_radio" name="gum_surgery" value="No" <? if($gum_surgery == 'No') echo " checked";?> />No

                                                        <span id="gum_surgery_extra">Please describe: <input type="text" class="field text addr tbox" id="gum_surgery_text" name="gum_surgery_text" value="<?= $gum_surgery_text; ?>" />

</span>
                                                </span>
                                        </div>

                <?php } ?>
                <?php if($drymouth != ''){ ?>

                                        <div>
                        <span>
                                                        <label>Do you have morning dry mouth?</label>

                                                        <input type="radio" class="extra drymouth_radio" name="drymouth" value="Yes" <? if($drymouth == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra drymouth_radio" name="drymouth" value="No" <? if($drymouth == 'No') echo " checked";?> />No

                                                        <span id="drymouth_extra">Please describe: <input type="text" class="field text addr tbox" id="drymouth_text" name="drymouth_text" value="<?= $drymouth_text; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($injury != ''){ ?>

                                 <div>                        <span>
                                                        <label>Have you ever had injury to your head, face, neck, mouth, or teeth?</label>

                                                        <input type="radio" class="extra injury_radio" name="injury" value="Yes" <? if($injury == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra injury_radio" name="injury" value="No" <? if($injury == 'No') echo " checked";?> />No

                                                        <span id="injury_extra">Please describe: <input type="text" class="field text addr tbox" id="injury_text" name="injury_text" value="<?= $injury_text; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($completed_future != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Are you planning to have dental work done in the near future?</label>


                                                        <input type="radio" class="extra completed_future_radio" name="completed_future" value="Yes" <? if($completed_future == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra completed_future_radio" name="completed_future" value="No" <? if($completed_future == 'No') echo " checked";?> />No

<span id="completed_future_extra">Please describe: <input type="text" class="field text addr tbox" id="future_dental_det" name="future_dental_det"  value="<?= $future_dental_det; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
                <?php if($clinch_teeth != ''){ ?>
                                        <div>
                        <span>
                                                        <label>Do you clinch or grind your teeth?</label>

                                                        <input type="radio" class="extra clinch_grind_radio" name="clinch_grind" value="Yes" <? if($clinch_grind == 'Yes') echo " checked";?> />Yes
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                                        <input type="radio" class="extra clinch_grind_radio" name="clinch_grind" value="No" <? if($clinch_grind == 'No') echo " checked";?> />No
                                                        <span id="clinch_grind_extra">Please describe: <input type="text" class="field text addr tbox" id="clinch_grind_text" name="clinch_grind_text" value="<?= $clinch_grind_text; ?>" />
</span>
                                                </span>
                                        </div>
                <?php } ?>
<label class="desc" id="title0" for="Field0">
                        Family History
                    </label>
                <?php if($family_hd != ''){ ?>
                    <div>
                        <span class="full">
                                <label>Have genetic members of your family had Heart Disease?</label>
                                                <input type="radio" name="family_hd" class="family_hd_radio" value="Yes" style="width:10px;" <?= ($family_hd == "Yes")?'checked="checked"':''; ?> /> Yes
                                                <input type="radio" name="family_hd" class="family_hd_radio" value="No" style="width:10px;" <?= ($family_hd == "No")?'checked="checked"':''; ?> /> No
                                                                    <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'family_hd', $pat_row['family_hd'], $family_hd, true, $showEdits, 'radio');
                            ?>

                        </span>
                    </div>
                <?php } ?>
                <?php if($family_bp != ''){ ?>
                    <div>
                        <span>
                                <label>High Blood Pressure?</label>
                                                <input type="radio" class="family_bp_radio" name="family_bp" value="Yes" style="width:10px;" <?= ($family_bp == "Yes")?'checked="checked"':''; ?> /> Yes
                                                <input type="radio" class="family_bp_radio" name="family_bp" value="No" style="width:10px;" <?= ($family_bp == "No")?'checked="checked"':''; ?> /> No
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'family_bp', $pat_row['family_bp'], $family_bp, true, $showEdits, 'radio');
                            ?>

                        </span>
                    </div>
                <?php } ?>
                <?php if($family_dia != ''){ ?>
                    <div>
                        <span>
                             <label>Diabetes?</label>
                                                <input type="radio" class="family_dia_radio" name="family_dia" value="Yes" style="width:10px;" <?= ($family_dia == "Yes")?'checked="checked"':''; ?> /> Yes
                                                <input type="radio" class="family_dia_radio" name="family_dia" value="No" style="width:10px;" <?= ($family_dia == "No")?'checked="checked"':''; ?> /> No
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'family_dia', $pat_row['family_dia'], $family_dia, true, $showEdits, 'radio');
                            ?>

                                        </span>
                </div>
                <?php } ?>
                <?php if($family_sd != ''){ ?>
                <div>
                        <span>
                                <label>Have any genetic members of your family been diagnosed or treated for a sleep disorder?</label>
                                <input type="radio" class="family_sd_radio" name="family_sd" value="Yes" style="width:10px;" <?= ($family_sd == "Yes")?'checked="checked"':''; ?> /> Yes
                                <input type="radio" class="family_sd_radio" name="family_sd" value="No" style="width:10px;" <?= ($family_sd == "No")?'checked="checked"':''; ?> /> No
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'family_sd', $pat_row['family_sd'], $family_sd, true, $showEdits, 'radio');
                            ?>

                        </span>

		</div>
                <?php } ?>

		<label class="desc" id="title0" for="Field0">
                        SOCIAL HISTORY
                    </label>
                <?php if($alcohol != ''){ ?>
                    <div>
                        <span class="full">
                                Alcohol consumption: How often do you consume alcohol within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="alcohol" value="Daily" class="tbox" style="width:10px;" <? if($alcohol == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="occasionally" class="tbox" style="width:10px;" <? if($alcohol == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="alcohol" value="never" class="tbox" style="width:10px;" <? if($alcohol == 'never')  echo " checked";?> />
                            Rarely/Never
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'alcohol', $pat_row['alcohol'], $alcohol, true, $showEdits);
                            ?>

                            <br /><br />
                <?php } ?>
                <?php if($sedative != ''){ ?>
                            Sedative Consumption: How often do you take sedatives within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="sedative" value="Daily" class="tbox" style="width:10px;" <? if($sedative == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="occasionally" class="tbox" style="width:10px;" <? if($sedative == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="sedative" value="never" class="tbox" style="width:10px;" <? if($sedative == 'never')  echo " checked";?> />
                            Rarely/Never


                            <br /><br />
                <?php } ?>
                <?php if($caffeine != ''){ ?>

                            Caffeine consumption: How often do you consume caffeine within 2-3 hours of bedtime?
                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="caffeine" value="Daily" class="tbox" style="width:10px;" <? if($caffeine == 'Daily')  echo " checked";?> />
                            Daily
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="occasionally" class="tbox" style="width:10px;" <? if($caffeine == 'occasionally')  echo " checked";?> />
                            Occasionally
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="caffeine" value="never" class="tbox" style="width:10px;" <? if($caffeine == 'never')  echo " checked";?> />
                            Rarely/Never
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'caffeine', $pat_row['caffeine'], $caffeine, true, $showEdits);
                            ?>

                            <br /><br />
                <?php } ?>
                <?php if($smoke != ''){ ?>
                            Do you Smoke?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="smoke" value="Yes" class="tbox smoke_radio" style="width:10px;" <? if($smoke == 'Yes')  echo " checked";?>  onclick="displaysmoke();" />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="smoke" value="No" class="tbox smoke_radio" style="width:10px;" <? if($smoke == 'No')  echo " checked";?> onclick="hidesmoke();" />
                            No


                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <br />

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <div id="smoke">If Yes, number of packs per day
                            <input type="text" name="smoke_packs" value="<?=$smoke_packs?>" class="tbox" style="width:50px;" />
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'smoke_packs', $pat_row['smoke_packs'], $smoke_packs, true, $showEdits);
                            ?>

                            </div>
                            <br /><br />
                <?php } ?>
                <?php if($tobacco != ''){ ?>
                            Do you use Chewing Tobacco?

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="tobacco" value="Yes" class="tbox tobacco_radio" style="width:10px;" <? if($tobacco == 'Yes')  echo " checked";?> />
                            Yes
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="radio" name="tobacco" value="No" class="tbox tobacco_radio" style="width:10px;" <? if($tobacco == 'No')  echo " checked";?> />
                            No
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'tobacco', $pat_row['tobacco'], $tobacco, true, $showEdits, 'radio');
                            ?>

                        </span>
                                        </div>
                <br /><br />
                <?php } ?>
                <?php if($additional_paragraph != ''){ ?>
		<div>
                        <span>
                                Additional Paragraph<br />
                            <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                            <?php
                                showPatientValue('dental_q_page3', $_GET['pid'], 'additional_paragraph', $pat_row['additional_paragraph'], $additional_paragraph, true, $showEdits);
                            ?>

                        </span>
                    </div>
                <?php } ?>

<?php
$sql = "select * from dental_ex_page4 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page4id = st($myarray['ex_page4id']);
$exam_teeth = st($myarray['exam_teeth']);
$other_exam_teeth = st($myarray['other_exam_teeth']);
$caries = st($myarray['caries']);
$where_facets = st($myarray['where_facets']);
$missing = st($myarray['missing']);
$cracked_fractured = st($myarray['cracked_fractured']);
$old_worn_inadequate_restorations = st($myarray['old_worn_inadequate_restorations']);
$dental_class_right = st($myarray['dental_class_right']);
$dental_division_right = st($myarray['dental_division_right']);
$dental_class_left = st($myarray['dental_class_left']);
$dental_division_left = st($myarray['dental_division_left']);
$additional_paragraph = st($myarray['additional_paragraph']);
$initial_tooth = st($myarray['initial_tooth']);
$open_proximal = st($myarray['open_proximal']);
$deistema = st($myarray['deistema']);
$crossbite = st($myarray['crossbite']);

?>

                    <label class="desc" id="title0" for="Field0">
                        <span class="form_info">
                                DENTAL SCREENING
                        </span>
                    </label>
                <?php if($missing != ''){ ?>
                                        <div>
                        <span style="color:#000000;">
                                Missing Tooth #
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="text" name="missing" value="<?=$missing?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=missing&fval='+document.ex_page4frm.missing.value); return false;">Change</button>

                                                        <!--<button onclick="Javascript: loadPopup('missing_teeth_form.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&mt='+document.ex_page4frm.missing.value); getElementById('popupContact').style.top = '200px'; getElementById('popupContact').style.height = '500px'; return false;">Perio Chart</button>-->
                                                        <button onclick="Javascript: $('#perio_chart').toggle('slow'); return false;">Perio Chart</button>

                        </span>
                    </div>
<div id="perio_chart" style="display:none;">
<iframe name="perio_iframe" id="perio_iframe" src="missing_teeth_form.php?pid=<?=$_GET['pid']?>&mt=<?= $missing ?>" width="920" height="840"></iframe>
</div>
                    <br />
<?php } ?>

                    <label class="desc" id="title0" for="Field0">
                        EXAMINATION OF TEETH REVEALED
                    </label>

                    <div>
                        <span>
                                <?
                                                        $exam_teeth_sql = "select * from dental_exam_teeth where status=1 order by sortby";
                                                        $exam_teeth_my = mysql_query($exam_teeth_sql);

                                                        while($exam_teeth_myarray = mysql_fetch_array($exam_teeth_my))
                                                        {
							if(!strpos($exam_teeth,'~'.st($exam_teeth_myarray['exam_teethid']).'~') === false) {
                                                        ?>
                                                                <input type="checkbox" id="exam_teeth" name="exam_teeth[]" value="<?=st($exam_teeth_myarray['exam_teethid'])?>" <? if(strpos($exam_teeth,'~'.st($exam_teeth_myarray['exam_teethid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($exam_teeth_myarray['exam_teeth']);?><br />
                                                        <?
							}
                                                        }
                                                        ?>
                        </span>
                        </div>
		<?php if($other_exam_teeth != ''){ ?>
                    <div>
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_exam_teeth" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_exam_teeth;?></textarea>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($caries != ''){ ?>

                    <div>
                        <span style="color:#000000;">
                            <label class="exam_label">Caries Tooth #</label>
                            <input type="text" name="caries" value="<?=$caries?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=caries&fval='+document.ex_page4frm.caries.value); return false;">Change</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($where_facets != ''){ ?>
                    <div>
                        <span style="color:#000000;">
                            <label class="exam_label">Wear Facets Tooth #</label>
                            <input type="text" name="where_facets" value="<?=$where_facets?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=where_facets&fval='+document.ex_page4frm.where_facets.value); return false;">Change</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($cracked_fractured != ''){ ?>
                    <div>
                        <span style="color:#000000;">
                                <label class="exam_label">Cracked or Fractured Tooth #</label>
                            <input type="text" name="cracked_fractured" value="<?=$cracked_fractured?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=cracked_fractured&fval='+document.ex_page4frm.cracked_fractured.value); return false;">Change</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($old_worn_inadequate_restorations != ''){ ?>
                    <div>
                        <span style="color:#000000;">
                                <label class="exam_label">Old, Worn or Inadequate Restorations Tooth #</label>
                            <input type="text" name="old_worn_inadequate_restorations" value="<?=$old_worn_inadequate_restorations?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth.php?tx=old_worn_inadequate_restorations&fval='+document.ex_page4frm.old_worn_inadequate_restorations.value); return false;">Change</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        DENTAL RELATIONSHIP
                    </label>

                    <div>
                        <span class="left">
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" colspan="2" align="center" style="font-size:16px;">
                                        Right
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top" width="60%">
                                        <u>Class</u>
                                    </td>
                                        <td valign="top" width="40%">
                                        <u>Division</u>
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_right" value="I (normal)" <? if($dental_class_right == 'I (normal)') echo " checked";?> style="width:10px;" />
                                        I (normal)
                                    </td>
                                    <td valign="top">
                                        <input type="radio" name="dental_division_right" value="1" <? if($dental_division_right == '1') echo " checked";?> style="width:10px;" />
                                        1
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_right" value="II (Retrognathic)(Retruded Lower Jaw)" <? if($dental_class_right == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        II (Retrognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Retruded Lower Jaw)
                                    </td>
                                    <td valign="top">
                                        <input type="radio" name="dental_division_right" value="2" <? if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                        2
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_right" value="III (Prognathic)(Protruded Lower Jaw)" <? if($dental_class_right == 'III (Prognathic)(Protruded Lower Jaw)')
 echo " checked";?> style="width:10px;" />
                                        III (Prognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Protruded Lower Jaw)
                                    </td>
                                    <td valign="top">&nbsp;

                                    </td>
                                </tr>
                            </table>

                        </span>

                        <span class="left">
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" colspan="2" align="center" style="font-size:16px;">
                                        Left
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top" width="60%">
                                        <u>Class</u>
                                    </td>
                                        <td valign="top" width="40%">
                                        <u>Division</u>
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_left" value="I (normal)" <? if($dental_class_left == 'I (normal)') echo " checked";?> style="width:10px;" />
                                        I (normal)
                                    </td>
                                    <td valign="top">
                                        <input type="radio" name="dental_division_left" value="1" <? if($dental_division_left == '1') echo " checked";?> style="width:10px;" />
                                        1
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_left" value="II (Retrognathic)(Retruded Lower Jaw)" <? if($dental_class_left == 'II (Retrognathic)(Retruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        II (Retrognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Retruded Lower Jaw)
                                    </td>
                                    <td valign="top">
                                        <input type="radio" name="dental_division_left" value="2" <? if($dental_division_right == '2') echo " checked";?> style="width:10px;" />
                                        2
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <input type="radio" name="dental_class_left" value="III (Prognathic)(Protruded Lower Jaw)" <? if($dental_class_left == 'III (Prognathic)(Protruded Lower Jaw)') echo " checked";?> style="width:10px;" />
                                        III (Prognathic)
                                        <br />
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        (Protruded Lower Jaw)
                                    </td>
                                    <td valign="top">&nbsp;

                                    </td>
                                </tr>
                            </table>

                        </span>
                        </div>
                    <br />
<div class="clear"></div>
                <?php if($additional_paragraph != ''){ ?>
                    <label class="desc clear" id="title0" for="Field0">
                        Other Items:
                    </label>

                    <div>
                        <span>
                                <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        TOOTH CONTACT PRIOR TO ORAL APPLIANCE
                    </label>
                <?php if($crossbite != ''){ ?>
                                        <div>
                        <span>
                            <label class="exam_label">Teeth in Crossbite</label>

                            <input type="text" name="crossbite" value="<?=$crossbite;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=crossbite&fval=<?=$crossbite;?>');  return false;">Chart</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($initial_tooth != ''){ ?>
                    <div>
                        <span>
                                <label class="exam_label">The initial tooth contact was between</label>

                            <input type="text" name="initial_tooth" id="initial_tooth" value="<?=$initial_tooth;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=initial_tooth&fval=<?=$initial_tooth;?>'); return false;">Chart</button>
                            <button onclick="Javascript: $('#initial_tooth').val('Bilateral and even initial contact'); return false;">Bilateral and even initial contact</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($open_proximal != ''){ ?>
                    <div>
                        <span>
                                <label class="exam_label">Open proximal contact(s) present between teeth numbers</label>
                            <input type="text" name="open_proximal" value="<?=$open_proximal;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=open_proximal&fval=<?=$open_proximal;?>'); return false;">Chart</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                <?php if($deistema != ''){ ?>
                    <div>
                        <span>
                                <label class="exam_label">Diastema(s) present between teeth numbers</label>

                            <input type="text" name="deistema" value="<?=$deistema;?>" class="field text addr tbox" readonly="readonly" />
                            <button onclick="Javascript: loadPopupRefer('select_teeth_cross.php?tx=deistema&fval=<?=$deistema;?>'); return false;">Chart</button>
                        </span>
                    </div>
                    <br />
                <?php } ?>
<?php
$sql = "select * from dental_ex_page1 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page1id = st($myarray['ex_page1id']);
$blood_pressure = st($myarray['blood_pressure']);
$pulse = st($myarray['pulse']);
$neck_measurement = st($myarray['neck_measurement']);
//$bmi = st($myarray['bmi']);
$additional_paragraph = st($myarray['additional_paragraph']);
$tongue = st($myarray['tongue']);

?>

                    <label class="desc" id="title0" for="Field0">
                        VITAL DATA
                    </label>
                <?php if($blood_pressure != ''){ ?>
                    <div>
                        <span>
                                Blood Pressure
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            <input id="blood_pressure" name="blood_pressure" type="text" class="field text addr tbox" value="<?=$blood_pressure;?>" tabindex="1" maxlength="255" style="width:75px;" />
                        </span>
                        </div>
                    <br />
                <?php } ?>
                <?php if($pulse != ''){ ?>
                    <div>
                        <span>
                                Pulse
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;
                            <select name="pulse" id="pulse" class="field text addr tbox" style="width:50px;" tabindex="2">
                                <? for($i=50;$i<=150;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($pulse == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                        </span>
                        </div>
                    <br />
                <?php } ?>
                <?php if($neck_measurement != ''){ ?>
                    <div>
                        <span>
                                Neck Measurement
                            &nbsp;&nbsp;&nbsp;
                            <select name="neck_measurement" id="neck_measurement" class="field text addr tbox" style="width:50px;" tabindex="3">
                                <? for($i=5;$i<=29;$i+=.5)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($neck_measurement == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            inches
                        </span>
                        </div>
                    <br />
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                       HEIGHT/WEIGHT
                    </label>
    <ul style="width:50%; float:left;">
                <?php if($feet != ''){ ?>
                <li>
                            <select name="feet" id="feet" class="field text addr tbox" style="width:100px;" tabindex="5" onchange="cal_bmi();" >
                                <option value="0">Feet</option>
                                <? for($i=1;$i<9;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($feet == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <?php
                                showPatientValue('dental_patients', $_GET['pid'], 'feet', $pat_row['feet'], $feet, true, $showEdits);
                            ?>
                            <label for="feet">Feet</label>
                </li>
                <?php } ?>
                <?php if($inches != ''){ ?>
                <li>
                            <select name="inches" id="inches" class="field text addr tbox" style="width:100px;" tabindex="6" onchange="cal_bmi();">
                                <option value="-1">Inches</option>
                                <? for($i=0;$i<12;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($inches!='' && $inches == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>
                            <label for="inches">Inches</label>
                </li>
                <?php } ?>
                <?php if($weight != ''){ ?>
                <li>
                            <select name="weight" id="weight" class="field text addr tbox" style="width:100px;" tabindex="7" onchange="cal_bmi();">
                                <option value="0">Weight</option>
                                <? for($i=80;$i<=500;$i++)
                                                                {
                                                                ?>
                                                                        <option value="<?=$i?>" <? if($weight == $i) echo " selected";?>><?=$i?></option>
                                                                <?
                                                                }?>
                            </select>

                            <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
                </li>
                <?php } ?>
                <?php if($bmi != ''){ ?>
                <li>
                                <span style="color:#000000; padding-top:2px;">BMI</span>
                                <input id="bmi" name="bmi" type="text" class="field text addr tbox" value="<?=$bmi?>" tabindex="8" maxlength="255" style="width:50px;" readonly="readonly" />
                </li>
                <?php } ?>
                                <label for="inches">
                                &lt; 18.5 is Underweight
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                18.5 - 24.9 is Normal
                                <br />
                                &nbsp;&nbsp;&nbsp;
                                25 - 29.9 is Overweight
                                <br />
                                &gt; 30 is Obese
                            </label>
                    <label class="desc" id="title0" for="Field0">
                        AIRWAY EVALUATION
                        <br />
                        <span class="form_info">Tongue</span>
                        <br />
                    </label>
                    <div>
                        <span>
                                <?
                                                        $tongue_sql = "select * from dental_tongue where status=1 order by sortby";
                                                        $tongue_my = mysql_query($tongue_sql);

                                                        while($tongue_myarray = mysql_fetch_array($tongue_my))
                                                        {
							if(!strpos($tongue,'~'.st($tongue_myarray['tongueid']).'~') === false){
                                                        ?>
                                                                <input type="checkbox" id="tongue" name="tongue[]" value="<?=st($tongue_myarray['tongueid'])?>" tabindex="9" <? if(strpos($tongue,'~'.st($tongue_myarray['tongueid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($tongue_myarray['tongue']);?><br />
                                                        <?
							}
                                                        }
                                                        ?>
                        </span>
                   </div>

                                        <br />
                <?php if($additional_paragraph != ''){ ?>
                                        <label class="desc" id="title0" for="Field0">
                                                Additional Paragraph
                                        </label>

                                        <div>
                                                <span>
                                                        <textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                                                </span>
                                        </div>
                                        <br />
                <?php } ?>
<?php

$sql = "select * from dental_ex_page2 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page2id = st($myarray['ex_page2id']);
$mallampati = st($myarray['mallampati']);
$tonsils = st($myarray['tonsils']);
$tonsils_grade = st($myarray['tonsils_grade']);

?>
                <?php if($mallampati != ''){ ?>
                    <label class="desc" id="title0" for="Field0">
                        AIRWAY EVALUATION(continued)
                        <br />
                        <span class="form_info">Mallampati Classification</span>
                        <br />
                    </label>

                    <div>
                        <span>
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/class1.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class I" <? if($mallampati == 'Class I') echo " checked";?> /> Class I
                                    </td>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/class2.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class II" <? if($mallampati == 'Class II') echo " checked";?> /> Class II
                                    </td>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/class3.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class III" <? if($mallampati == 'Class III') echo " checked";?> /> Class III
                                    </td>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/class4.jpg" height="201" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="mallampati" value="Class IV" <? if($mallampati == 'Class IV') echo " checked";?> /> Class IV
                                    </td>
                                </tr>
                            </table>
                        </span>
                        </div>
                    <br />
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        TONSILS
                    </label>
                <?php if($tonsils != ''){ ?>
                    <div>
                        <span>
                                <input type="checkbox" id="tonsils" name="tonsils[]" value="Present" <? if(strpos($tonsils,'~Present~') === false) {} else { echo " checked";}?> />
                            Present
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Obstructive" <? if(strpos($tonsils,'~Obstructive~') === false) {} else { echo " checked";}?> />
                            Obstructive
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" id="tonsils" name="tonsils[]" value="Purulent" <? if(strpos($tonsils,'~Purulent~') === false) {} else { echo " checked";}?> />
                            Purulent
                        </span>
                   </div>
                   <br />
                <?php } ?>
                <?php if($tonsils_grade != ''){ ?>
                   <div>
                        <span>
                                <table width="100%" cellpadding="3" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" width="20%" align="center">
                                        <img src="images/grade0.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 0" <? if($tonsils_grade == 'Grade 0') echo " checked";?> /> Grade 0
                                        <br /><br />
                                        Absent
                                    </td>
                                        <td valign="top" width="20%" align="center">
                                        <img src="images/grade1.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 1" <? if($tonsils_grade == 'Grade 1') echo " checked";?> /> Grade 1
                                        <br /><br />
                                        Small within the tonsillar fossa
                                    </td>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/grade2.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 2" <? if($tonsils_grade == 'Grade 2') echo " checked";?> /> Grade 2
                                        <br /><br />
                                        Extends beyond the tonsillar pillar
                                    </td>
                                        <td valign="top" width="25%" align="center">
                                        <img src="images/grade3.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 3" <? if($tonsils_grade == 'Grade 3') echo " checked";?> /> Grade 3
                                        <br /><br />
                                        Hypertrophic but not touching in midline
                                    </td>
                                        <td valign="top" width="20%" align="center">
                                        <img src="images/grade4.png" height="188" width="131" border="0" />
                                        <br />
                                        <input type="radio" name="tonsils_grade" value="Grade 4" <? if($tonsils_grade == 'Grade 4') echo " checked";?> /> Grade 4
                                        <br /><br />
                                        Hypertrophic and touching in midline
                                    </td>
                                </tr>
                            </table>
                        </span>
                        </div>
                    <br />
                <?php } ?>

<?php

$sql = "select * from dental_ex_page3 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page3id = st($myarray['ex_page3id']);
$maxilla = st($myarray['maxilla']);
$other_maxilla = st($myarray['other_maxilla']);
$mandible = st($myarray['mandible']);
$other_mandible = st($myarray['other_mandible']);
$soft_palate = st($myarray['soft_palate']);
$other_soft_palate = st($myarray['other_soft_palate']);
$uvula = st($myarray['uvula']);
$other_uvula = st($myarray['other_uvula']);
$gag_reflex = st($myarray['gag_reflex']);
$other_gag_reflex = st($myarray['other_gag_reflex']);
$nasal_passages = st($myarray['nasal_passages']);
$other_nasal_passages = st($myarray['other_nasal_passages']);

?>
                    <label class="desc" id="title0" for="Field0">
                        <span class="form_info">
                                OTHER AIRWAY ITEMS
                        </span>
                    </label>
                    <label class="desc" id="title0" for="Field0">
                        Maxilla
                    </label>

                    <div class="cb_half">
                        <span>
                                <?
                                                        $maxilla_sql = "select * from dental_maxilla where status=1 order by sortby";
                                                        $maxilla_my = mysql_query($maxilla_sql);

                                                        while($maxilla_myarray = mysql_fetch_array($maxilla_my))
                                                        {
							if(!strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') === false){
                                                        ?>
                                                                <input type="checkbox" id="maxilla" name="maxilla[]" value="<?=st($maxilla_myarray['maxillaid'])?>" <? if(strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($maxilla_myarray['maxilla']);?><br />
                                                        <?
							}
                                                        }
                                                        ?>
                        </span>
                        </div>
                <?php if($other_maxilla != ''){ ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_maxilla" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_maxilla;?></textarea>
                        </span>
                    </div>
                    <br />
                <?php } ?>

                    <label class="desc" id="title0" for="Field0">
                        Mandible
                    </label>

                    <div class="cb_half">
                        <span>
                                <?
                                                        $mandible_sql = "select * from dental_mandible where status=1 order by sortby";
                                                        $mandible_my = mysql_query($mandible_sql);

                                                        while($mandible_myarray = mysql_fetch_array($mandible_my))
                                                        {
							if(!strpos($mandible,'~'.st($mandible_array['mandibleid']).'~') === false ) {
                                                        ?>
                                                                <input type="checkbox" id="mandible" name="mandible[]" value="<?=st($mandible_myarray['mandibleid'])?>" <? if(strpos($mandible,'~'.st($mandible_myarray['mandibleid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($mandible_myarray['mandible']);?><br />
                                                        <?
							}
                                                        }
                                                        ?>
                        </span>
                        </div>
                <?php if($other_mandible != ''){ ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_mandible" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_mandible;?></textarea>
                        </span>
                    </div>
                    <br />
                <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        Soft Palate
                    </label>

                    <div class="cb_half">
                        <span>
                                <?
                                                        $soft_palate_sql = "select * from dental_soft_palate where status=1 order by sortby";
                                                        $soft_palate_my = mysql_query($soft_palate_sql);

                                                        while($soft_palate_myarray = mysql_fetch_array($soft_palate_my))
                                                        {
							if(!strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') === false) {
                                                        ?>
                                                                <input type="checkbox" id="soft_palate" name="soft_palate[]" value="<?=st($soft_palate_myarray['soft_palateid'])?>" <? if(strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($soft_palate_myarray['soft_palate']);?><br />
                                                        <?
							}
                                                        }
                                                        ?>
                        </span>
                        </div>
		<?php if($other_soft_palate != ''){ ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_soft_palate" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_soft_palate;?></textarea>
                        </span>
                    </div>
                    <br />
		<?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        Uvula
                    </label>

                    <div class="cb_half">
                        <span>
                       <?php
                                                        $uvula_sql = "select * from dental_uvula where status=1 order by sortby";
                                                        $uvula_my = mysql_query($uvula_sql);
                                                        //$uvula_prearray = mysql_fetch_array($uvula_my);

                                                        ?>
                      <!--<input type="checkbox" name="uvula[]" id="uvula" onclick="showMe('uvuladiv')" value="1" <?php if(in_array("1", $uvula_prearray)){ echo "checked=\"checked\""; }?> >&nbsp;&nbsp;&nbsp;&nbsp;Not Clinically Present<br />
                      
                      <div id="uvuladiv" <?php if(in_array("1", $uvula_prearray)){ echo "style=\"display:none;\""; }?>> 
                      -->
                                <?

                                                        while($uvula_myarray = mysql_fetch_array($uvula_my))
                                                        {
							if(!strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') === false) {
                                                        ?>
                                                                <input type="checkbox" id="uvula" name="uvula[]" value="<?=st($uvula_myarray['uvulaid'])?>" <? if(strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($uvula_myarray['uvula']);?><br />
                                                        <?
							}
                                                        }
                                                        ?> <!--</div>-->

                        </span>
                        </div>
		<?php if($other_uvula != '') { ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_uvula" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_uvula;?></textarea>
                        </span>
                    </div>
                    <br />
		<? } ?>
                    <label class="desc" id="title0" for="Field0">
                        Gag Reflex
                    </label>

                    <div class="cb_half">
                        <span>
                                <?
                                                        $gag_reflex_sql = "select * from dental_gag_reflex where status=1 order by sortby";
                                                        $gag_reflex_my = mysql_query($gag_reflex_sql);

                                                        while($gag_reflex_myarray = mysql_fetch_array($gag_reflex_my))
                                                        {
							if(!strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') === false) {
                                                        ?>
                                                                <input type="checkbox" id="gag_reflex" name="gag_reflex[]" value="<?=st($gag_reflex_myarray['gag_reflexid'])?>" <? if(strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($gag_reflex_myarray['gag_reflex']);?><br />
                                                        <?
                                                        }
							}
                                                        ?>
                        </span>
                        </div>
		<?php if( $other_gag_reflex != ''){ ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_gag_reflex" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_gag_reflex;?></textarea>
                        </span>
                    </div>
                    <br />
		<?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        Nasal Passages
                    </label>

                    <div class="cb_half">
                        <span>
                                <?
                                                        $nasal_passages_sql = "select * from dental_nasal_passages where status=1 order by sortby";
                                                        $nasal_passages_my = mysql_query($nasal_passages_sql);

                                                        while($nasal_passages_myarray = mysql_fetch_array($nasal_passages_my))
                                                        {
							if(!strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') === false) {
                                                        ?>
                                                                <input type="checkbox" id="nasal_passages" name="nasal_passages[]" value="<?=st($nasal_passages_myarray['nasal_passagesid'])?>" <? if(strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($nasal_passages_myarray['nasal_passages']);?><br />
                                                        <?
                                                        }
							}
                                                        ?>
                        </span>
                        </div>
		<?php if($other_nasal_passages != ''){ ?>
                    <div class="ta_half">
                        <span>
                                <span style="color:#000000; padding-top:0px;">
                                Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_nasal_passages" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_nasal_passages;?></textarea>
                        </span>
                    </div>
                    <br />

		<?php } ?>

<?php

$sql = "select * from dental_ex_page5 where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$ex_page5id = st($myarray['ex_page5id']);
$palpationid = st($myarray['palpationid']);
$palpationRid = st($myarray['palpationRid']);
$additional_paragraph_pal = st($myarray['additional_paragraph_pal']);
$joint_exam = st($myarray['joint_exam']);
$jointid = st($myarray['jointid']);
$i_opening_from = st($myarray['i_opening_from']);
$i_opening_to = st($myarray['i_opening_to']);
$i_opening_equal = st($myarray['i_opening_equal']);
$protrusion_from = st($myarray['protrusion_from']);
$protrusion_to = st($myarray['protrusion_to']);
$protrusion_equal = st($myarray['protrusion_equal']);
$l_lateral_from = st($myarray['l_lateral_from']);
$l_lateral_to = st($myarray['l_lateral_to']);
$l_lateral_equal = st($myarray['l_lateral_equal']);
$r_lateral_from = st($myarray['r_lateral_from']);
$r_lateral_to = st($myarray['r_lateral_to']);
$r_lateral_equal = st($myarray['r_lateral_equal']);
$deviation_from = st($myarray['deviation_from']);
$deviation_to = st($myarray['deviation_to']);
$deviation_equal = st($myarray['deviation_equal']);
$deflection_from = st($myarray['deflection_from']);
$deflection_to = st($myarray['deflection_to']);
$deflection_equal = st($myarray['deflection_equal']);
$range_normal = st($myarray['range_normal']);
$normal = st($myarray['normal']);
$other_range_motion = st($myarray['other_range_motion']);
$additional_paragraph_rm = st($myarray['additional_paragraph_rm']);
$screening_aware = st($myarray['screening_aware']);
$screening_normal = st($myarray['screening_normal']);
$deviation_r_l = st($myarray['deviation_r_l']);
$deflection_r_l = st($myarray['deflection_r_l']);

if($palpationid <> '')
{
        $pal_arr1 = split('~',$palpationid);

        foreach($pal_arr1 as $i => $val)
        {
                $pal_arr2 = explode('|',$val);

                $palid[$i] = $pal_arr2[0];
                $palseq[$i] = $pal_arr2[1];
        }
}

if($palpationRid <> '')
{
        $palR_arr1 = split('~',$palpationRid);

        foreach($palR_arr1 as $i => $val)
        {
                $palR_arr2 = explode('|',$val);

                $palRid[$i] = $palR_arr2[0];
                $palRseq[$i] = $palR_arr2[1];
        }
}

if($jointid <> '')
{
        $jo_arr1 = split('~',$jointid);

        foreach($jo_arr1 as $i => $val)
        {
                $jo_arr2 = explode('|',$val);

                $joid[$i] = $jo_arr2[0];
                $joseq[$i] = $jo_arr2[1];
        }
}

?>

                    <label class="desc" id="title0" for="Field0">
                        Muscles & Manual Palpation
                    </label>
                                        <br />
                    <div align="right" style="text-align:right; float:right;">
                        <span class="ex_p5_0">
                                0 - No Tenderness
                        </span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="ex_p5_1" style="padding-left:10px;">
                            1 - Mild
                        </span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="ex_p5_2"  style="padding-left:10px;">
                            2 - Moderate
                        </span>
                        &nbsp;&nbsp;&nbsp;
                        <span class="ex_p5_3" style="padding-left:10px;" >
                            3 - Severe
                        </span>
        <br />  <button onclick="setDefaults();return false;">Set all to 0</button>

                    </div>

                    <div id="topcb">
                        <span class="full">
                                <table width="80%" cellpadding="3" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" width="20%">
                                        Left
                                    </td>
                                        <td valign="top" width="20%">
                                        Right
                                    </td>
                                        <td valign="top" width="60%">&nbsp;

                                    </td>
                                </tr>

                                <?
                                                                $palpation_sql = "select * from dental_palpation where status=1 order by sortby";
                         
                                                                $palpation_my = mysql_query($palpation_sql);

                                                                while($palpation_myarray = mysql_fetch_array($palpation_my))
                                                                {
                                                                        if(@array_search($palpation_myarray['palpationid'],$palid) === false)
                                                                        {
                                                                                $chk = '';
                                                                        }
                                                                        else
                                                                        {
                                                                                $chk = $palseq[@array_search($palpation_myarray['palpationid'],$palid)];
                                                                        }

                                                                        if(@array_search($palpation_myarray['palpationid'],$palRid) === false)
                                                                        {
                                                                                $chkR = '';
                                                                        }
                                                                        else
                                                                        {
                                                                                $chkR = $palRseq[@array_search($palpation_myarray['palpationid'],$palRid)];
                                                                        }

                                                                ?>
			<?php if($chk != '' || $chkR != ''){ ?>
                                <tr>
                                        <td valign="top">
                                                                                <select id="palpation_<?=st($palpation_myarray['palpationid']);?>" name="palpation_<?=st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
                                                                                        <option value=""></option>
                                                                                        <option value="0" <? if($chk == '0') echo " selected";?> class="ex_p5_0">
                                                                                                0
                                                                                        </option>
                                                                                        <option value="1" <? if($chk == '1') echo " selected";?> class="ex_p5_1">
                                                                                                1
                                                                                        </option>
                                                                                        <option value="2" <? if($chk == '2') echo " selected";?> class="ex_p5_2">
                                                                                                2
                                                                                        </option>
                                                                                        <option value="3" <? if($chk == '3') echo " selected";?> class="ex_p5_3">
                                                                                                3
                                                                                        </option>

                                                                                </select>
                                     </td>
                                     <td valign="top">
                                        <select id="palpationR_<?=st($palpation_myarray['palpationid']);?>" name="palpationR_<?=st($palpation_myarray['palpationid']);?>" class="field text addr tbox" style="width:50px;">
                                                                                        <option value=""></option>
                                                                                        <option value="0" <? if($chkR == '0') echo " selected";?> class="ex_p5_0">
                                                                                                0
                                                                                        </option>
                                                                                        <option value="1" <? if($chkR == '1') echo " selected";?> class="ex_p5_1">
                                                                                                1
                                                                                        </option>
                                                                                        <option value="2" <? if($chkR == '2') echo " selected";?> class="ex_p5_2">
                                                                                                2
                                                                                        </option>
                                                                                        <option value="3" <? if($chkR == '3') echo " selected";?> class="ex_p5_3">
                                                                                                3
                                                                                        </option>

                                                                                </select>
                                     </td>
                                     <td valign="top">
                                        <span>
                                                                                <?=st($palpation_myarray['palpation']);?>
                                        </span>
                                     </td>
                                  </tr>
                                                                <?
						}
                                                                }?>
                                <tr>
                                        <td valign="top" colspan="3" align="right">
                                    </td>
                                </tr>
                            </table>
                        </span>
                        </div>
                    <br />
                        <?php if($additional_paragraph_pal != ''){ ?>
                    <label class="desc" id="title0" for="Field0">
                        Additional Paragraph
                    </label>

                    <div>
                        <span>
                                <textarea name="additional_paragraph_pal" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_pal;?></textarea>
                        </span>
                    </div>
                    <br />
                        <?php } ?>
                    <label class="desc" id="title0" for="Field0">
                        Joint Sounds
                    </label>

                    <div>
                        <span >
                                Examination Type:
                        </span>
                        </div>

                    <div>
                        <span class="full">
                                <table width="100%" cellpadding="3" cellspacing="1" >
                                <tr>
                                        <td valign="top" width="40%"><span>
                                        <?
                                                                                $joint_exam_sql = "select * from dental_joint_exam where status=1 order by sortby";
                                                                                $joint_exam_my = mysql_query($joint_exam_sql);

                                                                                while($joint_exam_myarray = mysql_fetch_array($joint_exam_my))
                                                                                {
										if(!strpos($joint_exam,'~'.st($joint_exam_myarray['joint_examid']).'~') === false) {
                                                                                ?>
                                                                                        <input type="checkbox" id="joint_exam" name="joint_exam[]" value="<?=st($joint_exam_myarray['joint_examid'])?>" <? if(strpos($joint_exam,'~'.st($joint_exam_myarray['joint_examid']).'~') === false) {} else { echo " checked";}?> style="width:10px;" />
                                                                                        &nbsp;&nbsp;
                                                                                        <?=st($joint_exam_myarray['joint_exam']);?><br />
                                                                                <?
										}
                                                                                }
                                                                                ?></span>
                                    </td>
                                    <td valign="top">
                                        <table width="100%" cellpadding="3" cellspacing="1">                                            <?
                                                                                        $joint_sql = "select * from dental_joint where status=1 order by sortby";
                                                                                        $joint_my = mysql_query($joint_sql);

                                                                                        while($joint_myarray = mysql_fetch_array($joint_my))
                                                                                        {
                                                                                                if(@array_search($joint_myarray['jointid'],$joid) === false)
                                                                                                {
                                                                                                        $chkJ = '';
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                        $chkJ = $joseq[@array_search($joint_myarray['jointid'],$joid)];
                                                                                                }
                                                                                        ?>
						<?php if($chkJ != ''){ ?>
                                                <tr>
                                                        <td valign="top" width="40%"> <span>
                                                                                                                <?=st($joint_myarray['joint']);?></span>
                                                    </td>
                                                    <td valign="top">
                                                        <select id="joint_<?=st($joint_myarray['jointid']);?>" name="joint_<?=st($joint_myarray['jointid']);?>" class="field text addr tbox" style="width:50px;">
                                                            <option value=""></option>
                                                            <option value="L" <? if($chkJ == 'L') echo " selected";?> >
                                                                L
                                                            </option>
                                                            <option value="R" <? if($chkJ == 'R') echo " selected";?>>
                                                                R
                                                            </option>
                                                            <option value="B" <? if($chkJ == 'B') echo " selected";?>>
                                                                B
                                                            </option>
                                                        </select>
                                                                                                        </td>
                                                                                                </tr>
                                                                                        <?
											}
                                                                                        }
                                                                                        ?>
                                        </table>

                                    </td>
                                </tr>
                            </table>

                        </span>
                    </div>





                    <label class="desc" id="title0" for="Field0">
                        Range Of Motion
                    </label>

                    <div>
                        <span >
                                <table width="100%" cellpadding="3" cellspacing="1">
			<?php if($i_opening_from != '') { ?>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Interincisal Opening
                                        </span>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" name="i_opening_from" class="field text addr tbox" style="width:50px;" value="<?=$i_opening_from;?>">
                                        </span>
                                    </td>
                                </tr>

                               <script type="text/javascript">
                                  function updateProtrusion(){
                                        pval = Math.abs($('#protrusion_to').val() - $('#protrusion_from').val());
                                        $('#protrusion_equal').val(pval);

                                  }
                               </script>
			                        <?php } ?>
                        <?php if($protrusion_from != '' || $protrusion_to != '') { ?>
                               <tr>
                                    <td valign="top">
                                    <span>George Scale</span>
                                    </td>
                                        <td valign="top">
                                        <input type="text" id="protrusion_from" name="protrusion_from" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?=$protrusion_from;?>">
                                        &nbsp;&nbsp;&nbsp;
                                        to
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="text" id="protrusion_to" name="protrusion_to" onkeyup="updateProtrusion();" class="field text addr tbox" style="width:50px;" value="<?=$protrusion_to;?>">

                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Protrusion (Automatically calculated from George Gauge above)
                                        </span>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" id="protrusion_equal" name="protrusion_equal" class="field text addr tbox" style="width:50px;" value="<?php echo abs($protrusion_to-($protrusion_from));?>">                                     </td>
                                </tr>
                        <?php } ?>
                        <?php if($l_lateral_from != '') { ?>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Left Lateral Excursion
                                        </span>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" name="l_lateral_from" class="field text addr tbox" style="width:50px;" value="<?=$l_lateral_from;?>">
                                        </span>
                                    </td>
                                </tr>
                        <?php } ?>
                        <?php if($r_lateral_from != '') { ?>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Right Lateral Excursion
                                        </span>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" name="r_lateral_from" class="field text addr tbox" style="width:50px;" value="<?=$r_lateral_from;?>">
                                        </span>
                                    </td>
                                </tr>
                        <?php } ?>
                        <?php if($deviation_r_l != '') { ?>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Deviation
                                        </span>
                                                                                &nbsp;&nbsp;
                                                                                <select id="deviation_r_l" name="deviation_r_l" class="field text addr tbox" style="width:60px;">
                                                                                        <option value=""></option>
                                                                                        <option value="Right" <? if($deviation_r_l == 'Right') echo " selected";?> >
                                                                                                Right
                                                                                        </option>
                                                                                        <option value="Left" <? if($deviation_r_l == 'Left') echo " selected";?>>
                                                                                                Left
                                                                                        </option>
                                                                                </select>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" name="deviation_from" class="field text addr tbox" style="width:50px;" value="<?=$deviation_from;?>">
                                        </span>
                                    </td>
                                </tr>
                        <?php } ?>
                        <?php if($deflection_r_l != '') { ?>
                                <tr>
                                        <td valign="top">
                                        <span>
                                        Deflection
                                        </span>
                                                                                &nbsp;
                                                                                <select id="deflection_r_l" name="deflection_r_l" class="field text addr tbox" style="width:60px;">
                                                                                        <option value=""></option>
                                                                                        <option value="Right" <? if($deflection_r_l == 'Right') echo " selected";?> >
                                                                                                Right
                                                                                        </option>
                                                                                        <option value="Left" <? if($deflection_r_l == 'Left') echo " selected";?>>
                                                                                                Left
                                                                                        </option>
                                                                                </select>
                                    </td>
                                    <td valign="top">
                                        <span>
                                        <input type="text" name="deflection_from" class="field text addr tbox" style="width:50px;" value="<?=$deflection_from;?>">
                                        </span>
                                    </td>
                                </tr>
                        <?php } ?>
                            </table>
                            <input type="checkbox" name="range_normal" value="1" <? if($range_normal == 1) echo " checked"; ?>/>
                            Within normal limits

                            <br /><br />

                           NOTE: (Normal range of motion has been noted Vertical 40 - 50mm,  Lateral 12mm, Protrusive 9mm)
                        </span>
                        </div>
                    <br />
                        <?php if($additional_paragraph_rm != '') { ?>
                    <label class="desc" id="title0" for="Field0">
                        Additional Paragraph
                        /
                        <button onclick="Javascript: loadPopupRefer('select_custom_all.php?fr=ex_page5frm&tx=additional_paragraph_rm'); return false;">Custom Text</button>
                    </label>

                    <div>
                        <span>
                                <textarea name="additional_paragraph_rm" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph_rm;?></textarea>
                        </span>
                    </div>
                    <br />
                        <?php } ?>

                    <label class="desc" id="title0" for="Field0">
                        Craniomandibular Screening
                    </label>

                    <div>
                        <span>
                                <input type="checkbox" name="screening_aware" value="1" <? if($screening_aware == 1) echo " checked"; ?>/>
                            Patient is aware of a temporomandibular disorder

                                <br /><br>
                                <input type="checkbox" name="screening_normal" value="1" <? if($screening_normal == 1) echo " checked"; ?>/>
                            Within normal limits
                        </span>
                        </div>
                    <br />

