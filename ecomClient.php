<?php
	try
	{
		$soap_url = 'http://ecom:8880';
		$soap_uri = 'http://fake-uri.com/';
		$soap_method = 'webWithdraw';
		$soap_method_params = array(new SoapParam('apin', 'username'), new SoapParam('444', 'password'), new SoapParam(500, 'amt'));

		$soapClient = new SoapClient(null, array('location' => $soap_url, 'uri' => $soap_uri, 'trace' => 1));


		/********** ONLY FOR WSDL *************
		//List all functions at WSDL service
		print_r($soapClient->__getFunctions());
		**************************************/

		print_r($soapClient->__soapCall($soap_method, $soap_method_params) . "\n");

	} catch (SoapFault $exception)
	{
		echo "SoapFault exception: " . $exception->faultstring . /*"\n" . $exception->detail .*/ "\n";
		
		print_r("Last Request: " . $soapClient->__getLastRequest() . "\n");	
		print_r("Last Response: " . $soapClient->__getLastResponse() . "\n");
	}
?>
