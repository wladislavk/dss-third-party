<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include "admin/includes/main_include.php";

	if (!empty($_POST['selsub']) && $_POST['selsub'] == 1) { ?>
		<script type="text/javascript">
			parent.document[<?= json_encode($_GET['fr']) ?>][<?= json_encode($_GET['tx']) ?>].value =
                <?= json_encode($_POST['description']) ?>;
			parent.disablePopupRefClean();
		</script>
        <?php
		trigger_error("Die called", E_USER_ERROR);
	}

$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
$my = $db->getResults($sql);

$customNotes = [];
$currentNote = null;
$notes = '';

if ($my) {
    foreach ($my as $myarray) {
        $customNotes []= [
            'title' => trim(utf8_encode($myarray['title'])),
            'description' => trim(utf8_encode($myarray['description']))
        ];
    }

    if (isset($_GET['title']) && isset($customNotes[$_GET['title']])) {
        $currentNote = $_GET['title'];
        $notes = $customNotes[$currentNote]['description'];
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="keywords" content="<?php echo st((!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : ''));?>" />
		<title><?php echo $sitename;?></title>
		<link href="css/admin.css?v=20160329" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
		<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
		<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="script/validation.js"></script>
        <script type="text/javascript">
            var customNotes = <?= json_encode($customNotes) ?>;
        </script>
        <script type="text/javascript" src="/manage/js/select_custom.js?v=<?= time() ?>"></script>
	</head>

	<body>
		<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
		    <tr bgcolor="#FFFFFF">
			    <td> 
					<br />
					<span class="admin_head">
						Select Custom Text
					</span>
					<br />&nbsp;
                    <form name="selfrm" action="?">
                        <input type="hidden" name="fr" value="<?= htmlspecialchars($_GET['fr']) ?>" />
                        <input type="hidden" name="tx" value="<?= htmlspecialchars($_GET['tx']) ?>" />
                        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
                            <tr class="tr_bg_h">
                                <td valign="top" class="col_head" >
                                    Title:
                                    <select name="title" class="tbox">
                                        <option value="">Select</option>
                                        <?php foreach ($customNotes as $index=>$note) { ?>
                                            <option value="<?= $index ?>" <?= !is_null($currentNote) && $index == $currentNote ? 'selected="selected"' : '' ?> <?= $note['title'] === '' ? 'style="font-style: italic"' : '' ?>>
                                                <?= htmlspecialchars($note['title'] ?: 'no title') ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <span title="Click here if the text template does not load automatically.&#013;Your changes will be lost" style="cursor: pointer;">
                                        <input type="submit" class="button" value="Load">
                                        ?
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>?fr=<?php echo (!empty($_GET['fr']) ? $_GET['fr'] : '');?>&tx=<?php echo (!empty($_GET['tx']) ? $_GET['tx'] : '');?>" method="post" onSubmit="return selabc(this)">
                        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
						    <tr class="tr_bg_h">
								<td valign="top" class="col_data" >
						        	<textarea name="description" id="description" class="tbox" style="width:98%; height:150px;"><?php echo $notes;?></textarea>
								</td>
							</tr>
						    <tr class="tr_bg_h">
								<td valign="top" class="col_head" >
						        	<input type="hidden" name="selsub" value="1" />
						        	<input type="submit" name="selbtn" value="Insert into Form" />
								</td>
							</tr>
						</table>
					</form>
					<br /><br />
				</td>
			</tr>
		</table>
	</body>
</html>
