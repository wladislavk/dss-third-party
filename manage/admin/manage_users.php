<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
include_once 'includes/edx_functions.php';

$isSuperAdmin = is_super($_SESSION['admin_access']);
$isSoftwareAdmin = is_software($_SESSION['admin_access']);

$canCreate = $isSuperAdmin || $isSoftwareAdmin;

$showAll = !empty($_GET['all']);
$search = !empty($_GET['search']) ? $_GET['search'] : '';
$hasSearch = false;
$userList = []; // Unfortunate name of the list of users

$totalUsers = 0;
$totalPages = 0;
$countDefault = 20;

$showPerPage = !empty($_GET['count']) ? intval($_GET['count']) : $countDefault;
$currentPage = !empty($_GET['page']) ? intval($_GET['page']) : 0;

$showPerPage = $showPerPage > 0 ? $showPerPage : $countDefault;
$currentOffset = $currentPage * $showPerPage;

if (!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access'])) {
    $deleteId = $db->escape($_REQUEST['delid']);
    $sql = "SELECT cc_id, edx_id FROM dental_users where userid='$deleteId'";
    $r = $db->getRow($sql);

    if ($r) {
        $sql = "delete from dental_users where userid='$deleteId'";
        $db->query($sql);
        edx_user_delete($r['edx_id']);

        if ($r['cc_id'] != '') {
            require_once '../3rdParty/stripe/lib/Stripe.php';
            $sql = "SELECT stripe_secret_key FROM companies c
                JOIN dental_user_company uc
                        ON c.id = uc.companyid
                 WHERE uc.userid='$deleteId'";
            $key_r = $db->getRow($sql);

            \Stripe::setApiKey($key_r['stripe_secret_key']);

            try {
                $cu = \Stripe_Customer::retrieve($r['cc_id']);
                $cu->delete();
            } catch(\Stripe_CardError $e) {
                // Since it's a decline, Stripe_CardError will be caught
                $body = $e->getJsonBody();
                $err  = $body['error'];
                echo $err['message'];
            } catch (\Stripe_InvalidRequestError $e) {
                // Invalid parameters were supplied to Stripe's API
                $body = $e->getJsonBody();
                $err  = $body['error'];
                echo $err['message'];
            }
        }

        $msg = "Deleted Successfully";
        ?>
        <script type="text/javascript">
            window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}

if ($showAll || $search) {
    $companyId = intval($_SESSION['admincompanyid']);

    $sql = "SELECT u.*, c.id AS company_id, c.name AS company_name, p.name AS plan_name
        FROM dental_users u
            LEFT JOIN dental_user_company uc ON uc.userid = u.userid
            LEFT JOIN companies c ON c.id = uc.companyid
            LEFT JOIN dental_plans p ON p.id = u.plan_id
        WHERE u.user_access = 2
        ";

    if ($isSuperAdmin && isset($_GET['cid'])) {
        $sql .= " AND c.id = '" . intval($_GET['cid']) . "' ";
    }

    if ($isSoftwareAdmin) {
        $sql .= " AND uc.companyid = '$companyId' ";
    } elseif (is_billing($_SESSION['admin_access'])) {
        $sql .= " AND u.billing_company_id = '$companyId' ";
    } else {
        $sql = '';
    }

    if (!empty($sql)) {
        if (!$showAll && $search) {
            $searchString = $search;
            $quotedTerms = [];

            if (preg_match_all('/"(?P<quoted>.*?)"/', $searchString, $matches)) {
                $quotedTerms = $matches['quoted'];
                $searchString = preg_replace('/".*?"/', '', $searchString);
            }

            $singleTerms = preg_split('/[\s\r\t\n]+/', $searchString);

            $searchTerms = array_merge($quotedTerms, $singleTerms);
            $searchTerms = array_unique($searchTerms);
            $searchTerms = array_filter($searchTerms, function($term){
                return strlen($term);
            });

            if ($searchTerms) {
                $hasSearch = true;

                array_walk($searchTerms, function(&$term)use($db){
                    $term = $db->escape($term);
                    $term = "u.username LIKE '%$term%' OR u.first_name LIKE '%$term%' OR u.last_name LIKE '%$term%'";
                });

                $sql .= ' AND (' . join(' OR ', $searchTerms) . ') ';
            }
        }

        $totalUsers = $db->getNumberRows($sql);
        $totalPages = $totalUsers/$showPerPage;

        $sql .= " ORDER BY u.last_name, u.first_name";
        $sql .= " LIMIT $currentOffset, $showPerPage";

        $userList = $db->getResults($sql);
    }
}

$queryString = [];

if ($search) {
    $queryString['search'] = $search;
}

if (!$search && $showAll) {
    $queryString['all'] = 1;
}

if ($showPerPage != $countDefault) {
    $queryString['count'] = $showPerPage;
}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Users
</div>
<br />
<br />

<?php if ($showAll) { ?>
    <h3>Viewing all users</h3>
<?php } elseif ($hasSearch) { ?>
    <h3>Search results for <code><?= htmlspecialchars($search) ?></code></h3>
<?php } ?>

<form class="form-group" name="user-search" action="?" method="get">
    <input class="form-control input-xlarge input-inline" name="search" value="<?= htmlspecialchars($search) ?>"
       placeholder="Multiple first names, last names or usernames" />
    <button class="btn btn-primary" type="submit">Search</button>
</form>

<div style="float:left; margin-left:20px;">
    <a href="manage_users.php?all=1" class="btn btn-success <?= $showAll ? 'disabled' : '' ?>">
        View All
    </a>
    &nbsp;&nbsp;
</div>

<?php if ($canCreate) { ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_users.php');" class="btn btn-success">
		Add New User
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<table class="table table-bordered table-hover">
	<?php if ($totalUsers > $showPerPage) {?>
	<tr bgColor="#ffffff">
		<td align="right" colspan="15" class="bp">
			Pages:
			<?php paging($totalPages, $currentPage, http_build_query($queryString)) ?>
		</td>
	</tr>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Username	
		</td>
		<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
		<td valign="top" class="col_head" width="20%">
			Letterhead
		</td>       
		<td valign="top" class="col_head" width="10%">
			Login As
		</td>
		<?php } ?>
		<td valign="top" class="col_head" width="8%">
			Locations
		</td>
		<td valign="top" class="col_head" width="8%">
			Contact
		</td>
		<td valign="top" class="col_head" width="8%">
			Staff
		</td>
		<td valign="top" class="col_head" width="8%">
		 	Patients	
		</td>
		<td valign="top" class="col_head" width="8%">
		 	Invoices	
		</td>
		<?php if(is_super($_SESSION['admin_access'])){ ?>
		<td valign="top" class="col_head" width="10%">
                        Company 
                </td>
		<?php } ?>
                <td valign="top" class="col_head" width="10%">
                        Plan
                </td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if (!count($userList)) { ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				<?= $showAll || $search ? 'No Records' : 'Perform a search, or click on View All' ?>
			</td>
		</tr>
	<?php } else {
		foreach ($userList as $user) {
			$staff_sql = "select count(userid) as staff_count from dental_users where docid='".st($user['userid'])."' and user_access=1";
			$staff_my = mysqli_query($con,$staff_sql);
			$staff_myarray = mysqli_fetch_array($staff_my);
			
			$con_sql = "select count(contactid) as con_count from dental_contact where docid='".st($user['userid'])."'";
			$con_my = mysqli_query($con,$con_sql);
			$con_myarray = mysqli_fetch_array($con_my);

                        $loc_sql = "select count(id) as loc_count from dental_locations where docid='".st($user['userid'])."'";
                        $loc_my = mysqli_query($con,$loc_sql);
                        $loc_myarray = mysqli_fetch_array($loc_my);

                        $pat_sql = "select count(patientid) as pat_count from dental_patients where docid='".st($user['userid'])."' ";
                        $pat_my = mysqli_query($con,$pat_sql);
                        $pat_myarray = mysqli_fetch_array($pat_my);

                        $inv_sql = "select count(id) as inv_count from dental_percase_invoice where docid='".st($user['userid'])."'  AND status != '".DSS_INVOICE_PENDING."'";
                        $inv_my = mysqli_query($con,$inv_sql);
                        $inv_myarray = mysqli_fetch_array($inv_my);
			
			if($user["status"] == 1)
			{
				$tr_class = "";
			}
			elseif($user["status"] == 2)
			{
				$tr_class = "info";
			}
                        elseif($user["status"] == 3)
                        {
                                $tr_class = "warning";
                        }
			else
			{
				$tr_class = "info";
			}
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($user["first_name"]. " " .$user["last_name"]);?>
				</td>
				<td valign="top">
					<?php if($user["status"] == 2){
					  echo "Registration emailed: ".(($user["registration_email_date"]!='')?date('m/d/Y H:i a', strtotime($user["registration_email_date"])):'');
					}else{ ?>
					  <?php echo st($user["username"]);?>
					<?php } ?>
				<?php if($user["status"] == 3){ ?>
					<br />
					Activated on: <?php echo  ($user['adddate'])?date('m/d/Y',strtotime($user['adddate'])):''; ?>
					<br />
					Suspended on: <?php echo  ($user['suspended_date'])?date('m/d/Y',strtotime($user['suspended_date'])):''; ?>
					<br />
					Suspended Reason: <?php echo  $user['suspended_reason']; ?>
				<?php } ?>
				</td>
				<?php if(is_super($_SESSION['admin_access']) || is_admin($_SESSION['admin_access'])) { ?>
				<td valign="top">
					<a href="/manage/admin/letterhead.php?uid=<?php echo st($user["userid"]);?>">Update Images</a>
				</td>
				
				<td valign="top">
					<?php if($user['status']!=2){ ?>
					<form action="login_as.php" method="post" target="Doctor_Login">
						<input type="hidden" name="username" value="<?php echo st($user["username"]);?>">
						<input type="hidden" name="password" value="<?php echo st($user["password"]);?>">
			            <input type="hidden" name="loginsub" value="1">
			            <input type="submit" name="btnsubmit" value=" Login " class="btn btn-success">			
					</form>
					<?php } ?>
				</td>
				<?php } ?>
			           <td valign="top" align="center">
                    <a href="manage_locations.php?docid=<?php echo $user["userid"];?>" class="btn btn-danger pull-right" title="locations">
                        <?php echo st($loc_myarray['loc_count']);?></a>
                                </td>	
                
				<td valign="top" align="center">
                    <a href="manage_contact.php?docid=<?php echo $user["userid"];?>" class="btn btn-danger pull-right" title="contacts">
                    	<?php echo st($con_myarray['con_count']);?></a>
				</td>	
                
				<td valign="top" align="center">
					<a href="manage_staff.php?docid=<?php echo $user["userid"];?>" class="btn btn-danger pull-right" title="staff">
                    	<?php echo st($staff_myarray['staff_count']);?></a>
				</td>	
                                <td valign="top" align="center">
                        <?php echo st($pat_myarray['pat_count']);?>
                                </td>
                                <td valign="top" align="center">
				<?php if(is_super($_SESSION['admin_access'])) { ?>
                        <a href="manage_percase_invoice_history.php?docid=<?php echo  $user["userid"]; ?>"><?php echo st($inv_myarray['inv_count']);?></a>
				<?php }else{ ?>
                        <a href="manage_percase_fo_invoice_history.php?docid=<?php echo  $user["userid"]; ?>"><?php echo st($inv_myarray['inv_count']);?></a>
				<?php } ?>
                                </td>

				<?php if(is_super($_SESSION['admin_access'])){ ?>
			 	<td valign="top" align="center">
                                        	<a href="manage_users.php?cid=<?php echo  $user["company_id"]; ?>"><?php echo  $user["company_name"]; ?></a>
				</td>			
				<?php } ?>
                                <td valign="top" align="center">
                                                <?php echo  $user["plan_name"]; ?>
                                </td>
				<td valign="top">
				<?php if(is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])) { ?>
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_users.php?ed=<?php echo $user["userid"];?>');" title="Edit Profile" class="btn btn-primary btn-sm">
						Edit
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				<?php } ?>
				<a href="manage_enrollments.php?ed=<?php echo $user["userid"];?>" title="Manage Enrollments" class="btn btn-primary btn-sm">
                                                Enrollments 
                                         <span class="glyphicon glyphicon-pencil"></span></a>
				</td>
			</tr>
	<?php 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
