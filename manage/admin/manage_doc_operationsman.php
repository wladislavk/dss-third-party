<?
include "includes/fmFunctions_oper.php"; 
include "includes/topFM.php";

?>

<span class="admin_head">
	Manage Operations Manual
</span>
<br />
<br />


	<?php echo $str;?>
  <?php echo ft_make_scripts_footer();?>
  <?php echo implode("\r\n", ft_invoke_hook('destroy'));?>


<br /><br />	
<? include "includes/bottom.htm";?>