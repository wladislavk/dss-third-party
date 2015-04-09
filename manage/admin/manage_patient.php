<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

if(!empty($_REQUEST["delid"]) && is_super($_SESSION['admin_access']))
{
	$del_sql = "delete from dental_patients where patientid='".$_REQUEST["delid"]."' OR parent_patientid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$del_sql = "delete from dental_patient_contacts where patientid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
        $del_sql = "delete from dental_patient_insurance where patientid='".$_REQUEST["delid"]."'";
        mysqli_query($con,$del_sql);

	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&docid=<?php echo $_GET['docid']?>";
	</script>
	<?
	trigger_error("Die called", E_USER_ERROR);
}

if(is_super($_SESSION['admin_access'])){
$doc_sql = "select * from dental_users where user_access=2 order by username";
}else{
  $doc_sql = "SELECT u.* FROM dental_users u 
                INNER JOIN dental_user_company uc ON uc.userid = u.userid
                WHERE u.user_access=2 AND uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'
                ORDER BY username";
}

$doc_my = mysqli_query($con,$doc_sql);

$doc_my1 = mysqli_query($con,$doc_sql);
$doc_myarray1 = mysqli_fetch_array($doc_my1);

if(empty($_GET['docid']))
{
	$_GET['docid'] = $doc_myarray1['userid'];
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
$sql = "select * from dental_patients order by lastname, firstname";
}elseif(is_software($_SESSION['admin_access'])){
$sql = "select p.* from dental_patients p 
	JOIN dental_users u ON u.userid=p.docid 
   	JOIN dental_user_company uc ON uc.userid = u.userid
	where uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."' order by p.lastname, p.firstname";
}elseif(is_billing($_SESSION['admin_access'])){
  $a_sql = "SELECT ac.companyid FROM admin_company ac
                        JOIN admin a ON a.adminid = ac.adminid
                        WHERE a.adminid='".mysqli_real_escape_string($con,$_SESSION['adminuserid'])."'";
  $a_q = mysqli_query($con,$a_sql);
  $admin = mysqli_fetch_assoc($a_q);
$sql = "select p.* from dental_patients p 
	JOIN dental_users u ON u.userid=p.docid 
	where u.billing_company_id='".mysqli_real_escape_string($con,$admin['companyid'])."' order by p.lastname, p.firstname";
}
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysqli_query($con,$sql);
$num_users=mysqli_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>
<link href="../css/search-hints.css" rel="stylesheet" type="text/css">

<div class="page-header">
	Manage Patient
   <!-- -
    <select class="tbox" onchange="Javascript: window.location='<?php echo $_SERVER['PHP_SELF'];?>?docid='+this.value;">
        <?php while($doc_myarray = mysqli_fetch_array($doc_my))
		{?>
    		<option value="<?php echo st($doc_myarray['userid']);?>" <?php if(st($doc_myarray['userid']) == $_GET['docid']) echo " selected";?>>
            	<?php echo st($doc_myarray['username']);?> [ <?php echo st($doc_myarray['name']);?> ]
            </option>
        <?php }?>
    </select>-->
</div>


