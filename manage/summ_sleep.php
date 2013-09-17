<?php
$s_lab_query = "SELECT * FROM dental_summ_sleeplab WHERE patiendid ='".$_GET['pid']."' ORDER BY id DESC";
$s_lab_result = mysql_query($s_lab_query);
$num_labs = mysql_num_rows($s_lab_result);
if(isset($_POST['submitnewsleeplabsumm'])){ $num_labs++; }
$body_width = ($num_labs*185)+215;
if($num_labs == 0){
?>
<div id="no_sleep_studies_div">
Patient has no completed sleep studies. Click here to add a study.
<input type="button" id="new_sleep_study_but2" onclick="show_study_table(); return false;" value="+ Add Sleep Study" />
</div>
<?php
}
?>
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


<script type="text/javascript">
function updateiframe(w){
$('#sleepstudies').css('width', ((w+1)*185)+'px');
}
function show_new_study(){
$('#new_sleep_study_but').hide();
document.getElementById('sleepstudies').contentWindow.show_new_study();
}
function show_new_sleep_but(){
$('#new_sleep_study_but').show();
}
function show_study_table(){
  show_new_study();
  $('#no_sleep_studies_div').hide();
  $('#sleep_studies_div').show();
}
</script>

        <div id="sleepstudies" style="border: medium none; width: 630px;float: left; margin-bottom: 20px; height: 559px;overflow-x:scroll;">
		<div style="border: medium none; overflow: hidden;width:<?= $body_width; ?>px;">
		<?php include 'add_sleep_study.php'; ?>
		</div>
                    <!--<iframe id="sleepstudies" height="532" width="<?= $body_width; ?>" style="border: medium none; overflow: hidden;" src="add_sleep_study.php?pid=<?php echo $_GET['pid']; ?>&yellow=1">Iframes must be enabled to view this area.</iframe>-->

        </div>

</div>

<script type="text/javascript">
 function updatelabs(i,c,s=null){
        $('#sleepstudies').contents().find('.place_select').append("<option value='"+i+"'>"+c+"</option>");
	if(s){
		alert(s);
		$('#'+s).val(i);
	}
        disablePopupClean();
 }
function updateContactField(inField, inVal, idField, idVal){
$('#'+inField).val(inVal);
$('#'+idField).val(idVal);
}
</script>
