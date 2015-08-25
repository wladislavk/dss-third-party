<?php namespace Ds3\Libraries\Legacy; ?><?php
    include "includes/top.htm";
    include_once '3rdParty/stripe/lib/Stripe.php';
    $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
    
    $r = $db->getRow($sql);
    if($_SESSION['docid']!=$_SESSION['userid'] && $r['manage_staff'] != 1){
?>
        <h3 style="margin-left:20px;">You are not permitted to view this page.</h3>
<?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $sql = "SELECT pi.* FROM dental_percase_invoice pi
    	    WHERE pi.status != '".DSS_INVOICE_PENDING."'AND pi.docid=".mysqli_real_escape_string($con,$_SESSION['docid'])." ORDER BY pi.due_date DESC";
    
    if (!isset($rec_disp)) {
        $rec_disp = 1;
    }

    $total_rec = $db->getNumberRows($sql);
    $no_pages = $total_rec/$rec_disp;

    $my = $db->getResults($sql);
    $num_users = count($my);

    $doc_sql = "SELECT * from dental_users WHERE userid=".mysqli_real_escape_string($con,$_SESSION['docid']);
    
    $doc = $db->getRow($doc_sql);
?>
    <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
    <script src="admin/popup/popup.js" type="text/javascript"></script>

    <span class="admin_head">
        Invoice History - <?php echo  $doc['name']; ?>
    </span>
    <br />

    <div align="center" class="red" style="clear:both;">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        	<tr class="tr_bg_h">
        		<td valign="top" class="col_head" width="25%">
			        Date		
		        </td>
        		<td valign="top" class="col_head" width="25%">
        			Action	
        		</td>
	        </tr>
        	<?php if($num_users == 0) { ?>
        		<tr class="tr_bg">
        			<td valign="top" class="col_head" colspan="10" align="center">
        				No Records
        			</td>
        		</tr>
        	<?php } else {
		        foreach ($my as $myarray) {
		            $case_sql = "SELECT COUNT(*) AS num_trxn, sum(percase_amount) AS ledger_total FROM dental_ledger dl 
                                 WHERE 
                                 dl.percase_invoice='".$myarray['id']."'
                                ";

            		$case = $db->getRow($case_sql);
            		$extra_sql = "SELECT sum(percase_amount) as extra_total FROM dental_percase_invoice_extra 
				                  WHERE percase_invoice='".$myarray['id']."'
                                ";

            		$extra = $db->getRow($extra_sql);
                    $fax_sql = "SELECT amount FROM dental_fax_invoice 
                                WHERE invoice_id='".$myarray['id']."'
                                ";

                    $fax = $db->getRow($fax_sql);
		    ?>
        			<tr>
        				<td valign="top">
        					<?php echo ($myarray["due_date"])?st(date('m/d/Y', strtotime($myarray["due_date"]))):($myarray["adddate"])?st(date('m/d/Y', strtotime($myarray["adddate"]))):'';?>
        				</td>
        				<td valign="top">
        					<a href="display_file.php?f=percase_invoice_<?php echo  $myarray['docid'];?>_<?php echo  $myarray['id']; ?>.pdf" class="button" title="EDIT" style="padding:3px 5px;" target="_blank">
        						View PDF
        					</a>
        					&nbsp;&nbsp;
        					<a href="invoice_history_view.php?invoice_id=<?php echo  $myarray['id']; ?>" class="button" style="padding:3px 5px;">HTML</a>                    
        				</td>
        			</tr>
	        <?php
                }
	        }
            ?>
        </table>
    </form>
    <br><br>
    <span class="admin_head">
        Credit Card Billing History - <?php echo  $doc['name']; ?>
    </span>
    <br />

    <div align="center" class="red" style="clear:both;">
        <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
    </div>

    <?php
        $charge_sql = "SELECT * FROM dental_charge
        		       WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
        
        $charge_q = $db->getResults($charge_sql);
    ?>

    <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
            <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                    Date
                </td>
                <td valign="top" class="col_head" width="30%">
                    Card #
                </td>
            </tr>
            <?php if(count($charge_q) == 0) { ?>
                <tr class="tr_bg">
                    <td valign="top" class="col_head" colspan="10" align="center">
                        No Records
                    </td>
                </tr>
            <?php } else {
                foreach ($charge_q as $charge_r) {
            ?>
                    <tr>
                        <td valign="top">
                            <?php echo st(date('m/d/Y g:i a', strtotime($charge_r["charge_date"])));?>
                        </td>
                    <td valign="top" style="font-weight:bold;">
				        <?php
                            if($charge_r["stripe_charge"]!='') {
                                $key_sql = "SELECT stripe_secret_key FROM companies c 
                                            JOIN dental_user_company uc
                                            ON c.id = uc.companyid
                                            WHERE uc.userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
                                
                                $key_r= $db->getRow($key_sql);

                                \Stripe::setApiKey($key_r['stripe_secret_key']);

                                try{
                                    $charge = \Stripe_Charge::retrieve($charge_r["stripe_charge"]);
                                } catch (Exception $e) {
                                    // Something else happened, completely unrelated to Stripe
                                    $body = $e->getJsonBody();
                                    $err  = $body['error'];
                                    echo $err['message'].". Please contact your Credit Card billing administrator to resolve this issue.";
                                } 

                                echo $charge->card->last4;
                            }
                        ?>
                    </td>
                </tr>
        <?php
                }
            }
        ?>
    </table>
    </form>
    <br /><br />

    <div id="popupContact">
        <a id="popupContactClose">
            <button>X</button>
        </a>
        <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
    </div>

    <div id="backgroundPopup"></div>

    <br /><br />	
<?php include "includes/bottom.htm";?>
