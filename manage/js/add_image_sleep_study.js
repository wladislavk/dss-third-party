function validate_image(){
    if($('#ss_file').val() == ''){
        alert('Image is required.');
        return false;
    }
    return true;
}

function updatePlace(f){
    if(f.sleeptesttype.value == "HST"){
        f.place.style.display = "none";
        f.home.style.display = "block";
    }else{
        f.place.style.display = "block";
        f.home.style.display = "none";
    }
}

function addstudylab(v){
    if(v == 'add'){
        parent.loadPopupRefer('add_sleeplab.php?r=flowsheet');
    }
}

$(document).ready(function(){
	setup_autocomplete('diagnosising_doc', 'diagnosising_doc_hints', 'diagnosising_npi', '', 'list_contacts_npi.php', 'contact', getParameterByName('pid'));
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}