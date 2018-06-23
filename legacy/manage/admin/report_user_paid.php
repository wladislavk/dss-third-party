<?php
namespace Ds3\Libraries\Legacy;
?>
<link href="../3rdParty/novus-nvd3/src/nv.d3.css" rel="stylesheet" type="text/css">
<script src="../3rdParty/novus-nvd3/lib/d3.v3.js"></script>
<script src="../3rdParty/novus-nvd3/nv.d3.js"></script>

<div id="user_paid">
    <svg style='height:300px; width: 450px;'/>
</div>
<script type="text/javascript">
    nv.addGraph(function() {
        var chart = nv.models.lineChart();

        chart.xAxis
            .axisLabel('Date')
            .showMaxMin(false)
            .tickFormat(function(d) {
                return d3.time.format("%x")(new Date(d*1000));
            });

        d3.select('#user_paid svg')
            .datum(treatmentCount())
            .transition()
            .duration(500)
            .call(chart);

        nv.utils.windowResize(function() { d3.select('#user_paid svg').call(chart) });

        return chart;
    });

 /**************************************
  * Simple test data generator
  */

 function treatmentCount() {
     var paid = [];
     <?php
     $start_date = date('Y-m-d', mktime(0,0,0,date('m'), date('d')-30, date('Y')));
     $end_date = date('Y-m-d');
    $sql = "select a.Date as paid_date,
       COALESCE( 
	(
SELECT count(du.userid) num_paid from dental_users du
                LEFT JOIN (SELECT COALESCE(sum(dl.percase_amount),0) as ledger_amount, pi.docid, pi.adddate FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_ledger dl on pi.id=dl.percase_invoice
                                GROUP BY pi.docid) i ON i.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(pi.monthly_fee_amount),0) as monthly_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                GROUP BY pi.docid) i1 ON i1.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(dle.percase_amount),0) as extra_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_percase_invoice_extra dle ON dle.percase_invoice=pi.id
                                GROUP BY pi.docid) i2 ON i2.docid=du.userid
                LEFT JOIN (SELECT COALESCE(sum(ip.invoice_amount), 0) as vob_amount, pi.docid FROM 
                                dental_percase_invoice pi 
                                 LEFT JOIN dental_insurance_preauth ip ON ip.invoice_id = pi.id
                                GROUP BY pi.docid) i3 ON i3.docid=du.userid


                WHERE du.docid=0 AND status=1 AND
		DATE(i.adddate) = a.Date AND	
         COALESCE((i.ledger_amount + i1.monthly_amount + i2.extra_amount + i3.vob_amount), 0) > 0
        ), 0) as num_paid
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
          ?>paid.push({x: <?= date('U',strtotime($r['paid_date'])); ?>, y: <?= $r['num_paid']; ?>});<?php 
        }
 ?>
   return [
     {
       values: paid,
       key: 'Number of Users Paid',
       color: '#ff7f0e'
     }

   ];
 }
</script>
