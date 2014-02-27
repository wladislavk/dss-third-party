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
<script language="javascript" type="text/javascript" src="/manage/3rdParty/tinymce4/tinymce.min.js"></script>
<script type="text/javascript" src="/manage/js/edit_letter.js"></script>
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
			<input type="submit" value=" Update Change List " class="button" />
</form>


<script type="text/javascript">
tinyMCE.init({
                        mode : "textareas",
                        theme : "modern",
                        menubar: false,
                        toolbar1: "undo redo | italic | bullist numlist outdent indent",
                        gecko_spellcheck : true,
                        plugins: "paste, save",
                        entities: "194,Acirc,34,quot,162,cent,8364,euro,163,pound,165,yen,169,copy,174,reg,8482,trade",
                        setup : function(ed) {
                                ed.on('keyDown', function(e) {
                                        if(e.shiftKey && e.keyCode==188){
                                                e.preventDefault();
                                                ed.execCommand('mceInsertContent', false, "≤");
                                        }
                                        if(e.shiftKey && e.keyCode==190){
                                                e.preventDefault();
                                                ed.execCommand('mceInsertContent', false, "≥");
                                        }
                                });
                        },
        paste_preprocess : function(pl, o) {
            o.content = o.content.replace(/&lt;/g, "≤");
            o.content = o.content.replace(/&gt;/g, "≥");
        }
                });

</script>
<? include 'includes/bottom.htm';?>
