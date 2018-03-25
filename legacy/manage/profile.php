<?php namespace Ds3\Libraries\Legacy; ?><?php
    include 'includes/top.htm';

    if(isset($_POST["profilesub"]) && $_POST["profilesub"] == 1) {
        $ed_sql = "update dental_users set name = '".s_for($_POST["name"])."', email = '".s_for($_POST["email"])."', address = '".s_for($_POST["address"])."', phone = '".s_for($_POST["phone"])."' where userid='".$_POST["ed"]."'";
        
        $db->query($ed_sql);
        $msg = "Edited Successfully";
?>
        <script type="text/javascript">
            window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>";
        </script>
<?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $thesql = "select * from dental_users where userid='".$_SESSION["userid"]."'";

    $themyarray = $db->getRow($thesql);
    if(isset($msg) && $msg != '') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
    } else {
        $username = st($themyarray['username']);
        $password = st($themyarray['password']);
        $name = st($themyarray['name']);
        $email = st($themyarray['email']);
        $address = st($themyarray['address']);
        $phone = st($themyarray['phone']);
        $but_text = "Add ";
    }

    if($themyarray["userid"] != '') {
        $but_text = "Edit ";
    } else {
        $but_text = "Add ";
    }
?>

    <br />
    <span class="admin_head">
        Profile
    </span>
    <br /><br />

    <?php if(isset($_GET['msg']) && $_GET['msg'] != '') { ?>
        <div align="center" class="red">
            <b><?php echo $_GET['msg'];?></b>
        </div>
    <?php } ?>
    <form name="profilefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return profileabc(this)">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">  
            <tr bgcolor="#FFFFFF" width="30%">
                <td valign="top" class="frmhead">
                    Username
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="username" value="<?php echo $username?>" class="tbox" <?php if($themyarray['userid'] <> '') echo " readonly"; ?>  /> 
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Password
                </td>
                <td valign="top" class="frmdata">
                    <a href="Javascript:;" onClick="Javascript: window.open('change_password.php','Change Password','top=100,left=100,width=500,height=275,scrollbars=yes,directories=no,location=no,toolbar=no')" class="formtext">
                        <b>CHANGE PASSWORD</b></a>
                    <input type="hidden" name="password" value="<?php echo $themyarray['password']?>" class="tbox_2" /> 
                    <input type="hidden" name="con_password" value="<?php echo $themyarray['password']?>" class="tbox_2" /> 
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Name
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="name" value="<?php echo $name?>" class="tbox" /> 
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Email
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="email" value="<?php echo $email?>" class="tbox" /> 
                    <span class="red">*</span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Address
                </td>
                <td valign="top" class="frmdata">
                    <textarea name="address" class="tbox"><?php echo $address;?></textarea>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Phone
                </td>
                <td valign="top" class="frmdata">
                    <input type="text" name="phone" value="<?php echo $phone;?>" class="tbox" /> 
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <span class="red">
                        * Required Fields                   
                    </span><br />
                    <input type="hidden" name="profilesub" value="1" />
                    <input type="hidden" name="ed" value="<?php echo $themyarray["userid"]?>" />
                    <input type="submit" value=" <?php echo $but_text?> Profile " class="button" />
                </td>
            </tr>
        </table>
    </form>

    <br /><br />
<?php include 'includes/bottom.htm';?>
