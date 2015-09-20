<?php namespace Ds3\Libraries\Legacy; ?><?php 

use Illuminate\Support\Facades\App;

$dentalexpage3 = App::make('Ds3\Contracts\DentalExPage3Interface');

	include "includes/top.htm";
	include_once('includes/patient_info.php');
	if ($patient_info) {
?>
	<link rel="stylesheet" href="css/ex_page3.css" type="text/css" />
	<script type="text/javascript" src="js/ex_page3.js"></script>

<?php
		if(!empty($_POST['ex_page3sub']) && $_POST['ex_page3sub'] == 1) {
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
					if(trim($val) <> '') $maxilla_arr .= trim($val).'~';
				}
			}

			if($maxilla_arr != '') $maxilla_arr = '~'.$maxilla_arr;
				
			$mandible_arr = '';
			if(is_array($mandible))
			{
				foreach($mandible as $val)
				{
					if(trim($val) <> '') $mandible_arr .= trim($val).'~';
				}
			}

			if($mandible_arr != '') $mandible_arr = '~'.$mandible_arr;
		
			$soft_palate_arr = '';
			if(is_array($soft_palate))
			{
				foreach($soft_palate as $val)
				{
					if(trim($val) <> '') $soft_palate_arr .= trim($val).'~';
				}
			}

			if($soft_palate_arr != '') $soft_palate_arr = '~'.$soft_palate_arr;
				
			$uvula_arr = '';
			if(is_array($uvula))
			{
				foreach($uvula as $val)
				{
					if(trim($val) <> '') $uvula_arr .= trim($val).'~';
				}
			}

			if($uvula_arr != '') $uvula_arr = '~'.$uvula_arr;
		
			$gag_reflex_arr = '';
			if(is_array($gag_reflex))
			{
				foreach($gag_reflex as $val)
				{
					if(trim($val) <> '') $gag_reflex_arr .= trim($val).'~';
				}
			}

			if($gag_reflex_arr != '') $gag_reflex_arr = '~'.$gag_reflex_arr;
				
			$nasal_passages_arr = '';
			if(is_array($nasal_passages))
			{
				foreach($nasal_passages as $val)
				{
					if(trim($val) <> '') $nasal_passages_arr .= trim($val).'~';
				}
			}

			if($nasal_passages_arr != '')
				$nasal_passages_arr = '~'.$nasal_passages_arr;
	
			if($_POST['ed'] == '')
			{
				// $ins_sql = " insert into dental_ex_page3 set 
				// patientid = '".s_for($_GET['pid'])."',
				// maxilla = '".s_for($maxilla_arr)."',
				// other_maxilla = '".s_for($other_maxilla)."',
				// mandible = '".s_for($mandible_arr)."',
				// other_mandible = '".s_for($other_mandible)."',
				// soft_palate = '".s_for($soft_palate_arr)."',
				// other_soft_palate = '".s_for($other_soft_palate)."',
				// uvula = '".s_for($uvula_arr)."',
				// other_uvula = '".s_for($other_uvula)."',
				// gag_reflex = '".s_for($gag_reflex_arr)."',
				// other_gag_reflex = '".s_for($other_gag_reflex)."',
				// nasal_passages = '".s_for($nasal_passages_arr)."',
				// other_nasal_passages = '".s_for($other_nasal_passages)."',
				// userid = '".s_for($_SESSION['userid'])."',
				// docid = '".s_for($_SESSION['docid'])."',
				// adddate = now(),
				// ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
				$ins_sql = array(
					'patientid' => s_for($_GET['pid']),
					'maxilla' => s_for($maxilla_arr),
					'other_maxilla' => s_for($other_maxilla),
					'mandible' => s_for($mandible_arr),
					'other_mandible' => s_for($other_mandible),
					'soft_palate' => s_for($soft_palate_arr),
					'other_soft_palate' => s_for($other_soft_palate),
					'uvula' => s_for($uvula_arr),
					'other_uvula' => s_for($other_uvula),
					'gag_reflex' => s_for($gag_reflex_arr),
					'other_gag_reflex' => s_for($other_gag_reflex),
					'nasal_passages' => s_for($nasal_passages_arr),
					'other_nasal_passages' => s_for($other_nasal_passages),
					'userid' => s_for($_SESSION['userid']),
					'docid' => s_for($_SESSION['docid']),
					'adddate' => date("Y-m-d H:i:s"),
					'ip_address' => s_for($_SERVER['REMOTE_ADDR'])
			);

				// $db->query($ins_sql);
				$dentalexpage3->save($ins_sql);
				$msg = "Added Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
	                    window.location='ex_page5.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
                } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				trigger_error("Die called", E_USER_ERROR);
			} else {
				// $ed_sql = " update dental_ex_page3 set 
				// maxilla = '".s_for($maxilla_arr)."',
				// other_maxilla = '".s_for($other_maxilla)."',
				// mandible = '".s_for($mandible_arr)."',
				// other_mandible = '".s_for($other_mandible)."',
				// soft_palate = '".s_for($soft_palate_arr)."',
				// other_soft_palate = '".s_for($other_soft_palate)."',
				// uvula = '".s_for($uvula_arr)."',
				// other_uvula = '".s_for($other_uvula)."',
				// gag_reflex = '".s_for($gag_reflex_arr)."',
				// other_gag_reflex = '".s_for($other_gag_reflex)."',
				// nasal_passages = '".s_for($nasal_passages_arr)."',
				// other_nasal_passages = '".s_for($other_nasal_passages)."'
				// where ex_page3id = '".s_for($_POST['ed'])."'";
				$ed_sql = array(
					'maxilla' => s_for($maxilla_arr),
					'other_maxilla' => s_for($other_maxilla),
					'mandible' => s_for($mandible_arr),
					'other_mandible' => s_for($other_mandible),
					'soft_palate' => s_for($soft_palate_arr),
					'other_soft_palate' => s_for($other_soft_palate),
					'uvula' => s_for($uvula_arr),
					'other_uvula' => s_for($other_uvula),
					'gag_reflex' => s_for($gag_reflex_arr),
					'other_gag_reflex' => s_for($other_gag_reflex),
					'nasal_passages' => s_for($nasal_passages_arr),
					'other_nasal_passages' => s_for($other_nasal_passages)
				);

				// $db->query($ed_sql);
				$dentalexpage3->update($ed_sql, s_for($_POST['ed']));

				$msg = "Edited Successfully";
                if(isset($_POST['ex_pagebtn_proceed'])){
?>
	                <script type="text/javascript">
	                    window.location='ex_page5.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
	                </script>
<?php
                } else {
?>
					<script type="text/javascript">
						window.location='<?php echo $_POST['goto_p']?>.php?pid=<?php echo $_GET['pid']?>&msg=<?php echo $msg;?>';
					</script>
<?php
				}
				trigger_error("Die called", E_USER_ERROR);
			}
		}		

		// $pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";

		// $pat_myarray = $db->getRow($pat_sql);
		$pat_myarray = $dentalexpage3->findFromDentalPatients(s_for($_GET['pid']));
		$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);
		if($pat_myarray['patientid'] == '')
		{
?>
			<script type="text/javascript">
				window.location = 'manage_patient.php';
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}

		// $sql = "select * from dental_ex_page3 where patientid='".$_GET['pid']."'";

		// $myarray = $db->getRow($sql);
		$myarray = $dentalexpage3->where('patientid',$_GET['pid']);
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

	<?php include("includes/form_top.htm");?>

	<br /><br>
	<div align="center" class="red">
		<b><?php  echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
	</div>

	<form id="ex_page3frm" class="ex_form" name="ex_page3frm" action="<?php echo $_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']?>" method="post">
		<input type="hidden" name="ex_page3sub" value="1" />
		<input type="hidden" name="ed" value="<?php echo $ex_page3id;?>" />
		<input type="hidden" name="goto_p" value="<?php echo $cur_page?>" />
		<div style="float:left; margin-left:10px;">
        	<input type="reset" value="Undo Changes" />
		</div>
		<div style="float:right;">
	        <input type="submit" name="ex_pagebtn" value="Save" />
	        <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" />
		    &nbsp;&nbsp;&nbsp;
		</div>
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
		                        	<?php
										$maxilla_sql = "select * from dental_maxilla where status=1 order by sortby";
										
										$maxilla_my = $db->getResults($maxilla_sql);
										foreach ($maxilla_my as $maxilla_myarray) {
									?>
										<input type="checkbox" id="maxilla" name="maxilla[]" value="<?php echo st($maxilla_myarray['maxillaid'])?>" <?php  if(strpos($maxilla,'~'.st($maxilla_myarray['maxillaid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
		                                <?php echo st($maxilla_myarray['maxilla']);?><br />
									<?php
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
		                        	<?php
										$mandible_sql = "select * from dental_mandible where status=1 order by sortby";
										
										$mandible_my = $db->getResults($mandible_sql);
										foreach ($mandible_my as $mandible_myarray) {
									?>
										<input type="checkbox" id="mandible" name="mandible[]" value="<?php echo st($mandible_myarray['mandibleid'])?>" <?php  if(strpos($mandible,'~'.st($mandible_myarray['mandibleid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
		                                <?php echo st($mandible_myarray['mandible']);?><br />
									<?php
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
		                        	<?php
										$soft_palate_sql = "select * from dental_soft_palate where status=1 order by sortby";
										
										$soft_palate_my = $db->getResults($soft_palate_sql);
										foreach ($soft_palate_my as $soft_palate_myarray) {
									?>
										<input type="checkbox" id="soft_palate" name="soft_palate[]" value="<?php echo st($soft_palate_myarray['soft_palateid'])?>" <?php  if(strpos($soft_palate,'~'.st($soft_palate_myarray['soft_palateid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
                                		<?php echo st($soft_palate_myarray['soft_palate']);?><br />
									<?php
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
										
										$uvula_my = $db->getResults($uvula_sql);									
						  				foreach ($uvula_my as $uvula_myarray) {
									?>
										<input type="checkbox" id="uvula" name="uvula[]" value="<?php echo st($uvula_myarray['uvulaid'])?>" <?php  if(strpos($uvula,'~'.st($uvula_myarray['uvulaid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
		                                <?php echo st($uvula_myarray['uvula']);?><br />
									<?php
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
		                        	<?php
										$gag_reflex_sql = "select * from dental_gag_reflex where status=1 order by sortby";
										
										$gag_reflex_my = $db->getResults($gag_reflex_sql);
										foreach ($gag_reflex_my as $gag_reflex_myarray) {
									?>
										<input type="checkbox" id="gag_reflex" name="gag_reflex[]" value="<?php echo st($gag_reflex_myarray['gag_reflexid'])?>" <?php  if(strpos($gag_reflex,'~'.st($gag_reflex_myarray['gag_reflexid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
		                                <?php echo st($gag_reflex_myarray['gag_reflex']);?><br />
									<?php
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
		                        	<?php
										$nasal_passages_sql = "select * from dental_nasal_passages where status=1 order by sortby";
										
										$nasal_passages_my = $db->getResults($nasal_passages_sql);
										foreach ($nasal_passages_my as $nasal_passages_myarray) {
									?>
										<input type="checkbox" id="nasal_passages" name="nasal_passages[]" value="<?php echo st($nasal_passages_myarray['nasal_passagesid'])?>" <?php  if(strpos($nasal_passages,'~'.st($nasal_passages_myarray['nasal_passagesid']).'~') === false) {} else { echo " checked";}?> />
		                                &nbsp;&nbsp;
		                                <?php echo st($nasal_passages_myarray['nasal_passages']);?><br />
									<?php
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

		<div style="float:left; margin-left:10px;">
	        <input type="reset" value="Undo Changes" />
		</div>
		<div style="float:right;">
	        <input type="submit" name="ex_pagebtn" value="Save" />
	        <input type="submit" name="ex_pagebtn_proceed" value="Save And Proceed" />
		    &nbsp;&nbsp;&nbsp;
		</div>
	</form>

	<br />
		<?php include("includes/form_bottom.htm");?>
	<br />

	<div id="popupContact" style="width:750px;">
	    <a id="popupContactClose">
	    	<button>X</button>
	    </a>
	    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
	</div>
	<div id="backgroundPopup"></div>

	<br /><br />	

<?php
	} else {  // end pt info check
		print "<div style=\"width: 65%; margin: auto;\">Patient Information Incomplete -- Please complete the required fields in Patient Info section to enable this page.</div>";
	}
?>

<?php  include "includes/bottom.htm";?>
