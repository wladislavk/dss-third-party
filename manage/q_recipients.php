<? 
include "includes/top.htm";

if($_POST['q_recipientssub'] == 1)
{
	$referring_physician = $_POST['referring_physician'];
	$dentist = $_POST['dentist'];
	$physicians_other = $_POST['physicians_other'];
	$patient_info = $_POST['patient_info'];
	
	if($_FILES["q_file1"]["name"] <> '')
	{
		$fname = $_FILES["q_file1"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner1 = $name.'_'.date('dmy_Hi');
		$banner1 = str_replace(" ","_",$banner1);
		$banner1 = str_replace(".","_",$banner1);
		$banner1 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file1"]["tmp_name"],"q_file/".$banner1);
		@chmod("q_file/".$banner1,0777);
		
		if($_POST['q_file1_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file1_old']);
		}
	}
	else
	{
		$banner1 = $_POST['q_file1_old'];
	}
	
	if($_FILES["q_file2"]["name"] <> '')
	{
		$fname = $_FILES["q_file2"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner2 = $name.'_'.date('dmy_Hi');
		$banner2 = str_replace(" ","_",$banner2);
		$banner2 = str_replace(".","_",$banner2);
		$banner2 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file2"]["tmp_name"],"q_file/".$banner2);
		@chmod("q_file/".$banner2,0777);
		
		if($_POST['q_file2_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file2_old']);
		}
	}
	else
	{
		$banner2 = $_POST['q_file2_old'];
	}
	
	if($_FILES["q_file3"]["name"] <> '')
	{
		$fname = $_FILES["q_file3"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner3 = $name.'_'.date('dmy_Hi');
		$banner3 = str_replace(" ","_",$banner3);
		$banner3 = str_replace(".","_",$banner3);
		$banner3 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file3"]["tmp_name"],"q_file/".$banner3);
		@chmod("q_file/".$banner3,0777);
		
		if($_POST['q_file3_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file3_old']);
		}
	}
	else
	{
		$banner3 = $_POST['q_file3_old'];
	}
	
	if($_FILES["q_file4"]["name"] <> '')
	{
		$fname = $_FILES["q_file4"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner4 = $name.'_'.date('dmy_Hi');
		$banner4 = str_replace(" ","_",$banner4);
		$banner4 = str_replace(".","_",$banner4);
		$banner4 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file4"]["tmp_name"],"q_file/".$banner4);
		@chmod("q_file/".$banner4,0777);
		
		if($_POST['q_file4_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file4_old']);
		}
	}
	else
	{
		$banner4 = $_POST['q_file4_old'];
	}
	
	if($_FILES["q_file5"]["name"] <> '')
	{
		$fname = $_FILES["q_file5"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner5 = $name.'_'.date('dmy_Hi');
		$banner5 = str_replace(" ","_",$banner5);
		$banner5 = str_replace(".","_",$banner5);
		$banner5 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file5"]["tmp_name"],"q_file/".$banner5);
		@chmod("q_file/".$banner5,0777);
		
		if($_POST['q_file5_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file5_old']);
		}
	}
	else
	{
		$banner5 = $_POST['q_file5_old'];
	}
	
	if($_FILES["q_file6"]["name"] <> '')
	{
		$fname = $_FILES["q_file6"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner6 = $name.'_'.date('dmy_Hi');
		$banner6 = str_replace(" ","_",$banner6);
		$banner6 = str_replace(".","_",$banner6);
		$banner6 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file6"]["tmp_name"],"q_file/".$banner6);
		@chmod("q_file/".$banner6,0777);
		
		if($_POST['q_file6_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file6_old']);
		}
	}
	else
	{
		$banner6 = $_POST['q_file6_old'];
	}
	
	if($_FILES["q_file7"]["name"] <> '')
	{
		$fname = $_FILES["q_file7"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner7 = $name.'_'.date('dmy_Hi');
		$banner7 = str_replace(" ","_",$banner7);
		$banner7 = str_replace(".","_",$banner7);
		$banner7 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file7"]["tmp_name"],"q_file/".$banner7);
		@chmod("q_file/".$banner7,0777);
		
		if($_POST['q_file7_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file7_old']);
		}
	}
	else
	{
		$banner7 = $_POST['q_file7_old'];
	}
	
	if($_FILES["q_file8"]["name"] <> '')
	{
		$fname = $_FILES["q_file8"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner8 = $name.'_'.date('dmy_Hi');
		$banner8 = str_replace(" ","_",$banner8);
		$banner8 = str_replace(".","_",$banner8);
		$banner8 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file8"]["tmp_name"],"q_file/".$banner8);
		@chmod("q_file/".$banner8,0777);
		
		if($_POST['q_file8_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file8_old']);
		}
	}
	else
	{
		$banner8 = $_POST['q_file8_old'];
	}
	
	if($_FILES["q_file9"]["name"] <> '')
	{
		$fname = $_FILES["q_file9"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner9 = $name.'_'.date('dmy_Hi');
		$banner9 = str_replace(" ","_",$banner9);
		$banner9 = str_replace(".","_",$banner9);
		$banner9 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file9"]["tmp_name"],"q_file/".$banner9);
		@chmod("q_file/".$banner9,0777);
		
		if($_POST['q_file9_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file9_old']);
		}
	}
	else
	{
		$banner9 = $_POST['q_file9_old'];
	}
	
	if($_FILES["q_file10"]["name"] <> '')
	{
		$fname = $_FILES["q_file10"]["name"];
		$lastdot = strrpos($fname,".");
		$name = substr($fname,0,$lastdot);
		$extension = substr($fname,$lastdot+1);
		$banner10 = $name.'_'.date('dmy_Hi');
		$banner10 = str_replace(" ","_",$banner10);
		$banner10 = str_replace(".","_",$banner10);
		$banner10 .= ".".$extension;
		
		@move_uploaded_file($_FILES["q_file10"]["tmp_name"],"q_file/".$banner10);
		@chmod("q_file/".$banner10,0777);
		
		if($_POST['q_file10_old'] <> '')
		{
			@unlink("q_file/".$_POST['q_file10_old']);
		}
	}
	else
	{
		$banner10 = $_POST['q_file10_old'];
	}
	
	/*echo "referring_physician - ".$referring_physician."<br>";
	echo "dentist - ".$dentist."<br>";
	echo "physicians_other - ".$physicians_other."<br>";
	echo "patient_info - ".$patient_info."<br>";
	echo "q_file1 - ".$banner1."<br>";
	echo "q_file2 - ".$banner2."<br>";
	echo "q_file3 - ".$banner3."<br>";
	echo "q_file4 - ".$banner4."<br>";
	echo "q_file5 - ".$banner5."<br>";
	echo "q_file6 - ".$banner6."<br>";
	echo "q_file7 - ".$banner7."<br>";
	echo "q_file8 - ".$banner8."<br>";
	echo "q_file9 - ".$banner9."<br>";
	echo "q_file10 - ".$banner10."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_q_recipients set 
		patientid = '".s_for($_GET['pid'])."',
		referring_physician = '".s_for($referring_physician)."',
		dentist = '".s_for($dentist)."',
		physicians_other = '".s_for($physicians_other)."',
		patient_info = '".s_for($patient_info)."',
		q_file1 = '".s_for($banner1)."',
		q_file2 = '".s_for($banner2)."',
		q_file3 = '".s_for($banner3)."',
		q_file4 = '".s_for($banner4)."',
		q_file5 = '".s_for($banner5)."',
		q_file6 = '".s_for($banner6)."',
		q_file7 = '".s_for($banner7)."',
		q_file8 = '".s_for($banner8)."',
		q_file9 = '".s_for($banner9)."',
		q_file10 = '".s_for($banner10)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?ex=<?=$_GET['ex']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
	else
	{
		$ed_sql = " update dental_q_recipients set 
		referring_physician = '".s_for($referring_physician)."',
		dentist = '".s_for($dentist)."',
		physicians_other = '".s_for($physicians_other)."',
		patient_info = '".s_for($patient_info)."',
		q_file1 = '".s_for($banner1)."',
		q_file2 = '".s_for($banner2)."',
		q_file3 = '".s_for($banner3)."',
		q_file4 = '".s_for($banner4)."',
		q_file5 = '".s_for($banner5)."',
		q_file6 = '".s_for($banner6)."',
		q_file7 = '".s_for($banner7)."',
		q_file8 = '".s_for($banner8)."',
		q_file9 = '".s_for($banner9)."',
		q_file10 = '".s_for($banner10)."'
		where q_recipientsid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		//echo $ed_sql;
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?ex=<?=$_GET['ex']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}
$sql = "select * from dental_q_recipients where patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_recipientsid = st($myarray['q_recipientsid']);
$referring_physician = st($myarray['referring_physician']);
$dentist = st($myarray['dentist']);
$physicians_other = st($myarray['physicians_other']);
$patient_info = st($myarray['patient_info']);
$q_file1 = st($myarray['q_file1']);
$q_file2 = st($myarray['q_file2']);
$q_file3 = st($myarray['q_file3']);
$q_file4 = st($myarray['q_file4']);
$q_file5 = st($myarray['q_file5']);
$q_file6 = st($myarray['q_file6']);
$q_file7 = st($myarray['q_file7']);
$q_file8 = st($myarray['q_file8']);
$q_file9 = st($myarray['q_file9']);
$q_file10 = st($myarray['q_file10']);

if($patient_info == '')
{
	$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
			
$sel_val = st($name);
if(st($pat_myarray['company']) <> '')
{
$sel_val .= "
".st($pat_myarray['company']);
}
if(st($pat_myarray['add1']) <> '')
{
$sel_val .= "
".st($pat_myarray['add1']);
}
if(st($pat_myarray['add2']) <> '')
{
$sel_val .= "
".st($pat_myarray['add2']);
}
if(st($pat_myarray['city']) <> '')
{
$sel_val .= "
".st($pat_myarray['city']);
}
if(st($pat_myarray['state']) <> '')
{
$sel_val .= " ".st($pat_myarray['state']);
}
if(st($pat_myarray['zip']) <> '')
{
$sel_val .= " ".st($pat_myarray['zip']);
}

$patient_info = $sel_val;
}
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;
<a href="manage_forms.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back To Forms</b></a>
<br />

<? include("includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="q_recipientsfrm" action="<?=$_SERVER['PHP_SELF'];?>?ex=<?=$_GET['ex']?>&pid=<?=$_GET['pid']?>" method="post" enctype="multipart/form-data" >
<input type="hidden" name="q_recipientssub" value="1" />
<input type="hidden" name="ed" value="<?=$q_recipientsid;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

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
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
				<li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Upload Digital Copy / Digital Photos
                    </label>
					<div>
						<br />
                        <span>
							Sleep Studies
						</span>
						<br />
						<span class="left">
							1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file1 <> '') {?>
                                <a href="q_file/<?=$q_file1?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file1" value="" size="26" />
                            <input type="hidden" name="q_file1_old" value="<?=$q_file1;?>" />
						</span>
						<span class="right">
							2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file2 <> '') {?>
                                <a href="q_file/<?=$q_file2?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file2" value="" size="26" />
                            <input type="hidden" name="q_file2_old" value="<?=$q_file2;?>" />
						</span>
					</div>
					
					<div>
						<br />
                        <span>
							Radiographs
						</span>
						<br />
						<span class="left">
							1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file3 <> '') {?>
                                <a href="q_file/<?=$q_file3?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file3" value="" size="26" />
                            <input type="hidden" name="q_file3_old" value="<?=$q_file3;?>" />
						</span>
						<span class="right">
							2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file4 <> '') {?>
                                <a href="q_file/<?=$q_file4?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file4" value="" size="26" />
                            <input type="hidden" name="q_file4_old" value="<?=$q_file4;?>" />
						</span>
					</div>
					
					<div>
						<br />
                        <span>
							Photos
						</span>
						<br />
						<span class="left">
							1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file5 <> '') {?>
                                <a href="q_file/<?=$q_file5?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file5" value="" size="26" />
                            <input type="hidden" name="q_file5_old" value="<?=$q_file5;?>" />
						</span>
						<span class="right">
							2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file6 <> '') {?>
                                <a href="q_file/<?=$q_file6?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file6" value="" size="26" />
                            <input type="hidden" name="q_file6_old" value="<?=$q_file6;?>" />
						</span>
					</div>
					
					<div>
						<br />
                        <span>
							Profile (face photo)
						</span>
						<br />
						<span class="left">
							1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file7 <> '') {?>
                                <a href="q_file/<?=$q_file7?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file7" value="" size="26" />
                            <input type="hidden" name="q_file7_old" value="<?=$q_file7;?>" />
						</span>
						<span class="right">
							2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file8 <> '') {?>
                                <a href="q_file/<?=$q_file8?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file8" value="" size="26" />
                            <input type="hidden" name="q_file8_old" value="<?=$q_file8;?>" />
						</span>
					</div>
					
					<div>
						<br />
                        <span>
							Other
						</span>
						<br />
						<span class="left">
							1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file9 <> '') {?>
                                <a href="q_file/<?=$q_file9?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file9" value="" size="26" />
                            <input type="hidden" name="q_file9_old" value="<?=$q_file9;?>" />
						</span>
						<span class="right">
							2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file10 <> '') {?>
                                <a href="q_file/<?=$q_file10?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file10" value="" size="26" />
                            <input type="hidden" name="q_file10_old" value="<?=$q_file10;?>" />
						</span>
					</div>
					
                    <!--<div>
                        <span>
                        	1.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file1 <> '') {?>
                                <a href="q_file/<?=$q_file1?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file1" value="" size="26" />
                            <input type="hidden" name="q_file1_old" value="<?=$q_file1;?>" />
                            <br /><br />
                            
                        	2.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file2 <> '') {?>
                                <a href="q_file/<?=$q_file2?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file2" value="" size="26" />
                            <input type="hidden" name="q_file2_old" value="<?=$q_file2;?>" />
                            <br /><br />
                            
                            
                        	3.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file3 <> '') {?>
                                <a href="q_file/<?=$q_file3?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file3" value="" size="26" />
                            <input type="hidden" name="q_file3_old" value="<?=$q_file3;?>" />
                            <br /><br />
                            
                            
                        	4.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file4 <> '') {?>
                                <a href="q_file/<?=$q_file4?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file4" value="" size="26" />
                            <input type="hidden" name="q_file4_old" value="<?=$q_file4;?>" />
                            <br /><br />
                            
                            
                        	5.
                            &nbsp;&nbsp;&nbsp;
                            <? if($q_file5 <> '') {?>
                                <a href="q_file/<?=$q_file5?>" target="_blank">
                                    <b>Preview</b></a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            <? }?>
                            <input type="file" name="q_file5" value="" size="26" />
                            <input type="hidden" name="q_file5_old" value="<?=$q_file5;?>" />
                            <br /><br />
                            
                        </span>
                    </div> -->
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

<br />
<? include("includes/form_bottom.htm");?>
<br />


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
