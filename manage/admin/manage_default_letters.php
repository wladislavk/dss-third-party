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
<? include "includes/bottom.htm";?>


<script type="text/javascript">

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
	alert(r.body);
      }
    },
    failure: function(data){
      //alert('fail');
    }
  }); 
});



</script>
