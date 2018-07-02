<?php
namespace Ds3\Libraries\Legacy;
?>
<div>
    <?php
    $db = new Db();

    $flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
    $flow = $db->getRow($flowquery);

    $rxrec = $flow['rxrec'];
    $lomnrec = $flow['lomnrec'];
    $rxlomnrec = $flow['rxlomnrec'];
    $rximgid = $flow['rx_imgid'];
    $lomnimgid = $flow['lomn_imgid'];
    $rxlomnimgid = $flow['rxlomn_imgid'];

    if ($rximgid != "") {
        $sql = "select image_file from dental_q_image where patientid='".$_GET['pid']."' AND imageid = '".$rximgid."';";
        $result = $db->getRow($sql);
        $rximgname = array_shift($result);
    }

    if ($lomnimgid != "") {
        $sql = "select image_file from dental_q_image where patientid='".$_GET['pid']."' AND imageid = '".$lomnimgid."';";
        $result = $db->getRow($sql);
        $lomnimgname = array_shift($result);
    }

    if ($rxlomnimgid != "") {
        $sql = "select image_file from dental_q_image where patientid='".$_GET['pid']."' AND imageid = '".$rxlomnimgid."';";
        $result = $db->getRow($sql);
        $rxlomnimgname = array_shift($result);
    }?>

    <div style="width:400px; clear:both; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">Insurance Documents</div>
    <table width="100%" <?php print (empty($medins)  ? 'class="yellow"' : ''); ?> align="center">
        <tr style="vertical-align:middle;">
            <td>
                <h3>Procedure</h3>
            </td>
            <td>
                <h3>Received</h3>
            </td>
            <td>
                <h3>Image</h3>
            </td>
        </tr>
        <?php
        if($rximgid != "" || $lomnimgid != ""){ ?>
            <tr>
                <td>
                    Rx.
                </td>
                <td>
                    <input id="rxrec" name="rxrec" type="text" class="field text addr tbox calendar" value="<?php echo $rxrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxrec');" onClick="<?php print ($rximgid == "" ? "alert('You must upload an image before Rx can be marked as received');" : ""); ?>" /><span id="req_0" class="req">*</span>
                </td>
                <td>
                    <?php
                    if ($rximgid != "") {?>
                        <a class="button" href="display_file.php?f=<?php echo $rximgname; ?>" target="_blank">View</a>
                        <?php
                        echo "<input type=\"button\" class=\"toggle_but\" id=\"rx\" onclick=\"loadPopup('add_image.php?pid=".$_GET['pid']."&sh=6&flow=');\" value=\"Edit\" title=\"Edit\" />";
                        echo "<input id=\"rximg\" style=\"display:none;\" name=\"rximg\" type=\"file\" size=\"4\" />";
                    }?>
                </td>
            </tr>
            <tr>
                <td>
                    L.O.M.N.
                </td>
                <td>
                    <input id="lomnrec" name="lomnrec" type="text" class="field text addr tbox calendar" value="<?php echo $lomnrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnrec');" onClick="<?php print ($lomnimgid == "" ? "alert('You must upload an image before LOMN can be marked as received');" : ""); ?>" /><span id="req_0" class="req">*</span>
                </td>
                <td>
                    <?php
                    if ($lomnimgid != "") {?>
                        <a href="display_file.php?f=<?php echo $lomnimgname; ?>" target="_blank" class="button">View</a>
                        <?php
                        echo "<input type=\"button\" class=\"toggle_but\" id=\"lomn\" onclick=\"loadPopup('add_image.php?pid=".$_GET['pid']."&sh=7&flow=');\" value=\"Edit\" title=\"Edit\" />";
                        echo "<input id=\"lomnimg\" style=\"display:none;\" name=\"lomnimg\" type=\"file\" size=\"4\" />";
                    }?>
                </td>
            </tr>
            <?php
        }else{ ?>
            <tr>
                <td>
                    Rx./L.O.M.N.
                </td>
                <td>
                    <input id="rxlomnrec" name="rxlomnrec" type="text" class="field text addr tbox calendar" value="<?php echo $rxlomnrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxlomnrec');" onClick="<?php print ($rxlomnimgid == "" ? "alert('You must upload an image before Rx/LOMN can be marked as received');" : ""); ?>" /><span id="req_0" class="req">*</span>
                </td>
                <td>
                    <?php
                    if ($rxlomnimgid != "") {?>
                        <a href="display_file.php?f=<?php echo $rxlomnimgname; ?>" target="_blank" class="button">View</a>
                        <?php
                        echo "<input type=\"button\" class=\"toggle_but\" id=\"lomn\" onclick=\"loadPopup('add_image.php?pid=".$_GET['pid']."&sh=13&flow=');\" value=\"Edit\" title=\"Edit\" />";
                        echo "<input id=\"rxlomnimg\" style=\"display:none;\" name=\"lomnimg\" type=\"file\" size=\"4\" />";
                    }?>
                </td>
            </tr>
            <?php
        } ?>
    </table>
</div>
