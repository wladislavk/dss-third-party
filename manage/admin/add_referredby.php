<?php 
session_start();

if(isset($_GET['addtopat'])){
$addtopat = $_GET['addtopat'];
}
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["referredbysub"] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_referredby set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."',  notes = '".s_for($_POST["notes"])."', status = '".s_for($_POST["status"])."' where referredbyid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		$addedtopat = $_POST['addedtopat'];

	// Check if required information is filled out on update
	$referredby_info = 0;
	if (!empty($_POST["add1"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"])) {
		$referredby_info = 1;
  }
	$sql = "UPDATE dental_referredby SET referredby_info = '".$referredby_info."' WHERE referredbyid = '".$_POST["ed"]."'";
	$result = mysql_query($sql) or die($sql." | ".mysql_error());
		
		if(isset($addtopat)){
		?>
      <script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='add_patient.php?ed=<?=$addedtopat;?>';
		</script>
		<?php
    }else{
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_referredby.php?msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ins_sql = "insert into dental_referredby set salutation = '".s_for($_POST["salutation"])."', firstname = '".s_for($_POST["firstname"])."', lastname = '".s_for($_POST["lastname"])."', middlename = '".s_for($_POST["middlename"])."', company = '".s_for($_POST["company"])."', add1 = '".s_for($_POST["add1"])."', add2 = '".s_for($_POST["add2"])."', city = '".s_for($_POST["city"])."', state = '".s_for($_POST["state"])."', zip = '".s_for($_POST["zip"])."', phone1 = '".s_for(num($_POST["phone1"]))."', phone2 = '".s_for(num($_POST["phone2"]))."', fax = '".s_for(num($_POST["fax"]))."', email = '".s_for($_POST["email"])."', national_provider_id = '".s_for($_POST["national_provider_id"])."', qualifier = '".s_for($_POST["qualifier"])."', qualifierid = '".s_for($_POST["qualifierid"])."', greeting = '".s_for($_POST["greeting"])."', sincerely = '".s_for($_POST["sincerely"])."',  notes = '".s_for($_POST["notes"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["status"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());

	// Check if required information is filled out on insert
	$referredby_info = 0;
	if (!empty($_POST["add1"]) && !empty($_POST["city"]) && !empty($_POST["state"]) && !empty($_POST["zip"])) {
		$referredby_info = 1;
  }
	$insertid = mysql_insert_id();
	$sql = "UPDATE dental_referredby SET referredby_info = '".$referredby_info."' WHERE referredbyid = '".$insertid."'";
	$result = mysql_query($sql);
		
		$msg = "Added Successfully";
		$addedtopat = $_POST['addedtopat'];
		
		if(isset($addtopat)){
		?>
      <script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='add_patient.php?ed=<?=$addedtopat;?>';
		</script>
		<?php
    }else{
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='manage_referredby.php?msg=<?=$msg;?>';
		</script>
		<?
		}
		die();
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_referredby where referredbyid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
		$notes = st($themyarray['notes']);
		
		$name = st($themyarray['firstname'])." ".st($themyarray['middlename'])." ".st($themyarray['lastname']);
		
		$but_text = "Add ";
	}
	
	if($themyarray["referredbyid"] != '')
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
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="referredbyfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&addtopat=1" method="post" onSubmit="return referredbyabc(this)">
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Referred By
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
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
                                    <option value="Dr." <? if($salutation == 'Dr.') echo " selected";?>>Dr.</option>
                                    <option value="Mr." <? if($salutation == 'Mr.') echo " selected";?>>Mr.</option>
                                    <option value="Mrs." <? if($salutation == 'Mrs.') echo " selected";?>>Mrs.</option>
                                    <option value="Miss." <? if($salutation == 'Miss.') echo " selected";?>>Miss.</option>
                                </select>
                                <label for="salutation">Salutation</label>
                            </span>
                            <span>
                                <input id="firstname" name="firstname" type="text" class="field text addr tbox" value="<?=$firstname?>" tabindex="2" maxlength="255" />
                                <label for="firstname">First Name</label>
                            </span>
                            <span>
                                <input id="lastname" name="lastname" type="text" class="field text addr tbox" value="<?=$lastname?>" tabindex="3" maxlength="255" />
                                <label for="lastname">Last Name</label>
                            </span>
                            <span>
                                <input id="middlename" name="middlename" type="text" class="field text addr tbox" value="<?=$middlename?>" tabindex="4" style="width:50px;" maxlength="1" />
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
                            <input id="company" name="company" type="text" class="field text addr tbox" value="<?=$company;?>" tabindex="5" style="width:575px;"  maxlength="255"/>
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
                                <input id="add1" name="add1" type="text" class="field text addr tbox" value="<?=$add1?>" tabindex="6" style="width:325px;"  maxlength="255"/>
                                <label for="add1">Address1</label>
                            </span>
                            <span>
                                <input id="add2" name="add2" type="text" class="field text addr tbox" value="<?=$add2?>" tabindex="7" style="width:325px;" maxlength="255" />
                                <label for="add2">Address2</label>
                            </span>
                        </div>
                        <div>
                            <span>
                                <input id="city" name="city" type="text" class="field text addr tbox" value="<?=$city?>" tabindex="8" style="width:200px;" maxlength="255" />
                                <label for="city">City</label>
                            </span>
                            <span>
                                <input id="state" name="state" type="text" class="field text addr tbox" value="<?=$state?>" tabindex="9" style="width:26px;" maxlength="2" />
                                <label for="state">State</label>
                            </span>
                            <span>
                                <input id="zip" name="zip" type="text" class="field text addr tbox" value="<?=$zip?>" tabindex="10" style="width:80px;" maxlength="255" />
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
                                <input id="phone1" name="phone1" type="text" class="field text addr tbox" value="<?=$phone1?>" tabindex="11" maxlength="255" style="width:200px;" />
                                <label for="phone1">Phone 1</label>
                            </span>
                            <span>
                                <input id="phone2" name="phone2" type="text" class="field text addr tbox" value="<?=$phone2?>" tabindex="12" maxlength="255" style="width:200px;" />
                                <label for="phone2">Phone 2</label>
                            </span>
                            <span>
                                <input id="fax" name="fax" type="text" class="field text addr tbox" value="<?=$fax?>" tabindex="13" maxlength="255" style="width:200px;" />
                                <label for="fax">Fax</label>
                            </span>
						</div>
                        <div>
                            <span>
                                <input id="email" name="email" type="text" class="field text addr tbox" value="<?=$email?>" tabindex="14" maxlength="255" style="width:325px;" />
                                <label for="email">Email</label>
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
                            	National Provider ID
                                <input id="national_provider_id" name="national_provider_id" type="text" class="field text addr tbox" value="<?=$national_provider_id?>" tabindex="15" maxlength="255" style="width:200px;" />
                            </span>
                        </div>
                    </li>
                    <li id="foli8" class="complex">	
                        <label class="desc" id="title0" for="Field0">
                            Other ID For Claim Forms
                        </label>
                        
                        <div>
                            <span>
                            	<? 
								$qualifier_sql = "select * from dental_qualifier where status=1 order by sortby";
								$qualifier_my = mysql_query($qualifier_sql);
								?>
                            	<select id="qualifier" name="qualifier" class="field text addr tbox" tabindex="16">
                                	<option value="0"></option>
                                    <? while($qualifier_myarray = mysql_fetch_array($qualifier_my))
									{?>
                                    	<option value="<?=st($qualifier_myarray['qualifierid']);?>">
                                        	<?=st($qualifier_myarray['qualifier']);?>
                                        </option>
                                    <? }?>
                                </select>
                                <label for="qualifier">Qualifier</label>
                            </span>
                            <span>
                                <input id="qualifierid" name="qualifierid" type="text" class="field text addr tbox" value="<?=$qualifierid?>" tabindex="17" maxlength="255" style="width:200px;" />
                                <label for="qualifierid">ID</label>
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
                                <input id="greeting" name="greeting" type="text" class="field text addr tbox" value="<?=$greeting?>" tabindex="18" maxlength="255" style="width:200px;" />
                                <label for="greeting">Greeting</label>
                            </span>
                            
                            
                    	</div>
                        
                        <div>
                        	<span>
                            	<textarea name="sincerely" id="sincerely" class="field text addr tbox" tabindex="19"><?=$sincerely?></textarea>
                                <label for="sincerely">Sincerely</label>
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
                            	<textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?=$notes?></textarea>
                            </span>
                        </div>
                    </li>
				</ul>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control" tabindex="22">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
                <br />&nbsp;
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="referredbysub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["referredbyid"]?>" />
                <input type="hidden" name="addedtopat" value="<?php echo $_GET['addtopat']; ?>">
                <input type="submit" value="<?=$but_text?> Referred By" class="btn btn-primary">
            </td>
        </tr>
    </table>
    
    
    </form>
</body>
</html>
