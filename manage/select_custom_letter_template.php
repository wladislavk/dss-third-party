<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('admin/includes/main_include.php');
    include_once('includes/constants.inc');

    if(isset($_POST['template'])) {
?>
        <script type="text/javascript">
            parent.window.location = 'add_custom_letter_template.php?cid=<?php echo  $_POST['template']; ?>';
        </script>
<?php
    }

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
            WHERE c.docid = '".mysqli_real_escape_string($con,$_SESSION['docid'])."'
            ORDER BY template_type DESC, id ASC;";
    
    $my = $db->getResults($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/form.css" type="text/css" />
        <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
    </head>

    <body>
        <br /><br />
        <div style="margin-left:20px;">	
            <p style="color:#fff;">Select an existing template below as the BASE for your new letter, preferably one that most closely resembles the type of letter you wish to create.</p>
            <form name="notesfrm" method="post" >
		        <select name="template">
			        <?php if ($my) foreach ($my as $r) { ?>
                        <?php
                            if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $r['triggerid']!=1) {
                                print "<option value=\"" . (($r['template_type']=='custom')?'C':'').$r['id'] . "\">" . (($r['template_type']=='custom')?'C':'').$r['id'] . " - " . $r['name'] . "</option>";
                            }
                        ?>
			        <?php } ?>
		        </select>
                <input type="submit" name="submit" value=" Select " class="button" />
            </form>
        </div>
    </body>
</html>
