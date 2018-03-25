$(document).ready(function()
{
    $('#dellink').click(function(){
        if (confirm('Do Your Really want to Delete?.')) {
            setRouteParameters('/manage/custom', '{"deleteId": "' + deleteId + '"}', $('#token').val());
        }
        return false;
    });
});
