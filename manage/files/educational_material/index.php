<? 
include "../../includes/fmFunctions_edu.php";
include "../../includes/fmTop.php";
?>
  
	<?php echo $str;?>
  <?php echo ft_make_scripts_footer();?>
  <?php echo implode("\r\n", ft_invoke_hook('destroy'));?>

<? 
include "../../includes/bottom.htm";
?>