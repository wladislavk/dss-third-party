<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include("includes/calendarinc.php");
   
    $sql = "SELECT * FROM dental_ledger_note where id=".(!empty($_GET['ed']) ? $_GET['ed'] : '');

    $n = $db->getRow($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
        <script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>

        <form id="ledgernoteform" name="ledgernoteform" action="update_ledger_notes.php" method="POST" >
            <table cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <tr>
                    <td valign="top" class="frmhead">Entry Date</td>
                    <td valign="top" class="frmdata">
                        <input id="entry_date" name="entry_date" type="text" class="tbox calendar" value="<?php echo  $n['entry_date']; ?>"  />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">Producer</td>
                    <td valign="top" class="frmdata">
                        <select id="producer" name="producer">
                            <?php
                                $p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
                                
                                $p_query = $db->getResults($p_sql);
                                if ($p_query) foreach ($p_query as $p) {
                                    echo '<option value="'.$p['userid'].'" '.(($p['userid']==$n['producerid'])?'selected="selected"':'').'>'.$p['name'].'</option>';
                                }
                            ?>
                        </select>
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">Note</td>
                    <td valign="top" class="frmdata">
                        <textarea id="note" name="note" class="tbox" ><?php echo  $n['note']; ?></textarea>
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr>
                    <td valign="top" class="frmhead">Private</td>
                    <td valign="top" class="frmdata">
                        <input id="private" name="private" type="checkbox" class="tbox" <?php echo  ($n['private']==1)?'checked="checked"':''; ?> />
                        <span class="red">*</span>
                    </td>
                </tr>
                <tr>
		            <td class="frmhead">
                        <a href="/manage/manage_ledger.php?delnoteid=<?php echo  (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>&amp;pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" target="_parent" style="font-weight:bold;" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                            Delete 
                        </a>
                    </td>
		            <td class="frmhead">
                        <input type="submit" value="Edit Note" />
                    </td>
	            </tr>
            </table>
            <input type="hidden" name="patientid" value="<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">
            <input type="hidden" name="id" value="<?php echo (!empty($_GET['ed']) ? $_GET['ed'] : ''); ?>">
        </form>

        <script type="text/javascript">
            var cal1 = new calendar2(document.ledgernoteform.elements['entry_date']);
        </script>
    </body>
</html>
