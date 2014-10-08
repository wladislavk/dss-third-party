function getCookie(name) {
	var matches = document.cookie.match(new RegExp(
		"(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
}

function show_sect(sect){
	$('.active').removeClass('active');
	$("#link_"+sect).addClass('active');
	$("#sections > div").hide();
	$("#sect_"+sect).show();
	$.cookie('pid', getParameterByName('pid'));
	$.cookie('summ_sect', sect);
}

var sect;
if(getParameterByName('sect')!=''){ 
    sect = getParameterByName('sect'); 
}else if(getCookie('summ_sect') && getCookie('pid') == getParameterByName('pid')){ 
    sect = getCookie('summ_sect');
}else{
    sect = 'summ';
}

show_sect(sect);