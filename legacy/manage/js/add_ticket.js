function add_attachment(){
    var blank = $(".attachment").filter(function() {
        return !this.value;
    }).length;
    if(blank > 0){
        alert('Please attach another file with the "Browse" button before adding another.');
        return false;
    }
    if($('.attachment').length<5){	
        $('#attachments').append('<span class="fullwidth"><input type="file" name="attachment[]" id="attachment1" class="attachment field text addr tbox" style="width:auto;" /> <a href="#" onclick="$(this).parent().remove();$(\'#add_attachment_but\').show();return false;">Remove</a></span>');
    }
    if($('.attachment').length==5){
        $('#add_attachment_but').hide();
    }
}

$('#google_link').click(function(){ 
    $('#google_link').attr('href', 'http://google.com/search?q='+$('#firstname').val()+'+'+$('#lastname').val()+'+'+$('#company').val()+'+'+$('#add1').val()+'+'+$('#city').val()+'+'+$('#state').val()+'+'+$('#zip').val());
});
