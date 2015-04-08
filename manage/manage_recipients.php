<?php 
include "includes/top.htm";

if($_POST['q_recipientssub'] == 1){
	$referring_physician = $_POST['referring_physician'];
	$dentist = $_POST['dentist'];
	$physicians_other = $_POST['physicians_other'];
	$patient_info = $_POST['patient_info'];
	
	/*
	echo "referring_physician - ".$referring_physician."<br>";
	echo "dentist - ".$dentist."<br>";
	echo "physicians_other - ".$physicians_other."<br>";
	echo "patient_info - ".$patient_info."<br>";
	*/
	
	if($_POST['ed'] == ''){
		$ins_sql = "insert into dental_q_recipients set 
						patientid = '".s_for($_GET['pid'])."',
						referring_physician = '".s_for($referring_physician)."',
						dentist = '".s_for($dentist)."',
						physicians_other = '".s_for($physicians_other)."',
						patient_info = '".s_for($patient_info)."',
						userid = '".s_for($_SESSION['userid'])."',
						docid = '".s_for($_SESSION['docid'])."',
						adddate = now(),
						ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		$db->query($ins_sql) or die($ins_sql." | ".mysqli_error($con));
		
		$msg = "Added Successfully";?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?php
		die();
	}else{
		$ed_sql = "update dental_q_recipients set 
					referring_physician = '".s_for($referring_physician)."',
					dentist = '".s_for($dentist)."',
					physicians_other = '".s_for($physicians_other)."',
					patient_info = '".s_for($patient_info)."'
					where q_recipientsid = '".s_for($_POST['ed'])."'";
		
		$db->query($ed_sql) or die($ed_sql." | ".mysqli_error($con));
		
		//echo $ed_sql;
		$msg = "Edited Successfully";?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_SERVER['PHP_SELF']?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?php
		die();
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_myarray = $db->getRow($pat_sql);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == ''){?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?php
	die();
}
$sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";
$myarray = $db->getRow($sql);

$q_recipientsid = st($myarray['q_recipientsid']);
$referring_physician = st($myarray['referring_physician']);
$dentist = st($myarray['dentist']);
$physicians_other = st($myarray['physicians_other']);
$patient_info = st($myarray['patient_info']);

if($patient_info == ''){
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);			
	$sel_val = st($name);
	if(st($pat_myarray['company']) <> ''){
		$sel_val .= "
		".st($pat_myarray['company']);
	}
	if(st($pat_myarray['add1']) <> ''){
		$sel_val .= "
		".st($pat_myarray['add1']);
	}
	if(st($pat_myarray['add2']) <> ''){
	$sel_val .= "
	".st($pat_myarray['add2']);
	}
	if(st($pat_myarray['city']) <> ''){
	$sel_val .= "
	".st($pat_myarray['city']);
	}
	if(st($pat_myarray['state']) <> ''){
	$sel_val .= " ".st($pat_myarray['state']);
	}
	if(st($pat_myarray['zip']) <> ''){
	$sel_val .= " ".st($pat_myarray['zip']);
	}

	$patient_info = $sel_val;
}?>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;
<a href="dss_letters.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br />

<span class="admin_head">
	Recipients
	-
    Patient <i><?=$name;?></i>
</span>
<br />
<br />
&nbsp;

<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>

<form name="q_recipientsfrm" action="<?=$_SERVER['PHP_SELF'];?>?ex=<?=$_GET['ex']?>&pid=<?=$_GET['pid']?>" method="post" enctype="multipart/form-data" >
<input type="hidden" name="q_recipientssub" value="1" />
<input type="hidden" name="ed" value="<?=$q_recipientsid;?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="q_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Referring Physician
                        &nbsp;&nbsp;&nbsp;
                        <button onclick="Javascript: loadPopup('select_contact_rec.php?tx=referring_physician'); return false;">Use Contact List</button>
                    </label>
                    <div>
                        <span>
                            <textarea name="referring_physician" class="field text addr tbox" style="width:650px; height:100px;"><?=$referring_physician;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Dentist
                        &nbsp;&nbsp;&nbsp;
                        <button onclick="Javascript: loadPopup('select_contact_rec.php?tx=dentist'); return false;">Use Contact List</button>
                    </label>
                    <div>
                        <span>
                            <textarea name="dentist" class="field text addr tbox" style="width:650px; height:100px;"><?=$dentist;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Physicians (other)
                        &nbsp;&nbsp;&nbsp;
                        <button onclick="Javascript: loadPopup('select_contact_rec.php?tx=physicians_other'); return false;">Use Contact List</button>
                    </label>
                    <div>
                        <span>
                            <textarea name="physicians_other" class="field text addr tbox" style="width:650px; height:100px;"><?=$physicians_other;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Patient Info
                    </label>
                    <div>
                        <span>
                            <textarea name="patient_info" class="field text addr tbox" style="width:650px; height:100px;"><?=$patient_info;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
</table>

<div align="right">
	<input type="reset" value="Reset" />
    <input type="submit" name="q_pagebtn" value="Save" tabindex="12" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>

<br /><br />	
<?php include "includes/bottom.htm";?>