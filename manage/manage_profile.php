<?php 
  include "includes/top.htm";
  include_once "admin/includes/form_updates.php";

  if(isset($_POST["profile_submit"])) {

    $sel_check = "select * from dental_users where username = '".s_for($_POST["username"])."' and userid <> '".s_for($_SESSION['userid'])."'";
    $sel_check2 = "select * from dental_users where email = '".s_for($_POST["email"])."' and userid <> '".s_for($_SESSION['userid'])."'";
 
    if($db->getNumberRows($sel_check) > 0) {
      $msg="Username already exist. So please give another Username.";
?>
      <script type="text/javascript">
        alert("<?php echo $msg;?>");
        window.location = "#add";
      </script>
<?php
    } elseif($db->getNumberRows($sel_check2)>0) {
      $msg="Email already exist. So please give another Email.";
?>
        <script type="text/javascript">
          alert("<?php echo $msg;?>");
          window.location = "#add";
        </script>
<?php
    } else {
      $in_sql = "UPDATE dental_users SET
      username='".mysqli_real_escape_string($con,$_POST['username'])."',
      npi='".mysqli_real_escape_string($con,$_POST['npi'])."',
      medicare_npi='".mysqli_real_escape_string($con,$_POST['medicare_npi'])."',
      medicare_ptan='".mysqli_real_escape_string($con,$_POST['medicare_ptan'])."',
      tax_id_or_ssn='".mysqli_real_escape_string($con,$_POST['tax_id_or_ssn'])."',
      ein='".mysqli_real_escape_string($con,$_POST['ein'])."',
      ssn='".mysqli_real_escape_string($con,$_POST['ssn'])."',
      practice='".mysqli_real_escape_string($con,$_POST['practice'])."',
      first_name='".mysqli_real_escape_string($con,$_POST['first_name'])."',
            last_name='".mysqli_real_escape_string($con,$_POST['last_name'])."',
      email='".mysqli_real_escape_string($con,$_POST['email'])."',
      address='".mysqli_real_escape_string($con,$_POST['address'])."',
      city='".mysqli_real_escape_string($con,$_POST['city'])."',
      state='".mysqli_real_escape_string($con,$_POST['state'])."',
      zip='".mysqli_real_escape_string($con,$_POST['zip'])."',
      phone='".mysqli_real_escape_string($con,$_POST['phone'])."',
      updated_at=now()
      WHERE userid='".$_SESSION['userid']."'";

      $db->query($in_sql);

      $u_sql = "SELECT edx_id FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
      $u = $db->getRow($u_sql);
      $userid = $u['edx_id'];
      shell_exec('sh edx_scripts/edxEditUser.sh '.$userid.' "'.$_POST['username'].'" "'.$_POST['email'].'" "ff&#x@fe@" "'.$_POST['first_name']. ' '.$_POST['last_name'].'"');
      form_update_all($_SESSION['docid']);
    }
  }

  if(isset($_POST["practice_submit"]))
  {
    $in_sql = "UPDATE dental_users SET
      username='".mysqli_real_escape_string($con,$_POST['username'])."',
      npi='".mysqli_real_escape_string($con,$_POST['npi'])."',
      medicare_npi='".mysqli_real_escape_string($con,$_POST['medicare_npi'])."',
      medicare_ptan='".mysqli_real_escape_string($con,$_POST['medicare_ptan'])."',
      tax_id_or_ssn='".mysqli_real_escape_string($con,$_POST['tax_id_or_ssn'])."',
      ein='".mysqli_real_escape_string($con,$_POST['ein'])."',
      ssn='".mysqli_real_escape_string($con,$_POST['ssn'])."',
      practice='".mysqli_real_escape_string($con,$_POST['practice'])."',
      first_name='".mysqli_real_escape_string($con,$_POST['first_name'])."',
      last_name='".mysqli_real_escape_string($con,$_POST['last_name'])."',
      email='".mysqli_real_escape_string($con,$_POST['email'])."',
      address='".mysqli_real_escape_string($con,$_POST['address'])."',
      city='".mysqli_real_escape_string($con,$_POST['city'])."',
      state='".mysqli_real_escape_string($con,$_POST['state'])."',
      zip='".mysqli_real_escape_string($con,$_POST['zip'])."',
      phone='".mysqli_real_escape_string($con,$_POST['phone'])."',
      fax='".mysqli_real_escape_string($con,$_POST['fax'])."',
      use_service_npi = '".mysqli_real_escape_string($con,$_POST['use_service_npi'])."',
      service_name = '".mysqli_real_escape_string($con,$_POST['service_name'])."',
      service_address = '".mysqli_real_escape_string($con,$_POST['service_address'])."',
      service_city = '".mysqli_real_escape_string($con,$_POST['service_city'])."',
      service_state = '".mysqli_real_escape_string($con,$_POST['service_state'])."',
      service_zip = '".mysqli_real_escape_string($con,$_POST['service_zip'])."',
      service_phone = '".mysqli_real_escape_string($con,$_POST['service_phone'])."',
      service_fax = '".mysqli_real_escape_string($con,$_POST['service_fax'])."',
      service_npi = '".mysqli_real_escape_string($con,$_POST['service_npi'])."',
      service_medicare_npi = '".mysqli_real_escape_string($con,$_POST['service_medicare_npi'])."',
      service_medicare_ptan = '".mysqli_real_escape_string($con,$_POST['service_medicare_ptan'])."',
      service_tax_id_or_ssn = '".mysqli_real_escape_string($con,$_POST['service_tax_id_or_ssn'])."',
      service_ssn = '".mysqli_real_escape_string($con,$_POST['service_ssn'])."',
      service_ein = '".mysqli_real_escape_string($con,$_POST['service_ein'])."',
      updated_at=now()
      WHERE userid='".$_SESSION['docid']."'";

    $db->query($in_sql);
    $u_sql = "SELECT edx_id FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
    
    $u = $db->getRow($u_sql);
    $userid = $u['edx_id'];
    shell_exec('sh edx_scripts/edxEditUser.sh '.$userid.' "'.$_POST['username'].'" "'.$_POST['email'].'" "ff&#x@fe@" "'.$_POST['first_name']. ' '.$_POST['last_name'].'"');

    $lc_sql = "SELECT * FROM dental_locations WHERE  default_location=1 AND docid='".$_SESSION["docid"]."'";
    
    if($db->getNumberRows($lc_sql) == 0){
      $loc_sql = "INSERT INTO dental_locations SET
        location = '".s_for($_POST['mailing_practice'])."', 
        name = '".s_for($_POST["mailing_name"])."', 
        address = '".s_for($_POST["mailing_address"])."', 
        city = '".s_for($_POST["mailing_city"])."', 
        state = '".s_for($_POST["mailing_state"])."', 
        zip = '".s_for($_POST["mailing_zip"])."', 
        email = '".s_for($_POST["mailing_email"])."',
        phone = '".s_for(num($_POST["mailing_phone"]))."',
        fax = '".s_for(num($_POST["mailing_fax"]))."',
        default_location=1, 
        docid='".$_SESSION["docid"]."'";
    } else {
      $loc_sql = "UPDATE dental_locations SET
        location = '".s_for($_POST['mailing_practice'])."', 
        name = '".s_for($_POST["mailing_name"])."', 
        address = '".s_for($_POST["mailing_address"])."', 
        city = '".s_for($_POST["mailing_city"])."', 
        state = '".s_for($_POST["mailing_state"])."', 
        zip = '".s_for($_POST["mailing_zip"])."', 
        email = '".s_for($_POST["mailing_email"])."',
        phone = '".s_for(num($_POST["mailing_phone"]))."',
        fax = '".s_for(num($_POST["mailing_fax"]))."'
        where default_location=1 AND docid='".$_SESSION["docid"]."'";
    }
    $db->query($loc_sql);

    form_update_all($_SESSION['docid']);
  }

  if(isset($_POST["letter_settings_but"])){
    $up_sql = "UPDATE dental_users SET
      use_letter_header = '".$_POST['letter_header']."',
      indent_address = '".$_POST['indent_address']."',
      header_space = '".$_POST['header_space']."'
      WHERE userid='".$_SESSION['docid']."'";

    $db->query($up_sql);
  }

  if(isset($_POST["margins_submit"]) || isset($_POST['margins_test'])) {
    $in_sql = "UPDATE dental_users SET
      letter_margin_header = '".mysqli_real_escape_string($con,$_POST['letter_margin_header'])."',
      letter_margin_footer = '".mysqli_real_escape_string($con,$_POST['letter_margin_footer'])."',
      letter_margin_top = '".mysqli_real_escape_string($con,$_POST['letter_margin_top'])."',
      letter_margin_bottom = '".mysqli_real_escape_string($con,$_POST['letter_margin_bottom'])."',
      letter_margin_left = '".mysqli_real_escape_string($con,$_POST['letter_margin_left'])."',
      letter_margin_right = '".mysqli_real_escape_string($con,$_POST['letter_margin_right'])."'
      WHERE userid='".$_SESSION['docid']."'";

    $db->query($in_sql);
    if(isset($_POST['margins_test'])){
      $title = "Test Letter";
      $filename = "test_margins_".$docid.".pdf";
      $html = "
        <p>name<br />
          practice<br />
          address
        </p>
        <p>&nbsp;</p>
        <p>date</p>
        <p>&nbsp;</p>
        <table border=\"0\">
          <tr>
            <td width=\"70\"></td>
            <td>name<br />
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
        window.open('letterpdfs/<?php echo  $filename; ?>');
      </script>
<?php
    }
  }

  if(isset($_POST["margins_reset"])) {
    $in_sql = "UPDATE dental_users SET
      letter_margin_header = '48',
      letter_margin_footer = '26',
      letter_margin_top = '14',
      letter_margin_bottom = '40',
      letter_margin_left = '18',
      letter_margin_right = '18'
      WHERE userid='".$_SESSION['docid']."'";

    $db->query($in_sql);
  }

  $rec_disp = 20;

  if(!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
  } else {
    $index_val = 0;
  }
  
  $i_val = $index_val * $rec_disp;
  $sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by title";
  
  $total_rec = $db->getNumberRows($sql);
  $no_pages = $total_rec/$rec_disp;

  $sql .= " limit ".$i_val.",".$rec_disp;
  $num_custom = $db->getNumberRows($sql);
