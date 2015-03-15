<?php namespace Ds3\Legacy; ?><?php
include "includes/top.htm";
include "includes/patient_nav.php";
?>
<ul class="nav nav-tabs nav-justified">
        <li>
            <a href="patient_clinical_exam.php?pid=<?php echo  $_GET['pid']; ?>" id="link_summ">Dental Exam</a>
        </li>
        <li>
            <a href="patient_clinical_exam2.php?pid=<?php echo  $_GET['pid']; ?>" id="link_notes">Vital Data/Tongue</a>
        </li>
        <li>
            <a href="patient_clinical_exam3.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">Mallampati/Tonsils</a>
        </li>
        <li class="active">
            <a href="patient_clinical_exam4.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">Airway Evaluation</a>
        </li>
        <li>
            <a href="patient_clinical_exam5.php?pid=<?php echo  $_GET['pid']; ?>" id="link_treatment">TMJ/ROM</a>
        </li>
    </ul>

    <p>&nbsp;</p>

<?php
if(!empty($_POST['ex_page3sub']) && $_POST['ex_page3sub'] == 1)
{
	$maxilla = $_POST['maxilla'];
	$other_maxilla = $_POST['other_maxilla'];
	$mandible = $_POST['mandible'];
	$other_mandible = $_POST['other_mandible'];
	$soft_palate = $_POST['soft_palate'];
	$other_soft_palate = $_POST['other_soft_palate'];
	$uvula = $_POST['uvula'];
	$other_uvula = $_POST['other_uvula'];
	$gag_reflex = $_POST['gag_reflex'];
	$other_gag_reflex = $_POST['other_gag_reflex'];
	$nasal_passages = $_POST['nasal_passages'];
	$other_nasal_passages = $_POST['other_nasal_passages'];
	
	$maxilla_arr = '';
	if(is_array($maxilla))
	{
		foreach($maxilla as $val)
		{
			if(trim($val) <> '')
				$maxilla_arr .= trim($val).'~';
		}
	}
	if($maxilla_arr != '')
		$maxilla_arr = '~'.$maxilla_arr;
		
	$mandible_arr = '';
	if(is_array($mandible))
	{
		foreach($mandible as $val)
		{
			if(trim($val) <> '')
				$mandible_arr .= trim($val).'~';
		}
	}
	if($mandible_arr != '')
		$mandible_arr = '~'.$mandible_arr;
		
	$soft_palate_arr = '';
	if(is_array($soft_palate))
	{
		foreach($soft_palate as $val)
		{
			if(trim($val) <> '')
				$soft_palate_arr .= trim($val).'~';
		}
	}
	if($soft_palate_arr != '')
		$soft_palate_arr = '~'.$soft_palate_arr;
		
	$uvula_arr = '';
	if(is_array($uvula))
	{
		foreach($uvula as $val)
		{
			if(trim($val) <> '')
				$uvula_arr .= trim($val).'~';
		}
	}
	if($uvula_arr != '')
		$uvula_arr = '~'.$uvula_arr;
		
	$gag_reflex_arr = '';
	if(is_array($gag_reflex))
	{
		foreach($gag_reflex as $val)
		{
			if(trim($val) <> '')
				$gag_reflex_arr .= trim($val).'~';
		}
	}
	if($gag_reflex_arr != '')
		$gag_reflex_arr = '~'.$gag_reflex_arr;
		
	$nasal_passages_arr = '';
	if(is_array($nasal_passages))
	{
		foreach($nasal_passages as $val)
		{
			if(trim($val) <> '')
				$nasal_passages_arr .= trim($val).'~';
		}
	}
	if($nasal_passages_arr != '')
		$nasal_passages_arr = '~'.$nasal_passages_arr;
	
	/*echo "maxilla - ".$maxilla_arr."<br>";
	echo "other_maxilla - ".$other_maxilla."<br>";
	echo "mandible - ".$mandible_arr."<br>";
	echo "other_mandible - ".$other_mandible."<br>";
	echo "soft_palate - ".$soft_palate_arr."<br>";
	echo "other_soft_palate - ".$other_soft_palate."<br>";
	echo "uvula - ".$uvula_arr."<br>";
	echo "other_uvula - ".$other_uvula."<br>";
	echo "gag_reflex - ".$gag_reflex_arr."<br>";
	echo "other_gag_reflex - ".$other_gag_reflex."<br>";
	echo "nasal_passages - ".$nasal_passages_arr."<br>";
	echo "other_nasal_passages - ".$other_nasal_passages."<br>";*/
	
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page3 set 
		patientid = '".s_for($_GET['pid'])."',
		maxilla = '".s_for($maxilla_arr)."',
		other_maxilla = '".s_for($other_maxilla)."',
		mandible = '".s_for($mandible_arr)."',
		other_mandible = '".s_for($other_mandible)."',
		soft_palate = '".s_for($soft_palate_arr)."',
		other_soft_palate = '".s_for($other_soft_palate)."',
		uvula = '".s_for($uvula_arr)."',
		other_uvula = '".s_for($other_uvula)."',
		gag_reflex = '".s_for($gag_reflex_arr)."',
		other_gag_reflex = '".s_for($other_gag_reflex)."',
		nasal_passages = '".s_for($nasal_passages_arr)."',
		other_nasal_passages = '".s_for($other_nasal_passages)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con,$ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?php echo $msg;?>");
                        window.location='ex_page5.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
		</script>
		<?
		}
		die();
	}
	else
	{
		$ed_sql = " update dental_ex_page3 set 
		maxilla = '".s_for($maxilla_arr)."',
		other_maxilla = '".s_for($other_maxilla)."',
		mandible = '".s_for($mandible_arr)."',
		other_mandible = '".s_for($other_mandible)."',
		soft_palate = '".s_for($soft_palate_arr)."',
		other_soft_palate = '".s_for($other_soft_palate)."',
		uvula = '".s_for($uvula_arr)."',
		other_uvula = '".s_for($other_uvula)."',
		gag_reflex = '".s_for($gag_reflex_arr)."',
		other_gag_reflex = '".s_for($other_gag_reflex)."',
		nasal_passages = '".s_for($nasal_passages_arr)."',
		other_nasal_passages = '".s_for($other_nasal_passages)."'
		where ex_page3id = '".s_for($_POST['ed'])."'";
		
		mysqli_query($con,$ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
                ?>
                <script type="text/javascript">
                        //alert("<?php echo $msg;?>");
                        window.location='ex_page5.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
                </script>
                <?
                }else{

		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
		</script>
		<?
		}
		die();
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con,$pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

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

$sql = "select * from dental_ex_page3 where patientid='".$_GET['pid']."'";
$my = mysqli_query($con,$sql);
$myarray = mysqli_fetch_array($my);

$ex_page3id = st($myarray['ex_page3id']);
$maxilla = st($myarray['maxilla']);
$other_maxilla = st($myarray['other_maxilla']);
$mandible = st($myarray['mandible']);
$other_mandible = st($myarray['other_mandible']);
$soft_palate = st($myarray['soft_palate']);
$other_soft_palate = st($myarray['other_soft_palate']);
$uvula = st($myarray['uvula']);
$other_uvula = st($myarray['other_uvula']);
$gag_reflex = st($myarray['gag_reflex']);
$other_gag_reflex = st($myarray['other_gag_reflex']);
$nasal_passages = st($myarray['nasal_passages']);
$other_nasal_passages = st($myarray['other_nasal_passages']);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<?php include("../includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form id="ex_page3frm" class="ex_form" name="ex_page3frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
<input type="hidden" name="ex_page3sub" value="1" />
<input type="hidden" name="ed" value="<?php echo $ex_page3id;?>" />
<input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />

<table style="clear:both;" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        <span class="form_info">
                        	OTHER AIRWAY ITEMS
                        </span>
                    </label>
				</li>
			</ul>
		</td>
	</tr>
    
    <tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Maxilla
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                        	<?
							$maxilla_sql = "select * from dental_maxilla where status=1 order by sortby";
							$maxilla_my = mysqli_query($con,$maxilla_sql);
							
							while($maxilla_myarray = mysqli_fetch_array($maxilla_my))
							{
							?>
								<input type="checkbox" id="maxilla" name="maxilla[]" value="<?php echo st($maxilla_myarray['maxillaid'])?>" <?php if(strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($maxilla_myarray['maxilla']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_maxilla" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_maxilla;?></textarea>
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
                        Mandible
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                        	<?
							$mandible_sql = "select * from dental_mandible where status=1 order by sortby";
							$mandible_my = mysqli_query($con,$mandible_sql);
							
							while($mandible_myarray = mysqli_fetch_array($mandible_my))
							{
							?>
								<input type="checkbox" id="mandible" name="mandible[]" value="<?php echo st($mandible_myarray['mandibleid'])?>" <?php if(strpos($mandible,'~'.st($mandible_myarray['mandibleid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($mandible_myarray['mandible']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_mandible" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_mandible;?></textarea>
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
                        Soft Palate
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                        	<?
							$soft_palate_sql = "select * from dental_soft_palate where status=1 order by sortby";
							$soft_palate_my = mysqli_query($con,$soft_palate_sql);
							
							while($soft_palate_myarray = mysqli_fetch_array($soft_palate_my))
							{
							?>
								<input type="checkbox" id="soft_palate" name="soft_palate[]" value="<?php echo st($soft_palate_myarray['soft_palateid'])?>" <?php if(strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($soft_palate_myarray['soft_palate']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div class="ta_half"> 
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_soft_palate" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_soft_palate;?></textarea>
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
                        Uvula
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                       <?php
							$uvula_sql = "select * from dental_uvula where status=1 order by sortby";
							$uvula_my = mysqli_query($con,$uvula_sql);
							//$uvula_prearray = mysqli_fetch_array($uvula_my);
							
							?>
                      <!--<input type="checkbox" name="uvula[]" id="uvula" onclick="showMe('uvuladiv')" value="1" <?php if(in_array("1", $uvula_prearray)){ echo "checked=\"checked\""; }?> >&nbsp;&nbsp;&nbsp;&nbsp;Not Clinically Present<br />
                      
                      <div id="uvuladiv" <?php if(in_array("1", $uvula_prearray)){ echo "style=\"display:none;\""; }?>> 
                      -->
                        	<?
							  
							while($uvula_myarray = mysqli_fetch_array($uvula_my))
							{
							?>
								<input type="checkbox" id="uvula" name="uvula[]" value="<?php echo st($uvula_myarray['uvulaid'])?>" <?php if(strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($uvula_myarray['uvula']);?><br />
							<?
							}
							?> <!--</div>-->
						
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_uvula" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_uvula;?></textarea>
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
                        Gag Reflex
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                        	<?
							$gag_reflex_sql = "select * from dental_gag_reflex where status=1 order by sortby";
							$gag_reflex_my = mysqli_query($con,$gag_reflex_sql);
							
							while($gag_reflex_myarray = mysqli_fetch_array($gag_reflex_my))
							{
							?>
								<input type="checkbox" id="gag_reflex" name="gag_reflex[]" value="<?php echo st($gag_reflex_myarray['gag_reflexid'])?>" <?php if(strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($gag_reflex_myarray['gag_reflex']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_gag_reflex" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_gag_reflex;?></textarea>
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
                        Nasal Passages
                    </label>
                    
                    <div class="cb_half">
                    	<span>
                        	<?
							$nasal_passages_sql = "select * from dental_nasal_passages where status=1 order by sortby";
							$nasal_passages_my = mysqli_query($con,$nasal_passages_sql);
							
							while($nasal_passages_myarray = mysqli_fetch_array($nasal_passages_my))
							{
							?>
								<input type="checkbox" id="nasal_passages" name="nasal_passages[]" value="<?php echo st($nasal_passages_myarray['nasal_passagesid'])?>" <?php if(strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?php echo st($nasal_passages_myarray['nasal_passages']);?><br />
							<?
							}
							?>
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_nasal_passages" class="field text addr tbox" style="width:650px; height:100px;"><?php echo $other_nasal_passages;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
    
    
         
</table>

</form>

<br />
<?php include("../includes/form_bottom.htm");?>
<br />



?>

<?php include "includes/bottom.htm";?>
