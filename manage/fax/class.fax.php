<?php

require_once('padCrypt.php');
require_once('AES_Encryption.php');

class FTSSamples
{
	protected $serviceEndpointUrl;
	protected $securityContext;
	protected $securityToken;
	
	public function __construct ()
	{
		$this->serviceEndpointUrl = "https://fws.axacore.com/xws/";
		$this->securityContext = "sFaxProd000043";			//<--- IMPORTANT: Enter a valid securityContext
	}

	public function OutboundFaxCreate($faxNumber, $fileName, $filePath, $fileType)
	{
		// Service Connection and Security Settings
		$methodSignature = "FTS.OutboundFaxCreate";
		$xwsSuccess = false;

		// IMPORTANT: key parameters
		//$faxNumber = "18883635968";						//<--- IMPORTANT: Enter a valid fax number
		//$fileName = "Page1.tif";						//<--- IMPORTANT: Enter a valid file name
		//$filePath = getcwd() . "/Page1.tif";			//<--- IMPORTANT: Enter a valid path to primary file to be faxed
		//$fileType = "tif";								//<--- IMPORTANT: Enter a valid file type
		
		// Set Security Token
		$FTSAES = new FTSAESHelper($this->securityContext);
		$this->securityToken = $FTSAES->GenerateSecurityTokenUrl();

		// Construct the base service URL endpoint
		$url = $this->serviceEndpointUrl; 
		$url .= "?XM=" . urlencode($methodSignature);
		$url .= "&XSC=" . urlencode($this->securityContext);
		$url .= "&XST=". urlencode($this->securityToken);
		
		// Add the method specific parameters
		$url .= "&RecipientFax=" . urlencode($faxNumber);
		$url .= "&FileName=" . urlencode($fileName);
		$url .= "&FileType=" . urlencode($fileType);
		
		echo "URL: " . $url;
		
		//reference primary file to fax
		$postData = array('file'=>"@$filePath");
		
		//initialize cURL and set cURL options
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, true); 
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
		
		$xwsSuccess = ($headers["XwsSuccess"] == "1");
		if($xwsSuccess)
		{
			$deliverId = $headers["XwsReturnData"];
			
			//get additional information from XML payload
			//response data xml payload
			$xResponseData = $helper->GetResponseData($responseBody, $responseInfo);
			if ($xResponseData != null)
			{
				//get transmissionid which is needed for OutboundFaxStatus, OutboundFaxDownload
				$responseTransmissionId = (string)$xResponseData->Delivery->attributes()->TransmissionId;
			}			
		}
		else
		{
			//something went wrong so investigate result and error information
			
			//get result information from response headers
			$xwsResultCode = (int)$headers["XwsResultCode"];
			$xwsResultInfo = $headers["XwsResultInfo"];
			
			echo "ResultCode=" . $xwsResultCode . "ResultInfo=" . $xwsResultInfo;
			
			//get error information from response headers
			$xwsErrorCode = (int)$headers["XwsErrorCode"];
			$xwsErrorInfo = $headers["XwsErrorInfo"];
			
			echo "ErrorCode=" . $xwsErrorCode . "ErrorInfo=" . $xwsErrorInfo;
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
		$body = "<?xml version='1.0'?>" . substr($responseBody, $responseInfo['header_size']);
		$xml = simplexml_load_string($body);
		
		return $xml->ResponseData;		
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
	protected $pTokenAppId;
	protected $pTokenAppKey;
	protected $pTokenClient; 
	protected $pEncryptionKey; 
	protected $pEncryptionInitVector;
	
	public function __construct($pSecurityContext)
	{
		$this->pTokenContext = $pSecurityContext;						
		$this->pTokenAppId = "Dental Sleep Solutions";					//<--- IMPORTANT: Enter a valid App Id 
		$this->pTokenAppKey = "je8y3yvyha5egy5esubase8agubyjape";		//<--- IMPORTANT: Enter a valid Encryption key
		$this->pTokenClient = "";							//<--- IMPORTANT: Enter a valid Client IP
		$this->pEncryptionKey = "je8y3yvyha5egy5esubase8agubyjape";	//<--- IMPORTANT: Enter a valid Encryption key
		$this->pEncryptionInitVector = "sf4xpr3s2c%r#fax";				//<--- IMPORTANT: Enter a valid Init vectory
	}
	
	public function GenerateSecurityTokenUrl()
	{
        $tokenDataInput;
        $tokenDataEncoded;
        $tokenGenDT;
		
		$tokenGenDT = gmdate("Y-m-d") . "T" . gmdate("H:i:s") . "Z";
		
		$tokenDataInput = "Context=" . $this->pTokenContext . "&AppId=" . $this->pTokenAppId . "&AppKey=" . $this->pTokenAppKey . "&GenDT=" . $tokenGenDT . "";
		
		if($this->pTokenClient != null && $this->pTokenClient != "")
		{
			$tokenDataInput .= "&Client=" . $this->pTokenClient;
		}
		
		$AES = new AES_Encryption($this->pEncryptionKey, $this->pEncryptionInitVector, "PKCS7", "cbc");
		$tokenDataEncoded = base64_encode($AES->encrypt($tokenDataInput));
		
		return $tokenDataEncoded;
	}
}