<script type="text/javascript">
        // Patient Search Suggestion Script
        var selection = 1;
        var selectedUrl = '';
        var searchVal = ""; // global variable to hold the last valid search string
        $(document).ready(function() {
                $('#patient_search').keyup(function(e) {
                                var a = e.which; // ascii decimal value
                                //var c = String.fromCharCode(a);
                                var listSize = $('#patient_list li').size();
                                var stringSize = $(this).val().length;
                                if ($(this).val().trim() == "") {
                                        $('#search_hints').css('display', 'none');
                                        $('.json_patient').remove();
                                        $('.create_new').remove();
                                        $('.initial_list').css("display", "table-row");
                                } else if ((stringSize > 1 || (listSize > 2 && stringSize > 1) || ($(this).val() == window.searchVal)) && ((a >= 39 && a <= 122 && a != 40) || a == 8)) { // (greater than apostrophe and less than z and not down arrow) or backspace
                                        $('.initial_list').css("display", "none");
                                        $('#search_hints').css("display", "inline");
                                        sendValue($('#patient_search').val());
                                        if ($(this).val() > 2) {
                                                window.searchVal = $(this).val().replace(/(\s+)?.$/, ""); // strip last character to match last positive result
                                        }
                                }
                });
                $(document).keyup(function(e) {
                        switch (e.which) {
                                case 38:
                                        move_selection('up');
                                        break;
                                case 40:
                                        move_selection('down');
                                        break;
                                case 13:
                                        if($('#search_hints').css('display') == 'inline' || $('#search_hints').css('display') == 'block'){      
                                          if (selectedUrl != '') {
                                                window.location = window.selectedUrl;
                                          }
                                        }
                                        break;
                        }
                });
                $('#patient_search').click(function() {
                        if ($(this).val() == 'Patient Search') {
                                $(this).val('');
                        }
                });
                $('#patient_list > li').hover(function() {
                        if($(this).data("pattype")!="no"){
                          $(this).css('cursor','pointer');
                        }
                        window.selection = $(this).data("number");
                        set_selected(window.selection);
                }, function() {
                        if($(this).data("pattype")!="no"){
                          $(this).css('cursor','auto');
                        }
                        $('#patient_list li').removeClass('list_hover');
                        window.selectedUrl = '';
                });
                $('#patient_list > li').click(function() {
                    if($(this).data("pattype")=="new"){
                        n = $('#patient_search').val();
                        window.location = "add_patient.php?search="+n;
                    }else if($(this).data("pattype")=="no"){
                        //do nothing
                    }else{
                        if (selectedUrl != '') {
                                window.location = window.selectedUrl;
                        }
                        $('#patient_search').val($(this).html());
                        sendValue($(this).html());
                    }
                });
                $('*').click(function() {
                        $('.search_hints').css('display', 'none');
                });
        });
        function sendValue(partial_name) {
                $.post(
                
                "list_patients.php",

                { 
                        "partial_name": partial_name 
                },

                function(data) {
                        if (data.length == 0) {
                                $('.json_patient').remove();
                                $('.create_new').remove();
                                $('.no_matches').remove();
                                //$('#search_hints').css('display', 'none');
                               var newLi = $('#patient_list .template').clone(true).removeClass('template').addClass('no_matches').data("pattype", "no");
                                        template_list_new(newLi, "No Matches")
                                                .appendTo('#patient_list')
                                                .fadeIn();
                                var newLi = $('#patient_list .template').clone(true).removeClass('template').addClass('create_new').data("pattype", "new");
                                        template_list_new(newLi, "Add patient with this name&#8230;")
                                                .appendTo('#patient_list')
                                                .fadeIn();
                        }else{
                        if (data.error) {
                                //alert(data.error);
                        } else {
                                $('.json_patient').remove();
                                $('.create_new').remove();
                               $('.no_matches').remove();
 
                                for (i in data) {
                                        var newLi = $('#patient_list .template').clone(true).removeClass('template').addClass('json_patient').data("number", parseInt(i)+1).data("patientid", data[i].patientid).data("patient_info", data[i].patient_info);
                                        template_list(newLi, data[i])
                                                .appendTo('#patient_list')
                                                .fadeIn();
                                        <?php if ($_SERVER['PHP_SELF'] == "/manage/manage_patient.php") { ?>
                                        if (data[i].stat == "1") {
                                                var tr_class = "tr_active";
                                        } else {
                                                var tr_class = "tr_inactive";
                                        }
                                        var newRow = $('#patients .template').clone().removeClass('template').addClass('json_patient').addClass(tr_class);
                                        template_table(newRow, data[i])
                                                .appendTo('#patients')
                                                .fadeIn();
                                        <?php } ?>
                                }
                           }
                        }
                },

                "json"
                );
        }
        function move_selection(direction) {
                if ($('#patient_list > li.list_hover').size() == 0) {
                        window.selection = 0;
                }
                if (direction == 'up' && window.selection != 0) {
                        if (window.selection != 1) {
                                window.selection--;
                        }
                } else if (direction == 'down') {
                        if (window.selection != ($("#patient_list li").size() -1)) {
                                window.selection++;
                        }
                }
                set_selected(window.selection);
        }
        function set_selected(menuitem) {
                $('#patient_list li').removeClass('list_hover');
                $('#patient_list li').eq(menuitem).addClass('list_hover');
                var pid = $('#patient_list li').eq(menuitem).data("patientid");
                var patient_info = $('#patient_list li').eq(menuitem).data("patient_info");
                    if($('#patient_list li').eq(menuitem).data("pattype")=="new"){
                        n = $('#patient_search').val();
                        window.selectedUrl = "add_patient.php?search="+n;
                    }else if($('#patient_list li').eq(menuitem).data("pattype")=="no"){
                        window.selectedUrl = '';
                    }else{

                        window.selectedUrl = "view_patient.php?pid=" + pid;
                    }
        }
        function template_list(li, patient) {
                if(patient.middlename != null){
                var mid = patient.middlename
                }else{
                        var mid = '';
                }
                li.html(patient.lastname + ", " + patient.firstname + " " + mid+ " - "+patient.doctor);
                return li;
        }
        function template_list_new(li, str) {
                li.html(str);
                return li;
        }


        function template_table(row, patient) {
                var pm = "";
                if (patient.premedcheck == "1") {
                        var pm = "&nbsp;&nbsp;&nbsp;<font style=\"font-weight:bold; color:#FF0000;\">*Med";
                }
                if(patient.middlename != null){                        var mid = patient.middlename
                }else{
                        var mid = '';
                }
                if (patient.patient_info == 1) {
                        row.find('.patient_name').html("<a href=\"add_patient.php?pid=" + patient.patientid + "&ed=" + patient.patientid + "\">" + patient.lastname + ", " + patient.firstname + " " + mid + "</a>" + pm);
                        row.find('.flowsheet').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "\">" + patient.fspage1_complete + "</a>");
                        row.find('.next_visit').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "&page=page2\">" + patient.next_visit + "</a>");
                        row.find('.last_visit').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "&page=page2\">" + patient.last_visit + "</a>");
                        row.find('.last_treatment').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "&page=page2\">" + patient.last_treatment + "</a>");
                        row.find('.appliance').html("<a href=\"dss_summ.php?pid=" + patient.patientid + "\">" + patient.device + "</a>");
                        row.find('.appliance_since').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "&page=page2\">" + patient.delivery_date + "</a>");
                        row.find('.vob').html("<a href=\"manage_insurance.php?pid=" + patient.patientid + "\">" + patient.vob + "</a>");
                        row.find('.rxlomn').html("<a href=\"manage_flowsheet3.php?pid=" + patient.patientid + "\">" + patient.rxlomn + "</a>");
                        row.find('.ledger').html("<a href=\"manage_ledger.php?pid=" + patient.patientid + "\">" + patient.ledger + "</a>");
                } else {
                        row.html("<td><a href=\"add_patient.php?pid=" + patient.patientid + "&ed=" + patient.patientid + "\">" + patient.lastname + ", " + patient.firstname + " " + mid + "</a>" + pm+"</td><td colspan=\"9\" align=\"center\" class=\"pat_incomplete\">-- Patient Incomplete --</td>");
                        /*
                        row.find('.patient_name').html("<a href=\"add_patient.php?pid=" + patient.patientid + "&ed=" + patient.patientid + "\">" + patient.lastname + ", " + patient.firstname + " " + patient.middlename + "</a>" + pm);
                        row.find('.flowsheet').html(patient.fspage1_complete);
                        row.find('.next_visit').html(patient.next_visit);
                        row.find('.last_visit').html(patient.last_visit);
                        row.find('.last_treatment').html(patient.last_treatment);
                        row.find('.appliance').html(patient.device);
                        row.find('.appliance_since').html(patient.delivery_date);
                        row.find('.vob').html(patient.vob);
                        row.find('.ledger').html(patient.ledger)
                        */
                }
                return row;
        }
