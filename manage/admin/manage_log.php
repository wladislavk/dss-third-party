<?php namespace Ds3\Legacy; ?><?php 
include "includes/top.htm";

	if(is_billing($_SESSION['admin_access'])){
?>
		<h2>You are not authorized to view this page.</h2>
<?php
  		die();
	}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
$sql = "select u.*, 
	(select COUNT(*) from dental_login where userid=u.userid) num_logins,
        (select login_date from dental_login where userid=u.userid ORDER BY login_date DESC LIMIT 1) last_login
	from dental_users u ";
}else{
  $sql = "select u.* from dental_users u 
        JOIN dental_user_company uc ON uc.userid = u.userid OR uc.userid = u.docid
        where uc.companyid = '".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."' ";
}


$sort_dir = (isset($_REQUEST['sort_dir']))?strtolower($_REQUEST['sort_dir']):'';
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : '';
$sort_by_sql = '';
switch ($sort_by) {
  case "name":
    $sort_by_sql = "u.first_name $sort_dir, u.last_name $sort_dir";
    break;
  case "logins":
    $sort_by_sql = "num_logins $sort_dir";
    break;
  case "last_login":
    $sort_by_sql = "last_login $sort_dir";
    break;
  default:
    $sort_by_sql = "u.username $sort_dir";
    break;
}

$sql .= " ORDER BY ".$sort_by_sql;





$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Login Data
</div>
<br />
<br />



<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'username')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="20%">
			<a href="manage_log.php?sort=username&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='username'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Username</a>	
		</td>
		<td valign="top" class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="35%">
			<a href="manage_log.php?sort=name&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='name'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
		</td>
                <td valign="top" class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'logins')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="10%">
                        <a href="manage_log.php?sort=logins&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='logins'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>"># Logins</a>
                </td>
                <td valign="top" class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'last_login')?'arrow_'.strtolower($_REQUEST['sort_dir']):''; ?>" width="25%">
                        <a href="manage_log.php?sort=last_login&sort_dir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='last_login'&&$_REQUEST['sort_dir']=='ASC')?'DESC':'ASC'; ?>">Last Login</a>
                </td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0)
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
		while($myarray = mysqli_fetch_array($my))
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
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
				<td valign="top">
					<?php echo st($myarray["first_name"]. " ".$myarray["last_name"]);?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["num_logins"]);?>
                                </td>
                                <td valign="top">
                                        <?php echo ($myarray["last_login"])?date('m/d/Y h:i:s', strtotime($myarray["last_login"])):'';?>
                                </td>	
				<td valign="top">
				<a href="Javascript:;"  onclick="Javascript: loadPopup('log.php?led=<?php echo $myarray["userid"];?>');" class="btn btn-info" title="View Logs">
					View Logs
					</a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</form>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
