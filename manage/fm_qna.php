<? 
include "includes/fmFunctions_qna.php";
include "includes/fmTop.php";
?>
<style>
#contentMain form{
width:auto;
}
</style>
<span class="admin_head">
	Healthcare Questionnaire
</span>
<br />
<br />
<div style="margin:0 20px 0 20px;>  
	<?php echo $str;?>
  <?php echo ft_make_scripts_footer();?>
  <?php echo implode("\r\n", ft_invoke_hook('destroy'));?>

</div>
<br /><br />
<? 
include "includes/bottom.htm";
?>