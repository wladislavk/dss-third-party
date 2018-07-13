<?php

require_once('padCrypt.php');
require_once('AES_Encryption.php');

class FTSSamples
{
    /** @var \Ds3\Libraries\Legacy\Db */
    private $db;

    private $serviceEndpointUrl;
    private $securityContext;
    private $securityToken;
    private $apiKey;

    public function __construct(\Ds3\Libraries\Legacy\Db $db)
    {
        $con = $GLOBALS['con'];
        $this->db = $db;

        $this->serviceEndpointUrl = "https://api.sfaxme.com/api/";
        $this->securityContext = ""; //<--- Required but leave blank exactly as it is here

        $key_sql = "SELECT * FROM companies WHERE id='".$this->db->escape( $_SESSION['companyid'])."'";
        $key_q = mysqli_query($con, $key_sql);
        $keys = mysqli_fetch_assoc($key_q);

        $this->apiKey = $keys['sfax_app_key'];//Required Key
    }


    public function OutboundFaxCreate($faxNumber, $filePath, $faxRecipient = "test")
    {
        $optionalParams="CoverPageName=None;CoverPageSubject=PHPTest;CoverPageReference=PhpTest1234;TrackingCode=PHPTest1234";//Parameters to pass for CoverPages

        // Set Security Token
        $FTSAES = new FTSAESHelper($this->db, $this->securityContext);
        $this->securityToken = $FTSAES->GenerateSecurityTokenUrl();

        // Construct the base service URL endpoint
        $url = $this->serviceEndpointUrl;
        $url .= "sendfax?";
        $url .= "token=". urlencode($this->securityToken);
        $url .= "&ApiKey=" . urlencode($this->apiKey);

        // Add the method specific parameters
        $url .= "&RecipientFax=" . urlencode($faxNumber);
        $url .= "&RecipientName=" . urlencode($faxRecipient);
        $url .= "&OptionalParams=" . urlencode($optionalParams);

        //echo "URL: " . $url;

        //reference primary file to fax
        $postData = ['file' => "@$filePath"];

        //initialize cURL and set cURL options
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        //trust any cert - FOR DEVELOPMENT ONLY
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //execute curl and get response information
        $responseBody = curl_exec($ch);
        $responseInfo = curl_getinfo($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = json_decode(substr($responseBody, $header_size), true);
        curl_close ($ch);

        //get headers and response data
        $helper = new FTSHelper();
        $headers = $helper->GetHeaders($responseBody, $responseInfo);
        $helper->GetResponseData($responseBody, $responseInfo);
        if ($body['isSuccess']) {
            //get additional information from XML payload
            //response data xml payload
            $helper->GetResponseData($responseBody, $responseInfo);

            //get additional information from XML payload
            //response data xml payload
            $helper->GetResponseData($responseBody, $responseInfo);

            $return["status"] = true;
            $return["transmission_id"] = $body['SendFaxQueueId'];
            return $return;
        } else {
            error_log(__CLASS__ . " - Post data: " . print_r($postData, true));
            error_log(__CLASS__ . " - Raw response: " . $responseBody);
            return $headers;
        }
    }

    public function OutboundFaxStatus($sendfaxQueueId)
    {
        // key parameters

        // Set Security Token
        $FTSAES = new FTSAESHelper($this->db, $this->securityContext);
        $this->securityToken = $FTSAES->GenerateSecurityTokenUrl();

        // Construct the base service URL endpoint
        $url = $this->serviceEndpointUrl;
        $url .= "sendfaxstatus?";
        $url .= "token=". urlencode($this->securityToken);
        $url .= "&ApiKey=" . urlencode($this->apiKey);

        // Add the method specific parameters
        $url .= "&SendFaxQueueId=" . urlencode($sendfaxQueueId);

        //initialize cURL and set cURL options
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //specific cURL options for HTTPS sites
        //see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //execute curl and get response information

        $responseBody = curl_exec($ch);
        $responseInfo = curl_getinfo($ch);
        curl_close ($ch);
        //get headers and response data
        $helper = new FTSHelper();
        $headers = $helper->GetHeaders($responseBody, $responseInfo);

        if ($responseInfo["http_code"] == 200) {
            //get additional information from XML payload
            //response data xml payload
            $xResponseData = $helper->ReturnResponseData($responseBody, $responseInfo);
            if ($xResponseData != null) {
                return $xResponseData;
            }
        } else {
            //something went wrong so investigate result and error information

            //get result information from response headers
            $xwsResultCode = $responseInfo["http_code"];

            echo "ResultCode=" . $xwsResultCode ;

            //get error information from response headers
            $xwsErrorCode = $responseInfo["http_code"];

            echo "ErrorCode=" . $xwsErrorCode ;
        }
        return $headers;
    }
}

class FTSHelper
{
    public function GetHeaders($responseBody, $responseInfo)
    {
        $header_text = substr($responseBody, 0, $responseInfo['header_size']);
        $headers = [];
        foreach(explode("\n",$header_text) as $line) {
            $parts = explode(": ",$line);
            if(count($parts) == 2) {
                if (isset($headers[$parts[0]])) {
                    if (is_array($headers[$parts[0]])) {
                        $headers[$parts[0]][] = chop($parts[1]);
                    } else {
                        $headers[$parts[0]] = [$headers[$parts[0]], chop($parts[1])];
                    }
                } else {
                    $headers[$parts[0]] = chop($parts[1]);
                }
            }
        }
        return $headers;
    }

