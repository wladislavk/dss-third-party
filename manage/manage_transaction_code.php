<?php
include "includes/top.htm";

$sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con, $_SESSION['userid'])."'";
$r = $db->getRow($sql);
if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1){ ?>
	You are not authorized to access this page.
	<?php
	die();
}

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."' AND docid='".$_SESSION['docid']."';";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_transaction_code WHERE docid='".$_SESSION['docid']."' order by sortby";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_users = count($my);

if(!empty($_POST['sortsub']) && $_POST['sortsub'] == 1)
{
	foreach($_POST['sortby'] as $key => $val)
	{
		$smyarray = $my[$key];
		if($val == '' || is_numeric($val) === false)
		{
			$val = 999;
		}
		
		$up_sort_sql = "update dental_transaction_code set sortby='".s_for($val)."' where transaction_codeid='".$smyarray["transaction_codeid"]."' AND docid='".$_SESSION['docid']."';";
		$db->query($up_sort_sql);
	}
	$msg = "Sort By Changed Successfully";
	?>
	<script type="text/javascript">
		//alert("<?php echo $msg;?>");
		window.location.replace("<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg;?>");
	</script>
	<?
	die();
}
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Transaction Code
</span>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_transaction_code.php');" class="addButton">
		Add New Transaction Code
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="10%">
			TX Code		
		</td>
		<td valign="top" class="col_head" width="30%">
			Description		
		</td>
		<td valign="top" class="col_head" width="30%">
			Type		
		</td>
		<td valign="top" class="col_head" width="10%">
			Sort By 
		</td>
		<td valign="top" class="col_head" width="10%">
			Amount
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if($num_users == 0)
	{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="10" align="center">
			No Records
		</td>
	</tr>
	<?php 
	}
	else
	{
		foreach ($my as $myarray) {

			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top">
			<?php echo st($myarray["transaction_code"]);?>
		</td>
		<td valign="top">
			<?php echo st(substr($myarray["description"], 0, 25));?>
		</td>
		<td valign="top">
          
        <?php
        
         if($myarray["type"] == "1"){
	         echo "Medical Code";
         }elseif($myarray["type"] == "2"){
	         echo "Patient Payment Code";
         }elseif($myarray["type"] == "3"){
	         echo "Insurance Payment Code";
         }elseif($myarray["type"] == "4"){
	         echo "Diagnostic Code";
         }elseif($myarray["type"] == "5"){
	         echo "Modifier Code";
         }elseif($myarray["type"] == "6"){
	         echo "Adjustment Code";
         }
        
        ?>                  

		</td>
		<td valign="top" align="center">
			<input type="text" name="sortby[]" value="<?php echo st($myarray['sortby'])?>" class="tbox" style="width:30px"/>
		</td>	
		<td valign="top" align="center">
			<?php echo st($myarray['amount'])?>
		</td>						
		<td valign="top">
			<a href="#"  onclick="loadPopup('add_transaction_code.php?ed=<?php echo $myarray["transaction_codeid"];?>');return false;" class="editlink" title="EDIT">
				Edit
			</a>
		</td>
	</tr>
	<?php 	}
		?>
	<tr>
		<td valign="top" class="col_head" colspan="3">&nbsp;
			
		</td>
		<td valign="top" class="col_head" colspan="2">
			<input type="hidden" name="sortsub" value="1" />
			<input type="submit" value=" Change " class="button" />
		</td>
	</tr>
		<?php
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
