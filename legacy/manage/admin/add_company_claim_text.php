<?php
namespace Ds3\Libraries\Legacy;

include_once('includes/main_include.php');
include("includes/sescheck.php");

$db = new Db();

if(!empty($_POST["custom_textsub"]) && $_POST["custom_textsub"] == 1) {
    if($_POST["ed"] != "") {
        $ed_sql = "update dental_claim_text set 
        title = '".$db->escape($_POST["title"])."', 
        description = '".$db->escape($_POST["description"])."'
        where id='".$_POST["ed"]."'";
        mysqli_query($con,$ed_sql);

        $msg = "Edited Successfully";
        ?>
        <script type="text/javascript">
            parent.window.location='manage_company_claim_text.php?companyid=<?= $_GET['companyid']; ?>&msg=<?=$msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ins_sql = "insert into dental_claim_text set 
        title = '".$db->escape($_POST["title"])."',
        description = '".$db->escape($_POST["description"])."',
        adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', companyid=".$_GET['companyid'];
        mysqli_query($con,$ins_sql);

        $msg = "Added Successfully";
        ?>
        <script type="text/javascript">
            parent.window.location='manage_company_claim_text.php?companyid=<?= $_GET['companyid']; ?>&msg=<?=$msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
$thesql = "select * from dental_claim_text where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);

if(!empty($msg)) {
    $title = $_POST['title'];
    $description = $_POST['description'];
} else {
    $title = st($themyarray['title']);
    $description = st($themyarray['description']);
}

if($themyarray["id"] != '') {
    $but_text = "Edit ";
} else {
    $but_text = "Add ";
}
?>
<br /><br />
<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
<?php } ?>
<form name="transaction_codefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&companyid=<?= $_GET['companyid']; ?>" method="post">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Claim Text 
               <?php if($title <> "") {?>
                   &quot;<?=$title;?>&quot;
               <?php } ?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Title
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="title" value="<?=$title?>" class="form-control" /> 
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
                <textarea class="form-control" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="custom_textsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Claim Text" class="btn btn-primary">
                <?php if (!empty($themyarray["customid"]) && $_SESSION['admin_access'] == 1) { ?>
                    <a href="manage_company_claim_text.php?delid=<?=$themyarray["customid"];?>&docid=<?= $_GET['docid']; ?>" onclick="return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
            </td>
        </tr>
    </table>
</form>
</body>
</html>
