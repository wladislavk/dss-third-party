<?php namespace Ds3\Legacy; ?><?php
include_once('includes/main_include.php');
include("includes/sescheck.php");
if(!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1)
{
    if($_POST["ed"] != "")
    {
        $ed_sql = "update dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."', status = '".s_for($_POST["status"])."' where contactid='".$_POST["ed"]."'";
        mysqli_query($con,$ed_sql);

        $msg = "Edited Successfully";
        ?>
        <script type="text/javascript">
            //alert("<?php echo $msg;?>");
	    <?php if($_POST['corp']=='1'){ ?>
              parent.window.location='manage_fcontact.php?msg=<?php echo $msg;?>';
	    <?php }else{ ?>
              parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
	    <?php } ?>
        </script>
        <?
        die();
    }
    else
    {
        $ins_sql = "insert into dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."',corporate='".s_for($_POST['corp'])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
        mysqli_query($con,$ins_sql);
        
        $msg = "Added Successfully";
        
        ?>
        <script type="text/javascript">
            //alert("<?php echo $msg;?>");
            <?php if($_POST['corp']=='1'){ ?>
              parent.window.location='manage_fcontact.php?msg=<?php echo $msg;?>';
            <?php }else{ ?>
              parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
            <?php } ?>
        </script>
        <?
        die();
    }
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_contact where contactid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
    $themy = mysqli_query($con,$thesql);
    $themyarray = mysqli_fetch_array($themy);
    
    if(!empty($msg))
    {
        $salutation = $_POST['salutation'];
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $lastname = $_POST['lastname'];
        $company = $_POST['company'];
        $add1 = $_POST['add1'];
        $add2= $_POST['add2'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $zip = $_POST['zip'];
        $phone1 = $_POST['phone1'];
        $phone2 = $_POST['phone2'];
        $fax = $_POST['fax'];
        $email = $_POST['email'];
        $national_provider_id = $_POST['national_provider_id'];
        $qualifier = $_POST['qualifier'];
        $qualifierid = $_POST['qualifierid'];
        $greeting = $_POST['greeting'];
        $sincerely = $_POST['sincerely'];
        $contacttypeid = $_POST['contacttypeid'];
        $notes = $_POST['notes'];
    }
    else
    {
        $salutation = st($themyarray['salutation']);
        $firstname = st($themyarray['firstname']);
        $middlename = st($themyarray['middlename']);
        $lastname = st($themyarray['lastname']);
        $company = st($themyarray['company']);
        $add1 = st($themyarray['add1']);
        $add2 = st($themyarray['add2']);
        $city = st($themyarray['city']);
        $state = st($themyarray['state']);
        $zip = st($themyarray['zip']);
        $phone1 = st($themyarray['phone1']);
        $phone2 = st($themyarray['phone2']);
        $fax = st($themyarray['fax']);
        $email = st($themyarray['email']);
        $national_provider_id = st($themyarray['national_provider_id']);
        $qualifier = st($themyarray['qualifier']);
        $qualifierid = st($themyarray['qualifierid']);
        $greeting = st($themyarray['greeting']);
        $sincerely = st($themyarray['sincerely']);
        $contacttypeid = st($themyarray['contacttypeid']);
        $notes = st($themyarray['notes']);
        
        $name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
        
        $but_text = "Add ";
    }
    
    if($themyarray["contactid"] != '')
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
                <?php echo  $but_text ?>
                <?php echo  (!empty($_GET['heading']) ? $_GET['heading'] : '') ?>
                Contact
                <?php if (trim($name) != "") { ?>
                    &quot;<?php echo $name;?>&quot;
                <?php } ?>
            </h1>
        </div>
        <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&amp;activePat=<?php echo (!empty($_GET['activePat']) ? $_GET['activePat'] : ''); ?>" method="post" onSubmit="return contactabc(this)" class="form-horizontal">
            <div class="form-group">
                <label for="contacttype" class="col-md-3 control-label">Contact Type</label>
                <div class="col-md-9">
                    <?

                    if(isset($_GET['ed'])){
    $ctype_sqlmy = "select * from dental_contact where contactid='".$_GET['ed']."' LIMIT 1;";
    $ctype_myquerymyarray = mysqli_query($con,$ctype_sqlmy);

    $ctid = mysqli_fetch_array($ctype_myquerymyarray);
   }

    $ctype_sql = "select * from dental_contacttype where status=1 ";
    if(!isset($_REQUEST['corp']) || $_REQUEST['corp'] != '1'){
        $ctype_sql .= " AND corporate='0' ";
    }
    $ctype_sql .= " order by sortby";
    $ctype_my = mysqli_query($con,$ctype_sql);
    ?>
                    <select id="contacttypeid" name="contacttypeid" class="form-control">

                        <? while($ctype_myarray = mysqli_fetch_array($ctype_my)){
      ?>

      <option <?php if(!empty($ctid['contacttypeid']) && $ctype_myarray['contacttypeid'] == $ctid['contacttypeid']){ echo " selected='selected'";} ?> <?php if(!empty($_GET['type']) && $ctype_myarray['contacttypeid'] == $_GET['type']){ echo " selected='selected'";} ?> <?php if(isset($_GET['ctypeeq']) && $ctype_myarray['contacttypeid'] == '11'){ echo " selected='selected'";} ?> value="<?php echo st($ctype_myarray['contacttypeid']);?>">

                                <?php echo st($ctype_myarray['contacttype']);?>
 				<?php echo  ($ctype_myarray['corporate']=='1')?" - Only avail. in Corp. contacts":""; ?>
                            </option>
                        <? }?>
                    </select>
                </div>
            </div>

            <div class="page-header">
                <strong>Name</strong>
            </div>
            <div class="form-group">
                <label for="salutation" class="col-md-3 control-label">Salutation</label>
                <div class="col-md-9">
                    <select name="salutation" id="salutation" class="form-control" tabindex="1" style="width:80px;" >
                        <option value=""></option>
                        <option value="Dr." <?php echo  ($salutation == 'Dr.') ? 'selected' : '' ?>>Dr.</option>
                        <option value="Mr." <?php echo  ($salutation == 'Mr.') ? 'selected' : '' ?>>Mr.</option>
                        <option value="Mrs." <?php echo  ($salutation == 'Mrs.') ? 'selected' : '' ?>>Mrs.</option>
                        <option value="Miss." <?php echo  ($salutation == 'Miss.') ? 'selected' : '' ?>>Miss.</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="firstname" class="col-md-3 control-label">First Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First name" value="<?php echo  $firstname ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="middlename" class="col-md-3 control-label">Middle Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Middle name" value="<?php echo  $middlename ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-md-3 control-label">Last Name</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Last name" value="<?php echo  $lastname ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Company</strong>
            </div>
            <div class="form-group">
                <label for="company" class="col-md-3 control-label">Company</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="company" id="company" placeholder="Company" value="<?php echo  $company ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Address</strong>
            </div>
            <div class="form-group">
                <label for="add1" class="col-md-3 control-label">Address</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="add1" id="add1" placeholder="Address" value="<?php echo  $add1 ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="text" class="form-control" name="add2" id="add2" placeholder="Address (second line)" value="<?php echo  $add2 ?>">
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
                <label for="phone1" class="col-md-3 control-label">Phone (main)</label>
                <div class="col-md-9">
                    <input type="text" class="form-control extphonemask" name="phone1" id="phone1" placeholder="Phone number" value="<?php echo  $phone1 ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="phone2" class="col-md-3 control-label">Phone (alternative)</label>
                <div class="col-md-9">
                    <input type="text" class="form-control extphonemask" name="phone2" id="phone2" placeholder="Phone number" value="<?php echo  $phone2 ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="fax" class="col-md-3 control-label">Fax</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="fax" id="fax234" placeholder="Fax number" value="<?php echo  $fax ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-3 control-label">Email</label>
                <div class="col-md-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo  $email ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Identification</strong>
            </div>
            <div class="form-group">
                <label for="national_provider_id" class="col-md-3 control-label">National Provider ID</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" name="national_provider_id" id="national_provider_id" placeholder="National provider ID" value="<?php echo  $national_provider_id ?>">
                </div>
            </div>
            
            <div class="page-header">
                <strong>Other ID for Claim Forms</strong>
            </div>
            <div class="form-group">
                <label for="qualifier" class="col-md-3 control-label">Qualifier</label>
                <div class="col-md-9">
                    <? 
                    $qualifier_sql = "select * from dental_qualifier where status=1 order by sortby";
                    $qualifier_my = mysqli_query($con,$qualifier_sql);
                    ?>
                    <select id="qualifier" name="qualifier" class="form-control">
                        <option value="0"></option>
                        <? while($qualifier_myarray = mysqli_fetch_array($qualifier_my))
                        {?>
                            <option value="<?php echo st($qualifier_myarray['qualifierid']);?>">
                                <?php echo st($qualifier_myarray['qualifier']);?>
                            </option>
                        <? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="desc" class="col-md-3 control-label">Notes</label>
                <div class="col-md-9">
                    <textarea name="desc" id="desc" class="form-control"><?php echo  $notes ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-md-3 control-label">Status</label>
                <div class="col-md-9">
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?php echo  (!empty($status) && $status == 1) ? 'selected' : '' ?>>Active</option>
                        <option value="2" <?php echo  (!empty($status) && $status == 2) ? 'selected' : '' ?>>In-Active</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="contactsub" value="1">
                    <input type="hidden" name="ed" value="<?php echo  $themyarray["contactid"] ?>">
		    <input type="hidden" name="corp" value="<?php echo  (isset($_REQUEST['corp']) && $_REQUEST['corp']=='1')?"1":"0"; ?>" />
                    <input type="submit" value="<?php echo  $but_text ?> Contact" class="btn btn-primary">
                <?php if ($themyarray["contactid"] != '') { ?>
                    <a class="btn btn-danger pull-right" href="javascript:parent.window.location='manage_contact.php?delid=<?php echo  $themyarray["contactid"] ?>&amp;docid=<?php echo  $_GET['docid'] ?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" title="DELETE">
                        Delete
                    </a>
                <?php } ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
