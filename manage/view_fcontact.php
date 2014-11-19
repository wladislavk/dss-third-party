<?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1){
	if($_POST["ed"] != ""){
		$ed_sql = "update dental_fcontact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for($_POST["phone1"])."', phone2 = '".s_for($_POST["phone2"])."', fax = '".s_for($_POST["fax"])."', email = '".s_for($_POST["email"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."' where contactid='".$_POST["ed"]."'";
		$db->query($ed_sql);
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_fcontact.php?msg=<?php echo $msg;?>';
		</script>
		<?php
		die();
	}
	else
	{
		$ins_sql = "insert into dental_fcontact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for($_POST["phone1"])."', phone2 = '".s_for($_POST["phone2"])."', fax = '".s_for($_POST["fax"])."', email = '".s_for($_POST["email"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		$db->query($ins_sql);
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_fcontact.php?msg=<?php echo $msg;?>';
		</script>
		<?php
		die();
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
<script type="text/javascript" src="js/check_elements.js"></script>

</head>
<body onload="check();">

<?php
$thesql = "select * from dental_contact where contactid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
$themyarray = $db->getRow($thesql);

if(!empty($msg)){
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
    $greeting = $_POST['greeting'];
    $sincerely = $_POST['sincerely'];
    $contacttypeid = $_POST['contacttypeid'];
    $notes = $_POST['notes'];
}else{
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
    $greeting = st($themyarray['greeting']);
    $sincerely = st($themyarray['sincerely']);
    $contacttypeid = st($themyarray['contacttypeid']);
    $notes = st($themyarray['notes']);

    $name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);

    $but_text = "Add ";
}

if($themyarray["contactid"] != ''){
    $but_text = "Edit ";
}else{
    $but_text = "Add ";
}?>

<br /><br />

<?php 
if(!empty($msg)) {?>
<div align="center" class="red">
    <?php echo $msg;?>
</div>
<?php 
}?>
 
<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return contactabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text . 'Contact';
if($name <> "") {?>
           		&quot;<?php echo $name;?>&quot;
<?php 
}?>
            </td>
        </tr>
        <tr>
        	<td valign="top" colspan="2" class="frmhead">
				<ul>
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Name
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                        	<span>
                            	<select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;" >
                                	<option value=""></option>
                                    <option value="Dr." <?php if($salutation == 'Dr.') echo " selected";?>>Dr.</option>
                                    <option value="Mr." <?php if($salutation == 'Mr.') echo " selected";?>>Mr.</option>
                                    <option value="Mrs." <?php if($salutation == 'Mrs.') echo " selected";?>>Mrs.</option>
                                    <option value="Miss." <?php if($salutation == 'Miss.') echo " selected";?>>Miss.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?php echo $firstname?>" tabindex="2" maxlength="255" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?php echo $lastname?>" tabindex="3" maxlength="255" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?php echo $middlename?>" tabindex="4" style="width:50px;" maxlength="1" />
                                <label for="middlename">Middle <br />Init</label>
                            </span>
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            <span>
                            <span style="color:#000000">Company</span>
                            <input id="company" name="company" type="text" class="field text addr tbox" value="<?php echo $company;?>" tabindex="5" style="width:575px;"  maxlength="255"/>
                            </span>
                        </label>
                    </li>
				</ul>
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            Address
                            <span id="req_0" class="req">*</span>
                        </label>
                        <div>
                            <span>
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?php echo $add1?>" tabindex="6" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?php echo $add2?>" tabindex="7" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?php echo $city?>" tabindex="8" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?php echo $state?>" tabindex="9" style="width:26px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?php echo $zip?>" tabindex="10" style="width:80px;" maxlength="255" />
                                <label for="zip">Zip / Post Code </label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
                            <span>
                                <input id="phone1" name="phone1" type="text" class="field text addr tbox" value="<?php echo $phone1?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="phone1">Phone 1</label>
                            </span>
                            <span>
                                <input id="phone2" name="phone2" type="text" class="field text addr tbox" value="<?php echo $phone2?>" tabindex="12" maxlength="255" style="width:200px;" />
                                <label for="phone2">Phone 2</label>
                            </span>
                            <span>
                                <input id="fax" name="fax" type="text" class="field text addr tbox" value="<?php echo $fax?>" tabindex="13" maxlength="255" style="width:200px;" />
                                <label for="fax">Fax</label>
                            </span>
						</div>
                        <div>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?php echo $email?>" tabindex="14" maxlength="255" style="width:325px;" />
                                <label for="email">Email</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr> 

        </tr>
        <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
                            <span>
                                <input id="greeting" name="greeting" type="text" class="field text addr tbox" value="<?php echo $greeting?>" tabindex="18" maxlength="255" style="width:200px;" />
                                <label for="greeting">Greeting</label>
                            </span>
                    	</div>
                        <div>
                        	<span>
                            	<textarea name="sincerely" id="sincerely" class="field text addr tbox" tabindex="19"><?php echo $sincerely?></textarea>
                                <label for="sincerely">Sincerely</label>
                            </span>
                            
                            <span>
<?php 
$ctype_sql = "select * from dental_contacttype order by sortby";
$ctype_my = $db->getResults($ctype_sql);
?>            
                            	<select id="contacttypeid" name="contacttypeid" class="field text addr tbox" tabindex="20">

                                	<option value="0"></option>
<?php 
if ($ctype_my) foreach ($ctype_my as $ctype_myarray) {?>
                                	<option value="<?php echo st($ctype_myarray['contacttypeid']);?>" <?php if($ctype_myarray['contacttypeid'] === $contacttypeid){ echo " selected=\"selected\"";} ?>>
                                    	<?php echo st($ctype_myarray['contacttype']);?>
                                    </option>        
<?php 
}?>
                                </select>
                                <label for="contacttype">Contact Type</label>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        
         <tr> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	 <label class="desc" id="title0" for="Field0">
                            Notes:
                        </label>
                        <div>
                            <span class="full">
                            	<textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?php echo $notes?></textarea>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["contactid"]?>" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
