<?php
namespace Ds3\Libraries\Legacy;

$pat_r = $db->getRow("SELECT p_m_ins_type FROM dental_patients WHERE patientid = '" . intval($_GET['pid']) . "'");

$lab_place_r = $db->getResults("SELECT sleeplabid, company
    FROM dental_sleeplab
    WHERE status = '1'
        AND docid = '" . intval($_SESSION['docid']) . "'
    ORDER BY sleeplabid DESC");

$ins_diag_my = $db->getResults("SELECT *
    FROM dental_ins_diagnosis
    WHERE status = 1
    ORDER BY sortby");

$device_my = $db->getResults("SELECT deviceid, device
    FROM dental_device
    WHERE status = 1
    ORDER BY sortby");

$studyCount = !empty($studyCount) ? $studyCount : 1;

?>
<style type="text/css">
    .sleep-labs-container {
        position: relative;
        display: block;
        width: 500px;
        overflow-x: scroll;
        overflow-y: hidden;
    }

    .sleep-labs-scroll {
        position: relative;
        display: block;
        max-height: 450px;
        width: 2000px;
    }

    .sleeplabstable {
        position: relative;
        display: inline-block;
        line-height: 22px;
        margin: 0;
    }

    .sleeplabstable tr { height: 28px; }
    .yellow .odd, .yellow .even { background: #edeb46; }
    .odd { background: #f9ffdf; }
    .even { background: #e4ffcf; }
    select { width: 140px; }
</style>
<script type="text/javascript">
    function validate_image(){
        if($('#ss_file').val() == ''){
            alert('Image is required.');
            return false;
        }
        return true;
    }

    function updatePlace(f){
        if(f.sleeptesttype.value == "HST"){
            f.place.style.display = "none";
            f.home.style.display = "block";
        }else{
            f.place.style.display = "block";
            f.home.style.display = "none";
        }
    }

    function addstudylab(v){
        if(v == 'add'){
            parent.loadPopupRefer('add_sleeplab.php?r=flowsheet');
        }
    }

    jQuery(function($){
        $('.sleep-labs-container').each(function(){
            var $container = $(this),
                $parent = $container.parent(), // assume a td
                $scroll = $container.find('.sleep-labs-scroll'),
                $tables = $scroll.find('table.sleeplabstable'),
                width = 20;

            $tables.each(function(){
                width += $(this).width();
            });

            $scroll.width(width);
            $container.width($parent.width() > width ? width : $parent.width());
        });
    });
</script>
<div class="sleep-labs-container">
    <div class="sleep-labs-scroll">
        <table class="sleeplabstable">
            <tr>
                <td valign="top" class="odd">
                    Date
                </td>
            </tr>
            <tr>
                <td valign="top" class="even">
                    Sleep Test Type
                </td></tr>
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
        <?php for ($n=0; $n<$studyCount; $n++) { ?>
            <input type="hidden" name="submitnewsleeplabsumm" value="1" />
            <table class="sleeplabstable <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>" id="sleepstudyscrolltable">
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="<?= date('m/d/Y'); ?>">
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="sleeptesttype">
                            <option value="HST">HST</option>
                            <option value="PSG">PSG</option>
                            <option value="PSG Baseline">PSG Baseline</option>
                            <option value="HST Baseline">HST Baseline</option>
                            <option value="HST Titration">HST Titration</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <select name="place" class="place_select" onchange="addstudylab(this.value)">
                            <option>SELECT</option>
                            <?php foreach($lab_place_r as $lab_place) { ?>
                                <option value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
                            <?php } ?>
                            <option value="add">ADD SLEEP LAB</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                            <option value="">SELECT</option>
                            <?php foreach ($ins_diag_my as $ins_diag_myarray) { ?>
                                <option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" >
                                    <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                                </option>
                            <?php } ?>
                        </select>
                        <span id="req_0" class="req">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input style="width:100px;" type="text" name="diagnosising_doc" />
                        <?php if ($pat_r['p_m_ins_type'] == 1) { ?>
                            <span id="req_0" class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input style="width:100px;" type="text" name="diagnosising_npi" />
                        <?php if ($pat_r['p_m_ins_type'] == 1) { ?>
                            <span id="req_0" class="req">*</span>
                        <?php } ?>
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
                            <?php foreach ($device_my as $device_myarray) { ?>
                                <option value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                            <?php } ?>
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
            </table>
        <?php } ?>
    </div>
</div>
