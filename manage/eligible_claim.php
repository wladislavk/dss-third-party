<?php namespace Ds3\Libraries\Legacy; ?><?php
session_start();
require_once('includes/constants.inc');
require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
?>
<html>

    <head>

        <!-- Jquery -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <!-- Jquery UI-->

        <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

        <script src="https://eligibleapi.com/js/eligible-claim-1500-2014.min.js"></script>

        <link href="https://eligibleapi.com/css/eligible-claim-1500-2014.min.css" rel="stylesheet">

        <script type="text/javascript"> window.eligiblePublicKey="YOUR_ELIGIBLE_PUBLIC_KEY_HERE"</script>

    </head>

    <body>

    <form action="claim_handler.php" method="POST">

        <div id="eligibleapi-claim-1500-form"></div>

    </form>

<script type="text/javascript">
  $(document).ready( function(){

    $('input[name="dependent[first_name]"]').val('test');
 


  });

</script>

    </body>

</html>



