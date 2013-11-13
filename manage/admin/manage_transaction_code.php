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
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_transaction_code where default_code=1 order by sortby";
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
		window.location.replace("<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg;?>");
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

<?php
if(is_super($_SESSION['admin_access'])){
?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_transaction_code.php');" class="addButton">
		Add New Transaction Code
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

&nbsp;
<b>Total Records: <?=$total_rec;?></b>
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
		<td valign="top" class="col_head" width="10%">
			TX Code		
		</td>
		<td valign="top" class="col_head" width="40%">
			Description		
		</td>
		<td valign="top" class="col_head" width="30%">
			Type		
		</td>
		<td valign="top" class="col_head" width="10%">
			Sort By 
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
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					  <input type="text" name="sortby[]" value="<?=st($myarray['sortby'])?>" class="tbox" style="width:30px"/>
					<?php }else{ ?>
					  <?=st($myarray['sortby'])?>
					<?php } ?>
				</td>	
						
				<td valign="top">
					<?php if(is_super($_SESSION['admin_access'])){ ?>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_transaction_code.php?ed=<?=$myarray["transaction_codeid"];?>');" class="editlink" title="EDIT">
						Edit
					</a>
                    			<?php } ?>
				</td>
			</tr>
	<? 	}
		?>
		<tr>
			<td valign="top" class="col_head" colspan="3">&nbsp;
				
			</td>
			<td valign="top" class="col_head" colspan="2">
				<?php if(is_super($_SESSION['admin_access'])){ ?>
				<input type="hidden" name="sortsub" value="1" />
				<input type="submit" value=" Change " class="button" />
				<?php } ?>
			</td>
		</tr>
		<?
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
