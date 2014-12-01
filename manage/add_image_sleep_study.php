<?php
include_once('admin/includes/main_include.php');
include("includes/calendarinc.php");
$pat_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."';";
$pat_r = $db->getRow($pat_sql);
?>
<script type="text/javascript" src="script/autocomplete.js"></script>
<script type="text/javascript" src="script/autocomplete_local.js"></script>
<script type="text/javascript" src="js/add_image_sleep_study.js"></script>
<link rel="stylesheet" href="css/add_sleep_study.css" type="text/css" media="screen" />

<table class="sleeplabstable" width="108" align="center" style="float:left; margin: 0;line-height:22px;">
    <tr>
        <td valign="top" class="odd">
            Date
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            Sleep Test Type
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            Place
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            Diagnosis
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            Diagnosing Phys.
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            Diagnosing NPI#
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            File
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            AHI
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            AHI Supine
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            RDI
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            RDI Supine
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            O<sub>2</sub> Nadir
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            T &le; 90% O<sub>2</sub>
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            Dental Device
        </td>
    </tr>
    <tr>
        <td valign="top" class="odd">
            Device Setting
        </td>
    </tr>
    <tr>
        <td valign="top" class="even">
            Notes
        </td>
    </tr>
</table>
<form action="#" method="POST" style="float:left; width:185px;" enctype="multipart/form-data" onsubmit="return validate_image();">
    <table class="sleeplabstable <?php print (!empty($show_yellow) && !$sleepstudy  ? 'yellow' : ''); ?>" id="sleepstudyscrolltable">
        <tr>
            <td valign="top" class="odd">
                <input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="<?php echo date('m/d/Y'); ?>">
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <select name="sleeptesttype">
                    <option value="HST Baseline">HST Baseline</option>
                    <option value="PSG Baseline">PSG Baseline</option>
                    <option value="HST Titration">HST Titration</option>
                    <option value="PSG Titration">PSG Titration</option>
                    <option value="Oximeter">Oximeter</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <select name="place" class="place_select" onchange="addstudylab(this.value)">
                    <option>SELECT</option>
                    <option value="0">Home</option>
<?php
$lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY company ASC";

$lab_place_r = $db->getResults($lab_place_q);
foreach ($lab_place_r as $lab_place) {?>
                    <option value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
<?php
}?>
                    <option value="add">ADD SLEEP LAB</option>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                    <option value="">SELECT</option>
<?php
$ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
$ins_diag_my = $db->getResults($ins_diag_sql);

foreach ($ins_diag_my as $ins_diag_myarray) {?>
                    <option value="<?php echo st($ins_diag_myarray['ins_diagnosisid'])?>" >
                        <?php echo st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                    </option>
<?php
}?>
                </select> <span id="req_0" class="req">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input style="width:100px;" type="text" id="diagnosising_doc" autocomplete="off" name="diagnosising_doc" />
<?php
if($pat_r['p_m_ins_type']==1){?>
                <span id="req_0" class="req">*</span>
<?php
}?>
                <br />
                <div id="diagnosising_doc_hints" class="search_hints" style="display:none;">
                    <ul id="diagnosising_doc_list" class="search_list">
                        <li class="template" style="display:none">Doe, John S</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input style="width:100px;" type="text" id="diagnosising_npi" name="diagnosising_npi" />
<?php
if($pat_r['p_m_ins_type']==1){?>
                <span id="req_0" class="req">*</span>
<?php
}?>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input style="width:140px" size="8" type="file" name="ss_file" id="ss_file" /> <span id="req_0" class="req">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="ahi" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="ahisupine" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="rdi" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="rdisupine" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="o2nadir" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="t9002" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even" style="height:25px;">
                <select name="dentaldevice" style="width:150px;">
                    <option value="">SELECT</option>
<?php
$device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
$device_my = $db->getResults($device_sql);

foreach ($device_my as $device_myarray) {?>
                    <option value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
<?php
}?>
                </select>
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
                <input type="text" name="devicesetting" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="even">
                <input type="text" name="notes" />
            </td>
        </tr>
        <tr>
            <td valign="top" class="odd">
            		<input type="hidden" name="submitnewsleeplabsumm" value="1" />
                <input type="submit" value="Submit Study" />
            </td>
        </tr>
    </table>
</form>