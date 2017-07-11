$(document).ready(function () {
  // Shows the test form or real form depending on the value of radio button named test
  var drawForm = function () {
    if ($("input[name=test]:checked").val() == "true") {
      showTestForm();
    } else {
      showRealForm();
    }
  }

  // Whenever the user click on the radio button for test, show test or real form
  $("input[name=test]").on('click', drawForm);

  // Draw the form according to the test selection
  drawForm();

  // When the user clicks on submit, do an api request to eligible api and parse the answer
  $(".form-coverage").on('submit', function (e) {
    e.preventDefault();

    // Remove any previous result
    $(".eligible-result").remove();

    // Do the api request and parse the results
    fetchCoverage();
  });
});

// Shows the real api call form
showRealForm = function () {
  $(".test-param").hide();
  $(".real-param").show();
}

// Shows the test api call form
showTestForm = function () {
  $(".real-param").hide();
  $(".test-param").show();
}

var fetchCoverage = function () {
  // Put all the form fields into an object
  if ($("input[name=test]:checked").val() == "true") {
    var params = {
      api_key: $("#api_key").val(),
      member_id: $("#test_member_id").val(),
      provider_npi: "1234567890",
      test: "true"
    }
  } else {
    var params = {
      api_key: $("#api_key").val(),
      payer_id: $("#payer_id").val(),
      internal_id: $("#internal_id").val(),
      cascade: $("#cascade").val(),
      date: $("#date").val(),
      from_date: $("#from_date").val(),
      to_date: $("#to_date").val(),
      service_type: $("#service_type").val(),

      provider_npi: $("#provider_npi").val(),
      provider_last_name: $("#provider_last_name").val(),
      provider_first_name: $("#provider_first_name").val(),
      provider_organization_name: $("#provider_organization_name").val(),
      provider_tax_id: $("#provider_tax_id").val(),
      provider_taxonomy_code: $("#provider_taxonomy_code").val(),
      provider_submitter_id: $("#provider_submitter_id").val(),
      provider_street_line_1: $("#provider_street_line_1").val(),
      provider_street_line_2: $("#provider_street_line_2").val(),
      provider_city: $("#provider_city").val(),
      provider_state: $("#provider_state").val(),
      provider_zip: $("#provider_zip").val(),

      member_id: $("#member_id").val(),
      member_first_name: $("#member_first_name").val(),
      member_last_name: $("#member_last_name").val(),
      member_dob: $("#member_dob").val(),
      member_ssn: $("#member_ssn").val(),
      member_employee_id: $("#member_employee_id").val(),
      member_gender: $("#member_gender").val(),
      member_group_id: $("#member_group_id").val(),
      member_state: $("#member_state").val(),
      member_city: $("#member_city").val(),
      member_zip: $("#member_zip").val(),

      dependent_id: $("#dependent_id").val(),
      dependent_first_name: $("#dependent_first_name").val(),
      dependent_last_name: $("#dependent_last_name").val(),
      dependent_dob: $("#dependent_dob").val(),
      dependent_ssn: $("#dependent_ssn").val(),
      dependent_employee_id: $("#dependent_employee_id").val(),
      dependent_gender: $("#dependent_gender").val(),
      dependent_group_id: $("#dependent_group_id").val(),
      dependent_state: $("#dependent_state").val(),
      dependent_city: $("#dependent_city").val(),
      dependent_zip: $("#dependent_zip").val(),

      test: "false"
    }
  };

  for (var key in params) {
    if ((params[key] === undefined) || (params[key] == null) || (params[key] == "")) {
      delete(params[key]);
    }
  }

  // Validation, if any parameter is missing, add the bootstrap class has-error
//  $.each(params, function (key) {
//    if ((params[key] === undefined) || (params[key].match(/^\s*$/))) {
//      $("#" + key).closest('.form-group').addClass('has-error');
//    } else {
//      $("#" + key).closest('.form-group').removeClass('has-error');
//    }
//  });

  // If there is any error, alert, otherwise, do the request
  if ($("input[name=test]:checked").val() != "true" && $(".has-error").length > 0) {
    alert("Please fill all the fields");
  } else {
    $(".has-error").removeClass("has-error");
    coverageRequest(params);
  }
}