    public function GetResponseData($responseBody, $responseInfo)
    {
        $body = "" . substr($responseBody, $responseInfo['header_size']);
        echo "SendFaxResponse: " . $body;
    }

    public function ReturnResponseData($responseBody, $responseInfo)
    {
        $body = "" . substr($responseBody, $responseInfo['header_size']);
        return $body;
    }
}

class FTSAESHelper
{
    private $pTokenContext;
    private $pTokenUsername;
    private $pTokenApiKey;
    private $pTokenClient;
    private $pEncryptionKey;
    private $pEncryptionInitVector;

    public function __construct(\Ds3\Libraries\Legacy\Db $db, $pSecurityContext)
    {
        $con = $GLOBALS['con'];

        $key_sql = "SELECT * FROM companies WHERE id='".$db->escape( $_SESSION['companyid'])."'";
        $key_q = mysqli_query($con, $key_sql);
        $keys = mysqli_fetch_assoc($key_q);
        $this->pTokenContext = $pSecurityContext;
        $this->pTokenUsername = $keys['sfax_app_id'];  //<--- IMPORTANT: Enter a valid Username
        $this->pTokenApiKey = $keys['sfax_app_key'];  //<--- IMPORTANT: Enter a valid ApiKey
        $this->pTokenClient = "";   //<--- IMPORTANT: Leave Blank
        $this->pEncryptionKey = $keys['sfax_encryption_key'];  //<--- IMPORTANT: Enter a valid Encryption key
        $this->pEncryptionInitVector = $keys['sfax_init_vector'];//"x49e*wJVXr8BrALE";  //<--- IMPORTANT: Enter a valid Init vector
    }

    public function GenerateSecurityTokenUrl()
    {
        $tokenGenDT = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . "Z";

        $tokenDataInput = "Context=" . $this->pTokenContext . "&Username=" . $this->pTokenUsername. "&ApiKey=" . $this->pTokenApiKey . "&GenDT=" . $tokenGenDT . "";

        if ($this->pTokenClient != null && $this->pTokenClient != "") {
            $tokenDataInput .= "&Client=" . $this->pTokenClient;
        }

        try {
            $AES = new AES_Encryption($this->pEncryptionKey, $this->pEncryptionInitVector, "PKCS7", "cbc");
            $tokenDataEncoded = base64_encode($AES->encrypt($tokenDataInput));
        } catch (Exception $e) {
            error_log(__CLASS__ . ': Wrong initialization values for AES Encryption');
            $tokenDataEncoded = null;
        }

        return $tokenDataEncoded;
    }
}
