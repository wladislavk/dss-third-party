<? 
include "includes/top.htm";
require_once "admin/includes/form_updates.php";

if(isset($_POST["profile_submit"]))
{

  $in_sql = "UPDATE dental_users SET
	username='".mysql_real_escape_string($_POST['username'])."',
	npi='".mysql_real_escape_string($_POST['npi'])."',
	medicare_npi='".mysql_real_escape_string($_POST['medicare_npi'])."',
	medicare_ptan='".mysql_real_escape_string($_POST['medicare_ptan'])."',
	tax_id_or_ssn='".mysql_real_escape_string($_POST['tax_id_or_ssn'])."',
	ein='".mysql_real_escape_string($_POST['ein'])."',
	ssn='".mysql_real_escape_string($_POST['ssn'])."',
	practice='".mysql_real_escape_string($_POST['practice'])."',
	name='".mysql_real_escape_string($_POST['name'])."',
	email='".mysql_real_escape_string($_POST['email'])."',
	address='".mysql_real_escape_string($_POST['address'])."',
	city='".mysql_real_escape_string($_POST['city'])."',
	state='".mysql_real_escape_string($_POST['state'])."',
	zip='".mysql_real_escape_string($_POST['zip'])."',
	phone='".mysql_real_escape_string($_POST['phone'])."'
	WHERE userid='".$_SESSION['userid']."'";
  mysql_query($in_sql);
  form_update_all($_SESSION['docid']);
}

if(isset($_POST["practice_submit"]))
{
  
  $in_sql = "UPDATE dental_users SET
        username='".mysql_real_escape_string($_POST['username'])."',
        npi='".mysql_real_escape_string($_POST['npi'])."',
        medicare_npi='".mysql_real_escape_string($_POST['medicare_npi'])."',
        medicare_ptan='".mysql_real_escape_string($_POST['medicare_ptan'])."',
        tax_id_or_ssn='".mysql_real_escape_string($_POST['tax_id_or_ssn'])."',
        ein='".mysql_real_escape_string($_POST['ein'])."',
        ssn='".mysql_real_escape_string($_POST['ssn'])."',
        practice='".mysql_real_escape_string($_POST['practice'])."',
        name='".mysql_real_escape_string($_POST['name'])."',
        email='".mysql_real_escape_string($_POST['email'])."',
        address='".mysql_real_escape_string($_POST['address'])."',
        city='".mysql_real_escape_string($_POST['city'])."',
        state='".mysql_real_escape_string($_POST['state'])."',
        zip='".mysql_real_escape_string($_POST['zip'])."',
        phone='".mysql_real_escape_string($_POST['phone'])."',
	fax='".mysql_real_escape_string($_POST['fax'])."',
        mailing_practice='".mysql_real_escape_string($_POST['mailing_practice'])."',
        mailing_name='".mysql_real_escape_string($_POST['mailing_name'])."',
        mailing_address='".mysql_real_escape_string($_POST['mailing_address'])."',
        mailing_city='".mysql_real_escape_string($_POST['mailing_city'])."',
        mailing_state='".mysql_real_escape_string($_POST['mailing_state'])."',
        mailing_zip='".mysql_real_escape_string($_POST['mailing_zip'])."',
        mailing_phone='".mysql_real_escape_string($_POST['mailing_phone'])."'
        WHERE userid='".$_SESSION['docid']."'";
  mysql_query($in_sql);
form_update_all($_SESSION['docid']);
}

