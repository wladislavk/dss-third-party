<?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");

    $q = (!empty($_GET["q"]) ? $_GET["q"] : '');
    $pco = (!empty($_GET["pco"]) ? $_GET["pco"] : '');

    $sql = "SELECT * FROM dental_transaction_code WHERE type = '".$q."' and docid=".$_SESSION['docid']." ORDER BY sortby ASC";

    $result = $db->getResults($sql);

    echo "<select style=\"width: 130px;\" onchange='return getTransCodesAmount(this.value,this.name,".$q.")' id='form[".$pco."][proccode]' name='form[".$pco."][proccode]'><option>Select TX Code</option>";
    if (!empty($result)) foreach ($result as $row) {
        if ($row['transaction_code'] != '' && $row['description'] != '') {
            echo "<option value='".$row['transaction_codeid']."'>".$row['transaction_code']." - ".$row['description']."</option>";
        }
    }

    echo "</select>";
?> 
