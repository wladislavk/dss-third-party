<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include "includes/general_functions.php";
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>

<script type="text/javascript" src="js/masks.js"></script> 
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
				 docid='".$_SESSION['docid']."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_locations.php?msg=<?=$msg;?>';
		</script>
		<?
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
</head>
<body>

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
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return locationabc(this)" >
    <table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> <?php echo $_GET['heading']; ?> Location 
               <? if($location <> "") {?>
               		&quot;<?=$location;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmhead">
				<ul>        
                    <li id="foli8" class="complex">	
                        <div>
                        	<span>
                            	<input type="text" name="location" id="location" value="<?= $location; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="location">Practice Location</label>
                            </span>
                       </div>   
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="name" id="name" value="<?= $name; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="name">Doctor Name</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="address" id="address" value="<?= $address; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="address">Address</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="city" id="city" value="<?= $city; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="city">City</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="state" id="state" value="<?= $state; ?>" class="field text addr tbox" maxlength="2" tabindex="1" style="width:300px;" >
                                <label for="state">State</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="zip" id="zip" value="<?= $zip; ?>" class="field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="zip">Zip</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="phone" id="phone" value="<?= $phone; ?>" class="extphonemask field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="phone">Phone</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead">
                                <ul>
                    <li id="foli8" class="complex">
                        <div>
                                <span>
                                <input type="text" name="fax" id="fax" value="<?= $fax; ?>" class="phonemask field text addr tbox" tabindex="1" style="width:300px;" >
                                <label for="fax">Fax</label>
                            </span>
                       </div>
                    </li>
                </ul>
            </td>
        </tr>

        <tr>
            <td  align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="contactsub" value="1" />
		<input type="hidden" name="docid" value="<?= $_GET['docid']; ?>" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value=" <?=$but_text?> Location" class="button" />
		<?php  if($themyarray["id"] != ''){ ?>
                    <a style="float:right;" href="javascript:parent.window.location='manage_locations.php?delid=<?=$themyarray["id"];?>'" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                Delete
                                        </a>
                 <?php } ?>
            </td>
        </tr>
    </table>
    </form>





      </div>
  </td>
</tr>
<!-- Stick Footer Section Here -->
</table>
</body>
</html>
