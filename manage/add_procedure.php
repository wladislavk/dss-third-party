<?php 
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

if($_POST["proceduresub"] == 1)
{
	if($_POST["ed"] != "")
	{
		$ed_sql = "update dental_procedure set patientid = '".s_for($_GET["pid"])."', insuranceid = '".s_for($_GET["insid"])."', service_date_from = '".s_for($_POST["service_date_from"])."', service_date_to = '".s_for($_POST["service_date_to"])."', place_service = '".s_for($_POST["place_service"])."', type_service = '".s_for($_POST["type_service"])."', cpt_code = '".s_for($_POST["cpt_code"])."', units = '".s_for($_POST["units"])."', charge = '".s_for($_POST["charge"])."', total_charge = '".s_for($_POST["total_charge"])."', applies_icd = '".s_for($_POST["applies_icd"])."', npi = '".s_for($_POST["npi"])."', other_id = '".s_for($_POST["other_id"])."', other_id_qualifier = '".s_for($_POST["other_id_qualifier"])."', modifier_code_1 = '".s_for($_POST["modifier_code_1"])."', modifier_code_2 = '".s_for($_POST["modifier_code_2"])."', modifier_code_3 = '".s_for($_POST["modifier_code_3"])."', modifier_code_4 = '".s_for($_POST["modifier_code_4"])."', epsdt = '".s_for($_POST["epsdt"])."', emg = '".s_for($_POST["emg"])."', supplemental_info = '".s_for($_POST["supplemental_info"])."' where procedureid='".$_POST["ed"]."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql.mysql_error();
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='insurance.php?msg=<?=$msg;?>&insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>';
		</script>
		<?
		die();
	}
	else
	{
		$ins_sql = "insert into dental_procedure set patientid = '".s_for($_GET["pid"])."', insuranceid = '".s_for($_GET["insid"])."', service_date_from = '".s_for($_POST["service_date_from"])."', service_date_to = '".s_for($_POST["service_date_to"])."', place_service = '".s_for($_POST["place_service"])."', type_service = '".s_for($_POST["type_service"])."', cpt_code = '".s_for($_POST["cpt_code"])."', units = '".s_for($_POST["units"])."', charge = '".s_for($_POST["charge"])."', total_charge = '".s_for($_POST["total_charge"])."', applies_icd = '".s_for($_POST["applies_icd"])."', npi = '".s_for($_POST["npi"])."', other_id = '".s_for($_POST["other_id"])."', other_id_qualifier = '".s_for($_POST["other_id_qualifier"])."', modifier_code_1 = '".s_for($_POST["modifier_code_1"])."', modifier_code_2 = '".s_for($_POST["modifier_code_2"])."', modifier_code_3 = '".s_for($_POST["modifier_code_3"])."', modifier_code_4 = '".s_for($_POST["modifier_code_4"])."', epsdt = '".s_for($_POST["epsdt"])."', emg = '".s_for($_POST["emg"])."', supplemental_info = '".s_for($_POST["supplemental_info"])."', docid='".$_SESSION['docid']."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
		mysql_query($ins_sql) or die($ins_sql.mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			parent.window.location='insurance.php?msg=<?=$msg;?>&insid=<?=$_GET['insid']?>&pid=<?=$_GET['pid']?>';
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
    $thesql = "select * from dental_procedure where procedureid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	
	$service_date_from = st($themyarray['service_date_from']);
	$service_date_to = st($themyarray['service_date_to']);
	$place_service = st($themyarray['place_service']);
	$type_service = st($themyarray['type_service']);
	$cpt_code = st($themyarray['cpt_code']);
	$units = st($themyarray['units']);
	$charge = st($themyarray['charge']);
	$total_charge = st($themyarray['total_charge']);
	$applies_icd = st($themyarray['applies_icd']);
	$npi = st($themyarray['npi']);
	$other_id = st($themyarray['other_id']);
	$other_id_qualifier = st($themyarray['other_id_qualifier']);
	$modifier_code_1 = st($themyarray['modifier_code_1']);
	$modifier_code_2 = st($themyarray['modifier_code_2']);
	$modifier_code_3 = st($themyarray['modifier_code_3']);
	$modifier_code_4 = st($themyarray['modifier_code_4']);
	$epsdt = st($themyarray['epsdt']);
	$emg = st($themyarray['emg']);
	$supplemental_info = st($themyarray['supplemental_info']);
	
	$but_text = "Add ";
	
	
	if($themyarray["contactid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	
	$place_sql = "select * from dental_place_service where status=1 order by sortby";
	$place_my = mysql_query($place_sql) or die($place_sql ." | ".mysql_error());
	
	$type_sql = "select * from dental_type_service where status=1 order by sortby";
	$type_my = mysql_query($type_sql) or die($type_sql ." | ".mysql_error());
	
	$cpt_sql = "select * from dental_cpt_code where status=1 order by sortby";
	$cpt_my = mysql_query($cpt_sql) or die($cpt_sql ." | ".mysql_error());
	
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
	<script type="text/javascript">
		function cal_tot()
		{
			var err = 0;
			var tot = 0;
			
			fa = document.procedurefrm;
			
			if(trim(fa.units.value) == '' )
			{
				alert("Units is Required.");
				fa.units.focus();
				err = 1;
			}
			
			if( err == 0)
			{
				if(isNaN(trim(fa.units.value)))
				{
					alert("Only Numberical Value Accepted.");
					fa.units.focus();
					err = 1;
				}
			}
			
			if( err == 0)
			{
				if(trim(fa.charge.value) == '')
				{
					alert("Charges is Required.");
					fa.charge.focus();
					err = 1;
				}
			}
			
			if( err == 0)
			{	
				if(isNaN(trim(fa.charge.value)))
				{
					alert("Only Numberical Value Accepted.");
					fa.charge.focus();
					err = 1;
				}
			}
			
			if(err == 0)
			{
				tot = parseFloat(trim(fa.units.value)) * parseFloat(trim(fa.charge.value));
			}
			else
			{
				tot = 0.00;
			}
			
			fa.total_charge.value = tot;
		}
	</script>
    <form name="procedurefrm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid'];?>&insid=<?=$_GET['insid'];?>" method="post" >
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Procedure
            </td>
        </tr>
        <tr>
        	<td valign="top" class="frmhead" width="30%">
				Dates of Service 
            </td>
			<td valign="top" class="frmdata">
				<b>From</b>
				
				<input type="text" value="<?=$service_date_from?>" name="service_date_from" class="inbox_line3" size="10"/>
				
				<b>To</b>
				
				<input type="text" value="<?=$service_date_to?>" name="service_date_to" class="inbox_line3" size="10"/>
				
            </td>
        </tr>
		<tr>
			<td valign="top" class="frmhead">
				Place of Service
			</td>
			<td valign="top" class="frmdata">
				<select name="place_service" class="inbox_line3" style="width:300px;">
					<option value=""></option>
					<?
					while($place_myarray = mysql_fetch_array($place_my))
					{?>
						<option value="<?=st($place_myarray['place_serviceid']);?>" <? if($place_service == st($place_myarray['place_serviceid'])) echo " selected";?>>
							<?=st($place_myarray['place_service']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Type of Service
			</td>
			<td valign="top" class="frmdata">
				<select name="type_service" class="inbox_line3" style="width:300px;">
					<option value=""></option>
					<?
					while($type_myarray = mysql_fetch_array($type_my))
					{?>
						<option value="<?=st($type_myarray['type_serviceid']);?>" <? if($type_service == st($type_myarray['type_serviceid'])) echo " selected";?>>
							<?=st($type_myarray['type_service']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				CPT Code
			</td>
			<td valign="top" class="frmdata">
				<select name="cpt_code" class="inbox_line3" style="width:300px;">
					<option value=""></option>
					<?
					while($cpt_myarray = mysql_fetch_array($cpt_my))
					{?>
						<option value="<?=st($cpt_myarray['cpt_codeid']);?>" <? if($cpt_code == st($cpt_myarray['cpt_codeid'])) echo " selected";?>>
							<?=st($cpt_myarray['cpt_code']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Units
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=number_format($units,1)?>" name="units" class="inbox_line3" size="10" onBlur="cal_tot()"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Charge per unit
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=number_format($charge,2)?>" name="charge" class="inbox_line3" size="10" onBlur="cal_tot()"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Total Charges
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=number_format($total_charge,2)?>" name="total_charge" class="inbox_line3" size="10"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Applies to which ICD in BOX 21
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=$applies_icd?>" name="applies_icd" class="inbox_line3" size="10"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead" colspan="2">
				Rendering Provider
				<span style="font-size:10px;">
				(If different than Box 33 Billing Provider)
				</span>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				NPI
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=$npi?>" name="npi" class="inbox_line3" size="10"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Other ID
			</td>
			<td valign="top" class="frmdata">
				<input type="text" value="<?=$other_id?>" name="other_id" class="inbox_line3" size="10"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Other ID Qualifier
			</td>
			<td valign="top" class="frmdata">
				<select name="other_id_qualifier" class="inbox_line3" style="width:50px;">
					<option value=""></option>
					<?
					$qua_sql = "select * from dental_qualifier where status=1 order by sortby";
					$qua_my = mysql_query($qua_sql);
					while($qua_myarray = mysql_fetch_array($qua_my))
					{?>
						<option value="<?=st($qua_myarray['qualifierid']);?>" <? if($other_id_qualifier == st($qua_myarray['qualifierid'])) echo " selected";?>>
							<?=st($qua_myarray['qualifier']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead" colspan="2">
				Less Used Items
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Modifier Code 1
			</td>
			<td valign="top" class="frmdata">
				<select name="modifier_code_1" class="inbox_line3" style="width:450px;">
					<option value=""></option>
					<?
					$mod_sql = "select * from dental_modifier_code where status=1 order by sortby";
					$mod_my = mysql_query($mod_sql) or die($mod_sql." | ".mysql_error());
					while($mod_myarray = mysql_fetch_array($mod_my))
					{?>
						<option value="<?=st($mod_myarray['modifier_codeid']);?>" <? if($modifier_code_1 == st($mod_myarray['modifier_codeid'])) echo " selected";?>>
							<?=st($mod_myarray['modifier_code']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Modifier Code 2
			</td>
			<td valign="top" class="frmdata">
				<select name="modifier_code_2" class="inbox_line3" style="width:450px;">
					<option value=""></option>
					<?
					$mod_sql = "select * from dental_modifier_code where status=1 order by sortby";
					$mod_my = mysql_query($mod_sql) or die($mod_sql." | ".mysql_error());
					while($mod_myarray = mysql_fetch_array($mod_my))
					{?>
						<option value="<?=st($mod_myarray['modifier_codeid']);?>" <? if($modifier_code_2 == st($mod_myarray['modifier_codeid'])) echo " selected";?>>
							<?=st($mod_myarray['modifier_code']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Modifier Code 3
			</td>
			<td valign="top" class="frmdata">
				<select name="modifier_code_3" class="inbox_line3" style="width:450px;">
					<option value=""></option>
					<?
					$mod_sql = "select * from dental_modifier_code where status=1 order by sortby";
					$mod_my = mysql_query($mod_sql) or die($mod_sql." | ".mysql_error());
					while($mod_myarray = mysql_fetch_array($mod_my))
					{?>
						<option value="<?=st($mod_myarray['modifier_codeid']);?>" <? if($modifier_code_3 == st($mod_myarray['modifier_codeid'])) echo " selected";?>>
							<?=st($mod_myarray['modifier_code']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead">
				Modifier Code 4
			</td>
			<td valign="top" class="frmdata">
				<select name="modifier_code_4" class="inbox_line3" style="width:450px;">
					<option value=""></option>
					<?
					$mod_sql = "select * from dental_modifier_code where status=1 order by sortby";
					$mod_my = mysql_query($mod_sql) or die($mod_sql." | ".mysql_error());
					while($mod_myarray = mysql_fetch_array($mod_my))
					{?>
						<option value="<?=st($mod_myarray['modifier_codeid']);?>" <? if($modifier_code_4 == st($mod_myarray['modifier_codeid'])) echo " selected";?>>
							<?=st($mod_myarray['modifier_code']);?>
						</option>
					<?
					}?>
				</select>
			</td>
		</tr>
		<tr>
			<td valign="top" class="frmhead" colspan="2">
				<input type="checkbox" name="epsdt" value="1" <? if($epsdt == 1) echo " checked";?> />
				EPSDT
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="emg" value="1" <? if($emg == 1) echo " checked";?> />
				EMG
			</td>
		</tr>
		
		<tr>
			<td valign="top" class="frmhead">
				Supplemental Info ? 
			</td>
			<td valign="top" class="frmdata">
				<textarea name="supplemental_info" cols="40" rows="4"><?=$supplemental_info?></textarea>
			</td>
		</tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="proceduresub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["procedureid"]?>" />
                <input type="submit" value=" <?=$but_text?> Procedure " class="button" />
            </td>
        </tr>
    </table>
    </form>
	
	
<script type="text/javascript">
	cal_tot();
</script>

</body>
</html>