<?php 
include "includes/top.htm";
?>
<style type="text/css">
.cb_half{ width:200px; float: left; }
.ta_half{ width:200px; float:left; }
.ta_half textarea { width: 400px; }
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(':input:not(#patient_search)').change(function() { 
			window.onbeforeunload = confirmExit;
		});
		$('#ex_page3frm').submit(function() {
			window.onbeforeunload = null;
		});
	});
  function confirmExit()
  {
    return "You have attempted to leave this page.  If you have made any changes to the fields without clicking the Save button, your changes will be lost.  Are you sure you want to exit this page?";
  }
</script>
<?php
if($_POST['ex_page3sub'] == 1)
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
		foreach($mandible as $val)
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
		formid = '".s_for($_GET['fid'])."',
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
		
		mysql_query($ins_sql) or die($ins_sql." | ".mysql_error());
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
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
		
		mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		die();
	}
}


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

$sql = "select * from dental_ex_page3 where formid='".$_GET['fid']."' and patientid='".$_GET['pid']."'";
$my = mysql_query($sql);
$myarray = mysql_fetch_array($my);

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
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>

<a name="top"></a>
&nbsp;&nbsp;

<? include("includes/form_top.htm");?>

<br />
<br>

<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form id="ex_page3frm" name="ex_page3frm" action="<?=$_SERVER['PHP_SELF'];?>?fid=<?=$_GET['fid']?>&pid=<?=$_GET['pid']?>" method="post">
<input type="hidden" name="ex_page3sub" value="1" />
<input type="hidden" name="ed" value="<?=$ex_page3id;?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
	<input type="reset" value="Reset" />
	<input type="submit" name="ex_pagebtn" value="Save" />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
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
							$maxilla_my = mysql_query($maxilla_sql);
							
							while($maxilla_myarray = mysql_fetch_array($maxilla_my))
							{
							?>
								<input type="checkbox" id="maxilla" name="maxilla[]" value="<?=st($maxilla_myarray['maxillaid'])?>" <? if(strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($maxilla_myarray['maxilla']);?><br />
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
                            <textarea name="other_maxilla" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_maxilla;?></textarea>
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
							$mandible_my = mysql_query($mandible_sql);
							
							while($mandible_myarray = mysql_fetch_array($mandible_my))
							{
							?>
								<input type="checkbox" id="mandible" name="mandible[]" value="<?=st($mandible_myarray['mandibleid'])?>" <? if(strpos($mandible,'~'.st($mandible_myarray['mandibleid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($mandible_myarray['mandible']);?><br />
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
                            <textarea name="other_mandible" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_mandible;?></textarea>
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
							$soft_palate_my = mysql_query($soft_palate_sql);
							
							while($soft_palate_myarray = mysql_fetch_array($soft_palate_my))
							{
							?>
								<input type="checkbox" id="soft_palate" name="soft_palate[]" value="<?=st($soft_palate_myarray['soft_palateid'])?>" <? if(strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($soft_palate_myarray['soft_palate']);?><br />
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
                            <textarea name="other_soft_palate" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_soft_palate;?></textarea>
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
							$uvula_my = mysql_query($uvula_sql);
							$uvula_prearray = mysql_fetch_array($uvula_my);
							
							?>
                      <input type="checkbox" name="uvula[]" id="uvula" onclick="showMe('uvuladiv')" value="1" <?php if(in_array("1", $uvula_prearray)){ echo "checked=\"checked\""; }?> >&nbsp;&nbsp;&nbsp;&nbsp;Not Clinically Present<br />
                      
                      <div id="uvuladiv" <?php if(in_array("1", $uvula_prearray)){ echo "style=\"display:none;\""; }?>> 
                      
                        	<?
							  
							while($uvula_myarray = mysql_fetch_array($uvula_my))
							{
							?>
								<input type="checkbox" id="uvula" name="uvula[]" value="<?=st($uvula_myarray['uvulaid'])?>" <? if(strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($uvula_myarray['uvula']);?><br />
							<?
							}
							?> </div>
						
                        </span>
                   	</div>
                    <div class="ta_half">
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_uvula" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_uvula;?></textarea>
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
							$gag_reflex_my = mysql_query($gag_reflex_sql);
							
							while($gag_reflex_myarray = mysql_fetch_array($gag_reflex_my))
							{
							?>
								<input type="checkbox" id="gag_reflex" name="gag_reflex[]" value="<?=st($gag_reflex_myarray['gag_reflexid'])?>" <? if(strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($gag_reflex_myarray['gag_reflex']);?><br />
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
                            <textarea name="other_gag_reflex" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_gag_reflex;?></textarea>
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
							$nasal_passages_my = mysql_query($nasal_passages_sql);
							
							while($nasal_passages_myarray = mysql_fetch_array($nasal_passages_my))
							{
							?>
								<input type="checkbox" id="nasal_passages" name="nasal_passages[]" value="<?=st($nasal_passages_myarray['nasal_passagesid'])?>" <? if(strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') === false) {} else { echo " checked";}?> />
                                &nbsp;&nbsp;
                                <?=st($nasal_passages_myarray['nasal_passages']);?><br />
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
                            <textarea name="other_nasal_passages" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_nasal_passages;?></textarea>
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
    <input type="submit" name="q_pagebtn" value="Save" />
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
