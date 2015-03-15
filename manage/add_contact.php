<?php namespace Ds3\Libraries\Legacy; ?><?php 
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
//include "includes/general_functions.php";
include_once "admin/includes/general.htm";
include_once "includes/constants.inc";
//include "includes/top.htm";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="js/masks.js"></script>
<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if(!empty($_POST["contactsub"]) && $_POST["contactsub"] == 1){
	if(!empty($_POST["ed"])){
		$ed_sql = "update dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."', status = '".s_for($_POST["status"])."', preferredcontact = '".s_for($_POST["preferredcontact"])."' , dea_number = '".s_for($_POST["dea_number"])." where contactid='".$_POST["ed"]."'";
		$db->query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
		</script>
		<?
		die();
	} else {
		$ins_sql = "insert into dental_contact set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for(ucfirst($_POST["firstname"]))."', lastname = '".s_for(ucfirst($_POST["lastname"]))."', middlename = '".s_for(ucfirst($_POST["middlename"]))."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."', contacttypeid = '".s_for($_POST["contacttypeid"])."', notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."', preferredcontact = '".$_POST['preferredcontact']."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', dea_number = '".s_for($_POST["dea_number"])."'";
		$rid = $db->getInsertId($ins_sql);
		$let_sql = "SELECT use_letters, intro_letters FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
		error_log($let_sql);
		$let_r = $db->getRow($let_sql);
		if($let_r['use_letters'] && $let_r['intro_letters']){
			$dct_sql = "SELECT physician from dental_contacttype WHERE contacttypeid=".mysql_real_escape_string($_POST["contacttypeid"]);
			$dct_r = $db->getRow($dct_sql);
	        if($dct_r['physician']==1){	
				//DO NOT CREATE LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
				//error_log($_SESSION['user_type'] ." ". DSS_USER_TYPE_SOFTWARE);
				if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE){
					create_welcome_letter('1', $rid, $_SESSION['docid']);
				}	
				create_welcome_letter('2', $rid, $_SESSION['docid']);?>
				<script type="text/javascript">
					alert('This created an introduction letter. If you do not wish to send an introduction delete the letter from your Pending Letters queue.');
				</script>
				<?php
			}
		}
		$c_sql = "SELECT contacttype from dental_contacttype where contacttypeid='".$_POST["contacttypeid"]."'";
		$c_r = $db->getRow($c_sql);
		$contact = $c_r['contacttype'];
		$name = $_POST['lastname'].", ".$_POST['firstname']." - ".$contact;
		$npi_name = $_POST['firstname']." ".$_POST['lastname'];
		$npi = $_POST['national_provider_id'];
		$msg = "Added Successfully";
	  	if($_GET['from']=='add_patient'){	
			if($_GET['from_id']!=''){?>
			<script type="text/javascript">
				<?php 
				if($_POST['contacttypeid']==11){ ?>
					parent.updateReferredBy('<option value="<?php echo $rid; ?>" selected="selected"><?php echo $_POST["company"]; ?></option>', '<?php echo $_GET['from_id']; ?>');
				<?php 
				} ?>
			</script>
			<?php
			}elseif($_GET['in_field']!='' && $_GET['id_field']!=''){	
			if(substr($_GET['in_field'],0,16)=='diagnosising_doc'){?>
                <script type="text/javascript">
                   parent.updateContactField('<?php echo $_GET['in_field']; ?>', '<?php echo addslashes($npi_name); ?>', '<?php echo $_GET['id_field']; ?>', '<?php echo $npi; ?>');
                </script>
			<?php
			}else{ ?>
			<script type="text/javascript">
			   parent.updateContactField('<?php echo $_GET['in_field']; ?>', '<?php echo addslashes($name); ?>', '<?php echo $_GET['id_field']; ?>', '<?php echo $rid; ?>');
			</script>
			<?php
			}	
		} ?>
		<script type="text/javascript">
			parent.disablePopupRefClean();
		</script>
		<?php
		}elseif($_GET['activePat']!=''){?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location.href= 'add_patient.php?ed=' + getParameterByName('activePat') + "&preview=1&addtopat=1&pid=" + getParameterByName('activePat');
		      // -->
		</script>
		<?php
    }else{?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			parent.window.location='manage_contact.php?msg=<?php echo $msg;?>';
		</script>
		<?php
		}
		die();
	}
}

