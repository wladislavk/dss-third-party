<?php namespace Ds3\Libraries\Legacy; ?><div id="screened">
  <svg style='height:300px; width: 450px;'/>
</div>

<script type="text/javascript">
$(document).ready(function(){
  nv.addGraph(function() {
    var chart = nv.models.multiBarChart().width(450).height(300);

    chart.xAxis
       .axisLabel('Date')
        .showMaxMin(false)      
        .tickFormat(function(d) {return d3.time.format("%x")(new Date(d*1000));});

    chart.yAxis
        .tickFormat(d3.format(',f'));

    chart.stacked(true);

    d3.select('#screened svg')
        .datum(screened_data())
      .transition().duration(500).call(chart);

    nv.utils.windowResize(function() { d3.select('#screened svg').call(chart) });
    return chart;
  });
});
 
 
function screened_data(){
  series = [];
  s = "";

  <?php
    $u_sql = "SELECT u.userid, u.name FROM dental_users u
    		      JOIN dental_screener s ON u.userid = s.userid
    		      WHERE 
    		      (u.docid = '".mysqli_real_escape_string($con,$_SESSION['docid'])."'
    		      OR u.userid = '".mysqli_real_escape_string($con,$_SESSION['docid'])."') GROUP BY u.userid";
    $u_q = $db->getResults($u_sql);
    foreach ($u_q as $user) {
  ?>

      s = '{ "key": "<?php echo  $user['name'];?>","color":"#'+Math.floor(Math.random()*16777215).toString(16)+'", "values": [';
      screened = [];

      <?php
        $sql = "select a.Date as screened_date,
                COALESCE((SELECT count(id) 
                FROM dental_screener t1
                WHERE userid='".$user['userid']."' AND DATE(t1.adddate) = a.Date), 0) as num_screened 
                from (
                  select curdate() - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
                  from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                  cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                  cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
                ) a
                where a.Date between '".(!empty($start_date) ? $start_date : '')."' AND '".(!empty($end_date) ? $end_date : '')."' 
                ORDER BY a.Date";
        $q = $db->getResults($sql);
        foreach ($q as $r) {
      ?>

          s += '{"x": "<?php echo  date('U',strtotime($r['screened_date'])); ?>", "y": <?php echo  $r['num_screened']; ?>},';
      <?php } ?>

      	s = s.slice(0, -1);
      	s +=  "]}";
      	s = $.parseJSON(s);
       	series.push(s);

  <?php } ?>

  return series;
}

</script>




