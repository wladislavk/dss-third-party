<?php include 'includes/top.htm';

$form_sql = "select * from dental_forms where formid='".s_for($_GET['fid'])."'";
$form_my = mysql_query($form_sql);
$form_myarray = mysql_fetch_array($form_my);

if($form_myarray['formid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_forms.php?pid=<?=$_GET['pid'];?>';
	</script>
	<?
	die();
}

$pat_sql = "select * from dental_patients where patientid='".s_for($form_myarray['patientid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$name1 = st($pat_myarray['salutation'])." ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$ref_sql = "select * from dental_q_recipients where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$ref_my = mysql_query($ref_sql);
$ref_myarray = mysql_fetch_array($ref_my);

$referring_physician = st($ref_myarray['referring_physician']);

$a_arr = explode('
',$referring_physician);

if(st($pat_myarray['dob']) <> '' )
{
	$dob_y = date('Y',strtotime(st($pat_myarray['dob'])));
	$cur_y = date('Y');
	$age = $cur_y - $dob_y;
}
else
{
	$age = 'N/A';
}

if(st($pat_myarray['gender']) == 'Female')
{
	$h_h =  "Her";
	$s_h =  "She";
	$h_h1 =  "her";
	$m_s = "Mrs.";
}
else
{
	$h_h =  "His";
	$s_h =  "He";
	$h_h1 =  "him";
	$m_s = "Mr.";
}
?>
<br />
<span class="admin_head">
	DSS request LOMN and Rx
</span>
<br />
&nbsp;&nbsp;
<a href="dss_letters.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<div align="right">
	<button class="addButton" onclick="Javascript: window.open('dss_request_lomn_and_rx_print.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
		Print Letter 
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<button class="addButton" onclick="Javascript: window.open('dss_request_lomn_and_rx_word.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
		Word Document
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">

<?=date('F d, Y')?><br><br>

Re: 	<strong><?=$name?></strong> <br>
DOB:	<strong><?=st($pat_myarray['dob'])?></strong><br>
SSN:	<strong><?=st($pat_myarray['ssn'])?></strong><br><br>

Dr. <strong><?=$a_arr[0];?></strong>,<br><br>

We need your help with getting some insurance coverage for dental device therapy for <strong><?=$name?></strong>.<br /><br />

Can you please provide us with the following:<br /><br />

<ul>
	<li>Letter of Medical Necessity</li>
	<li>Prescription for Oral Appliance Therapy</li>
</ul>


Please fax this back to 941 778 7602 at your earliest convenience.  <br /><br />

Thank you again for your help.  Please continue to keep us in mind for all of your mild to moderate OSA patients, as well as those who are intolerant of CPAP.<br /><br />

Regards,<br /><br /><br /><br />



<strong><?=$_SESSION['name']?>, DDS</strong><br><br>

		</td>
	</tr>
</table>


<? include 'includes/bottom.htm';?>