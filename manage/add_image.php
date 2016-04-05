<?php namespace Ds3\Libraries\Legacy; ?><?php

include_once('admin/includes/main_include.php');
include_once('includes/constants.inc');
include("includes/sescheck.php");
include_once('includes/general_functions.php');

$uploaded = false;

$patientId = intval($_GET['pid']);

$maxFileSizeExceeded = 'There was an error with the file upload(s). Please verify that the file does not exceed 10MB and try again.';
$noFileName = 'There was an error with the file upload(s). Please ensure the filename does not contain strange characters and try again.';
$invalidFileType = 'There was an error with the file upload(s). Please ensure the filename has the correct extension and try again.';
$multipleImages = 'Image processing has stopped as one image contained an error: ';
$errorMessage = '';

if (isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] && !$_FILES) {
    error_log('Max file size exceeded AND PHP didn\'t populate FILES global variable, and POST might be corrupt');
    $errorMessage = $maxFileSizeExceeded;
}

if (!$errorMessage && isset($_POST['submitnewsleeplabsumm'])) {
    $date = s_for($_POST['date']);
    $sleeptesttype = s_for($_POST['sleeptesttype']);
    $place = s_for($_POST['place']);
    $diagnosising_doc = s_for($_POST['diagnosising_doc']);
    $diagnosising_npi = s_for($_POST['diagnosising_npi']);
    $apnea = s_for($_POST['apnea']);
    $hypopnea = s_for($_POST['hypopnea']);
    $ahi = s_for($_POST['ahi']);
    $ahisupine = s_for($_POST['ahisupine']);
    $rdi = s_for($_POST['rdi']);
    $rdisupine = s_for($_POST['rdisupine']);
    $o2nadir = s_for($_POST['o2nadir']);
    $t9002 = s_for($_POST['t9002']);
    $sleepefficiency = s_for($_POST['sleepefficiency']);
    $cpaplevel = s_for($_POST['cpaplevel']);
    $dentaldevice = s_for($_POST['dentaldevice']);
    $devicesetting = s_for($_POST['devicesetting']);
    $diagnosis = s_for($_POST['diagnosis']);
    $notes = s_for($_POST['notes']);
    $testnumber = s_for($_POST['testnumber']);
    $needed = s_for($_POST['needed']);
    $scheddate = s_for($_POST['scheddate']);
    $completed = s_for($_POST['completed']);
    $interpolation = s_for($_POST['interpolation']);
    $copyreqdate = s_for($_POST['copyreqdate']);
    $sleeplab = s_for($_POST['sleeplab']);
    $patientid = intval($_GET['pid']);

    $banner1 = '';
    $image_id = '';

    if (isset($_FILES['ss_file'])) {
        $errorNo = $_FILES['ss_file']['error'];

        if (isFaultyUpload($errorNo)) {
            error_log("SS file upload error [{$errorNo}]: {$dss_file_upload_errors[$errorNo]}");
            $errorMessage = $maxFileSizeExceeded;
        } elseif (!$errorNo && !strlen(trim($_FILES['ss_file']['name']))) {
            error_log("SS file upload error: The file upload misses the filename");
            $errorMessage = $noFileName;
        } elseif (!$errorNo) {
            $fname = $_FILES["ss_file"]["name"];
            $lastdot = strrpos($fname,".");

            $name = substr($fname,0,$lastdot);
            $extension = substr($fname,$lastdot+1);

            $name = preg_replace('/[^a-z0-9_]+/i', '-', $name);
            $extension = preg_replace('/[^a-z0-9_]+/i', '', $extension);

            $banner1 = $name.'_'.date('dmy_Hi');
            $banner1 .= ".".$extension;

            $uploaded = uploadImage($_FILES['ss_file'], "../../../shared/q_file/".$banner1);

            if ($uploaded) {
                $ins_sql = " insert into dental_q_image set
                              patientid = '".s_for($_GET['pid'])."',
                              title = '".$sleeptesttype." ".$date."',
                              imagetypeid = '1',
                              image_file = '".s_for($banner1)."',
                              userid = '".s_for($_SESSION['userid'])."',
                              docid = '".s_for($_SESSION['docid'])."',
                              adddate = now(),
                              ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                $image_id = $db->getInsertId($ins_sql);
            } else {
                error_log('SS file upload save error. Error message should be stored above this line.');
                $errorMessage = $maxFileSizeExceeded;
                $banner1 = '';
            }
        }
    } else {
        $banner1 = '';
        $image_id = '';
    }

    if (!$errorMessage) {
        $q = "INSERT INTO `dental_summ_sleeplab` (
                `id` , `date` , `sleeptesttype` , `place` , `diagnosising_doc`, `diagnosising_npi`, `ahi` , `ahisupine` ,
                `rdi` , `rdisupine` , `o2nadir` , `t9002` , `dentaldevice` , `devicesetting` , `diagnosis` ,
                `filename` , `notes`, `testnumber`, `sleeplab`, `patiendid`, `image_id`
            )
            VALUES (NULL,'".
            $date."','".$sleeptesttype."','".$place."','".$diagnosising_doc."','".$diagnosising_npi."','".$ahi."','".$ahisupine."','".
            $rdi."','".$rdisupine."','".$o2nadir."','".$t9002."','".$dentaldevice."','".$devicesetting."','".$diagnosis."','".
            $banner1."', '".$notes."', '".$testnumber."', '".$sleeplab."', '".$patientid."', '".$image_id."')";

        error_log("SS save query: $q");
        $run_q = $db->getInsertId($q);

        if (empty($run_q)) {
            $errorMessage = 'Could not add sleep lab... Please try again.';
        }
    }

    if (!empty($run_q)) {
        if ($uploaded) {
            $ins_id = $run_q;
        }

        $msg = "Successfully added sleep lab". ($uploaded ? ' but the file upload failed' : '');
        ?>
        <script type="text/javascript">
            parent.window.location='q_image.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}

if (!$errorMessage && !empty($_POST["imagesub"]) && $_POST["imagesub"] == 1) {
    $title = $_POST['title'];
    $imageId = intval($_POST['ed']);
    $imageTypeId = intval($_POST['imagetypeid']);

    $primaryFileUpload = isset($_FILES['image_file']);
    $secondaryFileUpload = isset($_FILES['image_file_1']);

    $primaryError = false;
    $secondaryError = false;

    if ($primaryFileUpload) {
        $primaryError = $_FILES['image_file']['error'];

        if (isFaultyUpload($primaryError)) {
            error_log("[Image file] file upload error [{$primaryError}]: {$dss_file_upload_errors[$primaryError]}");
            $errorMessage = $maxFileSizeExceeded;
        } elseif (!$primaryError && !strlen(trim($_FILES['ss_file']['name']))) {
            error_log("SS file upload error: The file upload misses the filename");
            $errorMessage = $noFileName;
        }
    }

    if ($secondaryFileUpload) {
        $secondaryError = $_FILES['image_file_1']['error'];

        if (isFaultyUpload($secondaryError)) {
            error_log("[Image file (1)] file upload error [{$secondaryError}]: {$dss_file_upload_errors[$secondaryError]}");
            $errorMessage = $maxFileSizeExceeded;
        } elseif (!$secondaryError && !strlen(trim($_FILES['ss_file']['name']))) {
            error_log("SS file upload error: The file upload misses the filename");
            $errorMessage = $noFileName;
        }
    }

    if (
        $imageId == '' ||
        ($primaryFileUpload && $primaryError === 0) ||
        ($secondaryFileUpload && $secondaryError === 0)
    ) {
        $ftype = isset($_FILES["image_file"]["type"]) ? $_FILES["image_file"]["type"] : '';
        $fname = isset($_FILES["image_file"]["name"]) ? $_FILES["image_file"]["name"] : '';
        $lastdot = strrpos($fname, ".");
        $name = substr($fname, 0, $lastdot);
        $extension = substr($fname, $lastdot + 1);

        $name = preg_replace('/[^a-z0-9_]+/i', '-', $name);
        $extension = preg_replace('/[^a-z0-9_]+/i', '', $extension);

        if (
            $imageTypeId == 0 ||
            (array_search($ftype, $dss_file_types) !== false) ||
            (array_search(strtolower($extension), $dss_file_extensions) !== false)
        ) {
            if ($imageTypeId == '0') {
                $fname = $_FILES["image_file_1"]["name"];
                $lastdot = strrpos($fname,".");
                $name = substr($fname,0,$lastdot);
                $extension = substr($fname,$lastdot+1);

                $name = preg_replace('/[^a-z0-9_]+/i', '-', $name);
                $extension = preg_replace('/[^a-z0-9_]+/i', '', $extension);

                $banner1 = $name.'_'.date('dmy_Hi');
                $banner1 .= ".".$extension;

                // Get new sizes
                $newwidth = 1500;
                $newheight = 1500;

                // Load
                $thumb = imagecreatetruecolor($newwidth, $newheight);

                $troublesomeImages = 0;

                for ($i=1; $i<=9 && !$troublesomeImages; $i++) {
                    $fname = $_FILES["image_file_".$i]["name"];
                    $lastdot = strrpos($fname,".");
                    $name = substr($fname,0,$lastdot);
                    $extension2 = substr($fname,$lastdot+1);

                    switch (strtolower($extension2)) {
                        case 'jpg':
                        case 'jpeg':
                            $source = @imagecreatefromjpeg($_FILES["image_file_".$i]["tmp_name"]);
                            break;
                        case 'gif':
                            $source = @imagecreatefromgif($_FILES["image_file_".$i]["tmp_name"]);
                            break;
                        case 'png':
                            $source = @imagecreatefrompng($_FILES["image_file_".$i]["tmp_name"]);
                            break;
                    }

                    if (empty($source)) {
                        // What if we cannot read the tmp file?
                        error_log('Image upload: invalid image extension, attempting to read from string');
                        $source = @imagecreatefromstring(file_get_contents($_FILES["image_file_".$i]["tmp_name"]));
                    }

                    // If we cannot read at least once image, stop processing ALL images
                    if (empty($source)) {
                        error_log('Image upload: invalid image type, or unable to read the uploaded file');
                        $troublesomeImages++;
                        break;
                    }

                    list($width, $height) = getimagesize($_FILES["image_file_".$i]["tmp_name"]);
                    $x = (($i - 1) % 3) * 500;
                    $y = floor(($i - 1) / 3) * 500;

                    $aspectRatioOfWidth  = $width / $height;
                    $aspectRatioOfHeight = $height / $width;

                    $newWidth = 500;
                    $newHeight = 500;

                    if ($aspectRatioOfWidth < 1) {
                        $newWidth = floor(500 * $aspectRatioOfWidth);
                        $x += 500 - $newWidth;
                    } else {
                        $newHeight = floor(500 * $aspectRatioOfHeight);
                        $y += 500 - $newHeight;
                    }

                    // Resize
                    imagecopyresized($thumb, $source, $x, $y, 0, 0, $newWidth, $newHeight, $width, $height);
                }

                if ($troublesomeImages) {
                    error_log('Image upload: errors uploading multiple images, maybe image types');
                    $errorMessage = "{$multipleImages}{$invalidFileType}";
                } else {
                    // Output
                    switch (strtolower($extension)) {
                        case 'jpg':
                        case 'jpeg':
                            imagejpeg($thumb, "../../../shared/q_file/".$banner1);
                            break;
                        case 'gif':
                            imagegif($thumb, "../../../shared/q_file/".$banner1);
                            break;
                        case 'png':
                            imagepng($thumb, "../../../shared/q_file/".$banner1);
                            break;
                    }

                    @chmod("../../../shared/q_file/".$banner1,0777);
                    $uploaded = file_exists("../../../shared/q_file/$banner1");
                }

                if (!$uploaded) {
                    $banner1 = '';
                }
            } else { //ALL OTHER IMAGES
                $filesize = $_FILES["image_file"]["size"];

                if ($filesize <= DSS_IMAGE_MAX_SIZE) {
                    if ($_FILES["image_file"]["name"] <> '') {
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 .= ".".$extension;

                        $profile = ($_POST['imagetypeid']==4)?'profile':'general';
                        $uploaded = uploadImage($_FILES['image_file'], "../../../shared/q_file/".$banner1, $profile);

                        if ($uploaded) {
                            if ($_POST['image_file_old'] <> '') {
                                @unlink("../../../shared/q_file/".$_POST['image_file_old']);
                            }
                        } else {
                            $banner1 = '';
                        }
                    } else {
                        $banner1 = $_POST['image_file_old'];
                    }
                } else {
                    $errorMessage = $maxFileSizeExceeded;
                    $uploaded = false;
                }
            }
        } else {
            $errorMessage = 'Invalid File Type. The uploaded file has an invalid format or an incorrect file extension.';
        }
    } else {
        $ed_sql = "UPDATE dental_q_image SET 
                      title = '" . $db->escape($title) . "',
                      imagetypeid = '$imageTypeId'
                      WHERE imageid = '$imageId'";
        $db->query($ed_sql);

        if ($_POST['claim_file_update'] == 1) {
            updateClaimRelatedArchives($patientId, $imageId, $imageTypeId);
        }

        $msg = "Edited Successfully";?>
        <script type="text/javascript">
            parent.window.location='q_image.php?pid=<?php echo $_GET['pid'];?>&sh=<?php echo $_GET['sh'];?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    if ($uploaded) {
        if ($_POST["ed"] != "") {
            $ed_sql = " update dental_q_image set
                    			title = '".s_for($title)."',
                    			imagetypeid = '".s_for($imageTypeId)."' ";

            if ($uploaded) {
                $ed_sql .= ", image_file = '".s_for($banner1)."' ";
            }

            $ed_sql .= " where imageid = '".s_for($_POST['ed'])."'";
            $db->query($ed_sql);

            $msg = "Edited Successfully";?>

            <script type="text/javascript">
                parent.window.location='q_image.php?pid=<?php echo $_GET['pid'];?>&sh=<?= $imageTypeId ?>';
            </script>
            <?php
            trigger_error("Die called", E_USER_ERROR);
        } else {
            $ins_sql = " insert into dental_q_image set
                      			patientid = '".s_for($_GET['pid'])."',
                      			title = '".s_for($title)."',
                      			imagetypeid = '".s_for($imageTypeId)."',
                      			image_file = '".s_for($banner1)."',
                      			userid = '".s_for($_SESSION['userid'])."',
                      			docid = '".s_for($_SESSION['docid'])."',
                      			adddate = now(),
                      			ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

            $imageId = $db->getInsertId($ins_sql);

            if ($_POST['claim_file_update'] == 1) {
                updateClaimRelatedArchives($patientId, $imageId, $imageTypeId);
            }

            $msg = "Uploaded Successfully";

            if ($_REQUEST['flow'] == "1") {?>
                <script type="text/javascript">
                    parent.window.location="/manage/manage_flowsheet3.php?pid=<?php echo $_GET['pid'];?>"
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            } else if ($_REQUEST['return'] == 'patinfo') { ?>
                <script type="text/javascript">
                    <?php if($_REQUEST['return_field']=='profile'){ ?>
                    parent.updateProfileImage('<?php echo $banner1; ?>');
                    <?php }elseif($_POST['imagetypeid']==10){ ?>
                    parent.updateInsCard('<?php echo $banner1; ?>', 'p_m_ins_card');
                    <?php }elseif($_POST['imagetypeid']==12){ ?>
                    parent.updateInsCard('<?php echo $banner1; ?>', 's_m_ins_card');
                    <?php } ?>
                    parent.disablePopupClean();
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            } else { ?>
                <script type="text/javascript">
                    parent.window.location='q_image.php?pid=<?php echo $_GET['pid'];?>';
                </script>
                <?php
                trigger_error("Die called", E_USER_ERROR);
            }
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="css/admin.css?v=20160404" />
    <link rel="stylesheet" type="text/css" href="css/form.css" />
    <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
    <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
    <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="script/validation.js"></script>
    <script type="text/javascript" src="/manage/js/file-upload-check.js"></script>
    <script type="text/javascript" src="js/add_image.js?v=<?= time() ?>"></script>
</head>
<body>
<div id="loader" style="position:absolute;width:100%; height:98%; display:none;">
    <img style="margin:100px 0 0 45%" src="images/DSS-ajax-animated_loading-gif.gif" />
</div>
<?php
$thesql = "select * from dental_q_image where imageid='".intval($_REQUEST["ed"])."'";
$themyarray = $db->getRow($thesql);

if(!empty($msg)){
  	$title = $_POST['title'];
		$imageTypeId = intval($_POST['imagetypeid']);
}else{
		$title = st($themyarray['title']);
		$image_file = st($themyarray['image_file']);
		$imageTypeId = intval($themyarray['imagetypeid']);
		$but_text = "Add ";
}

if($imageTypeId == '')
		$imageTypeId = intval($_GET['sh']);

$forceMode = !empty($_GET['itro']) && $_GET['itro'] == 1;

if(!empty($themyarray["contactid"])){
		$but_text = "Edit ";
}else{
  	$but_text = "Add ";
}?>
	
<br /><br />
	
<?php if (!empty($msg)) { ?>
<div align="center" class="red">
    <?php echo $msg;?>
</div>
<?php } ?>
<form name="imagefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1&pid=<?php echo $_GET['pid'];?>&sh=<?= $imageTypeId ?>" method="post" onSubmit="return imageabc(this);" enctype="multipart/form-data">
		<input name="flow" type="hidden" value="<?php echo (!empty($_GET['flow']) ? $_GET['flow'] : '');?>" />
    <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Image
               <?php if($title <> "") {?>
               		&quot;<?php echo $title;?>&quot;
               <?php }?>
            </td>
        </tr>
    		<tr>
          	<td valign="top" colspan="2" class="frmhead">
        				<ul>
                    <li id="foli8" class="complex">	
            						<span>
              							Image Type
              							&nbsp;&nbsp;
<?php
$itype_sql = "select * from dental_imagetype where status=1 order by sortby";
$itype_my = $db->getResults($itype_sql);

if ($forceMode) { ?>
                            <input type="hidden" id="imagetypeid" name="imagetypeid" value="<?= $imageTypeId ?>" />
<?php
    foreach ($itype_my as $itype_myarray) {
        if($imageTypeId == st($itype_myarray['imagetypeid'])){
            echo $itype_myarray['imagetype'];
        }
	  }
}else{?>
              							<select id="imagetypeid" name="imagetypeid" class="field text addr tbox" >
                								<option value=""></option>
<?php 
    foreach ($itype_my as $itype_myarray) {?>
              									<option value="<?php echo st($itype_myarray['imagetypeid']);?>" <? if($imageTypeId == st($itype_myarray['imagetypeid']) || !empty($_GET['it']) && $_GET['it']==$itype_myarray['imagetypeid']) echo " selected"; ?>>
                										<?php echo st($itype_myarray['imagetype']);?>
              									</option>
<?php 
    }?>
                								<option value="0">Clinical Photos (Pre-Tx Batch)</option>
              							</select>
<?php 
} ?>
            						</span> 
            						<span id="req_0" class="req">*</span>
                    </li>
                </ul>
            </td>
        </tr>
<?php

$patientId = intval($_GET['pid']);

// These keys match the ones from claimRelatedArchiveType
$claimRelatedArchivesSql = "SELECT rx_imgid AS `rx`, lomn_imgid AS `lomn`, rxlomn_imgid AS `rxlomn`
        FROM dental_flow_pg1 WHERE pid='$patientId'
        UNION SELECT NULL, NULL, NULL";
$claimRelatedArchives = $db->getRow($claimRelatedArchivesSql);

$claimRelatedType = $themyarray ? array_search($themyarray['imageid'], $claimRelatedArchives) : '';
$currentType = claimRelatedArchiveType($imageTypeId);

if ($themyarray && $claimRelatedType) { ?>
        <tr>
            <td valign="top" colspan="2" class="frmhead">
                This image is on file for insurance claims as
                <?= $claimRelatedType === 'rxlomn' ? 'LOMN / Rx' : strtoupper($claimRelatedType) ?>
            </td>
        </tr>
<?php } ?>
        <tr class="image_sect claim_file_update" <?= $themyarray || $forceMode ? '' : 'style="display:none;"' ?>>
            <td valign="top" colspan="2" class="frmhead">
                <label title="By selecting this option the current image will replace any other LOMN / Rx on file">
                    <input type="checkbox" value="1" name="claim_file_update"
                        <?= $claimRelatedType === $currentType ? 'disabled' : '' ?>
                        <?= $claimRelatedType || ($forceMode && $currentType) ? 'checked' : '' ?> />
                    Use this image for insurance claims
                </label>
            </td>
        </tr>
        <tr class="image_sect"> 
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">	
                        <span>
                            Title
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input id="title" name="title" type="text" class="field text addr tbox" value="<?php echo $title;?>" maxlength="255"/>
                        </span>
                        <span id="req_0" class="req">*</span>
                    </li>
                </ul>
            </td>
        </tr>
        <tr id="orig_file" class="image_sect"> 
            <td valign="top" colspan="2" class="frmhead">
                <ul>
                    <li id="foli8" class="complex">	
                        <span>
                            Image
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
if($image_file <> '') {?>
                            <a href="display_file.php?f=<?php echo $image_file?>" target="_blank">
                            <b>Preview</b></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
<?php 
}?>
                            <input type="file" name="image_file" value="" size="26" />
                            <input type="hidden" name="image_file_old" value="<?php echo $image_file;?>" />
                        </span>
                        <span id="req_0" class="req">*</span>
                    </li>
                </ul>
            </td>
        </tr>
        <tr id="extra_files" style="display:none;" class="image_sect">
          	<td colspan="2" class="frmhead">
<?php
$labels = array('', 'Facial Right', 'Facial Front', 'Facial Left', 'Retracted Right', 'Retracted Frontal', 'Retracted Left', 'Occlusal Upper', 'Mallampati', 'Occlusal Lower');
for($i=1;$i<=9;$i++){ ?>

            		<label style="width:100px; float:left; display:block;"><?php echo $labels[$i]; ?></label>
          			<input type="file" name="image_file_<?php echo $i; ?>" value="" size="26" /><br />
<?php 
} ?>
          	</td>
        </tr>
        <tr class="image_sect">
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="imagesub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["imageid"]?>" />
            		<input type="hidden" name="return" value="<?php echo (!empty($_REQUEST['return']) ? $_REQUEST['return'] : ''); ?>" />
                <input type="hidden" name="return_field" value="<?php echo (!empty($_REQUEST['return_field']) ? $_REQUEST['return_field'] : ''); ?>" />
                <input type="submit" value=" <?php echo $but_text?> Image" class="button" />
            </td>
        </tr>
    </table>
</form>

<table bgcolor="#FFFFFF" cellpadding="5" cellspacing="1" width="700" align="center">
    <tr id="sleep_study" style="display:none;">
        <td colspan="2" class="frmhead">
                <?php include 'add_image_sleep_study.php'; ?>
            </td>
    </tr>
</table>
<?php if ($errorMessage) { ?>
<script type="text/javascript">
    alert(<?= json_encode($errorMessage) ?>);
</script>
<?php } ?>
</body>
</html>
<?php

function claimRelatedArchiveType($imageTypeId)
{
    $imageTypeId = intval($imageTypeId);

    if ($imageTypeId === DSS_CLAIM_FILE_TYPE_RX) {
        return 'rx';
    }

    if ($imageTypeId === DSS_CLAIM_FILE_TYPE_LOMN) {
        return 'lomn';
    }

    if ($imageTypeId === DSS_CLAIM_FILE_TYPE_BOTH) {
        return 'rxlomn';
    }

    return '';
}

function updateClaimRelatedArchives($patientId, $imageId, $imageTypeId)
{
    $imageType = claimRelatedArchiveType($imageTypeId);

    if (!$imageType) {
        return false;
    }

    $db = new Db();

    $patientId = intval($patientId);
    $imageId = intval($imageId);

    $claimRelatedFilesSql = "SELECT rx_imgid, lomn_imgid, rxlomn_imgid, rxrec, lomnrec, rxlomnrec
        FROM dental_flow_pg1 WHERE pid='$patientId'";
    $claimRelatedFiles = $db->getRow($claimRelatedFilesSql);

    // The patient does not have its corresponding dental_flow_pg1 row
    if (!$claimRelatedFiles) {
        $claimRelatedFilesSql = "INSERT INTO dental_flow_pg1 (copyreqdate, pid)
            SELECT copyreqdate, patientid
            FROM dental_patients
            WHERE patientid = '$patientId'";
        $db->query($claimRelatedFilesSql);

        $claimRelatedFiles = [
            'rx_imgid' => '',
            'lomn_imgid' => '',
            'rxlomn_imgid' => '',
            'rxrec' => '',
            'lomnrec' => '',
            'rxlomnrec' => '',
        ];
    }

    // If the target claim file is the same as the new image id, nothing to do
    if ($claimRelatedFiles["{$imageType}_imgid"] == $imageId) {
        return false;
    }

    // LOMN/Rx (combined) is not compatible with separated images, they reset/cancel each other
    if ($imageType === 'rxlomn') {
        $claimRelatedFiles['rx_imgid'] = '';
        $claimRelatedFiles['lomn_imgid'] = '';
        $claimRelatedFiles['rxrec'] = '';
        $claimRelatedFiles['lomnrec'] = '';
    } else {
        $claimRelatedFiles['rxlomn_imgid'] = '';
        $claimRelatedFiles['rxlomnrec'] = '';
    }

    // If this image id is being used at some other location, remove that value
    if (in_array($imageId, $claimRelatedFiles)) {
        $key = array_search($imageId, $claimRelatedFiles);

        if (strpos($key, '_imgid')) {
            // Null the image id, and also the date
            $claimRelatedFiles[$key] = '';
            $claimRelatedFiles[str_replace('_imgid', 'rec', $key)] = '';
        }
    }

    $claimRelatedFiles["{$imageType}_imgid"] = $imageId;
    $claimRelatedFiles["{$imageType}rec"] = date('m/d/Y');

    $updateValuesSql = [];

    foreach ($claimRelatedFiles as $key=>$value) {
        /**
         * The keys are safe values, we defined them before, no need to escape them
         * The values can contain legacy data, better to escape them
         *
         * Faulty logic at some other places dictate that empty fields must be NULL
         * otherwise this comparison will fail:
         *
         * $image_id != ""
         */
        $value = $value === '' ? 'NULL' : "'" . $db->escape($value) . "'";
        $updateValuesSql []= "$key = $value";
    }

    $updateValuesSql = join(', ', $updateValuesSql);
    $updateSql = "UPDATE dental_flow_pg1 SET $updateValuesSql WHERE pid='$patientId'";

    $db->query($updateSql);

    return true;
}
