
        <button onclick="Javascript: loadPopup('add_notes.php?pid=<?=$_GET['pid'];?>');" class="addButton" style="float: right;">
                + Add New Progress Note
        </button>
<div class="clear"></div>

<?php
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name from dental_notes n
        LEFT JOIN dental_users u on u.userid=n.signed_id
where n.docid='".$_SESSION['docid']."' and n.patientid='".s_for($_GET['pid'])."' ";
$sql .= " order by n.adddate DESC";
$sql = "select n.*, CONCAT(u.first_name,' ',u.last_name) signed_name, p.adddate as parent_adddate from
        (
        select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate desc
        ) as n
        LEFT JOIN dental_users u on u.userid=n.signed_id
        LEFT JOIN dental_notes p ON p.notesid = n.parentid
        group by n.parentid
        order by n.procedure_date DESC, n.adddate desc
        ";
$my=mysql_query($sql) or die(mysql_error());

include 'partials/patient_notes.php'; ?>
        <button onClick="Javascript: window.open('print_notes.php?pid=<?=$_GET['pid'];?>','Print_Notes','width=800,height=500',scrollbars=1);" class="addButton" style="float: left;">
                Print All Progress Notes
        </button>
        <button onClick="sign_notes(); return false;" class="addButton" style="float: right;">
                Sign Selected Notes
        </button>


<script type="text/javascript">

function sign_notes(){
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

</script>


