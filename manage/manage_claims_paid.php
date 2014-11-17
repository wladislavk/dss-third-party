<?php 
    include "includes/top.htm";
    include_once "includes/constants.inc";
    
    if(!isset($_GET['sort1'])){
        $_GET['sort1']='oldest';
        $_GET['dir1']='ASC';
    }

    if(!isset($_GET['sort2'])){
        $_GET['sort2']='adddate';
        $_GET['dir2']='ASC';
    }

    if(!isset($_GET['filter'])){
        $_GET['filter']=100;
    }

    if(isset($_REQUEST["vid"]))
    {
            $del_sql = "UPDATE dental_insurance SET fo_paid_viewed=1 where insuranceid='".$_REQUEST["claimid"]."'";
        
            $db->query($del_sql);
            $msg = "Claim marked viewed";
?>
            <script type="text/javascript">
                window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
            </script>
<?php
            die();
    }

    $pend_sql = "select i.*, p.firstname, p.lastname,
                (SELECT SUM(amount) FROM dental_ledger WHERE primary_claim_id = i.insuranceid) billed,
                (SELECT SUM(p.amount) FROM dental_ledger_payment p JOIN dental_ledger dl ON p.ledgerid=dl.ledgerid WHERE dl.primary_claim_id = i.insuranceid) paid,
                (SELECT e.adddate FROM dental_claim_electronic e WHERE e.claimid=i.insuranceid ORDER by e.adddate DESC LIMIT 1) electronic_adddate
                from dental_insurance i left join dental_patients p on i.patientid=p.patientid 
                where i.docid='".$_SESSION['docid']."' ";
    if(isset($_GET['paid_viewed'])){ 
        $pend_sql .= " AND fo_paid_viewed=0 ";
    }
    $pend_sql .= " AND (i.status IN (".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.", ".DSS_CLAIM_PAID_SEC_PATIENT."))" ;
    if(isset($_GET['sort2'])){
        if($_GET['sort2']=='patient'){
            $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
        }else{
            $sort = $_GET['sort2']." ".$_GET['dir2'];
        }
    }
    $pend_sql .= " ORDER BY " . mysqli_real_escape_string($con,$sort);

    $pend_my = $db->getResults($pend_sql);
