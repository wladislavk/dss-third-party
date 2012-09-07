<?php 
include "includes/header.php";
include 'includes/questionnaire_sections.php';
?>
<link rel="stylesheet" href="css/questionnaire.css" />
<?php
if($_POST['q_sleepsub'] == 1)
{
	$epworth_sql = "select * from dental_epworth where status=1 order by sortby";
	$epworth_my = mysql_query($epworth_sql);
	
	$epworth_arr = '';
	
	while($epworth_myarray = mysql_fetch_array($epworth_my))
	{
		if($_POST['epworth_'.$epworth_myarray['epworthid']] <> '')
		{
			$epworth_arr .= $epworth_myarray['epworthid'].'|'.$_POST['epworth_'.$epworth_myarray['epworthid']].'~';
		}
	}
	
	$analysis = $_POST['analysis'];
        $snore_1 = $_POST['snore_1'];
        $snore_2 = $_POST['snore_2'];
        $snore_3 = $_POST['snore_3'];
        $snore_4 = $_POST['snore_4'];
        $snore_5 = $_POST['snore_5'];
        $tot_score = $_POST['tot_score'];
	
	/*echo "epworthid - ".$epworth_arr."<br>";
	echo "analysis - ".$analysis."<br>";*/
	

        if($_POST['ed'] == '')
        {
                $ins_sql = " insert into dental_q_sleep set 
                patientid = '".s_for($_SESSION['pid'])."',
                epworthid = '".s_for($epworth_arr)."',
                analysis = '".s_for($analysis)."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
                $ins_sql = " insert into dental_thorton set 
                patientid = '".s_for($_SESSION['pid'])."',
                snore_1 = '".s_for($snore_1)."',
                snore_2 = '".s_for($snore_2)."',
                snore_3 = '".s_for($snore_3)."',
                snore_4 = '".s_for($snore_4)."',
                snore_5 = '".s_for($snore_5)."',
                tot_score = '".s_for($tot_score)."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
        $exist_sql = "SELECT patientid FROM dental_q_page1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        if(mysql_num_rows($exist_q) == 0)
        {
		$ed_sql = "insert into dental_q_page1 set
                        ess='".mysql_real_escape_string($_POST['epTot'])."',
                        tss='".s_for($tot_score)."',
                        patientid='".$_SESSION['pid']."'";
                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
        }else{
                $ed_sql = "update dental_q_page1 set
                        ess='".mysql_real_escape_string($_POST['epTot'])."',
                        tss='".s_for($tot_score)."'
                        WHERE patientid='".$_SESSION['pid']."'";
                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
	}
                mysql_query("UPDATE dental_patients SET sleep_status=1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
                mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
                $msg = "Added Successfully";
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        window.location='<?=$_POST['goto_p']; ?>?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
                </script>
                <?
                die();
        }
        else
        {
	
		$ed_sql = " update dental_q_sleep set 
		epworthid = '".s_for($epworth_arr)."',
		analysis = '".s_for($analysis)."'
		where q_sleepid = '".s_for($_POST['ed'])."'";
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		$ed_sql = " update dental_thorton set 
                snore_1 = '".s_for($snore_1)."',
                snore_2 = '".s_for($snore_2)."',
                snore_3 = '".s_for($snore_3)."',
                snore_4 = '".s_for($snore_4)."',
                snore_5 = '".s_for($snore_5)."',
                tot_score = '".s_for($tot_score)."'
                where thortonid = '".s_for($_POST['ted'])."'";

                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
        $exist_sql = "SELECT patientid FROM dental_q_page1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        if(mysql_num_rows($exist_q) == 0)
        {
                $ed_sql = "insert into dental_q_page1 set
                        ess='".mysql_real_escape_string($_POST['epTot'])."',
                        tss='".s_for($tot_score)."',
                        patientid='".$_SESSION['pid']."'";
                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
        }else{

		$ed_sql = "update dental_q_page1 set
			ess='".mysql_real_escape_string($_POST['epTot'])."',
			tss='".s_for($tot_score)."'
			WHERE patientid='".$_SESSION['pid']."'";
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		//echo $ed_sql;
	}
                mysql_query("UPDATE dental_patients SET sleep_status=1 WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
                mysql_query("UPDATE dental_patients SET symptoms_status=2, sleep_status=2, treatments_status=2, history_status=2 WHERE symptoms_status=1 AND sleep_status=1 AND treatments_status=1 AND history_status=1 AND patientid='".mysql_real_escape_string($_SESSION['pid'])."'");
		$msg = " Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?= $_POST['goto_p']; ?>?msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


        $exist_sql = "SELECT sleep_status, symptoms_status FROM dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'";
        $exist_q = mysql_query($exist_sql);
        $exist_row = mysql_fetch_assoc($exist_q);
        if($exist_row['sleep_status'] == 0 && ($exist_row['symptoms_status'] == 0 || $exist_row['symptoms_status']==1))
        {

$sql = "select * from dental_thorton where patientid='".$_SESSION['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$thortonid = st($myarray['thortonid']);
$snore_1 = st($myarray['snore_1']);
$snore_2 = st($myarray['snore_2']);
$snore_3 = st($myarray['snore_3']);
$snore_4 = st($myarray['snore_4']);
$snore_5 = st($myarray['snore_5']);
$tot_score = st($myarray['tot_score']);

$pat_sql = "select * from dental_patients where patientid='".s_for($_SESSION['pid'])."'";
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

$sql = "select * from dental_q_sleep where patientid='".$_SESSION['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

$q_sleepid = st($myarray['q_sleepid']);
$epworthid = st($myarray['epworthid']);
$analysis = st($myarray['analysis']);

if($epworthid <> '')
{	
	$epworth_arr1 = split('~',$epworthid);
	
	foreach($epworth_arr1 as $i => $val)
	{
		$epworth_arr2 = explode('|',$val);
		
		$epid[$i] = $epworth_arr2[0];
		$epseq[$i] = $epworth_arr2[1];
	}
}

?>

<a name="top"></a>
<?php include 'includes/questionnaire_header.php'; ?>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form id="q_sleepfrm" class="q_form" name="q_sleepfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
<input type="hidden" name="q_sleepsub" value="1" />
<input type="hidden" name="ed" value="<?=$q_sleepid;?>" />
<input type="hidden" id="goto_p" name="goto_p" value="treatments.php" />

<div class="formEl_a">
<h3>Epworth Sleep Questionnaire</h3>
	<div class="legend">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = No chance of dozing<br />
                        <strong>1</strong> = Slight chance of dozing<br />
                        <strong>2</strong> = Moderate chance of dozing<br />
                        <strong>3</strong> = High chance of dozing<br />
	</div>
                    <? 
					$epworth_sql = "select * from dental_epworth where status=1 order by sortby";
					$epworth_my = mysql_query($epworth_sql);
					$epworth_number = mysql_num_rows($epworth_my);
					?>
                    
                        	<script type="text/javascript">
								function cal_analaysis(fa)
								{
									var an_tot = 0;
									/*									
									alert(document.q_sleepfrm.elements.length);
									for(i=0; i<document.q_sleepfrm.elements.length; i++)
									{
										if(document.q_sleepfrm.elements[i].type == 'select-one')
										{
											if(document.q_sleepfrm.elements[i].value != '')
											{
												an_tot = an_tot + parseInt(document.q_sleepfrm.elements[i].value, 10);
											}
										}
									}
									*/
									an_tot += parseInt($('#epworth_1').val());
                                                                        an_tot += parseInt($('#epworth_3').val());
                                                                        an_tot += parseInt($('#epworth_4').val());
                                                                        an_tot += parseInt($('#epworth_5').val());
                                                                        an_tot += parseInt($('#epworth_6').val());
                                                                        an_tot += parseInt($('#epworth_7').val());
                                                                        an_tot += parseInt($('#epworth_8').val());
									if(an_tot < 8)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a normal amount of sleepiness.';
									}
									
									if (an_tot >= 8 && an_tot < 10)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+',  which indicates a average amount of sleepiness.';
									}
									
									if (an_tot >= 10 && an_tot < 16)
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which may indicate excessive sleepiness depending on the situation. The patient may want to seek medical attention.';
									}
									
									if (an_tot >= 16 )
									{
										an_text = 'The Epworth Sleepiness Scale score was '+an_tot+', which indicates excessive sleepiness and medical attention should be sought.';
									}
									
									document.q_sleepfrm.analysis.value = an_text;
									document.q_sleepfrm.epTot.value = an_tot;
									//alert("Tot: " + an_tot+"\nText: "+an_text);
								}
							</script>
                    <?
                                        while($epworth_myarray = mysql_fetch_array($epworth_my))
                                        {
                                                if(@array_search($epworth_myarray['epworthid'],$epid) === false)
                                                {
                                                        $chk = '';
                                                }
                                                else
                                                {
                                                        $chk = $epseq[@array_search($epworth_myarray['epworthid'],$epid)];                                                }

                                        ?>
	<div class="sepH_b half">
		<label class="lbl_in"><?=st($epworth_myarray['epworth']);?></label>
                        	<select id="epworth_<?=st($epworth_myarray['epworthid']);?>" name="epworth_<?=st($epworth_myarray['epworthid']);?>" class="inpt_in" onchange="cal_analaysis(this.value);">
                                <option value="0" <? if($chk == '0') echo " selected";?>>0</option>
                                <option value="1" <? if($chk == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($chk == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($chk == 3) echo " selected";?>>3</option>
                            </select>
                    </div>
                    <? }?>
                            	<h5 class="clear">Analysis</h5>
                            <textarea name="analysis" class="field text addr tbox" style="width:650px; height:100px;"><?=$analysis;?></textarea>
			    <input type="hidden" name="epTot" />
<script type="text/javascript">
cal_analaysis(0);
</script>
<br /><br />
        <h3>Thornton Snoring Scale</h3>
<script type="text/javascript">
        function cal_snore()
        {
                var fa = document.q_sleepfrm;
                
                var tot = parseInt(fa.snore_1.value) + parseInt(fa.snore_2.value) + parseInt(fa.snore_3.value) + parseInt(fa.snore_4.value) + parseInt(fa.snore_5.value); 
                
                fa.tot_score.value = tot;
        }
</script>

<input type="hidden" name="thortonsub" value="1" />
<input type="hidden" name="ted" value="<?=$thortonid;?>" />
<div class="legend">
                        Using the following scale, choose the most appropriate number for each situation.

                        <br />
                        <strong>0</strong> = Never<br />
                        <strong>1</strong> = Infrequently (1 night per week)<br />
                        <strong>2</strong> = Frequently (2-3 nights per week)<br />
                        <strong>3</strong> = Most of the time (4 or more nights)<br />
</div>
                <div class="sepH_b half">        
			<label class="lbl_in">1. My snoring affects my relationship with my partner:</label>
                        <select name="snore_1" onchange="Javascript: cal_snore()" class="inpt_in">
                                <option value="0" <? if($snore_1 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_1 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_1 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_1 == 3) echo " selected";?>>3</option>
                        </select>
		</div>
		<div class="sepH_b half">
                        <label class="lbl_in">2. My snoring causes my partner to be irritable or tired:</label>
                        <select name="snore_2" onchange="Javascript: cal_snore()" class="inpt_in">
                                <option value="0" <? if($snore_2 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_2 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_2 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_2 == 3) echo " selected";?>>3</option>
                        </select>
		</div>
		<div class="sepH_b half">
                        <label class="lbl_in">3. My snoring requires us to sleep in separate rooms:</label>
                        <select name="snore_3" onchange="Javascript: cal_snore()" class="inpt_in">
                                <option value="0" <? if($snore_3 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_3 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_3 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_3 == 3) echo " selected";?>>3</option>
                        </select>
		</div>
		<div class="sepH_b half">
                        <label class="lbl_in">4. My snoring is loud:</label>
                        <select name="snore_4" onchange="Javascript: cal_snore()" class="inpt_in">
                                <option value="0" <? if($snore_4 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_4 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_4 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_4 == 3) echo " selected";?>>3</option>
                        </select>
		</div>
		<div class="sepH_b half">
                        <label class="lbl_in">5. My snoring affects people when I am sleeping away from home:</label>
                        <select name="snore_5" onchange="Javascript: cal_snore()" class="inpt_in">
                                <option value="0" <? if($snore_5 == 0) echo " selected";?>>0</option>
                                <option value="1" <? if($snore_5 == 1) echo " selected";?>>1</option>
                                <option value="2" <? if($snore_5 == 2) echo " selected";?>>2</option>
                                <option value="3" <? if($snore_5 == 3) echo " selected";?>>3</option>
                        </select>
		</div>
                        <h5 class="clear">Your Score:</h5>
                        <input type="text" name="tot_score" value="<?= $tot_score; ?>" class="tbox" style="width:80px;" readonly="readonly" >
                        <b>A score of 5 or greater indicates your snoring may be significantly affecting your quality of life.  </b>
<script type="text/javascript">
  $('document').ready( function(){
        cal_snore();
 });
</script>







<p class="confirm_text">Thank you for completing the Epworth/Thorton Questionnaire! Please click the box below to confirm and record your answers. </p>


<div align="right">
    <input type="submit" name="q_pagebtn" class="next btn btn_d" value="Save and Proceed" />
    &nbsp;&nbsp;&nbsp;
</div>
</form>
<?php }else{
show_section_completed($_SESSION['pid']);
} ?>
<? include "includes/footer.php";?>