?>

  <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
  <script src="admin/popup/popup.js" type="text/javascript"></script>

  <span class="admin_head">
    Manage Profile
  </span>
  <br />
  <br />
  &nbsp;
  <a href="legal_docs.php">View Legal Documents</a>
  <br />
  <div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
  </div>

<?php
    $u_sql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";

    $user = $db->getRow($u_sql);

    $p_sql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
    $p_sql = "select u.*, c.companyid, l.name mailing_name, l.address mailing_address, l.location mailing_practice, l.city mailing_city, l.state mailing_state, l.zip as mailing_zip, l.email as mailing_email, l.phone as mailing_phone, l.fax as mailing_fax from dental_users u 
                  LEFT JOIN dental_user_company c ON u.userid = c.userid
                  LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location=1
                  where u.userid='".mysqli_real_escape_string($con,$_SESSION["docid"])."'";

    $practice = $db->getRow($p_sql);
?>

  <link rel="stylesheet" href="css/manage_profile.css" type="text/css" />

  <div class="half">
    <h3>My Profile</h3>
    <form action="#" method="post" onsubmit="return check_dups(this);">
      <input type="hidden" name="userid" value="<?php echo  $user['userid']; ?>" />
      <div class="detail">
        <label>Username:</label>
        <input class="value" name="username" value="<?php echo  $user['username']; ?>" />
      </div>
      <div class="detail">
        <label>NPI:</label>
        <input class="value" name="npi" value="<?php echo  $user['npi']; ?>" />
      </div>
      <div class="detail">
        <label>Medicare Provider (NPI/DME) Number:</label>
        <input class="value" name="medicare_npi" value="<?php echo  $user['medicare_npi']; ?>" />
      </div>
      <div class="detail">
        <label>Medicare PTAN Number:</label>
        <input class="value" name="medicare_ptan" value="<?php echo  $user['medicare_ptan']; ?>" />
      </div>
      <div class="detail">
        <label>Tax ID or SSN:</label>
        <input class="value" name="tax_id_or_ssn" value="<?php echo  $user['tax_id_or_ssn']; ?>" />
      </div>
      <div class="detail">
        <label>EIN or SSN:</label>
        <span class="value">
          <input type="checkbox" name="ein" value="1" <?php echo  ($user['ein']==1)?'checked="checked"':""; ?> /> EIN 
          <input type="checkbox" name="ssn" value="1" <?php echo  ($user['ssn']==1)?'checked="checked"':""; ?> />SSN
        </span>
      </div>
      <div class="detail">
        <label>Practice:</label>
        <input class="value" name="practice" value="<?php echo  $user['practice']; ?>" />
      </div>
      <div class="detail">
        <label>First Name:</label>
        <input class="value" name="first_name" value="<?php echo  $user['first_name']; ?>" />
      </div>
      <div class="detail">
        <label>Last Name:</label>
        <input class="value" name="last_name" value="<?php echo  $user['last_name']; ?>" />
      </div>
      <div class="detail">
        <label>Email:</label>
        <input class="value" name="email" value="<?php echo  $user['email']; ?>" />
      </div>
      <div class="detail">
        <label>Address:</label>
        <input class="value" name="address" value="<?php echo  $user['address']; ?>" />
      </div>
      <div class="detail">
        <label>City:</label>
        <input class="value" name="city" value="<?php echo  $user['city']; ?>" />
      </div>
      <div class="detail">
        <label>State:</label>
        <input class="value" name="state" value="<?php echo  $user['state']; ?>" />
      </div>
      <div class="detail">
        <label>Zip:</label>
        <input class="value" name="zip" value="<?php echo  $user['zip']; ?>" />
      </div>
      <div class="detail">
        <label>Phone:</label>
        <input class="value extphonemask" name="phone" value="<?php echo  $user['phone']; ?>" />
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

    <?php if($practice['logo'] <> "") { ?>
      <img src="display_file.php?f=<?php echo $practice['logo'];?>" />
    <?php } ?>

    <a href="#" onclick="loadPopup('add_user_logo.php')" class="editlink" title="EDIT">
      Edit
    </a>

    <?php
      $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
      
      $r = $db->getRow($sql);
      if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff']!=1){
        $check_profile_value = 1;
      } else {
        $check_profile_value = 0;
      }
    ?>

    <form action="#" method="post" onsubmit="return check_profile(this, <?php echo $check_profile_value; ?>);">
      <input type="hidden" name="userid" value="<?php echo  $practice['userid']; ?>" />
      <div class="detail">
        <label>Username:</label>
        <input class="value" name="username" value="<?php echo  $practice['username']; ?>" />
      </div>
      <div class="detail">
        <label>NPI:</label>
        <input class="value" name="npi" value="<?php echo  $practice['npi']; ?>" />
      </div>
      <div class="detail">
        <label>Medicare Provider (NPI/DME) Number:</label>
        <input class="value" name="medicare_npi" value="<?php echo  $practice['medicare_npi']; ?>" />
      </div>
      <div class="detail">
        <label>Medicare PTAN Number:</label>
        <input class="value" name="medicare_ptan" value="<?php echo  $practice['medicare_ptan']; ?>" />
      </div>
      <div class="detail">
        <label>Tax ID or SSN:</label>
        <input class="value" name="tax_id_or_ssn" value="<?php echo  $practice['tax_id_or_ssn']; ?>" />
      </div>
      <div class="detail">
        <label>EIN or SSN:</label>
        <span class="value">
          <input type="checkbox" name="ein" value="1" <?php echo  ($practice['ein']==1)?'checked="checked"':""; ?> /> EIN
          <input type="checkbox" name="ssn" value="1" <?php echo  ($practice['ssn']==1)?'checked="checked"':""; ?> />SSN
        </span>
      </div>
      <div class="detail">
        <label>Practice:</label>
        <input class="value" name="practice" value="<?php echo  $practice['practice']; ?>" />
      </div>
      <div class="detail">
        <label>First Name:</label>
        <input class="value" name="first_name" value="<?php echo  $practice['first_name']; ?>" />
      </div>
      <div class="detail">
        <label>Last Name:</label>
        <input class="value" name="last_name" value="<?php echo  $practice['last_name']; ?>" />
      </div>
      <div class="detail">
        <label>Email:</label>
        <input class="value" name="email" value="<?php echo  $practice['email']; ?>" />
      </div>
      <div class="detail">
        <label>Address:</label>
        <input class="value" name="address" value="<?php echo  $practice['address']; ?>" />
      </div>
      <div class="detail">
        <label>City:</label>
        <input class="value" name="city" value="<?php echo  $practice['city']; ?>" />
      </div>
      <div class="detail">
        <label>State:</label>
        <input class="value" name="state" value="<?php echo  $practice['state']; ?>" />
      </div>
      <div class="detail">
        <label>Zip:</label>
        <input class="value" name="zip" value="<?php echo  $practice['zip']; ?>" />
      </div>
      <div class="detail">
        <label>Phone:</label>
        <input class="value extphonemask" name="phone" value="<?php echo  $practice['phone']; ?>" />
      </div>
      <div class="detail">
        <label>Fax:</label>
        <input class="value phonemask" name="fax" value="<?php echo  $practice['fax']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Practice:</label>
        <input class="value" name="mailing_practice" value="<?php echo  $practice['mailing_practice']; ?>" />
      </div>
      <div class="detail">
        <label>Practice Email:</label>
        <input class="value" name="mailing_email" value="<?php echo  $practice['mailing_email']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Name:</label>
        <input class="value" name="mailing_name" value="<?php echo  $practice['mailing_name']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Address:</label>
        <input class="value" name="mailing_address" value="<?php echo  $practice['mailing_address']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing City:</label>
        <input class="value" name="mailing_city" value="<?php echo  $practice['mailing_city']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing State:</label>
        <input class="value" name="mailing_state" value="<?php echo  $practice['mailing_state']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Zip:</label>
        <input class="value" name="mailing_zip" value="<?php echo  $practice['mailing_zip']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Phone:</label>
        <input class="value extphonemask" name="mailing_phone" value="<?php echo  $practice['mailing_phone']; ?>" />
      </div>
      <div class="detail">
        <label>Mailing Fax:</label>
        <input class="value phonemask" name="mailing_fax" value="<?php echo  $practice['mailing_fax']; ?>" />
      </div>
      <div class="detail">
        <label>Do you use a separate NPI number for Service Facility (CMS1500 box 32) and Billing Provider (CMS1500 box 33) items when filing claims?:</label>
        <input type="radio" class="value" name="use_service_npi" value="1" <?php echo  ($practice['use_service_npi'])?'checked="checked"':''; ?> /> Yes
        <input type="radio" class="value" name="use_service_npi" value="0" <?php echo  (!$practice['use_service_npi'])?'checked="checked"':''; ?> /> No
      </div>
      <div class="detail service_info">
        <label>Service Name:</label>
        <input class="value" name="service_name" value="<?php echo  $practice['service_name']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service Address:</label>
        <input class="value" name="service_address" value="<?php echo  $practice['service_address']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service City:</label>
        <input class="value" name="service_city" value="<?php echo  $practice['service_city']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service State:</label>
        <input class="value" name="service_state" value="<?php echo  $practice['service_state']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service Zip:</label>
        <input class="value" name="service_zip" value="<?php echo  $practice['service_zip']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service NPI:</label>
        <input class="value" name="service_npi" value="<?php echo  $practice['service_npi']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service Medicare NPI:</label>
        <input class="value" name="service_medicare_npi" value="<?php echo  $practice['service_medicare_npi']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service Medicare PTAN:</label>
        <input class="value" name="service_medicare_ptan" value="<?php echo  $practice['service_medicare_ptan']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service Tax ID or SSN:</label>
        <input class="value" name="service_tax_id_or_ssn" value="<?php echo  $practice['service_tax_id_or_ssn']; ?>" />
      </div>
      <div class="detail service_info">
        <label>Service EIN or SSN:</label>
        <span class="value">
          <input type="checkbox" name="service_ein" value="1" <?php echo  ($practice['service_ein']==1)?'checked="checked"':""; ?> /> EIN
          <input type="checkbox" name="service_ssn" value="1" <?php echo  ($practice['service_ssn']==1)?'checked="checked"':""; ?> />SSN
        </span>
      </div>

      <script type="text/javascript" src="js/manage_profile.js"></script>

      <div class="detail">
        <label>&nbsp;</label>
        <input type="submit" name="practice_submit" value="Update Practice" />
      </div>
    </form>
  </div>

  <div style="clear:both;"></div>

  <?php if($practice['user_type'] == DSS_USER_TYPE_SOFTWARE) { ?>
    <div style="width:98%; margin-left:1%">
      <h3>Letter Margins</h3>
      All units in millimeters (mm).
      <form action="#" method="post">
        <div class="detail">
          <label>Header:</label>
          <input class="value" name="letter_margin_header" value="<?php echo  $practice['letter_margin_header']; ?>" />
        </div>
        <div class="detail">
          <label>Footer:</label>
          <input class="value" name="letter_margin_footer" value="<?php echo  $practice['letter_margin_footer']; ?>" />
        </div>
        <div class="detail">
          <label>Top:</label>
          <input class="value" name="letter_margin_top" value="<?php echo  $practice['letter_margin_top']; ?>" />
        </div>
        <div class="detail">
          <label>Bottom:</label>
          <input class="value" name="letter_margin_bottom" value="<?php echo  $practice['letter_margin_bottom']; ?>" />
        </div>
        <div class="detail">
          <label>Left:</label>
          <input class="value" name="letter_margin_left" value="<?php echo  $practice['letter_margin_left']; ?>" />
        </div>
        <div class="detail">
          <label>Right:</label>
          <input class="value" name="letter_margin_right" value="<?php echo  $practice['letter_margin_right']; ?>" />
        </div>
        <div class="detail">
          <label>&nbsp;</label>
          <input type="submit" name="margins_submit" value="Update Margins" />
          <input type="submit" name="margins_reset" value="Reset Margins" />
          <input type="submit" name="margins_test" value="Print Test Letter" />
          <p style="color:#933;">Warning!  Adjusting the letter margins will cause your letter template to no longer align with #9 envelope address fields.  Click “Reset” if you wish to restore the default margins.</p>
        </div>
      </form>

      <div style="width:100%">
        <div id="num_nine" class="third letter_templates">
          <h4>#9 Envelope</h4>
          <img style="border:solid 2px #000;" src="images/letter_template_number9-envelope.png" /><br /><br />
          <input type="button" onclick="set_num_nine();return false;" value="select" />
        </div>
        <div id="num_nine" class="third letter_templates">
          <h4> No return address + Left-aligned + Single Spacing</h4>
          <img style="border:solid 2px #000;" src="images/letter_template_NOreturn-left-single.png" /><br /><br />
          <input type="button" onclick="set_ls();return false;" value="select" />
        </div>
        <div id="num_nine" class="third letter_templates">
          <h4>Return address + Left + Single Spacing</h4>
          <img style="border:solid 2px #000;" src="images/letter_template_return-left-single.png" /><br /><br />
          <input type="button" onclick="set_rls();return false;" value="select" />
        </div>
      </div>

      <br /><br />

      <form action="#" method="post" style="clear:both;">
        <input type="checkbox" value="1" <?php echo ($user['use_letter_header']=='1')?'checked="checked"':'';?> id="letter_header" name="letter_header" /> Use Letter Return Address
        <br />
        <input type="checkbox" value="1" <?php echo ($user['indent_address']=='1')?'checked="checked"':'';?> id="indent_address" name="indent_address" /> Address Align: #9 Envelope
        <br />
        <input type="checkbox" value="1" <?php echo ($user['header_space']=='1')?'checked="checked"':'';?> id="header_space" name="header_space" /> Extra space in the header
        <br /><br />
        <input type="submit" name="letter_settings_but" value="Save Settings" />
      </form>
  <?php } else { ?>
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
  <div class="fullwidth">
    <?php
      if(isset($_POST['auto_letters'])) {
        $sql = "UPDATE dental_users SET
          tracker_letters = '".mysqli_real_escape_string($con,$_POST['tracker_letters'])."',
          intro_letters = '".mysqli_real_escape_string($con,$_POST['intro_letters'])."'
          WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
        
        $db->query($sql);
      }

      $let_sql = "SELECT use_letters, tracker_letters, intro_letters FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
      
      $let_r = $db->getRow($let_sql);
      if($let_r['use_letters']) {
    ?>
        <form action="#" method="post">
          <h3>Enable Auto-Generated Letters</h3>
          <input value="1" type="checkbox" name="tracker_letters" <?php echo  ($let_r['tracker_letters'])?'checked="checked"':''; ?> /> Allow software to automatically generate letters based on treatment steps from the TRACKER page. Unchecking this box means no letters will be generated unless you explicitly create them. Please leave this box CHECKED unless you know what you're doing!
          <br />
          <input value="1" type="checkbox" name="intro_letters" <?php echo  ($let_r['intro_letters'])?'checked="checked"':''; ?> /> Allow software to automatically generate welcome letters to new contacts.  Unchecking this box means no welcome letters will be generated unless you explicitly create them.  Please leave this box CHECKED unless you know what you're doing!
          <br />
          <input type="submit" name="auto_letters" value="Save Settings" />
        </form>
    <?php } ?>
  </div>

  <div class="fullwidth">
    <?php include 'stripe_card_info.php'; ?>
  </div>

  <?php include 'signature_test.php'; ?>


  <div id="popupContact" style="width:750px;height:460px">
      <a id="popupContactClose">
        <button>X</button>
      </a>
      <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
  </div>
  <div id="backgroundPopup"></div>

  <br /><br />  
  <?php include "includes/bottom.htm";?>


<script type="text/javascript">

  

</script>


