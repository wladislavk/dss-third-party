/***************************/

//SETTING UP OUR POPUP
//0 means disabled; 1 means enabled;
var popupStatus = 0;

//loading popup with jQuery magic!
function loadPopup(fa){
	//centering with css
	centerPopup();
	
	document.getElementById("aj_pop").src = fa; 
	
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1;
	}
}

//loading popup with jQuery magic!
function loadPopupRefer(fa){
        //centering with css
        centerPopupRef();

        document.getElementById("aj_ref").src = fa;

        //loads popup only if it is disabled
        if(popupStatus==0){
                $("#backgroundPopupRef").css({
                        "opacity": "0.7"
                });
                $("#backgroundPopupRef").fadeIn("slow");
                $("#popupRefer").fadeIn("slow");
                popupStatus = 1;
        }
}

//loading popup with jQuery magic!
function loadPopup1(fa){
	//centering with css
	centerPopup1();
	
	document.getElementById("aj_pop").src = fa; 
	
	//loads popup only if it is disabled
	if(popupStatus==0){
		$("#backgroundPopup").css({
			"opacity": "0.7"
		});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupContact").fadeIn("slow");
		popupStatus = 1; 
	}
}

function createCookie(name,value,days) {
              if (days) {
                  var date = new Date();
                  date.setTime(date.getTime()+(days*24*60*60*1000));
                  var expires = "; expires="+date.toGMTString();
              }
              else var expires = "";
              document.cookie = name+"="+value+expires+"; path=/";
          }

		
  function readCookie(name) {
              var nameEQ = name + "=";
              var ca = document.cookie.split(';');
              for(var i=0;i < ca.length;i++) {
                  var c = ca[i];
                  while (c.charAt(0)==' ') c = c.substring(1,c.length);
                  if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
              }
              return null;
  }
          
  function eraseCookie(name) {
              createCookie(name,"",-1);
  }

//disabling popup with jQuery magic!
function disablePopup(){
	//disables popup only if it is enabled
	if(popupStatus==1){
	var answer = confirm("Are you sure you want to exit without saving?")
	if (answer){
				$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		eraseCookie('tempforledgerentry');
		popupStatus = 0;
		parent.window.location.reload();
	}else{
		//parent.window.location.reload();
	}
	}
}
//disabling popup with jQuery magic!
function disablePopupRef(){
        //disables popup only if it is enabled
        if(popupStatus==1){
        var answer = confirm("Are you sure you want to exit without saving?")
        if (answer){
                                $("#backgroundPopupRef").fadeOut("slow");
                $("#popupRefer").fadeOut("slow");
                popupStatus = 0;
        }else{
                //parent.window.location.reload();
        }
        }
}
function disablePopupRefClean(){
        //disables popup only if it is enabled
        if(popupStatus==1){
                                $("#backgroundPopupRef").fadeOut("slow");
                $("#popupRefer").fadeOut("slow");
                popupStatus = 0;
        }
}


//disabling popup with jQuery magic!
function disablePopup1(){
	//disables popup only if it is enabled
	if(popupStatus==1){
		$("#backgroundPopup").fadeOut("slow");
		$("#popupContact").fadeOut("slow");
		//window.history.go(0);
		popupStatus = 0;
	}
}

//centering popup
function centerPopup(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
        var topPos = (windowHeight/2-popupHeight/2 + window.pageYOffset) + "px";
	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": topPos,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}

//centering popup
function centerPopupRef(){
        //request data for centering
        var windowWidth = document.documentElement.clientWidth;
        var windowHeight = document.documentElement.clientHeight;
        var popupHeight = $("#popupRefer").height();
        var popupWidth = $("#popupRefer").width();
        var topPos = (windowHeight/2-popupHeight/2 + window.pageYOffset) + "px";
        //centering
        $("#popupRefer").css({
                "position": "absolute",
                "top": topPos, 
                "left": windowWidth/2-popupWidth/2
        });
        //only need force for IE6

        $("#backgroundPopupRef").css({
                "height": windowHeight
        });

}

//centering popup
function centerPopup1(){
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupContact").height();
	var popupWidth = $("#popupContact").width();
	//centering
	$("#popupContact").css({
		"position": "absolute",
		"top": (windowHeight/2-popupHeight/2)+1100,
		"left": windowWidth/2-popupWidth/2
	});
	//only need force for IE6
	
	$("#backgroundPopup").css({
		"height": windowHeight
	});
	
}

//CONTROLLING EVENTS IN jQuery
$(document).ready(function(){
	
	//LOADING POPUP
	//Click the button event!
	/*$("#button").click(function(){
		//centering with css
		centerPopup();
		//load popup
		loadPopup();
	});*/
				
	//CLOSING POPUP
	//Click the x event!
	$("#popupContactClose").click(function(){
		disablePopup();
	});
	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});
        //Click the x event!
        $("#popupReferClose").click(function(){
                disablePopupRef();
        });
        //Click out event!
        $("#backgroundPopupRef").click(function(){
                disablePopupRef();
        });

	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});

});