</script>
                                                                                                          



<form>
    <!--<form name="form" action="search.php" method="get">-->
  <div id="patient_search_div">
  <input type="text" id="patient_search" value="Patient Search" name="q" autocomplete="off" />
  <!--<input type="submit" name="Submit" value="Patient Search By Last Name" class="btn btn-primary">-->
        <br />
        <div id="search_hints"  class="search_hints" style="display:none;">
                <ul id="patient_list">
                        <li class="template" style="display:none">Doe, John S</li>
                </ul>
        </div>
   </div>
</form>










&nbsp;
<?php if(!is_billing($_SESSION['admin_access'])){ ?>
<div align="right">
	<button onclick="Javascript: loadPopup('add_patient.php?docid=<?php echo $_GET['docid']?>');" class="btn btn-success">
		Add New Patient
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<?php } ?>
<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"docid=".$_GET['docid']);
			?>
		</TD>
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="90%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
					<?php echo st($myarray["firstname"]);?>&nbsp;
                    <?php echo st($myarray["middlename"]);?>.&nbsp;
                    <?php echo st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<a href="view_patient.php?pid=<?php echo $myarray["patientid"];?>" title="Edit" class="btn btn-primary btn-sm">
						View
					 <span class="glyphicon glyphicon-pencil"></span></a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
