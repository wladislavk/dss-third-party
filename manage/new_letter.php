<?php include 'includes/top.htm';

function trigger_letter1($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '1';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		?>
		<script type="text/javascript">
			alert("<?= $letter; ?>");
		</script>
		<?php
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}
 
function trigger_letter2($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '2';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 2: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter3($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '3';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 3: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter4($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '4';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 4: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter5($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '5';
	if ($send_method = "") {
		$send_method = 'email';
	}
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 5: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter6($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '6';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 6: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter7($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '7';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 7: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter8($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '8';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 8: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter9($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '9';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 9: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter10($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '10';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 10: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter11($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '11';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 11: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter12($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '12';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 12: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter13($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '13';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 13: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter14($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '14';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 14: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter15($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '15';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 15: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter16($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '16';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method, '', '', false);
	if (!is_numeric($letter)) {
		print "Can't send letter 16: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter17($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '17';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 17: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter18($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '18';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 18: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter19($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '19';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method, '', '', false);
	if (!is_numeric($letter)) {
		print "Can't send letter 19: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter20($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '20';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 20: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter21($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '21';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 21: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter22($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '22';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 22: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter23($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '23';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 23: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter24($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '24';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 24: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter25($pid, $topatient, $md_referral_list, $md_list, $send_method) {
	$letterid = '25';
	$letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
	if (!is_numeric($letter)) {
		print "Can't send letter 25: " . $letter;
		die();
	} else {
		?>
		<script type="text/javascript">
			//parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>';		
		</script>	
		<?php
		die();
	}
}

function trigger_letter99($pid, $topatient, $md_referral_list, $md_list, $send_method) {
        $letterid = '99';
        $letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
        if (!is_numeric($letter)) {
                print "Can't send letter 99: " . $letter;
                die();
        } else {
                ?>
                <script type="text/javascript">
                        parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';                
                </script>
                <?php
                die();
        }
}

function trigger_letter126($pid, $topatient, $md_referral_list, $md_list, $send_method) {
        $letterid = '126';
        $letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
        if (!is_numeric($letter)) {
                print "Can't send letter 126: " . $letter;
                die();
        } else {
                ?>
                <script type="text/javascript">
			parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';
                </script>
                <?php
                die();
        }
}

function trigger_letter178($pid, $topatient, $md_referral_list, $md_list, $send_method) {
        $letterid = '178';
        $letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method);
        if (!is_numeric($letter)) {
                print "Can't send letter 178: " . $letter;
                die();
        } else {
                ?>
                <script type="text/javascript">
                        parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';
                </script>
                <?php
                die();
        }
}


function trigger_letter($letterid, $pid, $topatient, $md_referral_list, $md_list, $send_method) {
	if($letterid[0]=='C'){
	  $template_type = 1;
	  $letterid = substr($letterid, 1);
	}else{
	  $template_type = 0;
	}
	if($letterid=='16' || $letterid=='19'){
		$check_recipient = false;
	}else{
		$check_recipient = true;
	}
	
        $letter = create_letter($letterid, $pid, '', $topatient, $md_list, $md_referral_list, '', '', '', $send_method, null, null, $check_recipient, $template_type);
        if (!is_numeric($letter)) {
                print "Can't send letter ".$letterid.": " . $letter;
                die();
        } else {
                ?>
                <script type="text/javascript">
                        parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=new_letter';                
                </script>
                <?php
                die();
        }
}



if (isset($_POST['submit'])) {
	$templateid = $_POST['template'];
	$patientid = $_POST['patient'];
	$topatient = (!empty($_POST['contacts']['patient']) ? true : false);
	$md_referrals = $_POST['contacts']['md_referrals'];
	$mds = $_POST['contacts']['mds'];
	$send_method = $_POST['send_method'];
	foreach ($md_referrals as $id) {
		$md_referral_list .= $id . ",";
	}
	if ($mds) {
		foreach ($mds as $id) {
			$md_list .= $id . ",";
		}
	}
	$md_referral_list = rtrim($md_referral_list, ",");
	$md_list = rtrim($md_list, ",");
	

	trigger_letter($templateid, $patientid, $topatient, $md_referral_list, $md_list, $send_method);

	/*switch ($templateid) {
		case 1:
			trigger_letter1($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 2:
			trigger_letter2($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 3:
			trigger_letter3($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 4:
			trigger_letter4($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 5:
			trigger_letter5($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 6:
			trigger_letter6($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 7:
			trigger_letter7($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 8:
			trigger_letter8($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 9:
			trigger_letter9($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 10:
			trigger_letter10($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 11:
			trigger_letter11($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 12:
			trigger_letter12($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 13:
			trigger_letter13($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 14:
			trigger_letter14($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 15:
			trigger_letter15($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 16:
			trigger_letter16($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 17:
			trigger_letter17($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 18:
			trigger_letter18($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 19:
			trigger_letter19($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 20:
			trigger_letter20($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 21:
			trigger_letter21($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 22:
			trigger_letter22($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 23:
			trigger_letter23($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 24:
			trigger_letter24($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
		case 25:
			trigger_letter25($patientid, $topatient, $md_referral_list, $md_list, $send_method);
			break;
                case 99:
                        trigger_letter99($patientid, $topatient, $md_referral_list, $md_list, $send_method);
                        break;
                case 126:
                        trigger_letter126($patientid, $topatient, $md_referral_list, $md_list, $send_method);
                        break;
                case 178:
                        trigger_letter178($patientid, $topatient, $md_referral_list, $md_list, $send_method);
                        break;


		default:
			break;
	}*/
}

?>

<script type="text/javascript">
	$(document).ready(function(){
		$('#template').change(function(){
			if ($(this).val() == 5) {
				$("#send_method option[value=email]").attr('selected','selected');
				$("#send_method option[value=]").hide();
				$("#send_method option[value=paper]").hide();
				$("#send_method option[value=fax]").hide();
			} else {
				$("#send_method option[value=]").show().attr('selected','selected');
				$("#send_method option[value=paper]").show();
				$("#send_method option[value=fax]").show();				
			}
		});
		$('#template').change(function(){
			if ($(this).val() == "") {
				alert("You must select a template.");
			} else {
				sendValues($('#template').val(), <?=$_GET['pid'];?>);
			}
		});
    $('#send_method').change(function(){
			if ($('#template').val() == "") {
				alert("You must select a template.");
			}
			$('.json_contact').each(function() {
				$(this).find('input').removeAttr('disabled');
			});
			if ($(this).val() == "fax") {
				checkContacts("fax");
      }
			if ($(this).val() == "email") {
				checkContacts("email");
      }
    });
		$('#default_contacts').click(function(){
			if ($(this).attr('checked') && $('#template').val() == "1") {
				$('.md_checkbox').each(function() {
					$(this).attr('checked', true);
				});
			}
		});
		$('#submit').click(function(){
			if ($('#template').val() == "") {
				alert("You must select a letter template.");
				return false;
			} if ($('#patient').val() == "") {
				alert("You must select a patient.");
				return false;
			}
			var one_selected = false;
			$('.patient_checkbox').each(function() {
				if ($(this).attr('checked')) {
					one_selected = true;
				}
			});
			$('.md_referral_checkbox').each(function() {
				if ($(this).attr('checked')) {
					one_selected = true;
				}
			});
			$('.md_checkbox').each(function() {
				if ($(this).attr('checked')) {
					one_selected = true;
				}
			});
			if (one_selected != true) {
				alert("You must select at least one contact.");
				return false;
			}
		});
	});
  function checkContacts(method) {
		var errorMsg = '';
		$('.json_contact').each(function() {
			if ($(this).data(method) == null || $(this).data(method)=='') {
				var name = $(this).data('name');
        if (method == 'fax') {
					 errorMsg += name + " doesn't have a " + method + " number.\n";
        } else if (method == 'email') {
					 errorMsg += name + " doesn't have an " + method + " address.\n";
 				}
				$(this).find('input').removeAttr('checked');
				$(this).find('input').attr('disabled', 'disabled');
			}else{
			}
		});
		if (errorMsg != '') {
			//alert(errorMsg);
		}
  }
	function sendValues(templateid, patientid) {
		$.post(
		
		"new_letter_contacts.php",

		{ 
			"templateid": templateid,
			"patientid": patientid 
		},

		function(data) {
			$('.json_contact').remove();
			$('#contact_header').css('display', 'table-cell');
      for (i in data) {
				if (data[i]['type'] == 'patient') {
					var newDiv = $('#contacts .patient_template')
						.clone(true)
						.removeClass('patient_template')
						.addClass('json_contact')
						.attr('id', 'contact'+i)
						.data('name', data[i]['name'])
						.data('fax', data[i]['fax'])
						.data('email', data[i]['email']);
					template_div(newDiv, i, data[i])
						.appendTo('#contacts')
						.fadeIn();
 				}
				if (data[i]['type'] == 'md_referral') {
					var newDiv = $('#contacts .md_referral_template')
						.clone(true)
						.removeClass('md_referral_template')
						.addClass('json_contact')
						.attr('id', 'contact'+i)
						.data('name', data[i]['name'])
						.data('fax', data[i]['fax'])
						.data('email', data[i]['email']);
					template_div(newDiv, i, data[i])
						.appendTo('#contacts')
						.fadeIn();
 				}
				if (data[i]['type'] == 'md') {
					var newDiv = $('#contacts .md_template')
						.clone(true)
						.removeClass('md_template')
						.addClass('json_contact')
						.attr('id', 'contact'+i)
						.data('name', data[i]['name'])
						.data('fax', data[i]['fax'])
						.data('email', data[i]['email']);
					template_div(newDiv, i, data[i])
						.appendTo('#contacts')
						.fadeIn();
 				}
      }
			$('#submit').css("display", "block");
		},

		"json"
		);
	}
  function template_div(div, index, contact) {
		if (contact.type == "patient") {
			div.html("<input class=\"patient_checkbox\" type=\"checkbox\" name=\"contacts[patient]\" value=\"" + contact.id + "\" />Patient: " + contact.name);
    }
		if (contact.type == "md_referral") {
                        if(contact.status==2){
                                div.html("Referring MD: " + contact.name + " (INACTIVE CONTACT - UNABLE TO SEND LETTERS)");
                        }else{
				div.html("<input class=\"md_referral_checkbox\" type=\"checkbox\" name=\"contacts[md_referrals][" + index + "]\" value=\"" + contact.id + "\" />Referring MD: " + contact.name);
			}
		}
		if (contact.type == "md") {
			if(contact.status==2){
				div.html(contact.label+": " + contact.name + " (INACTIVE CONTACT - UNABLE TO SEND LETTERS)");	
			}else{
				div.html("<input class=\"md_checkbox\" type=\"checkbox\" name=\"contacts[mds][" + index + "]\" value=\"" + contact.id + "\" />"+contact.label+": " + contact.name);
			}
		}
		return div;
  }
</script>
<div style="padding-left:25px;">
	<H1 class="blue">Create New Letter</H1>
</div>
<form name="create_letter" action="/manage/new_letter.php?pid=<?php print $_GET['pid']; ?>" method="post">
  <input name="patient" type="hidden" value="<?php print $_GET['pid']; ?>" />
	<table style="margin-left:25px; width=100%;">
		<tr>
			<td>Select a letter template: <select id="template" name="template">
				<option value=""></option>
				<?php
				$templates = "SELECT 
						'default' as template_type,
						t.id, 
						t.name, 
						ct.triggerid 
					FROM dental_letter_templates  t 
                        		INNER JOIN dental_letter_templates ct ON ct.triggerid = t.id
                        		WHERE ct.companyid='".$_SESSION['companyid']."' AND
						t.default_letter=1 
				UNION
					SELECT 
						'custom',
						c.id,
						c.name,
						''
					FROM dental_letter_templates_custom c
						WHERE c.status=1 AND c.docid = '".mysqli_real_escape_string($con, $_SESSION['docid'])."'

				ORDER BY template_type ASC, id ASC
						;";
				$result = mysql_query($templates);
				while ($row = mysql_fetch_assoc($result)) {
					//DO NOT SHOW LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
      					if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $row['triggerid']!=1){
					  print "<option value=\"" . (($row['template_type']=='custom')?'C':'').$row['id'] . "\">" . (($row['template_type']=='custom')?'C':'').$row['id'] . " - " . $row['name'] . "</option>";
					}
				}
				?>
				</select>
			</td>
			<td style="padding-left: 20px;">Method of Sending: <select id="send_method" name="send_method">
					<option value="">Default Preferred</option>
					<option value="paper">Paper Mail</option>
					<option value="email">Email</option>
					<option value="fax">Fax</option>
				</select>
			</td>
		</tr>
		<tr>
			<td id="contact_header" style="display:none;">Select Contacts:<br /><!--<input id="default_contacts" type="checkbox" name="defaults" value="defaults" />Default Contacts<br />--></td>
		</tr>
		<tr>
			<td id="contacts">
				<div class="patient_template" style="display: none;"><input type="checkbox" />Patient: Mr. John Doe</div>
				<div class="md_referral_template" style="display: none;"><input type="checkbox" />Referring MD: Dr. John Doe</div>
				<div class="md_template" style="display: none;"><input type="checkbox" />MD: Dr. John Doe</div>  
			</td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td><input style="display:none;margin-top:25px;" id="submit" type="submit" name="submit" value="Create Letter" class="addButton"></td>
		</tr>
	<table>
</form>



<?php include 'includes/bottom.htm'; ?>
