<?php include 'includes/top.htm';?>
<br />

<? if(mysqli_num_rows($page_my) == 0)
{?>
	<div align="center" class="red">
		<b>No Records</b>
	</div>
<? }
else
{?>

    <span class="admin_head">
        <?=st($page_myarray['title']);?>
    </span>
    <br />
    <br />
    
    <?=html_entity_decode(st($page_myarray['description']));?>

<? }?>


<? include 'includes/bottom.htm';?>