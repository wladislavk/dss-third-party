<?
include "includes/fmFunctions_edu.php"; 
include "includes/topFM.php";

?>

<span class="admin_head">
	Manage Educational Materials
</span>
<br />
<br />


	<?php echo $str;?>
  <?php echo ft_make_scripts_footer();?>
  <?php echo implode("\r\n", ft_invoke_hook('destroy'));?>


<br /><br />	
<? include "includes/bottom.htm";?>