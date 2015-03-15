<?php namespace Ds3\Legacy; ?><?php
    if(!isset($_GET['print'])){
        include "includes/top.htm";
    }else{
?>
        <html>
            <body>
<?php
            include_once('admin/includes/main_include.php');
            include("includes/sescheck.php");
            include_once('includes/constants.inc');
            include_once('admin/includes/access.php');
    }
?>

    <link rel="stylesheet" href="css/ledger.css" />

<?php
    if(!empty($_REQUEST['dailysub']) && $_REQUEST['dailysub'] != 1 && !empty($_REQUEST['monthlysub']) && $_REQUEST['monthlysub'] != 1 && !empty($_REQUEST['weeklysub']) && $_REQUEST['weeklysub'] != 1 && !empty($_REQUEST['rangesub']) && $_REQUEST['rangesub'] != 1 && empty($_GET['pid'])) { ?>
    	<script type="text/javascript">
    		window.location = 'ledger.php';
    	</script>
	<?php
	   die();
    }

    if(!isset($_REQUEST['sort'])){
        $_REQUEST['sort'] = 'service_date';
        $_REQUEST['sortdir'] = 'asc';
    }

    if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date'])){
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
    }elseif(!empty($_REQUEST['dailysub'])){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy'])); 
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
    }elseif(!empty($_REQUEST['weeklysub'])){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd'], $_REQUEST['d_yy']));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['d_mm'], $_REQUEST['d_dd']+6, $_REQUEST['d_yy']));
    }elseif(!empty($_REQUEST['monthlysub'])){
        $start_date = date('Y-m-01', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
        $end_date = date('Y-m-t', mktime(0, 0, 0, $_REQUEST['d_mm'], 1, $_REQUEST['d_yy']));
    }elseif(!empty($_REQUEST['rangesub'])){
        $start_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['s_d_mm'], $_REQUEST['s_d_dd'], $_REQUEST['s_d_yy']));
        $end_date = date('Y-m-d', mktime(0, 0, 0, $_REQUEST['e_d_mm'], $_REQUEST['e_d_dd'], $_REQUEST['e_d_yy']));
    }else{
        $start_date = false;
        $end_date = false;
    }

    $rec_disp = 200;

    if(!empty($_REQUEST["page"])) {
    	$index_val = $_REQUEST["page"];
    } else {
    	$index_val = 0;
    }
    	
    $i_val = $index_val * $rec_disp;

    if(isset($_GET['pid'])){
        $sql = "select * from dental_ledger where patientid='".$_GET['pid']."' "; 
    }else{
        $sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' ";
    }

    $sql .= " order by service_date";

    $total_rec = $db->getNumberRows($sql);
    $no_pages = $total_rec/$rec_disp;

    $sql .= " limit ".$i_val.",".$rec_disp.";";
    $my = $db->getResults($sql);
    $num_users = count($my);
?>

    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>

    <span class="admin_head">
    	Ledger Report
            <?php if(!empty($_REQUEST['dailysub']) && $_REQUEST['dailysub'] == 1) { ?>
                (<i><?php echo  date('m-d-Y', strtotime($start_date)); ?></i>)
            <?php }
                if(!empty($_REQUEST['weeklysub']) && $_REQUEST['weeklysub'] == 1 || !empty($_REQUEST['rangesub']) && $_REQUEST['rangesub'] == 1) { 
            ?>
                    (<i><?php echo  date('m-d-Y', strtotime($start_date))?> - <?php echo  date('m-d-Y', strtotime($end_date))?></i>)
            <?php }
                if(!empty($_REQUEST['monthlysub']) && $_REQUEST['monthlysub'] == 1) {
            ?>
                    (<i><?php echo  date('m-Y', strtotime($start_date)) ?></i>)
            <?php }
                if(!empty($_GET['pid'])) {
            ?>
                    (<i><?php echo $thename;?></i>)
            <?php } ?>
     - Producer	
    </span>
    <div>
        &nbsp;&nbsp;
        <a href="ledger.php" class="editlink" title="EDIT">
	       <b>&lt;&lt;Back</b></a>
    </div>
    <br />

    <link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />

    <div align="right">
        <button onclick="Javascript: window.location='ledger_producer_report.php?print=1&dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>';" class="addButton">
            Print
        </button>
        &nbsp;&nbsp;
    </div>

    <br />

    <div align="center" class="red">
    	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <?php
        $p_sql = "SELECT * FROM dental_users WHERE
    		    (userid='".$_SESSION['docid']."' OR
    		    (docid='".$_SESSION['docid']."' AND
    			producer=1))";

        $p_q = $db->getResults($p_sql);
        if ($p_q) foreach ($p_q as $producer) {
            include 'ledger_producer_table.php'; 
        }
    ?>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose">
        <button>X</button>
    </a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>

<div id="backgroundPopup"></div>

<br /><br />
	
<?php
    if(!isset($_GET['print'])){
        include "includes/bottom.htm";
    }
?>
