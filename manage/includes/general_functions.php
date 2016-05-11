<?php
namespace Ds3\Libraries\Legacy;

define('SHARED_FOLDER', __DIR__ . '/../../../../shared/');
define('Q_FILE_FOLDER', SHARED_FOLDER . '/q_file/');

require_once __DIR__ . '/constants.inc';
require_once __DIR__ . '/../../reg/twilio/Services/Twilio.php';

function generateApiToken($idOrEmail) {
    $apiPath = env('API_PATH');
    $phpPath = env('PHP_PATH');

    if ($apiPath && $phpPath) {
        $idOrEmail = escapeshellarg($idOrEmail);
        return exec("$phpPath {$apiPath}/artisan jwt:token {$idOrEmail}");
    }

    return '';
}

function apiToken() {
  return isset($_SESSION['api_token']) ? $_SESSION['api_token'] : '';
}

function adminApiToken () {
    return isset($_SESSION['admin_api_token']) ? $_SESSION['admin_api_token'] : '';
}

function secureSessionStart() {
    $domain = 'example.com'; // note $domain
    $session_name = 'sec_session_id'; // Set a custom session name
    $secure = true; // Set to true if using https.
    $httponly = true; // This stops javascript being able to access the session id.
    ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies.
    $cookieParams = session_get_cookie_params(); // Gets current cookies params.
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $domain, $secure, $httponly); // note $domain
    session_name($session_name); // Sets the session name to the one set above.
    session_start(); // Start the php session
    session_regenerate_id(true); // regenerated the session, delete the old one.
}

function isSharedFile ($name) {
    return strlen($name) && is_file(Q_FILE_FOLDER . $name);
}

function isFaultyUpload ($uploadError) {
    return !in_array($uploadError, array(UPLOAD_ERR_OK, UPLOAD_ERR_NO_FILE));
}

function uploadImage($image, $file_path, $type = 'general'){
  $uploadedfile = $image['tmp_name'];
  $fname = $image["name"];
  $lastdot = strrpos($fname,".");
  $name = substr($fname,0,$lastdot);
  $filesize = $image["size"];
  $extension = substr($fname,$lastdot+1);
  list($width,$height)=getimagesize($uploadedfile);
  if(($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT) || $filesize > DSS_IMAGE_MAX_SIZE
		|| ($type == 'profile' && ($width >DSS_IMAGE_PROFILE_WIDTH || $height>DSS_IMAGE_PROFILE_HEIGHT))
                || ($type == 'device' && ($width >DSS_IMAGE_DEVICE_WIDTH || $height>DSS_IMAGE_DEVICE_HEIGHT))
		 ){

    if(strtolower($extension)=="jpg" || strtolower($extension)=="jpeg" )
    {
      $src = @imagecreatefromjpeg($uploadedfile);
    }
    elseif(strtolower($extension)=="png")
    {
      $src = @imagecreatefrompng($uploadedfile);
    }
    else
    {
      $src = @imagecreatefromgif($uploadedfile);
    }

      if (!$src) {
          // What if we cannot read the tmp file?
          error_log('Image upload: invalid image extension, attempting to read from string');
          $src = @imagecreatefromstring(file_get_contents($uploadedfile));
      }

      if (!$src) {
          error_log('Image upload: invalid image type, or unable to read the uploaded file');
          return false;
      }

    if(($width>DSS_IMAGE_MAX_WIDTH || $height>DSS_IMAGE_MAX_HEIGHT)
		|| ($type == 'profile' && ($width >DSS_IMAGE_PROFILE_WIDTH || $height>DSS_IMAGE_PROFILE_HEIGHT))
		|| ($type == 'device' && ($width >DSS_IMAGE_DEVICE_WIDTH || $height>DSS_IMAGE_DEVICE_HEIGHT))
		 ){
	if($type=='profile'){
	$resize_width = DSS_IMAGE_PROFILE_WIDTH;
	$resize_height = DSS_IMAGE_PROFILE_HEIGHT;
	}elseif($type=='device'){
        $resize_width = DSS_IMAGE_DEVICE_WIDTH;
        $resize_height = DSS_IMAGE_DEVICE_HEIGHT;
        }else{
        $resize_width = DSS_IMAGE_RESIZE_WIDTH;
        $resize_height = DSS_IMAGE_RESIZE_HEIGHT;
        }
        $prop_width = $width/$resize_width;
        $prop_height = $height/$resize_height;
        if($prop_width>$prop_height){
      	  $newwidth=$resize_width;
      	  $newheight=($height/$width)*$newwidth;
    	}elseif($prop_height>$prop_width){
      	  $newheight=$resize_height;
      	  $newwidth=($width/$height)*$newheight;
    	}else{
      	  $newwidth=$resize_width;
      	  $newheight=$resize_height;
    	}
    }else{
	$newwidth = $width;
	$newheight = $height;
    }
    //$newwidth=DSS_IMAGE_MAX_WIDTH;
    //$newheight=($height/$width)*$newwidth;
    $tmp=imagecreatetruecolor($newwidth,$newheight);
    imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
    if($extension=="jpg" || $extension=="jpeg" )
    {
    imagejpeg($tmp,$file_path,60);
    }
    elseif($extension=="png")
    {
      imagepng($tmp,$file_path,6);
    }
    else
    {
      imagegif($tmp,$file_path,60);
    }
    $uploaded = true;
    if(filesize($file_path) > DSS_FILE_MAX_SIZE){
      @unlink($file_path);
      $uploaded = false;
    }
    imagedestroy($src);
    imagedestroy($tmp);

  }else{
    if( ($image['size'] > 0 && $image['size'] <= DSS_FILE_MAX_SIZE) ){

      @move_uploaded_file($image["tmp_name"],$file_path);
      $uploaded = true;

    }else{
      $uploaded =false;
    }
  }

  if ($uploaded) {
    @chmod($file_path,0777);

    // Ensure the file really exists
    $uploaded = file_exists($file_path);

    if (!$uploaded) {
      error_reporting("Upload Image: failed to save $file_path");
      error_reporting('Upload Image: $_FILES data - ' . json_encode($_FILES));
    }
  }

  return $uploaded;
}

