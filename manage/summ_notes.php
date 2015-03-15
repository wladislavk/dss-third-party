<?php namespace Ds3\Libraries\Legacy; ?><button onclick="Javascript: loadPopup('add_notes.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>');" class="addButton" style="float: right;">
    + Add New Progress Note
</button>

<div class="clear"></div>

<?php
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name from dental_notes n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        where n.docid='".$_SESSION['docid']."' and n.patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where docid='".$_SESSION['docid']."' and status IN (1,2) and patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";
$my = $db->getResults($sql);

include 'partials/patient_notes.php'; ?>
        <a href="print_notes.php?pid=<?=(!empty($_GET['pid']) ? $_GET['pid'] : '');?>" target="_blank" class="addButton" style="float: left;">
                Print All Progress Notes
        </a>
        <button onClick="sign_notes(); return false;" class="addButton" style="float: right;">
                Sign Selected Notes
        </button>


<script type="text/javascript">

function sign_notes(){
  if(!confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?')){
    return false;
  }
  sign_arr = new Array();
  i=0;
  $('.sign_chbx:checked').each(function(){
    sign_arr[i++] = $(this).val();
  });
                                  $.ajax({
                                        url: "includes/sign_notes.php",
                                        type: "post",
                                        data: {ids: sign_arr.join(',')},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
						    $('.sign_chbx:checked').each(function(){
    							id = $(this).val();
							$('#note_'+id).css('backgroundColor', '');
							$('#note_edit_'+id).remove();
 						    });
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
}

function add_note(pid){
  $.ajax({
  url:'create_draft_note.php?pid='+pid,
  complete: function (response) {
    note_id = response['responseText'].replace(/\s*\<.*?\>\s*/g, ''); //strips all things in <>
    console.log(note_id);
    loadPopup('add_notes.php?pid='+pid+'&ed='+note_id);
  },
  error: function(){
    alert("There was an error creating the note");
  }
  });
}
</script>
<a href="print_notes.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>" target="_blank" class="addButton" style="float: left;">
    Print All Progress Notes
</a>
<button onClick="sign_notes(); return false;" class="addButton" style="float: right;">
    Sign Selected Notes
</button>

<script src="js/summ_notes.js" type="text/javascript"></script>
