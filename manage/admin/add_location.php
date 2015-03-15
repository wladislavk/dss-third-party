<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>

<script type="text/javascript" src="../js/masks.js"></script> 
<?php
if(!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1)
{

	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_locations set 
				location = '".mysqli_real_escape_string($con,$_POST["location"])."', 
				name = '".mysqli_real_escape_string($con,$_POST["name"])."',
				address = '".mysqli_real_escape_string($con,$_POST["address"])."',
                                city = '".mysqli_real_escape_string($con,$_POST["city"])."',
                                state = '".mysqli_real_escape_string($con,$_POST["state"])."',
                                zip = '".mysqli_real_escape_string($con,$_POST["zip"])."',
                                phone = '".mysqli_real_escape_string($con,num($_POST["phone"]))."',
				fax = '".mysqli_real_escape_string($con,num($_POST["fax"]))."'
				where id='".$_POST["ed"]."'";
		mysqli_query($con,$ed_sql);

		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_locations.php?docid=<?php echo  $_POST['docid']; ?>&msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
	else
	{
	
		$ins_sql = "insert into dental_locations set location = '".s_for($_POST["location"])."',
                                name = '".mysqli_real_escape_string($con,$_POST["name"])."',
                                address = '".mysqli_real_escape_string($con,$_POST["address"])."',
                                city = '".mysqli_real_escape_string($con,$_POST["city"])."',
                                state = '".mysqli_real_escape_string($con,$_POST["state"])."',
                                zip = '".mysqli_real_escape_string($con,$_POST["zip"])."',
                                phone = '".mysqli_real_escape_string($con,num($_POST["phone"]))."',
                                fax = '".mysqli_real_escape_string($con,num($_POST["fax"]))."',
				 docid='".$_POST['docid']."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysqli_query($con,$ins_sql);
		
		$msg = "Added Successfully";
		
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_locations.php?docid=<?php echo  $_POST['docid']; ?>&msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	}
}
?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_locations where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$location = $_POST['location'];
		$name = $_POST['name'];
		$address = $_POST['address'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $zip = $_POST['zip'];
                $phone = $_POST['phone'];
		$fax = $_POST['fax'];
	}
	else
	{
		$location = st($themyarray['location']);
		$name = st($themyarray['name']);
		$address = st($themyarray['address']);
                $city = st($themyarray['city']);
                $state = st($themyarray['state']);
                $zip = st($themyarray['zip']);
                $phone = st($themyarray['phone']);
		$fax = st($themyarray['fax']);
		$but_text = "Add ";
	}
	
	if($themyarray["id"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
    <div class="col-md-6 col-md-offset-3">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                <?php echo $but_text?> <?php echo (!empty($_GET['heading']) ? $_GET['heading'] : ''); ?> Location 
                <? if($location <> "") {?>
                    &quot;<?php echo $location;?>&quot;
                <? }?>
            </h1>
        </div>
        <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return locationabc(this)" class="form-horizontal">
            <div class="page-header">
                <strong>Name</strong>
            </div>
            <div class="form-group">
                <label for="location" class="col-md-3 control-label">Practice Location</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Practice Location" value="<?php echo  $location ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">Doctor Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Doctor Name" value="<?php echo  $name ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Address</strong>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?php echo  $address ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?php echo  $city ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?php echo  $state ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code" value="<?php echo  $zip ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Contact Information</strong>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" value="<?php echo  $phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax number" value="<?php echo  $fax ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="contactsub" value="1">
                    <input type="hidden" name="docid" value="<?php echo  $_GET['docid']; ?>">
                    <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>">
                    <input type="submit" value="<?php echo $but_text?> Location" class="btn btn-primary">
                    <?php  if($themyarray["id"] != ''){ ?>
                    <a class="btn btn-danger pull-right" href="javascript:parent.window.location='manage_locations.php?delid=<?php echo $themyarray["id"];?>&docid=<?php echo $_GET['docid']?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" title="DELETE">
                        Delete
                    </a>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
