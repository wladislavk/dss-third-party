<?php namespace Ds3\Libraries\Legacy; ?><?php 
//session_start();
include_once('includes/main_include.php');
include("includes/sescheck.php");
include '../includes/constants.inc';
?>
  <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="../script/masks.js"></script>

<?php
if(!empty($_POST["mult_transaction_codesub"]) && $_POST["mult_transaction_codesub"] == 1)
{
	$op_arr = split("\n",trim($_POST['transaction_code']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_transaction_code where transaction_code = '".s_for($val)."'";
			$query_check=mysqli_query($con,$sel_check);
			
			if(mysqli_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_transaction_code set transaction_code = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysqli_query($con,$ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?php echo $msg;?>");
		parent.window.location='manage_transaction_code.php?msg=<?php echo $msg;?>';
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

if(!empty($_POST["transaction_codesub"]) && $_POST["transaction_codesub"] == 1)
{
	$sel_check = "select * from dental_transaction_code where docid=". $_GET['docid'] ." AND  transaction_code = '".s_for($_POST["transaction_code"])."' and transaction_codeid <> '".s_for($_POST['ed'])."'";
	$query_check = mysqli_query($con,$sel_check);

	if(mysqli_num_rows($query_check)>0)
	{
		$msg = "Transaction Code already exist. So please give another Transaction Code.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false)
		{
			$sby = 999;
		}
		else
		{
			$sby = s_for($_POST["sortby"]);
		}
		
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_transaction_code set transaction_code = '".s_for($_POST["transaction_code"])."', place = '".s_for($_POST['place'])."', 
                                modifier_code_1 = '".s_for($_POST['modifier_code_1'])."',
                                modifier_code_2 = '".s_for($_POST['modifier_code_2'])."',
                                days_units = '".s_for($_POST['days_units'])."',
				amount_adjust = '".s_for($_POST['amount_adjust'])."',
				sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."', type = '".s_for($_POST["type"])."', amount = '".s_for($_POST['amount'])."' where transaction_codeid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql) or trigger_error($ed_sql." | ".mysqli_error($con), E_USER_ERROR);
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_doctor_transaction_code.php?docid=<?php echo  $_GET['docid']; ?>&msg=<?php echo $msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into dental_transaction_code set transaction_code = '".s_for($_POST["transaction_code"])."', place = '".s_for($_POST['place'])."', 
                                modifier_code_1 = '".s_for($_POST['modifier_code_1'])."',
                                modifier_code_2 = '".s_for($_POST['modifier_code_2'])."',
                                days_units = '".s_for($_POST['days_units'])."',
                                amount_adjust = '".s_for($_POST['amount_adjust'])."',
				sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."', type = '".s_for($_POST["type"])."', amount = '".s_for($_POST['amount'])."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', docid=".$_GET['docid'];
			mysqli_query($con,$ins_sql) or trigger_error($ins_sql.mysqli_error($con), E_USER_ERROR);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_doctor_transaction_code.php?docid=<?php echo  $_GET['docid']; ?>&msg=<?php echo $msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_transaction_code where transaction_codeid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$transaction_code = $_POST['transaction_code'];
    		$type = $_POST['type'];		
		$place = $_POST['place'];
		$sortby = $_POST['sortby'];
                $amount = $_POST['amount'];
		$status = $_POST['status'];
		$description = $_POST['description'];
                $modifier_code_1 = $_POST['modifier_code_1'];
                $modifier_code_2 = $_POST['modifier_code_2'];
                $days_units = $_POST['days_units'];
		$amount_adjust = $_POST['amount_adjust'];
	}
	else
	{
		$transaction_code = st($themyarray['transaction_code']);
		$type = st($themyarray['type']);
		$place = st($themyarray['place']);
		$sortby = st($themyarray['sortby']);
                $amount = st($themyarray['amount']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
                $modifier_code_1 = $themyarray['modifier_code_1'];
                $modifier_code_2 = $themyarray['modifier_code_2'];
                $days_units = $themyarray['days_units'];
		$amount_adjust = $themyarray['amount_adjust'];
		$but_text = "Add ";
	}
	
	if($themyarray["transaction_codeid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="transaction_codefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&docid=<?php echo  $_GET['docid']; ?>" method="post" onSubmit="return transaction_codeabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Transaction Code 
               <?php if($transaction_code <> "") {?>
               		&quot;<?php echo $transaction_code;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Transaction Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="transaction_code" value="<?php echo $transaction_code?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Transaction Type
            </td>
            <td valign="top" class="frmdata">
                <select name="type" class="form-control" />
                  <option value="1" <?php if($type == "1"){echo " selected='selected'";} ?>> Medical Code </option>
                  <option value="2" <?php if($type == "2"){echo " selected='selected'";} ?>> Patient Payment Code </option>
                  <option value="3" <?php if($type == "3"){echo " selected='selected'";} ?>> Insurance Payment Code </option>
                  <option value="4" <?php if($type == "4"){echo " selected='selected'";} ?>> Diagnostic Code </option>
                  <option value="5" <?php if($type == "5"){echo " selected='selected'";} ?>> Modifier Code </option>
                  <option value="6" <?php if($type == "6"){echo " selected='selected'";} ?>> Adjustment Code </option>              
                </select> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
               Place
            </td>
            <td valign="top" class="frmdata">
                <select name="place" class="form-control" />
                  <option value=""></option>
                  <?php
                        $psql = "select * from dental_place_service order by sortby";
                        $pmy = mysqli_query($con,$psql);
                        while($prow = mysqli_fetch_assoc($pmy)){
                  ?>
                  <option value="<?php echo  $prow['place_serviceid']; ?>" <?php if($place == $prow['place_serviceid']){echo " selected='selected'";} ?>><?php echo  $prow['place_service']." ".$prow['description']; ?></option>
                  <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">            <td valign="top" class="frmhead" width="30%">
               Default Modifier Code 1
            </td>
            <td valign="top" class="frmdata">
                <select name="modifier_code_1" class="form-control" />
                  <option value=""></option>
                  <?php
                        $psql = "select * from dental_modifier_code order by sortby";
                        $pmy = mysqli_query($con,$psql);
                        while($prow = mysqli_fetch_assoc($pmy)){
                  ?>
                  <option value="<?php echo  $prow['modifier_code']; ?>" <?php if($modifier_code_1 == $prow['modifier_code']){echo " selected='selected'";} ?>><?php echo  $prow['modifier_code']." ".$prow['description'];
 ?></option>
                  <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">            <td valign="top" class="frmhead" width="30%">
               Default Modifier Code 2
            </td>
            <td valign="top" class="frmdata">
                <select name="modifier_code_2" class="form-control" />
                  <option value=""></option>
                  <?php
                        $psql = "select * from dental_modifier_code order by sortby";
                        $pmy = mysqli_query($con,$psql);
                        while($prow = mysqli_fetch_assoc($pmy)){
                  ?>                  <option value="<?php echo  $prow['modifier_code']; ?>" <?php if($modifier_code_2 == $prow['modifier_code']){echo " selected='selected'";} ?>><?php echo  $prow['modifier_code']." ".$prow['description'];
 ?></option>
                  <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">            <td valign="top" class="frmhead" width="30%">
               Default Days/Units
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="days_units" value="<?php echo $days_units;?>" class="tbox singlenumber" style="width:30px"/>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?php echo $sortby;?>" class="form-control" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
               Price 
            </td>
            <td valign="top" class="frmdata">
                $<input type="text" name="amount" value="<?php echo $amount;?>" class="form-control" style="width:100px"/>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Amount Adjustment
            </td>
            <td valign="top" class="frmdata">
                <select name="amount_adjust" class="form-control">
                        <option value="<?php echo  DSS_AMOUNT_ADJUST_USER; ?>" <?php if($amount_adjust == DSS_AMOUNT_ADJUST_USER) echo " selected";?>><?php echo  $dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_USER]; ?></option>
                        <option value="<?php echo  DSS_AMOUNT_ADJUST_NEGATIVE; ?>" <?php if($amount_adjust == DSS_AMOUNT_ADJUST_NEGATIVE) echo " selected";?>><?php echo  $dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_NEGATIVE]; ?></option>
                        <option value="<?php echo  DSS_AMOUNT_ADJUST_POSITIVE; ?>" <?php if($amount_adjust == DSS_AMOUNT_ADJUST_POSITIVE) echo " selected";?>><?php echo  $dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_POSITIVE]; ?></option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="form-control" name="description" style="width:100%;"><?php echo $description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="transaction_codesub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["transaction_codeid"]?>" />
                <input type="submit" value="<?php echo $but_text?> Transaction Code" class="btn btn-primary">
		<?php if($themyarray["transaction_codeid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_doctor_transaction_code.php?delid=<?php echo $themyarray["transaction_codeid"];?>&docid=<?php echo  $_GET['docid']; ?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
  
</body>
</html>
