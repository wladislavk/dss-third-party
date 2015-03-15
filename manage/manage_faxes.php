<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
include_once('includes/constants.inc');

if(isset($_GET['ceid']) && $_GET['ceid']!=''){
  $up_sql = "UPDATE dental_faxes SET viewed='1'
	WHERE id='".mysqli_real_escape_string($con,$_GET['ceid'])."'
	";
  $db->query($up_sql);
}



$sql = "SELECT f.*,
        CONCAT(p.firstname,' ',p.lastname) as patient_name,
        l.template_type,
        l.templateid,
        l.pdf_path,
        l.status as letter_status,
        ec.description AS error_description,
        ec.resolution AS error_resolution
         FROM dental_faxes f 
        LEFT JOIN dental_patients p ON p.patientid = f.patientid
        LEFT JOIN dental_letters l ON l.letterid = f.letterid
        LEFT JOIN dental_fax_error_codes ec ON ec.error_code = f.sfax_error_code
        WHERE f.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' AND
        sfax_completed=1 AND sfax_status=2 AND
        viewed = 0";
$sql .= " ORDER BY adddate DESC";

$my = $db->getResults($sql);
if (count($my)) {
?>

<span class="admin_head">Manage Faxes - Fax Errors</span>
<br />
<br />
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
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
                Error
            </td>
            <td valign="top" class="col_head" width="15%">
                Action
            </td>
        </tr>
    <?php if(count($my) == 0){ ?>
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="6" align="center">
                No Records
            </td>
        </tr>
    <?
    }
    else
    {
        foreach ($my as $myarray) {

            if($myarray['template_type']=='0'){
              $template_query = "SELECT name FROM dental_letter_templates WHERE id = ".$myarray['templateid'].";";
            }else{
              $template_query = "SELECT name FROM dental_letter_templates_custom WHERE id = ".$myarray['templateid'].";";
            }

            $title = $db->getRow($template_query);

            ?>
        <tr>
            <td valign="top">
                <?php echo st($myarray["adddate"]);?>&nbsp;
            </td>
            <td valign="top">
                <a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $myarray['contactid']; ?>'); return false;"><?php echo $myarray["to_name"]; ?></a> <?php echo format_phone($myarray["to_number"]);?>
            </td>
            <td valign="top">
                <a href="dss_summ.php?sect=letters&pid=<?php echo $myarray['patientid']; ?>"><?php echo $myarray['patient_name']; ?></a>
            </td>
            <td valign="top">
            <?php if($myarray['pdf_path'] && $myarray['letter_status']!=DSS_LETTER_PENDING){ ?>
                <a href="letterpdfs/<?php echo $myarray['pdf_path']; ?>"><?php echo $title; ?></a>
            <?php }else{ ?>
                <a href="edit_letter.php?pid=<?php echo $myarray['patientid'];?>&lid=<?php echo $myarray['letterid']; ?>"><?php echo $title['name']; ?></a>
            <?php } ?>
            </td>
            <td valign="top">
                <?php echo st($myarray["error_description"]); ?> - <?php echo st($myarray["error_resolution"]); ?>
            </td>
            <td valign="top">
            <?php if($myarray['pdf_path'] && $myarray['letter_status']!=DSS_LETTER_PENDING){ ?>
                <a href="letterpdfs/<?php echo $myarray['pdf_path']; ?>">View Letter</a>
            <?php }else{ ?>
                <a href="edit_letter.php?pid=<?php echo $myarray['patientid'];?>&lid=<?php echo $myarray['letterid']; ?>&goto=faxes">
                    Resend Letter
                </a>
                |
                <a href="manage_faxes.php?ceid=<?php echo $myarray['id']; ?>" onclick="return confirm('This will revert the letter to a status of pending. You will still need to resend the letter. Are you sure you want to clear this error?');">
                    Clear Error
                </a>
            <?php } ?>
            </td>
        </tr>
        <?php }
    }?>
    </table>
</form>

<?php }
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
	l.deleted as letter_deleted,
	CASE l.template_type
		WHEN '0' THEN t.name
		WHEN '1' THEN tc.name
	END letter_name 
	 FROM dental_faxes f 
	LEFT JOIN dental_patients p ON p.patientid = f.patientid
	LEFT JOIN dental_letters l ON l.letterid = f.letterid
	LEFT JOIN dental_letter_templates t ON t.id=l.templateid
	LEFT JOIN dental_letter_templates_custom tc ON tc.id=l.templateid
	WHERE f.docid='".mysqli_real_escape_string($con,$_SESSION['docid'])."' ";

if(isset($_REQUEST['filter'])){
    if($_REQUEST['filter'] == 'success'){
        $sql .= " AND f.sfax_status='1' ";
    }elseif($_REQUEST['filter'] == 'fail'){
        $sql .= " AND f.sfax_status='2' and l.deleted!='1' ";
    }elseif($_REQUEST['filter'] == 'deleted'){
        $sql .= " AND l.deleted='1' ";
    }
}

if(!isset($_REQUEST['sort'])){
    $_REQUEST['sort'] = 'adddate';
    $_REQUEST['sortdir'] = 'DESC';
}

if ($_REQUEST['sort'] == 'lastname') {
    $sql .= " ORDER BY p.lastname ".$_REQUEST['sortdir'].", p.firstname ".$_REQUEST['sortdir'];
} elseif($_REQUEST['sort']!='') {
    $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
}

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);

