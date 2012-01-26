//step-by-step wizard
lga_wizard = {
	init: function(){
		//wizard form submit
		$('#register_form').submit(function() {
			var post = $(this).serializeObject();
			$.post('helpers/register_submit.php', post, function(data) {
				$('#form_summary').html(data);
			});
			return false;
		});

		//set page width for steps
		pageW = $('#status').outerWidth();
		$('.page').css('width',pageW - 10);
		
		//initialize wizard
		var root = $("#register").fancyscrollable();
		var api = root.fancyscrollable();
		api.onBeforeSeek(function(event, i) {
			if (api.getIndex() < i) {
				var page = root.find(".page").eq(api.getIndex());
				notValid = false;
				//class="validate" needs to be added to elements that needs to be validated
				page.find('.validate').each(function(){
					//assign validator to single element
					validator = $("#register_form").validate({
						highlight: function(element) {
							$(element).closest('div').addClass("error");
						},
						unhighlight: function(element) {
							$(element).closest('div').removeClass("error");
						},
                        rules: {
                            firstname: "required",
			    lastname: "required",
                            email: {
                                required: true,
                                email: true
                            },
                            street: "required",
                            zip: "required"
                        },
                        messages: {
                            firstname: "This field is required",
			    lastname: "This field is required",
			    email: {
				required: "This field is required",			
				email: "The field requires a valid email address"
				},
			    street: "This field is required",
                            zip: "This field is required"
                        }
					}).element($(this));
					if(validator == false){	notValid = true	}
				})
				if(notValid == true){ return false }
			}
			$("#status li").removeClass("active").eq(i).addClass("active filed");
			$("#status li.active").prev("li").addClass("filed");
		});

		// if tab is pressed on the next button seek to next page
		root.find("a.next,button.next").keydown(function(e) {
			if (e.keyCode == 9) {
				// seeks to next tab by executing our validation routine
				api.next();
				e.preventDefault();
			}
		});
	        root.find("a.next2,button.next2").click(function(e) {
                                api.move(2);
                });	
                root.find("a.prev2,button.prev2").click(function(e) {
                                api.move(-2);
                });
		//disable enter key for wizard
			//Bind this keypress function to all of the input tags
			root.find("input").keypress(function (evt) {
			//Deterime where our character code is coming from within the event
				var charCode = evt.charCode || evt.keyCode;
				if (charCode  == 13) { //Enter key's keycode
					return false;
				}
			});
	}

};


function updateNext(v){
  if(v=='No'){
	$('#insNext').hide();
        $('#insNext2').show();
        $('#insPrev').hide();
        $('#insPrev2').show();
  }else{
        $('#insNext').show();
	$('#insNext2').hide();
	$('#insPrev').show();
	$('#insPrev2').hide();
  }
}

