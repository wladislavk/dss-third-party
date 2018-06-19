<?php
namespace Ds3\Libraries\Legacy;
?>
<link href="3rdParty/novus-nvd3/src/nv.d3.css" rel="stylesheet" type="text/css">

<script src="3rdParty/novus-nvd3/lib/d3.v3.js"></script>
<script src="3rdParty/novus-nvd3/nv.d3.js"></script>

<div id="treatment">
  <svg style='height:300px; width: 450px;'/>
</div>

<script type="text/javascript">
$(document).ready(function(){
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
});
 
 
 
 
 /**************************************
  * Simple test data generator
  */
 
 
 function treatmentCount() {
   var consult = [];
   var impressions = [];
   <?php

    $sql = "select a.Date as treatment_date,
            COALESCE((SELECT count(i.id) 
            FROM dental_flow_pg2_info i
            JOIN dental_patients p ON i.patientid=p.patientid
            WHERE p.docid='".$_SESSION['docid']."' AND i.segmentid=2 AND DATE(i.date_completed) = a.Date), 0) as num_consult,
            COALESCE((SELECT count(i.id) 
            FROM dental_flow_pg2_info i
            JOIN dental_patients p ON i.patientid=p.patientid
            WHERE p.docid='".$_SESSION['docid']."' AND i.segmentid=4 AND DATE(i.date_completed) = a.Date), 0) as num_impressions 
            from (
              select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
              from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
              cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
              cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
            ) a
            where a.Date between '".(!empty($start_date) ? $start_date : '')."' AND '".(!empty($end_date) ? $end_date : '')."' 
            ORDER BY a.Date";

    $q = $db->getResults($sql);
    foreach ($q as $r) { ?>
     consult.push({x: <?php echo  date('U',strtotime($r['treatment_date'])); ?>, y: <?php echo  $r['num_consult']; ?>});
     impressions.push({x: <?php echo  date('U',strtotime($r['treatment_date'])); ?>, y: <?php echo  $r['num_impressions']; ?>});
     <?php
    }
 ?> 
   return [
     {
       values: consult,
       key: 'Number of Consults',
       color: '#ff7f0e'
     },
     {
       values: impressions,
       key: 'Number of Impressions',
       color: '#ff0e7f'
     }
   ];
 }
</script>
