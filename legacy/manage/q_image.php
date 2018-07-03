<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
require_once('includes/patient_info.php');

$db = new Db();

if ($patient_info) {
    if(!empty($_POST['q_recipientssub']) && $_POST['q_recipientssub'] == 1) {
        ?>
        <script type="text/javascript">
            window.location = '<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    if(!empty($_REQUEST["delid"])) {
        $del_sql = "delete from dental_q_image where imageid='".$_REQUEST["delid"]."'";
        $db->query($del_sql);
        ?>
        <script type="text/javascript">
            window.location = "<?php echo $_SERVER['PHP_SELF']?>?pid=<?php echo $_GET['pid'];?>&sh=<?php echo $_GET['sh'];?>";
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
    $pat_myarray = $db->getRow($pat_sql);

    if($pat_myarray['patientid'] == '') { ?>
        <script type="text/javascript">
            window.location = 'manage_patient.php';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    if (!isset($_REQUEST['sort'])) {
        $_REQUEST['sort'] = 'adddate';
    }

    if (!isset($_REQUEST['sortdir'])) {
        $_REQUEST['sortdir'] = 'DESC';
    }
    ?>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup2.js?v=20170326" type="text/javascript"></script>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <a name="top"></a>
    &nbsp;&nbsp;
    <b>Show Image Type</b>
    &nbsp;&nbsp;
    <?php
    $itype_sql = "select * from dental_imagetype where status=1 order by sortby";
    $itype_my = $db->getResults($itype_sql);
    ?>
    <select name="imagetypeid" class="field text addr tbox" onchange="window.location='<?php echo $_SERVER['PHP_SELF']?>?pid=<?php echo $_GET['pid'];?>&sh='+this.value;">
        <option value="">All</option>
        <?php foreach ($itype_my as $itype_myarray) { ?>
            <option value="<?php echo st($itype_myarray['imagetypeid']);?>" <?php if(!empty($_GET['sh']) && $_GET['sh'] == st($itype_myarray['imagetypeid'])) echo " selected";?>>
                <?php echo st($itype_myarray['imagetype']);?>
            </option>
        <?php } ?>
    </select>
    <br />
    <div align="right">
        <button onclick="loadPopupRefer('add_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>&sh=<?php echo (!empty($_GET['sh']) ? $_GET['sh'] : '');?>&flow=<?php echo (!empty($_GET['flow']) ? $_GET['flow'] : '');?>');" class="addButton">
            Add New Image
        </button>
        &nbsp;&nbsp;
    </div>
    <br />
    <div align="center" class="red">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <form name="q_imagefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '')?>&sh=<?php echo (!empty($_GET['sh']) ? $_GET['sh'] : '');?>" method="post" >
        <input type="hidden" name="q_recipientssub" value="1" />
        <input type="hidden" name="ed" value="<?php echo (!empty($q_recipientsid) ? $q_recipientsid : '');?>" />
        <input type="hidden" name="goto_p" value="<?php echo (!empty($cur_page) ? $cur_page : '')?>" />
        <?php include 'partials/patient_images.php'; ?>
    </form>
    <br />
    <div style="visibility:hidden;"><?php include("includes/form_bottom.htm");?></div>
    <br />
    <div id="popupMemo" style="width:750px;z-index:5000; position:absolute;height:400px;display:none;">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop_memo" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopup"></div>

    <div id="popupRefer" style="width:750px;height:430px">
        <a id="popupReferClose">
            <button>X</button>
        </a>
        <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>
    <div id="backgroundPopupRef"></div>

    <br /><br />
<?php
} else {  // end pt info check
    echo "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
}
?>
<?php include "includes/bottom.htm";?>
