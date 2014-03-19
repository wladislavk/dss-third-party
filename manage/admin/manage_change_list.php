<?php include 'includes/top.htm';?>

<?
include_once('includes/password.php');

if($_POST['clsub'] == 1)
{
                $up_sql = "update dental_change_list set content='".mysql_real_escape_string($_POST['content'])."'";
		mysql_query($up_sql);
		
		$msg="Change List Updated Successfully.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
		</script>
		<?
}
?>
<span class="admin_head">
	Change List
<?php
 $a_sql = "SELECT * FROM dental_change_list";
 $a_q = mysql_query($a_sql);
 $a_r = mysql_fetch_assoc($a_q);
?>
</span>
<br /><br />

<br /><br />
<div align="center" class="red">
	<? echo $_GET['msg'];?>
</div>
		
<form name="passfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" >
<textarea name="content" style="width:98%; height:300px;"><?= $a_r['content']; ?></textarea>
			<input type="hidden" name="clsub" value="1" />
			<input type="submit" value=" Update Change List " class="btn btn-primary" />
</form>


<script type="text/javascript">
$(document).ready(function(){
    
    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline, separator, bullist ,numlist, separator,justifyleft, justifycenter,justifyright,  justifyfull, separator,help",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        gecko_spellcheck : true,
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left"
    });
    
    $('ul.list-group')
        .css({ 'overflow-y': 'auto' })
        .height($('textarea').height());
});
</script>
<? include 'includes/bottom.htm';?>
