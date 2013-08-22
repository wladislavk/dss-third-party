
        <button onclick="Javascript: loadPopup('add_notes.php?pid=<?=$_GET['pid'];?>');" class="addButton" style="float: right;">
                + Add New Progress Note
        </button>
<div class="clear"></div>

<?php
$sql = "select n.*, u.name signed_name from dental_notes n
        LEFT JOIN dental_users u on u.userid=n.signed_id
where n.docid='".$_SESSION['docid']."' and n.patientid='".s_for($_GET['pid'])."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, u.name signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";
$my=mysql_query($sql) or die(mysql_error());
?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="10" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {
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
                                <td valign="top" style="border:solid 1px #000;">
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
                                                                <a href="#" onclick="loadPopup('add_notes.php?pid=<?= $_GET['pid']; ?>&ed=<?= $myarray['notesid']; ?>');return false;">Edit</a>
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
			<tr><td style="line-height:2px;">&nbsp;</td></tr>
        <?      }
        }?>
</table>
        <button onClick="Javascript: window.open('print_notes.php?pid=<?=$_GET['pid'];?>','Print_Notes','width=800,height=500',scrollbars=1);" class="addButton" style="float: left;">
                Print All Progress Notes
        </button>
        <button onClick="sign_notes(); return false;" class="addButton" style="float: right;">
                Sign Selected Notes
        </button>


<script type="text/javascript">

function sign_notes(){
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
							$('#note_'+id).css('backgroundColor', '');
							$('#note_edit_'+id).remove();
 						    });
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
}

</script>