/**
 * Retrieve template from the template folder
 *
 * @param string $filename
 * @return string
 */
function getTemplate ($filename) {
    $templatePath = __DIR__ . '/../admin/includes/templates';

    $sections = explode('/', $filename);
    $sections = array_filter($sections);
    $sections = preg_replace('/[^a-z0-9_-]+/', '', $sections);

    $filename = join('/', $sections);

    if (!file_exists("$templatePath/$filename.tpl")) {
        return '';
    }

    return file_get_contents("$templatePath/$filename.tpl");
}

/**
 * Mini template engine, for easy variable replacement.
 *
 * @param string $template
 * @param array  $variables
 * @param bool   $escapeHtml
 * @return string
 */
function parseTemplate ($template, Array $variables=[], $escapeHtml=true) {
    if (!isset($variables['baseUrl'])) {
        $variables['baseUrl'] = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
    }

    $escapeList = [
        '--' => $variables,
        '{}' => $escapeHtml ? array_map('\htmlspecialchars', $variables) : $variables,
        '%%' => array_map('\rawurlencode', $variables),
    ];

    foreach ($escapeList as $delimiter=>$variableList) {
        $left = preg_quote('{' . $delimiter{0});
        $right = preg_quote($delimiter{1} . '}');

        $regex = "/(?<replacements>$left(?<keys>[a-z0-9_\-]+)$right)/i";

        if (!preg_match_all($regex, $template, $matches)) {
            continue;
        }

        $replacements = array_map(function ($key) use ($variableList) {
            return array_get($variableList, $key, '');
        }, $matches['keys']);

        $template = str_replace($matches['replacements'], $replacements, $template);
        $template = preg_replace($regex, '', $template);
    }

    return $template;
}

/**
 * Save email activity, for debug purposes
 *
 * @param string $from
 * @param string $to
 * @param string $subject
 * @param string $body
 * @param string $headers
 */
function logEmailActivity ($from, $to, $subject, $body, $headers) {
    $db = new Db();
    $emailData = [
        'from' => $from,
        'to' => $to,
        'subject' => $subject,
        'body' => $body,
        'headers' => $headers
    ];

    if (config('app.debug') && config('app.debugEmail')) {
        error_log("sendEmail debug information:");
        error_log(json_encode($emailData));
    }

    $emailData = $db->escapeAssignmentList($emailData);
    $db->query("INSERT INTO dental_email_log SET $emailData, created_at = NOW()");
}

