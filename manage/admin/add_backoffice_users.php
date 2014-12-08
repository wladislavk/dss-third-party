<?php 
    include_once('includes/main_include.php');
    include("includes/sescheck.php");
    include_once('includes/password.php');
    include_once('../includes/constants.inc');
    include_once '../includes/general_functions.php';
    include_once 'includes/access.php';
?>

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script><?php

if(!empty($_POST["usersub"]) && $_POST["usersub"] == 1)
{
	$sel_check = "select * from admin where username = '".s_for($_POST["username"])."' and adminid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
        $sel_check2 = "select * from admin where email = '".s_for($_POST["email"])."' and adminid <> '".s_for($_POST['ed'])."'";
        $query_check2=mysqli_query($con,$sel_check2);

	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Username already exist. So please give another Username.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	elseif(mysqli_num_rows($query_check2)>0)
        {
                $msg="Email already exist. So please give another Email.";
                ?>
                <script type="text/javascript">
                        alert("<?php echo $msg;?>");
                        window.location="#add";
                </script>
                <?
        }
        else
	{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update admin set 
				first_name = '".mysqli_real_escape_string($con,$_POST["first_name"])."',
				last_name = '".mysqli_real_escape_string($con,$_POST["last_name"])."',
				username = '".mysqli_real_escape_string($con,$_POST["username"])."',
				admin_access='".mysqli_real_escape_string($con,$_POST["admin_access"])."',
				email = '".mysqli_real_escape_string($con,$_POST["email"])."', 
				status = '".mysqli_real_escape_string($con,$_POST["status"])."' 
			where adminid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);
		
			if(is_super($_SESSION['admin_access'])){
                          mysqli_query($con,"DELETE FROM admin_company WHERE adminid='".mysqli_real_escape_string($con,$_POST["ed"])."'");
                          mysqli_query($con,"INSERT INTO admin_company SET adminid='".mysqli_real_escape_string($con,$_POST["ed"])."', companyid='".mysqli_real_escape_string($con,$_POST["companyid"])."'");
                        }elseif(is_super($_SESSION['admin_access'])){
                          mysqli_query($con,"DELETE FROM admin_company WHERE adminid='".mysqli_real_escape_string($con,$_POST["ed"])."'");
                          mysqli_query($con,"INSERT INTO admin_company SET adminid='".mysqli_real_escape_string($con,$_POST["ed"])."', companyid='".mysqli_real_escape_string($con,$_SESSION["companyid"])."'");
			}
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_backoffice.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{

			$salt = create_salt();
			$password = gen_password($_POST['password'], $salt);

			$ins_sql = "insert into admin set 
                                username = '".mysqli_real_escape_string($con,$_POST["username"])."',
                                admin_access='".mysqli_real_escape_string($con,$_POST["admin_access"])."',
                                email = '".mysqli_real_escape_string($con,$_POST["email"])."', 
                                status = '".mysqli_real_escape_string($con,$_POST["status"])."', 
				password = '".mysqli_real_escape_string($con,$password)."', 
				salt = '".$salt."',
                                first_name = '".mysqli_real_escape_string($con,$_POST["first_name"])."',
                                last_name = '".mysqli_real_escape_string($con,$_POST["last_name"])."',
				adddate=now(),
				ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql); 
                        $adminid = mysqli_insert_id($con);			

                        if(is_super($_SESSION['admin_access'])){
                          mysqli_query($con,"INSERT INTO admin_company SET adminid='".mysqli_real_escape_string($con,$adminid)."', companyid='".mysqli_real_escape_string($con,$_POST["companyid"])."'");
                        }else{
                          mysqli_query($con,"INSERT INTO admin_company SET adminid='".mysqli_real_escape_string($con,$adminid)."', companyid='".mysqli_real_escape_string($con,$_SESSION["admincompanyid"])."'");
                        }


			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_backoffice.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select a.*, ac.companyid from admin  a
		LEFT JOIN admin_company ac ON a.adminid = ac.adminid
		where a.adminid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$admin_access = $_POST['admin_access'];
		$status = $_POST['status'];
		$companyid = $_POST['companyid'];
	}
	else
	{
		$username = st($themyarray['username']);
		$password = st($themyarray['password']);
		$first_name = st($themyarray['first_name']);
                $last_name = st($themyarray['last_name']);
		$email = st($themyarray['email']);
		$status = st($themyarray['status']);
		$companyid = st($themyarray['companyid']);
		$admin_access = $themyarray['admin_access'];
		$but_text = "Add ";
	}
	
	if($themyarray["adminid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="userfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
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
			<?php if(is_super($_SESSION['admin_access'])){ ?>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_SUPER; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_SUPER) echo " selected";?>>Super</option>
			<?php } ?>
			<?php if(is_admin($_SESSION['admin_access'])){ ?>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_ADMIN; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_ADMIN) echo " selected";?>>Admin</option>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_BASIC; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_BASIC) echo " selected";?>>Basic</option>
                        <?php } ?>

			<?php if(is_super($_SESSION['admin_access']) || is_billing($_SESSION['admin_access'])){ ?>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_BILLING_ADMIN; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_BILLING_ADMIN) echo " selected";?>>Billing Admin</option>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_BILLING_BASIC; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_BILLING_BASIC) echo " selected";?>>Billing Basic</option>
			<?php } ?>
			<?php if(is_super($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])){ ?>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_HST_ADMIN; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_HST_ADMIN) echo " selected";?>>HST Admin</option>
                        <option value="<?php echo  DSS_ADMIN_ACCESS_HST_BASIC; ?>" <? if($admin_access == DSS_ADMIN_ACCESS_HST_BASIC) echo " selected";?>>HST Basic</option>
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
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
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
function update_access(){
  var new_company = $('#companyid').val();
  var admin_access = $('#admin_access').val();
                                  $.ajax({
                                        url: "includes/update_access.php",
                                        type: "post",
                                        data: {oid: selected_company, nid:new_company, cur:admin_access},
                                        success: function(data){
                                                var r = $.parseJSON(data);
						selected_company = new_company;
                                                if(r.change){
							$('#admin_access').html(r.change);	
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

}
$(document).ready(function(){
update_access();
selected_company = '<?php echo  $companyid; ?>';
});


function check_add(){
  $('.validate').each( function(){
    if($(this).val()==''){
      alert('All fields are required.');
      return false;
    }
  });
  return true;
}

</script>

</body>
</html>
