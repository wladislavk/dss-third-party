function delete_pending_letter(lid, type, rid, par)
{
	if(confirm('Are you sure you want to delete this letter?')){
        $.ajax({
            url: "includes/letter_delete.php",
            type: "post",
            data: {lid: lid, type: type, rid: rid, par: par},
            success: function(data){
                var r = $.parseJSON(data);
                if(!r.error){
					window.location.reload();
                }
            },
            failure: function(data){
            }
        });
	}
}