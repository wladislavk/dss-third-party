<?php namespace Ds3\Libraries\Legacy; ?><!DOCTYPE html>
<html>
  <head>
    <title>Eligible Enrollment JS Demo</title>

    <!-- Step 1 - jQuery 1.10.2 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <!-- Step 2 - Underscore.js 1.6.0 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js"></script>

    <!-- Step 3 - Signature.js -->
    <script src="https://eligibleapi.com/js/jquery.signaturepad.js"></script>
    <script src="https://eligibleapi.com/js/json2.min.js"></script>
    <link href="https://eligibleapi.com/css/jquery.signaturepad.min.css" rel="stylesheet">

    <!-- Step 4 - Select.js -->
    <script src="https://eligibleapi.com/js/select2.min.js"></script>
    <link href="https://eligibleapi.com/css/select2.min.css" rel="stylesheet">

    <!-- Step 5 - jQuery UI -->
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link href="https://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet">

    <!-- Step 6 - Enrollment.js -->
    <script src="https://eligibleapi.com/js/enrollment.min.js"></script>
    <link href="https://eligibleapi.com/css/enrollment.min.css" rel="stylesheet">

    <script type="text/javascript">
        // Set your publishable key
        Eligible.setPublishableKey("-a7xWM5Kn7V9sciZtT4zV92dlpp_RWvnpHS-");

        $(document).ready(function () {
            Eligible.EnrollmentView.initialize({
                baseElement: $('#enrollments'),
                generate_checksum: function (timestamp, callback) {
                  $.ajax({
                    type: 'POST',
                    url: 'http://localhost:9292/generate_checksum',
                    data: { timestamp: timestamp },
                    headers: { Accept: "application/json" },
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        callback(data.checksum, data.user_defined_field1, data.user_defined_field2);
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Something wrong with your sever implementation.')
                    }
                });
                }
            });
        });
    </script>

  </head>
  <body>
    <h1>Enrollment JS Demo</h1>
    <div id="enrollments">

    </div>
  </body>
</html>
