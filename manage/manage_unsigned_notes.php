<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';



//$unsigned_query = "SELECT distinct(patientid) FROM dental_notes n WHERE (n.signed_on IS NULL OR n.signed_on = '') AND n.docid = '".$_SESSION['docid']."' group by n.parentid order by n.signed_on DESC";


//NEEDS OPTIMIZED
$unsigned_query = "select distinct(patientid) from (select n.*, u.name signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc) as m
        where m.signed_on IS NULL OR m.signed_on = ''
        ";

$unsigned_res = mysql_query($unsigned_query);


?>
<h2 style="margin-left:20px;">Unsigned Progress Notes (<?= $num_unsigned; ?>)</h2>
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
  //$sql = "SELECT * from dental_notes n WHERE (n.signed_on IS NULL OR n.signed_on = '') AND n.patientid='".$unsigned_r['patientid']."' AND n.docid = '".$_SESSION['docid']."'";

//NEEDS OPTIMIZED
$sql = "select * from (select n.*, u.name signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where patientid='".$unsigned_r['patientid']."' AND status!=0 AND docid='".$_SESSION['docid']."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc) as m
        where m.signed_on IS NULL OR m.signed_on = '' AND m.patientid='".$unsigned_r['patientid']."' AND 
	m.docid = '".$_SESSION['docid']."'
        ";

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
                                <td valign="top" style="border: solid 1px #000;">
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
                                                                <a href="#" onclick="loadPopup('add_notes.php?goto=manage_unsigned_notes.php&pid=<?= $unsigned_r['patientid']; ?>&ed=<?= $myarray['notesid']; ?>')">Edit</a>
                                                                <?php if($myarray["docid"]==$_SESSION['userid']){ ?>
                                                                /
                                                                <a href="dss_summ.php?return=unsigned&pid=<?= $unsigned_r['patientid']; ?>&sid=<?= $myarray['notesid'];?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                                <input type="checkbox" class="sign_chbx sign_chbx_<?= $unsigned_r['patientid']; ?>" name="sign[]" value="<?= $myarray['notesid']; ?>" />
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
			<tr><td style="line-height:2px;">&nbsp;</td></tr>
        <?      } ?>
<tr><td>
        <button onClick="sign_notes('<?= $unsigned_r['patientid']; ?>'); return false;" class="addButton" style="float: right;">
                Sign Selected Notes
        </button>
</td></tr>
	<?php
        }?>
</table>

<script type="text/javascript">
function sign_notes(pid){
  if(!confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?')){
    return false;
  }
  sign_arr = new Array();
  i=0;
  $('.sign_chbx:checked').each(function(){
    sign_arr[i++] = $(this).val();
  });
                                  $.ajax({
                                        url: "includes/sign_notes.php",
                                        type: "post",
                                        data: {ids: sign_arr.join(',')},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                    $('.sign_chbx:checked').each(function(){
                                                        id = $(this).val();
                                                        $('#note_'+id).remove();
                                                    });
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
}
</script>

<? include 'includes/bottom.htm';?>

