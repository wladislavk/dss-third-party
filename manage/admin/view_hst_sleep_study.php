<?php
namespace Ds3\Libraries\Legacy;

$hstId = !empty($hstId) ? $hstId : 0;
$patientData = !empty($patientData) ?: [];
$hstNights = !empty($hstNights) ? $hstNights : 1;

$patientId = intval($patientData['patientid']);
$docId = intval($patientData['docid']);

$insuranceType = $db->getColumn("SELECT p_m_ins_type
    FROM dental_patients
    WHERE patientid = '$patientId'", 'p_m_ins_type', 0);

$labPlaces = $db->getResults("SELECT sleeplabid, company
    FROM dental_sleeplab
    WHERE status = '1'
        AND docid = '$docId'
    ORDER BY sleeplabid DESC");

$insuranceDiagnosis = $db->getResults("SELECT *
    FROM dental_ins_diagnosis
    WHERE status = 1
    ORDER BY sortby");

$dentalDevices = $db->getResults("SELECT deviceid, device
    FROM dental_device
    WHERE status = 1
    ORDER BY sortby");

$sleepStudies = $db->getResults("SELECT *
    FROM dental_summ_sleeplab
    WHERE id IN (
        SELECT sleep_study_id
        FROM dental_hst
        WHERE id = '$hstId'

        UNION

        SELECT sleep_id
        FROM dental_hst_sleeplab
        WHERE hst_id = '$hstId'
    )
    ORDER BY id DESC");

/**
 * Empty case, to always show a studies table
 */
if (count($sleepStudies) < $hstNights) {
    $sleepStudies = array_merge($sleepStudies, array_fill(0, $hstNights - count($sleepStudies), []));
}

$testTypes = [
    'HST',
    'PSG',
    'PSG Baseline',
    'HST Baseline',
    'HST Titration',
];

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
<script type="text/javascript" src="/manage/js/file-upload-check.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('.sleep-labs-container').each(function () {
            var $container = $(this),
                $parent = $container.parent(), // assume a td
                $scroll = $container.find('.sleep-labs-scroll'),
                $tables = $scroll.find('table.sleeplabstable'),
                width = 20;

            $tables.each(function () {
                width += $(this).width();
            });

            $scroll.width(width);
            $container.width($parent.width() > width ? width : $parent.width());
        });

        $('[id^=file_edit_] a').click(function () {
            var $this = $(this),
                $parent = $this.closest('td'),
                $edit = $parent.find('[id^=file_edit_]'),
                $file = $parent.find('[id^=ss_file_]');

            if ($this.text() === 'Edit') {
                $file.show();
                $edit.hide();
                $this.text('Cancel').appendTo($parent);
            } else {
                $file.hide();
                $edit.show();
                $this.text('Edit').appendTo($edit);
            }

            return false;
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
        <?php foreach ($sleepStudies as $n=>$study) { ?>
            <input type="hidden" name="studies[<?= $n ?>][id]" value="<?= e(array_get($study, 'id', 0)) ?>" />
            <table class="sleeplabstable <?= !empty($show_yellow) && empty($sleepstudy) ? 'yellow' : '' ?>">
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" onchange="validateDate('date_<?= $n ?>');" maxlength="255"
                            style="width: 100px;" tabindex="10" class="field text addr tbox calendar"
                            name="studies[<?= $n ?>][date]" value="<?= e(array_get($study, 'date', date('m/d/Y'))) ?>"
                            id="date_<?= $n ?>">
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="studies[<?= $n ?>][sleeptesttype]">
                            <?php foreach ($testTypes as $type) { ?>
                                <option value="<?= e($type) ?>"
                                    <?= array_get($study, 'sleeptesttype') == $type ? 'selected' : '' ?>>
                                    <?= e($type) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <select name="studies[<?= $n ?>][place]" class="place_select">
                            <option value="">SELECT</option>
                            <?php foreach ($labPlaces as $place) { ?>
                                <option value="<?= e($place['sleeplabid']) ?>"
                                    <?= array_get($study, 'place') == $place['sleeplabid'] ? 'selected' : '' ?>>
                                    <?= e($place['company']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <select name="studies[<?= $n ?>][diagnosis]" style="width:140px;" class="field text addr tbox">
                            <option value="">SELECT</option>
                            <?php foreach ($insuranceDiagnosis as $diagnosis) { ?>
                                <option value="<?= e($diagnosis['ins_diagnosisid']) ?>"
                                    <?= array_get($study, 'diagnosis') == $diagnosis['ins_diagnosisid'] ? 'selected' : '' ?>>
                                    <?= e("{$diagnosis['ins_diagnosis']} {$diagnosis['description']}") ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="req">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input style="width:100px;" type="text" name="studies[<?= $n ?>][diagnosising_doc]"
                            value="<?= e(array_get($study, 'diagnosising_doc')) ?>" />
                        <?php if ($insuranceType == 1) { ?>
                            <span class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input style="width:100px;" type="text" name="studies[<?= $n ?>][diagnosising_npi]"
                            value="<?= e(array_get($study, 'diagnosising_npi')) ?>" />
                        <?php if ($insuranceType == 1) { ?>
                            <span class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <?php if ($study['filename']) { ?>
                            <div id="file_edit_<?= $n ?>">
                                <a href="/manage/admin/display_file.php?f=<?= rawurlencode($study['filename']) ?>"
                                    target="_blank" class="btn btn-info btn-xs">View</a>
                                <a href="#" class="btn btn-primary btn-xs">Edit</a>
                            </div>
                            <input type="file" name="ss_file_<?= $n ?>" id="ss_file_<?= $n ?>" style="display: none;" />
                        <?php } else { ?>
                            <input type="file" name="ss_file_<?= $n ?>" id="ss_file_<?= $n ?>" />
                            <span class="req">*</span>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="studies[<?= $n ?>][ahi]" value="<?= e(array_get($study, 'ahi')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="studies[<?= $n ?>][ahisupine]"
                            value="<?= e(array_get($study, 'ahisupine')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="studies[<?= $n ?>][rdi]" value="<?= e(array_get($study, 'rdi')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="studies[<?= $n ?>][rdisupine]"
                            value="<?= e(array_get($study, 'rdisupine')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="studies[<?= $n ?>][o2nadir]"
                            value="<?= e(array_get($study, 'o2nadir')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="studies[<?= $n ?>][t9002]"
                            value="<?= e(array_get($study, 't9002')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even" style="height:25px;">
                        <select name="studies[<?= $n ?>][dentaldevice]" style="width:150px;">
                            <option value="">SELECT</option>
                            <?php foreach ($dentalDevices as $device) { ?>
                                <option value="<?= e($device['deviceid']) ?>"
                                    <?= array_get($study, 'dentaldevice') == $device['deviceid'] ? 'selected' : '' ?>>
                                    <?= e($device['device']) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="odd">
                        <input type="text" name="studies[<?= $n ?>][devicesetting]"
                            value="<?= e(array_get($study, 'devicesetting')) ?>" />
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="even">
                        <input type="text" name="studies[<?= $n ?>][notes]"
                            value="<?= e(array_get($study, 'notes')) ?>" />
                    </td>
                </tr>
            </table>
        <?php } ?>
    </div>
</div>
