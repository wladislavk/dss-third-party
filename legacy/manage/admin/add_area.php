<?php
namespace Ds3\Libraries\Legacy;

session_start();

require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["areasub"] == 1) {
    $sel_check = "select * from spine_area where area = '".s_for($_POST["area"])."' and areaid != '".s_for($_POST['ed'])."'";
    $query_check=mysqli_query($con, $sel_check);

    if(mysqli_num_rows($query_check)>0) {
        $msg="Area already exist. So please give another Area.";
        ?>
        <script type="text/javascript">
            alert("<?=$msg;?>");
            window.location="#add";
        </script>
        <?php
    } else {
        if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false) {
            $sby = 999;
        } else {
            $sby = s_for($_POST["sortby"]);
        }

        if($_POST["ed"] != "") {
            $ed_sql = "update spine_area set area = '".s_for($_POST["area"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where areaid='".$_POST["ed"]."'";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_area.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ins_sql = "insert into spine_area set area = '".s_for($_POST["area"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
            mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);

            $msg = "Added Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_area.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<br />
<?php
$thesql = "select * from spine_area where areaid='".$_REQUEST["ed"]."'";
$themy = mysqli_query($con, $thesql);
$themyarray = mysqli_fetch_array($themy);

if ($msg != '') {
    $area = $_POST['area'];
    $sortby = $_POST['sortby'];
    $status = $_POST['status'];
    $description = $_POST['description'];
} else {
    $area = st($themyarray['area']);
    $sortby = st($themyarray['sortby']);
    $status = st($themyarray['status']);
    $description = st($themyarray['description']);
}

if($themyarray["areaid"] != '') {
    $but_text = "Edit ";
} else {
    $but_text = "Add ";
}
?>
<br /><br />
<?php if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
<?php } ?>
<form name="areafrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return areaabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Area 
               <?php if($area != "") {?>
                   &quot;<?=$area;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Area
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="area" value="<?=$area?>" class="form-control" /> 
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?=$sortby;?>" class="form-control" style="width:30px"/>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select name="status" class="form-control">
                    <option value="1" <?php if ($status == 1) echo " selected";?>>Active</option>
                    <option value="2" <?php if ($status == 2) echo " selected";?>>In-Active</option>
                </select>
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
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="areasub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["areaid"]?>" />
                <input type="submit" value="<?=$but_text?> Area" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
