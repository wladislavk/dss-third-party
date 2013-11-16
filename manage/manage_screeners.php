<? 
require_once('includes/constants.inc');
include "includes/top.htm";
include "includes/similar.php";
?>
<link rel="stylesheet" href="css/screener.css" />

<?php

if(isset($_REQUEST['delid'])){
  $sql = "DELETE FROM dental_screener where docid='".mysql_real_escape_string($_SESSION['docid'])."' AND id='".mysql_real_escape_string($_REQUEST['delid'])."'";
  mysql_query($sql);
}

if(isset($_REQUEST['hst'])){

  $sql = "SELECT * FROM dental_screener WHERE id='".mysql_real_escape_string($_REQUEST['hst'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);

  $pat_sql = "INSERT INTO dental_patients SET
		docid='".mysql_real_escape_string($r['docid'])."',
		firstname = '".mysql_real_escape_string($r['first_name'])."',
                lastname = '".mysql_real_escape_string($r['last_name'])."',
                cell_phone = '".mysql_real_escape_string($r['phone'])."',
		status='1',
		adddate = now(),
		ip_address = '".$_SERVER['REMOTE_ADDR']."'";
  mysql_query($pat_sql);
  $pat_id = mysql_insert_id();
  
  $hst_sql = "UPDATE dental_hst SET
		patient_id = '".$pat_id."',
		status='".DSS_HST_PENDING."'
		WHERE screener_id=".mysql_real_escape_string($r['id']);
  mysql_query($hst_sql);
  ?>
  <script type="text/javascript">
    window.location = 'manage_screeners.php';
  </script>
  <?php
}		


?>
<style type="text/css">
.similar{ display:none; }
</style>
<?php
$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;

if(isset($_REQUEST['sort']) && $_REQUEST['sort'] != ''){
  switch($_REQUEST['sort']){
    case 'adddate':
	$sort = "s.adddate";
	break;
    case 'patient':
	$sort = "s.last_name";
	break;
    case 'user':
	$sort = 'u.name';
	break;
    case 'phone':
	$sort = 's.phone';
    	break;
  }
}else{
  $_REQUEST['sort']='adddate';
  $_REQUEST['sortdir']='DESC';
  $sort = "s.adddate";
}
if(isset($_REQUEST['sortdir']) && $_REQUEST['sortdir']!=''){
  $dir = $_REQUEST['sortdir'];
}else{
  $dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT s.*, u.name, h.id as hst_id,
	breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep  AS survey_total,
	(SELECT sum(se.response) FROM dental_screener_epworth se WHERE se.screener_id = s.id) ep_total,
        rx_cpap + rx_blood_pressure + rx_hypertension + rx_heart_disease + rx_stroke + rx_apnea + rx_diabetes + rx_lung_disease + rx_insomnia + rx_depression + rx_narcolepsy + rx_medication + rx_restless_leg + rx_headaches + rx_heartburn AS sect3_total 
	FROM dental_screener s 
	INNER JOIN dental_users u ON s.userid = u.userid 
	LEFT JOIN dental_hst h ON h.screener_id = s.id
	WHERE s.docid='".$_SESSION['docid']."' ";
if(isset($_GET['risk']) && $_GET['risk']!=''){
  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysql_real_escape_string($_GET['risk'])." ";
}
if(isset($_GET['contacted']) && $_GET['contacted'] != ''){
  $sql .= " AND contacted = ".mysql_real_escape_string($_GET['contacted'])." ";
}
if(isset($_GET['contacted_risk']) && $_GET['contacted_risk'] != ''){
  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysql_real_escape_string($_GET['contacted_risk'])." ";
  $sql .= " AND contacted = 0 ";
}

  $sql .= "ORDER BY ".$sort." ".$dir;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient Screeners
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<div style="margin-left:20px;margin-bottom:10px;">
<?php if($_GET['risk']>=10){ ?>
<a href="manage_screeners.php" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_screeners.php?risk=10" class="addButton">Show High/Severe</a>
<?php } ?>
<?php if(isset($_GET['contacted']) && $_GET['contacted']=='0'){ ?>
<a href="manage_screeners.php" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_screeners.php?contacted=0" class="addButton">Show Not Contacted</a>
<?php } ?>
<?php if($_GET['contacted_risk']>=10){ ?>
<a href="manage_screeners.php" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_screeners.php?contacted_risk=10" class="addButton">Show High/Severe NOT Contacted</a>
<?php } ?>


</div>

<div style="font-weight:bold; font-size: 14px; margin:0 auto; width: 300px; text-align:center;">
<?php if($_GET['risk']>=10){ ?>
	<p>Showing High/Severe Patients only</p>
<?php }elseif(isset($_GET['contacted']) && $_GET['contacted']==0){ ?>
	<p>Showing NOT contacted patients only</p>
<?php }elseif($_GET['contacted_risk']>=10){ ?>
        <p>Showing High/Severe NOT contacted patients only</p>
<?php } ?>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"contacted=".$_GET['contacted']."&contacted_risk=".$_GET['contacted_risk']."&risk=".$_GET['risk']."&sort=".$_GET['sort']."&sortdir=".$_GET['sortdir']);
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'adddate')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
			<a href="manage_screeners.php?sort=adddate&sortdir=<?php echo ($_REQUEST['sort']=='adddate'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Date</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
			<a href="manage_screeners.php?sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="13%">
                        <a href="manage_screeners.php?sort=phone&sortdir=<?php echo ($_REQUEST['sort']=='phone'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
                </td>
               <td valign="top" class="col_head"  width="10%">
                        Risk 
                </td>
		<td valign="top" class="col_head" width="10%">
                        CPAP
                </td>
               <td valign="top" class="col_head" width="10%">
			Epworth
                </td>
               <td valign="top" class="col_head" width="10%">
			Results	
                </td>
               <td valign="top" class="col_head" width="10%">
                        HST
                </td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'user')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_screeners.php?sort=user&sortdir=<?php echo ($_REQUEST['sort']=='user'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Screened By</a>
                </td>
                <td valign="top" class="col_head" width="10%">
                        Contacted
                </td>
		<td valign="top" class="col_head">
			Edit
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="4" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{


		$epworth_labels[0] = 'No chance of dozing';
		$epworth_labels[1] = 'Slight chance of dozing';
                $epworth_labels[2] = 'Moderate chance of dozing';
                $epworth_labels[3] = 'High chance of dozing';



		while($myarray = mysql_fetch_array($my))
		{
		?>
			<tr>
				<td valign="top">
					<?= date('m/d/Y h:i a', strtotime($myarray["adddate"]));?>
				</td>
				<td valign="top">
                                        <?= st($myarray["first_name"]); ?> <?= $myarray['last_name']; ?>
				</td>
                                <td valign="top">
                                        <?= st($myarray["phone"]); ?> 
                                </td>
        <?php
	if($myarray['survey_total'] > 15 || $myarray['ep_total'] > 18 || $myarray['sect3_total'] > 3){
		?><td valign="top" class="risk_severe"><a href="#" onclick="$('#details_<?= $myarray['id']; ?>').toggle(); return false;">Severe</a></td><?php
        }else if($myarray['survey_total'] > 11 || $myarray['ep_total'] > 14 || $myarray['sect3_total'] > 2){
		?><td valign="top" class="risk_high"><a href="#" onclick="$('#details_<?= $myarray['id']; ?>').toggle(); return false;">High</a></td><?php
        }else if($myarray['survey_total'] > 7 || $myarray['ep_total'] > 9 || $myarray['sect3_total'] > 1){
		?><td valign="top" class="risk_moderate"><a href="#" onclick="$('#details_<?= $myarray['id']; ?>').toggle(); return false;">Moderate</a></td><?php
        }else{
		?><td valign="top" class="risk_low"><a href="#" onclick="$('#details_<?= $myarray['id']; ?>').toggle(); return false;">Low</a></td><?php
        }
?>
				<td valign="top">
					<?= ($myarray['rx_cpap']>0)?'Yes':'No'; ?>
				</td>
                                <td valign="top">
					<?= st($myarray['ep_total']); ?>
                                </td>
				<td valign="top">
					<?php
						$diagnosis = array();
						if($myarray['rx_blood_pressure']>0){
							array_push($diagnosis, 'High blood pressure');
						}
                                                if($myarray['rx_hypertension']>0){
                                                        array_push($diagnosis, 'Hypertension');
                                                }
                                                if($myarray['rx_heart_disease']>0){
                                                        array_push($diagnosis, 'Heart disease');
                                                }
                                                if($myarray['rx_stroke']>0){
                                                        array_push($diagnosis, 'Stroke');
                                                }

                                                if($myarray['rx_apnea']>0){
                                                        array_push($diagnosis, 'Sleep apnea');
                                                }

                                                if($myarray['rx_diabetes']>0){
                                                        array_push($diagnosis, 'Diabetes');
                                                }

                                                if($myarray['rx_lung_disease']>0){
                                                        array_push($diagnosis, 'Lung disease');
                                                }

                                                if($myarray['rx_insomnia']>0){
                                                        array_push($diagnosis, 'Insomnia');
                                                }

                                                if($myarray['rx_depression']>0){
                                                        array_push($diagnosis, 'Depression');
                                                }

                                                if($myarray['rx_narcolepsy']>0){
                                                        array_push($diagnosis, 'Narcolepsy');
                                                }

                                                if($myarray['rx_medication']>0){
                                                        array_push($diagnosis, 'Sleeping medication');
                                                }

                                                if($myarray['rx_restless_leg']>0){
                                                        array_push($diagnosis, 'Restless Leg Syndrome');
                                                }

                                                if($myarray['rx_headaches']>0){
                                                        array_push($diagnosis, 'Morning headaches');
                                                }

                                                if($myarray['rx_heartburn']>0){
                                                        array_push($diagnosis, 'Heartburn (Gastroesophageal Reflux)');
                                                }

?>
					<a href="#" onclick="$('#details_<?= $myarray['id']; ?>').toggle(); return false;" id="diagnosis_count_<?=$myarray['id']; ?>">View</a>
				</td>
				<td valign="top">
				  <?php if($myarray['hst_id']){ ?>
					<a href="manage_screeners.php?hst=<?= $myarray['id']; ?>">Order</a>
				  <?php } ?>
				</td>
				<td valign="top">
					<?= $myarray['name']; ?>	
				</td>
				<td valign="top">
					<input type="checkbox" class="contact_chbx" value="<?= $myarray['id']; ?>" <?= ($myarray['contacted']==1)?'checked="checked"':'';?> />
				</td>
				<td>
					<a href="manage_screeners.php?delid=<?= $myarray['id']; ?>&page=<?= $_REQUEST['page']; ?>" onclick="return confirm('Are you sure you want to delete this screener?');">Delete</a>
				</td>
			</tr>
			<tr id="details_<?= $myarray['id']; ?>" style="display:none;">
			<td colspan="4" valign="top">
				<strong>Epworth Sleepiness Score</strong><br />
	<?php $ep_sql = "SELECT se.response, e.epworth 
				FROM dental_screener_epworth se
				JOIN dental_epworth e ON se.epworth_id =e.epworthid
				WHERE se.response > 0 AND se.screener_id='".mysql_real_escape_string($myarray['id'])."'";
		$ep_q = mysql_query($ep_sql);
		while($ep_r = mysql_fetch_assoc($ep_q)){
		?>
		<?= $ep_r['response']; ?> - <strong><?= $ep_r['epworth']; ?></strong><br />
		<?php } ?>
		<?= $myarray['ep_total']; ?> - Total
			</td><td valign="top" colspan="6">
			<strong>Health Symptoms</strong><br />
			<?= ($myarray['breathing']>0)?'Yes - <strong>Have you ever been told you stop breathing while asleep?</strong><br />':''; ?>
                        <?= ($myarray['driving']>0)?'Yes - <strong>Have you ever fallen asleep or nodded off while driving?</strong><br />':''; ?>
                        <?= ($myarray['gasping']>0)?'Yes - <strong>Have you ever woken up suddenly with shortness of breath, gasping or with your heart racing?</strong><br />':''; ?>
                        <?= ($myarray['sleepy']>0)?'Yes - <strong>Do you feel excessively sleepy during the day?</strong><br />':''; ?>
                        <?= ($myarray['snore']>0)?'Yes - <strong>Do you snore or have you ever been told that you snore?</strong><br />':''; ?>
                        <?= ($myarray['weight_gain']>0)?'Yes - <strong>Have you had weight gain and found it difficult to lose?</strong><br />':''; ?>
                        <?= ($myarray['blood_pressure']>0)?'Yes - <strong>Have you taken medication for, or been diagnosed with high blood pressure?</strong><br />':''; ?>
                        <?= ($myarray['jerk']>0)?'Yes - <strong>Do you kick or jerk your legs while sleeping?</strong><br />':''; ?>
                        <?= ($myarray['burning']>0)?'Yes - <strong>Do you feel burning, tingling or crawling sensations in your legs when you wake up?</strong><br />':''; ?>
                        <?= ($myarray['headaches']>0)?'Yes - <strong>Do you wake up with headaches during the night or in the morning?</strong><br />':''; ?>
                        <?= ($myarray['falling_asleep']>0)?'Yes - <strong>Do you have trouble falling asleep?</strong><br />':''; ?>
                        <?= ($myarray['staying_asleep']>0)?'Yes - <strong>Do you have trouble staying asleep once you fall asleep?</strong><br />':''; ?>

			<br />
			<strong>Co-morbidity</strong><br />
			<?php
			foreach($diagnosis as $d){
				echo $d."<br />";
			}
			?>
			</td>
			</tr>


	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>

<script type="text/javascript">
$('.contact_chbx').click(function(){
  c = ($(this).is(':checked'))?1:0;
  id = $(this).val();
                                  $.ajax({
                                        url: "includes/screener_contact.php",
                                        type: "post",
                                        data: {id: id, c: c},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
});
</script>
