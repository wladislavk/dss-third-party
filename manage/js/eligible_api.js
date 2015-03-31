$(document).ready(function(){
	setup_autocomplete_local('payer_name', 'payer_hints', 'payer_id', '', 'https://eligibleapi.com/resources/payers/eligibility.json', 'eligibility');
});

$('#api_submit').click( function(){
	$.ajax({
	  url: "https://gds.eligibleapi.com/v1.5/coverage/all.json",
	  type: "get",
	  data: {
	          api_key: '33b2e3a5-8642-1285-d573-07a22f8a15b4',
	          payer_id: $('#payer_id').val(),
	          service_provider_first_name: $('#provider_first_name').val(),
	          service_provider_last_name: $('#provider_last_name').val(),
	          provider_npi: $('#provider_npi').val(),
	          member_id: $('#patient_member_id').val(),
	          member_first_name: $('#patient_first_name').val(),
	          member_last_name: $('#patient_last_name').val(),
	          member_dob: $('#patient_dob').val(),
	          service_type: $('#service_type_code').val() 
	        },
	  complete: function(data){
	          console.log(data);
	          //$('#api_output').html(data.responseText);
	          $('#api_output').html('');
	          var r = $.parseJSON(data.responseText);
							$.ajax({
								url: "includes/eligibility_save.php",
								type: "post",
								data: {response: data.responseText},
								success: function(data2){
									//$('#api_output').append(data2);
									//alert(data2);
								}
							}); 
	          pr = false;//r['primary_insurance'];
	          if(pr){
					        din_ind = r.deductible_in_network.individual
	            din_fam = r.deductible_in_network.family
	            don_ind = r.deductible_out_network.individual
	            don_fam = r.deductible_out_network.family
							$('#api_output').append('<h3>Primary Insurance</h3>');
							$('#api_output').append('Name: '+pr.name);
	            $('#api_output').append('<br />Group Name: '+pr.group_name);
	            $('#api_output').append('<br />Status: '+r.coverage_status);
	            $('#api_output').append('<h3>Deductible In Network</h3>');
	            $('#api_output').append('<h4>Individual</h4>');
	            $('#api_output').append('Base Period: '+din_ind.base_period);
	            $('#api_output').append('<br />Remaining: '+din_ind.remaining);
	            $('#api_output').append('<h4>Family</h4>');
	            $('#api_output').append('Base Period: '+din_fam.base_period);
	            $('#api_output').append('<br />Remaining: '+din_fam.remaining);

	            $('#api_output').append('<h3>Deductible out of Network</h3>');
	            $('#api_output').append('<h4>Individual</h4>');
	            $('#api_output').append('Base Period: '+don_ind.base_period);
	            $('#api_output').append('<br />Remaining: '+don_ind.remaining);
	            $('#api_output').append('<h4>Family</h4>');
	            $('#api_output').append('Base Period: '+don_fam.base_period);
	            $('#api_output').append('<br />Remaining: '+don_fam.remaining);
	          }else{
	          //$('#api_output').append("<h3>Error</h3>");
	          }
	          pr = r['primary_insurance'];
	          s1 = r['1'];
	          s12 = r['12'];
	          s30 = r['30'];

	          if(pr){ 
	            pr = JSON.stringify(pr, null, 4);
	            pr = pr.replace(/\n/g,"<br />");
	            $('#api_output').append(pr);
	          }
	          
	          api_output = "<table width=\"95%\"><tr>";
	          if(s1){
	            s1 = JSON.stringify(s1, null, 4);
	            s1 = s1.replace(/\n/g,"<br />");
	            api_output += "<td>"+s1+"</td>";
	          }

	          if(s12){
	            s12 = JSON.stringify(s12, null, 4);
	            s12 = s12.replace(/\n/g,"<br />");
	            api_output += "<td>"+s12+"</td>";
	          }

	          if(s30){
	            s30 = JSON.stringify(s30, null, 4);
	            s30 = s30.replace(/\n/g,"<br />");
	            api_output += "<td>"+s30+"</td>";
	          }
	          $('#api_output').append(api_output+"</tr></table>");

	          data = JSON.stringify(data.responseText, null, '\t');
	          data = data.replace(/\\n/g,"<br />");
	          data = data.replace(/\\/g,"");
	          $('#api_output').append(data);
	          $('#api_output').show();
	        }
	});
});

function clear_payer_name(f)
{
	if(f.value=="Type Insurance Here"){
		$('#payer_name').val('');
	}
}