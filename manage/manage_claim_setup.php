<? 
include "includes/top.htm";


if(isset($_POST["margins_submit"]) || isset($_POST['margins_test']))
{

  $in_sql = "UPDATE dental_users SET
		claim_margin_top = '".mysql_real_escape_string($_POST['claim_margin_top'])."',
                claim_margin_left = '".mysql_real_escape_string($_POST['claim_margin_left'])."'
        WHERE userid='".$_SESSION['docid']."'";
  mysql_query($in_sql);
  if(isset($_POST['margins_test'])){
	$title = "Test Letter";
	$filename = "test_margins_".$docid.".pdf";
	$html = "
<p>
name<br />
practice<br />
address
</p><p>&nbsp;</p>
<p>date</p>
<p>&nbsp;</p>
<table border=\"0\">
<tr>
<td width=\"70\"></td>
<td>
name<br />
practice
address<br />
city, state zip<br />
</td>
</tr>
</table>
<p>&nbsp;</p>

<p>Dear Mr. Smith:</p>

<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

<p>Sincerely,
<br />
<br />
<br />
name<br />
<br />
</p>
";
 	//CREATE LETTER HERE
	//create_pdf($title, $filename, $html, null, '', '', '', $_SESSION['docid'] ); 

	?>
	<script type="text/javascript">
		window.open('letterpdfs/<?= $filename; ?>');
	</script>
	<?php
  }
}

if(isset($_POST["margins_reset"]))
{

  $in_sql = "UPDATE dental_users SET
                claim_margin_top = '0',
                claim_margin_left = '0'
        WHERE userid='".$_SESSION['docid']."'";
  mysql_query($in_sql);
}


$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by title";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_custom=mysql_num_rows($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Profile
</span>
<br />
<br />
&nbsp;

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<?php
  $p_sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $p_q = mysql_query($p_sql);
  $practice = mysql_fetch_assoc($p_q);


?>
<style type="text/css">
.half{
  float:left;
  margin: 0 1%;
  }

.detail{
  display: block;
  clear: both;
  }

.detail label{
  width: 250px;
  display: block;
  float: left;
  text-align: right;
  line-height: 24px;
  margin-right: 10px;
  }

</style>

<div class="half">
  <h3>Claim Margins</h3>
  <form action="#" method="post">
  <div class="detail">
    <label>Top:</label>
    <input class="value" name="claim_margin_top" value="<?= $practice['claim_margin_top']; ?>" />
  </div>
  <div class="detail">
    <label>Left:</label>
    <input class="value" name="claim_margin_left" value="<?= $practice['claim_margin_left']; ?>" />
  </div>
  <div class="detail">
    <label>&nbsp;</label>
        <input type="submit" name="margins_submit" value="Update Margins" />
	<input type="submit" name="margins_reset" value="Reset Margins" />
	<input type="submit" name="margins_test" value="Print Test Claim" />
  </div>
  </form>
</div>
<div style="clear:both;"></div>



<div id="popupContact" style="width:750px;height:460px">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
