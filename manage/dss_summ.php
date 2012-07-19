<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';

?>
<link rel="stylesheet" href="css/summ.css" />

<div>TOP SECTION</div>

<div id="content">
<ul id="summ_nav">
  <li><a href="#" onclick="show_sect('notes')" id="link_notes" class="active">PROG NOTES</a></li>
  <li><a href="#" onclick="show_sect('treatment')" id="link_treatment">TREATMENT Hx</a></li>
  <li><a href="#" onclick="show_sect('health')" id="link_health">HEALTH Hx</a></li>
  <li><a href="#" onclick="show_sect('letters')" id="link_letters">LETTERS</a></li>
  <li><a href="#" onclick="show_sect('sleep')" id="link_sleep">SLEEP TESTS</a></li>
  <li><a href="#" onclick="show_sect('subject')" id="link_subject">SUBJ TESTS</a></li>
  <li><a href="#" onclick="show_sect('contacts')" id="link_contacts">CONTACTS</a></li>
</ul>

  <div id="sections">
  	<div id="sect_notes">
        <button onClick="Javascript: window.open('print_notes.php?pid=<?=$_GET['pid'];?>','Print_Notes','width=800,height=500',scrollbars=1);" class="addButton" style="float: left;">
                Print Progress Note
        </button>

        <button onclick="Javascript: loadPopup('add_notes.php?pid=<?=$_GET['pid'];?>');" class="addButton" style="float: right;">
                Add New Progress Note
        </button>
<div class="clear"></div>

<?php
$sql = "select n.*, u.name signed_name from dental_notes n
	LEFT JOIN dental_users u on u.userid=n.signed_id
where n.docid='".$_SESSION['docid']."' and n.patientid='".s_for($_GET['pid'])."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, u.name signed_name from
	(
	select * from dental_notes where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate desc
	) as n
	LEFT JOIN dental_users u on u.userid=n.signed_id
	group by n.parentid
	order by n.adddate desc
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
                        <tr class="<?=$tr_class;?>" <? if(st($myarray["signed_id"]) == '') {?> style="background-color:#FF9999" <? }?>>
                                <td valign="top">
                                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                                                <tr>
                                                        <td valign="top" width="55%">
                                                                Entry Date:
                                                                <span style="font-weight:normal;">
                                                                        <?=date('M d, Y H:i',strtotime(st($myarray["adddate"])));?>
                                                                </span>
                                                                Procedure Date:
                                                                <span style="font-weight:normal;">
                                                                        <?=($myarray["procedure_date"]!='')?date('M d, Y',strtotime(st($myarray["procedure_date"]))):'';?>
                                                                </span>

                                                        </td>
                                                        <td valign="top">
                                                                Added By:
                                                                <span style="font-weight:normal;">
                                                                        <?=st($user_myarray["name"]);?>
                                                                </span>
                                                        </td>
							<td valign="top">
							<? if(st($myarray["signed_id"]) == '') { ?>
								Status: Unsigned
								<a href="#" onclick="loadPopup('add_notes.php?pid=<?= $_GET['pid']; ?>&ed=<?= $myarray['notesid']; ?>')">Edit / Sign</a>
							<? }else{ ?>
								Signed By: <?= $myarray["signed_name"]; ?>
								<br />
								Signed On: <?= date('m/d/Y H:i a', strtotime($myarray["signed_on"])); ?>
							<? } ?>
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

	</div>
	<div id="sect_treatment" style="display:none;">
		TREATMENT
	</div>
  </div>
</div>
<div class="clear"></div>
<? include 'includes/bottom.htm';?>

<script type="text/javascript">
  function show_sect(sect){
    $('.active').removeClass('active');
    $("#link_"+sect).addClass('active');
    $("#sections > div").hide();
    $("#sect_"+sect).show();
  }
</script>
