$(document).ready(function()
{
    $('#dellink').click(function(){
        if (confirm('Do Your Really want to Delete?.')) {
            setRouteParameters('/manage/transaction_code', '{"delid": "' + delid + '"}', $('#token').val());
        }
        return false;
    });
});
