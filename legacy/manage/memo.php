<?php
namespace Ds3\Libraries\Legacy;

include 'admin/includes/main_include.php';
?>
<html>
<body>
<script type="text/javascript" src="/manage/calendar1.js?v=20160328"></script>
<script type="text/javascript" src="/manage/calendar2.js?v=20160328"></script>
<?php
$db = new Db();

$memouserid = $_SESSION['userid'];

if(isset($_POST['submit'])) {
    $memobox = $_POST['memobox'];
    $show_until = $_POST['show_until'];
    $memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";

    $memo_check_qry = $db->getResults($memo_check_sql);
    if ($memo_check_qry) {
        foreach ($memo_check_qry as $memo_array) {
            $total_rows = count($memo_check_qry);

            if($memo_array != NULL || $memo_array != '') {
                if($total_rows >= 1) {
                    $memo_update_query = "UPDATE memo SET memo='{$memobox}',show_until='{$show_until}' WHERE user_id={$memouserid} LIMIT 1";

                    $db->query($memo_update_query);
                } else {
                    $memo_update_query = "INSERT INTO memo (user_id,memo,show_until) VALUES({$memouserid},'{$memobox}','{$show_until}') LIMIT 1";

                    $db->query($memo_update_query);
                }
            }
        }
    }
}

$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";

$memo_check_qry = $db->getResults($memo_check_sql);
if ($memo_check_qry) {
    foreach ($memo_check_qry as $memo_array) {
        if ($memo_array != null || $memo_array != '') {
            $memo = $memo_array['memo'];
            $date = $memo_array['show_until'];
        }
    }
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="width:600px; margin:40px" name="memofrm">
    <textarea name="memobox" cols=60 rows=6><?php echo $memo ?></textarea><br />
    <input type="text" onclick="cal72.popup();" maxlength="255" style="width: 150px;" class="field text addr tbox" name="show_until" id="show_until" value="<?php echo $date; ?>">
    <a href="javascript:cal72.popup();">
        <img width="16" height="16" border="0" alt="Click Here to Pick up the date" src="img/cal.gif">
    </a>
    <label for="add1">Show Until</label>
    <br />
    <input type="submit" name="submit" value="Update Memo" />
</form>

<script language="JavaScript">
    var cal72 = new calendar2(document.forms['memofrm'].elements['show_until']);
</script>
</body>
</html>
