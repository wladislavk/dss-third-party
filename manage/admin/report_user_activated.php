    <link href="../3rdParty/novus-nvd3/src/nv.d3.css" rel="stylesheet" type="text/css">

    <script src="../3rdParty/novus-nvd3/lib/d3.v3.js"></script>

    <script src="../3rdParty/novus-nvd3/nv.d3.js"></script>
<div id="treatment">
<svg style='height:300px; width: 450px;'/>
</div>
<script type="text/javascript">
 nv.addGraph(function() {  
   var chart = nv.models.lineChart();
 
   chart.xAxis
       .axisLabel('Date')
	.showMaxMin(false)	
	.tickFormat(function(d) {return d3.time.format("%x")(new Date(d*1000));})
 
   d3.select('#treatment svg')
       .datum(treatmentCount())
     .transition().duration(500)
       .call(chart);
 
   nv.utils.windowResize(function() { d3.select('#treatment svg').call(chart) });
 
   return chart;
 });
 
 
 
 
 /**************************************
  * Simple test data generator
  */
 
 
 function treatmentCount() {
   var activate = [];
   var suspend = []
   <?php
  $start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
  $end_date = date('Y-m-d');
	$sql1 = "select DATE(generated_date) as letter_date, count(letterid) num_letter FROM dental_letters 
		WHERE generated_date BETWEEN '".$start_date."' AND '".$end_date."'
		group by letter_date ORDER BY letter_date";

$sql = "select a.Date as activation_date,
       COALESCE((SELECT count(u.userid) 
        FROM dental_users u
        WHERE u.docid='0' AND status='1' AND (username!='' && username IS NOT NULL) AND DATE(u.adddate) = a.Date), 0) as num_activated,
       COALESCE((SELECT count(u.userid) 
        FROM dental_users u
        WHERE status=3 AND (username!='' && username IS NOT NULL) and docid=0 AND DATE(u.suspended_date) = a.Date), 0) as num_suspended
from (
    select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
    from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
    cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
) a
where a.Date between '".$start_date."' AND '".$end_date."' 
ORDER BY a.Date";
        $q = mysqli_query($con,$sql);
        while($r = mysqli_fetch_assoc($q)){
          ?>activate.push({x: <?= date('U',strtotime($r['activation_date'])); ?>, y: <?= $r['num_activated']; ?>});<?php 
	  ?>suspend.push({x: <?= date('U',strtotime($r['activation_date'])); ?>, y: <?= $r['num_suspended']; ?>});<?php
        }
/*$sql = "SELECT count(*) num_activated, activation_date
                FROM (SELECT 
                        userid, username,
                        case 
                          WHEN registration_date IS NOT NULL AND registration_date != ''
                            THEN registration_date
                          ELSE adddate
                        end as activation_date
                        FROM dental_users
                        WHERE status=1 AND (username!='' && username IS NOT NULL) and docid=0
                        ) u
	WHERE activation_date >= DATE_SUB(now(), INTERVAL 830 DAY)
        group by activation_date";

	$q = mysqli_query($con,$sql);
	while($r = mysqli_fetch_assoc($q)){
	  ?>activate.push({x: <?= date('U',strtotime($r['activation_date'])); ?>, y: <?= $r['num_activated']; ?>});<?php 
	}
$sql = "SELECT count(*) num_suspended, suspended_date
                        FROM dental_users
                        WHERE status=3 AND (username!='' && username IS NOT NULL) and docid=0
        AND suspended_date >= DATE_SUB(now(), INTERVAL 830 DAY)
        group by suspended_date";

        $q = mysqli_query($con,$sql);
        while($r = mysqli_fetch_assoc($q)){
          ?>suspend.push({x: <?= date('U',strtotime($r['suspended_date'])); ?>, y: <?= $r['num_suspended']; ?>});<?php
        }
*/
 ?> 
   return [
     {
       values: activate,
       key: 'Number of Users Activated',
       color: '#ff7f0e'
     },
     {
       values: suspend,
       key: 'Number of Users Suspended',
       color: '#0033ff'
     }

   ];
 }


</script>