/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
</head>
<body width="98%"> */ 

$psql = "select * from dental_contacttype WHERE physician=1";
$pq = $db->getResults($psql);
$physician_array = array();
if ($pq) foreach ($pq as $pr) {
  array_push($physician_array, $pr['contacttypeid']);
}
$physician_types = implode(',', $physician_array);

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
	$dea_number = $_POST['dea_number'];
	$national_provider_id = $_POST['national_provider_id'];
	$qualifier = $_POST['qualifier'];
	$qualifierid = $_POST['qualifierid'];
	$greeting = $_POST['greeting'];
	$sincerely = $_POST['sincerely'];
	$contacttypeid = $_POST['contacttypeid'];
	$notes = $_POST['notes'];
	$preferredcontact = $_POST['preferredcontact'];
	$status = $_POST['status'];
} else {
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
	$dea_number = st($themyarray['dea_number']);
	$national_provider_id = st($themyarray['national_provider_id']);
	$qualifier = st($themyarray['qualifier']);
	$qualifierid = st($themyarray['qualifierid']);
	$greeting = st($themyarray['greeting']);
	$sincerely = st($themyarray['sincerely']);
	$contacttypeid = st($themyarray['contacttypeid']);
	$notes = st($themyarray['notes']);
	$preferredcontact = st($themyarray['preferredcontact']);
	$name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
	$status = st($themyarray['status']);
	$but_text = "Add ";
}

