<?php
session_start();
require_once('../manage/admin/includes/config.php');
if(!isset($_SESSION['screener_doc'])){
  ?>
	<script type="text/javascript">
		window.location = 'login.php';
	</script>
  <?php
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Dental Sleep Solutions :: Screener</title>
    <link rel="stylesheet" href="css/lagu.css" />
<script type="text/javascript" src="../manage/admin/script/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="../manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
			<script type="text/javascript" src="../reg/lib/fancybox/jquery.easing-1.3.pack.js"></script>
			<script type="text/javascript" src="../reg/lib/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="script/screener.js"></script>
    <script type="text/javascript" src="../manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
    <script type="text/javascript" src="script/screener_masks.js"></script>
<link rel="stylesheet" href="css/screener.css" />
<link rel="stylesheet" href="../manage/admin/css/jquery-ui-1.8.22.custom.css" />
<link rel="stylesheet" href="../reg/lib/fancybox/jquery.fancybox-1.3.4.css" type="text/css" />
<!--[if IE]>
        <link rel="stylesheet" type="text/css" href="css/style_ie.css" />
<![endif]-->
</head>
<body class="fixed">
    <div id="header" >
        <div class="wrapper cf">
            <div class="logo fl">
                <h1>Dental Sleep Solutions</h1>
            </div>
            <ul id="main_nav" class="fr">
                                <li class="nav_item lgutipT" title="start over" style="display:none;" id="restart_nav"><a href="index.php" class="main_link" onclick="return confirm('Are you sure? All current progress will be lost.');"><img class="img_holder" style="background-image: url(images/images/icons/refresh.png)" alt="" src="images/blank.gif"/><span>Reset and Start Over</span></a></li>

                                <li class="nav_item lgutipT" title="Log Out"><a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="main_link"><img class="img_holder" style="background-image: url(images/icons/locked2.png)" alt="" src="images/blank.gif"/><span>Log Out</span></a></li>

            </ul>

	</div>
    </div>
    <div id="main">
        <div class="wrapper cf">
            <div class="cf brdrrad_a" id="main_section">
<form class="formEl_a register">
<input type="hidden" id="docid" name="docid" value="<?= $_SESSION['screener_doc']; ?>" />
<input type="hidden" id="userid" name="userid" value="<?= $_SESSION['screener_user']; ?>" />

<div class="sect" id="sect0">
<div class="dp100">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
                                                                                                        <p style="font-size:14px;"></p>


<?php
  $sql = "SELECT * FROM dental_screener where id='".mysql_real_escape_string($_GET['id'])."'";
  $q = mysql_query($sql);
  $r = mysql_fetch_assoc($q);
?>
<p>Please enter your information to complete this brief health assessment.</p>
<br />

<div class="sepH_b" id="email_div">
        <label class="lbl_a">Email</label>
        <input class="inpt_a" type="text" id="email" name="email" value="" />
</div>

<div class="sepH_b" id="ins_div">
        <label class="lbl_a">PPO Medical Insurance Company</label>
        <input class="inpt_a" type="text" id="ins" name="ins" value="" />
</div>

<div class="sepH_b" id="ins_id_div">
        <label class="lbl_a">ID#</label>
        <input class="inpt_a" type="text" id="ins_id" name="ins_id" value="" />
</div>

<div class="sepH_b" id="group_div">
        <label class="lbl_a">Group#</label>
        <input class="inpt_a" type="text" id="group" name="group" value="" />
</div>


                                                                                                                <div class="cf">
<a href="#" onclick="validate_register_0()" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>

</div>
<div class="clear"></div>
</div>


<div class="sect" id="sect1">
<div class="dp100">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>




<div class="sepH_b" id="gender_div">
        <label class="lbl_a">Gender</label>
        <div class="buttonset">
        <input type="radio" id="gender1" name="gender" value="Male" /><label for="gender1">Male</label>
        <input type="radio" id="gender2" name="gender" value="Female" /><label for="gender2">Female</label>
        </div>
</div>

<div class="sepH_b" id="weight_div">
        <label class="lbl_a">Weight</label>
        <input class="inpt_a" type="text" id="weight" name="weight" value="" />
</div>

<div class="sepH_b" id="height_div">
        <label class="lbl_a">Height</label>
        <input class="inpt_a" type="text" id="height" name="height" value="" />
</div>

<div class="sepH_b" id="neck_div">
        <label class="lbl_a">Neck Size</label>
        <input class="inpt_a" type="text" id="neck" name="neck" value="" />
</div>



                                                                                                                <div class="cf">
<a href="#" onclick="validate_register_1()" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>

</div>
<div class="clear"></div>
</div>


<div class="sect" id="sect2">
<div class="dp100">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>



  <div class="sepH_b" id="disorder_div">
        <div class="buttonset">
        <input type="radio" id="disorder1" name="disorder" value="8" /><label for="disorder1">Yes</label>
        <input type="radio" id="disorder2" name="disorder" value="0" /><label for="disorder2">No</label>
        </div>
        <label class="question">Have you ever been diagnosed with a sleep disorder?</label>
  </div>
  <div class="sepH_b" id="cpap_div">
        <div class="buttonset">
        <input type="radio" id="cpap1" name="cpap" value="8" /><label for="cpap1">Yes</label>
        <input type="radio" id="cpap2" name="cpap" value="0" /><label for="cpap2">No</label>
        </div>
        <label class="question">Are you currently using a CPAP machine</label>
  </div>
  <div class="sepH_b" id="cpap_every_night_div">
        <div class="buttonset">
        <input type="radio" id="cpap_every_night1" name="cpap_every_night" value="8" /><label for="cpap_every_night1">Yes</label>
        <input type="radio" id="cpap_every_night2" name="cpap_every_night" value="0" /><label for="cpap_every_night2">No</label>
        </div>
        <label class="question">If yes, do you use it every night?</label>
  </div>

<br /><br />
  <p class="clear">Please check any conditions for which you have been medically diagnosed or treated.</p>
  <div class="field half">
        <input type="checkbox" name="rx_heart_failure" value="1" />
        <label>Heart Failure</label>
  </div>
   <div class="field half">
        <input type="checkbox" name="rx_stroke" value="1" />
        <label>Stroke</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_hypertension" value="1" />
        <label>Hypertension</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_diabetes" value="1" />
        <label>Diabetes</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_metabolic_syndrome" value="1" />
        <label>Metabolic Syndrome</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_obesity" value="1" />
        <label>Obesity</label>
  </div>
  <div class="field half">
        <input type="checkbox" name="rx_heartburn" value="1" />
        <label>Heartburn (Gastroesophageal Reflux)</label>
  </div>

                                                                                                                <div class="cf">
<a href="#" onclick="validate_register_2()" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>

</div>
<div class="clear"></div>
</div>


<div class="sect" id="sect3">
<div class="dp100">
<h3 class="sepH_a">Dental Sleep Solutions - Patient Health Assessment</h3>
<div class="sepH_b" id="address_div">
        <label class="lbl_a">Address</label>
        <input class="inpt_a" type="text" id="address" name="address" value="" />
</div>

<div class="sepH_b" id="city_div">
        <label class="lbl_a">City</label>
        <input class="inpt_a" type="text" id="city" name="city" value="" />
</div>

<div class="sepH_b" id="state_div">
        <label class="lbl_a">State</label>
        <input class="inpt_a" type="text" id="state" name="state" value="" />
</div>

<div class="sepH_b" id="zip_div">
        <label class="lbl_a">Zip</label>
        <input class="inpt_a" type="text" id="zip" name="zip" value="" />
</div>

                                                                                                                <div class="cf">
<a href="#" onclick="validate_register_3()" class="fr next btn btn_large btn_d">Proceed &raquo;</a>
                                                                                                                </div>
</div>
<div class="clear"></div>
</div>

</form>

<div class="sect" id="sectfinish">
<h5 style="float:right;">Health Assessment - <span class="assessment_name"></span></h5>
<h3>Thank you for registering</h3>

<p id="result_body"></p>

<a rel="fancyReg" href="#regModal" class="fr next btn btn_medium btn_d">Finished - Click Here</a>
						<div style="display:none">
							<div id="regModal">
								<h4 class="sepH_a">Survey Complete</h4>
								<p class="sepH_c">Thank you for completing the registration.</p>
								<a href="index.php" id="finish_ok" class="btn btn_d">OK</a>
							</div>
						</div>
   </div>
  </div>
</div>

          </div>
<div style="clear:both;"></div>

        </div>
    </div>

    <!-- footer section -->
    <div id="footer">
        <div class="wrapper">
            <span class="fr">Copyright Dental Sleep Solutions 2012</span>
        </div>
    </div>
<script>
        $(function() {
                $(".buttonset").buttonset();
        });
        </script>

  </body>
</html>

