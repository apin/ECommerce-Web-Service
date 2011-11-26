<?php

require_once('classes/ecommerce.php');

$server = new SoapServer(null, array('uri' => 'http://fake-uri.com/'));
$server->setClass('ECommerce');
$server->handle();

?>
