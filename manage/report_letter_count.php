<?php namespace Ds3\Libraries\Legacy; ?>  <link href="3rdParty/novus-nvd3/src/nv.d3.css" rel="stylesheet" type="text/css">

  <script src="3rdParty/novus-nvd3/lib/d3.v3.js"></script>

  <script src="3rdParty/novus-nvd3/nv.d3.js"></script>

  <div id="chart">
    <svg style='height:300px; width: 450px;'/>
  </div>

  <script type="text/javascript">
   nv.addGraph(function() {  
     var chart = nv.models.lineChart();
   
     chart.xAxis
         .axisLabel('Date')
  	.showMaxMin(false)	
  	.tickFormat(function(d) {return d3.time.format("%x")(new Date(d*1000));})
   
     d3.select('#chart svg')
         .datum(letterCount())
       .transition().duration(500)
         .call(chart);
   
     nv.utils.windowResize(function() { d3.select('#chart svg').call(chart) });
   
     return chart;
   });
   
   
   
   
   /**************************************
    * Simple test data generator
    */
   
   
   function letterCount() {
     var letters = [];

     <?php
      	$sql1 = "select DATE(generated_date) as letter_date, count(letterid) num_letter FROM dental_letters 
      		       WHERE generated_date BETWEEN '".(!empty($start_date) ? $start_date : '')."' AND '".(!empty($end_date) ? $end_date : '')."'
      		       group by letter_date ORDER BY letter_date";

        $sql = "select a.Date as letter_date,
                COALESCE((SELECT count(letterid) 
                FROM dental_letters t1
                WHERE docid='".$_SESSION['docid']."' AND DATE(t1.generated_date) = a.Date), 0) as num_letter 
                from (
                  select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
                  from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                  cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                  cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
                ) a
                where a.Date between '".(!empty($start_date) ? $start_date : '')."' AND '".(!empty($end_date)  ? $end_date : '')."' 
                ORDER BY a.Date";

        $q = $db->getResults($sql);
      	foreach ($q as $r) {
  	 ?>
      letters.push({x: <?= date('U',strtotime($r['letter_date'])); ?>, y: <?= $r['num_letter']; ?>});

     <?php } ?> 
     return [
       {
         values: letters,
         key: 'Number of Letters',
         color: '#ff7f0e'
       }
     ];
   }
  </script>




