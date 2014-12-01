<?php include 'includes/top.htm';?>

  <link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
  <script src="admin/popup/popup2.js" type="text/javascript"></script>

  <br />
  <div>
    <table>
      <tr>
        <td valign="top" style="border-right:1px solid #00457c;width:290px;">
          <div style="padding-left:10px; padding-right:10px; margin-right:5px;" id="formLeftC"> 
            <?php
              $adminmemo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
              $adminmemo_check_qry = $db->getResults($adminmemo_check_sql);
              if ($adminmemo_check_qry) foreach ($adminmemo_check_qry as $adminmemo_array){
                if($adminmemo_array['memo'] != NULL || $adminmemo_array['memo'] != ''){
          	?>
              	  <div style="color:#ff0000; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;">
                    <span class="admin_head" style="color:#ff0000;"><em> Global Memo: </em></span>
                  </div>
              	  <br />
              	  <table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
                    <tr>
                      <td valign="top">
                        <?php 
                          echo "". $adminmemo_array['memo'] . "<br />";
                        ?>
                      </td>
                    </tr>
                  </table>
                  <br />
            <?php
                }
              }
            ?>

            <div style="color:#00457c; background:url(images/mod_headers.png) no-repeat top left; width:100%; height:28px;padding-top:1px;">
              <span class="admin_head" style="color:#00457c;"><em> Todays Memo: </em></span>
            </div>
          	<br />
          	<table width="260" border="0" align="center" cellpadding="1" cellspacing="1" class="sample">
              <tr>
                <td valign="top">
                  <?php 
                    $memouserid = $_SESSION['userid'];
                    $memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
                    
                    $memo_check_qry = $db->getResults($memo_check_sql);
                    if ($memo_check_qry) foreach ($memo_check_qry as $memo_array){
                      if($memo_array != NULL || $memo_array != ''){
                        echo $memo_array['memo'] . "<br /><hr />";
                      }
                    }
                  ?>
                  <a href="Javascript: ;" target="_blank" class="viewtable" title="EDIT" onclick="Javascript: loadPopup('memo.php'); getElementById('popupMemo').style.top = '200px'; return false;">Edit Memo</a>
                </td>
              </tr>
            </table>
            <br /><br /><br />
        
            <?php
              $sqlddlist = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
              if(!empty($_GET['sh']) && $_GET['sh'] != 2) {
              	$sqlddlist .= " and status = 1";
              }
              $sqlddlist .= " order by lastname, firstname";
              
              $myddlist = $db->query($sqlddlist);
            ?>
            <script language="javascript" src="js/directory.js"></script>

            <font style="font-size:16px; font-weight:bold;">View Patient Elements:</font><br />
            <form NAME="DropDown" ACTION="http://www.cgiforme.com/jumporama/cgi/jumporama.cgi" METHOD="post" >
              <select id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">
                <?php
                  $sqlddlist2 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
                  if(!empty($_GET['sh']) && $_GET['sh'] != 2) {
                  	$sqlddlist2 .= " and status = 1";
                  }
                  $sqlddlist2 .= " order by lastname, firstname";
                  
                  $myddlist2 = $db->getResults($sqlddlist2);
                  if ($myddlist2) foreach ($myddlist2 as $ddlistpname2) {
                ?>
                    <option value="manage_patient.php?pid=<?php echo $ddlistpname2['patientid']; ?>">
                      <?php echo $ddlistpname2['lastname'].", ".$ddlistpname2['firstname']." ".$ddlistpname2['middlename']; ?>
                    </option>
                <?php  
                  }
                ?>                
              </select>
              <br />
            </form>

            <div style="margin-top:25px;  width:100%;">&nbsp;</div> 
            <hr />
            <div style="margin-top:0px; width:100%;">&nbsp;</div> 

            <font style="font-size:16px; font-weight:bold;">View Patient Flowsheet:</font><br />
            <form NAME="DropDown">
              <SELECT id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">
                <?php
                  $sqlddlist3 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
                  if(!empty($_GET['sh']) && $_GET['sh'] != 2) {
                  	$sqlddlist3 .= " and status = 1";
                  }
                  $sqlddlist3 .= " order by lastname, firstname";
                  
                  $myddlist3 = $db->getResults($sqlddlist3);
                  if ($myddlist3) foreach ($myddlist3 as $ddlistpname3){
                ?>
                    <option value="manage_flowsheet.php?pid=<?php echo $ddlistpname3['patientid']; ?>">
                      <?php echo $ddlistpname3['lastname'].", ".$ddlistpname3['firstname']." ".$ddlistpname3['middlename']; ?>
                    </option>
                <?php  
                  }
                ?>                
              </select>
              <br />
            </form>  
            
            <div style="margin-top:25px;  width:100%;">&nbsp;</div> 
              <hr />
            <div style="margin-top:0px; width:100%;">&nbsp;</div>  

            <font style="font-size:16px; font-weight:bold;">View Patient Summary Sheet:</font><br />
            <form NAME="DropDown">
              <select id="mySelect" onchange="if(this.options[this.selectedIndex].value != ''){window.top.location.href=this.options[this.selectedIndex].value}" style="width:260px;">
                <?php
                  $sqlddlist4 = "select * from dental_patients where docid='".$_SESSION['docid']."' ";
                  if(!empty($_GET['sh']) && $_GET['sh'] != 2) {
                  	$sqlddlist4 .= " and status = 1";
                  }
                  $sqlddlist4 .= " order by lastname, firstname";
                  
                  $myddlist4 = $db->getResults($sqlddlist4);
                  foreach ($myddlist4 as $ddlistpname4) {
                ?>
                    <option value="dss_summ.php?pid=<?php echo $ddlistpname4['patientid']; ?>">
                      <?php echo $ddlistpname4['lastname'].", ".$ddlistpname4['firstname']." ".$ddlistpname4['middlename']; ?>
                    </option>
                <?php  
                  }
                ?>                
              </select>
              <br />
            </form>  
            
            <div style="margin-top:25px;  width:100%;">&nbsp;</div> 
              <hr />
            <div style="margin-top:0px; width:100%;">&nbsp;</div>  
          </div>
        </td>
        <td valign="top">
          <div style="width:660px; float:right; margin-left:5px;">
            <ul style="list-style-type:none;">
              <li><a style="font-size:16px; font-weight:bold;" href="manage_contact.php">Contacts</a></li>
              <li><a style="font-size:16px; font-weight:bold;" href="manage_staff.php">Staff</a></li>
              <li><a style="font-size:16px; font-weight:bold;" href="manage_referredby.php">Referrers</a></li>
              <li><a style="font-size:16px; font-weight:bold;" href="manage_fcontact.php">Corporate Contacts</a></li>
            </ul>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <div id="popupMemo" style="width:750px; z-index:9999; display:none; height:400px;">
      <a id="popupContactClose">
        <button>X</button>
      </a>
      <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
  </div> 

  <div id="popupContact" style="width:750px; display:none; height:400px;">
      <a id="popupContactClose">
        <button>X</button>
      </a>
      <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
  </div> 

  <div id="backgroundPopup"></div>

  <br /><br />

<?php include 'includes/bottom.htm';?> 