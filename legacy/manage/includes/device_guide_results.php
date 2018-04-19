<?php
namespace Ds3\Libraries\Legacy;
include_once('../admin/includes/main_include.php');
include_once('../includes/constants.inc');
include("../includes/sescheck.php");
include_once('../includes/general_functions.php');

$deviceArray = [];

if (!isset($db) || !$db instanceof Db) {
    exit;
}
$deviceSql = <<<SQL
SELECT d.deviceid device_id, d.device name, d.image_path FROM dental_device d
SQL;
$deviceResult = $db->getResults($deviceSql);
if ($deviceResult) {
    $totals = [];
    $deviceIds = [];
    foreach ($deviceResult as $device) {
        $deviceIds[] = $device['device_id'];
        $totals[$device['device_id']] = 0;
    }
    $deviceIdsString = join(',', $deviceIds);
    $settingSql = <<<SQL
SELECT ds.device_id device_id, s.id setting_id, s.setting_type, ds.value
FROM dental_device_guide_device_setting ds
JOIN dental_device_guide_settings s ON s.id=ds.setting_id
WHERE ds.device_id IN ($deviceIdsString)
SQL;
    $settingResult = $db->getResults($settingSql);
    if ($settingResult) {
        $hiddenIds = [];
        foreach ($settingResult as $deviceSetting) {
            if ($deviceSetting['setting_type'] == 1) {
                if ($deviceSetting['value'] != '1' && $_POST['setting' . $deviceSetting['setting_id']] == '1') {
                    $hiddenIds[] = $deviceSetting['device_id'];
                }
            } else {
                $settingValue = (!empty($_POST['setting' . $deviceSetting['setting_id']]) ? $_POST['setting' . $deviceSetting['setting_id']] : '');
                $val = $settingValue * $deviceSetting['value'];
                if (isset($_POST['setting_imp_' . $deviceSetting['setting_id']])) {
                    $val *= 1.75;
                }
                $totals[$deviceSetting['device_id']] += $val;
            }
        }
        foreach ($deviceResult as $device) {
            if (!in_array($device['device_id'], $hiddenIds)) {
                $newElement = [
                    'id' => $device['device_id'],
                    'name' => $device['name'],
                    'value' => $totals[$device['device_id']],
                    'image_path' => ($device['image_path']) ? "../display_file.php?f=" . $device['image_path'] : '',
                ];
                array_push($deviceArray, $newElement);
            }
        }
    }
}

usort($deviceArray, "Ds3\Libraries\Legacy\cmp");

echo json_encode($deviceArray);

function cmp($a, $b)
{
    if ($a['value'] == $b['value']) {
        return 0;
    }
    return ($a['value'] > $b['value']) ? -1 : 1;
}
