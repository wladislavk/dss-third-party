<?php

require_once('padCrypt.php');
require_once('AES_Encryption.php');

class FTSSamples
{
	protected $serviceEndpointUrl;
	protected $securityContext;
	protected $securityToken;
	protected $apiKey;
	
	public function __construct ()
	{
		$this->serviceEndpointUrl = "https://api.sfaxme.com/api/";
		$this->securityContext = ""; //<--- Required but leave blank exactly as it is here
                $key_sql = "SELECT * FROM companies WHERE id='".mysql_real_escape_string($_SESSION['companyid'])."'";
                $key_q = mysql_query($key_sql);
                $keys = mysql_fetch_assoc($key_q);
	
		$this->apiKey = "";//$keys['api_key'];//Required Key	
	}
  /* 	
	public function __construct ()
	{
		$this->serviceEndpointUrl = "https://fws.axacore.com/xws/";
		$key_sql = "SELECT * FROM companies WHERE id='".mysql_real_escape_string($_SESSION['companyid'])."'";
		$key_q = mysql_query($key_sql);
		$keys = mysql_fetch_assoc($key_q);
		$this->securityContext = $keys['sfax_security_context'];			//<--- IMPORTANT: Enter a valid securityContext
	}
  */
	public function OutboundFdaxCreate($faxNumber, $fileName, $filePath, $fileType)
{
		// Service Connection and Security Settings
		$isSuccess = false;

		// IMPORTANT: key parameters
		//$faxNumber = "15123668506";	//<--- IMPORTANT: Enter a valid fax number
		//$filePath = getcwd() . "/Page1.tif";   //<--- IMPORTANT: Enter a valid path to primary file to be faxed
		//$faxRecipient = "GeneTest";							
	$optionalParams="CoverPageName=None;CoverPageSubject=PHPTest;CoverPageReference=PhpTest1234;TrackingCode=PHPTest1234";//Parameters to pass for CoverPages
		
		// Set Security Token
		$FTSAES = new FTSAESHelper($this->securityContext);
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
		$postData = array('file'=>"@$filePath");
		
		//initialize cURL and set cURL options
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, true); 
		//curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_NOBODY, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		
		//specific cURL options for HTTPS sites
		//see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/EquifaxSecureGlobalBusinessCA-1.crt");
		
		//trust any cert - FOR DEVELOPMENT ONLY
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//execute curl and get response information
		$responseBody = curl_exec($ch);
		$responseInfo = curl_getinfo($ch);
		
		$error = curl_error($ch);
		
		curl_close ($ch);
				
		//get headers and response data
		$helper = new FTSHelper();
		$headers = $helper->GetHeaders($responseBody, $responseInfo);
		
		if ($responseInfo["http_code"] == 200)

		{			
			//get additional information from XML payload
			//response data xml payload
			$xResponseData = $helper->GetResponseData($responseBody, $responseInfo);
			if ($xResponseData != null)
			{
				
			}			
		}
		else
		{
			//something went wrong so investigate result and error information
			
			//get result information from response headers
			$xwsResultCode = $responseInfo["http_code"];
			
			echo "ResultCode=" . $xwsResultCode ;
			
			//get error information from response headers
			$xwsErrorCode = $responseInfo["http_code"];
			
			echo "ErrorCode=" . $xwsErrorCode ;
		}
	}

	public function OutboundFaxSatus($transmissionId) 
	{ 
		// key parameters
		$sendfaxQueueId = ""; //<--- IMPORTANT: Enter a valid transmissionId
		
		// Set Security Token
		$FTSAES = new FTSAESHelper($this->securityContext);
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
		//curl_setopt($ch, CURLOPT_POST, true);
		//curl_setopt($ch, CURLOPT_GETHTTP, true);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "");
		
		//specific cURL options for HTTPS sites
		//see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		//curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/EquifaxSecureGlobaleBusinessCA-1.crt");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//execute curl and get response information
		
		//echo "URL: " . $url;
		
		$responseBody = curl_exec($ch);
		$responseInfo = curl_getinfo($ch);
		$error = curl_error($ch);
		curl_close ($ch);
		
		//get headers and response data
		$helper = new FTSHelper();
		$headers = $helper->GetHeaders($responseBody, $responseInfo);
		
		if ($responseInfo["http_code"] == 200)

		{			
			//get additional information from XML payload
			//response data xml payload
			$xResponseData = $helper->GetResponseData($responseBody, $responseInfo);
			if ($xResponseData != null)
			{
				
			}			
		}
		else
		{
			//something went wrong so investigate result and error information
			
			//get result information from response headers
			$xwsResultCode = $responseInfo["http_code"];
			
			echo "ResultCode=" . $xwsResultCode ;
			
			//get error information from response headers
			$xwsErrorCode = $responseInfo["http_code"];
			
			echo "ErrorCode=" . $xwsErrorCode ;
		}
	}




}

