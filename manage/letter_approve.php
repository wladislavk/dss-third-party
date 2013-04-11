<?php
require_once 'admin/includes/config.php';
?>

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>

<?php

$s = "SELECT pdf_path from dental_letters where letterid='".mysql_real_escape_string($_GET['id'])."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$file = './letterpdfs/'.$r['pdf_path'];
$jpg = substr( $file, 0, -3 ) . 'jpg';
//echo $file;
?><br /><?php
//echo $jpg;
exec('gs -dSAFER -dBATCH -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r300 -sOutputFile='.$jpg.' '. $file)
?>

<a href="#" onclick="send_letter('<?=$_GET['id']; ?>')">Looks Good! SEND!</a> | <a href="#" onclick="reload_parent();">Cancel/Revise</a>
<img src="<?= $jpg; ?>" style="border:solid 2px #333;" width="600" />



<script type="text/javascript">
  function reload_parent(){

    parent.window.location = parent.window.location;

  }


  function send_letter(id){

                                  $.ajax({
                                        url: "includes/letter_send.php",
                                        type: "post",
                                        data: {id: id},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
							parent.window.location = parent.window.location;
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });


  }

</script>
