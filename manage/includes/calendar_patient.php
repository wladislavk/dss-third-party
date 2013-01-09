<?php
require_once '../admin/includes/config.php';


	getDataFromDB($_GET["mask"]);



	//print one level of the tree, based on parent_id
	function getDataFromDB($mask){
		$sql = "SELECT * FROM dental_patients WHERE firstname like '".mysql_real_escape_string($mask)."%' OR lastname like '".mysql_real_escape_string($mask)."%'";
		$sql.= " Order By lastname, firstname";

			print("<complete add='true'>");
		$res = mysql_query ($sql);
		if($res){
			while($row=mysql_fetch_assoc($res)){
				print("<option value=\"".$row["patientid"]."\">");
				print($row["firstname"]." ".$row["lastname"]);
				print("</option>");
			}
		}else{
			echo mysql_errno().": ".mysql_error()." at ".__LINE__." line in ".__FILE__." file<br>";
		}
		print("</complete>");
	}


?>
