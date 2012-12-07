<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';

$unsigned_query = "SELECT distinct(patientid) FROM dental_notes n WHERE (n.signed_on IS NULL OR n.signed_on = '') AND n.docid = '".$_SESSION['docid']."'";
$unsigned_res = mysql_query($unsigned_query);


?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<?php

while($unsigned_r = mysql_fetch_assoc($unsigned_res)){
  $p_sql = "SELECT * from dental_patients where patientid=".mysql_real_escape_string($unsigned_r['patientid']);
  $p_q = mysql_query($p_sql);
  $p_r = mysql_fetch_assoc($p_q);
?>

<tr>
  <td>
    <h3><a href="dss_summ.php?pid=<?= $p_r['patientid']; ?>&addtopat=1&sect=notes"><?= $p_r['firstname'] . " " . $p_r['lastname']; ?> - click to view patient chart</a></h3>
  </td>
</tr>

<?php
  $sql = "SELECT * from dental_notes n WHERE (n.signed_on IS NULL OR n.signed_on = '') AND n.patientid='".$unsigned_r['patientid']."' AND n.docid = '".$_SESSION['docid']."'";
  $q = mysql_query($sql);
  while($myarray = mysql_fetch_assoc($q)){
    
                        if($myarray["signed_id"] != '')
                        {
                                $tr_class = "tr_active";
                        }
                        else
                        {
                                $tr_class = "tr_inactive";
                        }
                        $tr_class = "tr_active";

                        $user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
                        $user_my = mysql_query($user_sql);
                        $user_myarray = mysql_fetch_array($user_my);
                ?>
                        <tr id="note_<?= $myarray['notesid'];?>" class="<?=$tr_class;?>" <? if(st($myarray["signed_id"]) == '') {?> style="background-color:#FF9999" <? }?>>
                                <td valign="top">
                                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                                                <tr>
                                                        <td valign="top" width="35%">
                                                                Procedure Date:
                                                                <span style="font-weight:normal;">
                                                                        <?=($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                                                </span> <br />
                                                                Entry Date:
                                                                <span style="font-weight:normal;">
                                                                        <?php
                                                                                $entry = ($myarray["parent_adddate"]!='')?$myarray["parent_adddate"]:$myarray["adddate"];
                                                                        ?>
                                                                        <?=date('M d, Y H:i',strtotime(st($entry)));?>
                                                                </span>

                                                        </td>
                                                        <td valign="top" width="35%">
                                                                Added By:
                                                                <span style="font-weight:normal;">
                                                                        <?=st($user_myarray["name"]);?>
                                                                </span>
                                                        </td>
                                                      <td valign="top" width="30%">
                                                        <span id="note_edit_<?= $myarray['notesid'];?>">
                                                        <? if(st($myarray["signed_id"]) == '') { ?>
                                                                Status: <span style="font-size:14px;">Unsigned</span>
                                                                <a href="#" onclick="loadPopup('add_notes.php?pid=<?= $_GET['pid']; ?>&ed=<?= $myarray['notesid']; ?>')">Edit</a>
                                                                <?php if($myarray["docid"]==$_SESSION['userid']){ ?>
                                                                /
                                                                <a href="dss_summ.php?pid=<?= $_GET['pid']; ?>&sid=<?= $myarray['notesid'];?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                                <input type="checkbox" class="sign_chbx" name="sign[]" value="<?= $myarray['notesid']; ?>" />
                                                                <?php } ?>
                                                        <? }else{ ?>
                                                                Signed By: <?= $myarray["signed_name"]; ?>
                                                                <br />
                                                                Signed On: <?= date('m/d/Y H:i a', strtotime($myarray["signed_on"])); ?>
                                                        <? } ?>
                                                        </span>
                                                        </td>
                                                </tr>
                                                <tr>
                                                        <td valign="top" colspan="3">
                                                                <hr size="1" />
                                                                <span style="font-weight:normal;">
                                                                        <?=nl2br(st($myarray["notes"]));?>
                                                                </span>
                                                        </td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
        <?      }
        }?>
</table>



<? include 'includes/bottom.htm';?>

