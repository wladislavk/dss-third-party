function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}

if (getParameterByName('sendins') == 1) {
  var insid = getParameterByName('insid');
  var type = getParameterByName('type');
  var pid = getParameterByName('pid');
  window.location = "insurance_electronic_file.php?insid=" + insid + "&type=" + type + "&pid=" + pid;
};
if (getParameterByName('showins') == 1) {
  var insid = getParameterByName('insid');
  var type = getParameterByName('type');
  var pid = getParameterByName('pid');
  window.location = "insurance_fdf_v2.php?insid=" + insid + "&type=" + type + "&pid=" + pid;
};