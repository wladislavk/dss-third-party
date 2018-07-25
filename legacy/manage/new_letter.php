<?php
namespace Ds3\Libraries\Legacy;

include 'includes/top.htm';

function trigger_letter($letterid, $pid, $topatient, $md_referral_list, $md_list, $send_method)
{
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
        echo "Can't send letter ".$letterid.": " . $letter;
        trigger_error("Die called", E_USER_ERROR);
    } else {
        ?>
        <script type="text/javascript">
            parent.window.location='/manage/edit_letter.php?pid=<?=$pid?>&lid=<?=$letter?>&goto=letter';
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }
}

$db = new Db();

if (isset($_POST['submit'])) {
    $templateid = $_POST['template'];
    $patientid = $_POST['patient'];
    $topatient = (!empty($_POST['contacts']['patient']) ? true : false);
    $md_referrals = $_POST['contacts']['md_referrals'];
    $mds = $_POST['contacts']['mds'];
    $send_method = $_POST['send_method'];
    if ($md_referrals) {
        foreach ($md_referrals as $id) {
            $md_referral_list .= $id . ",";
        }
    } else {
        $md_referral_list = '';
    }
    if ($mds) {
        foreach ($mds as $id) {
            $md_list .= $id . ",";
        }
    }
    $md_referral_list = rtrim($md_referral_list, ",");
    $md_list = rtrim($md_list, ",");

    trigger_letter($templateid, $patientid, $topatient, $md_referral_list, $md_list, $send_method);
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
        if (method === 'fax') {
                     errorMsg += name + " doesn't have a " + method + " number.\n";
        } else if (method === 'email') {
                     errorMsg += name + " doesn't have an " + method + " address.\n";
                }
                $(this).find('input').removeAttr('checked');
                $(this).find('input').attr('disabled', 'disabled');
            }
        });
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
            if (data[i]['type'] === 'patient') {
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
            if (data[i]['type'] === 'md_referral') {
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
                if (data[i]['type'] === 'md') {
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
        if (contact.type === "patient") {
            div.html("<input id=\"contact"+contact.id+"\" class=\"patient_checkbox\" type=\"checkbox\" name=\"contacts[patient]\" value=\"" + contact.id + "\" />Patient: " + contact.name);
    }
        if (contact.type === "md_referral") {
                        if(contact.status==2){
                                div.html("Referring MD: " + contact.name + " (INACTIVE CONTACT - UNABLE TO SEND LETTERS)");
                        }else{
                div.html("<input id=\"contact"+contact.id+"\" class=\"md_referral_checkbox\" type=\"checkbox\" name=\"contacts[md_referrals][" + index + "]\" value=\"" + contact.id + "\" />Referring MD: " + contact.name);
            }
        }
        if (contact.type === "md") {
            if(contact.status==2){
                div.html(contact.label+": " + contact.name + " (INACTIVE CONTACT - UNABLE TO SEND LETTERS)");
            }else{
                div.html("<input id=\"contact"+contact.id+"\" class=\"md_checkbox\" type=\"checkbox\" name=\"contacts[mds][" + index + "]\" value=\"" + contact.id + "\" />"+contact.label+": " + contact.name);
            }
        }
        return div;
  }
</script>
<div style="padding-left:25px;">
    <h1 class="blue">Create New Letter</h1>
</div>
<form name="create_letter" action="/manage/new_letter.php?pid=<?php echo $_GET['pid']; ?>" method="post">
    <input name="patient" type="hidden" value="<?php echo $_GET['pid']; ?>" />
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
                    WHERE ct.companyid='".$_SESSION['companyid']."' AND t.default_letter=1 
                UNION
                    SELECT 
                        'custom',
                        c.id,
                        c.name,
                        ''
                    FROM dental_letter_templates_custom c
                        WHERE c.status=1 AND c.docid = '".$db->escape( $_SESSION['docid'])."'

                ORDER BY template_type ASC, id ASC
                        ;";
                $result = mysqli_query($con, $templates);
                while ($row = mysqli_fetch_assoc($result)) {
                    //DO NOT SHOW LETTER 1 (FROM DSS) FOR USER TYPE SOFTWARE
                    if($_SESSION['user_type'] != DSS_USER_TYPE_SOFTWARE || $row['triggerid']!=1){
                        echo "<option value=\"" . (($row['template_type']=='custom')?'C':'').$row['id'] . "\">" . (($row['template_type']=='custom')?'C':'').$row['id'] . " - " . $row['name'] . "</option>";
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
            <td id="contact_header" style="display:none;">Select Contacts:<br /></td>
        </tr>
        <tr>
            <td id="contacts">
                <div class="patient_template" style="display: none;"><input type="checkbox" />Patient: Mr. John Doe</div>
                <div class="md_referral_template" style="display: none;"><input type="checkbox" />Referring MD: Dr. John Doe</div>
                <div class="md_template" style="display: none;"><input type="checkbox" />MD: Dr. John Doe</div>
            </td>
        </tr>
        <tr>
            <td><input style="display:none;margin-top:25px;" id="submit" type="submit" name="submit" value="Create Letter" class="addButton"></td>
        </tr>
    </table>
</form>
<?php include 'includes/bottom.htm'; ?>
