<? 
include "includes/top.htm";
include_once "includes/constants.inc";

    //OLD DSS ELIGIBLE CHECK
    //require 'eligible_api.php';

    ?>

<br />
<span class="admin_head">Eligibility Check for <?= $thename; ?></span>

<center><iframe width="98%" onLoad="autoResize('eligible');" id="eligible" class="eligible" src="eligible_check/eligible_check.php?docid=<?=$_SESSION['docid'];?>&pid=<?=$_GET['pid']; ?>">
    </iframe></center>




<script language="JavaScript">
<!--
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->

</script>

<?php

include 'includes/bottom.htm';
?>


