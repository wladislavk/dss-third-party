<?php 
include "includes/top.htm";
include_once "../includes/constants.inc";

$sql = "SELECT * FROM memo_admin order BY off_date ASC";
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<!--link rel="stylesheet" href="css/support.css" type="text/css" /-->
<div class="page-header">
	Manage Memos 
</div>
<button onclick="loadPopup('add_memo.php'); return false;" class="btn btn-success pull-right">
    Add Memo
    <span class="glyphicon glyphicon-plus"></span>
</button>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<thead>
	<tr class="tr_bg_h">
		<th valign="top" class="col_head" width="25%">
			Memo	
		</th>
                <th valign="top" class="col_head" width="10%">
                        Last Updated
                </th>
                <th valign="top" class="col_head" width="10%">
			End Date
                </th>
		<th valign="top" class="col_head" width="15%">
		Action
		</td>
	</tr>
	</thead>
	<tbody>
<?php if(mysqli_num_rows($my) == 0)
{ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="4" align="center">
		No Records
		</td>
		</tr>
		<?php 
}
else
{
	while($myarray = mysqli_fetch_array($my))
	{
		?>
			<tr>
			<td valign="top">
			<?php echo st($myarray["memo"]);?>
			</td>
			<td valign="top">
			<?php echo  st($myarray["last_update"]); ?>
			</td>	
                        <td valign="top">
                        <?php echo  st($myarray["off_date"]); ?>
			</td>
			<td valign="top">
			<a href="#" onclick="loadPopup('add_memo.php?ed=<?php echo $myarray["memo_id"];?>');" title="Edit Memo" class="btn btn-primary btn-sm">
			 Edit
			 <span class="glyphicon glyphicon-pencil"></span></a>
							</td>
							</tr>
							<?php 	}
}?>
</tbody>
</table>




<div id="popupContact">
<a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
