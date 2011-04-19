<?
include "includes/fmFunctions_mark.php"; 
include "includes/topFM.php";

?>

<span class="admin_head">
	Manage Marketing Materials
</span>
<br />
<br />


	<?php echo $str;?>
  <?php echo ft_make_scripts_footer();?>
  <?php echo implode("\r\n", ft_invoke_hook('destroy'));?>


<br /><br />	
<? include "includes/bottom.htm";?>