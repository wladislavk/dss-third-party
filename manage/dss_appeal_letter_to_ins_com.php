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


$ref_sql = "select * from dental_referredby where status=1 and referredbyid='".$pat_myarray['referred_by']."'";
$ref_my = mysql_query($ref_sql);
$ref_myarray = mysql_fetch_array($ref_my);

$ref_name = st($ref_myarray['salutation'])." ".st($ref_myarray['firstname'])." ".st($ref_myarray['middlename'])." ".st($ref_myarray['lastname']);

?>
<br />
<span class="admin_head">
	DSS Appeal letter to ins com
</span>
<br />
&nbsp;&nbsp;
<a href="dss_letters.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br /><br>

<div align="right">
	<button class="addButton" onclick="Javascript: window.open('dss_appeal_letter_to_ins_com_print.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','Print_letter','width=800,height=500,scrollbars=1');" >
		Print Letter 
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	<button class="addButton" onclick="Javascript: window.open('dss_appeal_letter_to_ins_com_word.php?fid=<?=$_GET['fid'];?>&pid=<?=$_GET['pid'];?>','word_letter','width=800,height=500,scrollbars=1');" >
		Word Document
	</button>
	&nbsp;&nbsp;&nbsp;&nbsp;
</div>

<table width="95%" cellpadding="3" cellspacing="1" border="0" align="center">
	<tr>
		<td valign="top">
		
<?=date('F d, Y');?><br /><br />

<b>
RE:	<?=$name?><br />
ID	<?=$pat_myarray['p_d_ins_id']?><br />
DOB	<?=$pat_myarray['dob']?><br />
</b>

<br /><br />
Dear Sir or Madam:
<br /><br />

I received your denial of coverage for the Mandibular Repositioning Device that has been prescribed for <strong><?=$name?></strong> by <strong><?=$ref_name;?></strong> and I am writing on behalf of <strong><?=$name1?></strong> to appeal that decision.  You have based your decision on (INSERT REASON WHY THEY ARE DENYING HERE).<br /><br />

<strong>Mr. <?=$name;?></strong> has been treated with a Mandibular Repositioning Device by <strong>Dr. <?=$_SESSION['name'];?></strong> to treat <strong>his</strong> documented sleep apnea.  This is neither an oral splint or appliance or a dental splint or dental brace.  It is a Mandibular Repositioning Device, specifically considered as Durable Medical Equipment, and specifically coded as a MEDICAL treatment for a MEDICAL diagnosis.  While these appliances are intraoral, they are not meant to treat the teeth. Instead, they reposition the jaw and tongue to open up the airway. Because the treatment is used to treat a medical condition, it cannot be considered “dental”.<br /><br />

It is gross negligence to deny payment for a Mandibular Repositioning Device under these circumstances.<br /><br />

The American Academy of Sleep Medicine published a Practice Parameters paper (Sleep, February 2006) on the use of oral appliances to treat sleep apnea.  This paper stated that the abundance of evidence based research on oral appliance therapy has shown Mandibular Repositioners to be successful enough that they recommend their use as a first line of therapy for mild to moderate sleep apnea, as well as for patients who are more severe and prefer them to CPAP or cannot tolerate CPAP.<br /><br />

This letter should explain why treatment for <strong><?=$name1?></strong> should be covered under “medical reimbursement".   I look forward to the opportunity to discuss this appeal and this case with you over the telephone.<br /><br />

Sincerely,<br /><br /><br /><br /><br>




<strong>
<?=$_SESSION['name']?> , DDS <br />
CC: <?=$name?> <br /><br />
</strong>

		</td>
	</tr>
</table>


<? include 'includes/bottom.htm';?>