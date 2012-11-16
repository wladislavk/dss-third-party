<? 
include "includes/top.htm";

$sql = "select * from dental_letter_templates WHERE default_letter=1 ORDER BY id ASC";
$my = mysql_query($sql);
?>
<script language="javascript" type="text/javascript" src="../3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<span class="admin_head">
	Manage Default Letters 
</span>
<br />
<br />

<?php if(!is_super($_SESSION['admin_access'])){ ?>
You do not have permission to edit default letters.
<?php 
die();
} ?>
<br />
<select id="letterid">
  <option value="">Select Letter</option>
  <?php while($r = mysql_fetch_assoc($my)){ ?>
	<option value="<?= $r['id']; ?>"><?= $r['id']." - ".$r['name']; ?></option>
  <?php } ?>
</select>
<br /><br />
<textarea id="letter"></textarea>
<br /><br />	
<? include "includes/bottom.htm";?>


<script type="text/javascript">

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

$('#letterid').change(function(){
  id = $(this).val();
  $.ajax({
    url: "includes/letters_get_body.php",
    type: "post",
    data: {id: id},
    success: function(data){
      var r = $.parseJSON(data);
      if(r.error){
      }else{
	$('#tinymce').html(r.body);
      }
    },
    failure: function(data){
      //alert('fail');
    }
  }); 
});



</script>
