<? 
include "includes/top.htm";
include_once "includes/constants.inc";


$t_sql = "SELECT * FROM dental_support_tickets
		WHERE docid='".mysql_real_escape_string($_SESSION['docid'])."'
		ORDER BY status ASC, adddate DESC";
$t_q = mysql_query($t_sql);

?>

        <button style="margin-right:10px; float:right;" onclick="loadPopup('add_ticket.php')" class="addButton">
                Add New Ticket
        </button>


<table width="98%" cellpadding="5" cellspacing="1" align="center">
  <tr class="tr_bg_h">
    <td class="col_head">Title</td>
    <td class="col_head">Body</td>
    <td class="col_head">Status</td>
    <td class="col_head">Action</td>
  </tr>
<?php

while($r = mysql_fetch_assoc($t_q)){
?>
  <tr> 
    <td><?= $r['title']; ?></td>
    <td><?= substr($r['body'], 0, 50); ?></td>
    <td><?= $r['status']; ?></td>
    <td><a href="view_support_ticket.php?ed=<?= $r['id']; ?>">View</a></td>
  </tr>

<?php
}
?>
</table>
<?php
include_once "includes/bottom.htm";
?>