// Perform the api request
var coverageRequest = function (params) {
  var coverageRequest = new EligibleRequest(EligibleEndpoints.coverage, successCallback, errorCallback, true);
  coverageRequest.request(params);
}

// If there is an error with the ajax api request, show it on an alert box
var errorCallback = function (xhr, textStatus, errorThrown) {
  // Check for NPI on errorThrown, since it may be an enrollment issue (https://eligible.com/rest#enrollments)
  if (typeof(errorThrown) === "String" && errorThrown.indexOf("NPI")) {
    alert("You should enroll your NPI though our website");
  } else {
    window.alert("Error on request: " + errorThrown);
  }
}

// If the api call was done, process its response, this just either build the success api call, or the error related
var successCallback = function (data) {
  var coverage = new Coverage(data);

  if (coverage.hasError()) {
    buildError(coverage.parseError());
  } else {
    buildCoverageHTML(coverage);
  }
}

// When there is an error on the api response, like the insurance company is down for maiteinance, we get an error
// which could be retrieved by coverage.parseError()
buildError = function (error) {
  $(".coverage-section").remove();
  var coverageSection = $("<section/>").addClass("coverage-section");
  if (error['details'].indexOf("Payer id submitted") !== -1) {
    var h1 = $("<h1/>", {text: error['details']}).appendTo(coverageSection);
  } else {
    var h1 = $("<h1/>", {text: error['reject_reason_description']}).appendTo(coverageSection);
  }
  var body = $('body');
  coverageSection.appendTo(body);
}

// When the api call was ok and we get data from the patient, build the success form
buildCoverageHTML = function(coverage) {
  $(".coverage-section").remove();
  var container = $("<section/>").addClass("coverage-section");
  var additionalInsuranceSection;
  var insuranceSection = $("<section/>").addClass("insurance-section");

  var plugin = new CoveragePlugin(coverage, container);


  plugin.addDemographicsSection();
  plugin.addInsuranceSection1(insuranceSection);
  plugin.addInsuranceSection2(insuranceSection);
  plugin.addInsuranceSection3(insuranceSection);
  plugin.addInsuranceSection4(insuranceSection);
  if (plugin.coverage.hasMedicaidManagedCare()) {
    plugin.addMedicaidManagedCare();
  }
  if (plugin.coverage.hasMedicaidNursingHome()) {
    plugin.addMedicaidNursingHome();
  }
  plugin.addPlanMaximumMinimumDeductibles();
  plugin.addPlanCoinsurance();
  plugin.addPlanCopayment();
  plugin.addPlanDisclaimer();
  plugin.addAdditionalInsurancePolicies();
  plugin.addNonCovered();
  plugin.addGenericServices();
  plugin.addLimitations();

  var body = $('body');
  var subscriberSection = $("<section/>").addClass('subscriber-section');
  container.appendTo(body);
  subscriberSection.prependTo(container);
  insuranceSection.insertAfter(subscriberSection);

  // Adding classes for styling
  $('.patient').appendTo(subscriberSection);
  $('.dependent').appendTo(subscriberSection);
  $('.primary-insurance').appendTo(insuranceSection);

  // If there is any additional insurance policy, add links to it
  var insuranceLinks = plugin.getAdditionalInsuranceLinks();
  if (insuranceLinks.length > 0) {
    var additionalInsuranceSection = $("<section/>").
      addClass('additional-insurance-section').addClass("alert alert-warning fade in").
      append('<p>Other insurance policies were found. Click below to see details</p>');
    $.each(insuranceLinks, function(idx, link) {
      additionalInsuranceSection.append(link);
      additionalInsuranceSection.append($("<br/>"));
    });
    additionalInsuranceSection.appendTo(subscriberSection);
  }

  $('body').append(plugin.coverageSection);
}