?>

    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>

    <span class="admin_head">
        Paid Claims 
    </span>
    <br />
    &nbsp;&nbsp;
    <div style="float: right; margin-right: 20px;">
        <?php if(!isset($_GET['paid_viewed'])){ ?>
            <a href="manage_claims_paid.php?paid_viewed=0" class="addButton">Show Not-Yet Viewed</a>
        <?php }
            if(isset($_GET['paid_viewed'])){ ?>
                <a href="manage_claims_paid.php" class="addButton">Show All</a>
        <?php } ?>
    </div>
    <br />
    <?php
        if(isset($_GET['msg'])){
    ?>
            <div align="center" class="red">
                <b><?php echo $_GET['msg'];?></b>
            </div>
    <?php
        } 
    ?>
    <table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
            <td valign="top" class="col_head <?php echo  ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
                <a href="?filter=<?php echo  $_GET['filter']; ?>&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?php echo  ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
            </td>
            <td valign="top" class="col_head <?php echo  ($_GET['sort2'] == 'billed')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                <a href="?filter=<?php echo  $_GET['filter']; ?>&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=billed&dir2=<?php echo  ($_GET['sort2']=='billed' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Billed Amount</a>
            </td>
            <td valign="top" class="col_head <?php echo  ($_GET['sort2'] == 'paid')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                <a href="?filter=<?php echo  $_GET['filter']; ?>&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=paid&dir2=<?php echo  ($_GET['sort2']=='paid' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Amount Paid</a>
            </td>
            <td valign="top" class="col_head <?php echo  ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                <a href="?filter=<?php echo  $_GET['filter']; ?>&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=patient&dir2=<?php echo  ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
            </td>
            <td valign="top" class="col_head <?php echo  ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                <a href="?filter=<?php echo  $_GET['filter']; ?>&sort1=<?php echo  $_GET['sort1']; ?>&dir1=<?php echo $_GET['dir1']; ?>&sort2=status&dir2=<?php echo  ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
            </td>
            <td valign="top" class="col_head" width="20%">
                Action
            </td>
        </tr>
        <?php if(count($pend_my) == 0) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
        <?php } else {
                foreach ($pend_my as $pend_myarray) {
                    if(!isset($pend_myarray["fo_paid_viewed"]) || $pend_myarray["fo_paid_viewed"] != 1) {
                        $tr_class = "unviewed";
                    } else {
                        $tr_class = "";
                    }
        ?>
                    <tr class="<?php echo $tr_class;?> status_<?php echo  $pend_myarray['status']; ?> claim">
                        <td valign="top">
                            <?php echo date('m-d-Y H:i',strtotime((($pend_myarray["electronic_adddate"]!='')?$pend_myarray["electronic_adddate"]:$pend_myarray["adddate"])));?>
                        </td>
                        <td valign="top">
                            $<?php echo  number_format($pend_myarray['billed'],2); ?>
                        </td>
                        <td valign="top">
                            $<?php echo  number_format($pend_myarray['paid'],2); ?>
                        </td>
                        <td valign="top">
                            <?php echo  $pend_myarray['firstname'].' '.$pend_myarray['lastname']; ?>
                        </td>
                        <td valign="top">
                            <?php echo $dss_claim_status_labels[$pend_myarray['status']];?>
                        </td>
                        <td valign="top">
                            <?php if(!isset($pend_myarray["fo_paid_viewed"]) || $pend_myarray["fo_paid_viewed"] != 1) { ?>
                                <a href="manage_claims_paid.php?claimid=<?php echo $pend_myarray["insuranceid"];?>&pid=<?php echo  $pend_myarray['patientid']; ?>&vid=1" class="editlink" title="Mark Viewed">
                                    Mark Viewed 
                                </a>
                               |
                            <?php } ?>
                            <a href="view_claim.php?claimid=<?php echo $pend_myarray["insuranceid"];?>&pid=<?php echo  $pend_myarray['patientid']; ?>" class="editlink" title="View">
                                View 
                            </a>
                        </td>
                    </tr>
        <?php
                }
            }
        ?>
    </table>
    <br /><br /><br />

    <script type="text/javascript">
        var filter = "<?php echo  $_GET['filter']; ?>";
        var DSS_CLAIM_PENDING = '<?php echo  DSS_CLAIM_PENDING; ?>';
        var DSS_CLAIM_SEC_PENDING = '<?php echo  DSS_CLAIM_SEC_PENDING; ?>';
        var DSS_CLAIM_PAID_INSURANCE = '<?php echo  DSS_CLAIM_PAID_INSURANCE; ?>';
        var DSS_CLAIM_PAID_SEC_INSURANCE = '<?php echo  DSS_CLAIM_PAID_SEC_INSURANCE; ?>';
        var DSS_CLAIM_PAID_PATIENT = '<?php echo  DSS_CLAIM_PAID_PATIENT; ?>';
        var DSS_CLAIM_SENT = '<?php echo  DSS_CLAIM_SENT; ?>';
        var DSS_CLAIM_SEC_SENT = '<?php echo  DSS_CLAIM_SEC_SENT; ?>';
        var DSS_CLAIM_DISPUTE = '<?php echo  DSS_CLAIM_DISPUTE; ?>';
        var DSS_CLAIM_SEC_DISPUTE = '<?php echo  DSS_CLAIM_SEC_DISPUTE; ?>';
        var DSS_CLAIM_REJECTED = '<?php echo  DSS_CLAIM_REJECTED; ?>';
    </script>

    <script type="text/javascript" src="/manage/js/manage_claims_paid.js"></script>

    <div id="popupContact" style="width:750px;">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>

    <div id="backgroundPopup"></div>

    <br /><br />

<?php include "includes/bottom.htm";?>