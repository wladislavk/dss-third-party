<table width="97%" align="center" style="float:left;margin-left:15px;">
<tr>
<td style="background:#333; color:#FFFFFF; font-size: 14px; font-weight:bold; height:30px;">
Sleep Studies:
</td>
</tr>
</table>
<div style="height:20px;"></div>
<!-- SLEEP LAB SECTION START -->
<style type="text/css">
  .sleeplabstable tr{ height: 28px; }
  .odd{ background: #F9FFDF; }
  .even{ background: #e4ffcf; }
</style>
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
                Needed
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Date Scheduled
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                Completed
                </td>
        </tr>
<tr>
                <td valign="top" class="even">
                Interpretation
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
                Copy Requested
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Request From
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
                Apnea
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                Hypopnia
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
                Sleep Efficiency
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                CPAP Level
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
  </table>


<script type="text/javascript">
function updateiframe(w){
$('#sleepstudies').css('width', ((w+1)*185)+'px');
}
</script>
<?php
$s_lab_query = "SELECT * FROM dental_summ_sleeplab WHERE patiendid ='".$_GET['pid']."' ORDER BY id DESC";
$s_lab_result = mysql_query($s_lab_query);
$num_labs = mysql_num_rows($s_lab_result);
if(isset($_POST['submitnewsleeplabsumm'])){ $num_labs++; }
$body_width = ($num_labs*185)+215;
?>

        <div style="border: medium none; width: 500px;float: left; margin-bottom: 20px; height: 869px;overflow-x:scroll;">
                    <iframe id="sleepstudies" height="842" width="<?= $body_width; ?>" style="border: medium none; overflow: hidden;" src="add_sleep_study.php?pid=<?php echo $_GET['pid']; ?>&yellow=1">Iframes must be enabled to view this area.</iframe>

        </div>


