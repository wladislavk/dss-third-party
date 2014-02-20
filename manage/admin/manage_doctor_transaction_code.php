<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&docid=<?= $_GET['docid']; ?>";
	</script>
	<?
	die();
}

$rec_disp = 50;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_transaction_code where docid=".$_GET['docid']." order by sortby";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

if($_POST['sortsub'] == 1)
{
	foreach($_POST['sortby'] as $val)
	{
		$smyarray = mysql_fetch_array($my);
		
		if($val == '' || is_numeric($val) === false)
		{
			$val = 999;
		}
		
		$up_sort_sql = "update dental_transaction_code set sortby='".s_for($val)."' where transaction_codeid='".$smyarray["transaction_codeid"]."'";
		mysql_query($up_sort_sql);
	}
	$msg = "Sort By Changed Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		window.location.replace("<?=$_SERVER['PHP_SELF']?>?docid=<?= $_GET['docid']; ?>&msg=<?=$msg;?>");
	</script>
	<?
	die();
}
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Transaction Code
</div>
<br />
<br />


<div align="right">
	<button onclick="Javascript: loadPopup('add_doctor_transaction_code.php?docid=<?= $_GET['docid']; ?>');" class="btn btn-success">
		Add New Transaction Code
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>?docid=<?= $_GET['docid']; ?>" method="post">
<table class="table table-bordered table-hover">
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
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($myarray = mysql_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["transaction_code"]);?>
				</td>
				<td valign="top">
					<?=st(substr($myarray["description"], 0, 25));?>
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
					<input type="text" name="sortby[]" value="<?=st($myarray['sortby'])?>" class="form-control text-center" style="width:5em"/>
				</td>	
		                <td valign="top" align="center">
                                       <?=st($myarray['amount'])?>
                                </td>				
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_doctor_transaction_code.php?docid=<?= $_GET['docid']; ?>&ed=<?=$myarray["transaction_codeid"];?>');" title="Edit" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="3">&nbsp;
				
			</td>
			<td valign="top" class="col_head" colspan="2">
				<input type="hidden" name="sortsub" value="1" />
				<input type="submit" value=" Change " class="btn btn-warning">
			</td>
		</tr>
		<?
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
