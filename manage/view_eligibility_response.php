<?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once('admin/includes/password.php');
    //include('includes/general_functions.php');
?>
    <link href="eligible_check/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="eligible_check/css/cupertino/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" media="screen">
    <link href="eligible_check/css/sample_1.css" rel="stylesheet" media="screen">

    <script src="eligible_check/js/lib/jquery-1.10.2.min.js"></script>
    <script src="eligible_check/js/lib/jquery-ui-1.10.3.custom.min.js"></script>

    <script src="eligible_check/js/eligible.js"></script>
    <script src="eligible_check/js/sample_1.js"></script>
    <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
    <script type="text/javascript" src="/manage/includes/modal.js"></script>
    <script type="text/javascript" src="/manage/3rdParty/jscolor/jscolor.js"></script>
    <link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
    <link rel="stylesheet" href="css/modal.css" />

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css" rel="stylesheet" type="text/css" />
        <script language="javascript" type="text/javascript" src="script/validation.js"></script>
    </head>

    <body>
        <div id="coverage_container"></div>
        <?php
            $thesql = "SELECT e.*, CONCAT(p.firstname,' ',p.lastname) as pat_name 
                      from dental_eligibility e 
                      JOIN dental_patients p on p.patientid=e.patientid
                      where e.id='".(!empty($_REQUEST["id"]) ? $_REQUEST["id"] : '')."'";

            $themyarray = $db->getRow($thesql);
        ?>
        <h2 style="color:#fff;">Eligibility for <?php echo $themyarray['pat_name']; ?> - <?php echo date('m/d/Y h:ia', strtotime($themyarray['adddate'])); ?></h2>
        <a href="eligible_check.php?pid=<?php echo $themyarray['patientid'];?>" style="color:#fff;">Return to chart</a>

<script>
    var response = <?php echo $themyarray['response']; ?>;
</script>

<script type="text/javascript" src="/manage/js/view_eligibility_response.js"></script>
        
</body>
</html>