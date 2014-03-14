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

<div class="row">
    <div class="col-md-6">
        <h4>Medications / Allergies</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <?php if ($premeddet != '') { ?>
                    <p>
                <?php } ?>
                
                <strong>Premedication:</strong>
                <?= ($premedcheck)?"Yes":"No";?>
                
                <?php if ($premeddet != '') { ?>
                    </p>
                    <p>
                        <span id="pm_det" <?php if($premedcheck == 0 && (!$showEdits || $premedcheck==$dpp_row['premedcheck'])){ echo 'style="display:none;"';} ?>>
                            <?=$premeddet;?>
                        </span>
                    </p>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <?php if ($other_allergens != '') { ?>
                    <p>
                <?php } ?>
                
                <strong>Allergens:</strong>
                <?= ($allergenscheck)?"Yes":"No"; ?>
                
                <?php if ($other_allergens != '') { ?>
                    </p>
                    <p>
                        <span id="a_det" <?php if($allergenscheck == 0 && (!$showEdits || $allergenscheck==$dpp_row['allergenscheck'])){ echo 'style="display:none;"';} ?>>
                            <?=$other_allergens;?>
                        </span>
                    </p>
                <?php } ?>
            </li>
            <li class="list-group-item">
                <?php if ($other_medications != '') { ?>
                    <p>
                <?php } ?>
                
                <strong>Current Medications:</strong>
                <?= ($medicationscheck)?"Yes":"No"; ?>
                
                <?php if ($other_medications != '') { ?>
                    </p>
                    <p>
                        <span id="m_det" <?php if($medicationscheck == 0 && (!$showEdits || $medicationscheck==$dpp_row['medicationscheck'])){ echo 'style="display:none;"';} ?>>
                            <?=$other_medications;?>
                        </span>
                    </p>
                <?php } ?>
            </li>
        </ul>
        
        <h4>Health History</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <p>
                    <strong>Medical History</strong>
                </p>
                <p><?= $other_history ?></p>
            </li>
        </ul>
    </div>
    
    <div class="col-md-6">
        <h4>Social History</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Have genetic members of your family had Heart Disease?:</strong>
                <?= $family_hd == 'Yes' ? 'Yes' : 'No' ?>
            </li>
            <li class="list-group-item">
                <strong>High blood pressure?:</strong>
                <?= $family_bp == 'Yes' ? 'Yes' : 'No' ?>
            </li>
            <li class="list-group-item">
                <strong>Diabetes?:</strong>
                <?= $family_dia == 'Yes' ? 'Yes' : 'No' ?>
            </li>
            <li class="list-group-item">
                <strong>Have any genetic members of your family been diagnosed or treated for a sleep disorder?:</strong>
                <?= $family_sd == 'Yes' ? 'Yes' : 'No' ?>
            </li>
        </ul>
        
        <h4>Family History</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>How often do you consume alcohol within 2-3 hours of bedtime?:</strong>
                <?= $alcohol ?>
            </li>
            <li class="list-group-item">
                <strong>How often do you take sedatives within 2-3 hours of bedtime?:</strong>
                <?= $sedative ?>
            </li>
            <li class="list-group-item">
                <strong>How often do you consume caffeine within 2-3 hours of bedtime?:</strong>
                <?= $caffeine ?>
            </li>
            <li class="list-group-item">
                <strong>Do you smoke?:</strong>
                <?= $smoke == 'Yes' ? 'Yes' : 'No' ?>
            </li>
            <?php if ($smoke == 'Yes') { ?>
                <li class="list-group-item">
                    <strong>Number of packs per day:</strong>
                    <?= intval($smoke_packs) ?>
                </li>
            <?php } ?>
            <li class="list-group-item">
                <strong>Do you use chewing tobacco?:</strong>
                <?= $tobacco == 'Yes' ? 'Yes' : 'No' ?>
            </li>
            <?php if ($additional_paragraph) { ?>
                <li class="list-group-item">
                    <p>
                        <strong>Additional details</strong>
                    </p>
                    <p>
                        <textarea name="additional_paragraph" class="field text addr tbox form-control" rows="3"><?=$additional_paragraph;?></textarea>
                    </p>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<h4>Dental History</h4>
<table class="table table-bordered">
    <?php if ($dental_health != '') { ?>
        <tr>
            <th>
                How would you describe your dental health?:</strong>
            </td>
            <td colspan="2">
                <?= $dental_health;?>
            </td>
        </tr>
    <?php } ?>
    
    <?php if ($wisdom_extraction == 'Yes' || $wisdom_extraction_text != '') { ?>
        <tr>
            <th>
                Have you ever had teeth extracted?:
            </th>
            <td>
                <?= $wisdom_extraction;?>
            </td>
            <td>Please describe: <?= $wisdom_extraction_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($removable == 'Yes' || $removable_text != '') { ?>
        <tr>
            <th>
                Do you wear removable partials?:
            </th>
            <td>
                <?= $removable;?>
            </td>
            <td>Please describe: <?= $removable_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($dentures == 'Yes' || $dentures_text != '') { ?>
        <tr>
            <th>
                Do you wear dentures?:
            </th>
            <td>
                <?= $dentures; ?>
            </td>
            <td>Please describe: <?= $dentures_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($orthodontics == 'Yes' || $year_completed != '') { ?>
        <tr>
            <th>
                Have you worn orthodontics (braces)?:
            </th>
            <td>
                <?= $orthodontics;?>
            </td>
            <td>Year completed: <?=$year_completed;?></td>
        </tr>
    <?php } ?>
    
    <?php if ($tmj_cp == 'Yes' || $tmj_cp_text != '') { ?>
        <tr>
            <th>
                Does your TMJ (jaw joint) click or pop?:
            </th>
            <td>
                <?= $tmj_cp;?>
            </td>
            <td>Please describe: <?= $tmj_cp_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($tmj_pain == 'Yes' || $tmj_pain_text != '') { ?>
        <tr>
            <th>
                Do you have pain in this joint?:
            </th>
            <td>
                <?= $tmj_pain;?>
            </td>
            <td>Please describe: <?= $tmj_pain_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($tmj_surgery == 'Yes' || $tmj_surgery_text != '') { ?>
        <tr>
            <th>
                Have you had TMJ (jaw joint) surgery?:
            </th>
            <td>
                <?= $tmj_surgery;?>
            </td>
            <td>Please describe: <?= $tmj_surgery_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($gum_prob == 'Yes' || $gum_prob_text != '') { ?>
        <tr>
            <th>
                Have you ever had gum problems?:
            </th>
            <td>
                <?= $gum_prob;?>
            </td>
            <td>Please describe: <?= $gum_prob_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($gum_surgery == 'Yes' || $gum_surgery_text != '') { ?>
        <tr>
            <th>
                Have you ever had gum surgery?:
            </th>
            <td>
                <?= $gum_surgery; ?>
            </td>
            <td>Please describe: <?= $gum_surgery_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($drymouth == 'Yes' || $drymouth_text != '') { ?>
        <tr>
            <th>
                Do you have morning dry mouth?:
            </th>
            <td>
                <?= $drymouth;?>
            </td>
            <td>Please describe: <?= $drymouth_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($injury == 'Yes' || $injury_text != '') { ?>
        <tr>
            <th>
                Have you ever had injury to your head, face, neck, mouth, or teeth?:
            </th>
            <td>
                <?= $injury; ?>
            </td>
            <td>Please describe: <?= $injury_text; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($completed_future == 'Yes' || $future_dental_det != '') { ?>
        <tr>
            <th>
                Are you planning to have dental work done in the near future?:
            </th>
            <td>
                <?=$completed_future;?>
            </td>
            <td>Please describe: <?= $future_dental_det; ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($clinch_teeth == 'Yes' || $clinch_grind_text != '') { ?>
        <tr>
            <th>
                Do you clinch or grind your teeth?:
            </th>
            <td>
                <?= $clinch_grind; ?>
            </td>
            <td>Please describe: <?= $clinch_grind_text; ?></td>
        </tr>
    <?php } ?>
</table>

<div class="row">
    <div class="col-md-6">
        <h4>Dental Screening</h4>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Missing Tooth #:</strong>
                <?= $missing ?>
                <button class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#perio-chart">
                    Perio Chart
                    <span class="glyphicon glyphicon-th"></span>
                </button>
                <div id="perio-chart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="perio-chart" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Perio Chart</h4>
                            </div>
                            <iframe src="/manage/missing_teeth_form.php?pid=<?=$_GET['pid']?>&mt=<?= $missing ?>" width="100%" height="840" border="0"></iframe>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <h4>Examination of Teeth Revealed</h4>
        <ul class="list-group">
            <?
            
            $exam_teeth_sql = "select * from dental_exam_teeth where status=1 order by sortby";
            $exam_teeth_my = mysql_query($exam_teeth_sql);
            
            while ($exam_teeth_myarray = mysql_fetch_array($exam_teeth_my)) {
                if (!strpos($exam_teeth,'~'.st($exam_teeth_myarray['exam_teethid']).'~') === false) { ?>
                    <li class="list-group-item">
                        <?=st($exam_teeth_myarray['exam_teeth']);?>
                    </li>
                <? }
            } ?>
            
            <?php if ($other_exam_teeth) { ?>
                <li class="list-group-item">
                    <strong>Other Items: </strong>
                    <?= $other_exam_teeth ?>
                </li>
            <?php } ?>
            
            <?php if ($caries) { ?>
                <li class="list-group-item">
                    <strong>Caries Tooth #: </strong>
                    <?= $caries ?>
                </li>
            <?php } ?>
            
            <?php if ($where_facets) { ?>
                <li class="list-group-item">
                    <strong>Wear Facets Tooth #: </strong>
                    <?= $where_facets ?>
                </li>
            <?php } ?>
            
            <?php if ($cracked_fractured) { ?>
                <li class="list-group-item">
                    <strong>Cracked or Fractured Tooth #: </strong>
                    <?= $cracked_fractured ?>
                </li>
            <?php } ?>
            
            <?php if ($old_worn_inadequate_restorations) { ?>
                <li class="list-group-item">
                    <strong>Old, Worn or Inadequate Restorations Tooth #: </strong>
                    <?= $old_worn_inadequate_restorations ?>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<?php if ($dental_class_right != "" || $dental_division_right != "" || $dental_class_left != "" || $dental_division_left != "") { ?>
    <h4>Dental Relationship</h4>
    
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <tr>
                    <th colspan="2" class="text-center">
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
                        <?= $dental_class_left;?>
                    </td>
                    <td valign="top">
                        <?=$dental_division_left;?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table table-bordered table-hover">
                <tr>
                    <th colspan="2" class="text-center">Right</th>
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
                        <?= $dental_class_right;?>
                    </td>
                    <td valign="top">
                        <?= $dental_division_right;?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>

<div class="box">
    <?php if ($additional_paragraph != '') { ?>
        <h4>Other Items:</h4>
        
        <div>
            <span>
                <?=$additional_paragraph;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <h4>Tooth Contact prior to Oral Appliance</h4>
    
    <?php if ($crossbite != '') { ?>
        <div>
            <span>
                <label class="exam_label">Teeth in Crossbite</label>
                <?=$crossbite;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <?php if ($initial_tooth != '') { ?>
        <div>
            <span>
                <label class="exam_label">The initial tooth contact was between</label>
                <?=$initial_tooth;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <?php if ($open_proximal != '') { ?>
        <div>
            <span>
                <label class="exam_label">Open proximal contact(s) present between teeth numbers</label>
                <?=$open_proximal;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <?php if ($deistema != '') { ?>
        <div>
            <span>
                <label class="exam_label">Diastema(s) present between teeth numbers</label>
                <?=$deistema;?>
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
    
    $bmi_sql = "select * from dental_patients where patientid='".$_GET['pid']."'";
    $bmi_my = mysql_query($bmi_sql);
    $bmi_myarray = mysql_fetch_array($bmi_my);
    $bmi = st($bmi_myarray['bmi']);
    $feet = st($bmi_myarray['feet']);
    $inches = st($bmi_myarray['inches']);
    $weight = st($bmi_myarray['weight']);
    
    ?>
    
    <h4>Vital Data</h4>
    
    <?php if ($blood_pressure != '') { ?>
        <div>
            <span>
                Blood Pressure
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;
                <?=$blood_pressure;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <?php if ($pulse != '') { ?>
        <div>
            <span>
                Pulse
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;
                <?= $pulse;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <?php if ($neck_measurement != '') { ?>
        <div>
            <span>
                Neck Measurement
                &nbsp;&nbsp;&nbsp;
                <?= $neck_measurement;?> inches
            </span>
        </div>
        <br />
    <?php } ?>
    
    <h4>Height/Weight</h4>
    
    <?php if ($feet != '') { ?>
        <?= $feet;?>
        <label for="feet">Feet</label>
    <?php } ?>
    
    <?php if ($inches != '') { ?>
        <?= $inches;?>
        <label for="inches">Inches</label>
    <?php } ?>
    
    <?php if ($weight != '') { ?>
        <?= $weight;?>
        <label for="inches">Weight in Pounds&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <?php } ?>
    
    <?php if ($bmi != '') { ?>
        <span style="color:#000000; padding-top:2px;">BMI</span>
        <?=$bmi?>
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
    <?php } ?>
    
    <?php if ($tongue != "" || $additional_paragraph!= "") { ?>
        <h4>Airway Evaluation
            <br />
            
            <?php if ($tongue != "") { ?>
                <span class="form_info">Tongue</span>
                <br />
            <?php } ?></h4>
        
        <?php if ($tongue != "") { ?>
            <div>
                <span>
                    <?
                    
                    $tongue_sql = "select * from dental_tongue where status=1 order by sortby";
                    $tongue_my = mysql_query($tongue_sql);
                    
                    while ($tongue_myarray = mysql_fetch_array($tongue_my)) {
                        if (strpos($tongue,'~'.st($tongue_myarray['tongueid']).'~') !== false) { ?>
                            <?=st($tongue_myarray['tongue']);?><br />
                        <? }
                    } ?>
                </span>
            </div>
            <br />
        <?php } ?>
        
        <?php if ($additional_paragraph != '') { ?>
            <h4>Additional Paragraph</h4>
            <div>
                <span>
                    <?=$additional_paragraph;?>
                </span>
            </div>
            <br />
        <?php } ?>
    <?php }
    
    $sql = "select * from dental_ex_page2 where patientid='".$_GET['pid']."'";
    $my = mysql_query($sql);
    $myarray = mysql_fetch_array($my);
    
    $ex_page2id = st($myarray['ex_page2id']);
    $mallampati = st($myarray['mallampati']);
    $tonsils = st($myarray['tonsils']);
    $tonsils_grade = st($myarray['tonsils_grade']);
    
    ?>
    
    <div class="row">
        <div class="col-md-6">
            <?php if ($mallampati != '') { ?>
                <h4>Airway Evaluation (continued)
                    <br />
                    <span class="form_info">Mallampati Classification</span>
                    <br /></h4>
                
                <table class="table table-bordered table-hover">
                    <tr>
                        <? if ($mallampati == 'Class I') { ?>
                            <td valign="top" width="25%" align="center">
                                <img src="images/class1.jpg" height="201" width="131" border="0" />
                                <br />
                                Class I
                            </td>
                        <? } else if ($mallampati == 'Class II') { ?>
                            <td valign="top" width="25%" align="center">
                                <img src="images/class2.jpg" height="201" width="131" border="0" />
                                <br />
                                Class II
                            </td>
                        <? } else if ($mallampati == 'Class III') { ?>
                            <td valign="top" width="25%" align="center">
                                <img src="images/class3.jpg" height="201" width="131" border="0" />
                                <br />
                                Class III
                            </td>
                        <? } else if ($mallampati == 'Class IV') { ?>
                            <td valign="top" width="25%" align="center">
                                <img src="images/class4.jpg" height="201" width="131" border="0" />
                                <br />
                                Class IV
                            </td>
                        <? } ?>
                    </tr>
                </table>
            <?php } ?>
        </div>
        <div class="col-md-6">
            <h4>Tonsils</h4>
            
            <?php if ($tonsils != '') { ?>
                <div>
                    <span>
                        <? if (strpos($tonsils,'~Present~') !== false) { ?>
                            Present
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <? } ?>
                        
                        <? if (strpos($tonsils,'~Obstructive~') !== false) { ?> 
                            Obstructive
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <? } ?>
                        
                        <? if (strpos($tonsils,'~Purulent~') !== false) { ?>
                            Purulent
                        <? } ?>
                    </span>
                </div>
                <br />
            <?php } ?>
            
            <?php if ($tonsils_grade != '') { ?>
                <div>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <? if ($tonsils_grade == 'Grade 0') { ?>
                                <td valign="top" width="20%" align="center">
                                    <img src="images/grade0.png" height="188" width="131" border="0" />
                                    <br />
                                    Grade 0
                                    <br /><br />
                                    Absent
                                </td>
                            <? } else if ($tonsils_grade == 'Grade 1') { ?>
                                <td valign="top" width="20%" align="center">
                                    <img src="images/grade1.png" height="188" width="131" border="0" />
                                    <br />
                                    Grade 1
                                    <br /><br />
                                    Small within the tonsillar fossa
                                </td>
                            <? } else if ($tonsils_grade == 'Grade 2') { ?>
                                <td valign="top" width="25%" align="center">
                                    <img src="images/grade2.png" height="188" width="131" border="0" />
                                    <br />
                                    Grade 2
                                    <br /><br />
                                    Extends beyond the tonsillar pillar
                                </td>
                            <? } else if ($tonsils_grade == 'Grade 3') { ?>
                                <td valign="top" width="25%" align="center">
                                    <img src="images/grade3.png" height="188" width="131" border="0" />
                                    <br />
                                    Grade 3
                                    <br /><br />
                                    Hypertrophic but not touching in midline
                                </td>
                            <? } else if ($tonsils_grade == 'Grade 4') { ?>
                                <td valign="top" width="20%" align="center">
                                    <img src="images/grade4.png" height="188" width="131" border="0" />
                                    <br />
                                    Grade 4
                                    <br /><br />
                                    Hypertrophic and touching in midline
                                </td>
                            <? } ?>
                        </tr>
                    </table>
                </div>
                <br />
            <?php } ?>
        </div>
    </div>
    
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
    <h4><span class="form_info">
            Other Airway Items
        </span></h4>
    
    <?php if ($maxilla != "" || $other_maxilla !="") { ?>
        <h4>Maxilla</h4>
        
        <div>
            <span>
                <?
                
                $maxilla_sql = "select * from dental_maxilla where status=1 order by sortby";
                $maxilla_my = mysql_query($maxilla_sql);
                
                while ($maxilla_myarray = mysql_fetch_array($maxilla_my)) {
                    if (strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') !== false) { ?>
                        <?=st($maxilla_myarray['maxilla']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ($other_maxilla != '') { ?>
            <div class="ta_half">
                <span>
                    <?=$other_maxilla;?>
                </span>
            </div>
            <br />
        <?php } ?>
    <?php } ?>
    
    <?php if ($mandible!='' || $other_mandible !='') { ?>
        <h4>Mandible</h4>
        
        <div>
            <span>
                <?
                
                $mandible_sql = "select * from dental_mandible where status=1 order by sortby";
                $mandible_my = mysql_query($mandible_sql);
                
                while ($mandible_myarray = mysql_fetch_array($mandible_my)) {
                    if (strpos($mandible,'~'.st($mandible_myarray['mandibleid']).'~') !== false ) { ?>
                        &nbsp;&nbsp;
                        <?=st($mandible_myarray['mandible']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ($other_mandible != '') { ?>
            <div class="ta_half">
                <span>
                    <?=$other_mandible;?>
                </span>
            </div>
            <br />
        <?php } ?>
    <?php } ?>
    
    <?php if ($soft_palate!='' || $other_soft_palate!='') { ?>
        <h4>Soft Palate</h4>
        
        <div>
            <span>
                <?
                
                $soft_palate_sql = "select * from dental_soft_palate where status=1 order by sortby";
                $soft_palate_my = mysql_query($soft_palate_sql);
                
                while ($soft_palate_myarray = mysql_fetch_array($soft_palate_my)) {
                    if (strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') !== false) { ?>
                        <?=st($soft_palate_myarray['soft_palate']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ($other_soft_palate != '') { ?>
            <div>
                <span>
                    <?=$other_soft_palate;?>
                </span>
            </div>
            <br />
        <?php } ?>
    <?php } ?>
    
    
    <?php if ($uvula!='' || $other_uvula!='') { ?>
        <h4>Uvula</h4>

        <div>
            <span>
                <?php
                
                $uvula_sql = "select * from dental_uvula where status=1 order by sortby";
                $uvula_my = mysql_query($uvula_sql);
                
                while ($uvula_myarray = mysql_fetch_array($uvula_my)) {
                    if (strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') !== false) { ?>
                        <?=st($uvula_myarray['uvula']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ($other_uvula != '') { ?>
            <div>
                <span>
                    <?=$other_uvula;?>
                </span>
            </div>
            <br />
        <? } ?>
    <? } ?>
    
    <?php if ($gag_reflex!='' || $other_gag_reflex!='') { ?>
        <h4>Gag Reflex</h4>
        
        <div>
            <span>
                <?
                
                $gag_reflex_sql = "select * from dental_gag_reflex where status=1 order by sortby";
                $gag_reflex_my = mysql_query($gag_reflex_sql);
                
                while ($gag_reflex_myarray = mysql_fetch_array($gag_reflex_my)) {
                    if (strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') !== false) { ?>
                        <?=st($gag_reflex_myarray['gag_reflex']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ( $other_gag_reflex != '') { ?>
            <div class="ta_half">
                <span>
                    <?=$other_gag_reflex;?>
                </span>
            </div>
            <br />
        <?php } ?>
    <?php } ?>
    
    <?php if ($nasal_passages!=''||$other_nasal_passages!='') { ?>
        <h4>Nasal Passages</h4>
        
        <div class="cb_half">
            <span>
                <?
                
                $nasal_passages_sql = "select * from dental_nasal_passages where status=1 order by sortby";
                $nasal_passages_my = mysql_query($nasal_passages_sql);
                
                while ($nasal_passages_myarray = mysql_fetch_array($nasal_passages_my)) {
                    if (strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') !== false) { ?>
                        <?=st($nasal_passages_myarray['nasal_passages']);?><br />
                    <? }
                } ?>
            </span>
        </div>
        
        <?php if ($other_nasal_passages != '') { ?>
            <div class="ta_half">
                <span>
                    <?=$other_nasal_passages;?>
                </span>
            </div>
            <br />
        <?php } ?>
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
    
    if ($palpationid <> '') {
        $pal_arr1 = split('~',$palpationid);
        
        foreach ($pal_arr1 as $i => $val) {
            $pal_arr2 = explode('|',$val);
            $palid[$i] = $pal_arr2[0];
            $palseq[$i] = $pal_arr2[1];
        }
    }
    
    if ($palpationRid <> '') {
        $palR_arr1 = split('~',$palpationRid);
        
        foreach ($palR_arr1 as $i => $val) {
            $palR_arr2 = explode('|',$val);
            $palRid[$i] = $palR_arr2[0];
            $palRseq[$i] = $palR_arr2[1];
        }
    }
    
    if ($jointid <> '') {
        $jo_arr1 = split('~',$jointid);
        
        foreach ($jo_arr1 as $i => $val) {
            $jo_arr2 = explode('|',$val);
            $joid[$i] = $jo_arr2[0];
            $joseq[$i] = $jo_arr2[1];
        }
    }
    
    ?>
    
    <h4>Muscles & Manual Palpation</h4>
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
    </div>
    
    <div id="topcb">
        <table class="table table-bordered table-hover">
            <tr>
                <th valign="top" width="20%">
                    Left
                </th>
                <th valign="top" width="20%">
                    Right
                </th>
                <th valign="top" width="60%">&nbsp;</th>
            </tr>
            <?
            
            $palpation_sql = "select * from dental_palpation where status=1 order by sortby";
            $palpation_my = mysql_query($palpation_sql);
            
            while ($palpation_myarray = mysql_fetch_array($palpation_my)) {
                if (@array_search($palpation_myarray['palpationid'],$palid) === false) {
                    $chk = '';
                }
                else {
                    $chk = $palseq[@array_search($palpation_myarray['palpationid'],$palid)];
                }
                
                if (@array_search($palpation_myarray['palpationid'],$palRid) === false) {
                    $chkR = '';
                }
                else {
                    $chkR = $palRseq[@array_search($palpation_myarray['palpationid'],$palRid)];
                }
                
                if ($chk != '' || $chkR != '') { ?>
                    <tr>
                        <td valign="top">
                            <?= $chk; ?>
                        </td>
                        <td valign="top">
                            <?= $chkR;?>
                        </td>
                        <td valign="top">
                            <span>
                                <?=st($palpation_myarray['palpation']);?>
                            </span>
                        </td>
                    </tr>
                <? }
            } ?>
            <tr>
                <td valign="top" colspan="3" align="right"></td>
            </tr>
        </table>
    </div>
    <br />
    
    <?php if ($additional_paragraph_pal != '') { ?>
        <h4>Additional Paragraph</h4>
        <div>
            <span>
                <?=$additional_paragraph_pal;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <h4>Joint Sounds</h4>
    <div>
        <span >
            Examination Type:
        </span>
    </div>
    <div>
        <table class="table table-bordered table-hover">
            <tr>
                <td valign="top" width="40%">
                    <span>
                        <?
                        
                        $joint_exam_sql = "select * from dental_joint_exam where status=1 order by sortby";
                        $joint_exam_my = mysql_query($joint_exam_sql);
                        
                        while ($joint_exam_myarray = mysql_fetch_array($joint_exam_my)) {
                            if (strpos($joint_exam,'~'.st($joint_exam_myarray['joint_examid']).'~') !== false) { ?>
                                <?=st($joint_exam_myarray['joint_exam']);?><br />
                            <? }
                        } ?>
                    </span>
                </td>
                <td valign="top">
                    <table width="100%" cellpadding="3" cellspacing="1">
                        <?
                        
                        $joint_sql = "select * from dental_joint where status=1 order by sortby";
                        $joint_my = mysql_query($joint_sql);
                        
                        while ($joint_myarray = mysql_fetch_array($joint_my)) {
                            if (@array_search($joint_myarray['jointid'],$joid) === false) {
                                $chkJ = '';
                            }
                            else {
                                $chkJ = $joseq[@array_search($joint_myarray['jointid'],$joid)];
                            }
                            
                            if ($chkJ != '') { ?>
                                <tr>
                                    <td valign="top" width="40%">
                                        <span>
                                            <?=st($joint_myarray['joint']);?>
                                        </span>
                                    </td>
                                    <td valign="top">
                                        <?= $chkJ;?> 
                                    </td>
                                </tr>
                            <? }
                        } ?>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <h4>Range Of Motion</h4>
    <div>
        <table class="table table-bordered table-hover">
            <?php if ($i_opening_from != '') { ?>
                <tr>
                    <td valign="top">
                        <span>
                            Interincisal Opening
                        </span>
                    </td>
                    <td valign="top">
                        <span>
                            <?=$i_opening_from;?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if ($protrusion_from != '' || $protrusion_to != '') { ?>
                <tr>
                    <td valign="top">
                        <span>George Scale</span>
                    </td>
                    <td valign="top">
                        <?=$protrusion_from;?>
                        &nbsp;&nbsp;&nbsp;
                        to
                        &nbsp;&nbsp;&nbsp;
                        <?=$protrusion_to;?>
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
                            <?php echo abs($protrusion_to-($protrusion_from));?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if ($l_lateral_from != '') { ?>
                <tr>
                    <td valign="top">
                        <span>
                            Left Lateral Excursion
                        </span>
                    </td>
                    <td valign="top">
                        <span>
                            <?=$l_lateral_from;?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if ($r_lateral_from != '') { ?>
                <tr>
                    <td valign="top">
                        <span>
                            Right Lateral Excursion
                        </span>
                    </td>
                    <td valign="top">
                        <span>
                        <?=$r_lateral_from;?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if ($deviation_r_l != '') { ?>
                <tr>
                    <td valign="top">
                        <span>
                            Deviation
                        </span>
                        &nbsp;&nbsp;
                        <?= $deviation_r_l;?> 
                    </td>
                    <td valign="top">
                        <span>
                        <?=$deviation_from;?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
            
            <?php if ($deflection_r_l != '') { ?>
                <tr>
                    <td valign="top">
                        <span>
                            Deflection
                        </span>
                        &nbsp;
                        <?= $deflection_r_l;?>
                    </td>
                    <td valign="top">
                        <span>
                        <?=$deflection_from;?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
        </table>
        
        <? if ($range_normal == 1) { ?>
            Within normal limits
            <br /><br />
            NOTE: (Normal range of motion has been noted Vertical 40 - 50mm,  Lateral 12mm, Protrusive 9mm)
        <? } ?>
    </div>
    <br />
    
    <?php if ($additional_paragraph_rm != '') { ?>
        <h4>Additional Paragraph</h4>
        <div>
            <span>
                <?=$additional_paragraph_rm;?>
            </span>
        </div>
        <br />
    <?php } ?>
    
    <h4>Craniomandibular Screening</h4>
    <div>
        <span>
            <? if ($screening_aware == 1) { ?>
                Patient is aware of a temporomandibular disorder
                <br /><br>
            <?php } ?>
            
            <? if ($screening_normal == 1) { ?>
                Within normal limits
            <?php } ?>
        </span>
    </div>
    <br />
</div>
