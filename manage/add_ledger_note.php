<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('admin/includes/main_include.php');
include("includes/sescheck.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <?php include("includes/calendarinc.php"); ?>
    <script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
    <script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
</head>
<body>
<form id="ledgernoteform" name="ledgernoteform" action="insert_ledger_notes.php" method="POST" >
    <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td valign="top" class="frmhead">
                Entry Date 
            </td>
            <td valign="top" class="frmdata">
                <input id="entry_date" name="entry_date" type="text" class="tbox calendar" value="<?= date('m/d/Y'); ?>"  />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Producer 
            </td>
            <td valign="top" class="frmdata">
                <select id="producer" name="producer">
<?php
$p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
$p_query = $db->getResults($p_sql);
foreach ($p_query as $p) {
    echo '<option value="'.$p['userid'].'">'.$p['first_name'].' '.$p['last_name'].'</option>';
}?>
                </select>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Note 
            </td>
            <td valign="top" class="frmdata">
                <textarea id="note" name="note" class="tbox" ></textarea>
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
            <td valign="top" class="frmhead">
                Private 
            </td>
            <td valign="top" class="frmdata">
                <input id="private" name="private" type="checkbox" class="tbox" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr>
    		<td class="frmhead"></td>
    		<td class="frmhead"><input type="submit" value="Add Note" /></td>
    	</tr>
    </table>
    <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
    <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
    <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>" />
</form>

<script src="js/add_ledger_note.js" type="text/javascript"></script>

</body>
</html> 
