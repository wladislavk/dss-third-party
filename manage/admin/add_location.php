<?php 
session_start();
require_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>

<script type="text/javascript" src="../js/masks.js"></script> 
<?php
if($_POST["contactsub"] == 1)
{

	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_locations set 
				location = '".mysql_real_escape_string($_POST["location"])."', 
				name = '".mysql_real_escape_string($_POST["name"])."',
				address = '".mysql_real_escape_string($_POST["address"])."',
                                city = '".mysql_real_escape_string($_POST["city"])."',
                                state = '".mysql_real_escape_string($_POST["state"])."',
                                zip = '".mysql_real_escape_string($_POST["zip"])."',
                                phone = '".mysql_real_escape_string(num($_POST["phone"]))."',
				fax = '".mysql_real_escape_string(num($_POST["fax"]))."'
				where id='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_locations.php?docid=<?= $_POST['docid']; ?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
	
		$ins_sql = "insert into dental_locations set location = '".s_for($_POST["location"])."',
                                name = '".mysql_real_escape_string($_POST["name"])."',
                                address = '".mysql_real_escape_string($_POST["address"])."',
                                city = '".mysql_real_escape_string($_POST["city"])."',
                                state = '".mysql_real_escape_string($_POST["state"])."',
                                zip = '".mysql_real_escape_string($_POST["zip"])."',
                                phone = '".mysql_real_escape_string(num($_POST["phone"]))."',
                                fax = '".mysql_real_escape_string(num($_POST["fax"]))."',
				 docid='".$_POST['docid']."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_locations.php?docid=<?= $_POST['docid']; ?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}
?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_locations where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
            <strong><?= $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if ($msg != '') { ?>
        <div class="alert alert-success text-center">
            <?= $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                <?=$but_text?> <?php echo $_GET['heading']; ?> Location 
                <? if($location <> "") {?>
                    &quot;<?=$location;?>&quot;
                <? }?>
            </h1>
        </div>
        <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return locationabc(this)" class="form-horizontal">
            <div class="page-header">
                <strong>Name</strong>
            </div>
            <div class="form-group">
                <label for="location" class="col-md-3 control-label">Practice Location</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Practice Location" value="<?= $location ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">Doctor Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Doctor Name" value="<?= $name ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Address</strong>
            </div>
            <div class="form-group">
                <label for="address" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="<?= $address ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-md-3 control-label">City</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="city" id="city" placeholder="City" value="<?= $city ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="state" class="col-md-3 control-label">State</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="state" id="state" placeholder="State" value="<?= $state ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="zip" class="col-md-3 control-label">Zip/Postal Code</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip/Postal Code" value="<?= $zip ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Contact Information</strong>
            </div>
            <div class="form-group">
                <label for="phone" class="col-md-3 control-label">Phone</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" value="<?= $phone ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax number" value="<?= $fax ?>">
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="contactsub" value="1">
                    <input type="hidden" name="docid" value="<?= $_GET['docid']; ?>">
                    <input type="hidden" name="ed" value="<?=$themyarray["id"]?>">
                    <input type="submit" value="<?=$but_text?> Location" class="btn btn-primary">
                    <?php  if($themyarray["id"] != ''){ ?>
                    <a class="btn btn-danger pull-right" href="javascript:parent.window.location='manage_locations.php?delid=<?=$themyarray["id"];?>&docid=<?=$_GET['docid']?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" title="DELETE">
                        Delete
                    </a>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