/**
 * Centralized place to send emails.
 *
 * The function will create a multipart email from either an HTML template, or an array of html/text templates.
 *
 * @param string       $from
 * @param string       $to
 * @param string       $subject
 * @param string|array $template
 * @param array        $variables
 * @param array        $extraHeaders
 * @return bool
 */
function sendEmail ($from, $to, $subject, $template, Array $variables=[], Array $extraHeaders=[]) {
    $newLine = "\n";
    $boundary = uniqid('ds3');
    $returnPath = preg_replace('/^.*?<(.+?)>$/', '$1', $from);
    $htmlContentType = 'Content-Type: text/html; charset=UTF-8';

    $headers = [
            "From: $from",
            "Reply-To: $from",
            "Return-Path: $returnPath",
            'X-Mailer: Dental Sleep Solutions Mailer',
            'MIME-Version: 1.0',
            "Content-Type: multipart/alternative; boundary=$boundary",
            'Date: '.date('n/d/Y g:i A'),
        ] + $extraHeaders;
    $headers = join($newLine, $headers) . $newLine;

    if (is_array($template)) {
        if (!isset($template['text']) && !isset($template['html'])) {
            throw new \RuntimeException('sendEmail requires the html or the text version of the message.');
        }

        $textBody = (string)array_get($template, 'text');
        $htmlBody = (string)array_get($template, 'html');
    } else {
        $htmlBody = (string)$template;
    }

    $htmlBody = tidyHtml($htmlBody);

    if (!isset($textBody) || !strlen($textBody)) {
        $textBody = \Html2Text\Html2Text::convert($htmlBody);
    }

    if ($variables) {
        $htmlBody = parseTemplate($htmlBody, $variables, true);
        $textBody = parseTemplate($textBody, $variables, true);
    }

    $body = $textBody .
        $newLine .
        $newLine .
        "--$boundary" .
        $newLine .
        $htmlContentType .
        $newLine .
        $newLine .
        $htmlBody;

    logEmailActivity($from, $to, $subject, $body, $headers);

    return mail($to, $subject, $body, $headers, "-f$returnPath");
}

/**
 * Retrieve patient and mailing doctor details, for patient emails
 *
 * @param int $patientId
 * @return array
 */
