<? 
include "includes/top.htm";
include_once "includes/constants.inc";
?>

<span class="admin_head">EdX Certificates</span>
<br /><br />
<ul class="fullwidth" style="list-style:none;">
<?php
  $c_sql = "SELECT * FROM edx_certificates c 
		JOIN dental_users u ON c.edx_id = u.edx_id
		WHERE u.userid='".mysql_real_escape_string($_SESSION['userid'])."'";
  $c_q = mysql_query($c_sql);
  while($c = mysql_fetch_assoc($c_q)){
    ?>
    <li>
	<a href="<?= $c['url']; ?>" target="_blank">
	  <?= $c['course_name']; ?> -
	  <?= $c['course_section']; ?> - 
	  <?= $c['course_subsection']; ?> -
	  <?= $c['number_ce']; ?>
	</a>
    </li>

<?php
  }
?>
</ul>
<?php
include 'includes/bottom.htm';
?>


