<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" class="table table-bordered table-hover">
<?php if(count($my) == 0){ ?>
        <tr class="tr_bg">
                <th valign="top" class="col_head" colspan="10" align="center">
                        No Records
                </th>
        </tr>
<?php
}else{
        foreach ($my as $myarray) {
                if($myarray["signed_id"] != '')
                {
                        $tr_class = "tr_active";
                        $bg_color = "";
                        $status = "Signed";
                }
                else if($myarray["status"]==2){
                        $tr_class = "tr_draft";
                        $bg_color = "#FFFF99";
                        $status = 'Draft';
                }
                else
                {
                        $tr_class = "tr_inactive";
                        $bg_color = "#FF9999";
                        $status = "Unsigned";
                }
                $tr_class = "tr_active";
                $user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
                $user_myarray = $db->getRow($user_sql);
?>
        <tr id="note_<?php echo $myarray['notesid'];?>" class="<?php echo $tr_class;?>" <?php if($bg_color != '') {?> style="background-color:<?php echo $bg_color?>" ?>>
                <td valign="top" style="border:solid 1px #000;">
                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                                <tr>
                                        <td valign="top" width="35%">
                                                Procedure Date:
                                                <span style="font-weight:normal;">
                                                        <?php echo ($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                                </span> 
                                                <br />
                                                Entry Date:
                                                <span style="font-weight:normal;">
                                                <?php
                                                        $entry = ($myarray["parent_adddate"]!='')?$myarray["parent_adddate"]:$myarray["adddate"];
                                                ?>
                                                        <?php echo date('M d, Y H:i',strtotime(st($entry)));?>
                                                </span>
                                        </td>
                                        <td valign="top" width="35%">
                                                Added By:
                                                <span style="font-weight:normal;">
                                                        <?php echo st($user_myarray["first_name"]." ".$user_myarray["last_name"]);?>
                                                </span>
                                        </td>
                                        <td valign="top" width="30%">
                                                <span id="note_edit_<?php echo $myarray['notesid'];?>">
                                        <?php if($status == 'Unsigned' || $status == 'Draft') { ?>
                                                        Status: 
                                                        <span style="font-size:14px;"><?php echo $status; ?></span>
                                                <?php if(!empty($office_type) && $office_type == DSS_OFFICE_TYPE_FRONT){ ?>
                                                        <a href="#" onclick="loadPopup('add_notes.php?pid=<?php echo $_GET['pid']; ?>&ed=<?php echo $myarray['notesid']; ?>');return false;">Edit</a>
                                                        <?php if($myarray["docid"]==$_SESSION['userid']){ ?>
                                                        /
                                                        <a href="dss_summ.php?pid=<?php echo $_GET['pid']; ?>&sid=<?php echo $myarray['notesid'];?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                        <input type="checkbox" class="sign_chbx" name="sign[]" value="<?php echo $myarray['notesid']; ?>" />
                                                        <?php } 
                                                        } 
                                        }else{ ?>
                                                        Signed By: <?php echo $myarray["signed_name"]; ?>
                                                        <br />
                                                        Signed On: <?php echo date('m/d/Y H:i a', strtotime($myarray["signed_on"])); ?>
                                        <?php } ?>
                                                </span>
                                        </td>
                                </tr>
                                <tr>
                                        <td valign="top" colspan="3">
                                                <hr size="1" />
                                                <span style="font-weight:normal;">
                                                        <?php echo nl2br(st($myarray["notes"]));?>
                                                </span>
                                        </td>
                                </tr>
                        </table>
                </td>
        </tr>
        <tr>
                <td style="line-height:2px;">&nbsp;</td>
        </tr>
        <?php      }
}
}?>
</table>
