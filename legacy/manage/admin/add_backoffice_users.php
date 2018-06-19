<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/password.php';
require_once __DIR__ . '/../includes/constants.inc';
require_once __DIR__ . '/../includes/general_functions.php';
require_once __DIR__ . '/includes/access.php';

$userId = intval(isset($_POST['ed']) ? $_POST['ed'] : $_GET['ed']);
$userCompanyId = $db->getColumn("SELECT admin_company.companyid FROM admin
    LEFT JOIN admin_company USING(adminid) WHERE admin.adminid = '$userId'", 'companyid');

/**
 * BO users can be edited by:
 *
 * 1: Super admin - No restrictions
 * 2: Admin - Company scope
 * 3, 4, 6: Basic admin - Company scope
 * 5, 7: Base user - Self
 * is_super() || (is_software() && WITHIN COMPANY SCOPE)
 */
$isSuperAdmin = is_super($_SESSION['admin_access']);
$isAdmin = is_admin($_SESSION['admin_access']);
$isSoftwareAdmin = is_software($_SESSION['admin_access']);
$isCompanyAdmin = is_billing_admin($_SESSION['admin_access']) || is_hst_admin($_SESSION['admin_access']);

$isSameCompany = $_SESSION['admincompanyid'] == $userCompanyId;
$isSelfManaged = $_SESSION['adminuserid'] == $userId;

$canEdit = $isSuperAdmin ||
    ($isAdmin && $isSameCompany) ||
    ($isSoftwareAdmin && $isSelfManaged) ||
    ($isCompanyAdmin && $isSameCompany) ||
    $isSelfManaged;
$canCreate = $isSuperAdmin || $isAdmin || $isCompanyAdmin;
$canView = $isSuperAdmin || $isSameCompany || (!$userId && $canCreate);

/**
 * View FO users: super admin, or within company scope.
 * Add logic to allow authorized users to see the "new user" form
 */
if (!$canView) { ?>
    <script>
        alert('You are not authorized to access this page.');
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

if (!empty($_POST["usersub"]) && $_POST["usersub"] == 1) {
    $userId = intval($_POST['ed']);
    $userCompanyId = $db->getColumn("SELECT admin_company.companyid FROM admin
        LEFT JOIN admin_company USING(adminid) WHERE admin.adminid = '$userId'", 'companyid');

    $isSameCompany = $_SESSION['admincompanyid'] == $userCompanyId;
    $isSelfManaged = $_SESSION['adminuserid'] == $userId;

    $canEdit = $isSuperAdmin ||
        ($isAdmin && $isSameCompany) ||
        ($isSoftwareAdmin && $isSelfManaged) ||
        ($isCompanyAdmin && $isSameCompany) ||
        $isSelfManaged;

    if ($userId && !$canEdit) { ?>
        <script>
            alert('You are not authorized to edit this user.');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }
    if (!$userId && !$canCreate) { ?>
        <script>
            alert('You are not authorized to create new users.');
        </script>
        <?php
        trigger_error('Die called', E_USER_ERROR);
    }

	$sel_check = "select * from admin where username = '".s_for($_POST["username"])."' and adminid <> '".s_for($_POST['ed'])."'";
	$query_check = mysqli_query($con,$sel_check);
	$sel_check2 = "select * from admin where email = '".s_for($_POST["email"])."' and adminid <> '".s_for($_POST['ed'])."'";
	$query_check2 = mysqli_query($con,$sel_check2);

	if(mysqli_num_rows($query_check)>0) {
		$msg="Username already exist. So please give another Username.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="#add";
		</script>
		<?php
	} elseif (mysqli_num_rows($query_check2)>0) {
	    $msg="Email already exist. So please give another Email.";
	    ?>
        <script type="text/javascript">
                alert("<?php echo $msg;?>");
                window.location="#add";
        </script>
        <?php
    } else {
        if (
            empty($_POST['username']) ||
            empty($_POST['first_name']) ||
            empty($_POST['last_name']) ||
            empty($_POST['email']) ||
            empty($_POST['admin_access']) ||
            empty($_POST['status']) ||
            ($isSuperAdmin && empty($_POST['companyid']))
        ) { ?>
            <script>
                alert('Some required fields are missing');
                window.history.back();
            </script>
            <?php
            trigger_error('Die called', E_USER_ERROR);
        }

        // The smaller the admin_access, the greater the permission
        $admin_access = $_POST['admin_access'] < $_SESSION['admin_access'] ?
            $_SESSION['admin_access'] : $_POST['admin_access'];

		if($_POST["ed"] != "") {
			$ed_sql = "update admin set 
				first_name = '".$db->escape($_POST["first_name"])."',
				last_name = '".$db->escape($_POST["last_name"])."',
				username = '".$db->escape($_POST["username"])."',
				admin_access = '".$db->escape( $admin_access)."',
				email = '".$db->escape($_POST["email"])."', 
				status = '".$db->escape($_POST["status"])."' 
			where adminid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			if(is_super($_SESSION['admin_access'])){
			    mysqli_query($con,"DELETE FROM admin_company WHERE adminid='".$db->escape($_POST["ed"])."'");
			    mysqli_query($con,"INSERT INTO admin_company SET adminid='".$db->escape($_POST["ed"])."', companyid='".$db->escape($_POST["companyid"])."'");
			} else {
			    mysqli_query($con,"DELETE FROM admin_company WHERE adminid='".$db->escape($_POST["ed"])."'");
			    mysqli_query($con,"INSERT INTO admin_company SET adminid='".$db->escape($_POST["ed"])."', companyid='".$db->escape($_SESSION["companyid"])."'");
			}
			
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='manage_backoffice.php?msg=<?php echo $msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		} else {
            if (
                !strlen($_POST['password']) ||
                !strlen($_POST['password2']) ||
                $_POST['password'] !== $_POST['password2']
            ) { ?>
                <script>
                    alert('The password differs from its verification.');
                    window.history.back();
                </script>
                <?php
                trigger_error('Die called', E_USER_ERROR);
            }

			$salt = create_salt();
			$password = gen_password($_POST['password'], $salt);

			$ins_sql = "insert into admin set 
                                username = '".$db->escape($_POST["username"])."',
                                admin_access='".$db->escape($admin_access)."',
                                email = '".$db->escape($_POST["email"])."', 
                                status = '".$db->escape($_POST["status"])."', 
				password = '".$db->escape($password)."', 
				salt = '".$salt."',
                                first_name = '".$db->escape($_POST["first_name"])."',
                                last_name = '".$db->escape($_POST["last_name"])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql); 
			$adminid = mysqli_insert_id($con);

			if(is_super($_SESSION['admin_access'])){
			    mysqli_query($con,"INSERT INTO admin_company SET adminid='".$db->escape($adminid)."', companyid='".$db->escape($_POST["companyid"])."'");
			} else {
			    mysqli_query($con,"INSERT INTO admin_company SET adminid='".$db->escape($adminid)."', companyid='".$db->escape($_SESSION["admincompanyid"])."'");
			}
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='manage_backoffice.php?msg=<?php echo $msg;?>';
			</script>
			<?php
			trigger_error("Die called", E_USER_ERROR);
		}
	}
}

include_once dirname(__FILE__) . '/includes/popup_top.htm';

$thesql = "select a.*, ac.companyid from admin  a
    LEFT JOIN admin_company ac ON a.adminid = ac.adminid
    where a.adminid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg)) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$admin_access = $_POST['admin_access'];
		$status = $_POST['status'];
		$companyid = $_POST['companyid'];
	} else {
		$username = st($themyarray['username']);
		$password = st($themyarray['password']);
		$first_name = st($themyarray['first_name']);
		$last_name = st($themyarray['last_name']);
		$email = st($themyarray['email']);
		$status = st($themyarray['status']);
		$companyid = st($themyarray['companyid']);
		$admin_access = $themyarray['admin_access'];
	}
	
	if($themyarray["adminid"] != '') {
		$but_text = "Edit ";
	} else {
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Backoffice User 
               <? if($username <> "") {?>
               		&quot;<?php echo $username;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Username
            </td>
            <td valign="top" class="frmdata">
                <input id="username" type="text" name="username" value="<?php echo $username?>" class="form-control validate" /> 
                <span class="red">*</span>				
            </td>
        </tr>
	<?php if(!isset($_REQUEST['ed'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password" type="password" name="password" value="<?php echo $password;?>" class="form-control validate" />
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Re-type Password
            </td>
            <td valign="top" class="frmdata">
                <input id="password2" type="password" name="password2" value="<?php echo $password;?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
	<?php } ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                First Name
            </td>
            <td valign="top" class="frmdata">
                <input id="first_name" type="text" name="first_name" value="<?php echo $first_name;?>" class="form-control validate" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Last Name
            </td>
            <td valign="top" class="frmdata">
                <input id="last_name" type="text" name="last_name" value="<?php echo $last_name;?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Email
            </td>
            <td valign="top" class="frmdata">
                <input id="email" type="text" name="email" value="<?php echo $email;?>" class="form-control validate" /> 
                <span class="red">*</span>				
            </td>
        </tr>

        <?php if(is_super($_SESSION['admin_access'])){ ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
               Company
            </td>
            <td valign="top" class="frmdata">
                <select id="companyid" name="companyid" class="form-control validate" onchange="update_access()">
			<option value="">Select Company</option>
                        <?php
                        $c_sql = "SELECT * FROM companies ORDER BY name asc";
                        $c_q = mysqli_query($con,$c_sql);
                        while($c_r = mysqli_fetch_assoc($c_q)){ ?>
                                <option value="<?php echo  $c_r['id']; ?>" <?php echo  ($companyid == $c_r['id'])?'selected="selected"':''; ?>><?php echo  $c_r['name']; ?></option>
                        <?php } ?>
                </select>
            </td>
        </tr>
	<?php } ?>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Access Level
            </td>
            <td valign="top" class="frmdata">
                <select id="admin_access" name="admin_access" class="form-control validate">
                    <option value="">Select Access</option>
                    <?php if (is_super($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_SUPER ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_SUPER ? 'selected' : '' ?>>Super</option>
                    <?php } ?>
                    <?php if (is_admin($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_ADMIN ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_ADMIN ? 'selected' : '' ?>>Admin</option>
                    <?php } ?>
                    <?php if (is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_BASIC ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_BASIC ? 'selected' : '' ?>>Basic</option>
                    <?php } ?>
                    <?php if (is_super($_SESSION['admin_access']) || is_billing_admin($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_BILLING_ADMIN ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_BILLING_ADMIN ? 'selected' : '' ?>>Billing Admin</option>
                    <?php } ?>
                    <?php if (is_super($_SESSION['admin_access']) || is_billing($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_BILLING_BASIC ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_BILLING_BASIC ? 'selected' : '' ?>>Billing Basic</option>
                    <?php } ?>
                    <?php if (is_super($_SESSION['admin_access']) || is_hst_admin($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_HST_ADMIN ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_HST_ADMIN ? 'selected' : '' ?>>HST Admin</option>
                    <?php } ?>
                    <?php if (is_super($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])) { ?>
                        <option value="<?= DSS_ADMIN_ACCESS_HST_BASIC ?>"
                            <?= $admin_access == DSS_ADMIN_ACCESS_HST_BASIC ? 'selected' : '' ?>>HST Basic</option>
                    <?php } ?>
                </select>
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select name="status" class="form-control">
                    <option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                    <?php if (!is_basic($_SESSION['admin_access'])) { ?>
                        <option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="usersub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["adminid"]?>" />
                <input type="submit" value="<?php echo $but_text?> User" class="btn btn-primary">
                <?php if($themyarray["adminid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_backoffice.php?delid=<?php echo $themyarray["adminid"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>

<script type="text/javascript">
var selected_company = '';

function update_access () {
    var new_company = $('#companyid').val(),
        admin_access = $('#admin_access').val();

    $.ajax({
        url: "includes/update_access.php",
        type: "post",
        data: { oid: selected_company, nid:new_company, cur:admin_access },
        success: function(data){
            var r = $.parseJSON(data);

            selected_company = new_company;

            if (r.change) {
                $('#admin_access').html(r.change);
            } else {}
        },
        failure: function(data){}
    });
}

function check_add () {
    $('.validate').each(function(){
        if ($(this).val() == '') {
            alert('All fields are required.');
            return false;
        }
    });

    if ($('[name=password]').length && ($('[name=password]').val() !== $('[name=password2]').val())) {
        alert('The password must match its verification.');
        return false;
    }

    return true;
}

jQuery(function($){
    <?php if (($userId && !$canEdit) || (!$userId && !$canCreate)) { ?>
        $('form[name=userfrm]').find('input, select, button').prop('disabled', true);
    <?php } ?>
    update_access();
    selected_company = '<?php echo  $companyid; ?>';

    $('form[name=userfrm]').submit(function(event){
        return check_add();
    });
}(jQuery));
</script>

</body>
</html>
