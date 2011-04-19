<?php 

if(isset($_POST['submitaddfu'])){
$patientid = $_GET['pid'];
$ep_dateadd = $_POST['ep_dateadd'];
$devadd = $_POST['devadd'];
$dsetadd = $_POST['dsetadd'];
$ep_eadd = $_POST['ep_eadd'];
$ep_tsadd = $_POST['ep_tsadd'];
$ep_sadd = $_POST['ep_sadd'];
$ep_radd = $_POST['ep_radd'];
$ep_eladd = $_POST['ep_eladd'];
$sleep_qualadd = $_POST['sleep_qualadd'];
$ep_hadd = $_POST['ep_hadd'];
$ep_wadd = $_POST['ep_wadd'];
$wapnadd = $_POST['wapnadd'];
$hours_sleepadd = $_POST['hours_sleepadd'];
$appt_notesadd = $_POST['appt_notesadd'];

$fuinsert_sql = "INSERT INTO dentalsummfu (patientid, ep_dateadd, devadd, dsetadd, ep_eadd, ep_tsadd, ep_sadd, ep_radd, ep_eladd, sleep_qualadd, ep_hadd, ep_wadd, wapnadd, hours_sleepadd, appt_notesadd) VALUES ('$patientid','$ep_dateadd','$devadd','$dsetadd','$ep_eadd','$ep_tsadd','$ep_sadd','$ep_radd','$ep_eladd','$sleep_qualadd','$ep_hadd','$ep_wadd','$wapnadd','$hours_sleepadd','$appt_notesadd')";

$fuinsert_qry = mysql_query($fuinsert_sql);

if(!$fuinsert_qry){
  echo "Error in inserting Follow Up, please try again.";
} 

}



$fuquery_sql = "SELECT * FROM dentalsummfu WHERE patientid ='".$_GET['pid']."' ORDER BY id DESC";
$fuquery_array = mysql_query($fuquery_sql);

?>

<!--key reference table-->
<div style="float: left; width: 210px; margin-right: 10px; padding: 0; border: 0;">
	
	<table style="width: 100%;" class="followup-keytable" cellpadding="0">
  <tr style="background: #444;">
  	<td colspan="4"><span style="color: #fff;">@Del / Follow Up ID / New</span></td>
  </tr>

  <tr>
  	    <td style="background: #F9FFDF;"><strong>Date</strong> - Baseline</td>
  </tr>
  
  <tr>
  	<td style="background: #E4FFCF;"><strong>Dev</strong> - Device</td>
  </tr>
    
  <tr>
  	<td style="background: #F9FFDF;"><strong>Set</strong> - Device Setting</td>
  </tr>
  
  <tr>
  	<td style="background: #E4FFCF;"><strong>ESS</strong></td>
  </tr>
  
  <tr>
  	<td style="background: #F9FFDF;"><strong>TSS</strong></td>
  </tr>
  
  <tr>
  	<td style="background: #E4FFCF;"><strong>S</strong> - Snoring Level (1-10)</td>
  </tr>
  
    <tr>
  	<td style="background: #F9FFDF;"><strong>Dig</strong> - Dig Recorder</td>
  </tr>
  
    <tr>
  	<td style="background: #E4FFCF;"><strong>E</strong> - Energy Level</td>
  </tr>
  
    <tr>
  	<td style="background: #F9FFDF;"><strong>SQ</strong> - Sleep Quality</td>
  </tr>
  
    <tr>
  	<td style="background: #E4FFCF;"><strong>H/W</strong> - Headaches per Week</td>
  </tr>
  
    <tr>
  	<td style="background: #F9FFDF;"><strong>A/W</strong> - Awakenings per Night</td>
  </tr>
  
    <tr>
  	<td style="background: #E4FFCF;"><strong>WA</strong> - Witnessed Apnea per Night</td>
  </tr>
  
    <tr>
  	<td style="background: #F9FFDF;"><strong>H/N</strong> - Hours of Sleep per Night</td>
  </tr>
  
    <tr>
  	<td style="background: #E4FFCF;"><strong>Other</strong></td>
  </tr>
 </table>
</div>



	<div style=" border: medium none;float: left;height: 440px;margin-bottom: 20px;margin-top: -4px;overflow: auto;">
		 <table width="700" style="overflow-x: auto;">
		   <tr>
		    <td>

<!-- IFRAME for FOLLOW UPS-->

<iframe height="433" width="100%" style="border: medium none; overflow-y: hidden;overflow-x: scroll;" src="dss_followups.php?pid=<?php echo $_GET['pid']; ?>">Iframes must be enabled to view this area.</iframe>

<!-- IFRAME for FOLLOW UPS-->

         </td>
      </tr>
		 </table>
	</div>


</div>
