<?php
require_once('admin/includes/config.php');
$pat_sql = "SELECT p_m_ins_type FROM dental_patients WHERE patientid='".$_GET['pid']."';";
$pat_q = mysql_query($pat_sql);
$pat_r = mysql_fetch_assoc($pat_q);
?>
<style type="text/css">
.sleeplabstable tr{height:28px; }
.yellow .odd, .yellow .even{
background:#edeb46;
}

  .odd{ background: #F9FFDF; }
  .even{ background: #e4ffcf; }
  select{width:140px;}
</style>


<table class="sleeplabstable" width="108" align="center" style="float:left; margin: 0;line-height:22px;">


        <tr>
                <td valign="top" class="odd">
                Date
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                Sleep Test Type
                </td></tr>
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
  </table>

<script type="text/javascript">
function validate_image(){
  if($('#ss_file').val() == ''){
    alert('Image is required.');
    return false;
  }
  return true;
}
</script>

<form action="#" method="POST" style="float:left; width:185px;" enctype="multipart/form-data" onsubmit="return validate_image();">
<table class="sleeplabstable <?php print ($show_yellow && !$sleepstudy  ? 'yellow' : ''); ?>" id="sleepstudyscrolltable">
        <tr>
                <td valign="top" class="odd">
                <input type="text" onchange="validateDate('date');" maxlength="255" style="width: 100px;" tabindex="10" class="field text addr tbox calendar" name="date" id="date" value="<?= date('m/d/Y'); ?>">
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                <select name="sleeptesttype">
      <option value="HST">HST</option>
      <option value="PSG">PSG</option>
      <option value="PSG Baseline">PSG Baseline</option>
      <option value="HST Baseline">HST Baseline</option>
      <option value="HST Titration">HST Titration</option>
    </select>
<script type="text/javascript">

function updatePlace(f){
if(f.sleeptesttype.value == "HST"){
  f.place.style.display = "none";
  f.home.style.display = "block";
}else{
  f.place.style.display = "block";
  f.home.style.display = "none";
}
}

</script>
                </td>
</tr>
  <tr>
                <td valign="top" class="odd">
<script type="text/javascript">

function addstudylab(v){
  if(v == 'add'){
    parent.loadPopupRefer('add_sleeplab.php?r=flowsheet');
  }
}

</script>
                <select name="place" class="place_select" onchange="addstudylab(this.value)">
<option>SELECT</option>
                <?php
     $lab_place_q = "SELECT sleeplabid, company FROM dental_sleeplab WHERE `status` = '1' AND docid = '".$_SESSION['docid']."' ORDER BY sleeplabid DESC";
     $lab_place_r = mysql_query($lab_place_q);
     while($lab_place = mysql_fetch_array($lab_place_r)){
    ?>
                  <option value="<?php echo $lab_place['sleeplabid']; ?>"><?php echo $lab_place['company']; ?></option>
    <?php
      }
    ?>
                <option value="add">ADD SLEEP LAB</option>
    </select>
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                          <select name="diagnosis" style="width:140px;" class="field text addr tbox" >
                                <option value="">SELECT</option>
                        <?php
                                $ins_diag_sql = "select * from dental_ins_diagnosis where status=1 order by sortby";
                                                                           $ins_diag_my = mysql_query($ins_diag_sql);

                                                                                while($ins_diag_myarray = mysql_fetch_array($ins_diag_my))
                                                                                {
                                                                                ?>
                                                                                        <option value="<?=st($ins_diag_myarray['ins_diagnosisid'])?>" >
                                                                                                <?=st($ins_diag_myarray['ins_diagnosis'])." ".$ins_diag_myarray['description'];?>
                                                                                        </option>
                                                                                <?
                                                                                }?>

                            </select> <span id="req_0" class="req">*</span>
                </td>
        </tr>
        <tr>
                <td valign="top" class="odd">
                  <input style="width:100px;" type="text" name="diagnosising_doc" />
                <?php
                        if($pat_r['p_m_ins_type']==1){
                ?>
                <span id="req_0" class="req">*</span>
                <?php
                        }
                ?>
                </td>
        </tr>
        <tr>
                <td valign="top" class="even">
                  <input style="width:100px;" type="text" name="diagnosising_npi" />
                <?php
                        if($pat_r['p_m_ins_type']==1){
                ?>
                <span id="req_0" class="req">*</span>
                <?php
                        }
                ?>
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                  <input style="width:140px" size="8" type="file" name="ss_file" id="ss_file" /> <span id="req_0" class="req">*</span>
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                <input type="text" name="ahi" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                <input type="text" name="ahisupine" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                <input type="text" name="rdi" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                <input type="text" name="rdisupine" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                <input type="text" name="o2nadir" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="odd">
                <input type="text" name="t9002" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="even" style="height:25px;">
                <select name="dentaldevice" style="width:150px;">
<option value="">SELECT</option>
        <?php
        $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
                                                                $device_my = mysql_query($device_sql);

                                                                while($device_myarray = mysql_fetch_array($device_my))
                                                                {
                ?>
                                                                 <option value="<?=st($device_myarray['deviceid'])?>"><?=st($device_myarray['device']);?></option>
                                                                 <?php
                                                                 }
                                                                ?>
    </select>
                </td>
  </tr>
  <tr>
                <td valign="top" class="odd">
                <input type="text" name="devicesetting" />
                </td>
        </tr>
  <tr>
                <td valign="top" class="even">
                <input type="text" name="notes" />
                </td>
        </tr>
        <tr>
                <td valign="top" class="odd">
		<input type="hidden" name="submitnewsleeplabsumm" value="1" />
                <input type="submit" value="Submit Study" />
                </td>
        </tr>
</table>
</form>

