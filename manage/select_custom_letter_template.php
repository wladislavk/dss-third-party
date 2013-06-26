<?php 
session_start();
if(isset($_POST['template'])){
  ?>
  <script type="text/javascript">
    parent.window.location = 'add_custom_letter_template.php?cid=<?= $_POST['template']; ?>';
  </script>
  <?php
}
?>
<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
<?php
require_once('admin/includes/config.php');
include_once('includes/constants.inc');

$sql = "SELECT 
                                                'default' as template_type,
                                                t.id, 
                                                t.name, 
                                                ct.triggerid 
                                        FROM dental_letter_templates  t 
                                        INNER JOIN dental_letter_templates ct ON ct.triggerid = t.id
                                        WHERE ct.companyid='".$_SESSION['companyid']."' AND
                                                t.default_letter=1 
                                UNION
                                        SELECT 
                                                'custom',
                                                c.id,
                                                c.name,
                                                ''
                                        FROM dental_letter_templates_custom c
                                                WHERE c.docid = '".mysql_real_escape_string($_SESSION['docid'])."'

                                ORDER BY template_type DESC, id ASC
                                                ;";
$my = mysql_query($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="css/form.css" type="text/css" />
</head>
<body>
<br /><br />	
    <form name="notesfrm" method="post" >
		<select name="template">
			<?php while($r = mysql_fetch_assoc($my)){ ?>
<?php
if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $r['triggerid']!=1){
                                          print "<option value=\"" . (($r['template_type']=='custom')?'C':'').$r['id'] . "\">" . (($r['template_type']=='custom')?'C':'').$r['id'] . " - " . $r['name'] . "</option>";
                                        }
?>
			<?php } ?>
		</select>
                <input type="submit" name="submit" value=" Select " class="button" />
    </form>
</body>
</html>
