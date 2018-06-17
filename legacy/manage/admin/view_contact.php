<?php
namespace Ds3\Libraries\Legacy;

include_once 'includes/main_include.php';
include "includes/sescheck.php";
include_once "includes/general.htm";

include_once dirname(__FILE__) . '/includes/popup_top.htm';
?>
<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
$thesql = "select c.*, ct.contacttype from dental_contact c 
    LEFT JOIN dental_contacttype ct ON ct.contacttypeid = c.contacttypeid
    where c.contactid='".$_REQUEST["ed"]."'";
$themy = mysqli_query($con,$thesql);
$themyarray = mysqli_fetch_array($themy);
	
$salutation = st($themyarray['salutation']);
$firstname = st($themyarray['firstname']);
$middlename = st($themyarray['middlename']);
$lastname = st($themyarray['lastname']);
$company = st($themyarray['company']);
$contacttype = st($themyarray['contacttype']);
$add1 = st($themyarray['add1']);
$add2 = st($themyarray['add2']);
$city = st($themyarray['city']);
$state = st($themyarray['state']);
$zip = st($themyarray['zip']);
$phone1 = st($themyarray['phone1']);
$phone2 = st($themyarray['phone2']);
$fax = st($themyarray['fax']);
$email = st($themyarray['email']);
$notes = st($themyarray['notes']);
?>
<div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Name:</label>
        <div class="col-md-9"><?php echo  $salutation." ".$firstname." ".$middlename." ".$lastname; ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Company:</label>
        <div class="col-md-9"><?php echo  $company; ?> </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Contact Type:</label>
        <div class="col-md-9"><?php echo  $contacttype; ?> </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Address:</label>
        <div class="col-md-9"><?php echo  $add1; ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-9"><?php echo  $add2; ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">&nbsp;</label>
        <div class="col-md-9"><?php echo  $city." ".$state." ".$zip; ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Phone:</label>
        <div class="col-md-9"><?php echo  format_phone($phone1); ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Phone 2:</label>
        <div class="col-md-9"><?php echo  format_phone($phone2); ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Fax:</label>
        <div class="col-md-9"><?php echo  format_phone($fax); ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Email:</label>
        <div class="col-md-9"><?php echo  $email; ?></div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-md-3 control-label">Notes:</label>
        <div class="col-md-9"><?php echo  $notes; ?></div>
    </div>
    <a href="add_contact.php?ed=<?php echo (!empty($_REQUEST['ed']) ? $_REQUEST['ed'] : '');?>&corp=<?php echo (!empty($_GET['corp']) ? $_GET['corp'] : '');?>" title="View Full" class="btn btn-primary btn-sm">
        View Full
        <span class="glyphicon glyphicon-pencil"></span>
    </a>
</div>

</body>
</html>
