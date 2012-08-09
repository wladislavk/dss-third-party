<?php
$flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
$flowresult = mysql_query($flowquery);
$flow = mysql_fetch_array($flowresult);
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
                $rximgid = $flow['rx_imgid'];
                $lomnimgid = $flow['lomn_imgid'];
if ($rximgid != "") {
        $sql = "select image_file from dental_q_image where patientid='".$_GET['pid']."' AND imageid = '".$rximgid."';";
        $result = mysql_query($sql);
        $rximgname = mysql_result($result, 0);
}

if ($lomnimgid != "") {
        $sql = "select image_file from dental_q_image where patientid='".$_GET['pid']."' AND imageid = '".$lomnimgid."';";
        $result = mysql_query($sql);
        $lomnimgname = mysql_result($result, 0);
}


?>
<div style="width:600px; clear:both; height:20px; margin:0 auto; padding-top:3px; padding-left:10px;" class="col_head tr_bg_h">MEDICAL INSURANCE</div>
<table width="610px" <?php print (!$medins  ? 'class="yellow"' : ''); ?> align="center">
<tr style="vertical-align:middle;">
<td>
<h3>Procedure</h3>
	</td>
	<td>
	<h3>Requested</h3>
</td>
<td>
<h3>Received</h3>
</td>
<td>
<h3>Image</h3>
</td>
</tr>
<tr>
<td>
Rx.
</td>
<td>
<input id="rxreq" name="rxreq" type="text" class="field text addr tbox calendar" value="<?php echo $rxreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxreq');" />
</td>
<td>
<input id="rxrec" name="rxrec" type="text" class="field text addr tbox calendar" value="<?php echo $rxrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('rxrec');" onClick="<?php print ($rximgid == "" ? "alert('You must upload an image before Rx can be marked as received');" : ""); ?>" /><span id="req_0" class="req">*</span>
</td>
<td><!--<a href="q_image.php?pid=<?php echo $_GET['pid']; ?>&sh=6&flow=1" id="add-rx" target="_self">Add/Edit RX</a>-->
					<?php
					if ($rximgid != "") {
						print "<input type=\"button\" id=\"rxview\" value=\"View\" title=\"View\" onClick=\"window.open(" . ($pdf1 ? "'/manage/q_file/$rximgname'" : "'imageholder.php?image=$rximgname'") . ",'windowname1','width=860, height=790,scrollbars=yes');return false;\" />";
						print "<input type=\"button\" class=\"toggle_but\" id=\"rx\" value=\"Edit\" title=\"Edit\" />";
						print "<input id=\"rximg\" style=\"display:none;\" name=\"rximg\" type=\"file\" size=\"4\" />";
						/*<a style="font-weight:bold; font-size:15px;" href="javascript: void(0)" onClick="window.open('sleepstudies/<?=$_GET['pid']?>-<?php echo $sleepstudy['testnumber']; ?>.<?php echo $sleepstudy['scanext']; ?>','windowname1','width=400, height=400');return false;">View Scan</a>*/
					} else {
						print "<input id=\"rximg\" name=\"rximg\" type=\"file\" size=\"4\" />";
					}
					?>
</td>

</tr>

<tr>

<td>
L.O.M.N.
</td>
<td>
<input id="lomnreq" name="lomnreq" type="text" class="field text addr tbox calendar" value="<?php echo $lomnreq; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnreq');" />
</td>
<td>
<input id="lomnrec" name="lomnrec" type="text" class="field text addr tbox calendar" value="<?php echo $lomnrec; ?>" tabindex="10" style="width:100px;" maxlength="255" onChange="validateDate('lomnrec');" onClick="<?php print ($lomnimgid == "" ? "alert('You must upload an image before LOMN can be marked as received');" : ""); ?>" /><span id="req_0" class="req">*</span>
</td>
<td>
                                                <?php
                                                if ($lomnimgid != "") {
                                                        print "<input type=\"button\" id=\"lomnview\" value=\"View\" title=\"View\" onClick=\"window.open(" . ($pdf2 ? "'/manage/q_file/$lomnimgname'" : "'imageholder.php?image=$lomnimgname'") . ",'windowname1','width=860,height=790,scrollbars=yes');return false;\" />";
                                                        print "<input type=\"button\" class=\"toggle_but\" id=\"lomn\" value=\"Edit\" title=\"Edit\" />";
                                                        print "<input id=\"lomnimg\" style=\"display:none;\" name=\"lomnimg\" type=\"file\" size=\"4\" />";
                                                        /*<a style="font-weight:bold; font-size:15px;" href="javascript: void(0)" onClick="window.open('sleepstudies/<?=$_GET['pid']?>-<?php echo $sleepstudy['testnumber']; ?>.<?php echo $sleepstudy['scanext']; ?>','windowname1','width=400, height=400');return false;">View Scan</a>*/
                                                } else {
                                                        print "<input id=\"lomnimg\" name=\"lomnimg\" type=\"file\" size=\"4\" />";
                                                }
                                                ?>

</td>

</tr>


</table>

