<?php
namespace Ds3\Libraries\Legacy;

include 'includes/top.htm';
?>
<br />
<?php if(mysqli_num_rows($page_my) == 0) { ?>
    <div align="center" class="red">
        <b>No Records</b>
    </div>
<?php } else { ?>
    <span class="admin_head">
        <?=st($page_myarray['title']);?>
    </span>
    <br />
    <br />
    <?=html_entity_decode(st($page_myarray['description']));?>
<?php } ?>
<?php include 'includes/bottom.htm';?>
