$(document).ready( function(){
    $('#dellink').click(function(){
        if (confirm('Are you sure you want to delete?')) {
            if (countLogins > 0) {
                if (confirm('This user has previously accessed your software. In order to store a record of their activity this user will be marked as INACTIVE. INACTIVE users cannot access your software.')) {
                    setRouteParameters('/manage/chairs', '{"deleteId": "' + deleteId + '"}', $('#token').val());
                }
            } else {
                setRouteParameters('/manage/chairs', '{"deleteId": "' + deleteId + '"}', $('#token').val());
            }
        }
        return false;
    });
});
