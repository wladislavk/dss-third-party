<?php
namespace Ds3\Libraries\Legacy;

session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["mult_qualifiersub"] == 1) {
    $op_arr = explode("\n",trim($_POST['qualifier']));

    foreach($op_arr as $i=>$val) {
        if($val != '') {
            $sel_check = "select * from dental_qualifier where qualifier = '".s_for($val)."'";
            $query_check=mysqli_query($con, $sel_check);

            if(mysqli_num_rows($query_check) == 0) {
                $ins_sql = "insert into dental_qualifier set qualifier = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
                mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
            }
        }
    }

    $msg = "Added Successfully";
    ?>
    <script type="text/javascript">
        parent.window.location='manage_qualifier.php?msg=<?=$msg;?>';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

if($_POST["qualifiersub"] == 1) {
    $sel_check = "select * from dental_qualifier where qualifier = '".s_for($_POST["qualifier"])."' and qualifierid != '".s_for($_POST['ed'])."'";
    $query_check=mysqli_query($con, $sel_check);

    if(mysqli_num_rows($query_check)>0) {
        $msg="Qualifier already exist. So please give another Qualifier.";
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
            $ed_sql = "update dental_qualifier set qualifier = '".s_for($_POST["qualifier"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where qualifierid='".$_POST["ed"]."'";
            mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);

            $msg = "Edited Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_qualifier.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ins_sql = "insert into dental_qualifier set qualifier = '".s_for($_POST["qualifier"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
            mysqli_query($con, $ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);

            $msg = "Added Successfully";
            ?>
            <script type="text/javascript">
                parent.window.location='manage_qualifier.php?msg=<?=$msg;?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        }
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<?php
$thesql = "select * from dental_qualifier where qualifierid='".$_REQUEST["ed"]."'";
$themy = mysqli_query($con, $thesql);
$themyarray = mysqli_fetch_array($themy);

if($msg != '') {
    $qualifier = $_POST['qualifier'];
    $sortby = $_POST['sortby'];
    $status = $_POST['status'];
    $description = $_POST['description'];
} else {
    $qualifier = st($themyarray['qualifier']);
    $sortby = st($themyarray['sortby']);
    $status = st($themyarray['status']);
    $description = st($themyarray['description']);
}

if($themyarray["qualifierid"] != '') {
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
<form name="qualifierfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return qualifierabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Qualifier 
               <?php if($qualifier != "") {?>
                   &quot;<?=$qualifier;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Qualifier
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="qualifier" value="<?=$qualifier?>" class="form-control" /> 
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
                <input type="hidden" name="qualifiersub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["qualifierid"]?>" />
                <input type="submit" value="<?=$but_text?> Qualifier" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
    
<?php if($_GET['ed'] == '') { ?>
    <div class="alert alert-danger text-center">
        <b>--------------------------------- OR ---------------------------------</b>
    </div>
    <form name="qualifierfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return qualifierabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Qualifier 
                   <span class="red">
                       (Type Each New Qualifier on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="qualifier" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields
                    </span><br />
                    <input type="hidden" name="mult_qualifiersub" value="1" />
                    <input type="submit" value="Add Multiple Qualifier" class="btn btn-primary">
                </td>
            </tr>
        </table>
    </form>
<?php }?>
</body>
</html>
