$(document).ready(function(){
    $('select[name=title]').change(function(){
        var index = $(this).val();

        try {
            index = parseInt(index);

            if (customNotes[index]) {
                $('#description').val(customNotes[index]['description']);
                return;
            }
        }
        catch (e) {}

        $('#description').val('');
    });
});