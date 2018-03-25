$('#imagetypeid').change(function(){
    if($(this).val() == '0'){
        $('.image_sect').show();
        $('#extra_files').show();
        $('#orig_file').hide();
        $('#sleep_study').hide();
    }else if($(this).val() == '1'){
        $('.image_sect').hide();
        $('#sleep_study').show();
    }else{
        $('.image_sect').show();
        $('#extra_files').hide();
        $('#orig_file').show();
        $('#sleep_study').hide();
    }

    if($(this).val() == '6'){
        $('.lomn_update').hide();
        $('.rx_update').show();	
        $('.rxlomn_update').hide();
    }else if($(this).val() == '7'){
        $('.lomn_update').show();
        $('.rx_update').hide();
        $('.rxlomn_update').hide();
    }else if($(this).val() == '14'){
        $('.lomn_update').hide();
        $('.rx_update').hide();
        $('.rxlomn_update').show();
    }else{
        $('.lomn_update').hide();
        $('.rx_update').hide();
        $('.rxlomn_update').hide();
    }
});