if(count($my)){
?>
<br /><br />
<span class="admin_head">Manage Faxes</span>
<br />
<br />
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <TR bgColor="#ffffff">
        <TD  colspan="3" class="bp">
            <label style="margin-left:20px;">Filter by status</label>
            <select onchange="updateFaxes(this.value)">
                <option value="all"  <?php echo (!empty($_GET['filter']) && $_GET['filter']== 'all')?'selected="selected"':''; ?>>All</option>
                <option value="success" <?php echo (!empty($_GET['filter']) && $_GET['filter']== 'success')?'selected="selected"':''; ?>>Success</option>
                <option value="fail" <?php echo (!empty($_GET['filter']) && $_GET['filter']== 'fail')?'selected="selected"':''; ?>>Fail</option>
                <option value="deleted" <?php echo (!empty($_GET['filter']) && $_GET['filter']== 'deleted')?'selected="selected"':''; ?>>Deleted</option>
            </select>

<script type="text/javascript">
function updateFaxes(v){
    window.location="?filter="+v+"&sort=<?php echo $_GET['sort']; ?>&sortdir=<?php echo $_GET['sortdir']; ?>";
}
</script>

        </td>
        <TD  align="right" colspan="2" class="bp">
        <?php if($total_rec > $rec_disp) {?>
            Pages:
            <?php
                paging($no_pages,$index_val,"");
            }?>
        </td>
    </tr>
    <tr class="tr_bg_h">
        <td valign="top" class="col_head  <?php echo ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
            <a href="manage_faxes.php?sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                Date Sent
            </a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'to_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
            <a href="manage_faxes.php?sort=to_name&sortdir=<?php echo ($_REQUEST['sort']=='to_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                To
            </a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'patient_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
            <a href="manage_faxes.php?sort=patient_name&sortdir=<?php echo ($_REQUEST['sort']=='patient_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                Patient
            </a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'letter_name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
            <a href="manage_faxes.php?sort=letter_name&sortdir=<?php echo ($_REQUEST['sort']=='letter_name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                Correspondance
            </a>
        </td>
        <td valign="top" class="col_head <?php echo ($_REQUEST['sort'] == 'sfax_status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="15%">
            <a href="manage_faxes.php?sort=sfax_status&sortdir=<?php echo ($_REQUEST['sort']=='sfax_status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">
                Status
            </a>
        </td>
    </tr>
    <?php if(count($my) == 0)
    { ?>
    <tr class="tr_bg">
        <td valign="top" class="col_head" colspan="4" align="center">
            No Records
        </td>
    </tr>
    <?php
    }
    else
    {
        foreach ($my as $myarray) { ?>
    <tr <?php echo ($myarray['letter_deleted']==1)?'class="row_deleted"':''; ?> <?php echo ($myarray['sfax_status'] == '2' && $myarray['viewed']=='0')?'class="current_alert""':'';?>>
        <td valign="top">
            <?php echo date('m/d/y h:i a', strtotime($myarray["sent_date"]));?>&nbsp;
        </td>
        <td valign="top">
            <a href="#" onclick="loadPopup('add_contact.php?ed=<?php echo $myarray['contactid']; ?>'); return false;">
                <?php echo $myarray["to_name"]; ?>
            </a> 
            <?php echo format_phone($myarray["to_number"]);?>
        </td>
        <td valign="top">
            <a href="dss_summ.php?sect=letters&pid=<?php echo $myarray['patientid']; ?>">
                <?php echo $myarray['patient_name']; ?>
            </a>
        </td>
        <td valign="top">
		<?php if($myarray['filename'] && ($myarray['letter_status']!=DSS_LETTER_PENDING || $myarray['viewed']==1) ){ ?>
            <a href="letterpdfs/<?php echo $myarray['filename']; ?>">
                <?php echo $myarray['letter_name']; ?>
            </a>
		<?php }else{ ?>
            <a href="edit_letter.php?pid=<?php echo $myarray['patientid'];?>&lid=<?php echo $myarray['letterid']; ?>">
                <?php echo $myarray['letter_name']; ?>
            </a>
		<?php } ?>
        </td>
		<td valign="top">
        <?php if($myarray['sfax_completed']=='0'){ ?>
            Pending
        <?php }elseif($myarray['sfax_status']=='1'){ ?>
            Success
        <?php }elseif($myarray['sfax_status']=='2' && $myarray['letter_deleted']=='1'){ ?>
            <a href="#" onclick="loadPopup('fax_errors.php?id=<?php echo $myarray['id'];?>');return false;">
                Deleted
            </a>
        <?php }elseif($myarray['sfax_status']=='2' && $myarray['sfax_status'] == '2' && $myarray['viewed']=='0'){ ?>
            <a href="edit_letter.php?pid=<?php echo $myarray['patientid'];?>&lid=<?php echo $myarray['letterid']; ?>">
                Fail (click to view)
            </a>
        <?php }elseif($myarray['sfax_status']=='2'){ ?>
            <a href="#" onclick="loadPopup('fax_errors.php?id=<?php echo $myarray['id'];?>');return false;">
                Fail
            </a>
        <?php } ?>
		</td>
    </tr>
    <?php }
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
<?php include "includes/bottom.htm";?>
