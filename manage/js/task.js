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