if(isset($_POST["margins_submit"]) || isset($_POST['margins_test']))
{

  $in_sql = "UPDATE dental_users SET
                letter_margin_header = '".mysql_real_escape_string($_POST['letter_margin_header'])."',
                letter_margin_footer = '".mysql_real_escape_string($_POST['letter_margin_footer'])."',
		letter_margin_top = '".mysql_real_escape_string($_POST['letter_margin_top'])."',
                letter_margin_bottom = '".mysql_real_escape_string($_POST['letter_margin_bottom'])."',
                letter_margin_left = '".mysql_real_escape_string($_POST['letter_margin_left'])."',
                letter_margin_right = '".mysql_real_escape_string($_POST['letter_margin_right'])."'
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
	create_pdf($title, $filename, $html, null, '', '', '', $_SESSION['docid'] ); 

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
                letter_margin_header = '48',
                letter_margin_footer = '26',
                letter_margin_top = '14',
                letter_margin_bottom = '40',
                letter_margin_left = '18',
                letter_margin_right = '18'
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
  $u_sql = "SELECT * FROM dental_users where userid='".mysql_real_escape_string($_SESSION['userid'])."'";
  $u_q = mysql_query($u_sql);
  $user = mysql_fetch_assoc($u_q);

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
  <h3>My Profile</h3>
  <form action="#" method="post">
  <input type="hidden" name="userid" value="<?= $user['userid']; ?>" />
  <div class="detail">
    <label>Username:</label>
    <input class="value" name="username" value="<?= $user['username']; ?>" />
  </div>
  <div class="detail">
    <label>NPI:</label>
    <input class="value" name="npi" value="<?= $user['npi']; ?>" />
  </div>
  <div class="detail">
    <label>Medicare Provider (NPI/DME) Number:</label>
    <input class="value" name="medicare_npi" value="<?= $user['medicare_npi']; ?>" />
  </div>
  <div class="detail">
    <label>Medicare PTAN Number:</label>
    <input class="value" name="medicare_ptan" value="<?= $user['medicare_ptan']; ?>" />
  </div>
  <div class="detail">
    <label>Tax ID or SSN:</label>
    <input class="value" name="tax_id_or_ssn" value="<?= $user['tax_id_or_ssn']; ?>" />
  </div>
  <div class="detail">
    <label>EIN or SSN:</label>
    <span class="value"><input type="checkbox" name="ein" value="1" <?= ($user['ein']==1)?'checked="checked"':""; ?> /> EIN 
		<input type="checkbox" name="ssn" value="1" <?= ($user['ssn']==1)?'checked="checked"':""; ?> />SSN</span>
  </div>
  <div class="detail">
    <label>Practice:</label>
    <input class="value" name="practice" value="<?= $user['practice']; ?>" />
  </div>
  <div class="detail">
    <label>Name:</label>
    <input class="value" name="name" value="<?= $user['name']; ?>" />
  </div>
  <div class="detail">
    <label>Email:</label>
    <input class="value" name="email" value="<?= $user['email']; ?>" />
  </div>
  <div class="detail">
    <label>Address:</label>
    <input class="value" name="address" value="<?= $user['address']; ?>" />
  </div>
  <div class="detail">
    <label>City:</label>
    <input class="value" name="city" value="<?= $user['city']; ?>" />
  </div>
  <div class="detail">
    <label>State:</label>
    <input class="value" name="state" value="<?= $user['state']; ?>" />
  </div>
  <div class="detail">
    <label>Zip:</label>
    <input class="value" name="zip" value="<?= $user['zip']; ?>" />
  </div>
  <div class="detail">
    <label>Phone:</label>
    <input class="value" name="phone" value="<?= $user['phone']; ?>" />
  </div>
  <div class="detail">
    <label>&nbsp;</label>
        <input type="submit" name="profile_submit" value="Update Profile" />
  </div>
  </form>


</div>

<div class="half">
  <h3>Practice Profile</h3>
  <h4>Practice Logo</h4>
   <?php
               if($practice['logo'] <> "") {?>
                        <img src="./q_file/<?=$practice['logo'];?>" />
               <? }?>

                                        <a href="Javascript:;"  onclick="Javascript: loadPopup('add_user_logo.php');" class="editlink" title="EDIT">
                                                Edit
                                        </a>

  <form action="#" method="post">
  <input type="hidden" name="userid" value="<?= $practice['userid']; ?>" />
  <div class="detail">
    <label>Username:</label>
    <input class="value" name="username" value="<?= $practice['username']; ?>" />
  </div>
  <div class="detail">
    <label>NPI:</label>
    <input class="value" name="npi" value="<?= $practice['npi']; ?>" />
  </div>
  <div class="detail">
    <label>Medicare Provider (NPI/DME) Number:</label>
    <input class="value" name="medicare_npi" value="<?= $practice['medicare_npi']; ?>" />
  </div>
  <div class="detail">
    <label>Medicare PTAN Number:</label>
    <input class="value" name="medicare_ptan" value="<?= $practice['medicare_ptan']; ?>" />
  </div>
  <div class="detail">
    <label>Tax ID or SSN:</label>
    <input class="value" name="tax_id_or_ssn" value="<?= $practice['tax_id_or_ssn']; ?>" />
  </div>
  <div class="detail">
    <label>EIN or SSN:</label>
    <span class="value"><input type="checkbox" name="ein" value="1" <?= ($practice['ein']==1)?'checked="checked"':""; ?> /> EIN
                <input type="checkbox" name="ssn" value="1" <?= ($practice['ssn']==1)?'checked="checked"':""; ?> />SSN</span>
  </div>
  <div class="detail">
    <label>Practice:</label>
    <input class="value" name="practice" value="<?= $practice['practice']; ?>" />
  </div>
  <div class="detail">
    <label>Name:</label>
    <input class="value" name="name" value="<?= $practice['name']; ?>" />
  </div>
  <div class="detail">
    <label>Email:</label>
    <input class="value" name="email" value="<?= $practice['email']; ?>" />
  </div>
  <div class="detail">
    <label>Address:</label>
    <input class="value" name="address" value="<?= $practice['address']; ?>" />
  </div>
  <div class="detail">
    <label>City:</label>
    <input class="value" name="city" value="<?= $practice['city']; ?>" />
  </div>
  <div class="detail">
    <label>State:</label>
    <input class="value" name="state" value="<?= $practice['state']; ?>" />
  </div>
  <div class="detail">
    <label>Zip:</label>
    <input class="value" name="zip" value="<?= $practice['zip']; ?>" />
  </div>
  <div class="detail">
    <label>Phone:</label>
    <input class="value" name="phone" value="<?= $practice['phone']; ?>" />
  </div>
  <div class="detail">
    <label>Fax:</label>
    <input class="value" name="fax" value="<?= $practice['fax']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing Practice:</label>
    <input class="value" name="mailing_practice" value="<?= $practice['mailing_practice']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing Name:</label>
    <input class="value" name="mailing_name" value="<?= $practice['mailing_name']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing Address:</label>
    <input class="value" name="mailing_address" value="<?= $practice['mailing_address']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing City:</label>
    <input class="value" name="mailing_city" value="<?= $practice['mailing_city']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing State:</label>
    <input class="value" name="mailing_state" value="<?= $practice['mailing_state']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing Zip:</label>
    <input class="value" name="mailing_zip" value="<?= $practice['mailing_zip']; ?>" />
  </div>
  <div class="detail">
    <label>Mailing Phone:</label>
    <input class="value" name="mailing_phone" value="<?= $practice['mailing_phone']; ?>" />
  </div>
  <div class="detail">
    <label>&nbsp;</label>
	<input type="submit" name="practice_submit" value="Update Practice" />
  </div>
  </form>
</div>

<div style="clear:both;"></div>

<?php if($practice['user_type'] == DSS_USER_TYPE_SOFTWARE){ ?>
<div class="half">
  <h3>Letter Margins</h3>
  <form action="#" method="post">
  <div class="detail">
    <label>Header:</label>
    <input class="value" name="letter_margin_header" value="<?= $practice['letter_margin_header']; ?>" />
  </div>
  <div class="detail">
    <label>Footer:</label>
    <input class="value" name="letter_margin_footer" value="<?= $practice['letter_margin_footer']; ?>" />
  </div>
  <div class="detail">
    <label>Top:</label>
    <input class="value" name="letter_margin_top" value="<?= $practice['letter_margin_top']; ?>" />
  </div>
  <div class="detail">
    <label>Bottom:</label>
    <input class="value" name="letter_margin_bottom" value="<?= $practice['letter_margin_bottom']; ?>" />
  </div>
  <div class="detail">
    <label>Left:</label>
    <input class="value" name="letter_margin_left" value="<?= $practice['letter_margin_left']; ?>" />
  </div>
  <div class="detail">
    <label>Right:</label>
    <input class="value" name="letter_margin_right" value="<?= $practice['letter_margin_right']; ?>" />
  </div>
  <div class="detail">
    <label>&nbsp;</label>
        <input type="submit" name="margins_submit" value="Update Margins" />
	<input type="submit" name="margins_reset" value="Reset Margins" />
	<input type="submit" name="margins_test" value="Print Test Letter" />
	<p style="color:#933;">Warning!  Adjusting the letter margins will cause your letter template to no longer align with #9 envelope address fields.  Click “Reset” if you wish to restore the default margins.</p>
  </div>
  </form>
</div>
<?php }else{ ?>
<div class="half">
  <h3>Letter Margins</h3>
  <div class="detail">
    <label>Header:</label>
	48
  </div>
  <div class="detail">
    <label>Footer:</label>
	26
  </div>
  <div class="detail">
    <label>Top:</label>
	14
  </div>
  <div class="detail">
    <label>Bottom:</label>
	40
  </div>
  <div class="detail">
    <label>Left:</label>
	18
  </div>
  <div class="detail">
    <label>Right:</label>
	18
  </div>
</div>

<?php } ?>
<div style="clear:both;"></div>



<div id="popupContact" style="width:750px;height:460px">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
