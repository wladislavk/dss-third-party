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
?>
<div class="dp60">

<h3 style="margin-bottom:20px;">Welcome, <?= $pat['firstname']; ?>!</h3>

<ul class="tabsB cf">
								<li><a href="#tab-1" class="current">Welcome</a></li>
								<li><a href="#tab-2" class="">About OSA</a></li>
								<li><a href="#tab-3" class="">Another Tab</a></li>
							</ul>
 
<div class="content_panes">

	<div id="tab-1" style="display: block; ">
		<div class="dp100">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>
<div style="height:12px; display:block; clear:both;"></div>
		<div class="dp50">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</div>
		<div class="dp50">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>
	</div>

	<div id="tab-2" class="cf formEl_a" style="display: none; ">
                <div class="dp100">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>
	</div>

        <div id="tab-3" class="cf formEl_a" style="display: none; ">
                <div class="dp50">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</div>
                <div class="dp50">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</div>

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
