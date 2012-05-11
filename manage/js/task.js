$(document).ready(function(){
$('.task_status').click(function(){
  t = $(this).val();
                                  $.ajax({
                                        url: "includes/update_task.php",
                                        type: "post",
                                        data: {id: t},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        x = $('#task_'+t).clone();
                                                        x.find('td.status_col').remove();
							$('.task_'+t).remove();
                                                        x.appendTo('#completed_tasks');
							$('#task_count').html($('#task_count').html()-1);
							clean_task_menu();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
});

  $('.task_item').mouseenter(function(){
        var v = $(this).find('.task_status').val();
        $('#task_extra_'+v).show();

  });
  $('.task_item').mouseleave(function(){
        var v = $(this).find('.task_extra').hide();
  });


function delete_task(id){

  if(confirm('Are you sure you want to delete this task?')){

                                  $.ajax({
                                        url: "includes/delete_task.php",
                                        type: "post",
                                        data: {id: id},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        $('.task_'+id).remove();
							$('#task_count').html($('#task_count').html()-1);
							clean_task_menu();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  }
}


function clean_task_menu(){

if($('#task_od_list li').size()==0){
  $('#task_od_header').hide();
}

if($('#task_tod_list li').size()==0){
  $('#task_tod_header').hide();
}

if($('#task_tom_list li').size()==0){
  $('#task_tom_header').hide();
}



}

});
