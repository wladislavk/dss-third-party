<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';

$db = new Db();

$docId = (int)$_SESSION['docid'];
$customId = (int)$_GET['ed'];

$isSoapAuthorized = $db->getNumberRows("SELECT doc_id
    FROM dental_api_permissions permission
        LEFT JOIN dental_api_permission_resource_groups api_group ON api_group.id = permission.group_id
    WHERE permission.doc_id = '$docId'
");

$isSoapAuthorized = $isSoapAuthorized && !empty($_GET['soap']);

if (!empty($_POST["customsub"]) && $_POST["customsub"] == 1) {
    $description = $_POST['description'];

    if (!is_string($description)) {
        $description = json_encode($description);
    }

    $customId = (int)$_POST['ed'];
    $data = [
        'title' => $_POST['title'],
        'description' => $description,
        'status' => $_POST['status'],
    ];

    if ($customId) {
        $data = $db->escapeAssignmentList($data);
        $db->query("UPDATE dental_custom
            SET $data
            WHERE customid = '$customId'
        ");
        $msg = "Edited Successfully";
        ?>
        <script type="text/javascript">
            parent.window.location = 'manage_custom.php?msg=<?php echo $msg;?>';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $data['docid'] = $docId;
    $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $data = $db->escapeAssignmentList($data);

    $db->query("INSERT INTO dental_custom
            SET $data, adddate = NOW()
        ");
    $msg = "Added Successfully";
    ?>
    <script type="text/javascript">
        parent.window.location = 'manage_custom.php?msg=<?php echo $msg;?>';
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$customNote = $db->getRow("SELECT *
    FROM dental_custom
    WHERE customid = '$customId'
");

$title = $customNote['title'];
$description = $customNote['description'];
$status = $customNote['status'];

$isSoapAuthorized = $isSoapAuthorized || is_array($description);

try {
    $jsonDescription = json_decode($description, true);

    if (is_array($jsonDescription)) {
        $description = $jsonDescription;
    }

    unset($jsonDescription);
} catch (\Exception $e) {
    /* Fall through */
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>
    </head>
    <body>
	<br /><br />
	<?php if(!empty($msg)) {?>
        <div align="center" class="red">
            <?php echo $msg;?>
        </div>
    <?php }?>
    <form name="customfrm" action="insert_custom.php?add=1" method="post" onSubmit="return customabc(this)">
        <table width="700" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <tr>
                <td colspan="2" class="cat_head">
                   <?= $customId ? 'Edit' : 'Add' ?> Custom <?= $isSoapAuthorized ? 'SOAP' : '' ?> Text
                   <?php if ($title <> "") {?>
                   		&quot;<?= e($title) ?>&quot;
                   <?php }?>
                </td>
            </tr>
            <tr> 
            	<td valign="top" colspan="2" class="frmhead">
                	<ul>
                		<li id="foli8" class="complex">	
                        	<label class="desc" id="title0" for="Field0">
                                Title:
                                <span id="req_0" class="req">*</span>
                           	</label>
                           	<div>
                                <span class="full">
                                	 <input id="title" name="title" type="text" class="field text addr tbox" value="<?= e($title) ?>" tabindex="5" style="width:600px;" maxlength="255"/>
                                </span>
                                <label>&nbsp;</label>
    						</div>
                        </li>
    				</ul>
                </td>
            </tr>
            <?php if ($isSoapAuthorized) { ?>
                <tr>
                    <td valign="top" class="frmhead">
                        Subjective
                    </td>
                    <td valign="top" class="frmdata">
                        <input type="hidden" name="description[is_soap]" value="1" />
                        <textarea id="subjective" name="description[subjective]" class="tbox"
                                  style="width:98%; height:60px;"><?= e($description['subjective']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Objective
                    </td>
                    <td valign="top" class="frmdata">
                        <textarea id="objective" name="description[objective]" class="tbox"
                                  style="width:98%; height:60px;"><?= e($description['objective']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Assessment
                    </td>
                    <td valign="top" class="frmdata">
                        <textarea id="assessment" name="description[assessment]" class="tbox"
                                  style="width:98%; height:60px;"><?= e($description['assessment']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">
                        Plan
                    </td>
                    <td valign="top" class="frmdata">
                        <textarea id="plan" name="description[plan]" class="tbox"
                                  style="width:98%; height:60px;"><?= e($description['plan']) ?></textarea>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td valign="top" colspan="2" class="frmhead">
                        <ul>
                            <li id="foli8" class="complex">
                                 <label class="desc" id="title0" for="Field0">
                                    Description:
                                    <span id="req_0" class="req">*</span>
                                </label>
                                <div>
                                    <span class="full">
                                        <textarea name="description" id="description" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;"><?= e($description) ?></textarea>
                                    </span>
                                    <label>&nbsp;</label>
                                </div>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php } ?>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmhead">
                    Status
                </td>
                <td valign="top" class="frmdata">
                	<select name="status" class="tbox" tabindex="22">
                    	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                    	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                    </select>
                    <br />&nbsp;
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="customsub" value="1" />
                    <input type="hidden" name="ed" value="<?= $customId ?>" />
                    <input type="submit" value=" <?= $customId ? 'Edit' : 'Add' ?> Custom <?= $isSoapAuthorized ? 'SOAP Note' : 'Text' ?>" class="button" />
    		        <?php if ($customId) { ?>
                        <a style="float:right;" href="manage_custom.php?delid=<?= $customId ?>"
                           onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink"
                           title="DELETE" target="_parent">
                            Delete 
                        </a>
    		        <?php } ?>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
