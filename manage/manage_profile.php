<?php
namespace Ds3\Libraries\Legacy;

set_time_limit(0);

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
      name='".mysqli_real_escape_string($con,$_POST['first_name'])." ".mysqli_real_escape_string($con,$_POST['last_name'])."',
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
      ein='".($_POST['ssnein'] === 'ein' ? 1 : 0)."',
      ssn='".($_POST['ssnein'] === 'ssn' ? 1 : 0)."',
      practice='".mysqli_real_escape_string($con,$_POST['practice'])."',
      first_name='".mysqli_real_escape_string($con,$_POST['first_name'])."',
      last_name='".mysqli_real_escape_string($con,$_POST['last_name'])."',
      name='".mysqli_real_escape_string($con,$_POST['first_name'])." ".mysqli_real_escape_string($con,$_POST['last_name'])."',
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
      service_ein = '".($_POST['service_ssnein'] === 'ein' ? 1 : 0)."',
      service_ssn = '".($_POST['service_ssnein'] === 'ssn' ? 1 : 0)."',
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
        {%long-content%}
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        <p>Sincerely,
        <br />
        <br />
        <br />
        name<br />
        <br />
        </p>
      ";

      $header = '';
      $footer = '';
      $cover = '';
      $overflow = '';

      if (!empty($_POST['margin_test']['cover'])) {
        // Get Doctor's Name and Email
        $sql = "SELECT name, email, phone, use_digital_fax, fax, logo, user_type
            FROM dental_users
            WHERE userid = '$docid'";
        $result = $db->getRow($sql);
        $doc_name = $result['name'];
        $doc_phone = $result['phone'];
        $doc_fax = $result['fax'];
        $logo = $result['logo'];
        $user_type = $result['user_type'];

        if ($user_type == DSS_USER_TYPE_SOFTWARE){
          if ($logo != ''){
            $cover_image = "<img src=\"../../../shared/q_file/$logo\" />";
          } else {
            $cover_image = "";
          }
        }else{
          $cover_image = "<img src=\"/manage/images/logo.gif\" />";
        }

        $cover = "
  <table>
  <tr>
  <td>$cover_image</td>
  <td><center>
  <b>CONFIDENTIAL HEALTH INFORMATION<br />
  FAX COVER SHEET</b>
  </center>
  </td>
  </tr>
  </table>
  <br /><br /><br />
  <b>DATE:</b> ".date('m/d/Y')."<br />
  <br />
  <b>TO:</b><br />
  NAME: John Smith<br />
  PHONE: ".format_phone('01234567890')."<br />
  FAX: ".format_phone('1234567890')."
  <br /><br />
  <b>FROM:</b><br />
  NAME: ".$doc_name."<br />
  PHONE: ".format_phone($doc_phone)."<br />
  FAX: ".format_phone($doc_fax)."<br /><br />

  TOTAL NUMBER OF PAGES:  %NUM_PAGES%
  <br /><br />
  <b>IF YOU RECEIVE THIS FAX IN ERROR, PLEASE CONTACT THE SENDER IMMEDIATELY AND THEN DESTROY THE FAXED MATERIALS.
  <br /><br />
  CONFIDENTIALITY NOTICE:</b><br />
  The documents accompanying this transmission contain legally privileged health information. This information is intended only for the use of the individual or entity named above. The authorized recipient of this information is prohibited from disclosing this information to any other party unless required to do so by law or regulation and is required to destroy the information after its stated need has been fulfilled.
  <br /><br />
  If you are not the intended recipient, you are hereby notified that any disclosure, copying, distribution, or action taken in reliance on the contents of these documents is strictly prohibited. If you have received this information in error, please notify the sender and the privacy officer immediately and arrange for the return or destruction of these documents.
  ";
      }

      if (!empty($_POST['margin_test']['header'])) {
        $header = date('F j, Y, g:i a') . ' - Header';
      }

      if (!empty($_POST['margin_test']['footer'])) {
        $franchisee_query = "SELECT
            u.user_type,
            l.name,
            mailing_name,
            l.location mailing_practice,
            l.address mailing_address,
            l.city mailing_city,
            l.state mailing_state,
            l.zip mailing_zip,
            u.email
          FROM dental_users u
            LEFT JOIN dental_locations l ON l.docid = u.userid AND l.default_location = 1
          WHERE u.userid = '$docid'";
        $franchisee_result = $db->getResults($franchisee_query);

        if ($franchisee_result) {
          foreach ($franchisee_result as $row) {
            $fi = $row;
          }
        }

        if (!empty($fi) && $fi['user_type'] == DSS_USER_TYPE_FRANCHISEE) {
          $footer = "{$fi['mailing_name']} {$fi['mailing_practice']} {$fi['mailing_address']} {$fi['mailing_city']} {$fi['mailing_state']} {$fi['mailing_zip']}";
        } else {
          $footer = 'Dr Name DSS Practice 742 Evergreen Terrace Springfield WA 00000';
        }
      }

      if (!empty($_POST['margin_test']['overflow'])) {
        $overflow = '<ul>
<li>
  No nec vero assueverit sadipscing. Oblique epicurei electram ut sit.
  <ul>
    <li>Dicta omittantur ei ius. Nam ei causae qualisque. Ne nam omittam intellegat.</li>
  </ul>
</li>
<li>
  Sed in nihil facilis quaestio, eu eam lorem vitae. Vel at natum idque aliquam, tation dissentias ex cum. Vis an possim interesset, eu autem veniam platonem mei.
  <ul>
    <li>Id eum libris accumsan dissentias. Saepe mediocritatem usu at, diam vitae expetenda vel ei, idque adipisci mnesarchum ne ius.</li>
    <li>An mei labores appareat, eu qui augue altera civibus.</li>
  </ul>
</li>
<li>
  Eu nibh quaerendum qui, pro cibo viris ex, vix consul nostrud electram id. In eum postea percipitur assueverit, laoreet accusamus neglegentur id mel.
  <ul>
    <li>Epicuri persecuti scribentur ei eos, quo ludus altera an. Tollit aliquando at vim, apeirian iudicabit tincidunt nec ne.</li>
    <li>An tamquam eligendi eum, duo dicit vituperatoribus ei, ut alia vocent efficiantur sea.</li>
  </ul>
</li>
<li>
  In vidit officiis interpretaris ius. Ei deserunt inciderint sea, esse inani delectus ad mel. Id per oporteat laboramus, duo quaeque alterum delectus eu. Quis perfecto adipiscing eum in, habeo persecuti no his.</li>
<li>
  Sit nullam assueverit intellegebat ut. An tota nemore instructior est. Alii mazim senserit duo ne.
  <ul>
    <li>Ferri ubique imperdiet vel an.</li>
    <li>Eos mandamus philosophia eu, legimus scaevola no his.</li>
    <li>Amet splendide in sed.</li>
  </ul>
</li>
</ul>
<p>
Etiam sit amet suscipit leo, sit amet sagittis urna. Nunc vitae odio dolor. Sed porttitor velit vitae sapien volutpat, ac facilisis ligula porta. Sed ac lorem nec ligula vehicula commodo. Ut ut eleifend velit. Aenean massa diam, imperdiet vitae posuere non, pharetra a arcu. Nulla et est diam. Mauris vitae augue a neque condimentum fermentum non id tortor. Duis sit amet est eget est aliquam lobortis. Nulla eleifend suscipit consequat. Morbi rhoncus, arcu eleifend efficitur bibendum, justo quam viverra ipsum, ut scelerisque ex quam ut velit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus quis aliquam nunc. Sed vel tortor a elit volutpat euismod ac vitae eros.
</p>
<p>
Duis ex nisi, dictum in pellentesque in, sagittis in leo. Mauris tortor elit, placerat vitae sem a, sodales pharetra quam. Pellentesque maximus at massa id egestas. Phasellus dolor erat, faucibus quis efficitur sed, ultrices at nulla. Nam aliquet, nunc a posuere vehicula, odio metus tincidunt lectus, et ultrices enim velit sit amet orci. Vivamus at pharetra nisi. In faucibus viverra lectus, vel rutrum mi dapibus ac. Ut id mi dolor. Nullam eget mi pellentesque, hendrerit lorem in, iaculis lorem.
</p>
<p>
Maecenas tempus mollis mauris, nec suscipit libero dapibus id. Suspendisse tortor lacus, blandit at sodales ac, vestibulum eget felis. Vivamus elit odio, accumsan sit amet elementum a, mattis sed ipsum. Quisque faucibus neque nec orci convallis vehicula. Vivamus in est ante. Vestibulum a tortor ac odio auctor eleifend eget at velit. Ut fermentum mattis hendrerit. Integer id dolor sed nunc viverra rhoncus et ut elit. Nunc eleifend sodales lorem. Donec at ornare eros. Nullam pretium lacinia egestas. Morbi risus massa, bibendum sit amet nisi molestie, dapibus egestas turpis. Sed accumsan neque tincidunt diam ullamcorper, id condimentum magna aliquet. Aliquam erat volutpat. Nunc consequat lacus nec tortor fermentum sollicitudin. Phasellus fermentum aliquet rutrum.
</p>
<p>
Donec risus elit, condimentum eget eros at, finibus posuere eros. Sed nibh nunc, rutrum vel aliquet quis, tristique eu risus. Proin fermentum leo in elementum consequat. Etiam egestas massa hendrerit leo molestie, non lacinia ante mollis. Donec nec tellus sit amet dolor blandit lacinia. Aliquam porttitor pharetra lacus, tincidunt ultrices arcu sollicitudin ut. Maecenas tellus orci, fringilla in lorem vitae, suscipit ultrices lectus. Donec ut justo magna.
</p>
<p>
Aliquam aliquam eleifend vestibulum. Curabitur vitae feugiat dui. Vivamus interdum ex erat, ac viverra sem imperdiet sit amet. Cras vulputate molestie leo nec mollis. Suspendisse potenti. Pellentesque mollis ultricies justo sit amet consequat. Nam imperdiet arcu et ligula consequat faucibus et eu mi. Duis ac elit eu arcu pretium pretium vel vitae dui. In hac habitasse platea dictumst. Duis vitae nisi aliquam, porttitor orci vitae, sagittis elit.
</p>';
      }

      $html = str_replace('{%long-content%}', $overflow, $html, $replacements);

      //CREATE LETTER HERE
      create_pdf($title, $filename, $html, null, $header, $footer, $cover, $_SESSION['docid'] );