class FTSHelper
{
	public static function GetHeaders($responseBody, $responseInfo)
	{
		$header_text = substr($responseBody, 0, $responseInfo['header_size']);
		
		$headers = array();
		foreach(explode("\n",$header_text) as $line) 
		{
			$parts = explode(": ",$line);
			if(count($parts) == 2) 
			{
				if (isset($headers[$parts[0]])) 
				{
					if (is_array($headers[$parts[0]])) $headers[$parts[0]][] = chop($parts[1]);
					else $headers[$parts[0]] = array($headers[$parts[0]], chop($parts[1]));
				} else 
				{
					$headers[$parts[0]] = chop($parts[1]);
				}
			}
		}
		return $headers;	
	}	
	public static function GetResponseData($responseBody, $responseInfo)
	{
        	$body = "" . substr($responseBody, $responseInfo['header_size']);
        	echo "SendFaxResponse: " . $body;
	}
	public static function WriteResponseToFile($responseBody, $responseInfo, $localFileName)
	{
		$data = substr($responseBody, $responseInfo['header_size']);
		$fp = fopen($localFileName, "w");
		fwrite($fp, $data, strlen($data));
		fclose($fp);
	}
}

class FTSAESHelper
{
	protected $pTokenContext; 
	protected $pTokenUsername;
	protected $pTokenApiKey;
	protected $pTokenClient; 
	protected $pEncryptionKey; 
	protected $pEncryptionInitVector;
	
	public function __construct($pSecurityContext)
	{
                $key_sql = "SELECT * FROM companies WHERE id='".mysql_real_escape_string($_SESSION['companyid'])."'";
                $key_q = mysql_query($key_sql);
                $keys = mysql_fetch_assoc($key_q);

                $this->pTokenContext = $pSecurityContext;
                $this->pTokenUsername = $keys['app_id'];                                   //<--- IMPORTANT: Enter a valid App Id 
                $this->pTokenAppKey = $keys['app_key'];         //<--- IMPORTANT: Enter a valid Encryption key
                $this->pTokenClient = "";                                                       //<--- IMPORTANT: Enter a valid Client IP
                $this->pEncryptionKey = $keys['app_key'];       //<--- IMPORTANT: Enter a valid Encryption key
                $this->pEncryptionInitVector = $keys['init_vector'];
		/*
	$this->pTokenContext=$pSecurityContext;                        
        $this->pTokenUsername="";  //<--- IMPORTANT: Enter a valid Username
        $this->pTokenApiKey=  "";  //<--- IMPORTANT: Enter a valid ApiKey
        $this->pTokenClient="";   //<--- IMPORTANT: Leave Blank
        $this->pEncryptionKey="";  //<--- IMPORTANT: Enter a valid Encryption key
        $this->pEncryptionInitVector="x49e*wJVXr8BrALE";  //<--- IMPORTANT: Enter a valid Init vector
		*/
	}
	
	public function GenerateSecurityTokenUrl()
	{
        $tokenDataInput;
        $tokenDataEncoded;
        $tokenGenDT;
		
		$tokenGenDT = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . "Z";
		
		$tokenDataInput = "Context=" . $this->pTokenContext . "&Username=" . $this->pTokenUsername. "&ApiKey=" . $this->pTokenApiKey . "&GenDT=" . $tokenGenDT . "";
		
		if($this->pTokenClient != null && $this->pTokenClient != "")
		{
			$tokenDataInput .= "&Client=" . $this->pTokenClient;
		}
		
		$AES = new AES_Encryption($this->pEncryptionKey, $this->pEncryptionInitVector, "PKCS7", "cbc");
		$tokenDataEncoded = base64_encode($AES->encrypt($tokenDataInput));
		
		return $tokenDataEncoded;
	}
}

