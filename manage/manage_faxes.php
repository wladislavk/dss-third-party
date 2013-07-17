<? 
require_once('includes/constants.inc');
include "includes/top.htm";

$rec_disp = 20;

if(isset($_REQUEST["page"]))
        $index_val = $_REQUEST["page"];
else
        $index_val = 0;

$i_val = $index_val * $rec_disp;

$sql = "SELECT f.*,
	CONCAT(p.firstname,' ',p.lastname) as patient_name,
	l.template_type,
	l.templateid,
        l.pdf_path,
        l.status as letter_status,
	CASE l.template_type
		WHEN '0' THEN t.name
		WHEN '1' THEN tc.name
	END letter_name 
	 FROM dental_faxes f 
	LEFT JOIN dental_patients p ON p.patientid = f.patientid
	LEFT JOIN dental_letters l ON l.letterid = f.letterid
	LEFT JOIN dental_letter_templates t ON t.id=l.templateid
	LEFT JOIN dental_letter_templates_custom tc ON tc.id=l.templateid
	WHERE f.docid='".mysql_real_escape_string($_SESSION['docid'])."' ";

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'adddate';
  $_REQUEST['sortdir'] = 'DESC';
}

  if ($_REQUEST['sort'] == 'lastname') {
        $sql .= " ORDER BY p.lastname ".$_REQUEST['sortdir'].", p.firstname ".$_REQUEST['sortdir'];
  } else {
          $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
        }


$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($my)){
?>
<br /><br />
<span class="admin_head">Manage Faxes</span>
<br />
<br />
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<? if($total_rec > $rec_disp) {?>
        <TR bgColor="#ffffff">
                <TD  align="right" colspan="15" class="bp">
                        Pages:
                        <?
                                 paging($no_pages,$index_val,"");
                        ?>
                </TD>
        </TR>
        <? }?>

        <tr class="tr_bg_h">
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_faxes.php?sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Date Sent</a>
                </td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'to_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                        <a href="manage_faxes.php?sort=to_name&sortdir=<?php echo ($_REQUEST['sort']=='to_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">To</a>
                </td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_faxes.php?sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
                <td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'letter_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
			<a href="manage_faxes.php?sort=letter_name&sortdir=<?php echo ($_REQUEST['sort']=='letter_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Correspondance</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'sfax_status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
                        <a href="manage_faxes.php?sort=sfax_status&sortdir=<?php echo ($_REQUEST['sort']=='sfax_status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Status</a>
                </td>
        </tr>
        <? if(mysql_num_rows($my) == 0)
        { ?>
                <tr class="tr_bg">
                        <td valign="top" class="col_head" colspan="4" align="center">
                                No Records
                        </td>
                </tr>
        <?
        }
        else
        {
                while($myarray = mysql_fetch_array($my))
                {

                ?>
                        <tr <?= ($myarray['sfax_status'] == '2' && $myarray['viewed']=='0')?'class="current_alert""':'';?>>
                                <td valign="top">
                                        <?=date('m/d/y h:i a', strtotime($myarray["sent_date"]));?>&nbsp;
                                </td>
                                <td valign="top">
                    			<a href="#" onclick="loadPopup('add_contact.php?ed=<?= $myarray['contactid']; ?>'); return false;"><?= $myarray["to_name"]; ?></a> <?=format_phone($myarray["to_number"]);?>
                                </td>
                                <td valign="top">
                                        <a href="dss_summ.php?sect=letters&pid=<?= $myarray['patientid']; ?>"><?= $myarray['patient_name']; ?></a>
                                </td>
                                <td valign="top">
					<?php if($myarray['pdf_path'] && $myarray['letter_status']!=DSS_LETTER_PENDING){ ?>
                                          <a href="letterpdfs/<?= $myarray['pdf_path']; ?>"><?= $myarray['letter_name']; ?></a>
					<?php }else{ ?>
		                          <a href="edit_letter.php?pid=<?=$myarray['patientid'];?>&lid=<?= $myarray['letterid']; ?>"><?= $myarray['letter_name']; ?></a>
					<?php } ?>
                                </td>
				<td valign="top">
					<?php if($myarray['sfax_completed']=='0'){ ?>
						Pending
					<?php }elseif($myarray['sfax_status']=='1'){ ?>
						Success
					<?php }elseif($myarray['sfax_status']=='2' && $myarray['sfax_status'] == '2' && $myarray['viewed']=='0'){ ?>
						<a href="edit_letter.php?pid=<?=$myarray['patientid'];?>&lid=<?= $myarray['letterid']; ?>">Fail (click to view)</a>
					<?php }elseif($myarray['sfax_status']=='2'){ ?>
                                                Fail
                                        <?php } ?>
				</td>
                        </tr>
        <?      }
        }?>
</table>
</form>

<?php } ?>




<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
