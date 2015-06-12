<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>

<?
include_once('includes/password.php');

if(!empty($_POST['clsub']) && $_POST['clsub'] == 1)
{
        $up_sql = "update dental_change_list set content='".mysqli_real_escape_string($con,$_POST['content'])."'";
		mysqli_query($con,$up_sql);
		
		$msg="Change List Updated Successfully.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
		</script>
		<?
}
?>
<span class="admin_head">
	Change List
<?php
 $a_sql = "SELECT * FROM dental_change_list";
 $a_q = mysqli_query($con,$a_sql);
 $a_r = mysqli_fetch_assoc( $a_q);
?>
</span>
<br /><br />

<br /><br />
<div align="center" class="red">
	<?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?>
</div>
		
<form name="passfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
<textarea name="content" style="width:98%; height:300px;"><?php echo  $a_r['content']; ?></textarea>
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
<?php include 'includes/bottom.htm';?>
