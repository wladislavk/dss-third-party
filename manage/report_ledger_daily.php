<?php namespace Ds3\Legacy; ?><div id="ledger_daily">
  <svg style='height:300px; width: 450px;'/>
</div>

<script type="text/javascript">
  nv.addGraph(function() {
    var chart = nv.models.lineChart()
                  .x(function(d) { return d[0] })
                  .y(function(d) { return d[1] }) //adjusting, 100% is 1.00, not 100 as it is in the data
                  .color(d3.scale.category10().range());

    chart.xAxis
        .tickFormat(function(d) {
          return d3.time.format('%x')(new Date(d))
        });

    chart.yAxis
        .tickFormat(d3.format(',f'));

    d3.select('#ledger_daily svg')
        .datum(ledgerDaily())
      .transition().duration(500)
        .call(chart);

    nv.utils.windowResize(chart.update);

    return chart;
}); 
 
 
 
 /**************************************
  * Simple test data generator
  */
 
 
 function ledgerDaily() {
   var charges = [];
   var credits = [];
   <?php
      $sql = "select a.Date as ledger_date,
              COALESCE((SELECT sum(l.amount) 
              FROM dental_ledger l
              WHERE l.docid='".$_SESSION['docid']."' AND DATE(l.service_date) = a.Date), 0) as charge,
              COALESCE((SELECT sum(dlp.amount) 
              from dental_ledger dl 
              JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
              WHERE dl.docid='".$_SESSION['docid']."' AND DATE(dlp.payment_date) = a.Date), 0) as credit 
              from (
                select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
                from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
              ) a
              where a.Date between '".(!empty($start_date) ? $start_date : '')."' AND '".(!empty($end_date) ? $end_date : '')."' 
              ORDER BY a.Date";

      $q = $db->getResults($sql);
	    $i = 0;
      $total_charge = 0;
	    $total_credits = 0;

      foreach ($q as $r) {
  ?>
        charges.push([ <?php echo  date('U',strtotime($r['ledger_date']))*1000; ?> , <?php echo  $r['charge']; ?>]);
        credits.push([ <?php echo  date('U',strtotime($r['ledger_date']))*1000; ?> , <?php echo  $r['credit']; ?>]);
  <?php
      }
  ?>

  return [
     {
	     "key": "Daily Charges",
       "values": charges
     },
     {
       "key": "Daily Credits",
       "values": credits
     }
   ];
 }

</script>



