$('#google_link').click(function(){ 
    $('#google_link').attr('href', 'http://google.com/search?q='+$('#firstname').val()+'+'+$('#lastname').val()+'+'+$('#company').val()+'+'+$('#add1').val()+'+'+$('#city').val()+'+'+$('#state').val()+'+'+$('#zip').val());
});

$(document).ready(function()
{
    $('#dellink').click(function(){
        if (confirm('Do Your Really want to Delete?.')) {
            setRouteParameters('/manage/sleeplab', '{"delid": "' + delid + '"}', $('#token').val());
        }
        return false;
    });
});
