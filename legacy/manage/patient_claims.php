<?php
namespace Ds3\Libraries\Legacy;

$db = new Db();

$sql = "select i.*,
        (SELECT count(*) FROM dental_claim_notes where claim_id=i.insuranceid) num_notes,
        (SELECT count(*) FROM dental_claim_notes where claim_id=i.insuranceid AND create_type='1') num_fo_notes 
    from dental_insurance i 
    where (i.status=".DSS_CLAIM_PENDING." OR i.status=".DSS_CLAIM_SEC_PENDING.") 
    AND i.docid='".(!empty($_SESSION['docid']) ? $_SESSION['docid'] : '')."' 
    and i.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' 
    order by i.adddate DESC";
$my = $db->getResults($sql);
?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
<?php 
if(!empty($total_rec) && $total_rec > $rec_disp) {?>
    <tr bgcolor="#ffffff">
        <td align="right" colspan="15" class="bp">
            Pages:
            <?php paging($no_pages, $index_val, "");?>
        </td>
    </tr>
    <?php
} ?>
<tr class="tr_bg_h">
    <td valign="top" class="col_head" width="60%">
        Date
    </td>
    <td valign="top" class="col_head" width="20%">
        Status
    </td>
    <td valign="top" class="col_head" width="20%">
        Action
    </td>
</tr>
<?php 
if (count($my) == 0) { ?>
    <tr class="tr_bg">
        <td valign="top" class="col_head" colspan="10" align="center">
            No Records
        </td>
    </tr>
    <?php
}else{
    foreach ($my as $myarray) {
        $tr_class = "tr_active"; ?>
        <tr class="<?php echo $tr_class;?>">
            <td valign="top">
                <?php echo date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
            </td>
            <td valign="top">
                <?php echo $dss_claim_status_labels[$myarray['status']];?>
            </td>
            <td valign="top">
                <a href="view_claim.php?claimid=<?php echo $myarray["insuranceid"];?>&pid=<?php echo $_GET['pid']; ?>" class="editlink" title="View Claim and Notes">
                    View <?php echo ($myarray['num_notes'] > 0)?"- Notes (".$myarray['num_notes'].")":''; ?>
                </a>
            </td>
        </tr>
    <?php
    }
} ?>
</table>
<?php
$sql = "select * from dental_insurance where status!=".DSS_CLAIM_PENDING." AND status!=".DSS_CLAIM_SEC_PENDING." AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate DESC";
$my = $db->getResults($sql);
?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <?php
    if(!empty($total_rec) && $total_rec > $rec_disp) {?>
        <tr bgcolor="#ffffff">
            <td align="right" colspan="15" class="bp">
              Pages:
              <?php paging($no_pages, $index_val, "");?>
            </td>
        </tr>
        <?php
    } ?>
    <tr class="tr_bg_h">
        <td valign="top" class="col_head" width="60%">
            Date
        </td>
        <td valign="top" class="col_head" width="20%">
            Status
        </td>
        <td valign="top" class="col_head" width="20%">
            Action
        </td>
    </tr>
    <?php
    if(count($my) == 0){ ?>
        <tr class="tr_bg">
            <td valign="top" class="col_head" colspan="10" align="center">
                No Records
            </td>
        </tr>
    <?php
    }else{
        foreach ($my as $myarray) {
            $tr_class = "tr_active";?>
            <tr class="<?php echo $tr_class;?>">
                <td valign="top">
                    <?php echo date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
                </td>
                <td valign="top">
                    <?php echo $dss_claim_status_labels[$myarray['status']];?>
                </td>
                <td valign="top">
                    <a href="view_claim.php?claimid=<?php echo $myarray["insuranceid"];?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="editlink" title="View Claim and Notes">
                        View
                    </a>
                </td>
            </tr>
            <?php
        }
    } ?>
</table>
