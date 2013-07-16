<? 
require_once('includes/constants.inc');
include "includes/top.htm";




$sql = "SELECT f.*,
	CONCAT(p.firstname,' ',p.lastname) as patient_name,
	l.template_type,
	l.templateid,
        l.pdf_path,
        l.status as letter_status
	 FROM dental_faxes f 
	LEFT JOIN dental_patients p ON p.patientid = f.patientid
	LEFT JOIN dental_letters l ON l.letterid = f.letterid
	WHERE f.docid='".mysql_real_escape_string($_SESSION['docid'])."' ";
  $sql .= " ORDER BY adddate DESC";
$my = mysql_query($sql);
if(mysql_num_rows($my)){
?>
<br /><br />
<span class="admin_head">Manage Faxes</span>
<br />
<br />
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="15%">
			Date Sent
                </td>
                <td valign="top" class="col_head" width="15%">
                        To
                </td>
                <td valign="top" class="col_head" width="15%">
			Patient
		</td>
                <td valign="top" class="col_head" width="15%">
			Correspondance 
		</td>
		<td valign="top" class="col_head" width="15%">
                        Status
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
if($myarray['template_type']=='0'){
  $template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$myarray['templateid'].";";
}else{
  $template_query = "SELECT name FROM dental_letter_templates_custom WHERE id = ".$myarray['templateid'].";";
}
$template_result = mysql_query($template_query);
$title = mysql_result($template_result, 0);

                ?>
                        <tr class="<?=$tr_class;?> <?= ($myarray['viewed']||$myarray['status']==DSS_PREAUTH_PENDING)?'':'unviewed'; ?>">
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
                                          <a href="letterpdfs/<?= $myarray['pdf_path']; ?>"><?= $title; ?></a>
					<?php }else{ ?>
		                          <a href="edit_letter.php?pid=<?=$myarray['patientid'];?>&lid=<?= $myarray['letterid']; ?>"><?= $title; ?></a>
					<?php } ?>
                                </td>
				<td valign="top">
					<?php if($myarray['sfax_completed']=='0'){ ?>
						Pending
					<?php }elseif($myarray['sfax_status']=='1'){ ?>
						Succeeded
					<?php }elseif($myarray['sfax_status']=='2'){ ?>
						Failed
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
