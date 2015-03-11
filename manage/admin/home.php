<?php 
require_once('classes/tc_calendar.php');
include 'includes/top.htm';

?>


<div class="row">
			<?php if (is_admin($_SESSION['admin_access'])) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat blue">
						<div class="visual">
							<i class="fa fa-envelope"></i>
						</div>
						<div class="details">
							<div class="number">
							<?= $pending_letters; ?>
							</div>
							<div class="desc">
								 LETTERS 
							</div>
						</div>
						<a class="more" href="/manage/admin/manage_letters.php">
							 View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			<?php } ?>
			<?php if (!is_hst($_SESSION['admin_access'])) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat green">
						<div class="visual">
							<i class="fa fa-hospital-o"></i>
						</div>
						<div class="details">
							<div class="number">
								<?= $num_pending_preauth; ?>
							</div>
							<div class="desc">
								VOBs 
							</div>
						</div>
						<a class="more" href="/manage/admin/manage_vobs.php?status=0">
							 View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			<?php } ?>
			<?php if (!is_billing($_SESSION['admin_access'])) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat purple">
						<div class="visual">
							<i class="fa fa-user-md"></i>
						</div>
						<div class="details">
							<div class="number">
								 <?= $num_pending_hst; ?>
							</div>
							<div class="desc">
								HSTs 
							</div>
						</div>
						<a class="more" href="/manage/admin/manage_hsts.php?status=<?= DSS_HST_PENDING; ?>">
							 View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			<?php } ?>
			<?php if (!is_hst($_SESSION['admin_access'])) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat yellow">
						<div class="visual">
							<i class="fa fa-medkit"></i>
						</div>
						<div class="details">
							<div class="number">
								<?= $num_pending_claims; ?>
							</div>
							<div class="desc">
								CLAIMS
							</div>
						</div>
						<a class="more" href="/manage/admin/manage_claims.php?status=0">
							 View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			<?php } ?>
			<?php if (is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access']) || is_billing($_SESSION['admin_access'])) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="dashboard-stat red">
						<div class="visual">
							<i class="fa  fa-question"></i> 
						</div>
						<div class="details">
							<div class="number">
								<?= $num_open_tickets; ?>
							</div>
							<div class="desc">
								TICKETS 
							</div>
						</div>
						<a class="more" href="/manage/admin/manage_support_tickets.php">
							 View more <i class="m-icon-swapright m-icon-white"></i>
						</a>
					</div>
				</div>
			<?php } ?>
			</div>



<?php if(is_billing($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])){ ?>

<h1>Welcome to the DS3 backoffice system.</h1>
<p>Any unauthorized use of this system is strictly prohibited. By accessing this system you are bound to the user agreement terms as well as all applicable HIPAA-HiTECH regulations. Please take all possible measures to ensure patient data is protected at all times.</p>


<?php }else{ ?>
                <center><B>Welcome</B></center> <p>&nbsp;</p>
		
<br /><br />
<?php } ?>
<? include 'includes/bottom.htm';?>
