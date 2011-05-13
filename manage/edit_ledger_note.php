<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

$sql = "SELECT * FROM dental_ledger_note where id=".$_GET['ed'];
$nq = mysql_query($sql);
$n = mysql_fetch_assoc($nq);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
parent.window.scroll(0, 0);
</script>


</head>
<body>




<link rel="stylesheet" href="css/form.css" type="text/css" />

<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
<form id="ledgernoteform" name="ledgernoteform" action="update_ledger_notes.php" method="POST" >

 <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
       <tr>
                <td valign="top" class="frmhead">
                                Entry Date 
            </td>
                <td valign="top" class="frmdata">
                                <input onclick="cal1.popup();" id="entry_date" name="entry_date" type="text" class="tbox" value="<?= $n['entry_date']; ?>"  />
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
$p_query = mysql_query($p_sql);
while($p = mysql_fetch_array($p_query)){
echo '<option value="'.$p['userid'].'" '.(($p['userid']==$n['producerid'])?'selected="selected"':'').'>'.$p['name'].'</option>';
}

?>

                                </select>
                                <span class="red">*</span>
            </td>
        </tr>
       <tr>
                <td valign="top" class="frmhead">
                                Note 
            </td>
                <td valign="top" class="frmdata">
                                <textarea id="note" name="note" class="tbox" ><?= $n['note']; ?></textarea>
                                <span class="red">*</span>
            </td>
        </tr>
       <tr>
                <td valign="top" class="frmhead">
                                Private 
            </td>
                <td valign="top" class="frmdata">
                                <input id="private" name="private" type="checkbox" class="tbox" <?= ($n['private']==1)?'checked="checked"':''; ?> />
                                <span class="red">*</span>
            </td>
        </tr>
        <tr>
		<td class="frmhead"></td>
		<td class="frmhead"><input type="submit" value="Edit Note" /></td>
	</tr>

</table>

<input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
<input type="hidden" name="id" value="<?php echo $_GET['ed']; ?>">
</form>
<script type="text/javascript">
var cal1 = new calendar2(document.ledgernoteform.elements['entry_date']);
</script>
</body>
</html> 
