<?php
namespace Ds3\Libraries\Legacy;

session_start();

require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["mult_screeningsub"] == 1) {
    $op_arr = explode("\n",trim($_POST['screening']));

    foreach($op_arr as $i=>$val) {
        if($val != '') {
            $sel_check = "select * from dental_screening where screening = '".s_for($val)."'";
            $query_check=mysqli_query($con, $sel_check);

            if(mysqli_num_rows($query_check) == 0) {
                $ins_sql = "insert into dental_screening set screening = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
                mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
            }
        }
    }
    $msg = "Added Successfully";
    ?>
    <script type="text/javascript">
        parent.window.location='manage_screening.php?msg=<?=$msg;?>';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

if($_POST["screeningsub"] == 1) {
    $sel_check = "select * from dental_screening where screening = '".s_for($_POST["screening"])."' and screeningid != '".s_for($_POST['ed'])."'";
    $query_check=mysqli_query($con, $sel_check);

    if(mysqli_num_rows($query_check)>0) {
        $msg="Screening already exist. So please give another Screening.";
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
            $ed_sql = "update dental_screening set screening = '".s_for($_POST["screening"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where screeningid='".$_POST["ed"]."'";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_screening.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ins_sql = "insert into dental_screening set screening = '".s_for($_POST["screening"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
            mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);

            $msg = "Added Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_screening.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
$thesql = "select * from dental_screening where screeningid='".$_REQUEST["ed"]."'";
$themy = mysqli_query($con, $thesql);
$themyarray = mysqli_fetch_array($themy);

if($msg != '') {
    $screening = $_POST['screening'];
    $sortby = $_POST['sortby'];
    $status = $_POST['status'];
    $description = $_POST['description'];
} else {
    $screening = st($themyarray['screening']);
    $sortby = st($themyarray['sortby']);
    $status = st($themyarray['status']);
    $description = st($themyarray['description']);
}

if($themyarray["screeningid"] != '') {
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
<?php }?>
<form name="screeningfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return screeningabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Screening 
               <?php if($screening != "") {?>
                   &quot;<?=$screening;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Screening
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="screening" value="<?=$screening?>" class="form-control" /> 
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
                    <option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                    <option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
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
                <input type="hidden" name="screeningsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["screeningid"]?>" />
                <input type="submit" value="<?=$but_text?> Screening" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>

<?php if($_GET['ed'] == '') {?>
    <div class="alert alert-danger text-center">
        <b>--------------------------------- OR ---------------------------------</b>
    </div>
    <form name="screeningfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return screeningabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Screening 
                   <span class="red">
                       (Type Each New Screening on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="screening" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields
                    </span><br />
                    <input type="hidden" name="mult_screeningsub" value="1" />
                    <input type="submit" value="Add Multiple Screening" class="btn btn-primary">
                </td>
            </tr>
        </table>
    </form>
<?php }?>
</body>
</html>
