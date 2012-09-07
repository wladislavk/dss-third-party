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

if(isset($_REQUEST['sort'])){
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
  }
}else{
  $_REQUEST['sort']='adddate';
  $_REQUEST['sortdir']='DESC';
  $sort = "s.adddate";
}
if(isset($_REQUEST['sortdir'])){
  $dir = $_REQUEST['sortdir'];
}else{
  $dir = 'DESC';
}
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT s.*, u.name,
	breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep  AS survey_total
	FROM dental_screener s 
	INNER JOIN dental_users u ON s.userid = u.userid 
	WHERE s.docid='".$_SESSION['docid']."' ";
if(isset($_GET['risk'])){
  $sql .= " AND (breathing + driving + gasping + sleepy + snore + weight_gain + blood_pressure + jerk + burning + headaches + falling_asleep + staying_asleep) >= ".mysql_real_escape_string($_GET['risk'])." ";
}
if(isset($_GET['contacted'])){
  $sql .= " AND contacted = ".mysql_real_escape_string($_GET['contacted'])." ";
}
  $sql .= "ORDER BY ".$sort." ".$dir;
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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
<?php if(isset($_GET['contacted']) && $_GET['contacted']==0){ ?>
<a href="manage_screeners.php" class="addButton">Show All</a>
<?php }else{ ?>
<a href="manage_screeners.php?contacted=0" class="addButton">Show Not Contacted</a>
<?php } ?>

</div>

<div style="font-weight:bold; font-size: 14px; margin:0 auto; width: 300px; text-align:center;">
<?php if($_GET['risk']>=10){ ?>
	<p>Showing High/Severe Patients only</p>
<?php }elseif(isset($_GET['contacted']) && $_GET['contacted']==0){ ?>
	<p>Showing NOT contacted patients only</p>
<?php } ?>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
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
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="25%">
                        <a href="manage_screeners.php?sort=patient&sortdir=<?php echo ($_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Phone</a>
                </td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        Risk 
                </td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        CPAP
                </td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'phone')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			Epworth
                </td>
               <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			Co-morbidity	
                </td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'user')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_screeners.php?sort=user&sortdir=<?php echo ($_REQUEST['sort']=='user'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Screened By</a>
                </td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'user')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
                        <a href="manage_screeners.php?sort=user&sortdir=<?php echo ($_REQUEST['sort']=='user'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Contacted</a>
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
					<?php if($myarray["survey_total"] < 8 ){ ?>		
						<td valign="top" class="risk_low">Low</td>
                                        <?php }elseif($myarray["survey_total"] < 10 ){ ?>
						<td valign="top" class="risk_moderate">Moderate</td>
                                        <?php }elseif($myarray["survey_total"] < 16 ){ ?>
						<td valign="top" class="risk_high">High</td>
                                        <?php }else{ ?>
						<td valign="top" class="risk_severe">Severe</td>
					<?php } ?>
				<td valign="top">
					<?= ($myarray['rx_cpap']>0)?'Yes':'No'; ?>
				</td>
                                <td valign="top">
					<?= st($myarray['epworth_lunch']+$myarray['epworth_lying']+$myarray['epworth_reading']+$myarray['epworth_passenger']+$myarray['epworth_public']+$myarray['epworth_traffic']+$myarray["epworth_talking"]); ?>
                                </td>
				<td valign="top">
					<?php
						$diagnosis = array();
						if($myarray['rx_blood_pressure']==1){
							array_push($diagnosis, 'High blood pressure');
						}
                                                if($myarray['rx_hypertension']==1){
                                                        array_push($diagnosis, 'Hypertension');
                                                }
                                                if($myarray['rx_heart_disease']==1){
                                                        array_push($diagnosis, 'Heart disease');
                                                }
                                                if($myarray['rx_stroke']==1){
                                                        array_push($diagnosis, 'Stroke');
                                                }

                                                if($myarray['rx_apnea']==1){
                                                        array_push($diagnosis, 'Sleep apnea');
                                                }

                                                if($myarray['rx_diabetes']==1){
                                                        array_push($diagnosis, 'Diabetes');
                                                }

                                                if($myarray['rx_lung_disease']==1){
                                                        array_push($diagnosis, 'Lung disease');
                                                }

                                                if($myarray['rx_insomnia']==1){
                                                        array_push($diagnosis, 'Insomnia');
                                                }

                                                if($myarray['rx_depression']==1){
                                                        array_push($diagnosis, 'Depression');
                                                }

                                                if($myarray['rx_narcolepsy']==1){
                                                        array_push($diagnosis, 'Narcolepsy');
                                                }

                                                if($myarray['rx_medication']==1){
                                                        array_push($diagnosis, 'Sleeping medication');
                                                }

                                                if($myarray['rx_restless_leg']==1){
                                                        array_push($diagnosis, 'Restless Leg Syndrome');
                                                }

                                                if($myarray['rx_headaches']==1){
                                                        array_push($diagnosis, 'Morning headaches');
                                                }

                                                if($myarray['rx_heartburn']==1){
                                                        array_push($diagnosis, 'Heartburn (Gastroesophageal Reflux)');
                                                }

?>
					<a href="#" onclick="$('#diagnosis_count_<?=$myarray['id']; ?>').hide();$('#diagnosis_text_<?=$myarray['id']; ?>').show();" id="diagnosis_count_<?=$myarray['id']; ?>"><?= count($diagnosis); ?></a>
					<a href="#" onclick="$('#diagnosis_count_<?=$myarray['id']; ?>').show();$('#diagnosis_text_<?=$myarray['id']; ?>').hide();" id="diagnosis_text_<?=$myarray['id']; ?>" style="display:none;"><?= implode($diagnosis, ', '); ?></a></span>
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
