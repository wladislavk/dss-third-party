<?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';
include 'includes/completed.php';
?>
        <script type="text/javascript">
                $(document).ready(function(){
                                //lga_fusionCharts.chart_k();
                                lga_flowTabs.tabs_b();
                        });
        </script>
<? $s = "SELECT * FROM dental_patients WHERE patientid='".mysql_real_escape_string($_SESSION['pid'])."'"; 
$q = mysql_query($s);
$pat = mysql_fetch_assoc($q);

$ds = "SELECT * FROM dental_users WHERE userid='".mysql_real_escape_string($pat['docid'])."'";
$dq = mysql_query($ds);
$doc = mysql_fetch_assoc($dq);

?>
<div class="dp60">

<h3 style="margin-bottom:20px;">Welcome, <?= $pat['firstname']; ?>!</h3>

<ul class="tabsB cf">
								<li><a href="#tab-1" class="current">Welcome</a></li>
							</ul>
 
<div class="content_panes">

	<div id="tab-1" style="display: block; ">
		<div class="dp100">
			<p>Welcome to the secure patient portal! We're excited that you have taken the first steps toward improving your sleep quality and health. Treating snoring and sleep apnea improves your quality of life, and can dramatically improve your health and well-being. At the office of <?= $doc['practice'];?>, we work hard to make sure you receive the best possible treatment.</p>
<br /> 
<p>Please check the status box on the right side of this page to make sure your patient profile is 100% complete. Click on any incomplete highlighted fields to answer them. After your profile is 100% complete, we will be ready to see you at your next visit!</p>
		</div>
	</div>

</div>
</div>
<div class="dp40">
<div class="box_c">
	<div class="box_c_heading">
		<span class="fl">Your Patient Profile</span>
	</div>
	<div class="box_c_content">
		<div style="float:left; margin:3px 5px 0 0; width:130px; background:#999; height:12px; padding:3px;">
			<?php
				$comp_width = $comp_perc*1.3;
			?>
			<div style="width:<?= $comp_width; ?>px; height:12px; background:#21759B;"></div>
		</div>
		<div style="font-size:18px;"><?= $comp_perc; ?>% Complete</div>
		<ul class="progress" style="margin-top:10px;">
  			<li><a href="register.php" class="<?= ($comp['registered'])?'complete':'incomplete'; ?>">Registration
                                <?= ($comp['registered'])?'':'<span class="details">(click to complete)</span>'; ?></a></li>
  			<li><a href="symptoms.php" class="<?= ($comp['symptoms'])?'complete':'incomplete'; ?>">Symptoms
                                <?= ($comp['symptoms'])?'':'<span class="details">(click to complete)</span>'; ?></a></li>
  			<li><a href="sleep.php" class="<?= ($comp['epworth'])?'complete':'incomplete'; ?>">Epworth/Thornton Scale
                                <?= ($comp['epworth'])?'':'<span class="details">(click to complete)</span>'; ?></a></li>
  			<li><a href="treatments.php" class="<?= ($comp['treatments'])?'complete':'incomplete'; ?>">Previous Treatments
				<?= ($comp['treatments'])?'':'<span class="details">(click to complete)</span>'; ?></a></li>
  			<li><a href="history.php" class="<?= ($comp['history'])?'complete':'incomplete'; ?>">Social Health History
                                <?= ($comp['history'])?'':'<span class="details">(click to complete)</span>'; ?></a></li>
			</ul>
	</div>
</div>
<?php
include 'includes/footer.php';
?>
