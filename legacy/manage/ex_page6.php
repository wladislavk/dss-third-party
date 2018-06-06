<?php namespace Ds3\Libraries\Legacy; ?><? 
include "includes/top.htm";

$db = new Db();
$baseTable = 'dental_ex_page6_view';
$baseSearch = [
    'patientid' => '$patientId',
    'docid' => '$docId'
];

/**
 * Define $patientId, $docId, $userId, $adminId
 * Define $isHistoricView, $historyId, $snapshotDate
 * Define $historyTable, $sourceTable
 * Define $isCreateNew, $isBackupTable
 *
 * Backup tables as needed
 */
require_once __DIR__ . '/includes/form-backup-setup.php';

if(!$isHistoricView && $_POST['ex_page6sub'] == 1)
{
	$completed = $_POST['completed'];
	$recommended = $_POST['recommended'];
	$other_diagnostic = $_POST['other_diagnostic'];
	$additional_paragraph = $_POST['additional_paragraph'];
	
	$completed_arr = '';
	if(is_array($completed))
	{
		foreach($completed as $val)
		{
			if(trim($val) <> '')
				$completed_arr .= trim($val).'~';
		}
	}
	if($completed_arr != '')
		$completed_arr = '~'.$completed_arr;
		
	$recommended_arr = '';
	if(is_array($recommended))
	{
		foreach($recommended as $val)
		{
			if(trim($val) <> '')
				$recommended_arr .= trim($val).'~';
		}
	}
	if($recommended_arr != '')
		$recommended_arr = '~'.$recommended_arr;
	
	if($_POST['ed'] == '')
	{
		$ins_sql = " insert into dental_ex_page6 set 
		patientid = '".s_for($_GET['pid'])."',
		completed = '".s_for($completed_arr)."',
		recommended = '".s_for($recommended_arr)."',
		other_diagnostic = '".s_for($other_diagnostic)."',
		additional_paragraph = '".s_for($additional_paragraph)."',
		userid = '".s_for($_SESSION['userid'])."',
		docid = '".s_for($_SESSION['docid'])."',
		adddate = now(),
		ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
		
		mysqli_query($con, $ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);
		
		$msg = "Added Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
	else
	{
		$ed_sql = " update dental_ex_page6_view set 
		completed = '".s_for($completed_arr)."',
		recommended = '".s_for($recommended_arr)."',
		other_diagnostic = '".s_for($other_diagnostic)."',
		additional_paragraph = '".s_for($additional_paragraph)."'
		where ex_page6id = '".s_for($_POST['ed'])."'";
		
		mysqli_query($con, $ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
		
		$msg = "Edited Successfully";
		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			window.location='<?=$_POST['goto_p']?>.php?pid=<?=$_GET['pid']?>&msg=<?=$msg;?>';
		</script>
		<?
		trigger_error("Die called", E_USER_ERROR);
	}
}


$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con, $pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

$sql = "select *
    from $sourceTable
    where patientid = '$patientId'
        $andHistoryIdConditional
        $andNullConditional";

$my = mysqli_query($con, $sql);
$myarray = mysqli_fetch_array($my);

$ex_page6id = st($myarray['ex_page6id']);
$completed = st($myarray['completed']);
$recommended = st($myarray['recommended']);
$other_diagnostic = st($myarray['other_diagnostic']);
$additional_paragraph = st($myarray['additional_paragraph']);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/form.css" type="text/css" />

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

<form name="ex_page6frm" class="ex_form" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?=$_GET['pid']?><?= $isHistoricView ? "&history_id=$historyId" : '' ?>" method="post">
<input type="hidden" name="ex_page6sub" value="1" />
    <input type="hidden" name="ed" value="<?= $targetId ?: '' ?>" />
    <input type="hidden" name="backup_table" value="<?= $isCreateNew ?>" />
<input type="hidden" name="goto_p" value="<?=$cur_page?>" />

<div align="right">
    <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
	<input type="submit" name="ex_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
    <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" <?= $isHistoricView ? 'disabled' : '' ?> />
    &nbsp;&nbsp;&nbsp;
</div>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
	<tr>
        <td valign="top" class="frmhead">
        	<ul>
                <li id="foli8" class="complex">	
                    <label class="desc" id="title0" for="Field0">
                        Diagnostic Testing
                    </label>
                    
                    <div>
                    	<span class="full">
                        	<table width="100%" cellpadding="3" cellspacing="1" >
                            	<tr>
                                	<td valign="top" width="10%">
                                    	Completed
                                    </td>
                                	<td valign="top" width="10%">
                                    	Recommended
                                    </td>
                                	<td valign="top" width="80%">&nbsp;
                                    	
                                    </td>
                                </tr>
                                
                                <?
								$diagnostic_sql = "select * from dental_diagnostic where status=1 order by sortby";
								$diagnostic_my = mysqli_query($con, $diagnostic_sql);
								
								while($diagnostic_myarray = mysqli_fetch_array($diagnostic_my))
								{	
								?>
                                <tr>
                                	<td valign="top">
										<input type="checkbox" id="completed" name="completed[]" value="<?=st($diagnostic_myarray['diagnosticid'])?>" <? if(strpos($completed,'~'.st($diagnostic_myarray['diagnosticid']).'~') === false) {} else { echo " checked";}?> style="width:10px;" />
                                     </td>
                                     <td valign="top">
                                     	<input type="checkbox" id="recommended" name="recommended[]" value="<?=st($diagnostic_myarray['diagnosticid'])?>" <? if(strpos($recommended,'~'.st($diagnostic_myarray['diagnosticid']).'~') === false) {} else { echo " checked";}?> style="width:10px;" />
                                     </td>
                                     <td valign="top">
                                     	<span>
										<?=st($diagnostic_myarray['diagnostic']);?>
                                        </span>
                                     </td>
                                  </tr>	
								<? 
								}?>
                                
                            </table>
                        </span>
                   	</div>
                    <div>
                        <span>
                        	<span style="color:#000000; padding-top:0px;">
                            	Other Items<br />
                            </span>
                            (Enter Each on Different Line)<br />
                            <textarea name="other_diagnostic" class="field text addr tbox" style="width:650px; height:100px;"><?=$other_diagnostic;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                    <label class="desc" id="title0" for="Field0">
                        Additional Paragraph
                        /
                        <button onclick="Javascript: loadPopup('select_custom_all.php?fr=ex_page6frm&tx=additional_paragraph'); getElementById('popupContact').style.top = '600px'; return false;">Custom Text</button>
                    </label>
                    
                    <div>
                    	<span>
                        	<textarea name="additional_paragraph" class="field text addr tbox" style="width:650px; height:100px;"><?=$additional_paragraph;?></textarea>
                        </span>
                    </div>
                    <br />
                    
                </li>
            </ul>
        </td>
    </tr>
</table>

<div align="right">
	<input type="reset" value="Reset" <?= $isHistoricView ? 'disabled' : '' ?> />
    <input type="submit" value="" style="visibility: hidden; width: 0px; height: 0px; position: absolute;" onclick="return false;" onsubmit="return false;" onchange="return false;" />
    <button class="do-backup hidden" title="Save a copy of the last saved values">
        <span class="done">Archive page</span>
        <span class="in-progress" style="display:none;">Archiving... <img src="/manage/images/loading.gif" alt=""></span>
    </button>
    <input type="reset" value="Undo Changes" <?= $isHistoricView ? 'disabled' : '' ?> />
    <input type="submit" name="ex_pagebtn" value="Save" <?= $isHistoricView ? 'disabled' : '' ?> />
    <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" <?= $isHistoricView ? 'disabled' : '' ?> />
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
<?php include __DIR__ . '/includes/vue-setup.htm'; ?>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
<? include "includes/bottom.htm";?>
