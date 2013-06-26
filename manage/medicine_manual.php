<?php
include_once 'includes/constants.inc';
include 'includes/top.htm';
?>

<script type="text/JavaScript">
function killCopy(e){
return false
}
function reEnable(){
return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
document.onmousedown=killCopy
document.onclick=reEnable
}
</script>
<div style="padding:0 20px; width:920px;height: 600px; overflow-y: scroll;">
<?php
include 'includes/medicine_manual_content.php';
?>
</div>
<? include 'includes/bottom.htm';?>