?>
      <script type="text/javascript">
        window.open('letterpdfs/<?php echo  $filename; ?>?t=<?= time() ?>');
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
<style>
  hr {
    margin: 2em auto;
    width: 80%;
    border: 1px solid #ccc;
    clear: both;
  }

  .detail label.inline {
    text-align: left;
  }

  .two-column {
    float: left;
    width: 49%;
  }

  .letter-template {
    border:solid 2px #ccc;
    cursor: pointer;
  }

  .letter-template.selected {
    border-color: #000;
  }
</style>
  <script src="admin/popup/popup.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
    var $templates = $('img.letter-template');

    $templates.click(function(){
      var $this = $(this);

      $templates.removeClass('selected');
      $this.addClass('selected');
    });
  });
</script>

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
          <label style="display:inline;width:auto;">
            <input type="radio" name="ssnein" value="ein" <?= $practice['ein'] == 1 ? 'checked' : '' ?> />
            EIN
          </label>
          <label style="display:inline;width:auto;">
            <input type="radio" name="ssnein" value="ssn" <?= $practice['ssn'] == 1 ? 'checked' : '' ?> />
            SSN
          </label>
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
          <label style="display:inline;width:auto;">
            <input type="radio" name="service_ssnein" value="ein" <?= $practice['service_ein'] == 1 ? 'checked' : '' ?> />
            EIN
          </label>
          <label style="display:inline;width:auto;">
            <input type="radio" name="service_ssnein" value="ssn" <?= $practice['service_ssn'] == 1 ? 'checked' : '' ?> />
            SSN
          </label>
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
      <hr />
      <h3>Letter Margins</h3>
      All units in millimeters (mm).
      <form action="#" method="post">
        <div class="two-column">
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
            <label><strong>Fax only</strong></label>
          </div>
          <div class="detail">
            <label>Header:</label>
            <input class="value" name="letter_margin_header" value="<?php echo  $practice['letter_margin_header']; ?>" />
          </div>
          <div class="detail">
            <label>Footer:</label>
            <input class="value" name="letter_margin_footer" value="<?php echo  $practice['letter_margin_footer']; ?>" />
          </div>
        </div>
        <div class="two-column">
          <div class="detail">
            <input type="submit" name="margins_submit" value="Update Margins" />
            <input type="submit" name="margins_reset" value="Reset Margins" />
          </div>
          <p>&nbsp;</p>
          <div class="detail">
            <div class="third">
              <input type="submit" name="margins_test" value="Print Test Letter" />
            </div>
            <div class="third">
              <label class="inline" title="Include a header in the test print">
                <input type="checkbox" name="margin_test[header]" value="1" />
                Header
              </label>
              <label class="inline" title="Include a footer in the test print">
                <input type="checkbox" name="margin_test[footer]" value="1" />
                Footer
              </label>
            </div>
            <div class="third">
              <label class="inline"  title="Include a cover page in the test print">
                <input type="checkbox" name="margin_test[cover]" value="1" />
                Cover page
              </label>
              <label class="inline" title="Make the test contents long enough to generate two pages">
                <input type="checkbox" name="margin_test[overflow]" value="1" />
                Two pages
              </label>
            </div>
          </div>
        </div>
        <div class="clear"></div>
        <p style="color:#933;text-align:center;">Warning!  Adjusting the letter margins will cause your letter template to no longer align with #9 envelope address fields.  Click “Reset” if you wish to restore the default margins.</p>
      </form>
      <hr />
      <div style="width:100%">
        <div id="num_nine" class="third letter_templates">
          <h4>#9 Envelope</h4>
          <img class="letter-template <?= $user['use_letter_header'] && $user['indent_address'] && $user['header_space'] ? 'selected' : '' ?>"
               onclick="set_num_nine();" src="images/letter_template_number9-envelope.png" />
        </div>
        <div id="num_nine" class="third letter_templates">
          <h4> No return address + Left-aligned + Single Spacing</h4>
          <img class="letter-template <?= !$user['use_letter_header'] && !$user['indent_address'] && !$user['header_space'] ? 'selected' : '' ?>"
               onclick="set_ls();" src="images/letter_template_NOreturn-left-single.png" />
        </div>
        <div id="num_nine" class="third letter_templates">
          <h4>Return address + Left + Single Spacing</h4>
          <img class="letter-template <?= $user['use_letter_header'] && !$user['indent_address'] && !$user['header_space'] ? 'selected' : '' ?>"
               onclick="set_rls();" src="images/letter_template_return-left-single.png" />
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
          <hr />
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
    <hr />
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