if($themyarray["contactid"] != '') {
	$but_text = "Edit ";
} else {
	$but_text = "Add ";
} ?>
	
	<? if(!empty($msg)) {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
<?php
        if(!empty($_GET['search'])){
          if(strpos($_GET['search'], ' ')){
            $firstname = substr($_GET['search'], 0, strpos($_GET['search'], ' '));
            $lastname = substr($_GET['search'], strpos($_GET['search'],' ')+1);
          }else{
            $firstname = $_GET['search'];
          }
        }

<?php 
if(!empty($msg)) {?>
<div align="center" class="red">
    <?php echo $msg;?>
</div>
<?php 
}
if(!empty($_GET['search'])){
	if(strpos($_GET['search'], ' ')){
		$firstname = ucfirst(substr($_GET['search'], 0, strpos($_GET['search'], ' ')));
		$lastname = ucfirst(substr($_GET['search'], strpos($_GET['search'],' ')+1));
	}else{
		$firstname = ucfirst($_GET['search']);
	}
}
?>

<form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&activePat=<?php echo (!empty($_GET['activePat']) ? $_GET['activePat'] : ''); ?>&from=<?php echo (!empty($_GET['from']) ? $_GET['from'] : ''); ?>&from_id=<?php echo (!empty($_GET['from_id']) ? $_GET['from_id'] : ''); ?>&in_field=<?php echo (!empty($_GET['in_field']) ? $_GET['in_field'] : ''); ?>&id_field=<?php echo (!empty($_GET['id_field']) ? $_GET['id_field'] : ''); ?>" method="post" onSubmit="return contactabc(this)" style="width:99%;">
    <input type="hidden" id="physician_types" value="<?php echo $physician_types; ?>" />
    <input type="hidden" name="contact_type" value="<?php echo (!empty($_GET['ctype']) ? $_GET['ctype'] : ''); ?>" />
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
<?php 
if(!empty($_GET['ctype']) && $_GET['ctype']=='ins'){ ?>
			Add Insurance Company
<?php 
}else{
	echo $but_text . (!empty($_GET['heading']) ? $_GET['heading'] : '') . 'Contact';
	if($name <> "") {?>
       		&quot;<?php echo $name;?>&quot;
<?php 
	}
} ?>
            </td>
        </tr>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
	            <ul>
	                <li id="foli8" class="complex">
	                    <div>
	                        <span>
<?php
if(isset($_GET['ed'])){
	$ctype_sqlmy = "select * from dental_contact where contactid='".$_GET['ed']."' LIMIT 1;";
	$ctid = $db->getRow($ctype_sqlmy);
}
$ctype_sql = "select * from dental_contacttype where status=1 AND corporate='0' order by sortby";
$ctype_my = $db->getResults($ctype_sql);?>
		                        <select id="contacttypeid" name="contacttypeid" class="field text addr tbox" tabindex="20">
			                        <option value="">Select a contact type</option>
<?php 
if ($ctype_my) foreach ($ctype_my as $ctype_myarray) {?>
									<option <?php if(!empty($ctid['contacttypeid']) && $ctype_myarray['contacttypeid'] == $ctid['contacttypeid']){ echo " selected='selected'";} ?> <?php if(!empty($_GET['type']) && $ctype_myarray['contacttypeid'] == $_GET['type']){ echo " selected='selected'";} ?> <?php if(isset($_GET['ctypeeq']) && $ctype_myarray['contacttypeid'] == '11'){ echo " selected='selected'";} ?> value="<?php echo st($ctype_myarray['contacttypeid']);?>">
<?php 
										echo st($ctype_myarray['contacttype']);?>
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
        <tr class="content physician other">
        	<td valign="top" colspan="2" class="frmhead">
				<ul>        
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Name
                            <?php echo (!empty($_GET['ctype']) && $_GET['ctype']!='ins')?'<span id="req_0" class="req">*</span>':''; ?>
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
        <tr class="content physician insurance other"> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                    	<label class="desc" id="title0" for="Field0">
                            <span>
	                            <span style="color:#000000">Company <?php echo (!empty($_GET['ctype']) && $_GET['ctype']=='ins')?'<span id="req_0" class="req">*</span>':''; ?></span>
	                            <input id="company" name="company" type="text" class="field text addr tbox" value="<?php echo $company;?>" tabindex="5" style="width:575px;"  maxlength="255"/>
                            </span>
                        </label>
                    </li>
				</ul>
            </td>
        </tr>
        <tr class="content physician insurance other"> 
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
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?php echo $state?>" tabindex="9" style="width:80px;" maxlength="255" />
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
        <tr class="content physician insurance other"> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
                            <span>
                                <input id="phone1" name="phone1" type="text" class="extphonemask field text addr tbox" value="<?php echo $phone1?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="phone1">Phone 1</label>
                            </span>
                            <span>
                                <input id="phone2" name="phone2" type="text" class="extphonemask field text addr tbox" value="<?php echo $phone2?>" tabindex="12" maxlength="255" style="width:200px;" />
                                <label for="phone2">Phone 2</label>
                            </span>
                            <span>
                                <input id="fax" name="fax" type="text" class="phonemask field text addr tbox" value="<?php echo $fax?>" tabindex="13" maxlength="255" style="width:200px;" />
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
        <tr class="content physician">
                <td valign="top" colspan="2" class="frmhead">
                <ul>
                        <li id="foli8" class="complex">
                        <div>
                            <span>
                                <input id="dea_number" name="dea_number" type="text" class="field text addr tbox" value="<?= $dea_number; ?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="dea_number">DEA License Number</label>
                            </span>
                        </div>
                    </li>
                                </ul>
            </td>
        </tr>
        <tr class="content physician"> 
        	<td valign="top" colspan="2" class="frmhead">
            	<ul>
            		<li id="foli8" class="complex">	
                        <div>
						    <span style="font-size:10px;">These fields required for Medicare referring physicians.</span><br />
                            <span>
                            	National Provider ID (NPI)
                                <input id="national_provider_id" name="national_provider_id" type="text" class="field text addr tbox" value="<?php echo $national_provider_id?>" tabindex="15" maxlength="255" style="width:200px;" />
                            </span>
                        </div>
                    </li>
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Other ID For Claim Forms
                        </label>
                        
                        <div>
                            <span>
<?php 
$qualifier_sql = "select * from dental_qualifier where status=1 order by sortby";
$qualifier_my = $db->getResults($qualifier_sql);?>
	                        	<select id="qualifier" name="qualifier" class="field text addr tbox" tabindex="16">
                                	<option value="0"></option>
<?php 
if ($qualifier_my) foreach ($qualifier_my as $qualifier_myarray) {?>
                                	<option value="<?php echo st($qualifier_myarray['qualifierid']);?>">
                                    	<?php echo st($qualifier_myarray['qualifier']);?>
                                    </option>
<?php 
}?>
                                </select>
                                <label for="qualifier">Qualifier</label>
                            </span>
                            <span>
                                <input id="qualifierid" name="qualifierid" type="text" class="field text addr tbox" value="<?php echo $qualifierid?>" tabindex="17" maxlength="255" style="width:200px;" />
                                <label for="qualifierid">ID</label>
                            </span>
						</div>
                   </li>     
                </ul>
            </td>
        </tr>
         <tr class="content physician insurance other"> 
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
        
        <tr bgcolor="#FFFFFF" class="content physician insurance other">
            <td valign="top" class="frmhead">
                Preferred Contact Method
            </td>
            <td valign="top" class="frmdata">
            	<select id="preferredcontact" name="preferredcontact" class="tbox" tabindex="22">
					<option value="fax" <?php if($preferredcontact == 'fax') echo " selected";?>>Fax</option>
                	<option value="paper" <?php if($preferredcontact == 'paper') echo " selected";?>>Paper Mail</option>
                	<option value="email" <?php if($preferredcontact == 'email') echo " selected";?>>Email</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        
        <tr bgcolor="#FFFFFF" class="content physician insurance other">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox" tabindex="22">
                	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        <tr class="content physician insurance other">
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["contactid"]?>" />
				<a href="#" id="google_link" target="_blank" style="float:left;" />
					Google
				</a>
                <input type="submit" value=" <?php echo $but_text?> Contact" class="button" />
<?php 
if($themyarray["contactid"] != ''){ ?>
                <a style="float:right;" href="duplicate_contact.php?winner=<?php echo $themyarray["contactid"];?>" title="Duplicate">
		             Is This a Duplicate? 
	            </a>
				<br />
<?php
	if(get_contact_sent_letters($themyarray["contactid"]) > 0){ ?>
		                    <a style="float:right;" href="manage_contact.php?inactiveid=<?php echo $themyarray["contactid"];?>" onclick="javascript: return confirm('Letters have previously been sent to this contact; therefore, for medical record purposes the contact cannot be deleted. This contact now will be marked as INACTIVE in your software and will no longer display in search results. Any pending letters associated with this contact will be deleted.');" class="dellink" target="_parent" title="DELETE">
                <input type="submit" value=" <?=$but_text?> Contact" class="button" />
		<?php if($themyarray["contactid"] != ''){ ?>
		                    <a style="float:right;" href="manage_contact.php?delid=<?=$themyarray["contactid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE" target="_parent">
                                                 Delete 
                                        </a>
<?php 
	}elseif(get_contact_pending_letters($themyarray["contactid"])> 0){ ?>
                                    <a style="float:right;" href="manage_contact.php?delid=<?php echo $themyarray["contactid"];?>" onclick="javascript: return confirm('Warning: There are pending letters associated with this contact.  When you delete the contact the pending letters will also be deleted. Proceed?');" class="dellink" target="_parent" title="DELETE">
                                                 Delete 
                                        </a>
<?php 
	}else{ ?>
                                	<a style="float:right;" href="manage_contact.php?delid=<?php echo $themyarray["contactid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" target="_parent" title="DELETE">
                                                 Delete
                                    </a>
 <?php 
	} ?>
<?php 
} ?>
            </td>
        </tr>
    </table>
</form>

</div>
<!--<div style="margin:0 auto;background:url(images/dss_05.png) no-repeat top left;width:980px; height:28px;"> </div>
  </td>
</tr>-->
<!-- Stick Footer Section Here -->
<!--</table>-->
<!--<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
-->

<script type="text/javascript" src="script/contact.js"></script>
<script type="text/javascript" src="js/add_contact.js"></script>

</body>
</html>
