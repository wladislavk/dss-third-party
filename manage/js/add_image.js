$(document).ready(function(){
    $('#imagetypeid').change(function(){
        var $this = $(this),
            $claimFile = $('.claim_file_update'),
            imageType = $this.val();

        $claimFile.find(':checkbox').removeAttr('disabled');

        if (imageType == '0') {
            $('.image_sect').show();
            $('#extra_files').show();
            $('#orig_file').hide();
            $('#sleep_study').hide();
        } else if (imageType == '1') {
            $('.image_sect').hide();
            $('#sleep_study').show();
        } else {
            $('.image_sect').show();
            $('#extra_files').hide();
            $('#orig_file').show();
            $('#sleep_study').hide();
        }

        if (imageType.match(/^(6|7|14)$/)) {
            $claimFile.show();
        } else {
            $claimFile.hide();
        }
    });
});