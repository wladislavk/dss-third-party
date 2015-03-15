<?php namespace Ds3\Libraries\Legacy; ?><?php
$s_lab_query = "SELECT * FROM dental_summ_sleeplab WHERE patiendid ='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."' ORDER BY id DESC";
$num_labs = $db->getNumberRows($s_lab_query);
if(isset($_POST['submitnewsleeplabsumm'])){ 
  $num_labs++; 
}
$body_width = ($num_labs*245)+245;
if($num_labs == 0){?>

<div id="no_sleep_studies_div">
  Patient has no completed sleep studies. Click here to add a study.
  <input type="button" id="new_sleep_study_but2" onclick="show_study_table(); return false;" value="+ Add Sleep Study" />
</div>
<?php
}?>

<div id="sleep_studies_div" <?= ($num_labs==0)?'style="display:none;"':''; ?>>
  <table width="97%" align="center" style="float:left;margin-left:15px;">
    <tr>
      <td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;">
        Sleep Tests:
      </td>
    </tr>
  </table>
  <div style="height:20px;"></div>
<!-- SLEEP LAB SECTION START -->
<link rel="stylesheet" href="css/summ_sleep.css" type="text/css" media="screen" />
  <table class="sleeplabstable" width="108" align="center" style="float:left; margin: 0 0 0 15px;line-height:22px;">
    <tr>
      <td valign="top" class="odd">
        Date
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        Sleep Test Type
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        Place
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        Diagnosis
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        Diagnosing Phys.
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        Diagnosing NPI#
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        File
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        AHI
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        AHI Supine
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        RDI
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        RDI Supine
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        O<sub>2</sub> Nadir
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        T &le; 90% O<sub>2</sub>
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        Dental Device
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        Device Setting
      </td>
    </tr>
    <tr>
      <td valign="top" class="even">
        Notes
      </td>
    </tr>
    <tr>
      <td valign="top" class="odd">
        <input type="button" id="new_sleep_study_but" onclick="show_new_study(); return false;" value="+ Add Sleep Study" />  
      </td>
    </tr>
  </table>

<script src="js/summ_sleep.js" type="text/javascript"></script>

  <div id="sleepstudies" style="border: medium none; width: 630px;float: left; margin-bottom: 20px; height: 559px;overflow-x:scroll;">
  	<div style="border: medium none; overflow: hidden;width:<?= $body_width; ?>px;">
  		<?php include 'add_sleep_study.php'; ?>
  	</div>
                      <!--<iframe id="sleepstudies" height="532" width="<?= $body_width; ?>" style="border: medium none; overflow: hidden;" src="add_sleep_study.php?pid=<?php echo $_GET['pid']; ?>&yellow=1">Iframes must be enabled to view this area.</iframe>-->
  </div>

</div>

