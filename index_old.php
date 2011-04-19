<? include"includes/top.htm";

$home_sql = "select * from homepage";
$home_my = mysql_query($home_sql);
$home_myarray = mysql_fetch_array($home_my);
?>   

<?=html_entity_decode(st($home_myarray['description']));?>
	
<? include"includes/bottom.htm"?>