function retrieveMailerData ($patientId) {
    $db = new Db();
    $patientId = intval($patientId);

    $patientData = $db->getRow("SELECT *
        FROM dental_patients
        WHERE patientid = '$patientId'");

    $locationId = $db->getColumn("SELECT location
        FROM dental_summary
        WHERE patientid = '$patientId'", 'location');

    if ($locationId) {
        $locationId = intval($locationId);
        $docId = intval($patientData['docid']);

        $locationConditional = "l.id = '$locationId' AND l.docid = '$docId'";
    } else {
        $locationConditional = "l.default_location = 1 AND p.patientid = '$patientId'";
    }

    $mailingData = $db->getRow("SELECT
            l.phone AS mailing_phone,
            u.user_type,
            u.logo,
            l.location AS mailing_practice,
            l.address AS mailing_address,
            l.city AS mailing_city,
            l.state AS mailing_state,
            l.zip AS mailing_zip
        FROM dental_users u
            INNER JOIN dental_patients p ON u.userid = p.docid
            LEFT JOIN dental_locations l ON l.docid = u.userid
        WHERE $locationConditional");

    if ($mailingData['user_type'] == DSS_USER_TYPE_SOFTWARE && isSharedFile($mailingData['logo'])) {
        $mailingData['logo'] = 'manage/display_file.php?f=' . $mailingData['logo'];
    } else {
        $mailingData['logo'] = 'reg/images/email/reg_logo.gif';
    }

    $mailingData['mailing_phone'] = format_phone($mailingData['mailing_phone']);

    return [
        'patientData' => $patientData,
        'mailingData' => $mailingData
    ];
}

/**
 * @param int    $patientId
 * @param string $patientEmail
 * @param bool   $isPasswordReset
 * @param string $oldEmail
 * @param int    $accessType
 * @return bool
 */
function sendRegistrationRelatedEmail ($patientId, $patientEmail, $isPasswordReset=false, $oldEmail='', $accessType=1) {
    $db = new Db();
    $patientId = intval($patientId);
    $accessType = intval($accessType);

    $contactData = retrieveMailerData($patientId);
    $patientData = $contactData['patientData'];
    $mailingData = $contactData['mailingData'];

    if ($isPasswordReset) {
        if ($patientData['recover_hash'] == '' || $patientEmail != $oldEmail) {
            $accessCode = rand(100000, 999999);
            $recoverHash = hash('sha256', $patientData['patientid'] . $patientData['email'] . rand());

            $db->query("UPDATE dental_patients SET
                    text_num = 0,
                    access_type = $accessType,
                    registration_status = 1,
                    access_code = '$accessCode',
                    recover_hash = '$recoverHash',
                    text_date = NOW(),
                    recover_time = NOW(),
                    registration_senton = NOW()
                WHERE patientid = '$patientId'");
        } else {
            $db->query("UPDATE dental_patients SET
                    access_type = $accessType,
                    registration_status = 1,
                    registration_senton = NOW()
                WHERE patientid = '$patientId'");
            $recoverHash = $patientData['recover_hash'];
        }

        $mailingData['patient_id'] = $patientId;
        $mailingData['recover_hash'] = $recoverHash;
        $mailingData['legend'] = '<p>We hope to hear from you soon!</p>';
        $mailingData['link'] = '{{baseUrl}}/reg/activate.php?id={%patient_id%}&amp;hash={%recover_hash%}';
    } else {
        $mailingData['link'] = '{{baseUrl}}/reg/login.php?email={%email%}';
    }

    $mailingData['email'] = $patientEmail;

    $from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
    $to = "{$patientData['firstname']} {$patientData['lastname']} <{$patientEmail}>";
    $subject = 'Online Patient Registration';
    $message = getTemplate('patient/registration');

    return sendEmail($from, $to, $subject, $message, $mailingData);
}

/**
 * Send registration email
 *
 * @param int    $patientId
 * @param string $patientEmail
 * @param mixed  $unusedLogin
 * @param string $oldEmail
 * @param int    $accessType
 * @return bool
 */
function sendRegEmail ($patientId, $patientEmail, $unusedLogin, $oldEmail, $accessType=1) {
    return sendRegistrationRelatedEmail($patientId, $patientEmail, true, $oldEmail, $accessType);
}

/**
 * Send "remember" email
 *
 * @param int    $patientId
 * @param string $patientEmail
 * @return bool
 */
function sendRemEmail ($patientId, $patientEmail) {
    return sendRegistrationRelatedEmail($patientId, $patientEmail, false);
}

/**
 * @param int    $patientId
 * @param string $newEmail
 * @param string $oldEmail
 * @param string $sentBy
 * @return bool
 */
function sendUpdatedEmail ($patientId, $newEmail, $oldEmail, $sentBy) {
    $patientId = intval($patientId);

    if (strtolower(trim($oldEmail)) === strtolower(trim($newEmail))) {
        return false;
    }

    $contactData = retrieveMailerData($patientId);
    $patientData = $contactData['patientData'];
    $mailingData = $contactData['mailingData'];

    $mailingData['old_email'] = $oldEmail;
    $mailingData['new_email'] = $newEmail;
    $mailingData['legend'] = $sentBy === 'doc' ?
        'An update has been made to your account.' : 'You have updated your account.';

    $from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
    $to = "{$patientData['firstname']} {$patientData['lastname']}";
    $subject = 'Online Patient Portal Email Update';
    $message = getTemplate('patient/update');

    $return = sendEmail($from, "$to <$oldEmail>", $subject, $message, $mailingData);
    $return = sendEmail($from, "$to <$newEmail>", $subject, $message, $mailingData) && $return;

    return $return;
}

/**
 * Save SMS activity, for debugging purposes
 *
 * @param string $from
 * @param string $to
 * @param string $text
 * @param string $status
 * @param string $sid
 * @param string $message
 */
function logSMSActivity ($from, $to, $text, $status, $sid, $message='') {
    $db = new Db();
    $smsData = [
        'from' => $from,
        'to' => $to,
        'text' => $text,
        'status' => $status,
        'sid' => $sid,
        'message' => $message
    ];

    if (config('app.debug') && config('app.debugEmail')) {
        error_log("sendSMS debug information:");
        error_log(json_encode($smsData));
    }

    $smsData = $db->escapeAssignmentList($smsData);
    $db->query("INSERT INTO dental_sms_log SET $smsData, created_at = NOW()");
}

/**
 * Send Twilio SMS
 *
 * @param string $to
 * @param string $text
 * @return bool
 */
function sendSMS ($to, $text) {
    $sid = config('app.twilio.sid');
    $token = config('app.twilio.token');
    $from = config('app.twilio.number');
    $sendSMS = config('app.twilio.enabled');

    if (empty($to)) {
        logSMSActivity($from, $to, $text, 'unsent', '', 'No phone number provided');
        return false;
    }

    if (!$sendSMS) {
        logSMSActivity($from, $to, $text, 'unsent', '', 'SMS send disabled');
        return false;
    }

    $smsId = '';
    $message = '';
    $sent = false;

    try {
        $client = new \Services_Twilio($sid, $token);
        $sms = $client->account->sms_messages->create($from, $to, $text);

        if ($sms) {
            $status = $sms->status ?: 'unprocessed';
            $smsId = $sms->sid ?: '';

            $sent = !in_array($status, ['failed', 'undelivered', 'unprocessed', '']);
        } else {
            $status = 'unset';
            $message = 'Twilio failed to retrieve a valid response';
        }
    } catch (\Services_Twilio_RestException $e) {
        $status = 'exception';
        $message = 'Twilio exception: ' . $e->getMessage();
    }

    logSMSActivity($from, $to, $text, $status, $smsId, $message);

    return $sent;
}

/**
 * Send activation code to patient or FO user, via SMS
 *
 * @param string $type
 * @param int    $id
 * @param string $hash
 * @return array
 */
function sendAccessCodeSMS ($type, $id, $hash) {
    $db = new Db();
    $id = intval($id);

    if ($type === 'user') {
        $table = 'dental_users';
        $column = 'userid';

        $data = $db->getRow("SELECT access_code, text_num, text_date, phone
            FROM dental_users
            WHERE userid = '$id'
                AND recover_hash = '" . $db->escape($hash) . "'");
    } else {
        $table = 'dental_patients';
        $column = 'patientid';

        $data = $db->getRow("SELECT access_code, text_num, text_date, cell_phone AS phone
            FROM dental_patients
            WHERE patientid = '$id'
                AND recover_hash = '" . $db->escape($hash) . "'");
    }

    if (!$data) {
        return ['error' => 'found'];
    }

    if ($data['text_num'] >= 5 && strtotime($data['text_date']) > (time() - 3600)) {
        return ['error' => 'limit'];
    }

    if ($data['access_code'] == '' || strtotime($data['access_code_date']) < time() - 86400){
        $recover_hash = rand(100000, 999999);

        $updateData = ['access_code' => $recover_hash];

        if ($type === 'patient') {
            $updateData['registration_status'] = 1;
        }

        $updateData = $db->escapeAssignmentList($updateData);

        $db->query("UPDATE $table SET $updateData, access_code_date = NOW()
            WHERE $column = '$id'");
    } else {
        $recover_hash = $data['access_code'];
    }

    $sent = sendSMS($data['phone'], "Your Dental Sleep Solutions access code is $recover_hash");

    if ($sent) {
        if (strtotime($data['text_date']) < (time() - 3600) || $data['text_num'] == 0) {
            $db->query("UPDATE $table
            SET text_num = 1, text_date = NOW()
            WHERE $column = '$id'");
        } else {
            $db->query("UPDATE $table
            SET text_num = text_num + 1
            WHERE $column = '$id'");
        }

        $response = ['success' => true];
    } else {
        $response = ['error' => 'unsent'];
    }

    return $response;
}

/**
 * Send activation code, lookup by email
 *
 * @param string $type
 * @param string $email
 * @return array
 */
function sendRecoveryCodeSMS ($type, $email) {
    $db = new Db();

    if ($type == 'user') {
        $table = 'dental_users';
        $column = 'userid';

        $data = $db->getRow("SELECT userid AS id, phone, password
            FROM dental_users
            WHERE email = '" . $db->escape($email) . "'");
    } else {
        $table = 'dental_patients';
        $column = 'patientid';

        $data = $db->getRow("SELECT patientid AS id, cell_phone AS phone, password
            FROM dental_patients
            WHERE email = '" . $db->escape($email) . "'");
    }

    if (!$data) {
        return ['error' => 'email'];
    }

    if ($data['password'] != '') {
        return ['error' => 'existing'];
    }

    $id = intval($data[$column]);

    $recover_hash = substr(hash('sha256', $id . $email . rand()), 0, 7);
    $db->query("UPDATE $table
        SET recover_hash = '$recover_hash', recover_time = NOW()
        WHERE $column = '$id'");

    $sent = sendSMS($data['phone'], "Your access code is $recover_hash");

    if ($sent) {
        $response = [
            'success' => true,
            'phone' => substr($data['cell_phone'], -2)
        ];
    } else {
        $response = ['error' => 'number'];
    }

    return $response;
}

function showPatientValue($table, $pid, $f, $pv, $fv, $showValues = true, $show=true, $type="text"){
  if($pv != $fv && $show){
	?>
	<span id="patient_<?= $f; ?>" class="patient_change">
		<?php if($showValues){ ?>
		   <?php if($type=="radio" && $pv=='0'){ ?>
			> No
		   <?php }elseif($type=="radio" && $pv=='1'){ ?>
			> Yes
		   <?php }else{ ?>
			 > <?= $pv; ?>
		   <?php } ?>
		<?php } ?>
                <a href="#" title="Reject" class="reject" onclick="updateQuestionnaire('<?= $table; ?>', '<?= $pid; ?>', '<?= $f; ?>', '<?= $fv; ?>', '<?= $type; ?>'); return false;"></a>
		<a href="#" title="Accept" class="accept" onclick="updateQuestionnaire('<?= $table; ?>', '<?= $pid; ?>', '<?= $f; ?>', '<?= $pv; ?>', '<?= $type; ?>'); return false;"></a>
	</span>
	<script type="text/javascript">
		$('#<?= $f; ?>').addClass('edits');
	</script>
	<?php
  }
}

function num($n, $phone=true){
$n = preg_replace('/\D/', '', $n);
if(!$phone){return $n; }
$pattern = '/([1]*)(.*)/';
preg_match($pattern, $n, $matches);
return $matches[2];
}

function format_phone($data){
if(  preg_match( '/.*(\d{3}).*(\d{3}).*(\d{4}).*(\d*)$/', $data,  $matches ) )
{
    $result = '(' . $matches[1] . ') ' .$matches[2] . '-' . $matches[3];
    if($matches[4]!=''){
      $result .= ' x'.$matches[4];
    }
    return $result;
}
}

function split_phone($num, $a){
        $num = preg_replace("/[^0-9]/", "", $num);
        // preg_match('/([0-1]*)(.*)/',$num, $m);
        // $num = $m[2];
  if($a){
        return substr($num, 0, 3);
  }else{
        return substr($num,3);
  }
  return $num;
}

function dateToTime ($unknownFormatDate, $defaultsNow=false) {
    $dateFormats = ['d-Y-m', 'm-d-y', 'm-d-Y', 'Y-m-d'];
    $timeFormats = ['', ' H:i:s'];
    $parsedDate = null;

    // Use a single delimiter
    $unknownFormatDate = str_replace('/', '-', $unknownFormatDate);

    foreach ($dateFormats as $date) {
        foreach ($timeFormats as $time) {
            $parsedDate = date_create_from_format("{$date}{$time}", $unknownFormatDate);

            if ($parsedDate) {
                break;
            }
        }

        if ($parsedDate) {
            break;
        }
    }

    if (!$parsedDate && $defaultsNow) {
        $parsedDate = date_create();
    }

    $time = $parsedDate ? $parsedDate->getTimestamp() : 0;

    return $time;
}

function dateFormat ($data, $defaultsNow=true) {
  if (!empty($data)) {
      $timestamp = dateToTime($data, $defaultsNow);
      $dateFormat = date('Y-m-d', $timestamp);
  } else {
      $dateFormat = '';
  }

  return $dateFormat;
}

/**
 * Parse phone + area code, as some form will use a single field, while another one will use separated fields
 * Return an array of two elements, each one having the proper amount of digits
 *
 * list($phone_code, $phone_number) = parsePhoneNumber($maybeEmptyAreaCode, $maybeFullPhoneNumber);
 */
function parsePhoneNumber ($areaCodeOrFullNumber, $phoneNumber='') {
    $fullNumber = preg_replace('/\D+/', '', "{$areaCodeOrFullNumber}{$phoneNumber}");

    return [
        substr($fullNumber, 0, 3), // area code
        substr($fullNumber, 3) // local number
    ];
}

function stateList () {
    $stateList = [
        'AL' =>  'Alabama',
        'AK' =>  'Alaska',
        'AS' =>  'American Samoa',
        'AZ' =>  'Arizona',
        'AR' =>  'Arkansas',
        'CA' =>  'California',
        'CO' =>  'Colorado',
        'CT' =>  'Connecticut',
        'DE' =>  'Delaware',
        'DC' =>  'District Of Columbia',
        'FM' =>  'Federated States Of Micronesia',
        'FL' =>  'Florida',
        'GA' =>  'Georgia',
        'GU' =>  'Guam',
        'HI' =>  'Hawaii',
        'ID' =>  'Idaho',
        'IL' =>  'Illinois',
        'IN' =>  'Indiana',
        'IA' =>  'Iowa',
        'KS' =>  'Kansas',
        'KY' =>  'Kentucky',
        'LA' =>  'Louisiana',
        'ME' =>  'Maine',
        'MH' =>  'Marshall Islands',
        'MD' =>  'Maryland',
        'MA' =>  'Massachusetts',
        'MI' =>  'Michigan',
        'MN' =>  'Minnesota',
        'MS' =>  'Mississippi',
        'MO' =>  'Missouri',
        'MT' =>  'Montana',
        'NE' =>  'Nebraska',
        'NV' =>  'Nevada',
        'NH' =>  'New Hampshire',
        'NJ' =>  'New Jersey',
        'NM' =>  'New Mexico',
        'NY' =>  'New York',
        'NC' =>  'North Carolina',
        'ND' =>  'North Dakota',
        'MP' =>  'Northern Mariana Islands',
        'OH' =>  'Ohio',
        'OK' =>  'Oklahoma',
        'OR' =>  'Oregon',
        'PW' =>  'Palau',
        'PA' =>  'Pennsylvania',
        'PR' =>  'Puerto Rico',
        'RI' =>  'Rhode Island',
        'SC' =>  'South Carolina',
        'SD' =>  'South Dakota',
        'TN' =>  'Tennessee',
        'TX' =>  'Texas',
        'UT' =>  'Utah',
        'VT' =>  'Vermont',
        'VI' =>  'Virgin Islands',
        'VA' =>  'Virginia',
        'WA' =>  'Washington',
        'WV' =>  'West Virginia',
        'WI' =>  'Wisconsin',
        'WY' =>  'Wyoming'
    ];

    return $stateList;
}

function stateSearch ($nameOrCode) {
    $states = stateList();
    $nameOrCode = trim($nameOrCode);

    $code = strtoupper($nameOrCode);
    $name = ucfirst(preg_replace('/ +/', ' ', strtolower($nameOrCode)));

    if (array_key_exists($code, $states)) {
        $name = $states[$code];
    } else if (array_search($name, $states)) {
        $code = array_search($name, $states);
    }

    return ['code' => $code, 'name' => $name];
}

function parseCityStateZip ($location) {
    $location = trim($location);
    $parsed = [
        'city' => '',
        'state' => '',
        'stateCode' => '',
        'zip' => ''
    ];

    $states = stateList();
    $stateCodes = array_keys($states);
    $stateRegex = join('|', $stateCodes) . '|' . str_replace(' ', ' +', join('|', $states));

    /**
     * Possible combinations in the address
     *
     * City can match almost anything, thus we leave those matches at the end, to avoid false positives
     */
    $patterns = [
        "/^(?P<zip>\d+|\d+-\d+)$/",
        "/^(?P<state>$stateRegex)$/i",
        "/^(?P<state>$stateRegex)[, ]+(?P<zip>\d+|\d+-\d+)$/i",
        "/^(?P<city>.+?)[, ]+(?P<state>$stateRegex)[, ]+(?P<zip>\d+|\d+-\d+)$/i",
        "/^(?P<city>.+?)[, ]+(?P<state>$stateRegex)$/i",
        "/^(?P<city>.+?)[, ]+(?P<zip>\d+|\d+-\d+)$/i",
        "/^(?P<city>.+)$/"
    ];

    foreach ($patterns as $pattern) {
        if (!preg_match($pattern, $location, $matches)) {
            continue;
        }

        $state = stateSearch(@$matches['state']);

        $location = [
            'city' => @$matches['city'],
            'state' => $state['name'],
            'stateCode' => $state['code'],
            'zip' => @$matches['zip']
        ];
    }

    return $location;
}

function isOptionSelected ($value) {
    if (is_string($value)) {
        $value = strtolower(trim($value));

        return $value === 'y' || $value === 'yes' || $value === 'true' || $value === '1';
    }

    return $value === 1 || $value === true;
}

/**
 * Remove sensitive fields from the POST data to be saved to the DB:
 *   - passwords
 *   - cc numbers
 *   - cc verification numbers
 *
 * @param array $data
 * @return array
 */
function cleanupPostData (Array $data) {
    foreach ($data as $key=>$dummy) {
        if (preg_match(
            '/
                ^p$|^pw$|pword|
                password|passwd|confirm|
                credit_card|creditcard|
                ccard|creditc|
                ccnum|cc_num|
                _cc_|^cc_|_cc$|
                cvn|ccvn
            /x',
            $key
        )) {
            $data[$key] = '';
        }
    }

    return $data;
}

/**
 * Auxiliary function to retrieve the only value that might be unique and can identify the request
 *
 * @return string
 */
function requestId () {
    return (string)$_SERVER['REQUEST_TIME_FLOAT'];
}

/**
 * Log POST (or any) data into the DB, to diagnose problems with missing data
 */
function logRequestData () {
    $db = new Db();

    if (strtolower($_SERVER['REQUEST_METHOD']) !== 'post') {
        return;
    }

    if (session_id() == '') {
        session_start();
    }

    $postData = cleanupPostData($_POST);

    $logData = $db->escapeAssignmentList([
        'patientid' => intval($_SESSION['patientid']),
        'userid' => intval($_SESSION['userid']),
        'adminid' => intval($_SESSION['adminid']),
        'script' => $_SERVER['SCRIPT_NAME'],
        'referer' => $_SERVER['HTTP_REFERER'],
        'request_time' => $_SERVER['REQUEST_TIME_FLOAT'],
        'get_data' => json_encode($_GET),
        'post_data' => json_encode($postData),
        'files_data' => json_encode($_FILES)
    ]);

    $logId = $db->getInsertId("INSERT INTO dental_request_data_log SET $logData, created_at = NOW()");

    $_SESSION['REQUEST_LOG_ID'] = $logId;
    $_SESSION['REQUEST_ID'] = requestId();
}

/**
 * Set relationship to request data
 *
 * @param string $itemTable
 * @param int    $itemId
 */
function linkRequestData ($itemTable, $itemId) {
    if (
        !isset($_SESSION['REQUEST_ID']) ||
        !isset($_SESSION['REQUEST_LOG_ID']) ||
        requestId() !== $_SESSION['REQUEST_ID'] ||
        !$_SESSION['REQUEST_LOG_ID']
    ) {
        return;
    }

    $db = new Db();

    $typeData = $db->escapeAssignmentList([
        'item_table' => $itemTable,
        'item_id' => $itemId,
        'log_id' => intval($_SESSION['REQUEST_LOG_ID'])
    ]);

    $db->query("INSERT INTO dental_request_data_type SET $typeData, created_at = NOW()");
}

/**
 * @param array        $query
 * @param string|array $overrideKey
 * @param mixed|null   $overrideValue
 */
function buildQuery (Array $query, $overrideKey='', $overrideValue=null) {
    if (!is_array($overrideKey)) {
        $overrideKey = [$overrideKey => $overrideValue];
    }

    foreach ($overrideKey as $key=>$value) {
        if (is_null($value)) {
            unset($query[$key]);
        } else {
            $query[$key] = $value;
        }
    }

    return http_build_query($query);
}
