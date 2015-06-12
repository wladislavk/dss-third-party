<?php namespace Ds3\Libraries\Legacy; ?><?php
    include 'includes/top.htm';
    include_once 'includes/constants.inc';

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

    $unsigned_res = $db->getResults($unsigned_query);
?>
    <h2 style="margin-left:20px;">Unsigned Progress Notes (<?php echo  $num_unsigned; ?>)</h2>
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >

    <script type="text/javascript" src="js/manage_unsigned_notes.js"></script>

<?php
    foreach ($unsigned_res as $unsigned_r) {
        $p_sql = "SELECT p.*, q.chief_complaint_text from dental_patients p LEFT JOIN dental_q_page1 q on q.patientid=p.patientid where p.patientid=".mysqli_real_escape_string($con, $unsigned_r['patientid']);
        $p_r = $db->getRow($p_sql);

        $itype_sql = "select * from dental_q_image where imagetypeid=4 AND patientid=".mysqli_real_escape_string($con, $unsigned_r['patientid'])." ORDER BY adddate DESC LIMIT 1";
        $itype = $db->getRow($itype_sql);
        $patient_photo = $itype['image_file'];
?>

        <tr>
          <td class="patient_header">
            <h3><a href="dss_summ.php?pid=<?php echo  $p_r['patientid']; ?>&addtopat=1&sect=notes"><?php echo  $p_r['firstname'] . " " . $p_r['lastname']; ?> - click to view patient chart</a></h3>
        	<div class="tooltip">
        		<img src="display_file.php?f=<?php echo  $patient_photo; ?>" style="float:left;" />
        		<div style="float:left;padding-left:10px;"> <?php echo  $p_r['firstname'] . " " . $p_r['lastname']; ?> - <?php echo  $p_r['dob']; ?><br />
            		REASON FOR SEEKING TX: <?php echo  $p_r['chief_complaint_text']; ?><br />
            		<?php echo $p_r['add1'];?><br />
                    <?php echo $p_r['add2'];?><br />
                    <?php echo $p_r['city']. " ".$p_r['state']." ".$p_r['zip'];?> 
        		</div> 		
        	</div>
          </td>
        </tr>

        <?php
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

            $q = $db->getResults($sql);
            foreach ($q as $myarray) {             
                if($myarray["signed_id"] != '') {
                    $tr_class = "tr_active";
                } else {
                    $tr_class = "tr_inactive";
                }

                $tr_class = "tr_active";

                $user_sql = "SELECT * FROM dental_users where userid='".st($myarray["userid"])."'";
                $user_myarray = $db->getRow($user_sql);
        ?>
                <tr id="note_<?php echo  $myarray['notesid'];?>" class="<?php echo $tr_class;?>" <? if(st($myarray["signed_id"]) == '') {?> style="background-color:#FF9999" <? }?>>
                    <td valign="top" style="border: solid 1px #000;">
                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                            <tr>
                                <td valign="top" width="35%">
                                    Procedure Date:
                                    <span style="font-weight:normal;">
                                        <?php echo ($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                    </span><br />
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
                                        <?php echo st($user_myarray["name"]);?>
                                    </span>
                                </td>
                                <td valign="top" width="30%">
                                    <span id="note_edit_<?php echo  $myarray['notesid'];?>">
                                        <?php if(st($myarray["signed_id"]) == '') { ?>
                                            Status: <span style="font-size:14px;">Unsigned</span>
                                            <a href="#" onclick="loadPopup('add_notes.php?goto=manage_unsigned_notes.php&pid=<?php echo  $unsigned_r['patientid']; ?>&ed=<?php echo  $myarray['notesid']; ?>')">Edit</a>
                                            
                                            <?php if ($myarray["docid"] == $_SESSION['userid']) { ?>
                                                /
                                                <a href="dss_summ.php?return=unsigned&pid=<?php echo  $unsigned_r['patientid']; ?>&sid=<?php echo  $myarray['notesid'];?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                <input type="checkbox" class="sign_chbx sign_chbx_<?php echo  $unsigned_r['patientid']; ?>" name="sign[]" value="<?php echo  $myarray['notesid']; ?>" />
                                        <?php       } 
                                            } else {
                                        ?>
                                                Signed By: <?php echo  $myarray["signed_name"]; ?>
                                                <br />
                                                Signed On: <?php echo  date('m/d/Y H:i a', strtotime($myarray["signed_on"])); ?>
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
        <?php } ?>

        <tr>
            <td>
                <button onClick="sign_notes('<?php echo  $unsigned_r['patientid']; ?>'); return false;" class="addButton" style="float: right;">
                    Sign Selected Notes
                </button>
            </td>
        </tr>
<?php } ?>
    </table>

<?php include 'includes/bottom.htm';?>
