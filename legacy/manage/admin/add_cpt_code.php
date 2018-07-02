<?php
namespace Ds3\Libraries\Legacy;

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["mult_cpt_codesub"]) && $_POST["mult_cpt_codesub"] == 1) {
    $op_arr = explode("\n",trim($_POST['cpt_code']));

    foreach($op_arr as $i=>$val) {
        if($val != '') {
            $sel_check = "select * from dental_cpt_code where cpt_code = '".s_for($val)."'";
            $query_check=mysqli_query($con,$sel_check);
            if(mysqli_num_rows($query_check) == 0) {
                $ins_sql = "insert into dental_cpt_code set cpt_code = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
                mysqli_query($con,$ins_sql);
            }
        }
    }
    $msg = "Added Successfully";
    ?>
    <script type="text/javascript">
        parent.window.location='manage_cpt_code.php?msg=<?php echo $msg;?>';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

if(!empty($_POST["cpt_codesub"]) && $_POST["cpt_codesub"] == 1) {
    $sel_check = "select * from dental_cpt_code where cpt_code = '".s_for($_POST["cpt_code"])."' and cpt_codeid != '".s_for($_POST['ed'])."'";
    $query_check=mysqli_query($con,$sel_check);
    if(mysqli_num_rows($query_check)>0) {
        $msg="CPT Code already exist. So please give another CPT Code.";
        ?>
        <script type="text/javascript">
            alert("<?php echo $msg;?>");
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
            $ed_sql = "update dental_cpt_code set cpt_code = '".s_for($_POST["cpt_code"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where cpt_codeid='".$_POST["ed"]."'";
            mysqli_query($con,$ed_sql);
            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_cpt_code.php?msg=<?php echo $msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ins_sql = "insert into dental_cpt_code set cpt_code = '".s_for($_POST["cpt_code"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
            mysqli_query($con,$ins_sql);
            $msg = "Added Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_cpt_code.php?msg=<?php echo $msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}
?>
<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
$thesql = "select * from dental_cpt_code where cpt_codeid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);

if(!empty($msg)) {
    $cpt_code = $_POST['cpt_code'];
    $sortby = $_POST['sortby'];
    $status = $_POST['status'];
    $description = $_POST['description'];
} else {
    $cpt_code = st($themyarray['cpt_code']);
    $sortby = st($themyarray['sortby']);
    $status = st($themyarray['status']);
    $description = st($themyarray['description']);
}

if($themyarray["cpt_codeid"] != '') {
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
<?php }?>
<form name="cpt_codefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return cpt_codeabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> CPT Code 
               <?php if($cpt_code != "") {?>
                   &quot;<?php echo $cpt_code;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                CPT Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="cpt_code" value="<?php echo $cpt_code?>" class="form-control" /> 
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?php echo $sortby;?>" class="form-control" style="width:30px"/>
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
                <textarea class="form-control" name="description" style="width:100%;"><?php echo $description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields
                </span><br />
                <input type="hidden" name="cpt_codesub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["cpt_codeid"]?>" />
                <input type="submit" value="<?php echo $but_text?> CPT Code" class="btn btn-primary">
                <?php if($themyarray["cpt_codeid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_cpt_code.php?delid=<?php echo $themyarray["cpt_codeid"];?>" onclick="return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
            </td>
        </tr>
    </table>
</form>
<?php if(empty($_GET['ed'])) {?>
    <div class="alert alert-danger text-center">
        <b>--------------------------------- OR ---------------------------------</b>
    </div>
    <form name="cpt_codefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return cpt_codeabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple CPT Code 
                   <span class="red">
                       (Type Each New CPT Code on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="cpt_code" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields
                    </span><br />
                    <input type="hidden" name="mult_cpt_codesub" value="1" />
                    <input type="submit" value="Add Multiple CPT Code" class="btn btn-primary">
                </td>
            </tr>
        </table>
    </form>
<?php }?>
</body>
</html>
